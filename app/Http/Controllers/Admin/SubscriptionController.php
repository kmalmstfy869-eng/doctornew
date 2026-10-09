<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Doctor;
use App\Models\FinanceEntry;
use App\Models\Plan;
use App\Models\Subscription;
use App\Support\Money;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
class SubscriptionController extends Controller
{
    private const SOON_DAYS = 7;

    /**
     * مستويات الباقات الثابتة (من الأقل للأعلى). الترتيب هنا هو المرجع الوحيد للترقية،
     * ولا يعتمد على السعر إطلاقًا.
     * clinic (Clinic System) > professional > prime > free
     */
    private const TIERS = [
        'clinic'       => 3,
        'professional' => 2,
        'prime'        => 1,
        'free'         => 0,
    ];

    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $state  = in_array($request->input('state'), ['active', 'soon', 'expired'], true)
            ? $request->input('state') : 'all';

        $subs = Subscription::query()
            ->paidPlans()
            ->with(['doctor.user', 'doctor.specialty', 'plan'])
            ->when($state === 'active', fn ($q) => $q->running())
            ->when($state === 'soon', fn ($q) => $q->expiringIn(self::SOON_DAYS))
            ->when($state === 'expired', fn ($q) => $q->ended())
            ->when($search !== '', fn ($q) => $q->whereHas(
                'doctor.user',
                fn ($u) => $u->where('name', 'like', '%' . addcslashes($search, '%_\\') . '%')
            ))
            ->orderByRaw("CASE WHEN status = 'active' AND end_date >= CURDATE() THEN 0 ELSE 1 END")
            ->orderBy('end_date')
            ->paginate(10)
            ->withQueryString();

        // بيانات المودالات تُحسب على السيرفر من بيانات الاشتراك الفعلية
        $subs->getCollection()->each(function (Subscription $s) {
            $s->setAttribute('upgrade_modal', $this->modalData($s));
        });

        $counts = [
            'all'     => Subscription::paidPlans()->count(),
            'active'  => Subscription::paidPlans()->running()->count(),
            'soon'    => Subscription::paidPlans()->expiringIn(self::SOON_DAYS)->count(),
            'expired' => Subscription::paidPlans()->ended()->count(),
        ];

        $monthIncome = (float) FinanceEntry::where('type', 'income')
            ->where('category', 'subscription')
            ->whereBetween('entry_date', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
            ->sum('amount');

        $plans = Plan::where('slug', '!=', 'free')->orderBy('sort_order')->get()
            ->map(fn ($p) => [
                'id' => $p->id, 'name' => $p->name,
                'price' => (float) $p->price, 'duration' => (int) $p->duration,
                'tier' => $this->tier($p),
            ])->values();

        return view('admin.subscriptions.index', compact(
            'subs', 'counts', 'monthIncome', 'plans', 'search', 'state'
        ) + ['soonDays' => self::SOON_DAYS]);
    }

    /** بحث لايف: الأطباء اللي مالهمش اشتراك مدفوع ساري */
    public function searchDoctors(Request $request)
    {
        $q    = trim((string) $request->input('q', ''));
        $like = '%' . addcslashes($q, '%_\\') . '%';

        $doctors = Doctor::query()
            ->active() // status = approved
            ->with(['user:id,name', 'specialty:id,name'])
            ->whereDoesntHave('subscription', fn ($s) => $s->paidPlans()->running())
            ->when($q !== '', fn ($d) => $d->where(
                fn ($w) => $w->whereHas('user', fn ($u) => $u->where('name', 'like', $like))
                    ->orWhere('phone', 'like', $like)
            ))
            ->limit(8)
            ->get()
            ->map(fn ($d) => [
                'id'        => $d->id,
                'name'      => $d->user?->name,
                'specialty' => $d->specialty?->name,
                'phone'     => $d->phone,
            ]);

        return response()->json($doctors);
    }

    /** إضافة اشتراك لطبيب */
    public function store(Request $request)
    {
        $data = $request->validateWithBag('subAdd', [
            'doctor_id'  => ['required', 'exists:doctors,id'],
            'plan_id'    => ['required', $this->paidPlanRule()],
            'start_date' => ['required', 'date', 'before_or_equal:today'],
            'amount'     => ['required', 'numeric', 'min:0','max:1000000'],
            'note'       => ['nullable', 'string', 'max:500'],
        ], $this->messages(), $this->attributes());

        DB::transaction(function () use ($data) {
            $doctor   = Doctor::with('user')->lockForUpdate()->findOrFail($data['doctor_id']);
            $existing = Subscription::with('plan')->where('doctor_id', $doctor->id)->lockForUpdate()->first();

            if ($existing && $existing->plan?->slug !== 'free' && $existing->is_running) {
                $this->fail('subAdd', 'doctor_id', 'الطبيب ده عنده اشتراك ساري بالفعل، استخدم الترقية أو التجديد.');
            }

            $plan = Plan::findOrFail($data['plan_id']);
            $sub  = $this->activate($doctor, $plan, Carbon::parse($data['start_date']), (float) $data['amount']);

            $this->income("اشتراك د. {$doctor->user->name} - باقة {$plan->name}", (float) $data['amount'], $data['note'] ?? null);


        });

        return back()->with('success', 'تم إضافة الاشتراك وتسجيله في المالية.');
    }


    public function change(Request $request, Subscription $subscription)
    {
        $data = $request->validateWithBag('subChange', [
            'plan_id'   => ['required', $this->paidPlanRule()],
            'sub_token' => ['required', 'string', 'max:128'],
            'note'      => ['nullable', 'string', 'max:500'],
        ], $this->messages(), $this->attributes());

        DB::transaction(function () use ($subscription, $data) {
            $sub = Subscription::with(['doctor.user', 'plan'])->lockForUpdate()->findOrFail($subscription->id);

            if (! $sub->is_running) {
                $this->fail('subChange', 'plan_id', 'الاشتراك منتهي، استخدم زر التجديد.');
            }
            if (! hash_equals($this->token($sub), (string) $data['sub_token'])) {
                $this->fail('subChange', 'plan_id', 'بيانات الاشتراك اتغيرت أو العملية اتنفذت قبل كده، حدّث الصفحة وجرّب تاني.');
            }
            if ((int) $sub->plan_id === (int) $data['plan_id']) {
                $this->fail('subChange', 'plan_id', 'اختار باقة مختلفة عن الحالية.');
            }

            $old = $sub->plan;
            $new = Plan::findOrFail($data['plan_id']);

            // التحقق من مستوى الباقة (من قاعدة البيانات) قبل أي تعديل أو تحصيل
            $oldTier = $this->tier($old);
            $newTier = $this->tier($new);

            if ($oldTier < 0 || $newTier <= $oldTier) {
                $this->fail('subChange', 'plan_id', 'الترقية متاحة لباقة بمستوى أعلى فقط، ومينفعش الترقية لنفس المستوى أو لمستوى أقل.');
            }

            $q = $this->quote($sub, $new);

            $sub->update([
                'plan_id'    => $new->id,
                'start_date' => today(),
                'end_date'   => today()->addDays((int) $new->duration + $q['bonus_days']),
                'price'      => $q['due'], // اللي دفعه فعليًا في الاشتراك الجديد، وسعر الباقة الأصلي من جدول الباقات
                'status'     => 'active',
            ]);

            // المالية: المبلغ المحصّل فعليًا فقط، والتفاصيل في الملاحظة
            $details = 'سعر الباقة الجديدة: ' . Money::fmt($q['new_price'])
                . ' ج.م | رصيد مخصوم من الاشتراك السابق: ' . Money::fmt($q['credit_used'])
                . ' ج.م | محصّل: ' . Money::fmt($q['due']) . ' ج.م';
            if (! empty($data['note'])) {
                $details .= ' | ' . $data['note'];
            }

            $this->income(
                "ترقية اشتراك د. {$sub->doctor->user->name}: {$old->name} ← {$new->name}",
                $q['due'],
                mb_substr($details, 0, 500)
            );


        });

        return back()->with('success', 'تمت الترقية وتسجيل المبلغ المحصّل في المالية.');
    }

    private function paidPlanRule()
    {
        return Rule::exists('plans', 'id')->where(fn ($q) => $q->where('slug', '!=', 'free'));
    }


    private function tier(?Plan $plan): int
    {
        if (! $plan) {
            return -1;
        }

        $hay = Str::lower((string) ($plan->slug ?? '') . ' ' . (string) ($plan->name ?? ''));

        foreach (self::TIERS as $key => $level) {
            if (str_contains($hay, $key)) {
                return $level;
            }
        }

        return -1;
    }

    private function activate(Doctor $doctor, Plan $plan, Carbon $start, float $amount): Subscription
    {
        return Subscription::updateOrCreate(
            ['doctor_id' => $doctor->id],
            [
                'plan_id'    => $plan->id,
                'start_date' => $start,
                'end_date'   => $start->copy()->addDays((int) $plan->duration),
                'price'      => $amount,
                'status'     => 'active',
            ]
        );
    }

    private function income(string $title, float $amount, ?string $note): void
    {
        if ($amount <= 0) {
            return;
        }

        FinanceEntry::create([
            'type'       => 'income',
            'category'   => 'subscription',
            'title'      => $title,
            'amount'     => $amount,
            'entry_date' => now('Africa/Cairo')->toDateString(),
            'note'       => $note,
            'created_by' => Auth::id(),
        ]);
    }

    private function fail(string $bag, string $field, string $msg): never
    {
        throw ValidationException::withMessages([$field => $msg])->errorBag($bag);
    }

    private function days(Carbon $from, Carbon $to): int
    {
        return (int) round($from->copy()->startOfDay()->diffInDays($to->copy()->startOfDay(), false));
    }

    /** توكن يمنع إعادة الإرسال أو التنفيذ على بيانات قديمة */
    private function token(Subscription $sub): string
    {
        return $sub->plan_id . '|' . $sub->start_date->toDateString() . '|' . $sub->end_date->toDateString()
            . '|' . number_format((float) $sub->price, 2, '.', '');
    }

    /** المدة الأصلية للاشتراك الحالي والأيام المتبقية والرصيد المتبقي (بالتناسب) */
    private function credit(Subscription $sub): array
    {
        $total  = max(1, $this->days($sub->start_date, $sub->end_date));
        $left   = min($total, max(0, $this->days(today(), $sub->end_date)));
        $paid   = round((float) $sub->price, 2);
        $credit = round($paid * $left / $total, 2);

        return compact('total', 'left', 'paid', 'credit');
    }

    /** عرض سعر الترقية لباقة معيّنة (المرجع الوحيد للحساب النهائي) */
    private function quote(Subscription $sub, Plan $new): array
    {
        $c        = $this->credit($sub);
        $newPrice = round((float) $new->price, 2);
        $used     = min($c['credit'], $newPrice);
        $due      = round(max($newPrice - $used, 0), 2);
        $leftover = round($c['credit'] - $used, 2);
        $perDay   = (int) $new->duration > 0 ? $newPrice / (int) $new->duration : 0;
        $bonus    = ($leftover > 0 && $perDay > 0) ? (int) floor($leftover / $perDay) : 0;

        return $c + [
            'new_price'   => $newPrice,
            'credit_used' => $used,
            'due'         => $due,
            'leftover'    => $leftover,
            'bonus_days'  => $bonus,
        ];
    }

    /** بيانات المودالات (روابط المسارات من الموديل، والأرقام من الحساب الفعلي) */
    private function modalData(Subscription $s): array
    {
        $c = $this->credit($s);

        return array_merge($s->modalPayload(), [
            'id'         => $s->id,
            'doctor'     => $s->doctor?->user?->name ?? '—',
            'plan_id'    => (int) $s->plan_id,
            'plan_name'  => $s->plan?->name,
            'plan_price' => (float) $s->plan?->price,
            'plan_tier'  => $this->tier($s->plan),
            'paid'       => $c['paid'],
            'credit'     => $c['credit'],
            'left'       => $c['left'],
            'days_left'  => $c['left'],
            'total_days' => $c['total'],
            'running'    => (bool) $s->is_running,
            'end'        => $s->end_date?->toDateString(),
            'token'      => $this->token($s),
        ]);
    }


    /** تجديد */
    public function renew(Request $request, Subscription $subscription)
    {
        $data = $request->validateWithBag('subRenew', [
            'plan_id'    => ['required', $this->paidPlanRule()],
            'start_date' => ['nullable', 'date', 'before_or_equal:today'],
            'amount'     => ['required', 'numeric', 'min:0'],
            'note'       => ['nullable', 'string', 'max:500'],
        ], $this->messages(), $this->attributes());

        DB::transaction(function () use ($subscription, $data) {
            $sub    = Subscription::with(['doctor.user', 'plan'])->lockForUpdate()->findOrFail($subscription->id);
            $amount = (float) $data['amount'];

            if ($sub->is_running) {
                $plan = $sub->plan;
                $sub->update([
                    'start_date' => today(),
                    'end_date'   => $sub->end_date->copy()->addDays((int) $plan->duration),
                    'price'      => $amount,
                ]);
            } else {
                $plan = Plan::findOrFail($data['plan_id']);
                $this->activate($sub->doctor, $plan, Carbon::parse($data['start_date'] ?? today()), $amount);
            }

            $this->income("تجديد اشتراك د. {$sub->doctor->user->name} - باقة {$plan->name}", $amount, $data['note'] ?? null);


        });

        return back()->with('success', 'تم تجديد الاشتراك وتسجيله في المالية.');
    }

    /* ----------------------------- helpers ----------------------------- */

    /** رسائل الأخطاء بالعربي لكل قواعد التحقق في الاشتراكات (إضافة / ترقية / تجديد) */
    private function messages(): array
    {
        return [
            // الطبيب
            'doctor_id.required' => 'لازم تختار الطبيب الأول.',
            'doctor_id.exists'   => 'الطبيب اللي اخترته مش موجود، ابحث واختار طبيب تاني.',

            // الباقة
            'plan_id.required' => 'لازم تختار الباقة.',
            'plan_id.exists'   => 'الباقة اللي اخترتها مش صالحة أو مش مدفوعة، اختار باقة من القائمة.',

            // تاريخ البداية
            'start_date.required'         => 'لازم تحدد تاريخ بداية الاشتراك.',
            'start_date.date'             => 'تاريخ البداية مش مكتوب بصيغة تاريخ صحيحة.',
            'start_date.before_or_equal'  => 'تاريخ البداية لازم يكون النهارده أو قبل كده، مينفعش تاريخ في المستقبل.',

            // المبلغ
            'amount.required' => 'لازم تكتب المبلغ المدفوع.',
            'amount.numeric'  => 'المبلغ المدفوع لازم يكون رقم صحيح.',
            'amount.min'      => 'المبلغ المدفوع مينفعش يكون أقل من صفر.',
            'amount.max'      => 'المبلغ المدفوع كبير للغاية.',

            // الملاحظة
            'note.string' => 'الملاحظة لازم تكون نص.',
            'note.max'    => 'الملاحظة طويلة جدًا، الحد الأقصى :max حرف.',

            // توكن الترقية
            'sub_token.required' => 'بيانات الاشتراك ناقصة، حدّث الصفحة وجرّب تاني.',
            'sub_token.string'   => 'بيانات الاشتراك غير صالحة، حدّث الصفحة وجرّب تاني.',
            'sub_token.max'      => 'بيانات الاشتراك غير صالحة، حدّث الصفحة وجرّب تاني.',
        ];
    }

    private function attributes(): array
    {
        return [
            'doctor_id'  => 'الطبيب',
            'plan_id'    => 'الباقة',
            'start_date' => 'تاريخ البداية',
            'amount'     => 'المبلغ المدفوع',
            'note'       => 'الملاحظة',
            'sub_token'  => 'بيانات الاشتراك',
        ];
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAuditLog;
use App\Models\Doctor;
use App\Models\FinanceEntry;
use App\Models\PatientFile;
use App\Models\StorageSubscription;
use App\Services\ExtraStorageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ExtraStorageController extends Controller
{
    private const SOON_DAYS = 7;
    private const GB = 1073741824;

    public function __construct(private ExtraStorageService $svc) {}

    public function index(Request $request)
    {
        $this->svc->expireDue();

        $search = trim((string) $request->input('search', ''));
        $state = in_array($request->input('state'), ['active', 'soon', 'expired'], true) ? $request->input('state') : 'all';

        $subs = StorageSubscription::query()
            ->select('storage_subscriptions.*')
            ->selectSub($this->usedBytes('storage_subscriptions.doctor_id'), 'used_bytes')
            ->with(['doctor.user', 'doctor.specialty'])
            ->when($state === 'active', fn ($q) => $q->running())
            ->when($state === 'soon', fn ($q) => $q->expiringIn(self::SOON_DAYS))
            ->when($state === 'expired', fn ($q) => $q->ended())
            ->when($search !== '', fn ($q) => $q->whereHas(
                'doctor.user',
                fn ($u) => $u->where('name', 'like', '%' . addcslashes($search, '%_\\') . '%')
            ))
            ->orderByRaw("CASE WHEN status = 'active' AND end_date > CURDATE() THEN 0 ELSE 1 END")
            ->orderBy('end_date')
            ->paginate(10)
            ->withQueryString();

        $counts = [
            'all' => StorageSubscription::count(),
            'active' => StorageSubscription::running()->count(),
            'soon' => StorageSubscription::expiringIn(self::SOON_DAYS)->count(),
            'expired' => StorageSubscription::ended()->count(),
        ];

        $planStats = StorageSubscription::running()
            ->selectRaw('period, COUNT(*) as subs, SUM(gb) as gb')
            ->groupBy('period')->get()->keyBy('period');

        $extraGb = (float) StorageSubscription::running()->sum('gb');

        $monthIncome = (float) FinanceEntry::where('type', 'income')->where('category', 'extra_storage')
            ->whereBetween('entry_date', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
            ->sum('amount');

        return view('admin.storage.extra', [
            'subs' => $subs, 'counts' => $counts, 'planStats' => $planStats,
            'extraGb' => $extraGb, 'monthIncome' => $monthIncome,
            'search' => $search, 'state' => $state, 'soonDays' => self::SOON_DAYS,
            'cfg' => $this->svc->settings(),
        ]);
    }

    /** بحث لايف: الأطباء المعتمدين اللي مالهمش اشتراك مساحة ساري */
    public function searchDoctors(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $like = '%' . addcslashes($q, '%_\\') . '%';

        $rows = Doctor::query()->doctors()->active()
            ->join('users', 'users.id', '=', 'doctors.user_id')
            ->whereDoesntHave('storageSubscription', fn ($s) => $s->running())
            ->when($q !== '', fn ($d) => $d->where(fn ($w) => $w->where('users.name', 'like', $like)->orWhere('doctors.phone', 'like', $like)))
            ->select(['doctors.id', 'doctors.phone', 'doctors.patient_files_quota_gb', 'users.name as doctor_name'])
            ->selectSub($this->usedBytes('doctors.id'), 'used_bytes')
            ->orderBy('users.name')
            ->limit(8)
            ->get()
            ->map(fn ($d) => [
                'id' => $d->id,
                'name' => $d->doctor_name,
                'phone' => $d->phone,
                'used_gb' => round($d->used_bytes / self::GB, 2),
                'quota_gb' => (float) ($d->patient_files_quota_gb ?? $this->svc->base()),
            ]);

        return response()->json($rows);
    }

    /* ------------------------------ إضافة ------------------------------ */

    public function store(Request $request)
    {
        $data = $request->validateWithBag('extAdd', [
            'doctor_id' => ['required', 'integer'],
            'period' => ['required', Rule::in(array_keys(StorageSubscription::plans()))],
            'units' => ['required', 'integer', 'min:1', 'max:' . $this->svc->maxUnits()],
            'start_date' => ['required', 'date', 'before_or_equal:today'],
            'amount' => ['required', 'numeric', 'min:0', 'max:10000000'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $msg = DB::transaction(function () use ($data) {
            $doctor = Doctor::query()->doctors()->active()->with('user')->lockForUpdate()->find($data['doctor_id']);
            if (! $doctor) {
                $this->fail('extAdd', 'doctor_id', 'اختار طبيب معتمد.');
            }

            $existing = StorageSubscription::where('doctor_id', $doctor->id)->lockForUpdate()->first();
            if ($existing?->is_running) {
                $this->fail('extAdd', 'doctor_id', 'الطبيب ده عنده اشتراك مساحة ساري، استخدم التعديل أو التجديد.');
            }

            $start = Carbon::parse($data['start_date'])->startOfDay();
            $end = $start->copy()->addDays(StorageSubscription::periodDays($data['period']));
            if ($end->lte(today())) {
                $this->fail('extAdd', 'start_date', 'تاريخ البداية قديم والاشتراك هيبقى منتهي بالفعل.');
            }

            $units = (int) $data['units'];
            $gb = $units * StorageSubscription::unitGb();

            $sub = StorageSubscription::updateOrCreate(['doctor_id' => $doctor->id], [
                'period' => $data['period'], 'units' => $units, 'gb' => $gb,
                'start_date' => $start, 'end_date' => $end, 'status' => 'active',
                'locked_price' => $data['amount'],
            ]);

            $this->income("اشتراك مساحة +{$gb} GB ({$sub->period_label}) - د. {$doctor->user->name}", (float) $data['amount'], $data['note'] ?? null);
            AdminAuditLog::record('extra_storage.create', "extra#{$sub->id}", ['doctor_id' => $doctor->id, 'gb' => $gb, 'amount' => (float) $data['amount']]);

            $this->svc->sync($doctor->id);

            return 'تم تفعيل اشتراك المساحة وتسجيله في المالية.';
        });

        return back()->with('success', $msg);
    }

    /* ------------------------------ تعديل (باقة/وحدات) ------------------------------ */

    public function change(Request $request, StorageSubscription $extra)
    {
        $data = $request->validateWithBag('extChange', [
            'period' => ['required', Rule::in(array_keys(StorageSubscription::plans()))],
            'units' => ['required', 'integer', 'min:1', 'max:' . $this->svc->maxUnits()],
            'new_price' => ['required', 'numeric', 'min:0', 'max:10000000'],
            'collected' => ['required', 'numeric', 'min:0', 'max:10000000'],
            'sub_token' => ['required', 'string'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $msg = DB::transaction(function () use ($extra, $data) {
            $sub = StorageSubscription::with('doctor.user')->lockForUpdate()->findOrFail($extra->id);
            $this->guard($sub, 'extChange', $data['sub_token']);

            if (! $sub->is_running) {
                $this->fail('extChange', 'period', 'الاشتراك منتهي، استخدم التجديد.');
            }
            if ($sub->period === $data['period'] && (int) $sub->units === (int) $data['units']) {
                $this->fail('extChange', 'units', 'نفس الاشتراك الحالي، غيّر المدة أو عدد الوحدات.');
            }

            $q = $this->quote($sub, $data['period'], (float) $data['new_price']);
            $units = (int) $data['units'];
            $gb = $units * StorageSubscription::unitGb();
            $oldLabel = "+{$sub->gb_label} GB ({$sub->period_label})";

            $sub->update([
                'period' => $data['period'], 'units' => $units, 'gb' => $gb,
                'start_date' => today(), 'end_date' => today()->addDays($q['days'] + $q['bonus']),
                'locked_price' => $data['new_price'],
            ]);

            $this->income(
                "تعديل مساحة د. {$sub->doctor->user->name}: {$oldLabel} ← +{$gb} GB ({$sub->period_label})",
                (float) $data['collected'], $data['note'] ?? null
            );
            AdminAuditLog::record('extra_storage.change', "extra#{$sub->id}", [
                'gb' => $gb, 'period' => $sub->period, 'credit' => $q['credit'], 'collected' => (float) $data['collected'],
            ]);

            return 'تم تعديل الاشتراك وتسجيل المبلغ في المالية.' . $this->overUsageNote($sub->doctor_id);
        });

        return back()->with('success', $msg);
    }

    /* ------------------------------ تجديد ------------------------------ */

    public function renew(Request $request, StorageSubscription $extra)
    {
        $data = $request->validateWithBag('extRenew', [
            'period' => ['nullable', Rule::in(array_keys(StorageSubscription::plans()))],
            'units' => ['nullable', 'integer', 'min:1', 'max:' . $this->svc->maxUnits()],
            'start_date' => ['nullable', 'date', 'before_or_equal:today'],
            'amount' => ['required', 'numeric', 'min:0', 'max:10000000'],
            'sub_token' => ['required', 'string'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $msg = DB::transaction(function () use ($extra, $data) {
            $sub = StorageSubscription::with('doctor.user')->lockForUpdate()->findOrFail($extra->id);
            $this->guard($sub, 'extRenew', $data['sub_token']);

            if ($sub->is_running) {
                // لسه ساري: نفس الباقة، والأيام المتبقية بتتحفظ (النهاية القديمة + المدة)
                $sub->update([
                    'end_date' => $sub->end_date->copy()->addDays(StorageSubscription::periodDays($sub->period)),
                    'locked_price' => $data['amount'],
                ]);
            } else {
                $period = $data['period'] ?? $sub->period;
                $units = (int) ($data['units'] ?? $sub->units);
                $start = Carbon::parse($data['start_date'] ?? today())->startOfDay();
                $end = $start->copy()->addDays(StorageSubscription::periodDays($period));

                if ($end->lte(today())) {
                    $this->fail('extRenew', 'start_date', 'تاريخ البداية قديم والاشتراك هيبقى منتهي بالفعل.');
                }

                $sub->update([
                    'period' => $period, 'units' => $units, 'gb' => $units * StorageSubscription::unitGb(),
                    'start_date' => $start, 'end_date' => $end, 'status' => 'active',
                    'locked_price' => $data['amount'],
                ]);
            }

            $this->income("تجديد مساحة +{$sub->gb_label} GB ({$sub->period_label}) - د. {$sub->doctor->user->name}", (float) $data['amount'], $data['note'] ?? null);
            AdminAuditLog::record('extra_storage.renew', "extra#{$sub->id}", ['amount' => (float) $data['amount']]);

            $this->svc->sync($sub->doctor_id);

            return 'تم تجديد الاشتراك وتسجيله في المالية.';
        });

        return back()->with('success', $msg);
    }

    /* ------------------------------ helpers ------------------------------ */

    /** رصيد الأيام المتبقية يتخصم من سعر الاشتراك الجديد، والزيادة تتحول لأيام إضافية */
    private function quote(StorageSubscription $sub, string $period, float $newPrice): array
    {
        $days = StorageSubscription::periodDays($period);
        $credit = $sub->credit;
        $leftover = max(round($credit - $newPrice, 2), 0);
        $bonus = ($newPrice > 0 && $leftover > 0) ? (int) floor($leftover / ($newPrice / $days)) : 0;

        return ['days' => $days, 'credit' => $credit, 'due' => max(round($newPrice - $credit, 2), 0), 'bonus' => $bonus];
    }

    private function overUsageNote(int $doctorId): string
    {
        $quota = $this->svc->sync($doctorId);
        $used = (int) PatientFile::where('doctor_id', $doctorId)->sum('size');

        return $used > $quota * self::GB
            ? ' تنبيه: الاستهلاك أكبر من المساحة الجديدة، الرفع متوقف والملفات الموجودة تفضل.'
            : '';
    }

    private function usedBytes(string $column)
    {
        return PatientFile::query()->selectRaw('COALESCE(SUM(size), 0)')->whereColumn('patient_files.doctor_id', $column);
    }

    private function guard(StorageSubscription $sub, string $bag, string $token): void
    {
        if (! hash_equals($sub->token, $token)) {
            $this->fail($bag, 'sub_token', 'الاشتراك اتغيّر من أدمن تاني. اقفل النافذة وافتحها من جديد.');
        }
    }

    private function income(string $title, float $amount, ?string $note): void
    {
        if ($amount <= 0) {
            return;
        }

        FinanceEntry::create([
            'type' => 'income', 'category' => 'extra_storage', 'title' => $title, 'amount' => $amount,
            'entry_date' => now('Africa/Cairo')->toDateString(), 'note' => $note, 'created_by' => auth()->id(),
        ]);
    }

    private function fail(string $bag, string $field, string $msg): never
    {
        throw ValidationException::withMessages([$field => $msg])->errorBag($bag);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAuditLog;
use App\Models\Plan;
use App\Support\Money;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PlanController extends Controller
{
    private const TIER_ORDER = ['prime', 'professional', 'clinic-system'];
    private const TIER_BAG = 'planTier';
    private const ORDER_BAG = 'planOrder';

    public function index()
    {
        $all = Plan::query()
            ->withCount(['subscription as active_subs' => fn ($q) => $q
                ->where('status', 'active')
                ->where('end_date', '>', now())])
            ->get();

        $groups = $all->groupBy(fn (Plan $p) => $p->tierKey());
        $free = $groups->pull('free')?->sortBy('duration')->values();

        $keys = collect(self::TIER_ORDER)
            ->filter(fn ($k) => $groups->has($k))
            ->merge($groups->keys()->diff(self::TIER_ORDER))
            ->values();

        $tiers = $keys->mapWithKeys(fn ($k) => [$k => $groups[$k]->sortBy('duration')->values()]);

        $paid = $all->reject(fn (Plan $p) => $p->isFree())
            ->sortBy([['sort_order', 'asc'], ['id', 'asc']])
            ->values();

        $payloads = $tiers->map(fn ($rows, $key) => Plan::tierPayload($key, $rows) + [
            'best_plan_id' => $rows->firstWhere('the_best', true)?->id,
        ])->all();
        if ($free) {
            $payloads['free'] = Plan::tierPayload('free', $free);
        }

        $orderItems = $paid->map(fn (Plan $p) => [
            'id' => $p->id,
            'tier' => $p->tierKey(),
            'tier_label' => ucwords($p->name),
            'label' => $p->durationLabel(),
            'price' => Money::fmt($p->price),
        ])->all();

        return view('admin.plans.index', [
            'tiers' => $tiers,
            'free' => $free,
            'payloads' => $payloads,
            'orderItems' => $orderItems,
            'orderToken' => Plan::orderToken($paid),
        ]);
    }


    public function updateTier(Request $request, string $tier)
    {
        abort_if($this->tierRows($tier)->isEmpty(), 404);
        $free = $tier === 'free';

        $rules = [
            'plan_token' => ['required', 'string'],
            'description' => ['nullable', 'string', 'max:1000'],
            'features' => ['nullable', 'array', 'max:12'],
            'features.*' => ['nullable', 'string', 'max:120'],
            'best_plan' => ['nullable', 'integer'],
        ];
        if (! $free) {
            $rules['prices'] = ['required', 'array'];
            $rules['prices.*'] = ['required', 'numeric', 'min:0', 'max:10000000'];
        }

        $data = $request->validateWithBag(self::TIER_BAG, $rules, [], [
            'description' => 'الوصف',
            'features' => 'المميزات',
            'features.*' => 'الميزة',
            'prices' => 'الأسعار',
            'prices.*' => 'السعر',
            'best_plan' => 'المدة الأفضل',
            'plan_token' => 'رمز الباقة',
        ]);

        DB::transaction(function () use ($tier, $free, $data) {
            $rows = Plan::query()->lockForUpdate()->get()
                ->filter(fn (Plan $p) => $p->tierKey() === $tier)->values();

            if (! hash_equals(Plan::tierToken($rows), $data['plan_token'])) {
                $this->fail(self::TIER_BAG, 'plan_token', 'الباقة اتعدلت من أدمن تاني. اقفل النافذة وافتحها من جديد.');
            }

            if (! $free) {
                $ids = $rows->pluck('id')->sort()->values()->all();
                $sent = collect(array_keys($data['prices']))->map(fn ($k) => (int) $k)->sort()->values()->all();
                if ($ids !== $sent) {
                    $this->fail(self::TIER_BAG, 'prices', 'الأسعار المبعوتة مش مطابقة لمدد الباقة.');
                }

                // سعر المدة الأطول لازم يكون أكبر من سعر المدة الأقصر
                $prev = null;
                foreach ($rows->sortBy('duration') as $p) {
                    $price = (float) $data['prices'][$p->id];
                    if ($prev && $price < $prev['price']) {
                        $this->fail(self::TIER_BAG, 'prices', "سعر {$p->durationLabel()} لازم يكون أكبر من سعر {$prev['label']}.");
                    }
                    $prev = ['price' => $price, 'label' => $p->durationLabel()];
                }
            }

            $features = array_values(array_filter(
                array_map(fn ($f) => trim((string) $f), $data['features'] ?? []),
                fn ($f) => $f !== ''
            ));

            // المدة الأفضل: لازم تكون تابعة لنفس الباقة، والمجانية ملهاش أفضل
            $bestId = (! $free && ! empty($data['best_plan'])) ? (int) $data['best_plan'] : null;
            if ($bestId !== null && ! $rows->contains('id', $bestId)) {
                $this->fail(self::TIER_BAG, 'best_plan', 'المدة المختارة كـ«الأفضل» مش تابعة للباقة دي.');
            }

            foreach ($rows as $p) {
                $attrs = [
                    'description' => $data['description'] ?? '',
                    'features' => $features,
                    'the_best' => $bestId !== null && $p->id === $bestId,
                ];
                if (! $free) {
                    $attrs['price'] = $data['prices'][$p->id];
                }
                $p->update($attrs);
            }

        });

        return redirect()->route('admin.plans.index')->with('success', 'تم حفظ تعديلات الباقة.');
    }


    public function updateOrder(Request $request)
    {
        $data = $request->validateWithBag(self::ORDER_BAG, [
            'order_token' => ['required', 'string'],
            'order' => ['required', 'array', 'min:1'],
            'order.*' => ['required', 'integer', 'distinct'],
        ], [], ['order' => 'الترتيب', 'order_token' => 'رمز الترتيب']);

        DB::transaction(function () use ($data) {
            $all = Plan::query()->lockForUpdate()->get();
            $paid = $all->reject(fn (Plan $p) => $p->isFree())->values();

            if (! hash_equals(Plan::orderToken($paid), $data['order_token'])) {
                $this->fail(self::ORDER_BAG, 'order_token', 'الترتيب اتغيّر من أدمن تاني. حدّث الصفحة وجرّب تاني.');
            }

            $sent = collect($data['order'])->map(fn ($i) => (int) $i)->sort()->values()->all();
            if ($sent !== $paid->pluck('id')->sort()->values()->all()) {
                $this->fail(self::ORDER_BAG, 'order', 'قائمة الباقات غير مكتملة. حدّث الصفحة وجرّب تاني.');
            }

            foreach (array_values($data['order']) as $rank => $id) {
                Plan::query()->whereKey((int) $id)->update(['sort_order' => $rank]);
            }

            // المجانية في الآخر دايمًا
            $free = $all->first(fn (Plan $p) => $p->isFree());
            if ($free && (int) $free->sort_order < $paid->count()) {
                $free->update(['sort_order' => $paid->count()]);
            }

        });

        return redirect()->route('admin.plans.index')->with('success', 'تم حفظ ترتيب الباقات.');
    }

    private function tierRows(string $tier): Collection
    {
        return Plan::query()->get()->filter(fn (Plan $p) => $p->tierKey() === $tier)->values();
    }

    private function fail(string $bag, string $field, string $msg): never
    {
        throw ValidationException::withMessages([$field => $msg])->errorBag($bag);
    }
}

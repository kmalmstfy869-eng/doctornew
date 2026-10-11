@extends('admin.layout.app')

@push('extra_style')
    {{-- هيكل المودال (ext-modal / ext-panel) مشترك مع صفحة المساحة --}}
    <link rel="stylesheet"
        href="{{ asset('css/admin/extra-storage.css') }}?v={{ @filemtime(public_path('css/admin/extra-storage.css')) ?: time() }}">
    <link rel="stylesheet"
        href="{{ asset('css/admin/plans.css') }}?v={{ @filemtime(public_path('css/admin/plans.css')) ?: time() }}">
@endpush

@section('title', 'الباقات | لوحة الإدارة')
@section('page-title', 'الباقات')
@section('page-description', 'الأسعار والمميزات وترتيب الظهور')

@section('content')
    @php
        $fmt = fn($n) => \App\Support\Money::fmt($n);

        $reopen = $errors->planTier->any() ? ($payloads[old('tier')] ?? null) : null;
        $old = $reopen
            ? [
                'description' => old('description'),
                'features' => array_values((array) old('features', [])),
                'best_plan' => old('best_plan'),
                'prices' => (array) old('prices', []),
            ]
            : null;
    @endphp

    <div class="pl-page" dir="rtl" x-data>

        <p class="pl-hint">
            <i class="fa-solid fa-lock"></i>
            الاسم والـ slug والمدة ثابتين لأن الكود معتمد عليهم. الوصف والمميزات بتتطبق على كل مدد الباقة.
        </p>

        {{-- ================= الباقات الأم ================= --}}
        <div class="pl-tiers">
            @foreach ($tiers as $key => $rows)
                @php
                    $first = $rows->first();
                    $base = $first->duration > 0 ? $first->price / ($first->duration / 30) : 0;
                    $subs = $rows->sum('active_subs');
                    $maxSubs = max(1, (int) $rows->max('active_subs'));
                @endphp
                <article class="dashboard-card pl-tier" data-tier="{{ $key }}">
                    <header class="pl-tier__head">
                        <div class="pl-tier__top">
                            <h3 class="pl-name" dir="ltr">{{ ucwords($first->name) }}</h3>
                        </div>
                        <p class="pl-desc">{{ trim((string) $first->description) ?: 'بدون وصف' }}</p>
                    </header>

                    <ol class="pl-ladder">
                        @foreach ($rows as $p)
                            @php
                                $per = $p->duration > 0 ? $p->price / ($p->duration / 30) : 0;
                                $w = round(((int) $p->active_subs / $maxSubs) * 100); // الأكتر مشتركين = شريط ممتلئ
                                $save = $base > 0 ? max(0, round((1 - $per / $base) * 100)) : 0;
                            @endphp
                            <li class="pl-rung">
                                <span class="pl-rung__label">{{ $p->durationLabel() }}</span>
                                <span class="pl-rung__price">{{ $fmt($p->price) }} <small>ج.م</small></span>
                                <span class="pl-rung__meta">
                                    ≈ {{ $fmt($per) }} ج.م / شهر
                                    @if ($p->the_best)
                                        <span class="pl-best pl-best--sm"><i class="fa-solid fa-crown"></i> الأفضل</span>
                                    @endif
                                    @if ($save > 0)
                                        <em class="pl-save">وفّر {{ $save }}%</em>
                                    @endif
                                </span>
                                <span class="pl-rung__subs"><b>{{ $p->active_subs }}</b> مشترك</span>
                                <span class="pl-bar" aria-hidden="true"><i style="--w: {{ $w }}%"></i></span>
                            </li>
                        @endforeach
                    </ol>

                    <ul class="pl-feats">
                        @forelse (($first->features ?? []) as $f)
                            <li><i class="fa-solid fa-check"></i><span>{{ is_string($f) ? $f : json_encode($f, JSON_UNESCAPED_UNICODE) }}</span></li>
                        @empty
                            <li class="pl-empty">لا توجد مميزات</li>
                        @endforelse
                    </ul>

                    <footer class="pl-tier__foot">
                        <span class="pl-total"><b>{{ $subs }}</b> مشترك فعّال</span>
                        <button type="button" class="ap-btn ap-btn--primary ap-btn--sm"
                            data-plan="{{ json_encode($payloads[$key], JSON_UNESCAPED_UNICODE) }}"
                            @click="$dispatch('ap-plan-edit-open', JSON.parse($el.dataset.plan))">
                            <i class="fa-solid fa-pen"></i> تعديل
                        </button>
                    </footer>
                </article>
            @endforeach
        </div>

        {{-- ================= المجانية ================= --}}
        @if ($free)
            @php $f0 = $free->first(); @endphp
            <section class="dashboard-card pl-free" data-tier="free">
                <div class="pl-free__id">
                    <h3 class="pl-name" dir="ltr">Free</h3>
                    <span class="pl-chip pl-chip--solid">مجانية</span>
                </div>
                <div class="pl-free__body">
                    <p class="pl-desc">{{ trim((string) $f0->description) ?: 'بدون وصف' }}</p>
                    <div class="pl-free__chips">
                        @foreach (($f0->features ?? []) as $f)
                            <span class="pl-chip">{{ is_string($f) ? $f : json_encode($f, JSON_UNESCAPED_UNICODE) }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="pl-free__act">
                    <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm"
                        data-plan="{{ json_encode($payloads['free'], JSON_UNESCAPED_UNICODE) }}"
                        @click="$dispatch('ap-plan-edit-open', JSON.parse($el.dataset.plan))">
                        <i class="fa-solid fa-pen"></i> تعديل
                    </button>
                </div>
            </section>
        @endif

        {{-- ================= ترتيب الظهور ================= --}}
        <section class="dashboard-card pl-orderbox" x-data="apPlanOrder()"
            data-items="{{ json_encode($orderItems, JSON_UNESCAPED_UNICODE) }}">
            <div class="pl-orderbox__head">
                <h3>ترتيب الظهور</h3>
                <p>الأطباء بيظهروا حسب ترتيب باقتهم، الأعلى في القائمة الأول. الباقة المجانية دايمًا في الآخر.</p>
            </div>

            @if ($errors->planOrder->any())
                <div class="ap-alert ap-alert--bad">
                    <ul>@foreach ($errors->planOrder->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.plans.order') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="order_token" value="{{ $orderToken }}">

                <ol class="pl-order">
                    <template x-for="(it, i) in items" :key="it.id">
                        <li class="pl-ord" :data-tier="it.tier">
                            <input type="hidden" name="order[]" :value="it.id">
                            <span class="pl-ord__rank" x-text="i + 1"></span>
                            <span class="pl-ord__name">
                                <b dir="ltr" x-text="it.tier_label"></b>
                                <span x-text="it.label"></span>
                            </span>
                            <span class="pl-ord__price" x-text="it.price + ' ج.م'"></span>
                            <span class="pl-ord__btns">
                                <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" aria-label="تحريك لفوق"
                                    @click="move(i, -1)" :disabled="i === 0"><i class="fa-solid fa-arrow-up"></i></button>
                                <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" aria-label="تحريك لتحت"
                                    @click="move(i, 1)" :disabled="i === items.length - 1"><i class="fa-solid fa-arrow-down"></i></button>
                            </span>
                        </li>
                    </template>
                </ol>

                <div class="pl-savebar">
                    <span class="pl-savebar__msg" x-show="dirty()" x-cloak>الترتيب اتغيّر ولسه ما اتحفظش.</span>
                    <button type="submit" class="ap-btn ap-btn--primary">حفظ الترتيب</button>
                </div>
            </form>
        </section>

        {{-- ================= مودال: تعديل باقة ================= --}}
        <div x-data="apPlanTier()" data-reopen="{{ json_encode($reopen, JSON_UNESCAPED_UNICODE) }}"
            data-old="{{ json_encode($old, JSON_UNESCAPED_UNICODE) }}" @ap-plan-edit-open.window="open($event.detail)">
            <template x-teleport="body">
                <div class="ext-modal" x-show="show" x-cloak x-effect="document.body.style.overflow = show ? 'hidden' : ''"
                    @click.self="show = false" @keydown.escape.window="show = false">
                    <form method="POST" :action="plan ? plan.url : '#'" class="ext-panel" @submit="submit($event)">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tier" :value="plan ? plan.key : ''">
                        <input type="hidden" name="plan_token" :value="plan ? plan.token : ''">

                        <div class="ext-panel__head">
                            <h3>تعديل باقة <span dir="ltr" x-text="plan ? plan.title : ''"></span></h3>
                            <button type="button" class="ext-x" @click="show = false">×</button>
                        </div>

                        <div class="ext-panel__body">
                            @if ($errors->planTier->any())
                                <div class="ap-alert ap-alert--bad">
                                    <ul>@foreach ($errors->planTier->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                                </div>
                            @endif

                            <template x-if="plan">
                                <div class="ext-stack">

                                    <template x-if="!plan.is_free">
                                        <div class="ap-field">
                                            <label>الأسعار (ج.م)</label>
                                            <div class="pl-prices">
                                                <template x-for="pl in plan.plans" :key="pl.id">
                                                    <div class="pl-price-row">
                                                        <span class="pl-price-row__label" x-text="pl.label"></span>
                                                        <input type="number" :name="'prices[' + pl.id + ']'" x-model="prices[pl.id]"
                                                            step="0.01" min="0" class="ap-input" required>
                                                        <small x-show="perMonth(pl)" x-text="'≈ ' + perMonth(pl) + ' ج.م / شهر'"></small>
                                                    </div>
                                                </template>
                                            </div>
                                            <p class="pl-warn" x-show="ladderWarn()" x-text="ladderWarn()"></p>
                                        </div>
                                    </template>

                                    <div class="ap-field">
                                        <label>الوصف</label>
                                        <textarea name="description" x-model="description" rows="3" maxlength="1000" class="ap-input"></textarea>
                                    </div>

                                    <div class="ap-field">
                                        <label>المميزات <small>(حتى 12)</small></label>
                                        <div class="pl-feat-list">
                                            <template x-for="(f, i) in features" :key="f.id">
                                                <div class="pl-feat">
                                                    <input type="text" name="features[]" x-model="f.text" maxlength="120"
                                                        class="ap-input" placeholder="اكتب الميزة...">
                                                    <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" aria-label="لفوق"
                                                        @click="move(i, -1)" :disabled="i === 0"><i class="fa-solid fa-arrow-up"></i></button>
                                                    <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" aria-label="لتحت"
                                                        @click="move(i, 1)" :disabled="i === features.length - 1"><i class="fa-solid fa-arrow-down"></i></button>
                                                    <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" aria-label="حذف"
                                                        @click="removeFeature(i)"><i class="fa-solid fa-trash"></i></button>
                                                </div>
                                            </template>
                                        </div>
                                        <button type="button" class="ext-link" @click="addFeature()" x-show="features.length < 12">
                                            <i class="fa-solid fa-plus"></i> إضافة ميزة
                                        </button>
                                    </div>

                                    <template x-if="!plan.is_free">
                                        <div class="ap-field">
                                            <label>المدة الأفضل <small>(بتظهر للأطباء بشارة «الأفضل للأطباء»)</small></label>
                                            <div class="pl-best-pick">
                                                <label class="pl-check">
                                                    <input type="radio" name="best_plan" value="" x-model="bestPlan">
                                                    <span>بدون</span>
                                                </label>
                                                <template x-for="pl in plan.plans" :key="'best' + pl.id">
                                                    <label class="pl-check">
                                                        <input type="radio" name="best_plan" :value="pl.id" x-model="bestPlan">
                                                        <span x-text="pl.label"></span>
                                                    </label>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                </div>
                            </template>
                        </div>

                        <div class="ext-panel__foot">
                            <p class="pl-warn pl-warn--foot" x-show="ladderWarn()" x-text="ladderWarn()"></p>
                            <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy">حفظ التعديلات</button>
                            <button type="button" class="ap-btn ap-btn--ghost" @click="show = false">إلغاء</button>
                        </div>
                    </form>
                </div>
            </template>
        </div>

    </div>
@endsection

@push('extra_java')
    <script src="{{ asset('js/admin/plans.js') }}?v={{ @filemtime(public_path('js/admin/plans.js')) ?: time() }}"></script>
@endpush

@extends('admin.layout.app')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/admin/extra-storage.css') }}?v={{ @filemtime(public_path('css/admin/extra-storage.css')) ?: time() }}">
@endpush

@section('title', 'اشتراكات المساحة | لوحة الإدارة')
@section('page-title', 'اشتراكات المساحة الإضافية')
@section('page-description', 'مساحة ملفات المرضى فوق الـ ' . (int) config('clinic.patient_files_storage_gb', 25) . ' جيجا المجانية')

@section('content')
    @php
        $fmt = fn($n) => \App\Support\Money::fmt($n);
        $today = now('Africa/Cairo')->toDateString();
        $P = collect($cfg['plans'])->keyBy('key');
        $m = $P['monthly'] ?? null;
        $y = $P['yearly'] ?? null;
        $saving = $m && $y ? max($m['price'] * 12 - $y['price'], 0) : 0;
        $savingPct = $m && $y && $m['price'] > 0 ? round(($saving / ($m['price'] * 12)) * 100) : 0;

        $reopenChange = $errors->extChange->any() ? $subs->firstWhere('id', (int) old('ext_id'))?->modalPayload() : null;
        $reopenRenew = $errors->extRenew->any() ? $subs->firstWhere('id', (int) old('ext_id'))?->modalPayload() : null;
    @endphp

    <div class="ext-page" dir="rtl" x-data>

        {{-- ================= الباقات ================= --}}
        <div class="ext-plans">
            <div class="ext-plan ext-plan--base">
                <span class="ext-plan__icon"><i class="fa-solid fa-hard-drive"></i></span>
                <h3>المساحة الأساسية</h3>
                <div class="ext-plan__price"><b>{{ (int) $cfg['base_gb'] }}</b> <small>GB</small></div>
                <p>مجانًا لكل طبيب، بدون اشتراك.</p>
                <ul>
                    <li><i class="fa-solid fa-check"></i> ملفات المرضى (PDF وصور)</li>
                    <li><i class="fa-solid fa-check"></i> نسخ احتياطي يومي</li>
                </ul>
            </div>

            @foreach ($cfg['plans'] as $p)
                @php $isY = $p['days'] >= 360; $st = $planStats[$p['key']] ?? null; @endphp
                <div class="ext-plan {{ $isY ? 'ext-plan--featured' : '' }}">
                    @if ($isY && $saving > 0)
                        <span class="ext-plan__ribbon">الأوفر — وفّر {{ $fmt($saving) }} ج.م ({{ $savingPct }}%)</span>
                    @endif
                    <span class="ext-plan__icon"><i class="fa-solid {{ $isY ? 'fa-crown' : 'fa-calendar-days' }}"></i></span>
                    <h3>اشتراك {{ $p['label'] }}</h3>
                    <div class="ext-plan__price"><b>{{ $fmt($p['price']) }}</b> <small>ج.م / {{ $isY ? 'سنة' : 'شهر' }}</small></div>
                    <p>لكل {{ $cfg['unit_gb'] }} GB إضافية · ≈ {{ $fmt($p['price'] / ($p['days'] / 30)) }} ج.م / شهر</p>
                    <ul>
                        <li><i class="fa-solid fa-check"></i> +{{ $cfg['unit_gb'] }} GB لكل وحدة (حتى {{ $cfg['max_units'] }})</li>
                        <li><i class="fa-solid fa-lock"></i> سعر ثابت للمشترك مهما ارتفع السعر</li>
                    </ul>
                    <div class="ext-plan__foot">
                        <span><b>{{ $st->subs ?? 0 }}</b> مشترك</span>
                        <span><b>{{ rtrim(rtrim(number_format((float) ($st->gb ?? 0), 2, '.', ''), '0'), '.') ?: 0 }}</b> GB</span>
                        <button type="button" class="ap-btn ap-btn--primary ap-btn--sm"
                            @click="$dispatch('ap-ext-add-open', { period: '{{ $p['key'] }}' })">
                            <i class="fa-solid fa-plus"></i> اشتراك
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ================= شريط الأدوات ================= --}}
        <div class="dashboard-card ap-card" style="margin-top:1rem">
            <div class="ap-card__head">
                <div>
                    <h3>اشتراكات الأطباء</h3>
                    <p>المساحة الإضافية فقط، والاستهلاك الكامل في صفحة «مساحات الأطباء».</p>
                </div>
                <button type="button" class="ap-btn ap-btn--primary" @click="$dispatch('ap-ext-add-open')">
                    <i class="fa-solid fa-plus"></i> إضافة اشتراك
                </button>
            </div>
            <div class="ap-filters">
                <div class="ap-field ap-field--grow">
                    <label>بحث باسم الطبيب</label>
                    <input type="text" id="ext-search" value="{{ $search }}" class="ap-input"
                        placeholder="اكتب اسم الطبيب..." autocomplete="off">
                </div>
            </div>
        </div>

        <div id="ext-results">

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon green-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="stat-info"><p>اشتراكات سارية</p><h3>{{ $counts['active'] }}</h3></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon ext-icon-amber"><i class="fa-solid fa-hourglass-half"></i></div>
                    <div class="stat-info"><p>تنتهي خلال {{ $soonDays }} أيام</p><h3>{{ $counts['soon'] }}</h3></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue-icon"><i class="fa-solid fa-cubes-stacked"></i></div>
                    <div class="stat-info"><p>مساحة إضافية مباعة</p><h3>{{ rtrim(rtrim(number_format($extraGb, 2, '.', ''), '0'), '.') ?: 0 }} GB</h3></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon ext-icon-violet"><i class="fa-solid fa-sack-dollar"></i></div>
                    <div class="stat-info"><p>إيراد المساحة (الشهر)</p><h3 class="ap-plus">{{ $fmt($monthIncome) }} ج.م</h3></div>
                </div>
            </div>

            <div class="dashboard-card ap-card" style="margin-top:1rem">
                <div class="ap-card__head">
                    <div class="ext-tabs">
                        @foreach (['all' => 'الكل', 'active' => 'سارية', 'soon' => 'قاربت تنتهي', 'expired' => 'منتهية'] as $k => $label)
                            <a data-ext-nav
                                href="{{ route('admin.storage.extra.index', array_filter(['state' => $k === 'all' ? null : $k, 'search' => $search])) }}"
                                class="ext-tab {{ $state === $k ? 'is-active' : '' }}">{{ $label }} <b>{{ $counts[$k] }}</b></a>
                        @endforeach
                    </div>
                </div>

                @if ($subs->isEmpty())
                    <x-home.banner.no_results logo="fa-solid fa-cubes-stacked" title="لا توجد اشتراكات"
                        content="مفيش اشتراكات مساحة بتطابق البحث أو التبويب دلوقتي." />
                @else
                    <div class="ap-table-wrap">
                        <table class="ap-table">
                            <thead>
                                <tr>
                                    <th>الطبيب</th>
                                    <th>الاشتراك</th>
                                    <th>الاستهلاك</th>
                                    <th>السعر</th>
                                    <th>المدة</th>
                                    <th>الحالة</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subs as $s)
                                    @php
                                        $left = $s->days_left;
                                        $run = $s->is_running;
                                        $st = !$run ? 'expired' : ($left <= $soonDays ? 'soon' : 'ok');
                                        $totalDays = max(1, (int) $s->start_date->diffInDays($s->end_date));
                                        $timePct = $run ? min(100, max(2, round((1 - $left / $totalDays) * 100))) : 100;
                                        $catalog = \App\Models\StorageSubscription::catalog($s->period, $s->units);
                                        $locked = (float) $s->locked_price;
                                        $delta = round($catalog - $locked, 2);
                                        $usedGb = ((int) $s->used_bytes) / 1073741824;
                                        $quota = (float) ($s->doctor?->patient_files_quota_gb ?? $cfg['base_gb']);
                                        $usePct = $quota > 0 ? min(100, round(($usedGb / $quota) * 100)) : 0;
                                        $useCls = $usePct >= 100 ? 'bad' : ($usePct >= 90 ? 'warn' : 'ok');
                                        $name = $s->doctor?->user?->name ?? '—';
                                        $payload = json_encode($s->modalPayload(), JSON_UNESCAPED_UNICODE);
                                    @endphp
                                    <tr>
                                        <td data-label="الطبيب">
                                            <div class="ext-doc">
                                                <span class="ext-avatar">{{ mb_substr($name, 0, 1) }}</span>
                                                <div>
                                                    <div class="ap-title">د. {{ $name }}</div>
                                                    <div class="ap-sub">{{ $s->doctor?->specialty?->name ?? 'بدون تخصص' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="الاشتراك">
                                            <span class="ext-chip ext-chip--{{ $s->period }}">{{ $s->period_label }}</span>
                                            <div class="ext-gb">+{{ $s->gb_label }} GB <small>({{ $s->units }} وحدة)</small></div>
                                        </td>
                                        <td data-label="الاستهلاك">
                                            <div class="ext-use ext-use--{{ $useCls }}"><span style="width: {{ max($usePct, 2) }}%"></span></div>
                                            <div class="ap-sub" dir="ltr">{{ number_format($usedGb, 2) }} / {{ rtrim(rtrim(number_format($quota, 2, '.', ''), '0'), '.') }} GB</div>
                                        </td>
                                        <td data-label="السعر">
                                            <div class="ext-price">
                                                @if (abs($delta) > 0.009)
                                                    <div class="ext-price__old"><span>سعر الباقة الحالي</span> <s>{{ $fmt($catalog) }} ج.م</s></div>
                                                @endif
                                                <div class="ext-price__paid"><span>يدفع</span> <b>{{ $fmt($locked) }} ج.م</b></div>
                                                @if ($delta > 0.009)
                                                    <span class="ext-tag ext-tag--lock"><i class="fa-solid fa-lock"></i> سعر ثابت · يوفّر {{ $fmt($delta) }}</span>
                                                @elseif ($delta < -0.009)
                                                    <span class="ext-tag ext-tag--up"><i class="fa-solid fa-arrow-trend-up"></i> أعلى بـ {{ $fmt(abs($delta)) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td data-label="المدة">
                                            <div class="ext-meter ext-meter--{{ $st }}"><span style="width: {{ $timePct }}%"></span></div>
                                            <div class="ap-sub">{{ $s->start_date->translatedFormat('d M Y') }} → {{ $s->end_date->translatedFormat('d M Y') }}</div>
                                        </td>
                                        <td data-label="الحالة">
                                            @if ($st === 'expired')
                                                <span class="ext-state ext-state--expired"><i class="fa-solid fa-circle-xmark"></i> منتهي</span>
                                            @elseif ($st === 'soon')
                                                <span class="ext-state ext-state--soon"><i class="fa-solid fa-hourglass-half"></i> باقي {{ $left }} يوم</span>
                                            @else
                                                <span class="ext-state ext-state--ok"><i class="fa-solid fa-circle-check"></i> باقي {{ $left }} يوم</span>
                                            @endif
                                        </td>
                                        <td data-label="">
                                            <div class="ext-actions">
                                                @if ($run)
                                                    <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" data-ext="{{ $payload }}"
                                                        @click="$dispatch('ap-ext-change-open', JSON.parse($el.dataset.ext))">
                                                        <i class="fa-solid fa-sliders"></i> تعديل
                                                    </button>
                                                @endif
                                                <button type="button"
                                                    class="ap-btn ap-btn--sm {{ $st === 'ok' ? 'ap-btn--ghost' : 'ap-btn--primary' }}"
                                                    data-ext="{{ $payload }}"
                                                    @click="$dispatch('ap-ext-renew-open', JSON.parse($el.dataset.ext))">
                                                    <i class="fa-solid fa-rotate"></i> تجديد
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="ap-card__foot">{{ $subs->links('vendor.pagination.custom') }}</div>
                @endif
            </div>
        </div>

        {{-- ================= مودال: إضافة ================= --}}
        <div x-data="apExtAdd()" data-cfg="{{ json_encode($cfg) }}" data-today="{{ $today }}"
            data-search-url="{{ route('admin.storage.extra.doctors') }}"
            data-has-errors="{{ $errors->extAdd->any() ? '1' : '0' }}" data-old-doctor-id="{{ old('doctor_id') }}"
            data-old-doctor-name="{{ old('doctor_name') }}" data-old-period="{{ old('period') }}"
            data-old-units="{{ old('units') }}" data-old-start="{{ old('start_date') }}"
            data-old-amount="{{ old('amount') }}" @ap-ext-add-open.window="open($event.detail)">
            <template x-teleport="body">
                <div class="ext-modal" x-show="show" x-cloak x-effect="document.body.style.overflow = show ? 'hidden' : ''"
                    @click.self="show = false" @keydown.escape.window="show = false">
                    <form method="POST" action="{{ route('admin.storage.extra.store') }}" class="ext-panel"
                        @submit="busy = true">
                        @csrf
                        <div class="ext-panel__head">
                            <h3>إضافة اشتراك مساحة</h3>
                            <button type="button" class="ext-x" @click="show = false">×</button>
                        </div>
                        <div class="ext-panel__body">
                            @if ($errors->extAdd->any())
                                <div class="ap-alert ap-alert--bad"><ul>@foreach ($errors->extAdd->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                            @endif

                            <input type="hidden" name="doctor_id" :value="doctor ? doctor.id : ''">
                            <input type="hidden" name="doctor_name" :value="doctor ? doctor.name : ''">
                            <input type="hidden" name="period" :value="period">

                            <div class="ap-field">
                                <label>الطبيب</label>
                                <div class="ext-picked" x-show="doctor">
                                    <span class="ext-avatar" x-text="doctor ? (doctor.name || '').charAt(0) : ''"></span>
                                    <div class="ext-picked__info">
                                        <strong x-text="doctor ? 'د. ' + doctor.name : ''"></strong>
                                        <small x-show="doctor && doctor.quota_gb !== undefined"
                                            x-text="doctor ? ('مستهلك ' + doctor.used_gb + ' من ' + doctor.quota_gb + ' GB') : ''"></small>
                                    </div>
                                    <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" @click="doctor = null; search()">تغيير</button>
                                </div>
                                <div x-show="!doctor" class="ext-search">
                                    <input type="text" class="ap-input" x-model="q" @input.debounce.300ms="search()"
                                        @focus="search()" placeholder="ابحث باسم الطبيب أو رقم تليفونه..." autocomplete="off">
                                    <div class="ext-search__list" x-show="results.length">
                                        <template x-for="d in results" :key="d.id">
                                            <button type="button" class="ext-search__item" @click="pick(d)">
                                                <span class="ext-avatar" x-text="(d.name || '').charAt(0)"></span>
                                                <span>
                                                    <strong x-text="'د. ' + d.name"></strong>
                                                    <small x-text="d.used_gb + ' / ' + d.quota_gb + ' GB' + (d.phone ? ' • ' + d.phone : '')"></small>
                                                </span>
                                            </button>
                                        </template>
                                    </div>
                                    <p class="ext-hint" x-show="searched && !loading && !results.length">مفيش أطباء مطابقين (أو عنده اشتراك مساحة ساري).</p>
                                </div>
                            </div>

                            @include('admin.storage.partials.ext-picker')

                            <div class="ext-grid-2">
                                <div class="ap-field">
                                    <label>تاريخ البداية</label>
                                    <input type="date" name="start_date" x-model="start" :max="cfg.today" class="ap-input" required>
                                </div>
                                <div class="ap-field">
                                    <label>المبلغ المدفوع (ج.م) — يصبح السعر الثابت</label>
                                    <input type="number" name="amount" x-model="amount" step="0.01" min="0" class="ap-input" required>
                                </div>
                            </div>

                            <div class="ext-note" x-show="plan && amount !== '' && Math.abs(Number(amount) - catalog) > 0.009" x-cloak>
                                <i class="fa-solid fa-scale-balanced"></i>
                                <span>سعر الباقة <s x-text="money(catalog) + ' ج.م'"></s> · المدفوع <b x-text="money(amount) + ' ج.م'"></b></span>
                                <em :class="Number(amount) < catalog ? 'is-good' : 'is-bad'"
                                    x-text="Number(amount) < catalog ? ('خصم ' + money(catalog - Number(amount)) + ' ج.م') : ('زيادة ' + money(Number(amount) - catalog) + ' ج.م')"></em>
                            </div>

                            <div class="ap-field">
                                <label>ملاحظة (اختياري)</label>
                                <input type="text" name="note" maxlength="500" class="ap-input" value="{{ old('note') }}">
                            </div>

                            <div class="ext-sum" x-show="plan">
                                <div><span>المساحة الإضافية</span><b x-text="'+' + (units * cfg.unit_gb) + ' GB'"></b></div>
                                <div><span>المساحة الكلية</span><b x-text="(cfg.base_gb + units * cfg.unit_gb) + ' GB'"></b></div>
                                <div><span>تبدأ من</span><b x-text="start || '—'"></b></div>
                                <div><span>ينتهي في</span><b x-text="end || '—'"></b></div>
                            </div>
                        </div>
                        <div class="ext-panel__foot">
                            <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy || !doctor || !plan"
                                x-text="plan ? ('تفعيل وتسجيل ' + money(amount || 0) + ' ج.م') : 'تفعيل الاشتراك'"></button>
                            <button type="button" class="ap-btn ap-btn--ghost" @click="show = false">إلغاء</button>
                        </div>
                    </form>
                </div>
            </template>
        </div>

        {{-- ================= مودال: تعديل ================= --}}
        <div x-data="apExtChange()" data-cfg="{{ json_encode($cfg) }}" data-today="{{ $today }}"
            data-has-errors="{{ $errors->extChange->any() ? '1' : '0' }}"
            data-reopen="{{ json_encode($reopenChange, JSON_UNESCAPED_UNICODE) }}" data-old-period="{{ old('period') }}"
            data-old-units="{{ old('units') }}" data-old-price="{{ old('new_price') }}"
            data-old-collected="{{ old('collected') }}" @ap-ext-change-open.window="open($event.detail)">
            <template x-teleport="body">
                <div class="ext-modal" x-show="show" x-cloak x-effect="document.body.style.overflow = show ? 'hidden' : ''"
                    @click.self="show = false" @keydown.escape.window="show = false">
                    <form method="POST" :action="sub ? sub.url_change : '#'" class="ext-panel" @submit="busy = true">
                        @csrf
                        <input type="hidden" name="ext_id" :value="sub ? sub.id : ''">
                        <input type="hidden" name="sub_token" :value="sub ? sub.token : ''">
                        <input type="hidden" name="period" :value="period">

                        <div class="ext-panel__head">
                            <h3>تعديل الاشتراك — <span x-text="sub ? 'د. ' + sub.doctor : ''"></span></h3>
                            <button type="button" class="ext-x" @click="show = false">×</button>
                        </div>
                        <div class="ext-panel__body">
                            @if ($errors->extChange->any())
                                <div class="ap-alert ap-alert--bad"><ul>@foreach ($errors->extChange->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                            @endif

                            <template x-if="sub">
                                <div class="ext-stack">
                                    <div class="ext-sum">
                                        <div><span>الحالي</span><b x-text="'+' + sub.gb_label + ' GB · ' + sub.period_label"></b></div>
                                        <div><span>سعره الثابت</span><b x-text="money(sub.price) + ' ج.م'"></b></div>
                                        <div><span>باقي</span><b x-text="sub.left + ' يوم'"></b></div>
                                        <div><span>الاستهلاك</span><b x-text="sub.used_gb + ' GB'"></b></div>
                                    </div>

                                    @include('admin.storage.partials.ext-picker')

                                    <template x-if="!same">
                                        <div class="ext-diff">
                                            <div><span>سعر الاشتراك الجديد (ثابت)</span>
                                                <input type="number" name="new_price" x-model.number="newPrice" @input="onPrice()" step="0.01" min="0" class="ap-input"></div>
                                            <div><span>رصيد الأيام المتبقية</span><b x-text="'− ' + money(credit) + ' ج.م'"></b></div>
                                            <div class="is-total"><span>المطلوب دفعه الآن</span><b x-text="money(due) + ' ج.م'"></b></div>
                                            <div><span>المحصّل فعليًا (ج.م)</span>
                                                <input type="number" name="collected" x-model.number="collected" step="0.01" min="0" class="ap-input"></div>
                                        </div>
                                    </template>
                                    <template x-if="same">
                                        <div>
                                            <input type="hidden" name="new_price" :value="sub.price">
                                            <input type="hidden" name="collected" value="0">
                                            <p class="ext-hint">اختار مدة أو عدد وحدات مختلف عن الاشتراك الحالي.</p>
                                        </div>
                                    </template>

                                    <div class="ext-note is-soft" x-show="!same && bonus > 0" x-cloak>
                                        <i class="fa-solid fa-gift"></i>
                                        <span>الرصيد أكبر من سعر الاشتراك الجديد، الزيادة تتحول إلى <b x-text="bonus + ' يوم إضافي'"></b>.</span>
                                    </div>
                                    <div class="ext-note is-warn" x-show="!same && shrink" x-cloak>
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        <span>الاستهلاك الحالي <b x-text="sub.used_gb + ' GB'"></b> أكبر من المساحة الجديدة؛ الرفع هيتوقف والملفات الموجودة تفضل.</span>
                                    </div>

                                    <div class="ap-field">
                                        <label>ملاحظة (اختياري)</label>
                                        <input type="text" name="note" maxlength="500" class="ap-input" value="{{ old('note') }}">
                                    </div>

                                    <div class="ext-sum" x-show="!same">
                                        <div><span>المساحة الإضافية الجديدة</span><b x-text="'+' + newGb + ' GB'"></b></div>
                                        <div><span>المساحة الكلية</span><b x-text="(cfg.base_gb + newGb) + ' GB'"></b></div>
                                        <div><span>ينتهي في</span><b x-text="end"></b></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="ext-panel__foot">
                            <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy || same"
                                x-text="same ? 'تأكيد التعديل' : ('تأكيد وتسجيل ' + money(collected || 0) + ' ج.م')"></button>
                            <button type="button" class="ap-btn ap-btn--ghost" @click="show = false">إلغاء</button>
                        </div>
                    </form>
                </div>
            </template>
        </div>

        {{-- ================= مودال: تجديد ================= --}}
        <div x-data="apExtRenew()" data-cfg="{{ json_encode($cfg) }}" data-today="{{ $today }}"
            data-has-errors="{{ $errors->extRenew->any() ? '1' : '0' }}"
            data-reopen="{{ json_encode($reopenRenew, JSON_UNESCAPED_UNICODE) }}" data-old-period="{{ old('period') }}"
            data-old-units="{{ old('units') }}" data-old-start="{{ old('start_date') }}"
            data-old-amount="{{ old('amount') }}" @ap-ext-renew-open.window="open($event.detail)">
            <template x-teleport="body">
                <div class="ext-modal" x-show="show" x-cloak x-effect="document.body.style.overflow = show ? 'hidden' : ''"
                    @click.self="show = false" @keydown.escape.window="show = false">
                    <form method="POST" :action="sub ? sub.url_renew : '#'" class="ext-panel" @submit="busy = true">
                        @csrf
                        <input type="hidden" name="ext_id" :value="sub ? sub.id : ''">
                        <input type="hidden" name="sub_token" :value="sub ? sub.token : ''">
                        <input type="hidden" name="period" :value="period">

                        <div class="ext-panel__head">
                            <h3>تجديد الاشتراك — <span x-text="sub ? 'د. ' + sub.doctor : ''"></span></h3>
                            <button type="button" class="ext-x" @click="show = false">×</button>
                        </div>
                        <div class="ext-panel__body">
                            @if ($errors->extRenew->any())
                                <div class="ap-alert ap-alert--bad"><ul>@foreach ($errors->extRenew->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                            @endif

                            <template x-if="sub">
                                <div class="ext-stack">
                                    <div class="ext-sum">
                                        <div><span>الاشتراك</span><b x-text="'+' + sub.gb_label + ' GB · ' + sub.period_label"></b></div>
                                        <div><span>سعره الثابت</span><b x-text="money(sub.price) + ' ج.م'"></b></div>
                                        <div><span>الحالة</span><b :class="sub.running ? 'ext-ok-text' : 'ext-bad-text'"
                                                x-text="sub.running ? ('باقي ' + sub.left + ' يوم') : 'منتهي'"></b></div>
                                    </div>

                                    <div x-show="!sub.running" class="ext-stack">
                                        @include('admin.storage.partials.ext-picker')
                                        <div class="ap-field">
                                            <label>تاريخ بداية التجديد</label>
                                            <input type="date" name="start_date" x-model="start" :max="today" class="ap-input" :required="!sub.running">
                                        </div>
                                    </div>

                                    <div class="ap-field">
                                        <label>المبلغ المدفوع (ج.م) — يصبح السعر الثابت</label>
                                        <input type="number" name="amount" x-model="amount" step="0.01" min="0" class="ap-input" required>
                                        <button type="button" class="ext-link" x-show="Math.abs(catalog - Number(amount)) > 0.009"
                                            @click="amount = catalog">استخدام سعر الباقة الحالي (<span x-text="money(catalog)"></span> ج.م)</button>
                                    </div>

                                    <div class="ext-note" x-show="Math.abs(catalog - Number(amount || 0)) > 0.009" x-cloak>
                                        <i class="fa-solid fa-scale-balanced"></i>
                                        <span>سعر الباقة الحالي <s x-text="money(catalog) + ' ج.م'"></s> · السعر الثابت الجديد <b x-text="money(amount || 0) + ' ج.م'"></b></span>
                                    </div>

                                    <div class="ap-field">
                                        <label>ملاحظة (اختياري)</label>
                                        <input type="text" name="note" maxlength="500" class="ap-input" value="{{ old('note') }}">
                                    </div>

                                    <div class="ext-sum">
                                        <div><span>المدة المضافة</span><b x-text="days + ' يوم'"></b></div>
                                        <div><span>يبدأ التجديد من</span><b x-text="(sub.running ? sub.end : start) || '—'"></b></div>
                                        <div><span>ينتهي بعد التجديد</span><b x-text="end || '—'"></b></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="ext-panel__foot">
                            <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy"
                                x-text="'تأكيد التجديد وتسجيل ' + money(amount || 0) + ' ج.م'"></button>
                            <button type="button" class="ap-btn ap-btn--ghost" @click="show = false">إلغاء</button>
                        </div>
                    </form>
                </div>
            </template>
        </div>

    </div>
@endsection

@push('extra_java')
    <script src="{{ asset('js/admin/extra-storage.js') }}?v={{ @filemtime(public_path('js/admin/extra-storage.js')) ?: time() }}"></script>
@endpush

@extends('admin.layout.app')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
@endpush

@section('title', 'المالية | لوحة الإدارة')
@section('page-title', 'المالية')
@section('page-description', 'كل اللي داخل وكل اللي خارج')

@section('content')
    <div class="finance-page" dir="rtl">

        @php
            $fmt = fn($n) => \App\Support\Money::fmt($n);
            $labels = \App\Models\FinanceEntry::allCategories();
        @endphp

        @if ($errors->any())
            <div class="ap-alert ap-alert--bad">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div x-data>

            {{-- الفلاتر + زر الإضافة --}}
            <div class="dashboard-card ap-card">
                <div class="ap-card__head">
                    <div>
                        <h3>الفترة: {{ \Carbon\Carbon::parse($from)->translatedFormat('d M Y') }} -
                            {{ \Carbon\Carbon::parse($to)->translatedFormat('d M Y') }}</h3>
                        <p>الافتراضي الشهر الحالي</p>
                    </div>
                    <button type="button" class="ap-btn ap-btn--primary" @click="$dispatch('ap-fin-open')">
                        <i class="fa-solid fa-plus"></i> إضافة حركة
                    </button>
                </div>

                <form method="GET" action="{{ route('admin.finance.index') }}" class="ap-filters" id="finance-filters">
                    <div class="ap-field">
                        <label>من</label>
                        <input type="date" name="from" value="{{ $from }}" class="ap-input">
                    </div>
                    <div class="ap-field">
                        <label>إلى</label>
                        <input type="date" name="to" value="{{ $to }}" class="ap-input">
                    </div>
                    <div class="ap-field">
                        <label>النوع</label>
                        <select name="type" class="ap-input">
                            <option value="">الكل</option>
                            <option value="income" @selected($type === 'income')>داخل</option>
                            <option value="expense" @selected($type === 'expense')>خارج</option>
                        </select>
                    </div>
                    <div class="ap-field">
                        <label>التصنيف</label>
                        <select name="category" class="ap-input">
                            <option value="">الكل</option>
                            <optgroup label="داخل">
                                @foreach ($categories['income'] as $k => $v)
                                    <option value="{{ $k }}" @selected($category === $k)>{{ $v }}
                                    </option>
                                @endforeach
                            </optgroup>
                            <optgroup label="خارج">
                                @foreach ($categories['expense'] as $k => $v)
                                    <option value="{{ $k }}" @selected($category === $k)>{{ $v }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="ap-field ap-field--grow">
                        <label>بحث في البيان</label>
                        <input type="text" name="search" value="{{ $search }}" class="ap-input"
                            placeholder="اكتب للبحث..." autocomplete="off">
                    </div>
                    <a href="{{ route('admin.finance.index') }}" class="ap-btn ap-btn--ghost">الشهر الحالي</a>
                </form>
            </div>

            {{-- كل اللي بيتغير مع الفلاتر جوه الحاوية دي --}}
            <div id="finance-results">

                {{-- الملخص --}}
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon green-icon"><i class="fa-solid fa-arrow-down-long"></i></div>
                        <div class="stat-info">
                            <p>إجمالي الداخل</p>
                            <h3 class="ap-plus">{{ $fmt($income) }} ج.م</h3>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon ap-icon-red"><i class="fa-solid fa-arrow-up-long"></i></div>
                        <div class="stat-info">
                            <p>إجمالي الخارج</p>
                            <h3 class="ap-minus">{{ $fmt($expense) }} ج.م</h3>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon blue-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                        <div class="stat-info">
                            <p>الصافي</p>
                            <h3 class="{{ $net < 0 ? 'ap-minus' : 'ap-plus' }}">
                                {{ $net < 0 ? '−' : '' }}{{ $fmt(abs($net)) }} ج.م</h3>
                        </div>
                    </div>
                </div>

                <div class="ap-grid-2" style="margin-top:1rem">

                    {{-- التصنيفات --}}
                    <div class="dashboard-card ap-card">
                        <div class="ap-card__head">
                            <div>
                                <h3>حسب التصنيف</h3>
                                <p>في الفترة المحددة</p>
                            </div>
                        </div>
                        <div class="ap-card__body">
                            @forelse ($byCategory as $row)
                                @php
                                    $base = $row->type === 'income' ? max($income, 0.01) : max($expense, 0.01);
                                    $p = min(100, round(($row->total / $base) * 100));
                                @endphp
                                <div style="margin-bottom:1rem">
                                    <div
                                        style="display:flex;justify-content:space-between;gap:.5rem;font-size:.85rem;font-weight:800">
                                        <span>
                                            <span
                                                class="ap-badge {{ $row->type === 'income' ? 'ap-badge--ok' : 'ap-badge--bad' }}">{{ $row->type === 'income' ? 'داخل' : 'خارج' }}</span>
                                            {{ $labels[$row->category] ?? $row->category }} ({{ $row->n }})
                                        </span>
                                        <span>{{ $fmt($row->total) }} ج.م</span>
                                    </div>
                                    <div class="ap-meter {{ $row->type === 'income' ? '' : 'ap-meter--bad' }}"
                                        style="margin-top:.4rem"><span style="width: {{ max($p, 2) }}%"></span></div>
                                </div>
                            @empty
                                <x-home.banner.no_results logo="fa-solid fa-chart-pie" title="لا توجد تصنيفات"
                                    content="مفيش حركات في الفترة أو الفلاتر دي عشان نعرضها حسب التصنيف." />
                            @endforelse
                        </div>
                    </div>

                    {{-- آخر 6 شهور --}}
                    <div class="dashboard-card ap-card">
                        <div class="ap-card__head">
                            <div>
                                <h3>آخر 6 شهور</h3>
                                <p>بغض النظر عن الفلتر</p>
                            </div>
                        </div>
                        @if ($months->isEmpty())
                            <x-home.banner.no_results logo="fa-solid fa-calendar" title="لا توجد بيانات"
                                content="سجّل أول حركة عشان تظهر مقارنة آخر 6 شهور." />
                        @else
                            <div class="ap-table-wrap">
                                <table class="ap-table">
                                    <thead>
                                        <tr>
                                            <th>الشهر</th>
                                            <th>داخل</th>
                                            <th>خارج</th>
                                            <th>الصافي</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($months as $m)
                                            @php $n = $m->income - $m->expense; @endphp
                                            <tr>
                                                <td data-label="الشهر">
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $m->ym)->translatedFormat('F Y') }}
                                                </td>
                                                <td data-label="داخل"><span
                                                        class="ap-num ap-plus">{{ $fmt($m->income) }}</span></td>
                                                <td data-label="خارج"><span
                                                        class="ap-num ap-minus">{{ $fmt($m->expense) }}</span></td>
                                                <td data-label="الصافي"><span
                                                        class="ap-num {{ $n < 0 ? 'ap-minus' : 'ap-plus' }}">{{ $n < 0 ? '−' : '' }}{{ $fmt(abs($n)) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- الحركات --}}
                <div class="dashboard-card ap-card">
                    <div class="ap-card__head">
                        <div>
                            <h3>الحركات</h3>
                            <p>{{ $entries->total() }} حركة</p>
                        </div>
                    </div>

                    @if ($entries->isEmpty())
                        <x-home.banner.no_results logo="fa-solid fa-receipt" title="لا توجد حركات"
                            content="مفيش حركات بتطابق البحث أو الفلاتر دلوقتي. جرّب تغيّر الفلتر أو دوس على إضافة حركة." />
                    @else
                        <div class="ap-table-wrap">
                            <table class="ap-table">
                                <thead>
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>النوع</th>
                                        <th>التصنيف</th>
                                        <th>البيان</th>
                                        <th>المبلغ</th>
                                        <th>الحذف</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entries as $e)
                                        <tr>
                                            <td data-label="التاريخ">{{ $e->entry_date->translatedFormat('d M Y') }}</td>
                                            <td data-label="النوع"><span
                                                    class="ap-badge {{ $e->type === 'income' ? 'ap-badge--ok' : 'ap-badge--bad' }}">{{ $e->type === 'income' ? 'داخل' : 'خارج' }}</span>
                                            </td>
                                            <td data-label="التصنيف">{{ $e->category_label }}</td>
                                            <td data-label="البيان">
                                                <div>
                                                    <div class="ap-title">{{ $e->title }}</div>
                                                    @if ($e->note)
                                                        <div class="ap-sub">{{ $e->note }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td data-label="المبلغ"><span
                                                    class="ap-num {{ $e->type === 'income' ? 'ap-plus' : 'ap-minus' }}">{{ $e->type === 'income' ? '+' : '−' }}{{ $fmt($e->amount) }}
                                                    ج.م</span></td>
                                            <td data-label="">
                                                <form method="POST" action="{{ route('admin.finance.destroy', $e) }}"
                                                    onsubmit="return confirm('حذف الحركة دي نهائيًا؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="ap-btn ap-btn--danger ap-btn--sm"><i
                                                            class="fa-regular fa-trash-can"></i> حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="ap-card__foot">{{ $entries->links('vendor.pagination.custom') }}</div>
                    @endif
                </div>

            </div>

            {{-- مودال إضافة حركة --}}

            <div x-data="apFinance()" data-categories="{{ json_encode($categories) }}"
                data-old-type="{{ old('type', 'income') }}" data-old-category="{{ old('category') }}"
                data-has-errors="{{ $errors->financeStore->any() ? '1' : '0' }}" @ap-fin-open.window="show = true"
                x-cloak>
                <div x-show="show" class="ap-modal" @click.self="show = false" @keydown.escape.window="show = false">
                    <form method="POST" action="{{ route('admin.finance.store') }}"
                        class="dashboard-card ap-modal__panel" @submit="busy = true">
                        @csrf

                        <div class="ap-modal__head">
                            <h3>إضافة حركة</h3>
                            <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm"
                                @click="show = false">إغلاق</button>
                        </div>

                        @if ($errors->financeStore->any())
                            <div class="ap-alert ap-alert--bad" style="margin-bottom:1rem">
                                <ul>
                                    @foreach ($errors->financeStore->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="ap-seg" style="width:100%;margin-bottom:1rem">
                            <button type="button" style="flex:1" :class="type === 'income' ? 'is-active' : ''"
                                @click="setType('income')">داخل</button>
                            <button type="button" style="flex:1" :class="type === 'expense' ? 'is-active' : ''"
                                @click="setType('expense')">خارج</button>
                        </div>
                        <input type="hidden" name="type" :value="type">

                        <div class="ap-form-grid ap-form-grid--2">
                            <div class="ap-field">
                                <label>التصنيف</label>
                                <select name="category" x-model="category" class="ap-input" required>
                                    <template x-for="(label, key) in cats[type]" :key="key">
                                        <option :value="key" x-text="label" :selected="key === category">
                                        </option>
                                    </template>
                                </select>
                            </div>
                            <div class="ap-field">
                                <label>التاريخ</label>
                                <input type="date" name="entry_date"
                                    value="{{ old('entry_date', now('Africa/Cairo')->toDateString()) }}" class="ap-input"
                                    required>
                            </div>
                            <div class="ap-field" style="grid-column:1/-1">
                                <label>البيان</label>
                                <input type="text" name="title" value="{{ old('title') }}" maxlength="150"
                                    class="ap-input" placeholder="مثال: اشتراك د. أحمد - باقة Clinic System" required>
                            </div>
                            <div class="ap-field">
                                <label>المبلغ (ج.م)</label>
                                <input type="number" name="amount" value="{{ old('amount') }}" step="0.01"
                                    min="0.01" class="ap-input" required>
                            </div>
                            <div class="ap-field">
                                <label>ملاحظة (اختياري)</label>
                                <input type="text" name="note" value="{{ old('note') }}" maxlength="1000"
                                    class="ap-input">
                            </div>
                        </div>

                        <div class="ap-modal__foot">
                            <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy">حفظ
                                الحركة</button>
                            <button type="button" class="ap-btn ap-btn--ghost" @click="show = false">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('extra_java')
    <script src="{{ asset('js/admin/finance.js') }}?v={{ filemtime(public_path('js/admin/finance.js')) }}"></script>
@endpush

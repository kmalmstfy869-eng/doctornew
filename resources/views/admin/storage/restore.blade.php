@extends('admin.layout.app')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
@endpush

@section('title', 'استرجاع ملفات المرضى | لوحة الإدارة')
@section('page-title', 'استرجاع ملفات المرضى')
@section('page-description', 'استرجاع ملف معين أو الملفات الناقصة من النسخة الاحتياطية')

@section('content')

    @include('admin.storage._nav')

    @if ($errors->any())
        <div class="ap-alert ap-alert--bad">
            <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- ===== أ) استرجاع جماعي ===== --}}
    <div class="dashboard-card ap-card">
        <div class="ap-card__head">
            <div>
                <h3>استرجاع الملفات الناقصة</h3>
                <p>بيرجّع الملفات اللي مش موجودة في الـ Primary من النسخة الاحتياطية. الملفات اللي اتحذفت عمدًا مش بتتسترجع هنا.</p>
            </div>

            <form method="POST" action="{{ route('admin.storage.restore.preview') }}" x-data="{ busy: false }" @submit="busy = true">
                @csrf
                <button type="submit" class="ap-btn ap-btn--ghost" :disabled="busy">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span x-text="busy ? 'جاري الفحص...' : 'معاينة اللي هيتسترجع'">معاينة اللي هيتسترجع</span>
                </button>
            </form>
        </div>

        @if ($preview)
            <div class="ap-card__body">
                <div class="ap-kv">
                    <div><span>هيتسترجع</span><b>{{ $preview['count'] }}</b></div>
                    <div><span>موجود وسليم (هيتخطى)</span><b>{{ $preview['skipped'] }}</b></div>
                    <div><span>مشاكل في الفحص</span><b>{{ $preview['failed'] }}</b></div>
                </div>

                @if ($preview['count'] > 0)
                    <details style="margin-top:1rem">
                        <summary style="cursor:pointer;font-weight:800">أسماء الملفات اللي هتتسترجع</summary>
                        <ul style="margin-top:.5rem;padding-inline-start:1.2rem;font-size:.85rem">
                            @foreach ($preview['items'] as $n)<li>{{ $n }}</li>@endforeach
                            @if ($preview['more'] > 0)<li>و {{ $preview['more'] }} ملف تانيين</li>@endif
                        </ul>
                    </details>

                    <form method="POST" action="{{ route('admin.storage.restore.all') }}" x-data="{ busy: false }"
                        @submit="if (confirm('هيتم استرجاع {{ $preview['count'] }} ملف للتخزين الأساسي. متأكد؟')) { busy = true } else { $event.preventDefault() }"
                        style="margin-top:1rem">
                        @csrf
                        <label class="ap-check" style="color:inherit;margin-bottom:.75rem">
                            <input type="checkbox" name="confirm" value="1" required>
                            أؤكد استرجاع الملفات الناقصة (النسخة الاحتياطية الأصلية بتفضل زي ما هي)
                        </label>
                        <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span x-text="busy ? 'جاري الاسترجاع... متقفلش الصفحة' : 'استرجاع الناقص'">استرجاع الناقص</span>
                        </button>
                    </form>
                @else
                    <div class="ap-alert ap-alert--ok" style="margin-top:1rem">مفيش ملفات ناقصة، كله موجود.</div>
                @endif

                @if (! empty($preview['errors']))
                    <div class="ap-alert ap-alert--warn" style="margin-top:1rem">
                        مشاكل أثناء الفحص:
                        <ul>@foreach ($preview['errors'] as $e)<li>{{ $e['name'] }}: {{ $e['error'] }}</li>@endforeach</ul>
                    </div>
                @endif
            </div>
        @endif

        @if ($result)
            <div class="ap-card__body" style="border-top:1px solid rgba(127,127,127,.18)">
                <h4 style="margin:0 0 .75rem;font-weight:800">نتيجة آخر استرجاع جماعي</h4>
                <div class="ap-kv">
                    <div><span>اتسترجع</span><b class="ap-plus">{{ $result['restored'] }}</b></div>
                    <div><span>اتخطى</span><b>{{ $result['skipped'] }}</b></div>
                    <div><span>فشل</span><b class="{{ $result['failed'] ? 'ap-minus' : '' }}">{{ $result['failed'] }}</b></div>
                </div>

                @if (! empty($result['errors']))
                    <div class="ap-alert ap-alert--bad" style="margin-top:1rem">
                        تفاصيل الفشل:
                        <ul>@foreach ($result['errors'] as $e)<li>{{ $e['name'] }}: {{ $e['error'] }}</li>@endforeach</ul>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- ===== ب) استرجاع ملف معين ===== --}}
    <div x-data>
        <div class="dashboard-card ap-card">

            <div class="ap-card__head">
                <div>
                    <h3>استرجاع ملف معين</h3>
                    <p id="ap-count">{{ $rows->total() }} نسخة احتياطية</p>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.storage.restore') }}" class="ap-filters">
                <div class="ap-field ap-field--grow">
                    <label>بحث</label>
                    <input type="text" name="search" value="{{ $search }}" class="ap-input" autocomplete="off"
                        placeholder="اسم الملف أو المريض أو الدكتور"
                        data-live-search data-live-search-url="{{ route('admin.storage.restore') }}"
                        data-live-search-target="#ap-list" data-live-search-pagination="#ap-pagination"
                        data-live-search-count="#ap-count" data-live-search-preserve="#f-scope">
                </div>
                <div class="ap-field">
                    <label>عرض</label>
                    <select name="scope" id="f-scope" class="ap-input" onchange="this.form.submit()">
                        <option value="">كل النسخ</option>
                        <option value="deleted" @selected($scope === 'deleted')>الأصل اتحذف عمدًا</option>
                        <option value="no_record" @selected($scope === 'no_record')>سجل الداتابيز ناقص</option>
                    </select>
                </div>
                <a href="{{ route('admin.storage.restore') }}" class="ap-btn ap-btn--ghost">مسح الفلاتر</a>
            </form>

            <div id="ap-list">
                @include('admin.storage._restore_list')
            </div>

            <div id="ap-pagination" class="ap-card__foot">{{ $rows->links('vendor.pagination.custom') }}</div>

        </div>
    </div>

@endsection

@push('extra_java')
    <script src="{{ asset('js/clinic/live_search.js') }}"></script>
@endpush

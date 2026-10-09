@extends('admin.layout.app')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
@endpush

@section('title', 'مساحات الأطباء | لوحة الإدارة')
@section('page-title', 'مساحات الأطباء')
@section('page-description', 'تابع استهلاك ملفات المرضى لكل طبيب')

@section('content')

    @include('admin.storage._nav')

    @if ($errors->any())
        <div class="ap-alert ap-alert--bad">
            <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="dashboard-card ap-card">

        <div class="ap-card__head">
            <div>
                <h3>مساحات الأطباء</h3>
                <p id="ap-count">{{ $doctors->total() }} طبيب • المساحة الأساسية {{ rtrim(rtrim(number_format($defaultGb, 2), '0'), '.') }} GB + اشتراكات المساحة</p>
            </div>
            <a href="{{ route('admin.storage.extra.index') }}" class="ap-btn ap-btn--primary">
                <i class="fa-solid fa-cubes-stacked"></i> اشتراكات المساحة
            </a>
        </div>

        <form method="GET" action="{{ route('admin.storage.quotas') }}" class="ap-filters">
            <div class="ap-field ap-field--grow">
                <label>بحث</label>
                <input type="text" name="search" value="{{ $search }}" class="ap-input" autocomplete="off"
                    placeholder="اسم الدكتور أو الإيميل"
                    data-live-search data-live-search-url="{{ route('admin.storage.quotas') }}"
                    data-live-search-target="#ap-list" data-live-search-pagination="#ap-pagination"
                    data-live-search-count="#ap-count" data-live-search-preserve="#f-limit,#f-sort">
            </div>
            <div class="ap-field">
                <label>الاستهلاك</label>
                <select name="limit" id="f-limit" class="ap-input" onchange="this.form.submit()">
                    <option value="">الكل</option>
                    <option value="attention" @selected($limit === 'attention')>قرب من الحد أو ممتلئ</option>
                    <option value="near" @selected($limit === 'near')>قرب من الحد</option>
                    <option value="full" @selected($limit === 'full')>ممتلئ</option>
                </select>
            </div>
            <div class="ap-field">
                <label>الترتيب</label>
                <select name="sort" id="f-sort" class="ap-input" onchange="this.form.submit()">
                    <option value="percent" @selected($sort === 'percent')>نسبة الاستهلاك</option>
                    <option value="used" @selected($sort === 'used')>المساحة المستخدمة</option>
                    <option value="name" @selected($sort === 'name')>الاسم</option>
                </select>
            </div>
            <a href="{{ route('admin.storage.quotas') }}" class="ap-btn ap-btn--ghost">مسح الفلاتر</a>
        </form>

        <div id="ap-list">
            @include('admin.storage._quotas_list')
        </div>

        <div id="ap-pagination" class="ap-card__foot">{{ $doctors->links('vendor.pagination.custom') }}</div>

    </div>

@endsection

@push('extra_java')
    <script src="{{ asset('js/clinic/live_search.js') }}"></script>
@endpush

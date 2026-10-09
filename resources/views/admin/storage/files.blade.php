@extends('admin.layout.app')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
@endpush

@section('title', 'الملفات والنسخ | لوحة الإدارة')
@section('page-title', 'الملفات والنسخ الاحتياطية')
@section('page-description', 'اعرف كل ملف اتنسخ ولا لأ، واسترجع اللي ناقص')

@section('content')

    @include('admin.storage._nav')

    {{-- x-data فاضي: عشان أزرار الجدول تشتغل حتى بعد إعادة رسمها من البحث الحي --}}
    <div x-data>

        <div class="dashboard-card ap-card">

            <div class="ap-card__head">
                <div>
                    <h3>{{ $view === 'deleted' ? 'نسخ الملفات المحذوفة من الـ Primary' : 'ملفات المرضى' }}</h3>
                    <p id="ap-count">{{ $rows->total() }} {{ $view === 'deleted' ? 'نسخة' : 'ملف' }}</p>
                </div>

                <div class="ap-seg">
                    <a href="{{ route('admin.storage.files') }}" class="{{ $view === 'current' ? 'is-active' : '' }}">الملفات الحالية</a>
                    <a href="{{ route('admin.storage.files', ['view' => 'deleted']) }}" class="{{ $view === 'deleted' ? 'is-active' : '' }}">الأصل اتحذف</a>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.storage.files') }}" class="ap-filters">
                <input type="hidden" name="view" id="f-view" value="{{ $view }}">

                <div class="ap-field ap-field--grow">
                    <label>بحث</label>
                    <input type="text" name="search" value="{{ $search }}" class="ap-input" autocomplete="off"
                        placeholder="اسم الملف أو المريض أو الدكتور أو رقم الملف"
                        data-live-search data-live-search-url="{{ route('admin.storage.files') }}"
                        data-live-search-target="#ap-list" data-live-search-pagination="#ap-pagination"
                        data-live-search-count="#ap-count"
                        data-live-search-preserve="#f-view,#f-doctor,#f-status,#f-type,#f-from,#f-to">
                </div>

                <div class="ap-field">
                    <label>الدكتور</label>
                    <select name="doctor_id" id="f-doctor" class="ap-input" onchange="this.form.submit()">
                        <option value="">الكل</option>
                        @foreach ($doctors as $d)
                            <option value="{{ $d->id }}" @selected((int) request('doctor_id') === $d->id)>د. {{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>

                @if ($view === 'current')
                    <div class="ap-field">
                        <label>حالة النسخ</label>
                        <select name="status" id="f-status" class="ap-input" onchange="this.form.submit()">
                            <option value="">الكل</option>
                            <option value="done" @selected(request('status') === 'done')>اتنسخ</option>
                            <option value="pending" @selected(request('status') === 'pending')>لسه ما اتنسخش</option>
                            <option value="failed" @selected(request('status') === 'failed')>فشل النسخ</option>
                        </select>
                    </div>
                @endif

                <div class="ap-field">
                    <label>النوع</label>
                    <select name="type" id="f-type" class="ap-input" onchange="this.form.submit()">
                        <option value="">الكل</option>
                        <option value="pdf" @selected(request('type') === 'pdf')>PDF</option>
                        <option value="image" @selected(request('type') === 'image')>صورة</option>
                    </select>
                </div>

                <div class="ap-field">
                    <label>من ({{ $view === 'deleted' ? 'تاريخ الحذف' : 'تاريخ الرفع' }})</label>
                    <input type="date" name="from" id="f-from" value="{{ request('from') }}" class="ap-input" onchange="this.form.submit()">
                </div>

                <div class="ap-field">
                    <label>إلى</label>
                    <input type="date" name="to" id="f-to" value="{{ request('to') }}" class="ap-input" onchange="this.form.submit()">
                </div>

                <a href="{{ route('admin.storage.files', ['view' => $view]) }}" class="ap-btn ap-btn--ghost">مسح الفلاتر</a>
            </form>

            <div id="ap-list">
                @include('admin.storage._files_list')
            </div>

            <div id="ap-pagination" class="ap-card__foot">
                {{ $rows->links('vendor.pagination.custom') }}
            </div>

        </div>
    </div>

@endsection

@push('extra_java')
    <script src="{{ asset('js/clinic/live_search.js') }}"></script>
@endpush

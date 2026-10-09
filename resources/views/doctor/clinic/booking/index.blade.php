@extends('doctor.layouts.app_clinc')

@section('title', 'الحجوزات والطابور | دليل الأطباء')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
    @if ($isClinicSystem)
        <link rel="stylesheet" href="{{ asset('css/doctor/clinic/clinic-live-messages.css') }}">
    @endif
@endpush
    @once('modal-variants-css')
        @push('extra_style')
            <link rel="stylesheet" href="{{ asset('css/clinic/modal_variants.css') }}">
        @endpush
    @endonce
@section('content')

    <div class="w-full min-w-0 px-4 py-6 sm:px-6 lg:px-8">

        <div class="mx-auto w-full max-w-[1360px]">

            {{-- مركز الرسائل المباشرة (طبيب <-> مساعد) — بيتملى بالـ JS --}}
            @if ($isClinicSystem)
                <div id="clinic-live-messages" class="clinic-live-messages" hidden></div>
            @endif

            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <div class="mb-2 flex items-center gap-2 text-sm text-muted-foreground">

                        <span>
                            نظام العيادة
                        </span>

                        <i data-lucide="chevron-left" class="h-4 w-4"></i>

                        <span class="text-foreground">
                            الحجوزات والطابور
                        </span>

                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-foreground sm:text-3xl">
                        الحجوزات والطابور
                    </h1>

                    <p class="mt-1 text-sm text-muted-foreground">
                        إدارة الحجوزات ومتابعة المرضى وتنظيم طابور العيادة.
                    </p>

                </div>

                <div class="flex flex-wrap items-center gap-2">

                    <button type="button" class="btn btn-default" data-modal-open="new-booking-modal">

                        <i data-lucide="plus" class="h-4 w-4"></i>

                        حجز جديد

                    </button>

                </div>

            </div>


            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                <div class="stat-card">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-sm text-muted-foreground">
                                في الطابور
                            </p>

                            <p id="stat-queue-count" class="mt-1 text-2xl font-bold text-foreground">
                                {{ $queueCount }}
                            </p>

                        </div>

                        <div class="badge-warning flex h-11 w-11 items-center justify-center rounded-xl">

                            <i data-lucide="users-round" class="h-5 w-5"></i>

                        </div>

                    </div>

                </div>


                <div class="stat-card">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-sm text-muted-foreground">
                                داخل الكشف
                            </p>

                            <p id="stat-exam-count" class="mt-1 text-2xl font-bold text-foreground">
                                {{ $examCount }}
                            </p>

                        </div>

                        <div class="badge-purple flex h-11 w-11 items-center justify-center rounded-xl">

                            <i data-lucide="stethoscope" class="h-5 w-5"></i>

                        </div>

                    </div>

                </div>


                <div class="stat-card">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-sm text-muted-foreground">
                                تم الكشف اليوم
                            </p>

                            <p id="stat-done-count" class="mt-1 text-2xl font-bold text-foreground">
                                {{ $doneCount }}
                            </p>

                        </div>

                        <div class="badge-success flex h-11 w-11 items-center justify-center rounded-xl">

                            <i data-lucide="circle-check-big" class="h-5 w-5"></i>

                        </div>

                    </div>

                </div>


                <div class="stat-card">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-sm text-muted-foreground">
                                حجوزات اليوم
                            </p>

                            <p id="stat-total-count" class="mt-1 text-2xl font-bold text-foreground">
                                {{ $total }}
                            </p>

                        </div>

                        <div class="badge-info flex h-11 w-11 items-center justify-center rounded-xl">

                            <i data-lucide="calendar-days" class="h-5 w-5"></i>

                        </div>

                    </div>

                </div>

            </div>


            <div class="mb-6">

                <div class="clinic-surface-card overflow-hidden">

                    <div class="section-card-header">

                        <div>

                            <h2 class="text-lg font-bold text-foreground">
                                المريض الحالي
                            </h2>

                            <p class="mt-1 text-sm text-muted-foreground">
                                المريض الموجود حاليًا داخل الكشف.
                            </p>

                        </div>

                        <span class="badge badge-purple">

                            <i data-lucide="stethoscope" class="h-3.5 w-3.5"></i>

                            داخل الكشف

                        </span>

                    </div>


                    <div class="p-4 sm:p-5">

                        <div id="current-exam-list">

                            @foreach ($currentExam as $exam)
                                <div class="bq-current-card @if (!$loop->last) mb-4 @endif">

                                    <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">

                                        <div class="flex min-w-0 items-center gap-4">

                                            <div
                                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-primary-soft text-primary">

                                                <i data-lucide="user-round" class="h-7 w-7"></i>

                                            </div>

                                            <div class="min-w-0">

                                                <div class="flex flex-wrap items-center gap-2">

                                                    <h3 class="truncate text-lg font-bold text-foreground">
                                                        {{ $exam->patient_name ?? 'مريض بدون اسم' }}
                                                    </h3>

                                                    <span class="badge badge-purple">
                                                        داخل الكشف
                                                    </span>

                                                </div>

                                                <div
                                                    class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-sm text-muted-foreground">

                                                    @if ($exam->service)
                                                        <span class="flex items-center gap-1.5">

                                                            <i data-lucide="stethoscope" class="h-3.5 w-3.5"></i>

                                                            {{ $exam->service }}

                                                        </span>
                                                    @endif

                                                    @if ($exam->started_at)
                                                        <span class="flex items-center gap-1.5">

                                                            <i data-lucide="clock-3" class="h-3.5 w-3.5"></i>

                                                            بدأ {{ $exam->started_at->format('H:i') }}

                                                        </span>
                                                    @endif

                                                    @if ($exam->patient_phone)
                                                        <span class="flex items-center gap-1.5">

                                                            <i data-lucide="phone" class="h-3.5 w-3.5"></i>

                                                            {{ $exam->patient_phone }}

                                                        </span>
                                                    @endif

                                                </div>

                                            </div>

                                        </div>


                                        <div class="flex flex-wrap gap-2">

                                            @if ($exam->patient_id && $isClinicSystem)
                                                <a href="{{ route('clinic.patients.show', $exam->patient_id) }}"
                                                    class="btn btn-outline">

                                                    <i data-lucide="folder-open" class="h-4 w-4"></i>

                                                    ملف المريض

                                                </a>
                                            @endif

                                            <form method="POST" action="{{ route('clinic.bookings.finish', $exam) }}">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-default">

                                                    <i data-lucide="circle-check-big" class="h-4 w-4"></i>

                                                    إنهاء الكشف

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>


                        <div id="current-exam-empty" class="{{ $currentExam->count() ? 'hidden' : '' }}">

                            <x-home.banner.no_results logo="fa-solid fa-user-doctor" title="لا يوجد مريض داخل الكشف"
                                content="عند بدء الكشف على أحد المرضى من طابور الانتظار سيظهر هنا." />

                        </div>

                    </div>

                </div>

            </div>


            <div class="mb-6">

                <div class="clinic-surface-card overflow-hidden">

                    <div class="section-card-header">

                        <div>

                            <h2 class="text-lg font-bold text-foreground">
                                طابور الانتظار
                            </h2>

                            <p class="mt-1 text-sm text-muted-foreground">
                                ترتيب المرضى الحالي في الطابور.
                            </p>

                        </div>

                        <span id="queue-count-badge" class="badge badge-warning">

                            {{ $queueCount }}

                            {{ $queueCount == 1 ? 'مريض' : 'مرضى' }}

                        </span>

                    </div>


                    <div class="p-4 sm:p-5">

                        <div id="queue-list">

                            @foreach ($queuePatients as $booking)
                                <div class="clinic-surface-card mb-3 border border-border p-4 last:mb-0">

                                    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

                                        <div class="flex min-w-0 items-center gap-3">

                                            <div class="bq-queue-num">
                                                {{ $loop->iteration }}
                                            </div>

                                            <div class="bq-queue-info">

                                                <div class="bq-queue-title">
                                                    @if ($isClinicSystem && $booking->patient_id)
                                                        <a href="{{ route('clinic.patients.show', $booking->patient_id) }}"
                                                            class="text-xl font-semibold text-primary hover:underline">

                                                            {{ $booking->patient_name }}

                                                        </a>
                                                    @else
                                                        <p class="text-xl font-semibold">
                                                            {{ $booking->patient_name }}
                                                        </p>
                                                    @endif
                                                    <span
                                                        class="badge {{ $booking->booking_type === 'online' ? 'badge-primary' : 'badge-purple' }}">
                                                        {{ $booking->booking_type === 'online' ? 'أونلاين' : 'من العيادة' }}
                                                    </span>

                                                    @if ($booking->booking_type === 'online' && $booking->arrival_status)
                                                        <span class="badge badge-success">
                                                            {{ $booking->arrival_status }}
                                                        </span>
                                                    @endif

                                                </div>

                                                <div class="bq-queue-meta">

                                                    <span class="bq-queue-meta-item bq-queue-service">
                                                        <i data-lucide="clipboard-list"></i>
                                                        <span>{{ $booking->service ?? 'لم تحدد' }}</span>
                                                    </span>

                                                    @if ($booking->start_time)
                                                        <span class="bq-queue-meta-item">
                                                            <i data-lucide="clock-3"></i>
                                                            <span>
                                                                موعد:
                                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
                                                            </span>
                                                        </span>
                                                    @endif

                                                    @if ($booking->arrived_at)
                                                        <span class="bq-queue-meta-item">
                                                            <i data-lucide="log-in"></i>
                                                            <span>
                                                                وصول:
                                                                {{ $booking->arrived_at->format('h:i A') }}
                                                            </span>
                                                        </span>
                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                        <div class="bq-queue-actions">

                                            @if ($isClinicSystem && $booking->patient_id)
                                                <a href="{{ route('clinic.patients.show', $booking->patient_id) }}"
                                                    class="btn btn-outline btn-sm">

                                                    <i data-lucide="folder-open" class="h-4 w-4"></i>

                                                    ملف المريض

                                                </a>
                                            @endif

                                            <form method="POST" action="{{ route('clinic.bookings.call', $booking) }}">

                                                @csrf

                                                <button type="submit" class="btn btn-outline btn-sm">

                                                    <i data-lucide="megaphone" class="h-4 w-4"></i>

                                                    استدعاء

                                                </button>

                                            </form>

                                            <form method="POST" action="{{ route('clinic.bookings.start', $booking) }}">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit" class="btn btn-default btn-sm">

                                                    <i data-lucide="stethoscope" class="h-4 w-4"></i>

                                                    بدء الكشف

                                                </button>

                                            </form>

                                            <button type="button" class="btn btn-destructive" aria-label="حذف الحجز"
                                                data-cancel-booking="{{ $booking->id }}"
                                                data-cancel-name="{{ $booking->patient_name }}">

                                                <i data-lucide="trash-2" class="size-4">
                                                </i>

                                            </button>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                        <div id="queue-empty" class="{{ $queuePatients->count() ? 'hidden' : '' }}">

                            <x-home.banner.no_results logo="fa-solid fa-users-slash" title="الطابور فارغ حالياً"
                                content="لا يوجد مرضى في طابور الانتظار في الوقت الحالي." />

                        </div>

                    </div>

                </div>

            </div>


            <div class="clinic-surface-card overflow-hidden">

                <div class="section-card-header">

                    <div>

                        <h2 class="text-lg font-bold text-foreground">
                            الحجوزات
                        </h2>

                        <p class="mt-1 text-sm text-muted-foreground">
                            جميع الحجوزات وحالة كل حجز.
                        </p>

                    </div>


                    <a href="{{ route('clinic.history') }}" class="btn btn-default">
                        <i data-lucide="history" class="h-4 w-4"></i>
                        سجل الحجوزات
                    </a>

                </div>


                <form method="GET" action="{{ route('clinic.bookings.index') }}"
                    class="bq-toolbar border-b border-border p-4">

                    <div class="relative flex min-w-0 flex-1 items-center">

                        <input name="search" type="text" class="field-input w-full pl-24 pr-4"
                            value="{{ request('search') }}" placeholder="ابحث باسم المريض أو الهاتف...">

                        @if (request('search') || request('status') || request('source'))
                            <a href="{{ route('clinic.bookings.index') }}"
                                class="btn btn-destructive btn-sm absolute left-2 z-10 flex items-center justify-center gap-1"
                                title="إلغاء البحث">

                                <span class="text-xs font-bold leading-none">
                                    ✕
                                </span>

                            </a>
                        @endif

                    </div>


                    <select name="status" class="field-select">

                        <option value="" @selected(request('status', '') === '')>
                            كل الحالات
                        </option>

                        <option value="pending" @selected(request('status') === 'pending')>
                            في انتظار الحضور
                        </option>

                        <option value="confirmed" @selected(request('status') === 'confirmed')>
                            حضر للعيادة
                        </option>

                        <option value="in_progress" @selected(request('status') === 'in_progress')>
                            داخل الكشف
                        </option>

                        <option value="completed" @selected(request('status') === 'completed')>
                            تم الكشف
                        </option>

                        <option value="no_show" @selected(request('status') === 'no_show')>
                            لم يحضر
                        </option>

                        <option value="cancelled" @selected(request('status') === 'cancelled')>
                            ملغي
                        </option>

                    </select>


                    <select name="source" class="field-select">

                        <option value="" @selected(request('source', '') === '')>
                            كل المصادر
                        </option>

                        <option value="online" @selected(request('source') === 'online')>
                            أونلاين
                        </option>

                        <option value="clinic" @selected(request('source') === 'clinic')>
                            من العيادة
                        </option>

                    </select>


                    <button type="submit" class="btn btn-default">

                        <i data-lucide="search" class="h-4 w-4"></i>

                        بحث

                    </button>

                </form>


                <div class="border-b border-border px-4 py-3 sm:px-5">

                    <span id="bookings-count-label" class="text-sm text-muted-foreground">

                        {{ $bookings->total() }}

                        {{ $bookings->total() == 1 ? 'حجز' : 'حجوزات' }}

                    </span>

                </div>


                <div class="hidden overflow-x-auto lg:block">

                    <table class="clinic-table w-full">

                        <thead>

                            <tr>

                                <th>المريض</th>
                                <th>الحجز</th>
                                <th>الخدمة</th>
                                <th>المصدر</th>
                                <th>التاريخ</th>
                                <th>موعد الدخول المتوقع</th>
                                <th>الدفع</th>
                                <th>الحالة</th>
                                <th class="text-center">إجراءات</th>

                            </tr>

                        </thead>


                        <tbody id="bookings-tbody">
                            @include('doctor.clinic.booking.partials.table-body', [
                                'bookings' => $bookings,
                                'isClinicSystem' => $isClinicSystem,
                            ])
                        </tbody>

                    </table>

                </div>


                <div id="bookings-mobile-list" class="grid gap-3 p-4 lg:hidden">
                    @include('doctor.clinic.booking.partials.mobile-cards', [
                        'bookings' => $bookings,
                        'isClinicSystem' => $isClinicSystem,
                    ])
                </div>


                <div id="bookings-pagination-wrapper">
                    @include('doctor.clinic.booking.partials.pagination', ['bookings' => $bookings])
                </div>

            </div>

        </div>

    </div>


    {{-- حجز جديد (create variant) --}}

    <div id="new-booking-modal" class="modal-overlay">

        <div class="modal-panel modal-lg modal-panel--create">

            <div class="modal-head">

                <span class="modal-head__icon">
                    <i data-lucide="calendar-plus" class="h-5 w-5"></i>
                </span>

                <div class="min-w-0 flex-1">

                    <h3 class="modal-head__title">
                        حجز جديد
                    </h3>

                    <p class="modal-head__sub">
                        أضف حجزًا جديدًا للمريض.
                    </p>

                </div>

                <button type="button" class="btn btn-icon" data-modal-close>

                    <i data-lucide="x" class="h-5 w-5"></i>

                </button>

            </div>


            <form method="POST" action="{{ route('clinic.bookings.store') }}" id="new-booking-form">

                @csrf

                @if ($isClinicSystem)
                    <div class="mb-5">

                        <label class="field-label mb-2">
                            نوع المريض
                        </label>

                        <div class="bq-mode-switch">

                            <button type="button" id="mode-existing" class="bq-mode-btn">

                                <i data-lucide="user-round-check" class="h-5 w-5"></i>

                                <span>
                                    مريض موجود
                                </span>

                            </button>

                            <button type="button" id="mode-new" class="bq-mode-btn">

                                <i data-lucide="user-round-plus" class="h-5 w-5"></i>

                                <span>
                                    مريض جديد
                                </span>

                            </button>

                        </div>

                    </div>


                    <div id="existing-patient-fields">

                        <label class="field-label">
                            البحث عن المريض
                        </label>

                        <div class="relative mt-2">

                            <input id="patient-search" type="text" class="field-input pr-10" autocomplete="off"
                                placeholder="ابحث بالاسم أو رقم الهاتف...">

                        </div>

                        <div id="patient-search-results"
                            class="hidden mt-2 max-h-56 overflow-y-auto rounded-xl border border-border bg-card divide-y divide-border">
                        </div>

                        <input type="hidden" name="patient_id" id="patient-select" value="{{ old('patient_id') }}">

                        @error('patient_id')
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    {{ $message }}
                                </span>

                            </p>
                        @enderror

                        <div id="patient-selected-info" class="mt-3 hidden rounded-xl border border-border bg-muted p-4">

                            <div class="flex items-center justify-between gap-3">

                                <div class="min-w-0">

                                    <p id="patient-selected-name" class="truncate font-semibold text-foreground"></p>

                                    <p id="patient-selected-phone" class="mt-1 text-xs text-muted-foreground"></p>

                                </div>

                                <button type="button" id="patient-selected-clear" class="btn btn-outline btn-sm">
                                    تغيير
                                </button>

                            </div>

                        </div>

                    </div>


                    <div id="new-patient-fields">

                        <label class="field-label">
                            اسم المريض
                        </label>

                        <div class="relative mt-2">

                            <input name="new_patient_name" id="new-patient-name" type="text"
                                class="field-input pr-10 @error('new_patient_name') border-red-500 @enderror"
                                placeholder="اكتب اسم المريض" value="{{ old('new_patient_name') }}">

                        </div>

                        @error('new_patient_name')
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    {{ $message }}
                                </span>

                            </p>
                        @enderror


                        <label class="field-label mt-4">
                            رقم الهاتف
                        </label>

                        <div class="relative mt-2">

                            <input name="patient_phone" id="new-patient-phone" type="text" inputmode="tel"
                                class="field-input pr-10 @error('patient_phone') border-red-500 @enderror"
                                placeholder="اكتب رقم الهاتف" value="{{ old('patient_phone') }}">

                        </div>

                        @error('patient_phone')
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    {{ $message }}
                                </span>

                            </p>
                        @enderror


                        <p class="mt-2 text-xs text-muted-foreground">
                            عند إدخال رقم الهاتف، سيتم إنشاء ملف طبي للمريض تلقائيًا، ويمكنك استخدامه لاحقًا في متابعة
                            بياناته وحجوزاته.
                        </p>

                    </div>
                @else
                    <div>

                        <label class="field-label">
                            اسم المريض
                        </label>

                        <div class="relative mt-2">

                            <input name="new_patient_name" id="new-patient-name" type="text"
                                class="field-input pr-10 @error('new_patient_name') border-red-500 @enderror"
                                placeholder="اكتب اسم المريض" value="{{ old('new_patient_name') }}">

                        </div>

                        @error('new_patient_name')
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    {{ $message }}
                                </span>

                            </p>
                        @enderror


                        <label class="field-label mt-4">
                            رقم الهاتف
                        </label>

                        <div class="relative mt-2">

                            <input name="patient_phone" id="new-patient-phone" type="text" inputmode="tel"
                                class="field-input pr-10 @error('patient_phone') border-red-500 @enderror"
                                placeholder="اكتب رقم الهاتف" value="{{ old('patient_phone') }}">

                        </div>

                        @error('patient_phone')
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    {{ $message }}
                                </span>

                            </p>
                        @enderror


                        <p class="mt-2 text-xs text-muted-foreground">
                            يتم تسجيل بيانات المريض مع الحجز فقط.
                        </p>

                    </div>
                @endif


                <div class="mt-5">

                    <label class="field-label">
                        الخدمة
                    </label>

                    <select name="service" id="booking-service"
                        class="field-select mt-2 @error('service') border-red-500 @enderror">

                        <option value="">
                            اختر الخدمة
                        </option>

                        <option value="كشف" @selected(old('service') === 'كشف')>
                            كشف
                        </option>

                        <option value="استشارة" @selected(old('service') === 'استشارة')>
                            استشارة
                        </option>

                        <option value="متابعة" @selected(old('service') === 'متابعة')>
                            متابعة
                        </option>

                        <option value="إعادة كشف" @selected(old('service') === 'إعادة كشف')>
                            إعادة كشف
                        </option>

                        <option value="إجراء آخر" @selected(old('service') === 'إجراء آخر')>
                            إجراء آخر
                        </option>

                    </select>

                    @error('service')
                        <p class="bq-field-error">

                            <i data-lucide="circle-alert"></i>

                            <span>
                                {{ $message }}
                            </span>

                        </p>
                    @enderror

                </div>


                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-3">

                    <div>

                        <label class="field-label">
                            التاريخ
                        </label>

                        <input name="appointment_date" id="booking-date" type="date"
                            class="field-input mt-2 @error('appointment_date') border-red-500 @enderror"
                            value="{{ old('appointment_date', today()->format('Y-m-d')) }}" required>

                        @error('appointment_date')
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    {{ $message }}
                                </span>

                            </p>
                        @enderror

                    </div>


                    <div>

                        <label class="field-label">
                            السعر
                        </label>

                        <input name="price" id="booking-price" type="number" min="0" step="0.01"
                            class="field-input mt-2 @error('price') border-red-500 @enderror"
                            value="{{ old('price', 0) }}" required>

                        @error('price')
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    {{ $message }}
                                </span>

                            </p>
                        @enderror

                    </div>


                    <div>

                        <label class="field-label">
                            المبلغ المدفوع
                        </label>

                        <input name="paid" id="booking-paid" type="number" min="0" step="0.01"
                            class="field-input mt-2 @error('paid') border-red-500 @enderror" value="{{ old('paid', 0) }}"
                            required>

                        @error('paid')
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    {{ $message }}
                                </span>

                            </p>
                        @enderror

                    </div>

                </div>


                <div class="bq-pay-row mt-5">

                    <div>

                        <span class="text-sm text-muted-foreground">
                            إجمالي الحجز
                        </span>

                        <strong id="booking-total-preview" class="text-foreground">
                            {{ number_format((float) old('price', 0), 2) }} ج.م
                        </strong>

                    </div>


                    <div>

                        <span class="text-sm text-muted-foreground">
                            المدفوع
                        </span>

                        <strong id="booking-paid-preview" class="text-success">
                            {{ number_format((float) old('paid', 0), 2) }} ج.م
                        </strong>

                    </div>


                    <div>

                        <span class="text-sm text-muted-foreground">
                            المتبقي
                        </span>

                        <strong id="booking-remaining-preview" class="text-warning">

                            {{ number_format(max(0, (float) old('price', 0) - (float) old('paid', 0)), 2) }}

                            ج.م

                        </strong>

                    </div>

                </div>


                <div class="bq-modal-footer">

                    <button type="button" class="btn btn-ghost" data-modal-close>
                        إلغاء
                    </button>

                    <button type="submit" class="btn btn-default btn-submit">

                        <i data-lucide="calendar-plus" class="h-4 w-4"></i>

                        حفظ الحجز

                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- تعديل الخدمة (edit variant) --}}

    <div id="edit-service-modal" class="modal-overlay">

        <div class="modal-panel max-w-lg modal-panel--edit">

            <div class="modal-head">

                <span class="modal-head__icon">
                    <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                </span>

                <div class="min-w-0 flex-1">

                    <h3 class="modal-head__title">
                        تحديد الخدمة
                    </h3>

                    <p id="edit-service-patient" class="modal-head__sub"></p>

                </div>


                <button type="button" class="btn btn-icon" data-modal-close>

                    <i data-lucide="x" class="h-5 w-5"></i>

                </button>

            </div>


            <form method="POST" id="edit-service-form">

                @csrf
                @method('PATCH')


                <div>

                    <label class="field-label">
                        الخدمة
                    </label>

                    <select name="service" id="edit-service-select"
                        class="field-select mt-2 @error('service', 'service') border-red-500 @enderror">

                        <option value="">
                            لم تحدد
                        </option>

                        <option value="كشف">
                            كشف
                        </option>

                        <option value="استشارة">
                            استشارة
                        </option>

                        <option value="متابعة">
                            متابعة
                        </option>

                        <option value="إعادة كشف">
                            إعادة كشف
                        </option>

                        <option value="إجراء آخر">
                            إجراء آخر
                        </option>

                    </select>

                    @error('service', 'service')
                        <p class="bq-field-error">

                            <i data-lucide="circle-alert"></i>

                            <span>
                                {{ $message }}
                            </span>

                        </p>
                    @enderror

                </div>


                <p class="mt-3 text-xs text-muted-foreground">
                    يمكنك تحديد الخدمة الآن حتى لو لم يحددها المريض عند الحجز.
                </p>


                <div class="bq-modal-footer">

                    <button type="button" class="btn btn-ghost" data-modal-close>
                        إلغاء
                    </button>


                    <button type="submit" class="btn btn-primary btn-submit">

                        <i data-lucide="save" class="h-4 w-4"></i>

                        حفظ الخدمة

                    </button>

                </div>

            </form>

        </div>

    </div>



    <x-doctor.clinic.edit-payment-modal />

    {{-- إلغاء الحجز --}}

    <div id="cancel-booking-modal" class="modal-overlay">

        <div class="modal-panel max-w-lg">

            <div class="bq-modal-header">

                <div>

                    <h3 class="text-lg font-bold text-foreground">
                        إلغاء الحجز
                    </h3>

                    <p class="mt-1 text-sm text-muted-foreground">
                        هل تريد إلغاء هذا الحجز؟
                    </p>

                </div>


                <button type="button" class="btn btn-icon" data-modal-close>

                    <i data-lucide="x" class="h-5 w-5"></i>

                </button>

            </div>


            <div class="rounded-xl border border-destructive/20 bg-destructive/5 p-4">

                <div class="flex items-start gap-3">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-destructive/10 text-destructive">

                        <i data-lucide="triangle-alert" class="h-5 w-5"></i>

                    </div>


                    <div>

                        <p class="font-semibold text-foreground">
                            تأكيد إلغاء الحجز
                        </p>

                        <p id="cancel-booking-text" class="mt-1 text-sm leading-6 text-muted-foreground"></p>

                    </div>

                </div>

            </div>


            <div class="bq-modal-footer">

                <button type="button" class="btn btn-ghost" data-modal-close>
                    رجوع
                </button>


                <form method="POST" id="cancel-booking-form">

                    @csrf
                    @method('PATCH')

                    <button type="submit" class="btn btn-destructive">

                        <i data-lucide="trash-2" class="h-4 w-4"></i>

                        إلغاء الحجز

                    </button>

                </form>

            </div>

        </div>

    </div>


    <div id="toast-container" class="bq-toast-wrap"></div>


    @push('extra_java')
        @php
            // الرسائل المباشرة: لدكتور Clinic System ومساعديه الفعّالين بس
            $liveRole = $isClinicSystem
                ? \App\Models\ClinicMessage::roleFor(auth()->user(), auth()->user()->clinicDoctor())
                : null;

            $liveMessagesConfig = $liveRole
                ? [
                    'role' => $liveRole,
                    'indexUrl' => route('clinic.messages.index'),
                    'callUrlTemplate' => route('clinic.messages.call', ['booking' => '__BOOKING_ID__']),
                    'missingUrlTemplate' => route('clinic.messages.missing', ['booking' => '__BOOKING_ID__']),
                    'resolveUrlTemplate' => route('clinic.messages.resolve', ['message' => '__MESSAGE_ID__']),
                    'deleteUrlTemplate' => route('clinic.messages.destroy', ['message' => '__MESSAGE_ID__']),
                ]
                : null;
        @endphp

        <script>
            window.BookingPageConfig = {
                csrfToken: @json(csrf_token()),
                isClinicSystem: @json((bool) $isClinicSystem),
                queueDataUrl: @json(route('clinic.queue.data')),
                patientSearchUrl: @json(route('clinic.bookings.patients.search')),
                callUrlTemplate: @json(route('clinic.bookings.call', ['booking' => '__BOOKING_ID__'])),
                startUrlTemplate: @json(route('clinic.bookings.start', ['booking' => '__BOOKING_ID__'])),
                finishUrlTemplate: @json(route('clinic.bookings.finish', ['booking' => '__BOOKING_ID__'])),
                serviceUrlTemplate: @json(route('clinic.bookings.update-service', ['booking' => '__BOOKING_ID__'])),
                bookingsBaseUrl: @json(url('/clinic/bookings')),
                patientMode: @json(old('new_patient_name') || old('patient_phone') ? 'new' : 'existing'),
                hasNewBookingErrors: @json($errors->any() && !$errors->payment->any() && !$errors->service->any()),
                hasPaymentErrors: @json($errors->payment->any()),
                hasServiceErrors: @json($errors->service->any()),
                liveMessages: @json($liveMessagesConfig),
            };
        </script>


        <script src="{{ asset('js/clinic/booking-index.js') }}"></script>

        @if ($liveMessagesConfig)
            <script src="{{ asset('js/clinic/live-messages.js') }}"></script>
        @endif
    @endpush

@endsection
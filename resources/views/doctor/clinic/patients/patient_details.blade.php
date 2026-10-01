@extends('doctor.layouts.app_clinc')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/clinic/print.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/clinic/clinic-payments.css') }}">
@endpush

@section('title', 'بيانات المريض | دليل الأطباء')

@section('content')

    @php

        $documents = [
            [
                'id' => 'd1',
                'title' => 'تحليل صورة دم كاملة',
                'kind' => 'تحاليل',
                'dateLabel' => 'الخميس، 3 سبتمبر 2026',
                'size' => '220 KB',
            ],
            [
                'id' => 'd2',
                'title' => 'تقرير أشعة',
                'kind' => 'أشعة',
                'dateLabel' => 'الأحد، 30 أغسطس 2026',
                'size' => '1.8 MB',
            ],
        ];

        $fmtMoney = fn($n) => rtrim(rtrim(number_format((float) $n, 2, '.', ','), '0'), '.');

    @endphp


    <x-doctor.clinic.print-letterhead :doctor="$doctor" />

    <x-doctor.clinic.visit-form :patient="$patient" :show-trigger="false" :action="route('clinic.visits.store')" method="POST">

        <main id="patient-print-area" class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

            {{-- =========================================================
                 Patient Header
            ========================================================== --}}

            <div class="clinic-surface-card mb-4 overflow-hidden">

                <div class="p-4 sm:p-6">

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Patient Identity --}}
                        <div class="flex min-w-0 items-start gap-4">

                            <div
                                class="grid size-16 shrink-0 place-items-center rounded-2xl bg-primary-soft text-xl font-bold text-primary sm:size-[72px] sm:text-2xl">

                                {{ mb_substr($patient->name, 0, 2) }}

                            </div>

                            <div class="min-w-0">

                                <h1 class="text-xl font-bold text-foreground sm:text-2xl">
                                    {{ $patient->name }}
                                </h1>

                                <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-muted-foreground">

                                    <span class="inline-flex items-center gap-1.5">
                                        <i data-lucide="phone" class="size-4"></i>
                                        {{ $patient->phone ?: 'لا يوجد رقم هاتف' }}
                                    </span>

                                    <span class="hidden sm:inline">•</span>

                                    <span class="inline-flex items-center gap-1.5">

                                        <i data-lucide="cake" class="size-4"></i>

                                        @if ($patient->birth_date)
                                            {{ $patient->birth_date->age }} سنة
                                        @else
                                            العمر غير محدد
                                        @endif

                                    </span>

                                    <span class="hidden sm:inline">•</span>

                                    <span class="inline-flex items-center gap-1.5">

                                        <i data-lucide="user-round" class="size-4"></i>

                                        @if ($patient->gender === 'male')
                                            ذكر
                                        @elseif ($patient->gender === 'female')
                                            أنثى
                                        @else
                                            غير محدد
                                        @endif

                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- Actions --}}
                        <div class="bq-no-print flex flex-wrap gap-2">

                            {{-- زيارة جديدة / روشتة جديدة / فاتورة: ممنوعة على مساعد الطبيب --}}
                            @unless ($isAssistant)
                                <button type="button" class="btn btn-default btn-sm" @click="openCreate()">

                                    <i data-lucide="stethoscope" class="size-4"></i>

                                    زيارة جديدة

                                </button>


                                <button type="button" class="btn btn-default btn-sm" @click="$dispatch('bq-rx-create')">

                                    <i data-lucide="file-plus" class="size-4"></i>

                                    روشتة جديدة

                                </button>


                                <x-doctor.clinic.invoice-form :patient="$patient" />
                            @endunless

                        </div>

                    </div>

                </div>


                {{-- Quick Medical Info --}}
                <div class="grid border-t border-border/60 {{ $isAssistant ? 'sm:grid-cols-2' : 'sm:grid-cols-3' }}">

                    {{-- تاريخ التسجيل --}}
                    <div class="flex items-center gap-3 p-4">

                        <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">
                            <i data-lucide="calendar-plus" class="size-5"></i>
                        </div>

                        <div>

                            <p class="text-xs text-muted-foreground">
                                تاريخ التسجيل
                            </p>

                            <p class="mt-0.5 text-sm font-semibold">
                                {{ $patient->created_at->locale('ar')->translatedFormat('d M Y') }}
                            </p>

                        </div>

                    </div>

                    @unless ($isAssistant)
                        {{-- عدد الزيارات --}}
                        <div
                            class="flex items-center gap-3 border-t border-border/60 p-4 sm:border-t-0 {{ $isAssistant ? '' : 'sm:border-x' }}">

                            <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">
                                <i data-lucide="stethoscope" class="size-5"></i>
                            </div>

                            <div>

                                <p class="text-xs text-muted-foreground">
                                    عدد الزيارات
                                </p>

                                <p class="mt-0.5 text-sm font-semibold">
                                    {{ $visits->total() }} زيارة
                                </p>

                            </div>

                        </div>
                    @endunless

                    {{-- إجمالي المدفوع: مالي — ممنوع على مساعد الطبيب --}}
                    @unless ($isAssistant)
                        <div class="flex items-center gap-3 border-t border-border/60 p-4 sm:border-t-0">

                            <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">
                                <i data-lucide="wallet" class="size-5"></i>
                            </div>

                            <div>

                                <p class="text-xs text-muted-foreground">
                                    إجمالي المدفوع
                                </p>

                                <p class="mt-0.5 text-sm font-semibold tabular-nums">
                                    {{ number_format($totalPaid, 2) }} ج.م
                                </p>

                            </div>

                        </div>
                    @endunless

                </div>

            </div>


            {{-- =========================================================
                 Tabs
            ========================================================== --}}

            <div data-patient-tabs class="w-full">

                <div class="bq-no-print tabs-list w-full overflow-x-auto" style="scrollbar-width:none;">

                    <button type="button" class="tab-trigger active shrink-0" data-patient-tab="overview">

                        <i data-lucide="layout-dashboard" class="size-4"></i>

                        ملخص

                    </button>


                    {{-- الزيارات / الملفات / الروشتات / المدفوعات / ملاحظات: ملف طبي ومالي — ممنوع على مساعد الطبيب --}}
                    @unless ($isAssistant)
                        <button type="button" class="tab-trigger shrink-0" data-patient-tab="visits">

                            <i data-lucide="stethoscope" class="size-4"></i>

                            الزيارات

                            <span class="tab-count">
                                {{ $visits->total() }}
                            </span>

                        </button>


                        <button type="button" class="tab-trigger shrink-0" data-patient-tab="documents">

                            <i data-lucide="folder-open" class="size-4"></i>

                            الملفات

                            <span class="tab-count">
                                {{ count($documents) }}
                            </span>

                        </button>


                        <button type="button" class="tab-trigger shrink-0" data-patient-tab="prescriptions">

                            <i data-lucide="file-text" class="size-4"></i>

                            الروشتات

                            <span class="tab-count">
                                {{ $prescriptions->total() }}
                            </span>

                        </button>
                    @endunless


                    <button type="button" class="tab-trigger shrink-0" data-patient-tab="bookings">

                        <i data-lucide="calendar-days" class="size-4"></i>

                        الحجوزات

                        <span class="tab-count">
                            {{ $bookings->total() }}
                        </span>

                    </button>


                    @unless ($isAssistant)
                        <button type="button" class="tab-trigger shrink-0" data-patient-tab="payments">

                            <i data-lucide="wallet" class="size-4"></i>

                            المدفوعات

                            <span class="tab-count">
                                {{ $payments->total() }}
                            </span>

                        </button>


                        <button type="button" class="tab-trigger shrink-0" data-patient-tab="notes">

                            <i data-lucide="sticky-note" class="size-4"></i>

                            ملاحظات

                            <span class="tab-count">
                                {{ $notes->total() }}
                            </span>

                        </button>
                    @endunless

                </div>


                {{-- =====================================================
                     Overview
                ====================================================== --}}

                <div class="mt-4 patient-tab-panel active" data-patient-panel="overview">

                    <h2 class="bq-print-heading">
                        ملخص
                    </h2>

                    <div class="grid gap-4 {{ $isAssistant ? 'lg:grid-cols-1' : 'lg:grid-cols-3' }}">

                        {{-- Basic Information --}}
                        <div class="section-card">

                            <div class="section-card-header">

                                <div class="flex items-center gap-2">

                                    <div class="grid size-9 place-items-center rounded-lg bg-primary-soft text-primary">
                                        <i data-lucide="user-round" class="size-4"></i>
                                    </div>

                                    <h2 class="text-sm font-bold sm:text-base">
                                        البيانات الأساسية
                                    </h2>

                                </div>

                            </div>


                            <div class="section-card-body">

                                <dl class="space-y-3 text-sm">

                                    <div class="flex items-start justify-between gap-4">
                                        <dt class="text-muted-foreground">الاسم</dt>
                                        <dd class="text-end font-medium">
                                            {{ $patient->name }}
                                        </dd>
                                    </div>

                                    <div class="flex items-start justify-between gap-4">
                                        <dt class="text-muted-foreground">الهاتف</dt>
                                        <dd class="text-end font-medium tabular-nums">
                                            {{ $patient->phone ?: 'لا يوجد رقم هاتف' }}
                                        </dd>
                                    </div>

                                    <div class="flex items-start justify-between gap-4">
                                        <dt class="text-muted-foreground">تاريخ الميلاد</dt>
                                        <dd class="text-end font-medium">
                                            {{ $patient->birth_date ? $patient->birth_date->format('d/m/Y') : 'غير محدد' }}
                                        </dd>
                                    </div>

                                    <div class="flex items-start justify-between gap-4">
                                        <dt class="text-muted-foreground">النوع</dt>
                                        <dd class="text-end font-medium">
                                            @if ($patient->gender === 'male')
                                                ذكر
                                            @elseif ($patient->gender === 'female')
                                                أنثى
                                            @else
                                                غير محدد
                                            @endif
                                        </dd>
                                    </div>

                                    <div class="flex items-start justify-between gap-4">
                                        <dt class="text-muted-foreground">العنوان</dt>
                                        <dd class="max-w-[60%] text-end font-medium">
                                            {{ $patient->address ?: 'لم يضع عنوانًا' }}
                                        </dd>
                                    </div>

                                </dl>

                            </div>

                        </div>


                        {{-- آخر زيارة + الملخص المالي: ملف طبي ومالي — ممنوع على مساعد الطبيب --}}
                        @unless ($isAssistant)

                            {{-- Last Visit --}}
                            <div class="section-card">

                                <div class="section-card-header">

                                    <div class="flex items-center gap-2">

                                        <div class="grid size-9 place-items-center rounded-lg bg-primary-soft text-primary">
                                            <i data-lucide="activity" class="size-4"></i>
                                        </div>

                                        <h2 class="text-sm font-bold sm:text-base">
                                            آخر زيارة
                                        </h2>

                                    </div>

                                </div>


                                <div class="section-card-body">

                                    @if ($visits->isNotEmpty())
                                        @php
                                            $lastVisit = $visits->first();
                                        @endphp

                                        <div class="space-y-4">

                                            <div>

                                                <p class="text-base font-bold">
                                                    {{ $lastVisit->diagnosis ?: 'بدون تشخيص' }}
                                                </p>

                                                <p class="mt-1 text-xs text-muted-foreground">
                                                    {{ \Carbon\Carbon::parse($lastVisit->visit_date)->locale('ar')->translatedFormat('l، d M Y') }}
                                                </p>

                                            </div>

                                            @if ($lastVisit->complaint)
                                                <div class="rounded-xl bg-muted/40 p-3">

                                                    <p class="text-xs text-muted-foreground">
                                                        الشكوى
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium">
                                                        {{ $lastVisit->complaint }}
                                                    </p>

                                                </div>
                                            @endif

                                            @if ($lastVisit->notes)
                                                <div class="rounded-xl bg-muted/40 p-3">

                                                    <p class="text-xs text-muted-foreground">
                                                        ملاحظات
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium">
                                                        {{ $lastVisit->notes }}
                                                    </p>

                                                </div>
                                            @endif

                                        </div>
                                    @else
                                        <div class="clinic-surface-card p-6">

                                            <x-home.banner.no_results logo="fa-solid fa-stethoscope" title="لا توجد زيارات"
                                                content="لم يتم تسجيل أي زيارات لهذا المريض حتى الآن." />

                                        </div>
                                    @endif

                                </div>

                            </div>


                            {{-- Financial Summary --}}
                            <div class="section-card">

                                <div class="section-card-header">

                                    <div class="flex items-center gap-2">

                                        <div class="grid size-9 place-items-center rounded-lg bg-primary-soft text-primary">
                                            <i data-lucide="wallet" class="size-4"></i>
                                        </div>

                                        <h2 class="text-sm font-bold sm:text-base">
                                            الملخص المالي
                                        </h2>

                                    </div>

                                </div>


                                <div class="section-card-body">

                                    <div class="space-y-4">

                                        <div class="rounded-2xl bg-primary-soft p-4">

                                            <p class="text-xs text-muted-foreground">
                                                إجمالي المدفوع
                                            </p>

                                            <p class="mt-1 text-2xl font-bold text-primary tabular-nums">
                                                {{ number_format($totalPaid, 2) }}
                                                ج.م
                                            </p>

                                        </div>


                                        <dl class="space-y-3 text-sm">

                                            <div class="flex justify-between gap-3">
                                                <dt class="text-muted-foreground">عدد الحجوزات</dt>
                                                <dd class="font-semibold">
                                                    {{ $bookings->total() }}
                                                </dd>
                                            </div>

                                            <div class="flex justify-between gap-3">
                                                <dt class="text-muted-foreground">عدد الزيارات</dt>
                                                <dd class="font-semibold">
                                                    {{ $visits->total() }}
                                                </dd>
                                            </div>

                                            <div class="flex justify-between gap-3">
                                                <dt class="text-muted-foreground">عدد الروشتات</dt>
                                                <dd class="font-semibold">
                                                    {{ $prescriptions->total() }}
                                                </dd>
                                            </div>

                                            <div class="flex justify-between gap-3">
                                                <dt class="text-muted-foreground">عدد الملفات</dt>
                                                <dd class="font-semibold">
                                                    {{ count($documents) }}
                                                </dd>
                                            </div>

                                        </dl>

                                    </div>

                                </div>

                            </div>

                        @endunless

                    </div>

                </div>


                {{-- =====================================================
                     Visits / Documents / Prescriptions / Payments / Notes
                     ملف طبي ومالي — الأقسام دي كلها مقفولة تمامًا عن مساعد الطبيب
                ====================================================== --}}

                @unless ($isAssistant)

                    <div class="mt-4 hidden patient-tab-panel" data-patient-panel="visits">

                        <h2 class="bq-print-heading">
                            الزيارات
                        </h2>

                        @if ($visits->isNotEmpty())
                            @php

                                $fmtInline = fn($value) => is_array($value)
                                    ? collect($value)->filter()->join('، ')
                                    : $value;

                                $fmtLines = fn($value) => is_array($value)
                                    ? collect($value)->filter()->join("\n")
                                    : (string) ($value ?? '');

                            @endphp


                            <div class="space-y-3">

                                @foreach ($visits as $visit)
                                    @php

                                        $visitDate = \Carbon\Carbon::parse($visit->visit_date);

                                        $visitDateInput = $visitDate->format('Y-m-d');

                                        $visitDateLabel = $visitDate->locale('ar')->translatedFormat('l، d M Y');

                                        $nextVisitInput = '';

                                        $nextVisitLabel = null;

                                        if ($visit->next_visit_date) {
                                            $nextVisit = \Carbon\Carbon::parse($visit->next_visit_date);

                                            $nextVisitInput = $nextVisit->format('Y-m-d');

                                            $nextVisitLabel = $nextVisit->locale('ar')->translatedFormat('l، d M Y');
                                        }

                                        $requiredTests = $fmtInline($visit->required_tests);

                                        $requiredRadiology = $fmtInline($visit->required_radiology);

                                        $visitPayload = [
                                            'id' => $visit->id,

                                            'patient_id' => $visit->patient_id,

                                            'patient_name' => $patient->name,

                                            'patient_phone' => $patient->phone,

                                            'visit_date' => $visitDateInput,

                                            'complaint' => (string) ($visit->complaint ?? ''),

                                            'symptoms' => (string) ($visit->symptoms ?? ''),

                                            'diagnosis' => (string) ($visit->diagnosis ?? ''),

                                            'required_tests' => $fmtLines($visit->required_tests),

                                            'required_radiology' => $fmtLines($visit->required_radiology),

                                            'notes' => (string) ($visit->notes ?? ''),

                                            'next_visit_date' => $nextVisitInput,
                                        ];

                                        $printFields = [
                                            ['الشكوى الرئيسية', $visit->complaint, false, true],

                                            ['الأعراض', $visit->symptoms, false, true],

                                            ['التشخيص', $visit->diagnosis, true, true],

                                            ['التحاليل المطلوبة', $requiredTests, false, false],

                                            ['الأشعة', $requiredRadiology, false, false],

                                            ['ملاحظات الزيارة', $visit->notes, true, false],

                                            ['موعد المتابعة', $nextVisitLabel, false, false],
                                        ];

                                    @endphp


                                    <article class="clinic-surface-card bq-visit-card"
                                        data-print-target="visit-{{ $visit->id }}">

                                        <div class="bq-screen-only">

                                            <div
                                                class="flex flex-col gap-4 border-b border-border/60 p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">

                                                <div class="flex min-w-0 items-center gap-3">

                                                    <div
                                                        class="bq-visit-icon grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">

                                                        <i data-lucide="stethoscope" class="size-5"></i>

                                                    </div>

                                                    <div class="min-w-0">

                                                        <h3 class="bq-visit-title font-bold">
                                                            {{ $visit->diagnosis ?: 'بدون تشخيص' }}
                                                        </h3>

                                                        <div class="mt-1 flex flex-wrap items-center gap-2">

                                                            <span class="badge badge-muted">
                                                                {{ $visitDateLabel }}
                                                            </span>

                                                        </div>

                                                    </div>

                                                </div>


                                                <div class="bq-no-print flex shrink-0 flex-wrap items-center gap-2">

                                                    <button type="button" class="btn btn-default btn-sm"
                                                        @click="openEdit(@js($visitPayload))">

                                                        <i data-lucide="pencil" class="size-4"></i>

                                                        تعديل الزيارة

                                                    </button>


                                                    <button type="button" class="btn btn-outline btn-sm"
                                                        data-print-trigger="visit-{{ $visit->id }}"
                                                        data-print-mode="visit">

                                                        <i data-lucide="printer" class="size-4"></i>

                                                        طباعة الزيارة

                                                    </button>


                                                    <form method="POST" action="{{ route('clinic.visit.destroy', $visit) }}"
                                                        onsubmit="return confirm('حذف هذه الزياره نهائيًا؟')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-outline btn-sm">

                                                            <i data-lucide="trash-2" class="size-4"></i>

                                                            حذف

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>


                                            {{-- Body --}}
                                            <div class="grid gap-3 p-4 sm:grid-cols-2 sm:p-5">

                                                <div class="bq-visit-field rounded-xl bg-muted/40 p-3">

                                                    <p class="text-xs text-muted-foreground">
                                                        الشكوى
                                                    </p>

                                                    <p class="bq-visit-text mt-1 text-sm font-medium">
                                                        {{ $visit->complaint ?: '—' }}
                                                    </p>

                                                </div>


                                                <div class="bq-visit-field rounded-xl bg-muted/40 p-3">

                                                    <p class="text-xs text-muted-foreground">
                                                        الأعراض
                                                    </p>

                                                    <p class="bq-visit-text mt-1 text-sm font-medium">
                                                        {{ $visit->symptoms ?: '—' }}
                                                    </p>

                                                </div>


                                                @if ($requiredTests)
                                                    <div class="bq-visit-field rounded-xl bg-muted/40 p-3">

                                                        <p class="text-xs text-muted-foreground">
                                                            التحاليل المطلوبة
                                                        </p>

                                                        <p class="bq-visit-text mt-1 text-sm font-medium">
                                                            {{ $requiredTests }}
                                                        </p>

                                                    </div>
                                                @endif


                                                @if ($requiredRadiology)
                                                    <div class="bq-visit-field rounded-xl bg-muted/40 p-3">

                                                        <p class="text-xs text-muted-foreground">
                                                            الأشعة
                                                        </p>

                                                        <p class="bq-visit-text mt-1 text-sm font-medium">
                                                            {{ $requiredRadiology }}
                                                        </p>

                                                    </div>
                                                @endif


                                                @if ($visit->notes)
                                                    <div class="bq-visit-field rounded-xl bg-muted/40 p-3 sm:col-span-2">

                                                        <p class="text-xs text-muted-foreground">
                                                            ملاحظات الزيارة
                                                        </p>

                                                        <p class="bq-visit-text mt-1 text-sm font-medium">
                                                            {{ $visit->notes }}
                                                        </p>

                                                    </div>
                                                @endif


                                                @if ($nextVisitLabel)
                                                    <div class="bq-visit-field rounded-xl bg-muted/40 p-3">

                                                        <p class="text-xs text-muted-foreground">
                                                            موعد المتابعة
                                                        </p>

                                                        <p class="mt-1 text-sm font-medium">
                                                            {{ $nextVisitLabel }}
                                                        </p>

                                                    </div>
                                                @endif

                                            </div>

                                        </div>


                                        {{-- محتوى الطباعة --}}
                                        <div class="bq-print-only">

                                            <h2 class="bq-sheet-title">
                                                <span>تقرير زيارة طبية</span>
                                            </h2>


                                            <div class="bq-sheet-meta">

                                                <span class="bq-sheet-meta-wide">
                                                    <b>المريض:</b>
                                                    {{ $patient->name }}
                                                </span>

                                                @if ($patientAge)
                                                    <span>
                                                        <b>السن:</b>
                                                        {{ $patientAge }} سنة
                                                    </span>
                                                @endif

                                                @if ($patient->phone)
                                                    <span>
                                                        <b>الهاتف:</b>
                                                        {{ $patient->phone }}
                                                    </span>
                                                @endif

                                                <span>
                                                    <b>تاريخ الزيارة:</b>
                                                    {{ $visitDate->format('Y/m/d') }}
                                                </span>

                                            </div>


                                            <div class="bq-sheet-fields">

                                                @foreach ($printFields as [$label, $value, $full, $always])
                                                    @if (filled($value) || $always)
                                                        <div class="bq-sheet-field {{ $full ? 'bq-sheet-field-full' : '' }}">

                                                            <p class="bq-sheet-field-label">
                                                                {{ $label }}
                                                            </p>

                                                            <p class="bq-sheet-field-text">
                                                                {{ filled($value) ? $value : '—' }}
                                                            </p>

                                                        </div>
                                                    @endif
                                                @endforeach

                                            </div>

                                        </div>

                                    </article>
                                @endforeach


                                <div class="bq-no-print">

                                    {{ $visits->appends(['tab' => 'visits'])->links('vendor.pagination.custom') }}

                                </div>

                            </div>
                        @else
                            <div class="clinic-surface-card p-6">

                                <x-home.banner.no_results logo="fa-solid fa-stethoscope" title="لا توجد زيارات"
                                    content="لم يتم تسجيل أي زيارات لهذا المريض حتى الآن." />

                            </div>
                        @endif

                    </div>


                    <div class="mt-4 hidden patient-tab-panel" data-patient-panel="documents">

                        <h2 class="bq-print-heading">
                            الملفات
                        </h2>

                        @if (count($documents))
                            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">

                                @foreach ($documents as $document)
                                    <div class="clinic-surface-card p-4">

                                        <div class="flex items-start justify-between gap-3">

                                            <div
                                                class="grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">

                                                <i data-lucide="file" class="size-5"></i>

                                            </div>

                                            <span class="badge badge-info">
                                                {{ $document['kind'] }}
                                            </span>

                                        </div>


                                        <h3 class="mt-4 font-semibold">
                                            {{ $document['title'] }}
                                        </h3>


                                        <p class="mt-1 text-xs text-muted-foreground">

                                            {{ $document['dateLabel'] }}

                                            •

                                            {{ $document['size'] }}

                                        </p>


                                        <div class="bq-no-print mt-4 flex gap-2">

                                            <button type="button" class="btn btn-outline btn-sm flex-1">

                                                <i data-lucide="eye" class="size-4"></i>

                                                عرض

                                            </button>


                                            <button type="button" class="btn btn-outline btn-sm">

                                                <i data-lucide="download" class="size-4"></i>

                                            </button>

                                        </div>

                                    </div>
                                @endforeach

                            </div>
                        @else
                            <div class="clinic-surface-card p-6">

                                <x-home.banner.no_results logo="fa-solid fa-folder-open" title="لا توجد ملفات طبية"
                                    content="لم يتم تسجيل أي ملفات طبية لهذا المريض حتى الآن." />

                            </div>
                        @endif

                    </div>


                    <div class="mt-4 hidden patient-tab-panel" data-patient-panel="prescriptions">

                        <h2 class="bq-print-heading">
                            الروشتات
                        </h2>

                        @if (count($prescriptions))
                            <div class="space-y-3">

                                @foreach ($prescriptions as $rx)
                                    @php

                                        $rxMeds = collect($rx->medications ?? [])
                                            ->map(
                                                fn($m) => [
                                                    'name' => (string) ($m['name'] ?? ''),
                                                    'dose' => (string) ($m['dose'] ?? ''),
                                                    'frequency' => (string) ($m['frequency'] ?? ''),
                                                    'duration' => (string) ($m['duration'] ?? ''),
                                                    'timing' => (string) ($m['timing'] ?? ''),
                                                    'notes' => (string) ($m['notes'] ?? ''),
                                                ],
                                            )
                                            ->values();

                                        $rxPayload = [
                                            'id' => $rx->id,

                                            'patient_id' => $rx->patient_id,

                                            'patient_name' => $patient->name,

                                            'patient_phone' => (string) $patient->phone,

                                            'prescription_date' => $rx->prescription_date?->format('Y-m-d'),

                                            'next_visit_date' => $rx->next_visit_date?->format('Y-m-d'),

                                            'notes' => (string) ($rx->notes ?? ''),

                                            'medications' => $rxMeds->all(),
                                        ];

                                    @endphp


                                    <article class="clinic-surface-card p-4 sm:p-5"
                                        data-print-target="rx-{{ $rx->id }}">

                                        <div class="bq-screen-only">

                                            <div class="flex flex-wrap items-center justify-between gap-3">

                                                <div>

                                                    <p class="font-bold tabular-nums">
                                                        {{ $rx->ref }}
                                                    </p>

                                                    <p class="mt-1 text-xs text-muted-foreground">

                                                        {{ $rx->prescription_date?->locale('ar')->translatedFormat('d M Y') }}

                                                    </p>

                                                </div>


                                                <div class="bq-no-print flex flex-wrap items-center gap-2">

                                                    <button type="button" class="btn btn-default btn-sm"
                                                        @click="$dispatch('bq-rx-edit', @js($rxPayload))">

                                                        <i data-lucide="pencil" class="size-4"></i>

                                                        تعديل الروشتة

                                                    </button>


                                                    <button type="button" class="btn btn-outline btn-sm"
                                                        data-print-trigger="rx-{{ $rx->id }}" data-print-mode="rx">

                                                        <i data-lucide="printer" class="size-4"></i>

                                                        طباعة الروشتة

                                                    </button>


                                                    <form method="POST"
                                                        action="{{ route('clinic.prescriptions.destroy', $rx) }}"
                                                        onsubmit="return confirm('حذف هذه الروشتة نهائيًا؟')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-outline btn-sm">

                                                            <i data-lucide="trash-2" class="size-4"></i>

                                                            حذف

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>


                                            <div class="mt-4 overflow-hidden rounded-xl border border-border/60">

                                                <div
                                                    class="hidden grid-cols-[1.5fr_1fr_1fr_1fr_1fr] gap-3 bg-muted/40 px-4 py-3 text-xs font-semibold text-muted-foreground sm:grid">

                                                    <div>الدواء</div>
                                                    <div>الجرعة</div>
                                                    <div>التكرار</div>
                                                    <div>المدة</div>
                                                    <div>التوقيت</div>

                                                </div>


                                                @foreach ($rxMeds as $item)
                                                    <div
                                                        class="grid gap-2 border-b border-border/60 p-4 last:border-b-0 sm:grid-cols-[1.5fr_1fr_1fr_1fr_1fr] sm:items-center sm:gap-3 sm:px-4">

                                                        <div>

                                                            <p class="text-xs text-muted-foreground sm:hidden">
                                                                الدواء
                                                            </p>

                                                            <p class="font-semibold">
                                                                {{ $item['name'] }}
                                                            </p>

                                                            @if ($item['notes'] !== '')
                                                                <p class="mt-0.5 text-xs text-muted-foreground">
                                                                    {{ $item['notes'] }}
                                                                </p>
                                                            @endif

                                                        </div>


                                                        <div>

                                                            <p class="text-xs text-muted-foreground sm:hidden">
                                                                الجرعة
                                                            </p>

                                                            <p class="text-sm">
                                                                {{ $item['dose'] !== '' ? $item['dose'] : '—' }}
                                                            </p>

                                                        </div>


                                                        <div>

                                                            <p class="text-xs text-muted-foreground sm:hidden">
                                                                التكرار
                                                            </p>

                                                            <p class="text-sm">
                                                                {{ $item['frequency'] !== '' ? $item['frequency'] : '—' }}
                                                            </p>

                                                        </div>


                                                        <div>

                                                            <p class="text-xs text-muted-foreground sm:hidden">
                                                                المدة
                                                            </p>

                                                            <p class="text-sm">
                                                                {{ $item['duration'] !== '' ? $item['duration'] : '—' }}
                                                            </p>

                                                        </div>


                                                        <div>

                                                            <p class="text-xs text-muted-foreground sm:hidden">
                                                                التوقيت
                                                            </p>

                                                            <p class="text-sm text-muted-foreground">
                                                                {{ $item['timing'] !== '' ? $item['timing'] : '—' }}
                                                            </p>

                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>


                                            @if ($rx->notes || $rx->next_visit_date)
                                                <div class="mt-4 grid gap-3 sm:grid-cols-2">

                                                    @if ($rx->notes)
                                                        <div
                                                            class="rounded-xl bg-muted/40 p-3 {{ $rx->next_visit_date ? '' : 'sm:col-span-2' }}">

                                                            <p class="text-xs font-semibold text-muted-foreground">
                                                                ملاحظات الطبيب
                                                            </p>

                                                            <p class="bq-visit-text mt-1 text-sm">
                                                                {{ $rx->notes }}
                                                            </p>

                                                        </div>
                                                    @endif


                                                    @if ($rx->next_visit_date)
                                                        <div class="rounded-xl bg-muted/40 p-3">

                                                            <p class="text-xs font-semibold text-muted-foreground">
                                                                موعد المتابعة
                                                            </p>

                                                            <p class="mt-1 text-sm">
                                                                {{ $rx->next_visit_date->locale('ar')->translatedFormat('l، d M Y') }}
                                                            </p>

                                                        </div>
                                                    @endif

                                                </div>
                                            @endif

                                        </div>


                                        {{-- محتوى الطباعة --}}
                                        <x-doctor.clinic.prescription-print :rx="$rx" :name="$patient->name"
                                            :phone="$patient->phone" :age="$patientAge" />

                                    </article>
                                @endforeach


                                {{ $prescriptions->appends(['tab' => 'prescriptions'])->links('vendor.pagination.custom') }}

                            </div>
                        @else
                            <div class="clinic-surface-card p-6">

                                <x-home.banner.no_results logo="fa-solid fa-prescription-bottle-medical"
                                    title="لا توجد روشتات" content="لم يتم تسجيل أي روشتات لهذا المريض حتى الآن." />

                            </div>
                        @endif

                    </div>

                @endunless


                {{-- =====================================================
                     Bookings
                ====================================================== --}}

                <div class="mt-4 hidden patient-tab-panel" data-patient-panel="bookings">

                    <h2 class="bq-print-heading">
                        الحجوزات
                    </h2>


                    @if ($bookings->isNotEmpty())

                        <div class="space-y-3">

                            @foreach ($bookings as $booking)
                                @php

                                    $bookingStatus = match ($booking->status) {
                                        'pending' => ['في انتظار الحضور', 'warning'],

                                        'confirmed' => ['حضر للعيادة', 'info'],

                                        'in_progress' => ['جاري الكشف', 'purple'],

                                        'completed' => ['تم الكشف', 'success'],

                                        'cancelled' => ['ملغي', 'danger'],

                                        'no_show' => ['لم يحضر', 'muted'],

                                        default => ['غير معروف', 'muted'],
                                    };

                                @endphp


                                <div class="clinic-surface-card p-4">

                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                        {{-- بيانات الحجز --}}
                                        <div class="min-w-0">

                                            <div class="flex flex-wrap items-center gap-2">

                                                <span class="badge badge-{{ $bookingStatus[1] }}">
                                                    {{ $bookingStatus[0] }}
                                                </span>


                                                @if ($booking->booking_type === 'online')
                                                    <span class="badge badge-primary">
                                                        أونلاين
                                                    </span>
                                                @else
                                                    <span class="badge badge-purple">
                                                        من العيادة
                                                    </span>
                                                @endif

                                            </div>

                                            <p class="mt-2 text-sm text-muted-foreground">

                                                {{ \Carbon\Carbon::parse($booking->appointment_date)->locale('ar')->translatedFormat('l، d M Y') }}

                                                @if ($booking->started_at || $booking->completed_at)
                                                    •

                                                    @if ($booking->started_at)
                                                        بدأ
                                                        {{ \Carbon\Carbon::parse($booking->started_at)->format('g:i A') }}
                                                    @endif

                                                    @if ($booking->completed_at)
                                                        @if ($booking->started_at)
                                                            -
                                                        @endif

                                                        انتهى
                                                        {{ \Carbon\Carbon::parse($booking->completed_at)->format('g:i A') }}
                                                    @endif
                                                @endif

                                            </p>


                                            <p class="mt-1 text-xs text-muted-foreground">
                                                {{ $booking->service ?: 'لم تحدد' }}
                                            </p>

                                        </div>


                                        {{-- الدفع + إجراءات --}}
                                        <div class="flex shrink-0 items-center justify-between gap-4 sm:justify-end">

                                            <div class="text-end">

                                                <p class="font-bold tabular-nums">

                                                    {{ number_format((float) $booking->price, 2) }}

                                                    ج.م

                                                </p>


                                                <p class="mt-1 text-xs text-success">

                                                    {{ number_format((float) $booking->paid, 2) }}

                                                    جنيه

                                                </p>

                                            </div>


                                            <div class="flex items-center gap-2">

                                                {{-- تعديل الدفع: مالي — ممنوع على مساعد الطبيب --}}
                                                @unless ($isAssistant)
                                                    <button type="button" class="btn btn-icon" data-edit-payment
                                                        data-id="{{ $booking->id }}"
                                                        data-name="{{ $booking->patient_name }}"
                                                        data-price="{{ (float) $booking->price }}"
                                                        data-paid="{{ (float) $booking->paid }}" title="تعديل الدفع"
                                                        aria-label="تعديل الدفع">

                                                        <i data-lucide="wallet" class="size-4"></i>

                                                    </button>
                                                @endunless


                                                {{-- حذف الحجز --}}
                                                <form method="POST"
                                                    action="{{ route('clinic.bookings.destroy', $booking) }}"
                                                    onsubmit="return confirm('حذف هذا الحجز نهائيًا؟')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-icon btn-destructive"
                                                        title="حذف الحجز" aria-label="حذف الحجز">

                                                        <i data-lucide="trash-2" class="h-4 w-4">
                                                        </i>

                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>


                        <div class="mt-4">

                            {{ $bookings->appends(['tab' => 'bookings'])->links('vendor.pagination.custom') }}

                        </div>
                    @else
                        <div class="clinic-surface-card p-6">

                            <x-home.banner.no_results logo="fa-solid fa-calendar-check" title="لا توجد حجوزات"
                                content="لم يتم تسجيل أي حجوزات لهذا المريض حتى الآن." />

                        </div>

                    @endif

                </div>


                {{-- =====================================================
                     Payments — حجوزات مكتملة + حركات مسجلة يدويًا
                     مالي — مقفول تمامًا عن مساعد الطبيب
                ====================================================== --}}

                @unless ($isAssistant)

                    <div class="mt-4 hidden patient-tab-panel" data-patient-panel="payments">

                        <div class="bq-no-print mb-3 flex items-center justify-between gap-2">

                            <h2 class="bq-print-heading mb-0">
                                المدفوعات
                            </h2>



                        </div>

                        @if ($payments->isNotEmpty())
                            <div class="space-y-3">

                                @foreach ($payments as $row)
                                    @php
                                        $isBooking = $row->source === 'booking';
                                        $isExpense = $row->type === 'expense';
                                        $remaining = $isBooking
                                            ? max(0, (float) $row->expected - (float) $row->amount)
                                            : 0;
                                        $hasNote = !empty(trim((string) ($row->notes ?? '')));
                                    @endphp

                                    <div
                                        class="clinic-surface-card flex flex-col gap-3 p-4 sm:flex-row sm:items-center sm:justify-between">

                                        <div class="flex min-w-0 items-center gap-3">

                                            <div
                                                class="grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">

                                                <i data-lucide="wallet" class="size-5"></i>

                                            </div>

                                            <div class="min-w-0">

                                                <div class="flex flex-wrap items-center gap-2">

                                                    <p class="font-bold">
                                                        {{ $row->title ?: 'كشف / خدمة' }}
                                                    </p>

                                                    @if ($isExpense)
                                                        <span class="badge badge-danger">مصروف</span>
                                                    @else
                                                        <span class="badge badge-success">إيراد</span>
                                                    @endif

                                                    @if ($isBooking && $remaining > 0)
                                                        <span class="badge badge-warning">مستحق</span>
                                                    @endif
                                                </div>

                                                <p class="mt-1 text-xs text-muted-foreground">

                                                    {{ \Carbon\Carbon::parse($row->row_date)->locale('ar')->translatedFormat('l، d M Y') }}

                                                    •

                                                    {{ $isBooking ? 'من الحجز' : 'مسجل يدويًا' }}

                                                </p>

                                            </div>

                                        </div>


                                        <div class="flex flex-wrap items-center gap-3 sm:justify-end">

                                            @if ($isBooking)
                                                <div class="text-end">
                                                    <p class="text-xs text-muted-foreground">الإجمالي</p>
                                                    <p class="mt-0.5 font-bold tabular-nums">
                                                        {{ $fmtMoney($row->expected) }} ج.م
                                                    </p>
                                                </div>

                                                <div class="text-end">
                                                    <p class="text-xs text-muted-foreground">المدفوع</p>
                                                    <p class="mt-0.5 font-bold text-success tabular-nums">
                                                        {{ $fmtMoney($row->amount) }} ج.م
                                                    </p>
                                                </div>

                                                @if ($remaining > 0)
                                                    <div class="text-end">
                                                        <p class="text-xs text-muted-foreground">المتبقي</p>
                                                        <p class="mt-0.5 font-semibold tabular-nums text-warning">
                                                            {{ $fmtMoney($remaining) }} ج.م
                                                        </p>
                                                    </div>
                                                @endif

                                                <button type="button" class="btn btn-icon" data-edit-payment
                                                    data-id="{{ $row->row_id }}" data-name="{{ $patient->name }}"
                                                    data-price="{{ (float) $row->expected }}"
                                                    data-paid="{{ (float) $row->amount }}" title="تعديل الدفع"
                                                    aria-label="تعديل الدفع">
                                                    <i data-lucide="wallet" class="size-4"></i>
                                                </button>
                                            @else
                                                <div class="text-end">
                                                    <p class="text-xs text-muted-foreground">المبلغ</p>
                                                    <p
                                                        class="mt-0.5 font-bold tabular-nums {{ $isExpense ? 'text-destructive' : 'text-success' }}">
                                                        {{ $isExpense ? '−' : '' }}{{ $fmtMoney($row->amount) }} ج.م
                                                    </p>
                                                </div>

                                                <div class="flex items-center gap-2">

                                                    @if ($hasNote)
                                                        <button type="button" class="btn btn-icon" data-payment-note
                                                            data-note="{{ $row->notes }}"
                                                            data-title="{{ $row->title ?: 'ملاحظة الحركة' }}"
                                                            title="عرض الملاحظة" aria-label="عرض الملاحظة">
                                                            <i data-lucide="message-square-text" class="size-4"></i>
                                                        </button>
                                                    @endif

                                                    <form method="POST"
                                                        action="{{ route('clinic.payments.destroy', $row->row_id) }}"
                                                        onsubmit="return confirm('حذف هذا السجل؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-icon btn-destructive"
                                                            title="حذف" aria-label="حذف">
                                                            <i data-lucide="trash-2" class="size-4"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            @endif

                                        </div>

                                    </div>
                                @endforeach

                                {{ $payments->appends(['tab' => 'payments'])->links('vendor.pagination.custom') }}

                            </div>
                        @else
                            <div class="clinic-surface-card p-6">

                                <x-home.banner.no_results logo="fa-solid fa-wallet" title="لا توجد مدفوعات"
                                    content="لم يتم تسجيل أي مدفوعات لهذا المريض حتى الآن." />

                            </div>
                        @endif

                    </div>


                    {{-- =====================================================
                         Notes
                    ====================================================== --}}
                    <div class="mt-4 hidden patient-tab-panel" data-patient-panel="notes">

                        <h2 class="bq-print-heading">
                            ملاحظات
                        </h2>

                        <div class="grid gap-4 lg:grid-cols-[1fr_1.5fr]">

                            {{-- Add Note --}}
                            <div class="bq-no-print clinic-surface-card p-4 sm:p-5">

                                <div class="flex items-center gap-2">

                                    <div class="grid size-9 place-items-center rounded-lg bg-primary-soft text-primary">
                                        <i data-lucide="sticky-note" class="size-4"></i>
                                    </div>

                                    <div>
                                        <h2 class="text-sm font-bold">
                                            إضافة ملاحظة
                                        </h2>

                                        <p class="mt-0.5 text-xs text-muted-foreground">
                                            ملاحظات خاصة بالطبيب
                                        </p>
                                    </div>

                                </div>

                                <form action="{{ route('clinic.patient.notes.store', $patient) }}" method="POST"
                                    class="mt-4">
                                    @csrf

                                    <textarea name="note" rows="10"
                                        class="field-input min-h-[240px] resize-y @error('note') border-red-500 @enderror"
                                        placeholder="اكتب ملاحظة خاصة بالمريض...">{{ old('note') }}</textarea>

                                    @error('note')
                                        <p class="mt-1.5 text-xs text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    <button type="submit" class="btn btn-default mt-3 w-full">

                                        <i data-lucide="save" class="size-4"></i>

                                        حفظ الملاحظة

                                    </button>
                                </form>

                            </div>


                            {{-- Existing Notes --}}
                            <div>
                                @if ($notes?->total() > 0)
                                    <div class="space-y-3">

                                        @foreach ($notes as $note)
                                            <div class="clinic-surface-card p-4">

                                                <div class="flex items-start gap-3">

                                                    <div
                                                        class="grid size-9 shrink-0 place-items-center rounded-lg bg-muted text-muted-foreground">

                                                        <i data-lucide="sticky-note" class="size-4"></i>

                                                    </div>

                                                    <div class="min-w-0 flex-1">

                                                        <p class="text-sm leading-6 whitespace-pre-line">
                                                            {{ $note->note }}
                                                        </p>

                                                        <p class="mt-2 text-xs text-muted-foreground">
                                                            {{ $note->created_at?->timezone('Africa/Cairo')->format('Y/m/d - h:i A') }}
                                                        </p>

                                                    </div>



                                                    <form action="{{ route('clinic.patient.notes.destroy', $note) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('هل أنت متأكد من حذف هذه الملاحظة؟');">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-icon-sm shrink-0"
                                                            title="حذف الملاحظة" aria-label="حذف الملاحظة">

                                                            <i data-lucide="trash-2" class="h-4 w-4"></i>

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>
                                        @endforeach

                                        {{ $notes->appends(['tab' => 'notes'])->links('vendor.pagination.custom') }}
                                    </div>
                                @else
                                    <div class="clinic-surface-card p-6">

                                        <x-home.banner.no_results logo="fa-solid fa-note-sticky" title="لا توجد ملاحظات"
                                            content="لم يتم تسجيل أي ملاحظات لهذا المريض حتى الآن." />

                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>

                @endunless

            </div>

        </main>

    </x-doctor.clinic.visit-form>


    {{-- المودالات المالية والطبية: مقفولة تمامًا عن مساعد الطبيب --}}
    @unless ($isAssistant)
        {{-- مودال تعديل الدفع --}}
        <x-doctor.clinic.edit-payment-modal />


        {{-- modal الروشتة --}}
        <x-doctor.clinic.prescription-form :patient="$patient" />


        {{-- مودال عرض ملاحظة الحركة اليدوية --}}
        <div class="payment-note-modal" data-payment-note-modal aria-hidden="true">
            <div class="payment-note-panel" role="dialog" aria-modal="true" aria-labelledby="payment-note-modal-title"
                dir="rtl">
                <div class="payment-note-header">
                    <div class="payment-note-title-wrap">
                        <div class="payment-note-icon">
                            <i data-lucide="notebook-pen" class="size-5"></i>
                        </div>
                        <div class="min-w-0">
                            <h3 id="payment-note-modal-title" class="truncate text-lg font-bold">ملاحظة الحركة</h3>
                            <p class="mt-1 text-xs text-muted-foreground">التفاصيل الإضافية المسجلة مع الحركة المالية</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-icon" data-payment-note-close aria-label="إغلاق" title="إغلاق">
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>
                <div class="payment-note-body">
                    <div class="payment-note-content" data-payment-note-content></div>
                    <div class="payment-note-meta" data-payment-note-meta></div>
                </div>
            </div>
        </div>
    @endunless


    @push('extra_java')
        <script src="{{ asset('js/clinic/print.js') }}"></script>
        <script src="{{ asset('js/clinic/clinic-payments.js') }}"></script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {

                /*
                |--------------------------------------------------------------------------
                | Patient Details Tabs
                |--------------------------------------------------------------------------
                */

                const tabsWrapper =
                    document.querySelector('[data-patient-tabs]');

                if (tabsWrapper) {

                    const triggers =
                        tabsWrapper.querySelectorAll('[data-patient-tab]');

                    const panels =
                        tabsWrapper.querySelectorAll('[data-patient-panel]');


                    function activateTab(target, updateUrl = true) {

                        const exists =
                            Array.prototype.some.call(
                                triggers,
                                function(trigger) {

                                    return trigger.getAttribute(
                                        'data-patient-tab'
                                    ) === target;

                                }
                            ) &&
                            Array.prototype.some.call(
                                panels,
                                function(panel) {

                                    return panel.getAttribute(
                                        'data-patient-panel'
                                    ) === target;

                                }
                            );


                        if (!exists) {
                            target = 'overview';
                        }


                        triggers.forEach(function(trigger) {

                            trigger.classList.toggle(
                                'active',
                                trigger.getAttribute(
                                    'data-patient-tab'
                                ) === target
                            );

                        });


                        panels.forEach(function(panel) {

                            const isTarget =
                                panel.getAttribute(
                                    'data-patient-panel'
                                ) === target;


                            panel.classList.toggle(
                                'hidden',
                                !isTarget
                            );

                            panel.classList.toggle(
                                'active',
                                isTarget
                            );

                        });


                        if (updateUrl) {

                            const url =
                                new URL(window.location.href);

                            url.searchParams.set(
                                'tab',
                                target
                            );

                            url.searchParams.delete('page');

                            window.history.replaceState({},
                                '',
                                url.toString()
                            );

                        }

                    }


                    triggers.forEach(function(trigger) {

                        trigger.addEventListener(
                            'click',
                            function() {

                                activateTab(
                                    trigger.getAttribute(
                                        'data-patient-tab'
                                    ),
                                    true
                                );

                            }
                        );

                    });


                    const urlParams =
                        new URLSearchParams(
                            window.location.search
                        );


                    activateTab(
                        urlParams.get('tab') || 'overview',
                        false
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Edit Payment Modal
                |--------------------------------------------------------------------------
                */

                const paymentModal =
                    document.getElementById(
                        'edit-payment-modal'
                    );

                const paymentForm =
                    document.getElementById(
                        'edit-payment-form'
                    );

                const paymentPatient =
                    document.getElementById(
                        'edit-payment-patient'
                    );

                const paymentPrice =
                    document.getElementById(
                        'edit-payment-price'
                    );

                const paymentPaid =
                    document.getElementById(
                        'edit-payment-paid'
                    );

                const paymentTotalPreview =
                    document.getElementById(
                        'edit-payment-total-preview'
                    );

                const paymentPaidPreview =
                    document.getElementById(
                        'edit-payment-paid-preview'
                    );

                const paymentRemainingPreview =
                    document.getElementById(
                        'edit-payment-remaining-preview'
                    );


                function updatePaymentPreview() {

                    if (
                        !paymentPrice ||
                        !paymentPaid
                    ) {
                        return;
                    }


                    const price =
                        Math.max(
                            0,
                            Number(paymentPrice.value) || 0
                        );

                    const paid =
                        Math.max(
                            0,
                            Number(paymentPaid.value) || 0
                        );

                    const remaining =
                        Math.max(
                            0,
                            price - paid
                        );


                    if (paymentTotalPreview) {

                        paymentTotalPreview.textContent =
                            `${price.toFixed(2)} ج.م`;

                    }


                    if (paymentPaidPreview) {

                        paymentPaidPreview.textContent =
                            `${paid.toFixed(2)} ج.م`;

                    }


                    if (paymentRemainingPreview) {

                        paymentRemainingPreview.textContent =
                            `${remaining.toFixed(2)} ج.م`;

                    }

                }


                function openPaymentModal(button) {

                    if (
                        !paymentModal ||
                        !paymentForm
                    ) {
                        return;
                    }


                    const id =
                        button.dataset.id;

                    const name =
                        button.dataset.name || '';

                    const price =
                        Number(button.dataset.price || 0);

                    const paid =
                        Number(button.dataset.paid || 0);


                    paymentForm.action =
                        @json(route('clinic.bookings.payment', [
                                'booking' => '__BOOKING_ID__',
                            ])).replace(
                            '__BOOKING_ID__',
                            encodeURIComponent(id)
                        );


                    if (paymentPatient) {

                        paymentPatient.textContent =
                            `تعديل الدفع للحجز للمريض ${name}`;

                    }


                    if (paymentPrice) {

                        paymentPrice.value =
                            price;

                    }


                    if (paymentPaid) {

                        paymentPaid.value =
                            paid;

                    }


                    updatePaymentPreview();


                    paymentModal.classList.add('open');

                    document.body.classList.add(
                        'overflow-hidden'
                    );


                    if (window.lucide) {
                        window.lucide.createIcons();
                    }

                }


                function closePaymentModal() {

                    if (!paymentModal) {
                        return;
                    }


                    paymentModal.classList.remove('open');

                    document.body.classList.remove(
                        'overflow-hidden'
                    );

                }


                document.addEventListener(
                    'click',
                    function(event) {

                        const editButton =
                            event.target.closest(
                                '[data-edit-payment]'
                            );


                        if (editButton) {

                            openPaymentModal(
                                editButton
                            );

                            return;

                        }


                        const closeButton =
                            event.target.closest(
                                '[data-modal-close]'
                            );


                        if (closeButton) {

                            closePaymentModal();

                            return;

                        }


                        if (
                            paymentModal &&
                            event.target === paymentModal
                        ) {

                            closePaymentModal();

                        }

                    }
                );


                if (paymentPrice) {

                    paymentPrice.addEventListener(
                        'input',
                        updatePaymentPreview
                    );

                }


                if (paymentPaid) {

                    paymentPaid.addEventListener(
                        'input',
                        updatePaymentPreview
                    );

                }


                document.addEventListener(
                    'keydown',
                    function(event) {

                        if (
                            event.key === 'Escape' &&
                            paymentModal &&
                            paymentModal.classList.contains('open')
                        ) {

                            closePaymentModal();

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Lucide
                |--------------------------------------------------------------------------
                */

                if (window.lucide) {

                    window.lucide.createIcons();

                }

            });
        </script>
    @endpush

@endsection

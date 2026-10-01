@extends('doctor.layouts.app_clinc')

@section('title', 'لوحة تحكم العيادة | دليل الأطباء')

@section('content')
@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">

@endpush


    <main class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">
                <h1 class="truncate text-xl font-bold sm:text-2xl">
                    لوحة التحكم
                </h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    مرحبًا د.{{ Auth::user()->name ?? 'مدير النظام' }} — إليك ملخص عيادتك اليوم.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">

                <a href="{{ route('clinic.bookings.index') }}" class="btn btn-default btn-sm">
                    <i data-lucide="plus" class="size-4"></i>
                    حجز جديد
                </a>

                @if ($isClinicSystem)
                    <a href="{{ route('clinic.patients') }}" class="btn btn-outline btn-sm">
                        <i data-lucide="user-plus" class="size-4"></i>
                        مريض جديد
                    </a>
                @endif

                <a href="{{ route('clinic.slots.index') }}" class="btn btn-outline btn-sm">
                    <i data-lucide="calendar-clock" class="size-4"></i>
                    المواعيد المتاحة
                </a>

            </div>
        </div>


        {{-- =========================
            Statistics
        ========================== --}}
        <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-5">

            {{-- حجوزات اليوم --}}
            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            حجوزات اليوم
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-total-booking">
                            {{ $TotalBooking ?? 0 }}
                        </p>
                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-primary">
                        <i data-lucide="calendar-check" class="size-5"></i>
                    </span>

                </div>
            </div>


            {{-- أونلاين --}}
            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            حجوزات أونلاين
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-booking-online">
                            {{ $TotalBookingOnline ?? 0 }}
                        </p>
                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-info">
                        <i data-lucide="globe" class="size-5"></i>
                    </span>

                </div>
            </div>


            {{-- العيادة --}}
            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            حجوزات العيادة
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-booking-clinic">
                            {{ $TotalBookingClinic ?? 0 }}
                        </p>
                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-purple">
                        <i data-lucide="hospital" class="size-5"></i>
                    </span>

                </div>
            </div>


            {{-- المنتظرون --}}
            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            المرضى المنتظرون
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-waiting">
                            {{ $waitingPatients ?? 0 }}
                        </p>
                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-warning">
                        <i data-lucide="clock" class="size-5"></i>
                    </span>

                </div>
            </div>


            {{-- تم الكشف --}}
            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            تم الكشف عليهم
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-completed">
                            {{ $completedPatients ?? 0 }}
                        </p>
                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-success">
                        <i data-lucide="check-circle-2" class="size-5"></i>
                    </span>

                </div>
            </div>

        </div>


        {{-- =========================
            Second Statistics Row
        ========================== --}}
        <div class="mt-3 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-5">

            {{-- مواعيد متاحة --}}
            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            مواعيد متاحة
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-slots-available">
                            {{ $slotsStats['available'] }}
                        </p>
                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-success">
                        <i data-lucide="calendar-clock" class="size-5"></i>
                    </span>

                </div>
            </div>


            {{-- ملغي / لم يحضر --}}
            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            حجوزات مرفوضة / لم يحضر
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-cancelled">
                            {{ $cancelledPatients ?? 0 }}
                        </p>
                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-danger">
                        <i data-lucide="user-x" class="size-5"></i>
                    </span>

                </div>
            </div>


            {{-- مواعيد مغلقة --}}
            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            مواعيد مغلقة
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-slots-blocked">
                            {{ $slotsStats['blocked'] }}
                        </p>
                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-danger">
                        <i data-lucide="calendar-x" class="size-5"></i>
                    </span>

                </div>
            </div>


            {{-- الإيرادات: قفل كامل عن مساعد الطبيب --}}
            @if ($isClinicSystem)
                @unless ($isAssistant)
                    {{-- إيرادات اليوم --}}
                    <div class="stat-card">
                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">
                                <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                                    إيرادات اليوم
                                </p>

                                <p class="mt-2 text-2xl font-bold tabular-nums">
                                    {{ number_format($income['today'], 2) ?? 0 }}ج.م
                                </p>
                            </div>

                            <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-success">
                                <i data-lucide="circle-dollar-sign" class="size-5"></i>
                            </span>

                        </div>
                    </div>


                    {{-- إيرادات الشهر --}}
                    <div class="stat-card">
                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">
                                <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                                    إيرادات الشهر
                                </p>

                                <p class="mt-2 text-2xl font-bold tabular-nums">
                                    {{ number_format($income['month'], 2) ?? 0 }} ج.م
                                </p>
                            </div>

                            <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-primary">
                                <i data-lucide="trending-up" class="size-5"></i>
                            </span>

                        </div>
                    </div>
                @endunless
            @else
                @unless ($isAssistant)
                    {{-- Upgrade Card --}}
                    <div class="stat-card col-span-2 lg:col-span-2">
                        <div class="flex h-full items-center justify-between gap-4">

                            <div class="min-w-0">

                                <div class="flex items-center gap-2">
                                    <span class="grid size-9 shrink-0 place-items-center rounded-xl badge-primary">
                                        <i data-lucide="sparkles" class="size-4"></i>
                                    </span>

                                    <p class="text-sm font-bold">
                                        نظام العيادة
                                    </p>
                                </div>

                                <p class="mt-2 text-xs leading-5 text-muted-foreground">
                                    احصل على إدارة المرضى والملفات الطبية
                                    والإيرادات والتقارير بشكل متكامل.
                                </p>

                            </div>

                            <a href="#" class="btn btn-default btn-sm shrink-0">
                                <i data-lucide="arrow-up-circle" class="size-4"></i>
                                الترقية
                            </a>

                        </div>
                    </div>
                @endunless
            @endif

        </div>


        {{-- =========================
            Charts
        ========================== --}}
        <div class="mt-4 grid gap-4 lg:grid-cols-2">

            {{-- كل ما يخص الإيرادات والتقارير مقفول تمامًا عن مساعد الطبيب --}}
            @unless ($isAssistant)

                @if ($isClinicSystem)
                    {{-- الإيرادات --}}
                    <div class="section-card">

                        <div class="section-card-header">
                            <h2 class="text-sm font-bold sm:text-base">
                                الإيرادات — آخر ٧ أيام
                            </h2>
                        </div>

                        <div class="section-card-body">

                            <div class="h-56 w-full">

                                <div class="mini-chart">

                                    <div class="bar-col">
                                        <div class="bar" style="height:0%; background-color:var(--primary);"></div>
                                        <span class="bar-label">إث</span>
                                    </div>

                                    <div class="bar-col">
                                        <div class="bar" style="height:0%; background-color:var(--primary);"></div>
                                        <span class="bar-label">ثلا</span>
                                    </div>

                                    <div class="bar-col">
                                        <div class="bar" style="height:0%; background-color:var(--primary);"></div>
                                        <span class="bar-label">أرب</span>
                                    </div>

                                    <div class="bar-col">
                                        <div class="bar" style="height:100%; background-color:var(--primary);"></div>
                                        <span class="bar-label">خم</span>
                                    </div>

                                    <div class="bar-col">
                                        <div class="bar" style="height:67%; background-color:var(--primary);"></div>
                                        <span class="bar-label">جم</span>
                                    </div>

                                    <div class="bar-col">
                                        <div class="bar" style="height:0%; background-color:var(--primary);"></div>
                                        <span class="bar-label">سبت</span>
                                    </div>

                                    <div class="bar-col">
                                        <div class="bar" style="height:100%; background-color:var(--primary);"></div>
                                        <span class="bar-label">أحد</span>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                @else
                    {{-- Upgrade Chart --}}
                    <div class="section-card">

                        <div class="section-card-body">

                            <div class="flex min-h-56 flex-col items-center justify-center text-center">

                                <span class="grid size-14 place-items-center rounded-2xl bg-primary/10 text-primary">
                                    <i data-lucide="chart-no-axes-combined" class="size-7"></i>
                                </span>

                                <h2 class="mt-4 text-base font-bold">
                                    تقارير الإيرادات
                                </h2>

                                <p class="mt-2 max-w-md text-sm leading-6 text-muted-foreground">
                                    تابع إيرادات عيادتك يوميًا وشهريًا
                                    واعرف أداء الحجوزات بالتفصيل مع نظام العيادة.
                                </p>

                                <a href="#" class="btn btn-default btn-sm mt-4">
                                    <i data-lucide="lock-open" class="size-4"></i>
                                    فتح الميزة
                                </a>

                            </div>

                        </div>

                    </div>
                @endif

            @endunless

            {{-- الحجوزات أونلاين مقابل العيادة --}}
            <div class="section-card {{ $isAssistant ? 'lg:col-span-2' : '' }}">

                <div class="section-card-header">
                    <h2 class="text-sm font-bold sm:text-base">
                        الحجوزات — أونلاين مقابل العيادة
                    </h2>
                </div>

                <div class="section-card-body">

                    <div class="h-56 w-full">

                        <div class="mini-chart">

                            <div class="bar-col">
                                <div
                                    style="display:flex;gap:3px;align-items:flex-end;height:100%;width:100%;justify-content:center;">
                                    <div class="bar"
                                        style="height:0%;background-color:var(--chart-1);max-width:.7rem;">
                                    </div>

                                    <div class="bar"
                                        style="height:0%;background-color:var(--chart-4);max-width:.7rem;">
                                    </div>
                                </div>

                                <span class="bar-label">إث</span>
                            </div>


                            <div class="bar-col">
                                <div
                                    style="display:flex;gap:3px;align-items:flex-end;height:100%;width:100%;justify-content:center;">
                                    <div class="bar"
                                        style="height:25%;background-color:var(--chart-1);max-width:.7rem;">
                                    </div>

                                    <div class="bar"
                                        style="height:0%;background-color:var(--chart-4);max-width:.7rem;">
                                    </div>
                                </div>

                                <span class="bar-label">ثلا</span>
                            </div>


                            <div class="bar-col">
                                <div
                                    style="display:flex;gap:3px;align-items:flex-end;height:100%;width:100%;justify-content:center;">
                                    <div class="bar"
                                        style="height:0%;background-color:var(--chart-1);max-width:.7rem;">
                                    </div>

                                    <div class="bar"
                                        style="height:0%;background-color:var(--chart-4);max-width:.7rem;">
                                    </div>
                                </div>

                                <span class="bar-label">أرب</span>
                            </div>


                            <div class="bar-col">
                                <div
                                    style="display:flex;gap:3px;align-items:flex-end;height:100%;width:100%;justify-content:center;">
                                    <div class="bar"
                                        style="height:0%;background-color:var(--chart-1);max-width:.7rem;">
                                    </div>

                                    <div class="bar"
                                        style="height:25%;background-color:var(--chart-4);max-width:.7rem;">
                                    </div>
                                </div>

                                <span class="bar-label">خم</span>
                            </div>


                            <div class="bar-col">
                                <div
                                    style="display:flex;gap:3px;align-items:flex-end;height:100%;width:100%;justify-content:center;">
                                    <div class="bar"
                                        style="height:25%;background-color:var(--chart-1);max-width:.7rem;">
                                    </div>

                                    <div class="bar"
                                        style="height:0%;background-color:var(--chart-4);max-width:.7rem;">
                                    </div>
                                </div>

                                <span class="bar-label">جم</span>
                            </div>


                            <div class="bar-col">
                                <div
                                    style="display:flex;gap:3px;align-items:flex-end;height:100%;width:100%;justify-content:center;">
                                    <div class="bar"
                                        style="height:0%;background-color:var(--chart-1);max-width:.7rem;">
                                    </div>

                                    <div class="bar"
                                        style="height:0%;background-color:var(--chart-4);max-width:.7rem;">
                                    </div>
                                </div>

                                <span class="bar-label">سبت</span>
                            </div>


                            <div class="bar-col">
                                <div
                                    style="display:flex;gap:3px;align-items:flex-end;height:100%;width:100%;justify-content:center;">
                                    <div class="bar"
                                        style="height:100%;background-color:var(--chart-1);max-width:.7rem;">
                                    </div>

                                    <div class="bar"
                                        style="height:50%;background-color:var(--chart-4);max-width:.7rem;">
                                    </div>
                                </div>

                                <span class="bar-label">أحد</span>
                            </div>

                        </div>

                    </div>


                    <div class="mt-3 flex items-center gap-4 text-xs text-muted-foreground">

                        <span class="flex items-center gap-1.5">
                            <span class="size-2.5 rounded-full" style="background-color:var(--chart-1)">
                            </span>

                            أونلاين
                        </span>

                        <span class="flex items-center gap-1.5">
                            <span class="size-2.5 rounded-full" style="background-color:var(--chart-4)">
                            </span>

                            العيادة
                        </span>

                    </div>

                </div>
            </div>

        </div>


        {{-- =========================
            Bottom Sections
        ========================== --}}
        <div class="mt-4 grid gap-4 lg:grid-cols-3">


            {{-- جدول اليوم --}}
            <div class="section-card">

                <div class="section-card-header">

                    <h2 class="text-sm font-bold sm:text-base">
                        جدول اليوم
                    </h2>

                    <a href="{{ route('clinic.slots.index') }}" class="text-xs font-semibold text-primary">
                        عرض الكل
                    </a>

                </div>

                <div class="section-card-body">

                    <ul id="schedule-list" class="clinic-scroll-y max-h-72 space-y-2 pe-1">
                        @include('doctor.clinic.dashboard.partials.schedule-list', ['scheduleSlots' => $scheduleSlots])
                    </ul>

                </div>
            </div>


            {{-- طابور الانتظار --}}
            <div class="section-card">

                <div class="section-card-header">

                    <h2 class="text-sm font-bold sm:text-base">
                        طابور الانتظار
                    </h2>

                    <a href="{{ route('clinic.bookings.index') }}" class="text-xs font-semibold text-primary">
                        إدارة الطابور
                    </a>

                </div>

                <div class="section-card-body">

                    <ul id="queue-list" class="space-y-2">
                        @include('doctor.clinic.dashboard.partials.queue-list', ['dashboardQueue' => $dashboardQueue])
                    </ul>

                </div>
            </div>


            {{-- آخر الحجوزات --}}
            <div class="section-card">

                <div class="section-card-header">

                    <h2 class="text-sm font-bold sm:text-base">
                        آخر الحجوزات
                    </h2>

                    <a href="{{ route('clinic.bookings.index') }}" class="text-xs font-semibold text-primary">
                        عرض الكل
                    </a>

                </div>

                <div class="section-card-body">

                    <ul id="recent-bookings-list" class="space-y-2">
                        @include('doctor.clinic.dashboard.partials.recent-bookings', ['recentBookings' => $recentBookings])
                    </ul>

                </div>
            </div>

        </div>

    </main>

    @push('extra_java')
        <script>
            window.ClinicDashboardConfig = {
                queueDataUrl: @json(route('clinic.dashboard.queue-data')),
            };
        </script>

        <script src="{{ asset('js/clinic/dashboard.js') }}"></script>
    @endpush

@endsection

@extends('doctor.layouts.app_clinc')

@section('title', 'التقارير | دليل الأطباء')

@section('content')

    <main class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

        {{-- =========================================================
            Header
        ========================================================== --}}

        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">

                <h1 class="truncate text-xl font-bold sm:text-2xl">
                    التقارير
                </h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    ملخص أداء العيادة والحجوزات والمرضى خلال الفترة المحددة.
                </p>

            </div>


            <form method="GET" class="flex flex-wrap items-center gap-2">

                <select name="period" class="field-select w-full sm:w-40" onchange="this.form.submit()">

                    <option value="month" @selected($period === 'month')>
                        هذا الشهر
                    </option>

                    <option value="week" @selected($period === 'week')>
                        آخر 7 أيام
                    </option>

                    <option value="quarter" @selected($period === 'quarter')>
                        آخر 3 شهور
                    </option>

                    <option value="year" @selected($period === 'year')>
                        هذه السنة
                    </option>

                </select>

            </form>

        </div>



        {{-- =========================================================
            Booking Statistics
        ========================================================== --}}

        <div class="mb-4 grid grid-cols-2 gap-3 lg:grid-cols-4">


            {{-- إجمالي الحجوزات --}}
            <div class="stat-card">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">

                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            إجمالي الحجوزات
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums">
                            {{ $totalBookings }}
                        </p>

                        <p class="mt-1 text-xs text-muted-foreground">
                            خلال الفترة المحددة
                        </p>

                    </div>


                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-primary">

                        <i data-lucide="calendar-days" class="size-5"></i>

                    </span>

                </div>

            </div>



            {{-- الحجوزات المكتملة --}}
            <div class="stat-card">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">

                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            الحجوزات المكتملة
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums">
                            {{ $completedBookings }}
                        </p>


                        <div class="mt-1 flex items-center gap-1.5">

                            <span class="text-xs font-semibold text-success">
                                {{ $completedPercentage }}%
                            </span>

                            <span class="text-xs text-muted-foreground">
                                من إجمالي الحجوزات
                            </span>

                        </div>

                    </div>


                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-success">

                        <i data-lucide="circle-check-big" class="size-5"></i>

                    </span>

                </div>

            </div>



            {{-- الحجوزات الملغاة --}}
            <div class="stat-card">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">

                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            الملغاة / لم يحضر
                        </p>
                        <p class="mt-2 text-2xl font-bold tabular-nums">
                            {{ $cancelledBookings }}
                        </p>


                        <div class="mt-1 flex items-center gap-1.5">

                            <span class="text-xs font-semibold text-destructive">
                                {{ $cancelledPercentage }}%
                            </span>

                            <span class="text-xs text-muted-foreground">
                                نسبة الإلغاء
                            </span>

                        </div>

                    </div>


                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-danger">

                        <i data-lucide="calendar-x" class="size-5"></i>

                    </span>

                </div>

            </div>



            {{-- متوسط الحجوزات يوميًا --}}
            <div class="stat-card">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">

                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            متوسط الحجوزات يوميًا
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums">
                            {{ $averageBookingsPerDay }}
                        </p>

                        <p class="mt-1 text-xs text-muted-foreground">
                            حجز في اليوم
                        </p>

                    </div>


                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-info">

                        <i data-lucide="calendar-range" class="size-5"></i>

                    </span>

                </div>

            </div>

        </div>



        {{-- =========================================================
            Patients Summary
        ========================================================== --}}

        <div class="section-card mb-4">

            <div class="section-card-header">

                <div>

                    <h2 class="text-sm font-bold sm:text-base">
                        ملخص المرضى
                    </h2>

                    <p class="mt-1 text-xs text-muted-foreground">
                        نظرة سريعة على عدد المرضى المسجلين والمرضى الجدد — الأرقام دي ثابتة ومش بتتأثر بفلتر الفترة فوق.
                    </p>

                </div>

            </div>


            <div class="section-card-body">

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">


                    {{-- إجمالي المرضى --}}
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-border bg-background p-4">

                        <div class="flex min-w-0 items-center gap-3">

                            <span class="grid size-11 shrink-0 place-items-center rounded-xl badge-primary">

                                <i data-lucide="users" class="size-5"></i>

                            </span>


                            <div class="min-w-0">

                                <p class="text-xs font-medium text-muted-foreground sm:text-sm">
                                    إجمالي المرضى
                                </p>

                                <p class="mt-1 text-xs text-muted-foreground">
                                    جميع المرضى المسجلين بالعيادة
                                </p>

                            </div>

                        </div>


                        <p class="shrink-0 text-2xl font-bold tabular-nums">
                            {{ $totalPatients }}
                        </p>

                    </div>



                    {{-- مرضى جدد هذا الشهر --}}
                    <div class="flex items-center justify-between gap-4 rounded-xl border border-border bg-background p-4">

                        <div class="flex min-w-0 items-center gap-3">

                            <span class="grid size-11 shrink-0 place-items-center rounded-xl badge-success">

                                <i data-lucide="user-plus" class="size-5"></i>

                            </span>


                            <div class="min-w-0">

                                <p class="text-xs font-medium text-muted-foreground sm:text-sm">
                                    مرضى جدد هذا الشهر
                                </p>

                                <p class="mt-1 text-xs text-muted-foreground">
                                    ملفات مرضى أُضيفت خلال الشهر الحالي
                                </p>

                            </div>

                        </div>


                        <p class="shrink-0 text-2xl font-bold tabular-nums">
                            {{ $newPatientsThisMonth }}
                        </p>

                    </div>


                </div>

            </div>

        </div>



        {{-- =========================================================
            Bookings Chart (آخر 6 شهور — أونلاين مقابل عيادة)
        ========================================================== --}}

        <div class="section-card mb-4">

            <div class="section-card-header flex flex-wrap items-center justify-between gap-2">

                <div>

                    <h2 class="text-sm font-bold sm:text-base">
                        الحجوزات شهريًا
                    </h2>

                    <p class="mt-1 text-xs text-muted-foreground">
                        متابعة تغير عدد الحجوزات خلال الشهور الأخيرة.
                    </p>

                </div>


                <div class="flex items-center gap-4">

                    <span class="flex items-center gap-1.5 text-xs text-muted-foreground">
                        <span class="size-2.5 rounded-full" style="background-color:var(--chart-1);"></span>
                        أونلاين
                    </span>

                    <span class="flex items-center gap-1.5 text-xs text-muted-foreground">
                        <span class="size-2.5 rounded-full" style="background-color:var(--chart-4);"></span>
                        من العيادة
                    </span>

                </div>

            </div>


            <div class="section-card-body">

                <div class="h-56 w-full">

                    <div class="mini-chart">

                        @foreach ($monthlyChart as $month)
                            <div class="bar-col">

                                <div style="
                                        display:flex;
                                        gap:3px;
                                        align-items:flex-end;
                                        height:100%;
                                        width:100%;
                                        justify-content:center;
                                    "
                                    title="{{ $month['label'] }}: أونلاين {{ $month['online'] }} / عيادة {{ $month['clinic'] }}">

                                    <div class="bar"
                                        style="
                                            height:{{ $month['onlineHeight'] }}%;
                                            background-color:var(--chart-1);
                                            max-width:.7rem;
                                        ">
                                    </div>

                                    <div class="bar"
                                        style="
                                            height:{{ $month['clinicHeight'] }}%;
                                            background-color:var(--chart-4);
                                            max-width:.7rem;
                                        ">
                                    </div>

                                </div>

                                <span class="bar-label">
                                    {{ $month['label'] }}
                                </span>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
            Busiest Days
        ========================================================== --}}

        <div class="section-card mb-4">

            <div class="section-card-header flex flex-wrap items-center justify-between gap-2">

                <div>

                    <h2 class="text-sm font-bold sm:text-base">
                        أكثر أيام الأسبوع ازدحامًا
                    </h2>

                    <p class="mt-1 text-xs text-muted-foreground">
                        توزيع الحجوزات حسب يوم الأسبوع خلال الفترة المحددة.
                    </p>

                </div>


                @if ($topDay && $topDay['count'] > 0)
                    <span class="badge badge-primary">

                        <i data-lucide="flame" class="size-3.5"></i>

                        الأكثر ازدحامًا:
                        {{ $topDay['day'] }}

                    </span>
                @endif

            </div>


            <div class="section-card-body">

                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:grid-cols-7">

                    @foreach ($busyDays as $day)
                        @php
                            $percentage = $maxBusyDay > 0 ? ($day['count'] / $maxBusyDay) * 100 : 0;

                            $isTopDay = $maxBusyDay > 0 && $day['count'] === $maxBusyDay;
                        @endphp


                        <div
                            class="
                                rounded-xl border p-3
                                {{ $isTopDay ? 'border-primary/40 bg-primary/5' : 'border-border bg-background' }}
                            ">

                            <div class="mb-3 flex items-center justify-between gap-2">

                                <span class="text-sm font-semibold">
                                    {{ $day['day'] }}
                                </span>


                                @if ($isTopDay)
                                    <span class="grid size-7 place-items-center rounded-lg badge-primary"
                                        title="أكثر الأيام ازدحامًا">

                                        <i data-lucide="flame" class="size-3.5"></i>

                                    </span>
                                @endif

                            </div>


                            <p class="text-xl font-bold tabular-nums">

                                {{ $day['count'] }}

                                <span class="text-xs font-normal text-muted-foreground">
                                    حجز
                                </span>

                            </p>


                            <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-muted">

                                <div class="h-full rounded-full"
                                    style="
                                        width: {{ $percentage }}%;
                                        background-color: var(--primary);
                                    ">
                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>



        {{-- =========================================================
            Booking Sources
        ========================================================== --}}

        <div class="section-card mb-4">

            <div class="section-card-header flex flex-wrap items-center justify-between gap-2">

                <div>

                    <h2 class="text-sm font-bold sm:text-base">
                        مصادر الحجز
                    </h2>

                    <p class="mt-1 text-xs text-muted-foreground">
                        توزيع الحجوزات حسب طريقة تسجيل الحجز.
                    </p>

                </div>

            </div>


            <div class="section-card-body">

                <div class="overflow-x-auto">

                    <table class="clinic-table">

                        <thead>

                            <tr>

                                <th>
                                    المصدر
                                </th>

                                <th>
                                    عدد الحجوزات
                                </th>

                                <th>
                                    النسبة
                                </th>

                            </tr>

                        </thead>


                        <tbody id="rep-src">

                            @foreach ($bookingSources as $source)
                                <tr>

                                    <td>

                                        <div class="flex items-center gap-2">

                                            <span
                                                class="grid size-8 place-items-center rounded-lg {{ $source['badge'] }}">

                                                <i data-lucide="{{ $source['icon'] }}" class="size-4"></i>

                                            </span>

                                            <span>
                                                {{ $source['label'] }}
                                            </span>

                                        </div>

                                    </td>


                                    <td>

                                        <span class="tabular-nums">
                                            {{ $source['count'] }}
                                        </span>

                                    </td>


                                    <td>

                                        <span class="badge {{ $source['badge'] }}">
                                            {{ $source['percentage'] }}%
                                        </span>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


    </main>

@endsection

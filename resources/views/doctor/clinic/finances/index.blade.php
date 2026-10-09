@extends('doctor.layouts.app_clinc')

@section('title', 'المدفوعات والإيرادات | دليل الأطباء')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/clinic/clinic-payments.css') }}">
@endpush

@section('content')

    @php
        $fmt = fn ($n) => \App\Support\Money::fmt($n);
        $hasFilters = $q !== '' || $type;

        $todayNet = (float) $today['income'] - (float) $today['expense'];
        $periodNet = (float) $period['income'] - (float) $period['expense'];
    @endphp

    <main class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="min-w-0">
                <h1 class="truncate text-xl font-bold sm:text-2xl">المدفوعات والإيرادات</h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    إيرادات الحجوزات + الفواتير والمصروفات المسجلة يدويًا.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <x-doctor.clinic.invoice-form :service-names="$serviceNames" />
            </div>
        </div>


        {{-- Stats --}}
        <div class="mb-5 grid grid-cols-2 gap-3 lg:grid-cols-4">

            {{-- إيراد اليوم --}}
            <div class="stat-card">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">

                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            إيراد اليوم
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums">
                            {{ $fmt($today['income']) }} ج.م
                        </p>

                        <div class="mt-1 flex flex-wrap items-center gap-1 text-xs text-muted-foreground">

                            <span>
                                مصروفات اليوم:
                            </span>

                            <span class="font-semibold text-destructive">
                                {{ $fmt($today['expense']) }} ج.م
                            </span>

                            @if ((float) $today['expense'] > 0)
                                <i data-lucide="arrow-down" class="size-3.5 text-destructive"></i>
                            @endif

                        </div>

                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-success">
                        <i data-lucide="wallet" class="size-5"></i>
                    </span>

                </div>

            </div>


            {{-- إيراد الفترة --}}
            <div class="stat-card">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">

                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            إيراد الفترة
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums">
                            {{ $fmt($period['income']) }} ج.م
                        </p>

                        {{-- الصافي --}}
                        <div class="mt-1 flex flex-wrap items-center gap-1 text-xs">

                            <span class="text-muted-foreground">
                                الصافي:
                            </span>

                            @if ($periodNet > 0)

                                <span class="font-semibold text-success">
                                    +{{ $fmt($periodNet) }} ج.م
                                </span>

                                <i
                                    data-lucide="arrow-up"
                                    class="size-3.5 text-success"
                                ></i>

                            @elseif ($periodNet < 0)

                                <span class="font-semibold text-destructive">
                                    −{{ $fmt(abs($periodNet)) }} ج.م
                                </span>

                                <i
                                    data-lucide="arrow-down"
                                    class="size-3.5 text-destructive"
                                ></i>

                            @else

                                <span class="font-semibold text-muted-foreground">
                                    0 ج.م
                                </span>

                                <i
                                    data-lucide="minus"
                                    class="size-3.5 text-muted-foreground"
                                ></i>

                            @endif

                        </div>

                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-primary">
                        <i data-lucide="trending-up" class="size-5"></i>
                    </span>

                </div>

            </div>


            {{-- مصروفات الفترة --}}
            <div class="stat-card">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">

                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            مصروفات الفترة
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums text-destructive">
                            {{ $fmt($period['expense']) }} ج.م
                        </p>

                        <div class="mt-1 flex items-center gap-1 text-xs">

                            <span class="text-muted-foreground">
                                مسجلة يدويًا
                            </span>

                            @if ((float) $period['expense'] > 0)
                                <i
                                    data-lucide="arrow-down"
                                    class="size-3.5 text-destructive"
                                ></i>
                            @endif

                        </div>

                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-danger">
                        <i data-lucide="trending-down" class="size-5"></i>
                    </span>

                </div>

            </div>


            {{-- المستحقات --}}
            <div class="stat-card">

                <div class="flex items-start justify-between gap-3">

                    <div class="min-w-0">

                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">
                            مستحقات غير محصلة
                        </p>

                        <p class="mt-2 text-2xl font-bold tabular-nums">
                            {{ $fmt($dues->total) }} ج.م
                        </p>

                        <p class="mt-1 text-xs text-muted-foreground">
                            {{ $dues->c }} حجز
                        </p>

                    </div>

                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-warning">
                        <i data-lucide="clock" class="size-5"></i>
                    </span>

                </div>

            </div>

        </div>


        {{-- Chart --}}
        <div class="section-card mb-4">

            <div class="section-card-header">
                <h2 class="text-sm font-bold sm:text-base">
                    إيرادات آخر 7 أيام
                </h2>
            </div>

            <div class="section-card-body">

                <div class="h-56 w-full">

                    <div class="mini-chart">

                        @foreach ($chart as $day)

                            <div
                                class="bar-col"
                                title="{{ $fmt($day['total']) }} ج.م"
                            >

                                <div
                                    class="bar"
                                    style="height:{{ $day['height'] }}%; background-color:var(--primary);"
                                ></div>

                                <span class="bar-label">
                                    {{ $day['label'] }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>


        {{-- Filters --}}
        <form
            method="GET"
            class="clinic-surface-card my-4 flex flex-col gap-3 p-3 sm:flex-row sm:flex-wrap sm:items-end"
        >

            <div class="relative flex-1">

                @if ($hasFilters)

                    <a
                        href="{{ route('clinic.payments.index') }}"
                        class="btn btn-destructive btn-sm absolute left-2 z-10 flex items-center justify-center gap-1"
                        title="إلغاء الفلاتر"
                    >
                        <span class="text-xs font-bold leading-none">
                            ✕
                        </span>
                    </a>

                @endif

                <input
                    type="text"
                    name="q"
                    value="{{ $q }}"
                    class="field-input ps-9 pl-9"
                    placeholder="ابحث باسم المريض أو البيان..."
                >

                <i
                    data-lucide="search"
                    class="pointer-events-none absolute inset-y-0 start-3 my-auto size-4 text-muted-foreground"
                ></i>

            </div>


            <select
                name="type"
                class="field-select sm:w-40"
            >

                <option value="">
                    كل الأنواع
                </option>

                <option
                    value="income"
                    @selected($type === 'income')
                >
                    إيراد
                </option>

                <option
                    value="expense"
                    @selected($type === 'expense')
                >
                    مصروف
                </option>

                <option
                    value="due"
                    @selected($type === 'due')
                >
                    مستحق
                </option>

            </select>


            <input
                type="date"
                name="from"
                value="{{ $from }}"
                dir="ltr"
                class="field-input sm:w-40"
            >

            <input
                type="date"
                name="to"
                value="{{ $to }}"
                dir="ltr"
                class="field-input sm:w-40"
            >


            <button
                type="submit"
                class="btn btn-default"
            >

                <i
                    data-lucide="search"
                    class="size-4"
                ></i>

                تطبيق

            </button>

        </form>


        <p class="mb-3 text-xs text-muted-foreground">

            {{ \Carbon\Carbon::parse($from)->translatedFormat('j F Y') }}

            —

            {{ \Carbon\Carbon::parse($to)->translatedFormat('j F Y') }}

        </p>


        {{-- Results --}}
        <div id="payments-results">

            @if ($rows->count())


                {{-- Desktop --}}
                <div class="clinic-surface-card hidden overflow-hidden md:block">

                    <div class="w-full overflow-x-auto">

                        <table class="clinic-table w-full min-w-[900px]">

                            <thead>

                                <tr>

                                    <th>
                                        التاريخ
                                    </th>

                                    <th>
                                        المريض / الجهة
                                    </th>

                                    <th>
                                        البيان
                                    </th>

                                    <th>
                                        النوع
                                    </th>

                                    <th>
                                        الدفع
                                    </th>

                                    <th class="text-center">
                                        إجراءات
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($rows as $row)

                                    @php
                                        $isBooking = $row->source === 'booking';

                                        $isExpense =
                                            $row->type === 'expense';

                                        $remaining =
                                            $isBooking
                                                ? max(
                                                    0,
                                                    (float) $row->expected -
                                                    (float) $row->amount
                                                )
                                                : 0;

                                        $hasNote =
                                            ! empty(
                                                trim(
                                                    (string) ($row->notes ?? '')
                                                )
                                            );
                                    @endphp


                                    <tr class="border-t border-border hover:bg-muted/40">


                                        <td class="px-4 py-3 tabular-nums">

                                            {{ \Carbon\Carbon::parse($row->row_date)->translatedFormat('j F Y') }}

                                        </td>


                                        <td class="px-4 py-3">

                                            @if (! empty($row->patient_id))

                                                <a
                                                    href="{{ route('clinic.patients.show', $row->patient_id) }}"
                                                    class="font-medium text-primary hover:underline"
                                                >
                                                    {{ $row->patient_name ?: '—' }}
                                                </a>

                                            @else

                                                <p class="font-medium">
                                                    {{ $row->patient_name ?: 'العيادة' }}
                                                </p>

                                            @endif

                                        </td>


                                        <td class="px-4 py-3">

                                            <p>
                                                {{ $row->title ?: '—' }}
                                            </p>

                                            <p class="text-xs text-muted-foreground">

                                                {{ $isBooking ? 'من الحجز' : 'مسجل يدويًا' }}

                                            </p>

                                        </td>


                                        <td class="px-4 py-3">

                                            @if ($isExpense)

                                                <span class="badge badge-danger">
                                                    مصروف
                                                </span>

                                            @else

                                                <div class="flex flex-wrap items-center gap-1.5">

                                                    <span class="badge badge-success">
                                                        إيراد
                                                    </span>

                                                    @if ($isBooking && $remaining > 0)

                                                        <span class="badge badge-warning">
                                                            مستحق
                                                        </span>

                                                    @endif

                                                </div>

                                            @endif

                                        </td>


                                        <td class="px-4 py-3 tabular-nums">

                                            <p class="font-semibold {{ $isExpense ? 'text-destructive' : '' }}">

                                                {{ $isExpense ? 'المصروف: −' : 'المدفوع: ' }}

                                                {{ $fmt($row->amount) }} ج.م

                                            </p>


                                            @if ($isBooking)

                                                <p class="mt-1 text-xs text-muted-foreground">

                                                    الإجمالي:
                                                    {{ $fmt($row->expected) }}
                                                    ج.م

                                                </p>


                                                @if ($remaining > 0)

                                                    <p class="text-xs text-warning">

                                                        المتبقي:
                                                        {{ $fmt($remaining) }}
                                                        ج.م

                                                    </p>

                                                @endif

                                            @endif

                                        </td>


                                        <td class="px-4 py-3 text-center">

                                            @if ($isBooking)

                                                <button
                                                    type="button"
                                                    class="btn btn-icon-sm"
                                                    data-edit-payment
                                                    data-id="{{ $row->row_id }}"
                                                    data-name="{{ $row->patient_name }}"
                                                    data-price="{{ (float) $row->expected }}"
                                                    data-paid="{{ (float) $row->amount }}"
                                                    title="تعديل الدفع"
                                                    aria-label="تعديل الدفع"
                                                >

                                                    <i
                                                        data-lucide="wallet"
                                                        class="size-4"
                                                    ></i>

                                                </button>

                                            @else

                                                <div class="dropdown relative inline-block">

                                                    <button
                                                        type="button"
                                                        class="btn btn-icon-sm"
                                                        data-dropdown-trigger
                                                        aria-label="إجراءات الحركة"
                                                    >

                                                        <i data-lucide="more-horizontal"></i>

                                                    </button>


                                                    <div class="dropdown-menu dropdown-menu-end min-w-[200px]">

                                                        @if ($hasNote)

                                                            <button
                                                                type="button"
                                                                class="dropdown-item"
                                                                data-payment-note
                                                                data-note="{{ $row->notes }}"
                                                                data-title="{{ $row->title ?: 'ملاحظة الحركة' }}"
                                                            >

                                                                <i data-lucide="message-square-text"></i>

                                                                عرض الملاحظة

                                                            </button>

                                                            <div class="my-1 h-px bg-border"></div>

                                                        @endif


                                                        <form
                                                            method="POST"
                                                            action="{{ route('clinic.payments.destroy', $row->row_id) }}"
                                                            onsubmit="return confirm('حذف هذا السجل؟')"
                                                        >

                                                            @csrf
                                                            @method('DELETE')

                                                            <button
                                                                type="submit"
                                                                class="dropdown-item danger"
                                                            >

                                                                <i data-lucide="trash-2"></i>

                                                                حذف الحركة

                                                            </button>

                                                        </form>

                                                    </div>

                                                </div>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- Mobile --}}
                <div class="space-y-3 md:hidden">

                    @foreach ($rows as $row)

                        @php
                            $isBooking = $row->source === 'booking';

                            $isExpense =
                                $row->type === 'expense';

                            $remaining =
                                $isBooking
                                    ? max(
                                        0,
                                        (float) $row->expected -
                                        (float) $row->amount
                                    )
                                    : 0;

                            $hasNote =
                                ! empty(
                                    trim(
                                        (string) ($row->notes ?? '')
                                    )
                                );
                        @endphp


                        <div class="clinic-surface-card p-4">

                            <div class="mb-3 flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    @if (! empty($row->patient_id))

                                        <a
                                            href="{{ route('clinic.patients.show', $row->patient_id) }}"
                                            class="font-medium text-primary hover:underline"
                                        >
                                            {{ $row->patient_name ?: '—' }}
                                        </a>

                                    @else

                                        <p class="font-medium">
                                            {{ $row->patient_name ?: 'العيادة' }}
                                        </p>

                                    @endif


                                    <p class="mt-1 text-xs text-muted-foreground">

                                        {{ $row->title ?: '—' }}

                                    </p>

                                </div>


                                @if ($isExpense)

                                    <span class="badge badge-danger shrink-0">
                                        مصروف
                                    </span>

                                @else

                                    <span class="badge badge-success shrink-0">
                                        إيراد
                                    </span>

                                @endif

                            </div>


                            <div class="grid grid-cols-2 gap-3 border-y border-border py-3">

                                <div>

                                    <p class="text-xs text-muted-foreground">
                                        التاريخ
                                    </p>

                                    <p class="mt-1 text-sm font-medium tabular-nums">

                                        {{ \Carbon\Carbon::parse($row->row_date)->translatedFormat('j M Y') }}

                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs text-muted-foreground">
                                        المصدر
                                    </p>

                                    <p class="mt-1 text-sm font-medium">

                                        {{ $isBooking ? 'من الحجز' : 'مسجل يدويًا' }}

                                    </p>

                                </div>

                            </div>


                            <div class="mt-3 space-y-2 text-sm">

                                <div class="flex items-center justify-between gap-3">

                                    <span class="text-muted-foreground">
                                        المبلغ
                                    </span>

                                    <span class="font-semibold tabular-nums {{ $isExpense ? 'text-destructive' : '' }}">

                                        {{ $isExpense ? '−' : '' }}

                                        {{ $fmt($row->amount) }} ج.م

                                    </span>

                                </div>


                                @if ($isBooking)

                                    <div class="flex items-center justify-between gap-3">

                                        <span class="text-muted-foreground">
                                            الإجمالي
                                        </span>

                                        <span class="tabular-nums">
                                            {{ $fmt($row->expected) }} ج.م
                                        </span>

                                    </div>


                                    @if ($remaining > 0)

                                        <div class="flex items-center justify-between gap-3">

                                            <span class="text-muted-foreground">
                                                المتبقي
                                            </span>

                                            <span class="badge badge-warning tabular-nums">
                                                {{ $fmt($remaining) }} ج.م
                                            </span>

                                        </div>

                                    @endif

                                @endif

                            </div>


                            <div class="mt-4 flex gap-2 border-t border-border pt-3">

                                @if ($isBooking)

                                    <button
                                        type="button"
                                        class="btn btn-default flex-1"
                                        data-edit-payment
                                        data-id="{{ $row->row_id }}"
                                        data-name="{{ $row->patient_name }}"
                                        data-price="{{ (float) $row->expected }}"
                                        data-paid="{{ (float) $row->amount }}"
                                    >

                                        <i
                                            data-lucide="wallet"
                                            class="size-4"
                                        ></i>

                                        تعديل الدفع

                                    </button>

                                @else

                                    @if ($hasNote)

                                        <button
                                            type="button"
                                            class="btn btn-outline flex-1"
                                            data-payment-note
                                            data-note="{{ $row->notes }}"
                                            data-title="{{ $row->title ?: 'ملاحظة الحركة' }}"
                                        >

                                            <i
                                                data-lucide="message-square-text"
                                                class="size-4"
                                            ></i>

                                            الملاحظة

                                        </button>

                                    @endif


                                    <form
                                        method="POST"
                                        action="{{ route('clinic.payments.destroy', $row->row_id) }}"
                                        onsubmit="return confirm('حذف هذا السجل؟')"
                                        class="{{ $hasNote ? '' : 'flex-1' }}"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-destructive {{ $hasNote ? '' : 'w-full' }}"
                                            aria-label="حذف الحركة"
                                        >

                                            <i
                                                data-lucide="trash-2"
                                                class="size-4"
                                            ></i>

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <x-home.banner.no_results
                    logo="fa-solid fa-magnifying-glass"
                    title="لا توجد حركات مالية"
                    content="لم يتم العثور على أي مدفوعات أو إيرادات أو مصروفات مطابقة للفترة والفلاتر المحددة."
                />

            @endif

        </div>


        {{-- Pagination --}}
        @if ($rows->hasPages())

            <div class="mt-4">
                {{ $rows->links('vendor.pagination.custom') }}
            </div>

        @endif

    </main>


    {{-- مودال تعديل الدفع --}}
    <x-doctor.clinic.edit-payment-modal />


    {{-- مودال عرض ملاحظة الحركة اليدوية --}}
    <div
        class="payment-note-modal"
        data-payment-note-modal
        aria-hidden="true"
    >

        <div
            class="payment-note-panel"
            role="dialog"
            aria-modal="true"
            aria-labelledby="payment-note-modal-title"
            dir="rtl"
        >

            <div class="payment-note-header">

                <div class="payment-note-title-wrap">

                    <div class="payment-note-icon">
                        <i
                            data-lucide="notebook-pen"
                            class="size-5"
                        ></i>
                    </div>

                    <div class="min-w-0">

                        <h3
                            id="payment-note-modal-title"
                            class="truncate text-lg font-bold"
                        >
                            ملاحظة الحركة
                        </h3>

                        <p class="mt-1 text-xs text-muted-foreground">
                            التفاصيل الإضافية المسجلة مع الحركة المالية
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    class="btn btn-icon"
                    data-payment-note-close
                    aria-label="إغلاق"
                    title="إغلاق"
                >

                    <i
                        data-lucide="x"
                        class="size-5"
                    ></i>

                </button>

            </div>


            <div class="payment-note-body">

                <div
                    class="payment-note-content"
                    data-payment-note-content
                ></div>

                <div
                    class="payment-note-meta"
                    data-payment-note-meta
                ></div>

            </div>

        </div>

    </div>

@endsection


@push('extra_java')

    <script src="{{ asset('js/clinic/patient_search.js') }}"></script>

    {{-- مودال تعديل الدفع بيحتاج نفس الإعدادات المستخدمة في صفحة الحجوزات --}}
    <script>
        window.BookingPageConfig = window.BookingPageConfig || {
            csrfToken: @json(csrf_token()),
            bookingsBaseUrl: @json(url('/clinic/bookings')),
        };
    </script>

    <script src="{{ asset('js/clinic/booking-index.js') }}"></script>
    <script src="{{ asset('js/clinic/clinic-payments.js') }}"></script>

@endpush

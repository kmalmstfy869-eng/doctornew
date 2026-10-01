@extends('doctor.layouts.app_clinc')

@section('title', 'سجل الحجوزات | دليل الأطباء')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
@endpush

@section('content')

    <main class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">

                <h1 class="truncate text-xl font-bold sm:text-2xl">
                    سجل الحجوزات
                </h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    جميع الحجوزات المكتملة والملغاة والتي لم يحضر أصحابها.
                </p>

            </div>

        </div>

        <div data-tabs="bookings">

            {{-- Tabs --}}
            <div class="tabs-list tabs-list-full">

                <a href="{{ request()->fullUrlWithQuery(['booking_filter' => 'today', 'page' => 1]) }}"
                    class="tab-trigger {{ $filter === 'today' ? 'active' : '' }}">
                    اليوم
                </a>

                <a href="{{ request()->fullUrlWithQuery(['booking_filter' => 'upcoming', 'page' => 1]) }}"
                    class="tab-trigger {{ $filter === 'upcoming' ? 'active' : '' }}">
                    القادمة
                </a>

                <a href="{{ request()->fullUrlWithQuery(['booking_filter' => 'past', 'page' => 1]) }}"
                    class="tab-trigger {{ $filter === 'past' ? 'active' : '' }}">
                    السابقة
                </a>

                <a href="{{ request()->fullUrlWithQuery(['booking_filter' => 'cancelled', 'page' => 1]) }}"
                    class="tab-trigger {{ $filter === 'cancelled' ? 'active' : '' }}">
                    الملغاة
                </a>

                <a href="{{ request()->fullUrlWithQuery(['booking_filter' => 'all', 'page' => 1]) }}"
                    class="tab-trigger {{ $filter === 'all' ? 'active' : '' }}">
                    الكل
                </a>

            </div>

            {{-- Search --}}
            <form method="GET" action="{{ url()->current() }}"
                class="clinic-surface-card my-4 flex flex-col gap-3 p-3 sm:flex-row">

                <input type="hidden" name="booking_filter" value="{{ $filter }}" id="history-booking-filter">

                <div class="relative flex-1">

                    @if (request('search') || request('source', 'all') !== 'all')
                        <a href="{{ route('clinic.history', ['booking_filter' => $filter]) }}"
                            class="btn btn-destructive btn-sm absolute left-2 z-10 flex items-center justify-center gap-1"
                            title="إلغاء البحث">

                            <span class="text-xs font-bold leading-none">
                                ✕
                            </span>

                        </a>
                    @endif

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="ابحث باسم المريض أو الهاتف" autocomplete="off" data-live-search
                        data-live-search-url="{{ route('clinic.history') }}" data-live-search-target="#history-results"
                        data-live-search-pagination="#history-pagination"
                        data-live-search-preserve="#history-booking-filter,#history-source" class="field-input pe-9">

                </div>

                <select name="source" id="history-source" class="field-select sm:w-44">

                    <option value="all" {{ request('source', 'all') === 'all' ? 'selected' : '' }}>
                        كل المصادر
                    </option>

                    <option value="online" {{ request('source') === 'online' ? 'selected' : '' }}>
                        أونلاين
                    </option>

                    <option value="clinic" {{ request('source') === 'clinic' ? 'selected' : '' }}>
                        من العيادة
                    </option>

                </select>

                <button type="submit" class="btn btn-default">

                    <i data-lucide="search" class="size-4">
                    </i>

                    بحث

                </button>

            </form>

            {{-- Results --}}
            <div id="history-results">

                @if ($bookings->count())

                    {{-- Desktop --}}
                    <div class="clinic-surface-card hidden overflow-hidden md:block">

                        <div class="w-full overflow-x-auto">

                            <table class="clinic-table w-full min-w-[1000px]">

                                <thead>

                                    <tr>

                                        <th>🧡</th>

                                        <th>
                                            المريض
                                        </th>

                                        <th>
                                            التاريخ والوقت
                                        </th>

                                        <th>
                                            المصدر
                                        </th>

                                        <th>
                                            الخدمة
                                        </th>

                                        <th>
                                            الحالة
                                        </th>

                                        <th>
                                            الدفع
                                        </th>
                                        @unless ($isAssistant)
                                            <th class="text-center">
                                                إجراءات
                                            </th>
                                        @endunless
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($bookings as $booking)
                                        <tr class="border-t border-border hover:bg-muted/40">

                                            {{-- رقم الحجز --}}
                                            <td class="px-4 py-3 font-semibold tabular-nums">

                                                🧡 {{ $booking->display_number }}

                                            </td>

                                            {{-- المريض --}}
                                            <td class="px-4 py-3">

                                                @if ($isClinicSystem && $booking->patient_id)
                                                    <a href="{{ route('clinic.patients.show', $booking->patient_id) }}"
                                                        class="font-medium text-primary hover:underline">

                                                        {{ $booking->patient_name }}

                                                    </a>
                                                @else
                                                    <p class="font-medium">
                                                        {{ $booking->patient_name }}
                                                    </p>
                                                @endif

                                                <p class="text-xs text-muted-foreground tabular-nums">

                                                    {{ $booking->patient_phone }}

                                                </p>

                                            </td>

                                            {{-- التاريخ والوقت --}}
                                            <td class="px-4 py-3 tabular-nums">

                                                <p>
                                                    {{ $booking->display_date }}
                                                </p>

                                                <p class="text-xs text-muted-foreground">
                                                    {{ $booking->display_time }}
                                                </p>

                                            </td>

                                            {{-- المصدر --}}
                                            <td class="px-4 py-3">

                                                <span class="badge {{ $booking->source_class }}">
                                                    {{ $booking->source_label }}
                                                </span>

                                            </td>

                                            {{-- الخدمة --}}
                                            <td class="px-4 py-3">

                                                {{ $booking->service_label }}

                                            </td>

                                            {{-- الحالة --}}
                                            <td class="px-4 py-3">

                                                <span class="badge {{ $booking->status_class }}">
                                                    {{ $booking->status_label }}
                                                </span>

                                            </td>

                                            {{-- الدفع --}}
                                            <td class="px-4 py-3 tabular-nums">

                                                <p class="text-sm font-semibold {{ $booking->payment_class }}">

                                                    {{ $booking->payment_label }}

                                                </p>

                                                @if ((float) $booking->paid > 0)
                                                    <p class="mt-1 text-xs text-muted-foreground">

                                                        المدفوع:
                                                        {{ number_format((float) $booking->paid, 2) }}
                                                        ج.م

                                                    </p>
                                                @endif

                                                @if ((float) $booking->price > 0)
                                                    <p class="text-xs text-muted-foreground">

                                                        الإجمالي:
                                                        {{ number_format((float) $booking->price, 2) }}
                                                        ج.م

                                                    </p>
                                                @endif

                                            </td>

                                            @unless ($isAssistant)
                                                <td class="px-4 py-3">

                                                    <div class="dropdown relative">

                                                        <button type="button" class="btn btn-icon-sm" data-dropdown-trigger
                                                            aria-label="إجراءات الحجز">

                                                            <i data-lucide="more-horizontal"></i>

                                                        </button>

                                                        <div class="dropdown-menu min-w-[200px]">

                                                            <button type="button" class="dropdown-item" data-edit-payment
                                                                data-id="{{ $booking->id }}"
                                                                data-name="{{ $booking->patient_name }}"
                                                                data-price="{{ (float) $booking->price }}"
                                                                data-paid="{{ (float) $booking->paid }}">

                                                                <i data-lucide="wallet"></i>

                                                                تعديل الدفع

                                                            </button>
                                                            <form method="POST"
                                                                action="{{ route('clinic.bookings.destroy', $booking) }}"
                                                                onsubmit="return confirm('حذف هذا الحجز نهائيًا؟')">

                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" class="dropdown-item danger">

                                                                    <i data-lucide="trash-2"></i>

                                                                    حذف الحجز

                                                                </button>

                                                            </form>
                                                        </div>

                                                    </div>

                                                </td>
                                            @endunless

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                    {{-- Mobile --}}
                    <div class="space-y-3 md:hidden">

                        @foreach ($bookings as $booking)
                            <div class="clinic-surface-card p-4">

                                {{-- المريض + الحالة --}}
                                <div class="mb-3 flex items-start justify-between gap-3">

                                    <div class="min-w-0">

                                        @if ($isClinicSystem && $booking->patient_id)
                                            <a href="{{ route('clinic.patients.show', $booking->patient_id) }}"
                                                class="font-medium text-primary hover:underline">

                                                {{ $booking->patient_name }}

                                            </a>
                                        @else
                                            <p class="font-medium">
                                                {{ $booking->patient_name }}
                                            </p>
                                        @endif

                                        <p class="mt-1 text-xs text-muted-foreground tabular-nums">

                                            {{ $booking->patient_phone }}

                                        </p>

                                    </div>

                                    <span class="badge {{ $booking->status_class }} shrink-0">

                                        {{ $booking->status_label }}

                                    </span>

                                </div>

                                {{-- التاريخ والوقت --}}
                                <div class="grid grid-cols-2 gap-3 border-y border-border py-3">

                                    <div>

                                        <p class="text-xs text-muted-foreground">
                                            التاريخ
                                        </p>

                                        <p class="mt-1 text-sm font-medium tabular-nums">
                                            {{ $booking->display_date }}
                                        </p>

                                    </div>

                                    <div>

                                        <p class="text-xs text-muted-foreground">
                                            الوقت
                                        </p>

                                        <p class="mt-1 text-sm font-medium tabular-nums">
                                            {{ $booking->display_time }}
                                        </p>

                                    </div>

                                </div>

                                {{-- التفاصيل --}}
                                <div class="mt-3 space-y-2">

                                    {{-- المصدر --}}
                                    <div class="flex items-center justify-between gap-3 text-sm">

                                        <span class="text-muted-foreground">
                                            المصدر
                                        </span>

                                        <span class="badge {{ $booking->source_class }}">
                                            {{ $booking->source_label }}
                                        </span>

                                    </div>

                                    {{-- الخدمة --}}
                                    <div class="flex items-center justify-between gap-3 text-sm">

                                        <span class="text-muted-foreground">
                                            الخدمة
                                        </span>

                                        <span class="text-end">
                                            {{ $booking->service_label }}
                                        </span>

                                    </div>

                                    {{-- الدفع --}}
                                    <div class="flex items-center justify-between gap-3 text-sm">

                                        <span class="text-muted-foreground">
                                            الدفع
                                        </span>

                                        <div class="text-end">

                                            <p class="font-semibold {{ $booking->payment_class }}">

                                                {{ $booking->payment_label }}

                                            </p>

                                            @if ((float) $booking->paid > 0)
                                                <p class="mt-1 text-xs text-muted-foreground tabular-nums">

                                                    المدفوع:
                                                    {{ number_format((float) $booking->paid, 2) }}
                                                    ج.م

                                                </p>
                                            @endif

                                            @if ((float) $booking->price > 0)
                                                <p class="text-xs text-muted-foreground tabular-nums">

                                                    الإجمالي:
                                                    {{ number_format((float) $booking->price, 2) }}
                                                    ج.م

                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </div>

                                @unless ($isAssistant)
                                    <div class="mt-4 flex gap-2 border-t border-border pt-3">

                                        <button type="button" class="btn btn-default flex-1" data-edit-payment
                                            data-id="{{ $booking->id }}" data-name="{{ $booking->patient_name }}"
                                            data-price="{{ (float) $booking->price }}"
                                            data-paid="{{ (float) $booking->paid }}">

                                            <i data-lucide="wallet" class="size-4">
                                            </i>

                                            تعديل الدفع

                                        </button>
                                        <form method="POST" action="{{ route('clinic.bookings.destroy', $booking) }}"
                                            onsubmit="return confirm('حذف هذا الحجز نهائيًا؟')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-destructive" aria-label="حذف الحجز">

                                                <i data-lucide="trash-2" class="size-4">
                                                </i>

                                            </button>

                                        </form>
                                    </div>
                                @endunless

                            </div>
                        @endforeach

                    </div>
                @else
                    <x-home.banner.no_results logo="fa-solid fa-magnifying-glass" title="لا توجد حجوزات"
                        content="لم يتم العثور على حجوزات مطابقة للبحث أو الفلاتر المحددة." />

                @endif

            </div>

            {{-- Pagination --}}
            <div id="history-pagination" class="mt-4">

                {{ $bookings->links('vendor.pagination.custom') }}

            </div>

        </div>

    </main>

    <x-doctor.clinic.edit-payment-modal />

@endsection

@push('extra_java')
    {{-- Live Search --}}
    <script src="{{ asset('js/clinic/live_search.js') }}"></script>

    {{-- Booking Page Config --}}
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

        };
    </script>

    {{-- Booking / Queue JavaScript --}}
    <script src="{{ asset('js/clinic/booking-index.js') }}"></script>
@endpush

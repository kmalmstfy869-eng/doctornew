@forelse ($bookings as $booking)
    @php

        $price = (float) ($booking->price ?? 0);
        $paid = (float) ($booking->paid ?? 0);

        if ($paid <= 0) {
            $paymentLabel = 'غير مدفوع';
            $paymentClass = 'text-muted-foreground';
        } elseif ($paid >= $price) {
            $paymentLabel = 'مدفوع بالكامل';
            $paymentClass = 'text-success';
        } else {
            $paymentLabel = 'مدفوع جزئيًا';
            $paymentClass = 'text-warning';
        }

        $statusLabels = [
            'pending' => 'في انتظار حضوره',
            'confirmed' => 'حضر للعيادة',
            'in_progress' => 'داخل الكشف',
            'completed' => 'تم الكشف',
            'cancelled' => 'ملغي',
            'no_show' => 'لم يحضر',
        ];

        $statusClasses = [
            'pending' => 'badge-warning',
            'confirmed' => 'badge-info',
            'in_progress' => 'badge-purple',
            'completed' => 'badge-success',
            'cancelled' => 'badge-danger',
            'no_show' => 'badge-danger',
        ];

        $statusLabel = $statusLabels[$booking->status] ?? $booking->status;

        $statusClass = $statusClasses[$booking->status] ?? 'badge-info';

        $sourceLabel = $booking->booking_type === 'online' ? 'أونلاين' : 'من العيادة';

        $sourceClass = $booking->booking_type === 'online' ? 'badge-primary' : 'badge-purple';

    @endphp


    <div class="clinic-surface-card border border-border p-4">

        <div class="flex items-start justify-between gap-3">

            <div class="flex min-w-0 items-center gap-3">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-soft text-primary">

                    <i data-lucide="user-round" class="h-5 w-5"></i>

                </div>


                <div class="min-w-0">

                    @if ($isClinicSystem && $booking->patient_id)
                        <a href="{{ route('clinic.patients.show', $booking->patient_id) }}"
                            class="block truncate font-bold text-primary hover:underline">

                            {{ $booking->patient_name }}

                        </a>
                    @else
                        <h3 class="truncate font-bold text-foreground">
                            {{ $booking->patient_name }}
                        </h3>
                    @endif

                    <p class="mt-1 text-xs text-muted-foreground">
                        🧡{{ str_pad(($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </p>

                </div>

            </div>


            <div class="dropdown relative">

                <button type="button" class="btn btn-icon-sm" data-dropdown-trigger
                    aria-label="إجراءات الحجز">

                    <i data-lucide="more-horizontal"></i>

                </button>


                <div class="dropdown-menu min-w-[220px]">

                    @if ($booking->patient_id && $isClinicSystem)
                        <a href="{{ route('clinic.patients.show', $booking->patient_id) }}"
                            class="dropdown-item">

                            <i data-lucide="folder-open"></i>

                            عرض ملف المريض

                        </a>
                    @endif


                    <button type="button" class="dropdown-item" data-edit-service
                        data-id="{{ $booking->id }}" data-name="{{ $booking->patient_name }}"
                        data-service="{{ $booking->service ?? '' }}">

                        <i data-lucide="clipboard-pen"></i>

                        {{ $booking->service ? 'تعديل الخدمة' : 'تحديد الخدمة' }}

                    </button>


                    <button type="button" class="dropdown-item" data-edit-payment
                        data-id="{{ $booking->id }}" data-name="{{ $booking->patient_name }}"
                        data-price="{{ $price }}" data-paid="{{ $paid }}">

                        <i data-lucide="wallet"></i>

                        تعديل الدفع

                    </button>


                    @if ($booking->status === 'pending' && !$booking->arrived_at)
                        <form method="POST"
                            action="{{ route('clinic.bookings.arrive', $booking) }}">

                            @csrf
                            @method('PATCH')

                            <button type="submit" class="dropdown-item">

                                <i data-lucide="user-round-check"></i>

                                تسجيل وصول

                            </button>

                        </form>
                    @endif


                    @if ($booking->arrived_at && $booking->status === 'confirmed')
                        <form method="POST" action="{{ route('clinic.bookings.start', $booking) }}">

                            @csrf
                            @method('PATCH')

                            <button type="submit" class="dropdown-item">

                                <i data-lucide="stethoscope"></i>

                                بدء الكشف

                            </button>

                        </form>
                    @endif


                    @if ($booking->status === 'pending' && !$booking->arrived_at)
                        <form method="POST"
                            action="{{ route('clinic.bookings.no-show', $booking) }}">

                            @csrf
                            @method('PATCH')

                            <button type="submit" class="dropdown-item">

                                <i data-lucide="user-x"></i>

                                لم يحضر

                            </button>

                        </form>
                    @endif


                    @if ($booking->status === 'pending')
                        <button type="button" class="dropdown-item danger"
                            data-cancel-booking="{{ $booking->id }}"
                            data-cancel-name="{{ $booking->patient_name }}">

                            <i data-lucide="trash-2"></i>

                            إلغاء الحجز

                        </button>
                    @endif

                </div>

            </div>

        </div>


        <div class="mt-4 grid grid-cols-2 gap-3">

            <div class="rounded-xl bg-muted p-3">

                <p class="text-xs text-muted-foreground">
                    الخدمة
                </p>

                <p class="mt-1 text-sm font-semibold text-foreground">
                    {{ $booking->service ?? 'لم تحدد' }}
                </p>

            </div>


            <div class="rounded-xl bg-muted p-3">

                <p class="text-xs text-muted-foreground">
                    المصدر
                </p>

                <p class="mt-1">

                    <span class="badge {{ $sourceClass }}">
                        {{ $sourceLabel }}
                    </span>

                </p>

            </div>


            <div class="rounded-xl bg-muted p-3">

                <p class="text-xs text-muted-foreground">
                    التاريخ
                </p>

                <p class="mt-1 text-sm font-semibold text-foreground">

                    {{ \Carbon\Carbon::parse($booking->appointment_date)->format('Y-m-d') }}

                </p>

            </div>


            <div class="rounded-xl bg-muted p-3">

                <p class="text-xs text-muted-foreground">
                    موعد الدخول المتوقع
                </p>

                <p class="mt-1 text-sm font-semibold text-foreground">

                    @if ($booking->start_time)
                        {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
                    @else
                        بدون وقت
                    @endif

                </p>

            </div>

        </div>


        <div
            class="mt-3 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-border p-3">

            <div>

                <p class="text-xs text-muted-foreground">
                    الدفع
                </p>

                <p class="mt-1 text-sm font-semibold {{ $paymentClass }}">
                    {{ $paymentLabel }}
                </p>

                <p class="mt-1 text-xs text-muted-foreground">

                    {{ number_format($paid, 0) }}

                    /

                    {{ number_format($price, 0) }}

                    ج.م

                </p>

            </div>


            <div class="text-left">

                <p class="text-xs text-muted-foreground">
                    الحالة
                </p>

                <div class="mt-1">

                    <span class="badge {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>

                </div>

            </div>

        </div>


        @if ($booking->patient?->phone || $booking->patient_phone)
            <div class="mt-3 flex items-center gap-2 text-xs text-muted-foreground">

                <i data-lucide="phone" class="h-3.5 w-3.5"></i>

                {{ $booking->patient?->phone ?? $booking->patient_phone }}

            </div>
        @endif

    </div>

@empty

    <x-home.banner.no_results logo="fa-solid fa-magnifying-glass" title="لا توجد حجوزات"
        content="لم يتم العثور على حجوزات مطابقة للبحث أو الفلاتر المحددة." />
@endforelse

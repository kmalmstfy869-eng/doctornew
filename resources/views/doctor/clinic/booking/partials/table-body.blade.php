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


    <tr>

        <td>

            <div class="flex min-w-[190px] items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-soft text-primary">

                    <i data-lucide="user-round" class="h-5 w-5"></i>

                </div>


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


                    <div class="mt-0.5 text-xs text-muted-foreground">

                        {{ $booking->patient?->phone ?? ($booking->patient_phone ?? '—') }}

                    </div>

                </div>

            </div>

        </td>


        <td>

            <span class="font-semibold text-foreground">
                🧡{{ str_pad(($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration, 2, '0', STR_PAD_LEFT) }}
            </span>

        </td>


        <td>

            <span class="whitespace-nowrap text-sm text-foreground">
                {{ $booking->service ?? 'لم تحدد' }}
            </span>

        </td>


        <td>

            <span class="badge {{ $sourceClass }}">
                {{ $sourceLabel }}
            </span>

        </td>


        <td>

            <span class="whitespace-nowrap text-sm text-foreground">

                {{ \Carbon\Carbon::parse($booking->appointment_date)->format('Y-m-d') }}

            </span>

        </td>


        <td>

            <span class="whitespace-nowrap text-sm text-foreground">

                @if ($booking->start_time)
                    {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
                @else
                    بدون وقت
                @endif

            </span>

        </td>


        <td>

            <div class="whitespace-nowrap">

                <div class="font-semibold {{ $paymentClass }}">
                    {{ $paymentLabel }}
                </div>

                <div class="mt-0.5 text-xs text-muted-foreground">

                    {{ number_format($paid, 0) }}

                    /

                    {{ number_format($price, 0) }}

                    ج.م

                </div>

            </div>

        </td>


        <td>

            <span class="badge {{ $statusClass }}">
                {{ $statusLabel }}
            </span>

        </td>


        <td>

            <div class="bq-booking-actions">

                <div class="dropdown relative">

                    <button type="button" class="btn btn-icon-sm" data-dropdown-trigger aria-label="إجراءات الحجز">

                        <i data-lucide="more-horizontal"></i>

                    </button>


                    <div class="dropdown-menu min-w-[220px]">

                        @if ($booking->patient_id && $isClinicSystem)
                            <a href="{{ route('clinic.patients.show', $booking->patient_id) }}" class="dropdown-item">

                                <i data-lucide="folder-open"></i>

                                عرض ملف المريض

                            </a>
                        @endif


                        <button type="button" class="dropdown-item" data-edit-service data-id="{{ $booking->id }}"
                            data-name="{{ $booking->patient_name }}" data-service="{{ $booking->service ?? '' }}">

                            <i data-lucide="clipboard-pen"></i>

                            {{ $booking->service ? 'تعديل الخدمة' : 'تحديد الخدمة' }}

                        </button>


                        <button type="button" class="dropdown-item" data-edit-payment data-id="{{ $booking->id }}"
                            data-name="{{ $booking->patient_name }}" data-price="{{ $price }}"
                            data-paid="{{ $paid }}">

                            <i data-lucide="wallet"></i>

                            تعديل الدفع

                        </button>


                        @if ($booking->status === 'pending' && !$booking->arrived_at)
                            <form method="POST" action="{{ route('clinic.bookings.arrive', $booking) }}">

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
                            <form method="POST" action="{{ route('clinic.bookings.no-show', $booking) }}">

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

        </td>

    </tr>

@empty

    <tr>

        <td colspan="9" class="p-4">

            <x-home.banner.no_results logo="fa-solid fa-magnifying-glass" title="لا توجد حجوزات"
                content="لم يتم العثور على حجوزات مطابقة للبحث أو الفلاتر المحددة." />

        </td>

    </tr>
@endforelse

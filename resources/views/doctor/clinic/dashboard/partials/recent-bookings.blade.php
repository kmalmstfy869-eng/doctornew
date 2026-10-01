@php
    $statusLabels = [
        'pending' => 'بانتظار التأكيد',
        'confirmed' => 'مؤكد',
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
@endphp

@forelse ($recentBookings as $booking)

    @php
        $statusLabel = $statusLabels[$booking->status] ?? $booking->status;
        $statusClass = $statusClasses[$booking->status] ?? 'badge-info';
        $sourceLabel = $booking->booking_type === 'online' ? 'أونلاين' : 'من العيادة';
        $sourceClass = $booking->booking_type === 'online' ? 'badge-primary' : 'badge-purple';
    @endphp

    <li class="rounded-lg border border-border px-3 py-2">

        <div class="flex items-center justify-between gap-2">

            <p class="truncate text-sm font-semibold">
                {{ $booking->patient_name }}
            </p>

            <span class="badge {{ $statusClass }}">
                {{ $statusLabel }}
            </span>

        </div>

        <div class="mt-1.5 flex items-center gap-2 text-xs text-muted-foreground">

            <span class="tabular-nums">
                @if ($booking->start_time)
                    {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
                @else
                    {{ $booking->created_at->format('h:i A') }}
                @endif
            </span>

            <span>•</span>

            <span class="badge {{ $sourceClass }}">
                {{ $sourceLabel }}
            </span>

        </div>

    </li>

@empty

    <li>
        <x-home.banner.no_results logo="fa-solid fa-magnifying-glass" title="لا توجد حجوزات"
            content="لم يتم تسجيل أي حجوزات بعد." />
    </li>

@endforelse

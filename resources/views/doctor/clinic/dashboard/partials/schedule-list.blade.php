@forelse ($scheduleSlots as $slot)

    <li class="flex items-center justify-between gap-2 rounded-lg border border-border px-3 py-2">

        <span class="text-sm font-semibold tabular-nums">
            {{ $slot['start_label'] }} {{ $slot['start_period'] }} - {{ $slot['end_label'] }} {{ $slot['end_period'] }}
        </span>

        @if ($slot['status'] === 'available')

            <span class="badge badge-success">
                متاح
            </span>

        @elseif ($slot['status'] === 'booked')

            <span class="flex items-center gap-2">

                <span class="truncate text-xs text-muted-foreground">
                    {{ str_replace('بواسطة : ', '', $slot['label']) }}
                </span>

                <span class="badge badge-info">
                    محجوز
                </span>

            </span>

        @elseif ($slot['status'] === 'blocked')

            <span class="badge badge-danger">
                مغلق
            </span>

        @else

            <span class="badge badge-warning">
                انتهى وقته
            </span>

        @endif

    </li>

@empty

    <li>
        <x-home.banner.no_results logo="fa-regular fa-calendar-xmark" title="لا يوجد جدول عمل اليوم"
            content="لا يوجد مواعيد مفعّلة لهذا اليوم." />
    </li>

@endforelse

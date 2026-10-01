@forelse ($dashboardQueue as $index => $booking)

    <li class="flex items-center gap-3 rounded-lg border border-border px-3 py-2">

        <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-primary-soft text-sm font-bold text-primary">
            {{ $index + 1 }}
        </span>

        <div class="min-w-0 flex-1">

            <p class="truncate text-sm font-semibold">
                {{ $booking->patient_name }}
            </p>

            <p class="text-xs text-muted-foreground">
                @if ($booking->arrived_at)
                    وصل {{ $booking->arrived_at->format('H:i') }}
                @else
                    لم يسجل وصول
                @endif
            </p>

        </div>

        @if ($booking->status === 'in_progress')

            <span class="badge badge-purple">
                داخل الكشف
            </span>

        @else

            <span class="badge badge-warning">
                منتظر
            </span>

        @endif

    </li>

@empty

    <li>
        <x-home.banner.no_results logo="fa-solid fa-users-slash" title="الطابور فارغ حالياً"
            content="لا يوجد مرضى في طابور الانتظار في الوقت الحالي." />
    </li>

@endforelse

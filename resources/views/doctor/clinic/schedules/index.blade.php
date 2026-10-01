
@extends('doctor.layouts.app_clinc')
@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
@endpush
@section('title', 'جدول العيادة | دليل الأطباء')

@php
    $dayLabels = [
        0 => 'الأحد',
        1 => 'الإثنين',
        2 => 'الثلاثاء',
        3 => 'الأربعاء',
        4 => 'الخميس',
        5 => 'الجمعة',
        6 => 'السبت',
    ];

    $allDaysAdded = count($usedDays) >= 7;
@endphp

@section('content')

<main class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div class="min-w-0">

            <h1 class="truncate text-xl font-bold sm:text-2xl">
                جدول العيادة
            </h1>

            <p class="mt-1 text-sm text-muted-foreground">
                حدد أيام العمل وساعاته ومدة الموعد — هذا الجدول هو أساس توليد المواعيد الإلكترونية.
            </p>

        </div>

        <div class="flex flex-wrap items-center gap-2">

            <button
                type="button"
                class="btn btn-default"
                data-modal-open="{{ $allDaysAdded ? 'modal-all-days' : 'modal-new-day' }}"
            >
                <i data-lucide="plus" class="size-4"></i>
                إضافة يوم
            </button>

        </div>

    </div>

    @if ($schedules->count())

        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">

            @foreach ($schedules as $schedule)

                @php
                    $dayName = $dayLabels[$schedule->day_of_week];

                    $startTime = $schedule->start_time
                        ? \Illuminate\Support\Str::substr($schedule->start_time, 0, 5)
                        : null;

                    $endTime = $schedule->end_time
                        ? \Illuminate\Support\Str::substr($schedule->end_time, 0, 5)
                        : null;

                    $appointmentCount = null;

                    if ($schedule->is_active && $startTime && $endTime && $schedule->slot_duration) {
                        $start = \Carbon\Carbon::createFromFormat('H:i', $startTime);
                        $end = \Carbon\Carbon::createFromFormat('H:i', $endTime);

                        $minutes = $start->diffInMinutes($end);

                        $appointmentCount = intdiv(
                            $minutes,
                            $schedule->slot_duration
                        );
                    }
                @endphp

                <div class="clinic-surface-card p-4">

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            <h3 class="text-base font-bold">
                                {{ $dayName }}
                            </h3>

                            <p class="mt-1 text-sm text-muted-foreground tabular-nums">

                                @if ($schedule->is_active && $startTime && $endTime)

                                    {{ \Carbon\Carbon::createFromFormat('H:i', $startTime)->format('h:i') }}
                                    {{ \Carbon\Carbon::createFromFormat('H:i', $startTime)->format('A') === 'AM' ? 'ص' : 'م' }}

                                    ←

                                    {{ \Carbon\Carbon::createFromFormat('H:i', $endTime)->format('h:i') }}
                                    {{ \Carbon\Carbon::createFromFormat('H:i', $endTime)->format('A') === 'AM' ? 'ص' : 'م' }}

                                @else
                                    غير محدد
                                @endif

                            </p>

                        </div>

                        @if ($schedule->is_active)

                            <span class="badge badge-success">
                                مُفعل
                            </span>

                        @else

                            <span class="badge badge-muted">
                                معطل
                            </span>

                        @endif

                    </div>

                    <div class="mt-3 flex flex-wrap gap-2 text-xs">

                        <span class="badge badge-primary">
                            مدة الموعد: {{ $schedule->slot_duration }} دقيقة
                        </span>

                        @if ($appointmentCount !== null)

                            <span class="badge badge-info">
                                {{ $appointmentCount }} موعد
                            </span>

                        @endif

                    </div>

                    <div class="mt-4 flex items-center justify-between gap-2 border-t border-border pt-3">

                        <span class="text-xs text-muted-foreground">
                            {{ $schedule->is_active ? 'اليوم مُفعل للحجز' : 'اليوم غير مفعل للحجز' }}
                        </span>

                        <div class="flex gap-1">

                            <button
                                type="button"
                                class="btn btn-ghost btn-icon-sm"
                                data-modal-open="modal-edit-{{ $schedule->id }}"
                                aria-label="تعديل"
                            >
                                <i data-lucide="pencil" class="size-4"></i>
                            </button>

                            <button
                                type="button"
                                class="btn btn-ghost btn-icon-sm"
                                data-modal-open="modal-delete-{{ $schedule->id }}"
                                aria-label="حذف"
                            >
                                <i data-lucide="trash-2" class="size-4 text-destructive"></i>
                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <x-home.banner.no_results
            logo="fa-solid fa-calendar-days"
            title="لا يوجد جدول للعيادة"
            content="لم يتم إضافة مواعيد العمل بعد. أضف جدول عيادتك الآن لتنظيم مواعيد استقبال المرضى بسهولة."
        />

    @endif

</main>

<div id="modal-new-day" class="modal-overlay">

    <div class="modal-panel">

        <div class="mb-4">

            <h2 class="text-base font-bold">
                إضافة يوم عمل
            </h2>

            <p class="mt-1 text-sm text-muted-foreground">
                أضف يومًا جديدًا إلى جدول العيادة.
            </p>

        </div>

        <form action="{{ route('clinic.schedules.store') }}" method="POST">

            @csrf

            <div class="space-y-4">

                <div>

                    <label class="field-label">
                        اليوم
                    </label>

                    <select name="day_of_week" class="field-select" required>

                        @foreach ($dayLabels as $dayNumber => $dayName)

                            @if (!in_array($dayNumber, $usedDays))

                                <option
                                    value="{{ $dayNumber }}"
                                    {{ (string) old('day_of_week') === (string) $dayNumber ? 'selected' : '' }}
                                >
                                    {{ $dayName }}
                                </option>

                            @endif

                        @endforeach

                    </select>

                    @error('day_of_week')

                        <div class="field-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $message }}</span>
                        </div>

                    @enderror

                </div>

                <div class="grid grid-cols-2 gap-3">

                    <div>

                        <label class="field-label">
                            بداية العمل
                        </label>

                        <input
                            type="time"
                            name="start_time"
                            class="field-input"
                            value="{{ old('start_time', '09:00') }}"
                            required
                        >

                        @error('start_time')

                            <div class="field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </div>

                        @enderror

                    </div>

                    <div>

                        <label class="field-label">
                            نهاية العمل
                        </label>

                        <input
                            type="time"
                            name="end_time"
                            class="field-input"
                            value="{{ old('end_time', '14:00') }}"
                            required
                        >

                        @error('end_time')

                            <div class="field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $message }}</span>
                            </div>

                        @enderror

                    </div>

                </div>

                <div>

                    <label class="field-label">
                        مدة الموعد بالدقائق
                    </label>

                    <input
                        type="number"
                        name="slot_duration"
                        class="field-input"
                        value="{{ old('slot_duration', 30) }}"
                        min="5"
                        max="240"
                        step="5"
                        required
                    >

                    @error('slot_duration')

                        <div class="field-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $message }}</span>
                        </div>

                    @enderror

                </div>

                <div>

                    <label class="flex items-center gap-2">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', '1') ? 'checked' : '' }}
                        >

                        <span>
                            تفعيل اليوم
                        </span>

                    </label>

                    @error('is_active')

                        <div class="field-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $message }}</span>
                        </div>

                    @enderror

                </div>

            </div>

            <div class="mt-6 flex justify-end gap-2">

                <button
                    type="button"
                    class="btn btn-outline"
                    data-modal-close
                >
                    إلغاء
                </button>

                <button
                    type="submit"
                    class="btn btn-default"
                >
                    حفظ
                </button>

            </div>

        </form>

    </div>

</div>

<div id="modal-all-days" class="modal-overlay">

    <div class="modal-panel">

        <div class="mb-4">

            <h2 class="text-base font-bold">
                تم إضافة جميع الأيام
            </h2>

            <p class="mt-2 text-sm text-muted-foreground">
                لقد أضفت جميع أيام الأسبوع إلى جدول العيادة.
                يمكنك تعديل أوقات العمل أو مدة المواعيد من خلال زر التعديل.
            </p>

        </div>

        <div class="mt-6 flex justify-end">

            <button
                type="button"
                class="btn btn-default"
                data-modal-close
            >
                حسنًا
            </button>

        </div>

    </div>

</div>

@foreach ($schedules as $schedule)

    @php
        $dayName = $dayLabels[$schedule->day_of_week];

        $startTime = $schedule->start_time
            ? \Illuminate\Support\Str::substr($schedule->start_time, 0, 5)
            : '09:00';

        $endTime = $schedule->end_time
            ? \Illuminate\Support\Str::substr($schedule->end_time, 0, 5)
            : '14:00';

        $editStartTime = old('edit_schedule_id') == $schedule->id
            ? old('start_time', $startTime)
            : $startTime;

        $editEndTime = old('edit_schedule_id') == $schedule->id
            ? old('end_time', $endTime)
            : $endTime;

        $editSlotDuration = old('edit_schedule_id') == $schedule->id
            ? old('slot_duration', $schedule->slot_duration)
            : $schedule->slot_duration;

        $editIsActive = old('edit_schedule_id') == $schedule->id
            ? old('is_active')
            : $schedule->is_active;
    @endphp

    <div id="modal-edit-{{ $schedule->id }}" class="modal-overlay">

        <div class="modal-panel">

            <div class="mb-4">

                <h2 class="text-base font-bold">
                    تعديل يوم {{ $dayName }}
                </h2>

                <p class="mt-1 text-sm text-muted-foreground">
                    تعديل أوقات العمل ومدة الموعد وحالة اليوم.
                </p>

            </div>

            <form
                action="{{ route('clinic.schedules.update', $schedule->id) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

                <input
                    type="hidden"
                    name="edit_schedule_id"
                    value="{{ $schedule->id }}"
                >

                <div class="space-y-4">

                    <div>

                        <label class="field-label">
                            اليوم
                        </label>

                        <input
                            type="text"
                            class="field-input"
                            value="{{ $dayName }}"
                            disabled
                        >

                    </div>

                    <div class="grid grid-cols-2 gap-3">

                        <div>

                            <label class="field-label">
                                بداية العمل
                            </label>

                            <input
                                type="time"
                                name="start_time"
                                class="field-input"
                                value="{{ $editStartTime }}"
                                required
                            >

                            @error('start_time')

                                @if (old('edit_schedule_id') == $schedule->id)

                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>

                                @endif

                            @enderror

                        </div>

                        <div>

                            <label class="field-label">
                                نهاية العمل
                            </label>

                            <input
                                type="time"
                                name="end_time"
                                class="field-input"
                                value="{{ $editEndTime }}"
                                required
                            >

                            @error('end_time')

                                @if (old('edit_schedule_id') == $schedule->id)

                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>

                                @endif

                            @enderror

                        </div>

                    </div>

                    <div>

                        <label class="field-label">
                            مدة الموعد بالدقائق
                        </label>

                        <input
                            type="number"
                            name="slot_duration"
                            class="field-input"
                            value="{{ $editSlotDuration }}"
                            min="5"
                            max="240"
                            step="5"
                            required
                        >

                        @error('slot_duration')

                            @if (old('edit_schedule_id') == $schedule->id)

                                <div class="field-error">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </div>

                            @endif

                        @enderror

                    </div>

                    <div>

                        <label class="flex items-center gap-2">

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                {{ $editIsActive ? 'checked' : '' }}
                            >

                            <span>
                                تفعيل اليوم
                            </span>

                        </label>

                        @error('is_active')

                            @if (old('edit_schedule_id') == $schedule->id)

                                <div class="field-error">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </div>

                            @endif

                        @enderror

                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-2">

                    <button
                        type="button"
                        class="btn btn-outline"
                        data-modal-close
                    >
                        إلغاء
                    </button>

                    <button
                        type="submit"
                        class="btn btn-default"
                    >
                        حفظ التعديل
                    </button>

                </div>

            </form>

        </div>

    </div>

@endforeach

@foreach ($schedules as $schedule)

    @php
        $dayName = $dayLabels[$schedule->day_of_week];
    @endphp

    <div id="modal-delete-{{ $schedule->id }}" class="modal-overlay">

        <div class="modal-panel">

            <h2 class="text-base font-bold">
                حذف يوم {{ $dayName }}؟
            </h2>

            <p class="mt-2 text-sm text-muted-foreground">
                لن تظهر مواعيد هذا اليوم للحجز الإلكتروني. الحجوزات القائمة لن تُحذف.
            </p>

            <form
                action="{{ route('clinic.schedules.destroy', $schedule->id) }}"
                method="POST"
            >

                @csrf
                @method('DELETE')

                <div class="mt-6 flex justify-end gap-2">

                    <button
                        type="button"
                        class="btn btn-outline"
                        data-modal-close
                    >
                        إلغاء
                    </button>

                    <button
                        type="submit"
                        class="btn btn-destructive"
                    >
                        حذف
                    </button>

                </div>

            </form>

        </div>

    </div>

@endforeach


@if ($errors->any())

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            @if (old('edit_schedule_id'))

                const editModal = document.getElementById(
                    'modal-edit-{{ old('edit_schedule_id') }}'
                );

                if (editModal) {
                    editModal.classList.add('open');
                }

            @else

                const newDayModal = document.getElementById('modal-new-day');

                if (newDayModal) {
                    newDayModal.classList.add('open');
                }

            @endif

        });
    </script>

@endif




@endsection


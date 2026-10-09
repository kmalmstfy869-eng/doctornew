@extends('doctor.layouts.app_clinc')
@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
@endpush

@once('modal-variants-css')
    @push('extra_style')
        <link rel="stylesheet" href="{{ asset('css/clinic/modal_variants.css') }}">
    @endpush
@endonce
@section('title', 'المواعيد المتاحة للحجز الإلكتروني | دليل الأطباء')

@section('content')
    <main class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="min-w-0">
                <h1 class="truncate text-xl font-bold sm:text-2xl">المواعيد المتاحة للحجز الإلكتروني</h1>
                <p class="mt-1 text-sm text-muted-foreground">هذه المواعيد هي ما يراه المريض على الموقع. إغلاق موعد لا يؤثر
                    على جدول العيادة.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('clinic.schedules.index') }}">
                    <button class="btn btn-outline btn-sm">جدول العيادة</button>
                </a>
            </div>
        </div>

        <div class="clinic-surface-card mb-4 flex flex-col gap-3 p-3 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-2">
                <a href="{{ route('clinic.slots.index', ['date' => $prevDate]) }}" class="btn btn-outline btn-icon"
                    aria-label="اليوم السابق">
                    <i data-lucide="chevron-right" class="size-4"></i>
                </a>

                <a href="{{ route('clinic.slots.index', ['date' => $nextDate]) }}" class="btn btn-outline btn-icon"
                    aria-label="اليوم التالي">
                    <i data-lucide="chevron-left" class="size-4"></i>
                </a>

                @unless ($isToday)
                    <a href="{{ route('clinic.slots.index', ['date' => $todayDate]) }}"
                        class="btn btn-secondary btn-sm">اليوم</a>
                @else
                    <span class="btn btn-secondary btn-sm pointer-events-none">اليوم</span>
                @endunless
            </div>

            <p class="text-sm font-semibold">{{ $date->translatedFormat('l، d F Y') }}</p>

            <select class="field-select sm:w-40" data-filter-target="#slots-grid">
                <option value="all">كل الحالات</option>
                <option value="available">متاح</option>
                <option value="booked">محجوز</option>
                <option value="blocked">مغلق</option>
                <option value="expired">انتهى وقته</option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-3 lg:grid-cols-5">

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">إجمالي المواعيد</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums">{{ $stats['total'] }}</p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-primary">
                        <i data-lucide="calendar-clock" class="size-5"></i>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">متاح</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums">{{ $stats['available'] }}</p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-success">
                        <i data-lucide="lock-open" class="size-5"></i>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">محجوز</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums">{{ $stats['booked'] }}</p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-info">
                        <i data-lucide="calendar-clock" class="size-5"></i>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">مغلق</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums">{{ $stats['blocked'] }}</p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-danger">
                        <i data-lucide="lock" class="size-5"></i>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">انتهى وقته</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums">{{ $stats['expired'] }}</p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-warning">
                        <i data-lucide="clock-alert" class="size-5"></i>
                    </span>
                </div>
            </div>

        </div>

        <form id="closeSlotsForm" action="{{ route('clinic.slots.close') }}" method="POST">
            @csrf
            <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">
            <input type="hidden" name="reason" id="closeReasonInput" value="">
        </form>

        @if (!$isPastDate && $stats['available'] > 0)
            <div class="clinic-surface-card mt-4 flex flex-col gap-2 p-3">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-muted-foreground">حدد المواعيد المطلوب إغلاقها ثم اضغط الزر.</p>

                    <button type="button" id="bulkCloseBtn" class="btn btn-default btn-sm">
                        <i data-lucide="lock" class="size-3.5"></i> إغلاق المواعيد المحددة
                    </button>
                </div>

                <p id="bulkCloseMsg" class="hidden text-xs font-medium text-red-600"></p>
            </div>
        @endif

        <div class="mt-4">

            <div id="slots-grid" class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">

                @forelse ($slots as $slot)
                    <div class="clinic-surface-card p-3.5" data-filter-value="{{ $slot['status'] }}"
                        data-search-text="{{ $slot['start_time'] }} {{ $slot['label'] }}">

                        <div class="flex items-start gap-3">

                            @if ($slot['status'] === 'available')
                                <input type="checkbox" value="{{ $slot['start_time'] }}"
                                    class="checkbox mt-1 slot-checkbox" aria-label="تحديد">
                            @else
                                <span class="mt-1 size-4 inline-block"></span>
                            @endif

                            <div class="min-w-0 flex-1">

                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm font-bold tabular-nums">
                                        {{ $slot['start_label'] }} {{ $slot['start_period'] }} -
                                        {{ $slot['end_label'] }} {{ $slot['end_period'] }}
                                    </p>

                                    @if ($slot['status'] === 'available')
                                        <span class="badge badge-success">متاح</span>
                                    @elseif ($slot['status'] === 'booked')
                                        <span class="badge badge-info">محجوز</span>
                                    @elseif ($slot['status'] === 'blocked')
                                        <span class="badge badge-danger">مغلق</span>
                                    @else
                                        <span class="badge badge-warning">انتهى وقته</span>
                                    @endif
                                </div>

                                <p class="mt-1.5 truncate text-xs text-muted-foreground">
                                    {{ $slot['label'] }}
                                </p>

                                <div class="mt-3 flex flex-wrap gap-2">

                                    @if ($slot['status'] === 'expired')
                                        <span class="btn btn-outline btn-sm pointer-events-none opacity-60">
                                            تم إغلاقه تلقائيًا لانتهاء وقته
                                        </span>
                                    @elseif ($slot['status'] === 'booked')
                                        <a
                                            href="{{ route('clinic.bookings.index', ['date' => $date->format('Y-m-d')]) }}">
                                            <button type="button" class="btn btn-outline btn-sm">عرض الحجز</button>
                                        </a>
                                    @elseif ($slot['status'] === 'blocked')
                                        @if (!empty($slot['blocked_time_passed']))
                                            <span class="btn btn-outline btn-sm pointer-events-none opacity-60">
                                                <i data-lucide="lock" class="size-3.5"></i> مغلق - انتهى وقته ولا يمكن
                                                فتحه
                                            </span>
                                        @else
                                            <form action="{{ route('clinic.slots.open', $slot['blocked_id']) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline btn-sm">
                                                    <i data-lucide="lock-open" class="size-3.5"></i> فتح
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-span-full">
                        @if ($isPastDate)
                            <x-home.banner.no_results logo="fa-regular fa-calendar-xmark" title="هذا اليوم قد مضى"
                                content="لا يمكن عرض أو التعديل على مواعيد يوم سابق." />
                        @else
                            <x-home.banner.no_results logo="fa-regular fa-calendar-xmark"
                                title="لا توجد مواعيد لهذا اليوم" content="لا يوجد جدول عمل مفعّل لهذا اليوم." />
                        @endif
                    </div>
                @endforelse

            </div>
        </div>

    </main>

    {{-- مودال إغلاق المواعيد --}}
    <div id="closeReasonModal" class="hidden fixed inset-0 z-50 items-center justify-center p-4"
        style="background: rgba(0,0,0,.5);">
        <div class="clinic-surface-card modal-panel--edit w-full max-w-md bg-white p-4 sm:p-5" style="background:#fff;">

            <div class="modal-head">

                <span class="modal-head__icon">
                    <i data-lucide="lock" class="size-5"></i>
                </span>

                <div class="min-w-0 flex-1">
                    <h3 class="modal-head__title">تأكيد إغلاق المواعيد</h3>
                    <p id="closeReasonCount" class="modal-head__sub"></p>
                </div>

            </div>

            <label for="closeReasonTextarea" class="field-label mt-3 block">سبب الإغلاق (اختياري)</label>
            <textarea id="closeReasonTextarea" rows="3" class="field-select mt-1 w-full resize-none"
                placeholder="اكتب السبب هنا..."></textarea>

            <div class="modal-foot">
                <button type="button" id="closeReasonCancel" class="btn btn-outline btn-sm">إلغاء</button>
                <button type="button" id="closeReasonConfirm" class="btn btn-default btn-sm btn-submit">
                    <i data-lucide="lock" class="size-3.5"></i> تأكيد الإغلاق
                </button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var form = document.getElementById('closeSlotsForm');
            var bulkBtn = document.getElementById('bulkCloseBtn');
            var msg = document.getElementById('bulkCloseMsg');

            var modal = document.getElementById('closeReasonModal');
            var modalCount = document.getElementById('closeReasonCount');
            var modalTextarea = document.getElementById('closeReasonTextarea');
            var modalCancel = document.getElementById('closeReasonCancel');
            var modalConfirm = document.getElementById('closeReasonConfirm');

            if (!form || !bulkBtn) return;

            function showMsg(text) {
                if (!msg) return;
                msg.textContent = text;
                msg.classList.remove('hidden');
            }

            function hideMsg() {
                if (!msg) return;
                msg.classList.add('hidden');
                msg.textContent = '';
            }

            function openModal(count) {
                modalCount.textContent = 'سيتم إغلاق ' + count + ' موعد/مواعيد محددة.';
                modalTextarea.value = '';
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            bulkBtn.addEventListener('click', function() {
                var checked = document.querySelectorAll('#slots-grid input.slot-checkbox:checked');

                if (checked.length === 0) {
                    showMsg('من فضلك حدد موعدًا واحدًا على الأقل لإغلاقه.');
                    return;
                }

                hideMsg();
                openModal(checked.length);
            });

            modalCancel.addEventListener('click', closeModal);

            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeModal();
            });

            modalConfirm.addEventListener('click', function() {
                var checked = document.querySelectorAll('#slots-grid input.slot-checkbox:checked');

                if (checked.length === 0) {
                    closeModal();
                    showMsg('من فضلك حدد موعدًا واحدًا على الأقل لإغلاقه.');
                    return;
                }

                form.querySelectorAll('input[name="times[]"]').forEach(function(el) {
                    el.remove();
                });

                checked.forEach(function(cb) {
                    var hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'times[]';
                    hidden.value = cb.value;
                    form.appendChild(hidden);
                });

                var reasonInput = document.getElementById('closeReasonInput');
                if (reasonInput) reasonInput.value = modalTextarea.value || '';

                form.submit();
            });
        })();
    </script>
@endsection
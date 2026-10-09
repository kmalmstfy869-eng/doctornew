@extends('doctor.layouts.app_clinc')

@section('title', 'المرضى | دليل الأطباء')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
@endpush
    @once('modal-variants-css')
        @push('extra_style')
            <link rel="stylesheet" href="{{ asset('css/clinic/modal_variants.css') }}">
        @endpush
    @endonce
@section('content')

    @php
        $formKey = old('_form');
        $isCreateForm = $formKey === 'create';
        $createBag = $errors->getBag('createPatient');
        $editingId = str_starts_with((string) $formKey, 'edit-') ? (int) substr($formKey, 5) : null;

        $openModal = $createBag->any()
            ? 'modal-new-patient'
            : ($editingId && $errors->getBag('editPatient')->any() ? "modal-edit-patient-{$editingId}" : null);
    @endphp

    <main class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">
                <h1 class="truncate text-xl font-bold sm:text-2xl">المرضى</h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    <span id="patients-count">{{ $patients->total() }}</span>
                    ملف مريض مسجل في عيادتك
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button" class="btn btn-default" data-modal-open="modal-new-patient">
                    <i data-lucide="user-plus" class="size-4"></i>
                    مريض جديد
                </button>
            </div>

        </div>

        <div class="relative mb-4 max-w-md">

            <input id="patients-live-search" type="text" name="search" value="{{ request('search') }}"
                placeholder="ابحث بالاسم أو رقم الملف أو الهاتف" autocomplete="off" data-live-search
                data-live-search-url="{{ route('clinic.patients') }}" data-live-search-target="#patients-results"
                data-live-search-pagination="#patients-pagination" data-live-search-count="#patients-count"
                class="field-input pe-9">

        </div>

        <div id="patients-results">

            @if ($patients->count())

                <div id="patients-grid" class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">

                    @foreach ($patients as $patient)
                        @php
                            $initials = mb_substr(trim($patient->name), 0, 2);
                            $isThis = $editingId === $patient->id;
                            $editBag = $isThis ? $errors->getBag('editPatient') : new \Illuminate\Support\MessageBag();
                            $val = fn($key, $default = null) => $isThis ? old($key, $default) : $default;
                        @endphp

                        <div class="clinic-surface-card p-4" data-search-text="{{ $patient->name }} {{ $patient->phone }}">

                            <div class="flex items-start gap-3">

                                <span
                                    class="grid size-11 shrink-0 place-items-center rounded-full bg-primary-soft font-bold text-primary">
                                    {{ $initials ?: '؟' }}
                                </span>

                                <div class="min-w-0 flex-1">

                                    <a href="{{ route('clinic.patients.show', $patient) }}"
                                        class="block truncate font-bold text-primary hover:underline">
                                        {{ $patient->name }}
                                    </a>

                                    <p class="text-xs text-muted-foreground tabular-nums" dir="ltr">
                                        @if ($patient->phone)
                                            {{ $patient->phone }}
                                        @else
                                            لا يوجد رقم هاتف
                                        @endif
                                    </p>

                                    <div class="mt-2 flex flex-wrap gap-1.5">

                                        <span class="badge badge-muted">
                                            @if ($patient->birth_date)
                                                {{ $patient->birth_date->age }}
                                                سنة
                                            @else
                                                العمر غير محدد
                                            @endif
                                        </span>

                                        <span class="badge badge-info">
                                            @if ($patient->gender === 'male')
                                                ذكر
                                            @elseif ($patient->gender === 'female')
                                                أنثى
                                            @else
                                                غير محدد
                                            @endif
                                        </span>

                                    </div>

                                </div>

                            </div>

                            <div class="mt-3 flex items-center justify-between border-t border-border pt-3">

                                <p class="text-xs text-muted-foreground">
                                    سُجل
                                    {{ $patient->created_at->locale('ar')->translatedFormat('d M Y') }}
                                </p>

                                <div class="flex gap-1">

                                    <a href="{{ route('clinic.patients.show', $patient) }}" class="btn btn-outline btn-sm">
                                        الملف
                                    </a>

                                    <button type="button" class="btn btn-ghost btn-icon-sm"
                                        data-modal-open="modal-edit-patient-{{ $patient->id }}" aria-label="تعديل">
                                        <i data-lucide="pencil" class="size-4"></i>
                                    </button>

                                    @unless ((bool) Auth::user()?->doctorAssistant)
                                        <form method="POST" action="{{ route('clinic.patient.destroy', $patient) }}"
                                            class="inline"
                                            onsubmit="return confirm('هل أنت متأكد من حذف ملف المريض؟ سيتم حذف بياناته المرتبطة بالعيادة أيضًا .');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-ghost btn-icon-sm text-destructive hover:text-destructive"
                                                aria-label="حذف" title="حذف المريض">
                                                <i data-lucide="trash-2" class="size-4"></i>
                                            </button>

                                        </form>
                                    @endunless

                                </div>

                            </div>

                        </div>

                        {{-- ================= مودال التعديل ================= --}}
                        <div id="modal-edit-patient-{{ $patient->id }}" class="modal-overlay">

                            <div class="modal-panel modal-panel--edit">

                                <div class="modal-head">
                                    <span class="modal-head__icon">
                                        <i data-lucide="pencil" class="size-5"></i>
                                    </span>
                                    <div>
                                        <h2 class="modal-head__title">تعديل بيانات المريض</h2>
                                        <p class="modal-head__sub">{{ $patient->name }}</p>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('clinic.patients.update', $patient) }}">

                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="_form" value="edit-{{ $patient->id }}">

                                    <div class="grid gap-4 sm:grid-cols-2">

                                        <div class="sm:col-span-2">
                                            <label class="field-label">الاسم الكامل *</label>
                                            <input type="text" name="name"
                                                class="field-input {{ $editBag->has('name') ? 'border-destructive' : '' }}"
                                                value="{{ $val('name', $patient->name) }}" required>
                                            @if ($editBag->has('name'))
                                                <p class="mt-1 text-xs text-destructive">{{ $editBag->first('name') }}</p>
                                            @endif
                                        </div>

                                        <div>
                                            <label class="field-label">الهاتف *</label>
                                            <input type="text" name="phone" dir="ltr"
                                                class="field-input {{ $editBag->has('phone') ? 'border-destructive' : '' }}"
                                                value="{{ $val('phone', $patient->phone) }}" placeholder="01xxxxxxxxx">
                                            @if ($editBag->has('phone'))
                                                <p class="mt-1 text-xs text-destructive">{{ $editBag->first('phone') }}</p>
                                            @endif
                                        </div>

                                        <div>
                                            <label class="field-label">تاريخ الميلاد</label>
                                            <input type="date" name="birth_date"
                                                class="field-input {{ $editBag->has('birth_date') ? 'border-destructive' : '' }}"
                                                value="{{ $val('birth_date', $patient->birth_date?->format('Y-m-d')) }}">
                                            @if ($editBag->has('birth_date'))
                                                <p class="mt-1 text-xs text-destructive">{{ $editBag->first('birth_date') }}</p>
                                            @endif
                                        </div>

                                        <div>
                                            <label class="field-label">الجنس</label>
                                            <select name="gender"
                                                class="field-select {{ $editBag->has('gender') ? 'border-destructive' : '' }}">
                                                <option value="">اختر الجنس</option>
                                                <option value="male" @selected($val('gender', $patient->gender) === 'male')>ذكر</option>
                                                <option value="female" @selected($val('gender', $patient->gender) === 'female')>أنثى</option>
                                            </select>
                                            @if ($editBag->has('gender'))
                                                <p class="mt-1 text-xs text-destructive">{{ $editBag->first('gender') }}</p>
                                            @endif
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label class="field-label">العنوان</label>
                                            <textarea name="address" class="field-textarea {{ $editBag->has('address') ? 'border-destructive' : '' }}"
                                                rows="2" placeholder="عنوان المريض">{{ $val('address', $patient->address) }}</textarea>
                                            @if ($editBag->has('address'))
                                                <p class="mt-1 text-xs text-destructive">{{ $editBag->first('address') }}</p>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="modal-foot">
                                        <button type="button" class="btn btn-outline" data-modal-close>إلغاء</button>
                                        <button type="submit" class="btn btn-default btn-submit">حفظ التعديلات</button>
                                    </div>

                                </form>

                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                <x-home.banner.no_results logo="fa-solid fa-magnifying-glass" title="لا يوجد مرضى"
                    content="لم يتم العثور على مرضى مطابقين للبحث أو لا يوجد مرضى مسجلين في عيادتك." />
            @endif

        </div>

        <div id="patients-pagination" class="mt-4">
            {{ $patients->withQueryString()->links('vendor.pagination.custom') }}
        </div>

        {{-- ================= مودال الإنشاء ================= --}}
        <div id="modal-new-patient" class="modal-overlay">

            <div class="modal-panel modal-panel--create">

                <div class="modal-head">
                    <span class="modal-head__icon">
                        <i data-lucide="user-plus" class="size-5"></i>
                    </span>
                    <div>
                        <h2 class="modal-head__title">مريض جديد</h2>
                        <p class="modal-head__sub">هذا الملف خاص بعيادتك فقط ولا يظهر لأطباء آخرين.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('clinic.patients.store') }}">

                    @csrf
                    <input type="hidden" name="_form" value="create">

                    <div class="grid gap-4 sm:grid-cols-2">

                        <div class="sm:col-span-2">
                            <label class="field-label">الاسم الكامل *</label>
                            <input type="text" name="name"
                                class="field-input {{ $createBag->has('name') ? 'border-destructive' : '' }}"
                                value="{{ $isCreateForm ? old('name') : '' }}" placeholder="اسم المريض" required>
                            @if ($createBag->has('name'))
                                <p class="mt-1 text-xs text-destructive">{{ $createBag->first('name') }}</p>
                            @endif
                        </div>

                        <div>
                            <label class="field-label">الهاتف *</label>
                            <input type="text" name="phone" dir="ltr"
                                class="field-input {{ $createBag->has('phone') ? 'border-destructive' : '' }}"
                                value="{{ $isCreateForm ? old('phone') : '' }}" placeholder="01xxxxxxxxx">
                            @if ($createBag->has('phone'))
                                <p class="mt-1 text-xs text-destructive">{{ $createBag->first('phone') }}</p>
                            @endif
                        </div>

                        <div>
                            <label class="field-label">تاريخ الميلاد</label>
                            <input type="date" name="birth_date"
                                class="field-input {{ $createBag->has('birth_date') ? 'border-destructive' : '' }}"
                                value="{{ $isCreateForm ? old('birth_date') : '' }}">
                            @if ($createBag->has('birth_date'))
                                <p class="mt-1 text-xs text-destructive">{{ $createBag->first('birth_date') }}</p>
                            @endif
                        </div>

                        <div>
                            <label class="field-label">الجنس</label>
                            <select name="gender"
                                class="field-select {{ $createBag->has('gender') ? 'border-destructive' : '' }}">
                                <option value="">اختر الجنس</option>
                                <option value="male" @selected($isCreateForm && old('gender') === 'male')>ذكر</option>
                                <option value="female" @selected($isCreateForm && old('gender') === 'female')>أنثى</option>
                            </select>
                            @if ($createBag->has('gender'))
                                <p class="mt-1 text-xs text-destructive">{{ $createBag->first('gender') }}</p>
                            @endif
                        </div>

                        <div class="sm:col-span-2">
                            <label class="field-label">العنوان</label>
                            <textarea name="address" class="field-textarea {{ $createBag->has('address') ? 'border-destructive' : '' }}"
                                rows="2" placeholder="عنوان المريض">{{ $isCreateForm ? old('address') : '' }}</textarea>
                            @if ($createBag->has('address'))
                                <p class="mt-1 text-xs text-destructive">{{ $createBag->first('address') }}</p>
                            @endif
                        </div>

                    </div>

                    <div class="modal-foot">
                        <button type="button" class="btn btn-outline" data-modal-close>إلغاء</button>
                        <button type="submit" class="btn btn-default btn-submit">حفظ</button>
                    </div>

                </form>

            </div>

        </div>

    </main>

    @push('extra_java')
        <script>
            window.PatientsPageConfig = {
                openModal: @json($openModal),
            };
        </script>

        <script src="{{ asset('js/clinic/live_search.js') }}"></script>
        <script src="{{ asset('js/clinic/patients_index.js') }}"></script>
    @endpush

@endsection
@props([
    'patient' => null,
    'action' => null,
    'updateAction' => null,
])

@php
    $isPatientLocked = $patient !== null;

    $bag = $errors->getBag('prescription');
    $hasErrors = $bag->any();

    $old = fn ($key, $default = null) =>
        $hasErrors ? old($key, $default) : $default;

    $createAction = $action ?? route('clinic.prescriptions.store');

    $updateTemplate =
        $updateAction ??
        route('clinic.prescriptions.update', [
            'prescription' => '__ID__',
        ]);

    $oldEditingId = $hasErrors
        ? (int) old('_prescription_editing')
        : 0;

    $initialEditing = $oldEditingId > 0;

    $initialId = $initialEditing
        ? $oldEditingId
        : '';

    $initialAction = $initialEditing
        ? str_replace(
            '__ID__',
            $oldEditingId,
            $updateTemplate
        )
        : $createAction;

    $selectedPatientId =
        $isPatientLocked
            ? $patient->id
            : $old('patient_id');

    $searchPatient =
        ! $isPatientLocked && $selectedPatientId
            ? auth()->user()?->doctor?->patients()->find($selectedPatientId)
            : null;

    $oldMode = $hasErrors ? old('_patient_mode') : null;

    $initialMode = $isPatientLocked
        ? 'registered'
        : (in_array($oldMode, ['registered', 'external'], true)
            ? $oldMode
            : 'registered');

    // المريض المختار (بحث) بعد فشل الفورم
    $initialPatient =
        $hasErrors && $initialMode === 'registered' && $searchPatient
            ? [
                'id' => $searchPatient->id,
                'name' => $searchPatient->name,
                'phone' => $searchPatient->phone,
            ]
            : null;

    $initialFields = [
        'next_visit_date' =>
            $old('next_visit_date', '') ?? '',

        'notes' =>
            $old('notes', '') ?? '',

        'patient_name' =>
            $old('patient_name', '') ?? '',

        'patient_phone' =>
            $old('patient_phone', '') ?? '',
    ];

    $blankMed = [
        'name' => '',
        'dose' => '',
        'frequency' => '',
        'duration' => '',
        'timing' => '',
        'notes' => '',
    ];

    $oldMeds = $hasErrors
        ? old('medications')
        : null;

    $initialMeds =
        is_array($oldMeds) && count($oldMeds)
            ? collect($oldMeds)
                ->map(
                    fn ($m) =>
                        array_merge(
                            $blankMed,
                            \Illuminate\Support\Arr::only(
                                (array) $m,
                                array_keys($blankMed)
                            )
                        )
                )
                ->map(
                    fn ($m) =>
                        array_map(
                            fn ($v) => (string) ($v ?? ''),
                            $m
                        )
                )
                ->values()
                ->all()
            : [$blankMed];

    $errorMap = collect($bag->toArray())
        ->map(fn ($messages) => $messages[0] ?? '')
        ->all();
@endphp

@once
    @once('modal-variants-css')
        @push('extra_style')
            <link rel="stylesheet" href="{{ asset('css/clinic/modal_variants.css') }}">
        @endpush
    @endonce

    <style>
        /* ===== Prescription modal ===== */

        .modal-panel.bq-rx-modal {
            width: min(96vw, 980px);
            max-width: 96vw;
            max-height: 92vh;
            overflow-y: auto;
        }

        .bq-rx-modal .bq-modal-footer {
            position: sticky;
            bottom: 0;
            z-index: 2;
            background: inherit;
        }

        .bq-rx-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1rem;
            margin-top: 1.25rem;
        }

        @media (min-width: 640px) {
            .bq-rx-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .bq-rx-full {
                grid-column: 1 / -1;
            }
        }

        .bq-rx-section-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
            margin-top: 1.5rem;
        }

        .bq-rx-med {
            margin-top: .75rem;
            padding: .875rem;
            border: 1px solid hsl(var(--border, 214 32% 91%) / .7);
            border-radius: .875rem;
        }

        .bq-rx-med-head {
            display: flex;
            align-items: center;
            gap: .625rem;
            margin-bottom: .75rem;
        }

        .bq-rx-med-num {
            display: grid;
            place-items: center;
            width: 1.75rem;
            height: 1.75rem;
            border-radius: .5rem;
            font-size: .8rem;
            font-weight: 700;
        }

        .bq-rx-med-title {
            flex: 1;
            font-size: .875rem;
            font-weight: 700;
        }

        .bq-rx-med-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: .75rem;
        }

        .bq-rx-c-name,
        .bq-rx-c-notes {
            grid-column: 1 / -1;
        }

        @media (min-width: 768px) {
            .bq-rx-med-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .bq-rx-c-name,
            .bq-rx-c-notes {
                grid-column: span 2;
            }
        }

        .bq-rx-add {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            width: 100%;
            margin-top: .75rem;
            padding: .75rem;
            border: 1px dashed currentColor;
            border-radius: .875rem;
            font-weight: 600;
            cursor: pointer;
            background: transparent;
        }

        .bq-rx-modal .bq-rx-textarea {
            display: block;
            width: 100%;
            min-height: 6rem;
            max-height: 45vh;
            line-height: 1.75;
            resize: vertical;
            overflow-y: auto;
        }

        .bq-rx-mode {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            margin-bottom: 1rem;
        }
    </style>

    <datalist id="bq-rx-frequency">
        <option value="مرة يوميًا"></option>
        <option value="مرتين يوميًا"></option>
        <option value="3 مرات يوميًا"></option>
        <option value="4 مرات يوميًا"></option>
        <option value="كل 8 ساعات"></option>
        <option value="كل 12 ساعة"></option>
        <option value="عند اللزوم"></option>
    </datalist>

    <datalist id="bq-rx-duration">
        <option value="3 أيام"></option>
        <option value="5 أيام"></option>
        <option value="7 أيام"></option>
        <option value="10 أيام"></option>
        <option value="أسبوعين"></option>
        <option value="شهر"></option>
        <option value="مستمر"></option>
    </datalist>

    <datalist id="bq-rx-timing">
        <option value="بعد الأكل"></option>
        <option value="قبل الأكل"></option>
        <option value="مع الأكل"></option>
        <option value="على معدة فاضية"></option>
        <option value="قبل النوم"></option>
        <option value="صباحًا"></option>
        <option value="مساءً"></option>
    </datalist>
@endonce

<div
    x-data="{
        rxOpen: @js($hasErrors),
        rxShowErrors: @js($hasErrors),
        rxErrors: @js($errorMap),

        rxBusy: false,

        rxLocked: @js($isPatientLocked),

        rxEdit: @js($initialEditing),
        rxId: @js($initialId),

        rxAction: @js($initialAction),
        rxCreateAction: @js($createAction),
        rxUpdateTemplate: @js($updateTemplate),

        rxMode: @js($initialMode),

        rxInitialPatient: @js($initialPatient),

        rxSeq: 0,

        rxF: @js($initialFields),

        rxMeds: [],

        rxInitMeds: @js($initialMeds),

        rxInit() {
            this.rxMeds =
                this.rxInitMeds.map(
                    (m) => this.rxMakeMed(m)
                );

            if (this.rxOpen) {
                this.$nextTick(() => {
                    this.rxGrowAll();

                    if (this.rxInitialPatient) {
                        this.rxSetPatient(this.rxInitialPatient);
                    }
                });
            }
        },

        rxMakeMed(m) {
            this.rxSeq++;

            return {
                _k: this.rxSeq,

                name: m.name || '',
                dose: m.dose || '',
                frequency: m.frequency || '',
                duration: m.duration || '',
                timing: m.timing || '',
                notes: m.notes || '',
            };
        },

        rxBlankFields() {
            return {
                next_visit_date: '',
                notes: '',
                patient_name: '',
                patient_phone: '',
            };
        },

        rxErr(key) {
            return this.rxShowErrors
                ? (this.rxErrors[key] || '')
                : '';
        },

        rxGrow(el) {
            el.style.height = 'auto';
            el.style.height =
                el.scrollHeight + 2 + 'px';
        },

        rxGrowAll() {
            if (!this.$refs.rxForm) {
                return;
            }

            this.$refs.rxForm
                .querySelectorAll(
                    'textarea.bq-rx-textarea'
                )
                .forEach((el) => this.rxGrow(el));
        },

        rxSetPatient(p) {
            const box =
                this.$refs.rxForm
                    ? this.$refs.rxForm.querySelector(
                        '[data-patient-search]'
                    )
                    : null;

            if (!box) {
                return;
            }

            const idInput =
                box.querySelector(
                    '[data-patient-search-id]'
                );

            const selected =
                box.querySelector(
                    '[data-patient-search-selected]'
                );

            const picker =
                box.querySelector(
                    '[data-patient-search-picker]'
                );

            const searchInput =
                box.querySelector(
                    '[data-patient-search-input]'
                );

            const results =
                box.querySelector(
                    '[data-patient-search-results]'
                );

            const nameEl =
                box.querySelector(
                    '[data-patient-search-selected-name]'
                );

            const phoneEl =
                box.querySelector(
                    '[data-patient-search-selected-phone]'
                );

            if (idInput) {
                idInput.value = p ? p.id : '';
            }

            if (searchInput) {
                searchInput.value = '';
            }

            if (results) {
                results.innerHTML = '';
                results.classList.add('hidden');
            }

            if (nameEl) {
                nameEl.textContent =
                    p ? (p.name || '') : '';
            }

            if (phoneEl) {
                phoneEl.textContent =
                    p
                        ? (p.phone || 'لا يوجد رقم هاتف')
                        : '';
            }

            if (selected) {
                selected.classList.toggle(
                    'hidden',
                    !p
                );
            }

            if (picker) {
                picker.classList.toggle(
                    'hidden',
                    !!p
                );
            }
        },

        rxSwitchMode(mode) {
            if (
                this.rxLocked ||
                this.rxEdit ||
                mode === this.rxMode
            ) {
                return;
            }

            if (mode === 'external') {
                this.rxSetPatient(null);
            }

            this.rxMode = mode;
        },

        addMedication() {
            if (this.rxMeds.length >= 30) {
                return;
            }

            this.rxMeds.push(
                this.rxMakeMed({})
            );

            this.$nextTick(() => {
                const inputs =
                    this.$refs.rxForm.querySelectorAll(
                        '[data-rx-med-name]'
                    );

                if (inputs.length) {
                    inputs[
                        inputs.length - 1
                    ].focus();
                }
            });
        },

        removeMedication(i) {
            if (this.rxMeds.length > 1) {
                this.rxMeds.splice(i, 1);
            }
        },

        openCreatePrescription() {
            this.rxEdit = false;
            this.rxId = '';

            this.rxAction =
                this.rxCreateAction;

            this.rxF =
                this.rxBlankFields();

            this.rxMeds = [
                this.rxMakeMed({})
            ];

            this.rxShowErrors = false;
            this.rxBusy = false;

            this.rxMode = 'registered';

            this.rxSetPatient(null);

            this.rxOpen = true;

            this.$nextTick(() => {
                this.rxGrowAll();
            });
        },

        openEditPrescription(p) {
            const f =
                this.rxBlankFields();

            [
                'next_visit_date',
                'notes',
                'patient_name',
                'patient_phone'
            ].forEach((k) => {
                if (
                    p[k] !== null &&
                    p[k] !== undefined &&
                    p[k] !== ''
                ) {
                    f[k] = p[k];
                }
            });

            this.rxEdit = true;

            this.rxId = p.id;

            this.rxAction =
                this.rxUpdateTemplate.replace(
                    '__ID__',
                    p.id
                );

            this.rxF = f;

            this.rxMeds =
                (
                    Array.isArray(p.medications) &&
                    p.medications.length
                )
                    ? p.medications
                    : [{}];

            this.rxMeds =
                this.rxMeds.map(
                    (m) => this.rxMakeMed(m)
                );

            this.rxShowErrors = false;
            this.rxBusy = false;

            if (p.patient_id) {
                this.rxMode = 'registered';

                this.rxSetPatient({
                    id: p.patient_id,
                    name: p.patient_name,
                    phone: p.patient_phone
                });
            } else {
                this.rxMode = 'external';

                this.rxSetPatient(null);
            }

            this.rxOpen = true;

            this.$nextTick(() => {
                this.rxGrowAll();
            });
        },
    }"
    x-init="rxInit()"
    @bq-rx-create.window="openCreatePrescription()"
    @bq-rx-edit.window="openEditPrescription($event.detail)"
>

    <div
        x-cloak
        x-show="rxOpen"
        x-transition.opacity
        :class="{ 'open': rxOpen }"
        class="modal-overlay"
        @click.self="rxOpen = false"
        @keydown.escape.window="rxOpen = false"
    >

        <div
            x-show="rxOpen"
            x-transition
            @click.stop
            class="modal-panel bq-rx-modal"
            :class="rxEdit ? 'modal-panel--edit' : 'modal-panel--create'"
        >

            {{-- Header --}}
            <div class="modal-head">

                <span class="modal-head__icon">
                    <span x-show="!rxEdit"><i data-lucide="file-plus" class="size-5"></i></span>
                    <span x-show="rxEdit"><i data-lucide="pencil" class="size-5"></i></span>
                </span>

                <div class="min-w-0 flex-1">

                    <h3
                        class="modal-head__title"
                        x-text="
                            rxEdit
                                ? 'تعديل الروشتة'
                                : 'روشتة جديدة'
                        "
                    >
                        {{ $initialEditing
                            ? 'تعديل الروشتة'
                            : 'روشتة جديدة' }}
                    </h3>

                    <p class="modal-head__sub">
                        اكتب بيانات المريض والأدوية، ويمكن طباعتها بعد الحفظ.
                    </p>

                </div>

                <button
                    type="button"
                    class="btn btn-icon"
                    @click="rxOpen = false"
                >
                    <i
                        data-lucide="x"
                        class="size-5"
                    ></i>
                </button>

            </div>

            {{-- Form --}}
            <form
                x-ref="rxForm"
                method="POST"
                action="{{ $initialAction }}"
                :action="rxAction"
                @submit="rxBusy = true"
            >

                @csrf

                {{-- PUT في التعديل --}}
                <input
                    type="hidden"
                    name="_method"
                    value="PUT"
                    :disabled="!rxEdit"
                    @if (! $initialEditing) disabled @endif
                >

                {{-- ID الروشتة في التعديل --}}
                <input
                    type="hidden"
                    name="_prescription_editing"
                    :value="rxId"
                    :disabled="!rxEdit"
                    value="{{ $initialId }}"
                    @if (! $initialEditing) disabled @endif
                >

                {{-- وضع المريض --}}
                @if (! $isPatientLocked)

                    <input
                        type="hidden"
                        name="_patient_mode"
                        :value="rxMode"
                        value="{{ $initialMode }}"
                    >

                @endif

                {{-- ========================================================= --}}
                {{-- المريض --}}
                {{-- ========================================================= --}}

                @if ($isPatientLocked)

                    <div>

                        <input
                            type="hidden"
                            name="patient_id"
                            value="{{ $selectedPatientId }}"
                        >

                        <div class="rounded-xl border border-border/60 bg-muted/30 p-4">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft font-bold text-primary"
                                >
                                    {{ mb_substr($patient->name, 0, 2) }}
                                </div>

                                <div class="min-w-0">

                                    <p class="truncate font-semibold">
                                        {{ $patient->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-muted-foreground">
                                        {{ $patient->phone ?: 'لا يوجد رقم هاتف' }}
                                    </p>

                                </div>

                            </div>

                        </div>

                        <p
                            class="bq-field-error mt-2"
                            x-show="rxErr('patient_id')"
                        >
                            <span
                                x-text="rxErr('patient_id')"
                            ></span>
                        </p>

                    </div>

                @else

                    {{-- اختيار نوع المريض (مخفي في التعديل) --}}
                    <div
                        class="bq-rx-mode"
                        x-show="!rxEdit"
                    >

                        <button
                            type="button"
                            class="btn btn-sm"
                            :class="
                                rxMode === 'registered'
                                    ? 'btn-default'
                                    : 'btn-outline'
                            "
                            @click="
                                rxSwitchMode('registered')
                            "
                        >
                            مريض مسجل
                        </button>

                        <button
                            type="button"
                            class="btn btn-sm"
                            :class="
                                rxMode === 'external'
                                    ? 'btn-default'
                                    : 'btn-outline'
                            "
                            @click="
                                rxSwitchMode('external')
                            "
                        >
                            شخص غير مسجل
                        </button>

                    </div>

                    {{-- ===================================================== --}}
                    {{-- مريض مسجل --}}
                    {{-- ===================================================== --}}

                    <div
                        x-show="rxMode === 'registered'"
                        data-patient-search
                        data-patient-search-url="{{ route('clinic.bookings.patients.search') }}"
                    >

                        <input
                            type="hidden"
                            name="patient_id"
                            value="{{ $selectedPatientId }}"
                            data-patient-search-id
                        >

                        <div
                            data-patient-search-selected
                            class="hidden rounded-xl border border-border/60 bg-muted/30 p-4"
                        >

                            <div class="flex items-center justify-between gap-3">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div
                                        class="grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft font-bold text-primary"
                                    >
                                        <i
                                            data-lucide="user-round"
                                            class="size-5"
                                        ></i>
                                    </div>

                                    <div class="min-w-0">

                                        <p
                                            data-patient-search-selected-name
                                            class="truncate font-semibold"
                                        >
                                            {{ $searchPatient?->name }}
                                        </p>

                                        <p
                                            data-patient-search-selected-phone
                                            class="mt-1 text-xs text-muted-foreground"
                                        >
                                            {{
                                                $searchPatient
                                                    ? (
                                                        $searchPatient->phone
                                                            ?: 'لا يوجد رقم هاتف'
                                                    )
                                                    : ''
                                            }}
                                        </p>

                                    </div>

                                </div>

                                {{-- زر التغيير (مخفي في التعديل) --}}
                                <button
                                    type="button"
                                    data-patient-search-change
                                    x-show="!rxEdit"
                                    class="btn btn-outline btn-sm shrink-0"
                                >
                                    تغيير
                                </button>

                            </div>

                        </div>

                        <div data-patient-search-picker>

                            <label class="field-label">
                                البحث عن المريض
                            </label>

                            <div class="relative">

                                <i
                                    data-lucide="search"
                                    class="pointer-events-none absolute start-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground"
                                ></i>

                                <input
                                    type="text"
                                    class="field-input ps-9"
                                    placeholder="ابحث باسم المريض أو رقم الهاتف"
                                    autocomplete="off"
                                    data-patient-search-input
                                >

                            </div>

                            <div
                                data-patient-search-results
                                class="mt-2 hidden max-h-60 overflow-y-auto rounded-xl border border-border bg-background shadow-lg"
                            ></div>

                        </div>

                        <p
                            class="bq-field-error mt-2"
                            x-show="
                                rxMode === 'registered' &&
                                rxErr('patient_id')
                            "
                        >
                            <span
                                x-text="rxErr('patient_id')"
                            ></span>
                        </p>

                    </div>

                    {{-- ===================================================== --}}
                    {{-- شخص غير مسجل --}}
                    {{-- ===================================================== --}}

                    <div
                        x-show="rxMode === 'external'"
                        class="bq-rx-grid"
                        style="margin-top:0"
                    >

                        <div>

                            <label class="field-label">
                                اسم المريض
                            </label>

                            <input
                                type="text"
                                name="patient_name"
                                class="field-input"
                                maxlength="150"
                                placeholder="اكتب اسم المريض"
                                x-model="rxF.patient_name"
                                :disabled="
                                    rxMode !== 'external'
                                "
                            >

                            <p
                                class="bq-field-error mt-2"
                                x-show="
                                    rxMode === 'external' &&
                                    rxErr('patient_name')
                                "
                            >
                                <span
                                    x-text="rxErr('patient_name')"
                                ></span>
                            </p>

                        </div>

                        <div>

                            <label class="field-label">
                                رقم الهاتف
                            </label>

                            <input
                                type="text"
                                name="patient_phone"
                                class="field-input"
                                maxlength="30"
                                placeholder="01xxxxxxxxx"
                                x-model="rxF.patient_phone"
                                :disabled="
                                    rxMode !== 'external'
                                "
                            >

                            <p
                                class="bq-field-error mt-2"
                                x-show="
                                    rxMode === 'external' &&
                                    rxErr('patient_phone')
                                "
                            >
                                <span
                                    x-text="rxErr('patient_phone')"
                                ></span>
                            </p>

                        </div>

                    </div>

                @endif

                {{-- ========================================================= --}}
                {{-- موعد المتابعة فقط --}}
                {{-- ========================================================= --}}

                <div class="bq-rx-grid">

                    <div class="bq-rx-full">

                        <label class="field-label">
                            موعد المتابعة / الإعادة
                        </label>

                        <input
                            type="date"
                            name="next_visit_date"
                            class="field-input"
                            x-model="rxF.next_visit_date"
                        >

                        <p
                            class="bq-field-error mt-2"
                            x-show="rxErr('next_visit_date')"
                        >
                            <span
                                x-text="rxErr('next_visit_date')"
                            ></span>
                        </p>

                    </div>

                </div>

                {{-- ========================================================= --}}
                {{-- الأدوية --}}
                {{-- ========================================================= --}}

                <div class="bq-rx-section-title">

                    <h4 class="text-base font-bold">

                        الأدوية

                        <span
                            class="text-xs font-medium text-muted-foreground"
                            x-text="
                                '(' +
                                rxMeds.length +
                                ')'
                            "
                        ></span>

                    </h4>

                </div>

                <p
                    class="bq-field-error mt-2"
                    x-show="rxErr('medications')"
                >
                    <span
                        x-text="rxErr('medications')"
                    ></span>
                </p>

                <template
                    x-for="(med, i) in rxMeds"
                    :key="med._k"
                >

                    <div class="bq-rx-med">

                        <div class="bq-rx-med-head">

                            <span
                                class="bq-rx-med-num bg-primary-soft text-primary"
                                x-text="i + 1"
                            ></span>

                            <span
                                class="bq-rx-med-title"
                                x-text="
                                    'العلاج ' +
                                    (i + 1)
                                "
                            ></span>

                            <button
                                type="button"
                                class="btn btn-icon"
                                x-show="rxMeds.length > 1"
                                @click="
                                    removeMedication(i)
                                "
                                aria-label="حذف العلاج"
                                title="حذف العلاج"
                            >

                                <svg
                                    viewBox="0 0 24 24"
                                    width="18"
                                    height="18"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    <line x1="10" x2="10" y1="11" y2="17" />
                                    <line x1="14" x2="14" y1="11" y2="17" />
                                </svg>

                            </button>

                        </div>

                        <div class="bq-rx-med-grid">

                            {{-- اسم العلاج --}}
                            <div class="bq-rx-c-name">

                                <label class="field-label">
                                    اسم العلاج
                                </label>

                                <input
                                    type="text"
                                    class="field-input"
                                    maxlength="150"
                                    data-rx-med-name
                                    placeholder="مثال: Panadol Extra"
                                    :name="
                                        'medications[' +
                                        i +
                                        '][name]'
                                    "
                                    x-model="med.name"
                                >

                                <p
                                    class="bq-field-error mt-2"
                                    x-show="
                                        rxErr(
                                            'medications.' +
                                            i +
                                            '.name'
                                        )
                                    "
                                >
                                    <span
                                        x-text="
                                            rxErr(
                                                'medications.' +
                                                i +
                                                '.name'
                                            )
                                        "
                                    ></span>
                                </p>

                            </div>

                            {{-- الجرعة --}}
                            <div>

                                <label class="field-label">
                                    الجرعة
                                </label>

                                <input
                                    type="text"
                                    class="field-input"
                                    maxlength="100"
                                    placeholder="قرص"
                                    :name="
                                        'medications[' +
                                        i +
                                        '][dose]'
                                    "
                                    x-model="med.dose"
                                >

                            </div>

                            {{-- عدد المرات --}}
                            <div>

                                <label class="field-label">
                                    عدد المرات
                                </label>

                                <input
                                    type="text"
                                    class="field-input"
                                    maxlength="100"
                                    list="bq-rx-frequency"
                                    placeholder="3 مرات يوميًا"
                                    :name="
                                        'medications[' +
                                        i +
                                        '][frequency]'
                                    "
                                    x-model="med.frequency"
                                >

                            </div>

                            {{-- المدة --}}
                            <div>

                                <label class="field-label">
                                    المدة
                                </label>

                                <input
                                    type="text"
                                    class="field-input"
                                    maxlength="100"
                                    list="bq-rx-duration"
                                    placeholder="5 أيام"
                                    :name="
                                        'medications[' +
                                        i +
                                        '][duration]'
                                    "
                                    x-model="med.duration"
                                >

                            </div>

                            {{-- التوقيت --}}
                            <div>

                                <label class="field-label">
                                    التوقيت
                                </label>

                                <input
                                    type="text"
                                    class="field-input"
                                    maxlength="100"
                                    list="bq-rx-timing"
                                    placeholder="بعد الأكل"
                                    :name="
                                        'medications[' +
                                        i +
                                        '][timing]'
                                    "
                                    x-model="med.timing"
                                >

                            </div>

                            {{-- ملاحظات العلاج --}}
                            <div class="bq-rx-c-notes">

                                <label class="field-label">
                                    ملاحظات
                                </label>

                                <input
                                    type="text"
                                    class="field-input"
                                    maxlength="255"
                                    placeholder="عند اللزوم..."
                                    :name="
                                        'medications[' +
                                        i +
                                        '][notes]'
                                    "
                                    x-model="med.notes"
                                >

                            </div>

                        </div>

                    </div>

                </template>

                {{-- إضافة علاج --}}
                <button
                    type="button"
                    class="bq-rx-add text-primary"
                    @click="addMedication()"
                >

                    <svg
                        viewBox="0 0 24 24"
                        width="18"
                        height="18"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>

                    إضافة علاج آخر

                </button>

                {{-- ========================================================= --}}
                {{-- ملاحظات الطبيب --}}
                {{-- ========================================================= --}}

                <div class="mt-5">

                    <label class="field-label">
                        ملاحظات الطبيب
                    </label>

                    <textarea
                        name="notes"
                        rows="3"
                        class="field-input bq-rx-textarea mt-2"
                        placeholder="تعليمات عامة للمريض..."
                        x-model="rxF.notes"
                        @input="rxGrow($el)"
                    >{{ $initialFields['notes'] }}</textarea>

                    <p
                        class="bq-field-error mt-2"
                        x-show="rxErr('notes')"
                    >
                        <span
                            x-text="rxErr('notes')"
                        ></span>
                    </p>

                </div>

                {{-- Footer --}}
                <div class="bq-modal-footer">

                    <button
                        type="button"
                        class="dropdown-item danger"
                        @click="rxOpen = false"
                    >
                        إلغاء
                    </button>

                    <button
                        type="submit"
                        class="btn btn-default btn-submit"
                        :disabled="rxBusy"
                    >

                        <i
                            data-lucide="save"
                            class="size-4"
                        ></i>

                        <span
                            x-text="
                                rxEdit
                                    ? 'حفظ التعديلات'
                                    : 'حفظ الروشتة'
                            "
                        >
                            {{ $initialEditing
                                ? 'حفظ التعديلات'
                                : 'حفظ الروشتة' }}
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- patient_search.js مطلوب فقط لما المريض مش مقفول --}}
@if (! $isPatientLocked)

    @once('bq-patient-search-js')

        @push('extra_java')

            <script src="{{ asset('js/clinic/patient_search.js') }}"></script>

        @endpush

    @endonce

@endif
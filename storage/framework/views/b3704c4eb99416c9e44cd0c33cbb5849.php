<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'patient' => null,
    'visit' => null,
    'action' => '#',
    'method' => 'POST',
    'title' => null,
    'showTrigger' => true,
    'updateAction' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'patient' => null,
    'visit' => null,
    'action' => '#',
    'method' => 'POST',
    'title' => null,
    'showTrigger' => true,
    'updateAction' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $isEdit = $visit !== null;
    $isPatientLocked = $patient !== null;

    /*
    |--------------------------------------------------------------------------
    | عزل الفورم: old() والأخطاء تخص فورم الزيارة بس
    |--------------------------------------------------------------------------
    */
    $isMine = old('_form') === 'visit';
    $old = fn($key, $default = null) => $isMine ? old($key, $default) : $default;

    // لو التعديل فشل: نرجع المودال في وضع التعديل بنفس الزيارة
    $failedVisitId = $isMine ? old('_visit_editing') : null;
    $failedEdit = filled($failedVisitId);

    $startEdit = $isEdit || $failedEdit;

    $selectedPatientId = $isPatientLocked ? $patient->id : $old('patient_id', $visit?->patient_id);

    $searchPatient =
        !$isPatientLocked && $selectedPatientId ? auth()->user()?->doctor?->patients()->find($selectedPatientId) : null;

    $toText = fn($value) => is_array($value) ? collect($value)->filter()->join("\n") : (string) ($value ?? '');

    $updateTemplate = $updateAction ?? route('clinic.visits.update', ['visit' => '__VISIT__']);

    $initialVisitId = $visit?->id ?? ($failedEdit ? $failedVisitId : '');

    $initialAction = $startEdit ? str_replace('__VISIT__', $initialVisitId, $updateTemplate) : $action;

    $createTitle = $title && !$isEdit ? $title : 'إنشاء زيارة جديدة';
    $editTitle = $title && $isEdit ? $title : 'تعديل الزيارة';

    $oldPatientMode = $isMine ? old('_patient_mode') : null;

    $initialPatientMode = $isPatientLocked
        ? 'registered'
        : (in_array($oldPatientMode, ['registered', 'external'], true)
            ? $oldPatientMode
            : 'registered');

    $initialFields = [
        'complaint' => $old('complaint', $toText($visit?->complaint)) ?? '',
        'symptoms' => $old('symptoms', $toText($visit?->symptoms)) ?? '',
        'diagnosis' => $old('diagnosis', $toText($visit?->diagnosis)) ?? '',
        'required_tests' => $old('required_tests', $toText($visit?->required_tests)) ?? '',
        'required_radiology' => $old('required_radiology', $toText($visit?->required_radiology)) ?? '',
        'notes' => $old('notes', $toText($visit?->notes)) ?? '',
        'next_visit_date' =>
            $old(
                'next_visit_date',
                $visit?->next_visit_date ? \Carbon\Carbon::parse($visit->next_visit_date)->format('Y-m-d') : '',
            ) ?? '',
        'patient_name' => $old('patient_name', '') ?? '',
        'patient_phone' => $old('patient_phone', '') ?? '',
    ];

    $textFields = [
        [
            'name' => 'complaint',
            'label' => 'الشكوى الرئيسية',
            'placeholder' => 'اكتب الشكوى الرئيسية للمريض...',
            'full' => false,
        ],
        [
            'name' => 'symptoms',
            'label' => 'الأعراض',
            'placeholder' => 'اكتب الأعراض...',
            'full' => false,
        ],
        [
            'name' => 'diagnosis',
            'label' => 'التشخيص',
            'placeholder' => 'اكتب التشخيص...',
            'full' => true,
        ],
        [
            'name' => 'required_tests',
            'label' => 'التحاليل المطلوبة',
            'placeholder' => 'اكتب التحاليل المطلوبة...',
            'full' => false,
        ],
        [
            'name' => 'required_radiology',
            'label' => 'الأشعة',
            'placeholder' => 'اكتب الأشعة المطلوبة...',
            'full' => false,
        ],
        [
            'name' => 'notes',
            'label' => 'ملاحظات الزيارة',
            'placeholder' => 'اكتب أي ملاحظات إضافية...',
            'full' => true,
        ],
    ];

    // bag مخصص للزيارة (VisitRequest::$errorBag = 'visit')
    $visitErrorBag = $errors->getBag('visit');
    $visitHasErrors = $visitErrorBag->any();

    $visitErrorMap = collect($visitErrorBag->toArray())->map(fn($messages) => $messages[0] ?? '')->all();

    // المريض المختار (بحث) بعد فشل الفورم
    $initialPatient =
        $visitHasErrors && !$isPatientLocked && $initialPatientMode === 'registered' && $searchPatient
            ? [
                'id' => $searchPatient->id,
                'name' => $searchPatient->name,
                'phone' => $searchPatient->phone,
            ]
            : null;
?>

<?php if (! $__env->hasRenderedOnce('1f581dd7-1ce9-403d-8c98-6525df7292ff')): $__env->markAsRenderedOnce('1f581dd7-1ce9-403d-8c98-6525df7292ff'); ?>
    <?php if (! $__env->hasRenderedOnce('modal-variants-css')): $__env->markAsRenderedOnce('modal-variants-css'); ?>
        <?php $__env->startPush('extra_style'); ?>
            <link rel="stylesheet" href="<?php echo e(asset('css/clinic/modal_variants.css')); ?>">
        <?php $__env->stopPush(); ?>
    <?php endif; ?>

    <style>
        /* ===== Visit modal ===== */

        .modal-panel.bq-visit-modal {
            width: min(96vw, 1100px);
            max-width: 96vw;
            max-height: 92vh;
            overflow-y: auto;
        }

        .bq-visit-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1.25rem;
            margin-top: 1.25rem;
        }

        @media (min-width: 768px) {
            .bq-visit-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .bq-visit-col-full {
                grid-column: 1 / -1;
            }
        }

        .bq-visit-modal .bq-visit-textarea {
            display: block;
            width: 100%;
            min-height: 7rem;
            max-height: 55vh;
            line-height: 1.75;
            resize: vertical;
            overflow-y: auto;
        }

        .bq-visit-modal .bq-modal-footer {
            position: sticky;
            bottom: 0;
            z-index: 2;
            background: inherit;
        }

        .bq-visit-pmode {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            margin-bottom: 1rem;
        }
    </style>
<?php endif; ?>

<div x-data="{
    open: <?php echo \Illuminate\Support\Js::from($visitHasErrors)->toHtml() ?>,
    isEdit: <?php echo \Illuminate\Support\Js::from($startEdit)->toHtml() ?>,
    visitId: <?php echo \Illuminate\Support\Js::from($initialVisitId)->toHtml() ?>,

    action: <?php echo \Illuminate\Support\Js::from($initialAction)->toHtml() ?>,
    createAction: <?php echo \Illuminate\Support\Js::from($action)->toHtml() ?>,
    updateTemplate: <?php echo \Illuminate\Support\Js::from($updateTemplate)->toHtml() ?>,

    createTitle: <?php echo \Illuminate\Support\Js::from($createTitle)->toHtml() ?>,
    editTitle: <?php echo \Illuminate\Support\Js::from($editTitle)->toHtml() ?>,

    patientLocked: <?php echo \Illuminate\Support\Js::from($isPatientLocked)->toHtml() ?>,

    pMode: <?php echo \Illuminate\Support\Js::from($initialPatientMode)->toHtml() ?>,

    showErrors: <?php echo \Illuminate\Support\Js::from($visitHasErrors)->toHtml() ?>,
    errors: <?php echo \Illuminate\Support\Js::from($visitErrorMap)->toHtml() ?>,

    initialPatient: <?php echo \Illuminate\Support\Js::from($initialPatient)->toHtml() ?>,

    f: <?php echo \Illuminate\Support\Js::from($initialFields)->toHtml() ?>,

    err(key) {
        return this.showErrors ?
            (this.errors[key] || '') :
            '';
    },

    blankFields() {
        return {
            complaint: '',
            symptoms: '',
            diagnosis: '',
            required_tests: '',
            required_radiology: '',
            notes: '',
            next_visit_date: '',
            patient_name: '',
            patient_phone: '',
        };
    },

    grow(el) {
        el.style.height = 'auto';
        el.style.height = el.scrollHeight + 2 + 'px';
    },

    growAll() {
        if (!this.$refs.form) return;

        this.$refs.form
            .querySelectorAll('textarea.bq-visit-textarea')
            .forEach((el) => this.grow(el));
    },

    setPatient(p) {
        const box = this.$refs.form ?
            this.$refs.form.querySelector('[data-patient-search]') :
            null;

        if (!box) return;

        const idInput =
            box.querySelector('[data-patient-search-id]');

        const selected =
            box.querySelector('[data-patient-search-selected]');

        const picker =
            box.querySelector('[data-patient-search-picker]');

        const searchInput =
            box.querySelector('[data-patient-search-input]');

        const results =
            box.querySelector('[data-patient-search-results]');

        const nameEl =
            box.querySelector('[data-patient-search-selected-name]');

        const phoneEl =
            box.querySelector('[data-patient-search-selected-phone]');

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
            nameEl.textContent = p ? (p.name || '') : '';
        }

        if (phoneEl) {
            phoneEl.textContent =
                p ?
                (p.phone || 'لا يوجد رقم هاتف') :
                '';
        }

        if (selected) {
            selected.classList.toggle('hidden', !p);
        }

        if (picker) {
            picker.classList.toggle('hidden', !!p);
        }
    },

    switchPatientMode(mode) {
        if (
            this.patientLocked ||
            this.isEdit ||
            mode === this.pMode
        ) {
            return;
        }

        if (mode === 'external') {
            this.setPatient(null);
        }

        this.pMode = mode;
    },

    openCreate() {
        this.isEdit = false;
        this.visitId = '';

        this.action = this.createAction;

        this.f = this.blankFields();

        this.pMode = 'registered';

        this.setPatient(null);

        this.showErrors = false;

        this.open = true;

        this.$nextTick(() => {
            this.growAll();
        });
    },

    openEdit(v) {
        const next = this.blankFields();

        Object.keys(next).forEach((k) => {
            if (
                v[k] !== null &&
                v[k] !== undefined &&
                v[k] !== ''
            ) {
                next[k] = v[k];
            }
        });

        this.isEdit = true;

        this.visitId = v.id;

        this.action =
            this.updateTemplate.replace(
                '__VISIT__',
                v.id
            );

        this.f = next;

        if (v.patient_id) {
            this.pMode = 'registered';

            this.setPatient({
                id: v.patient_id,
                name: v.patient_name,
                phone: v.patient_phone
            });
        } else {
            this.pMode = 'external';

            this.setPatient(null);
        }

        this.showErrors = false;

        this.open = true;

        this.$nextTick(() => {
            this.growAll();
        });
    },
}" x-init="if (<?php echo \Illuminate\Support\Js::from($visitHasErrors)->toHtml() ?>) {
    $nextTick(() => {
        growAll();

        if (initialPatient) {
            setPatient(initialPatient);
        }
    })
}">

    <?php if($showTrigger): ?>
        <button type="button" class="btn btn-default" @click="openCreate()">
            <i data-lucide="stethoscope" class="size-4"></i>
            زيارة جديدة
        </button>
    <?php endif; ?>

    <?php echo e($slot); ?>


    <div x-cloak x-show="open" x-transition.opacity :class="{ 'open': open }" class="modal-overlay"
        @click.self="open = false" @keydown.escape.window="open = false">

        <div x-show="open" x-transition @click.stop class="modal-panel bq-visit-modal"
            :class="isEdit ? 'modal-panel--edit' : 'modal-panel--create'">

            
            <div class="modal-head">

                <span class="modal-head__icon">
                    <span x-show="!isEdit"><i data-lucide="stethoscope" class="size-5"></i></span>
                    <span x-show="isEdit"><i data-lucide="pencil" class="size-5"></i></span>
                </span>

                <div class="min-w-0 flex-1">

                    <h3 class="modal-head__title" x-text="isEdit ? editTitle : createTitle">
                        <?php echo e($startEdit ? $editTitle : $createTitle); ?>

                    </h3>

                    <p class="modal-head__sub"
                        x-text="isEdit ? 'تعديل بيانات الزيارة المسجلة.' : 'تسجيل بيانات الزيارة الطبية للمريض.'">
                        <?php echo e($startEdit ? 'تعديل بيانات الزيارة المسجلة.' : 'تسجيل بيانات الزيارة الطبية للمريض.'); ?>

                    </p>

                </div>

                <button type="button" class="btn btn-icon" @click="open = false">
                    <i data-lucide="x" class="size-5"></i>
                </button>

            </div>

            
            <form x-ref="form" method="POST" action="<?php echo e($initialAction); ?>" :action="action">

                <?php echo csrf_field(); ?>

                
                <input type="hidden" name="_form" value="visit">

                
                <input type="hidden" name="_method" value="PUT" :disabled="!isEdit"
                    <?php if(!$startEdit): ?> disabled <?php endif; ?>>

                
                <input type="hidden" name="_visit_editing" :value="visitId" :disabled="!isEdit"
                    value="<?php echo e($initialVisitId); ?>" <?php if(!$startEdit): ?> disabled <?php endif; ?>>

                
                <?php if(!$isPatientLocked): ?>
                    <input type="hidden" name="_patient_mode" :value="pMode" value="<?php echo e($initialPatientMode); ?>">
                <?php endif; ?>

                
                <?php if($isPatientLocked): ?>
                    <div>

                        <input type="hidden" name="patient_id" value="<?php echo e($selectedPatientId); ?>">

                        <div class="rounded-xl border border-border/60 bg-muted/30 p-4">

                            <div class="flex min-w-0 items-center gap-3">

                                <div
                                    class="grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft font-bold text-primary">
                                    <?php echo e(mb_substr($patient->name, 0, 2)); ?>

                                </div>

                                <div class="min-w-0">

                                    <p class="truncate font-semibold">
                                        <?php echo e($patient->name); ?>

                                    </p>

                                    <p class="mt-1 text-xs text-muted-foreground">
                                        <?php echo e($patient->phone ?: 'لا يوجد رقم هاتف'); ?>

                                    </p>

                                </div>

                            </div>

                        </div>

                        <p class="bq-field-error mt-2" x-show="err('patient_id')">
                            <span x-text="err('patient_id')"></span>
                        </p>

                    </div>
                <?php else: ?>
                    
                    <div class="bq-visit-pmode" x-show="!isEdit">

                        <button type="button" class="btn btn-sm"
                            :class="pMode === 'registered'
                                ?
                                'btn-default' :
                                'btn-outline'"
                            @click="switchPatientMode('registered')">
                            مريض مسجل
                        </button>

                        <button type="button" class="btn btn-sm"
                            :class="pMode === 'external'
                                ?
                                'btn-default' :
                                'btn-outline'"
                            @click="switchPatientMode('external')">
                            شخص غير مسجل
                        </button>

                    </div>

                    
                    <div x-show="pMode === 'registered'" data-patient-search
                        data-patient-search-url="<?php echo e(route('clinic.bookings.patients.search')); ?>">

                        <input type="hidden" name="patient_id" value="<?php echo e($selectedPatientId); ?>"
                            data-patient-search-id>

                        <div data-patient-search-selected
                            class="hidden rounded-xl border border-border/60 bg-muted/30 p-4">

                            <div class="flex items-center justify-between gap-3">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div
                                        class="grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft font-bold text-primary">
                                        <i data-lucide="user-round" class="size-5"></i>
                                    </div>

                                    <div class="min-w-0">

                                        <p data-patient-search-selected-name class="truncate font-semibold">
                                            <?php echo e($searchPatient?->name); ?>

                                        </p>

                                        <p data-patient-search-selected-phone
                                            class="mt-1 text-xs text-muted-foreground">
                                            <?php echo e($searchPatient ? ($searchPatient->phone ?: 'لا يوجد رقم هاتف') : ''); ?>

                                        </p>

                                    </div>

                                </div>

                                
                                <button type="button" data-patient-search-change x-show="!isEdit"
                                    class="btn btn-outline btn-sm shrink-0">
                                    تغيير
                                </button>

                            </div>

                        </div>

                        <div data-patient-search-picker>

                            <label class="field-label">
                                البحث عن المريض
                            </label>

                            <div class="relative">

                                <i data-lucide="search"
                                    class="pointer-events-none absolute start-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground"></i>

                                <input type="text" class="field-input ps-9"
                                    placeholder="ابحث باسم المريض أو رقم الهاتف" autocomplete="off"
                                    data-patient-search-input>

                            </div>

                            <div data-patient-search-results
                                class="mt-2 hidden max-h-60 overflow-y-auto rounded-xl border border-border bg-background shadow-lg">
                            </div>

                        </div>

                        <p class="bq-field-error mt-2" x-show="pMode === 'registered' && err('patient_id')">
                            <span x-text="err('patient_id')"></span>
                        </p>

                    </div>

                    
                    <div x-show="pMode === 'external'" class="bq-visit-grid" style="margin-top:0">

                        <div>

                            <label class="field-label">
                                اسم المريض
                            </label>

                            <input type="text" name="patient_name" class="field-input" maxlength="150"
                                placeholder="اكتب اسم المريض" x-model="f.patient_name" :disabled="pMode !== 'external'"
                                value="<?php echo e($initialFields['patient_name']); ?>">

                            <p class="bq-field-error mt-2" x-show="pMode === 'external' && err('patient_name')">
                                <span x-text="err('patient_name')"></span>
                            </p>

                        </div>

                        <div>

                            <label class="field-label">
                                رقم الهاتف (اختياري)
                            </label>

                            <input type="text" name="patient_phone" class="field-input" maxlength="30"
                                placeholder="01xxxxxxxxx" x-model="f.patient_phone" :disabled="pMode !== 'external'"
                                value="<?php echo e($initialFields['patient_phone']); ?>">

                            <p class="bq-field-error mt-2" x-show="pMode === 'external' && err('patient_phone')">
                                <span x-text="err('patient_phone')"></span>
                            </p>

                        </div>

                    </div>
                <?php endif; ?>

                
                <div class="bq-visit-grid">

                    
                    <div class="bq-visit-col" style="grid-column: 1 / -1;">

                        <label class="field-label">
                            موعد المتابعة / الإعادة
                        </label>

                        <input type="date" name="next_visit_date" class="field-input" x-model="f.next_visit_date"
                            value="<?php echo e($initialFields['next_visit_date']); ?>">

                        <p class="bq-field-error mt-2" x-show="err('next_visit_date')">
                            <span x-text="err('next_visit_date')"></span>
                        </p>

                    </div>

                    
                    <?php $__currentLoopData = $textFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bq-visit-col <?php echo e($field['full'] ? 'bq-visit-col-full' : ''); ?>">

                            <label class="field-label">
                                <?php echo e($field['label']); ?>

                            </label>

                            <textarea name="<?php echo e($field['name']); ?>" rows="3" class="field-input bq-visit-textarea mt-2"
                                placeholder="<?php echo e($field['placeholder']); ?>" x-model="f.<?php echo e($field['name']); ?>" @input="grow($el)"><?php echo e($initialFields[$field['name']]); ?></textarea>

                            <p class="bq-field-error mt-2" x-show="err('<?php echo e($field['name']); ?>')">
                                <span x-text="err('<?php echo e($field['name']); ?>')"></span>
                            </p>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>

                
                <div class="bq-modal-footer">

                    <button type="button" class="dropdown-item danger" @click="open = false">
                        إلغاء
                    </button>

                    <button type="submit" class="btn btn-default btn-submit">
                        <i data-lucide="save" class="size-4"></i>

                        <span
                            x-text="
                                isEdit
                                    ? 'حفظ التعديلات'
                                    : 'حفظ الزيارة'
                            ">
                            <?php echo e($startEdit ? 'حفظ التعديلات' : 'حفظ الزيارة'); ?>

                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<?php if(!$isPatientLocked): ?>
    <?php if (! $__env->hasRenderedOnce('bq-patient-search-js')): $__env->markAsRenderedOnce('bq-patient-search-js'); ?>
        <?php $__env->startPush('extra_java'); ?>
            <script src="<?php echo e(asset('js/clinic/patient_search.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
<?php endif; ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/clinic/visit-form.blade.php ENDPATH**/ ?>
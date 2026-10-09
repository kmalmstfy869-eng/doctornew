<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'patient' => null,
    'showTrigger' => true,
    'serviceNames' => [],
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
    'showTrigger' => true,
    'serviceNames' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>


<?php if (! $__env->hasRenderedOnce('modal-variants-css')): $__env->markAsRenderedOnce('modal-variants-css'); ?>
    <?php $__env->startPush('extra_style'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/clinic/modal_variants.css')); ?>">
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php
    $uid = 'inv-' . \Illuminate\Support\Str::random(6);

    $isLocked = $patient !== null;

    $bag = $errors->getBag('invoice');
    $hasErrors = $bag->any();

    // الأخطاء تخص المودال بتاع الصفحة دي بس لو الـ patient_id بتاعها بيطابق القفل الحالي
    // (يمنع ظهور خطأ فاتورة مريض في مودال فاتورة عيادة أو العكس)
    $oldPartyMatches = $isLocked
        ? old('patient_id') == $patient->id
        : true;

    $showErrors = $hasErrors && $oldPartyMatches;

    $errorMap = $showErrors
        ? collect($bag->toArray())->map(fn ($m) => $m[0] ?? '')->all()
        : [];

    $initialParty = $showErrors ? old('party', 'patient') : 'patient';
    $initialType = $showErrors ? old('type', 'income') : 'income';

    $initialFields = [
        'title' => $showErrors ? old('title', '') : '',
        'amount' => $showErrors ? old('amount', '') : '',
        'notes' => $showErrors ? old('notes', '') : '',
    ];

    $selectedPatientId = $isLocked
        ? $patient->id
        : ($showErrors ? old('patient_id') : null);

    $searchPatient = (! $isLocked && $selectedPatientId)
        ? auth()->user()?->doctor?->patients()->find($selectedPatientId)
        : null;
?>

<div
    x-data="{
        open: <?php echo \Illuminate\Support\Js::from($showErrors)->toHtml() ?>,
        showErrors: <?php echo \Illuminate\Support\Js::from($showErrors)->toHtml() ?>,
        errors: <?php echo \Illuminate\Support\Js::from($errorMap)->toHtml() ?>,

        locked: <?php echo \Illuminate\Support\Js::from($isLocked)->toHtml() ?>,
        party: <?php echo \Illuminate\Support\Js::from($initialParty)->toHtml() ?>,
        type: <?php echo \Illuminate\Support\Js::from($initialType)->toHtml() ?>,
        f: <?php echo \Illuminate\Support\Js::from($initialFields)->toHtml() ?>,

        err(key) {
            return this.showErrors ? (this.errors[key] || '') : '';
        },

        blank() {
            return {
                title: '',
                amount: '',
                notes: '',
            };
        },

        resetPatient() {
            const box = this.$refs.form.querySelector('[data-patient-search]');
            if (!box) return;

            const id = box.querySelector('[data-patient-search-id]');
            const selected = box.querySelector('[data-patient-search-selected]');
            const picker = box.querySelector('[data-patient-search-picker]');
            const input = box.querySelector('[data-patient-search-input]');
            const results = box.querySelector('[data-patient-search-results]');

            if (id) id.value = '';
            if (input) input.value = '';

            if (results) {
                results.innerHTML = '';
                results.classList.add('hidden');
            }

            if (selected) selected.classList.add('hidden');
            if (picker) picker.classList.remove('hidden');
        },

        openCreate() {
            this.party = 'patient';
            this.type = 'income';
            this.f = this.blank();
            this.showErrors = false;

            if (!this.locked) {
                this.resetPatient();
            }

            this.open = true;
        },
    }"
>
    <?php if($showTrigger): ?>
        <button
            type="button"
            class="btn btn-default"
            @click="openCreate()"
        >
            <i
                data-lucide="plus"
                class="size-4"
            ></i>

            فاتورة جديدة
        </button>
    <?php endif; ?>

    <div
        x-cloak
        x-show="open"
        x-transition.opacity
        :class="{ 'open': open }"
        class="modal-overlay"
        @click.self="open = false"
        @keydown.escape.window="open = false"
    >
        <div
            x-show="open"
            x-transition
            @click.stop
            class="modal-panel modal-lg modal-panel--create"
        >

            <div class="modal-head">

                <span class="modal-head__icon">
                    <i
                        data-lucide="receipt"
                        class="size-5"
                    ></i>
                </span>

                <div class="min-w-0 flex-1">

                    <h3 class="modal-head__title">
                        فاتورة جديدة
                    </h3>

                    <p class="modal-head__sub">

                        <?php if($isLocked): ?>

                            تسجيل دفعة أو مبلغ إضافي لهذا المريض.

                        <?php else: ?>

                            سجّل مبلغ مدفوع من مريض، أو إيراد / مصروف للعيادة.

                        <?php endif; ?>

                    </p>

                </div>

                <button
                    type="button"
                    class="btn btn-icon"
                    @click="open = false"
                >
                    <i
                        data-lucide="x"
                        class="size-5"
                    ></i>
                </button>

            </div>

            <form
                x-ref="form"
                method="POST"
                action="<?php echo e(route('clinic.payments.store')); ?>"
            >
                <?php echo csrf_field(); ?>

                <input
                    type="hidden"
                    name="party"
                    :value="party"
                >

                <input
                    type="hidden"
                    name="type"
                    :value="party === 'patient' ? 'income' : type"
                >

                <?php if($isLocked): ?>

                    <input
                        type="hidden"
                        name="patient_id"
                        value="<?php echo e($patient->id); ?>"
                    >

                    <div class="mt-4 rounded-xl border border-border/60 bg-muted/30 p-4">

                        <div class="flex min-w-0 items-center gap-3">

                            <div
                                class="grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft font-bold text-primary"
                            >
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

                <?php else: ?>

                    

                    <div class="mb-4 mt-4 flex flex-wrap gap-2">

                        <button
                            type="button"
                            class="btn btn-sm"
                            :class="party === 'patient' ? 'btn-default' : 'btn-outline'"
                            @click="party = 'patient'"
                        >
                            فاتورة مريض
                        </button>

                        <button
                            type="button"
                            class="btn btn-sm"
                            :class="party === 'clinic' ? 'btn-default' : 'btn-outline'"
                            @click="party = 'clinic'"
                        >
                            حركة عيادة
                        </button>

                    </div>

                    

                    <div
                        class="mb-4 flex flex-wrap gap-2"
                        x-show="party === 'clinic'"
                    >

                        <button
                            type="button"
                            class="btn btn-sm"
                            :class="type === 'income' ? 'btn-default' : 'btn-outline'"
                            @click="type = 'income'"
                        >
                            إيراد (دخل مبلغ)
                        </button>

                        <button
                            type="button"
                            class="btn btn-sm"
                            :class="type === 'expense' ? 'btn-default' : 'btn-outline'"
                            @click="type = 'expense'"
                        >
                            مصروف (خرج مبلغ)
                        </button>

                    </div>

                    <p
                        class="bq-field-error mb-2"
                        x-show="err('type')"
                    >
                        <span x-text="err('type')"></span>
                    </p>

                    <div
                        x-show="party === 'patient'"
                        data-patient-search
                        data-patient-search-url="<?php echo e(route('clinic.bookings.patients.search')); ?>"
                    >

                        <input
                            type="hidden"
                            name="patient_id"
                            value="<?php echo e($selectedPatientId); ?>"
                            :disabled="party !== 'patient'"
                            data-patient-search-id
                        >

                        <div
                            data-patient-search-selected
                            class="<?php echo e($searchPatient ? '' : 'hidden'); ?> rounded-xl border border-border/60 bg-muted/30 p-4"
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
                                            <?php echo e($searchPatient?->name); ?>

                                        </p>

                                        <p
                                            data-patient-search-selected-phone
                                            class="mt-1 text-xs text-muted-foreground"
                                        >
                                            <?php echo e($searchPatient ? ($searchPatient->phone ?: 'لا يوجد رقم هاتف') : ''); ?>

                                        </p>

                                    </div>

                                </div>

                                <button
                                    type="button"
                                    data-patient-search-change
                                    class="btn btn-outline btn-sm shrink-0"
                                >
                                    تغيير
                                </button>

                            </div>

                        </div>

                        <div
                            data-patient-search-picker
                            class="<?php echo e($searchPatient ? 'hidden' : ''); ?>"
                        >

                            <label class="field-label">
                                المريض *
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
                            x-show="party === 'patient' && err('patient_id')"
                        >
                            <span x-text="err('patient_id')"></span>
                        </p>

                    </div>

                <?php endif; ?>

                <div class="mt-4 grid gap-4 sm:grid-cols-2">

                    

                    <div class="sm:col-span-2">

                        <label class="field-label">

                            <?php if($isLocked): ?>

                                البيان *

                            <?php else: ?>

                                <span
                                    x-text="party === 'patient'
                                        ? 'الخدمة / البيان *'
                                        : 'البيان *'"
                                ></span>

                            <?php endif; ?>

                        </label>

                        <input
                            type="text"
                            name="title"
                            class="field-input"
                            maxlength="150"
                            <?php if(! empty($serviceNames)): ?>
                                list="<?php echo e($uid); ?>-titles"
                            <?php endif; ?>
                            <?php if($isLocked): ?>
                                placeholder="مثال: كشف عام"
                            <?php else: ?>
                                :placeholder="party === 'patient'
                                    ? 'مثال: كشف عام'
                                    : (type === 'expense'
                                        ? 'مثال: إيجار / كهرباء / مستلزمات'
                                        : 'مثال: إيراد آخر')"
                            <?php endif; ?>
                            x-model="f.title"
                        >

                        <p
                            class="bq-field-error mt-2"
                            x-show="err('title')"
                        >
                            <span x-text="err('title')"></span>
                        </p>

                    </div>


                    

                    <div class="sm:col-span-2">

                        <label class="field-label">
                            المبلغ (ج.م) *
                        </label>

                        <input
                            type="number"
                            name="amount"
                            dir="ltr"
                            step="0.01"
                            min="0.01"
                            class="field-input"
                            x-model="f.amount"
                        >

                        <p
                            class="bq-field-error mt-2"
                            x-show="err('amount')"
                        >
                            <span x-text="err('amount')"></span>
                        </p>

                    </div>


                    

                    <div class="sm:col-span-2">

                        <label class="field-label">
                            ملاحظات
                        </label>

                        <textarea
                            name="notes"
                            rows="2"
                            class="field-textarea"
                            x-model="f.notes"
                        ></textarea>

                        <p
                            class="bq-field-error mt-2"
                            x-show="err('notes')"
                        >
                            <span x-text="err('notes')"></span>
                        </p>

                    </div>

                </div>

                <div class="bq-modal-footer">

                    <button
                        type="button"
                        class="dropdown-item danger"
                        @click="open = false"
                    >
                        إلغاء
                    </button>

                    <button
                        type="submit"
                        class="btn btn-default btn-submit"
                    >
                        <i
                            data-lucide="save"
                            class="size-4"
                        ></i>

                        حفظ
                    </button>

                </div>

            </form>

        </div>

    </div>

    <?php if(! empty($serviceNames)): ?>

        <datalist id="<?php echo e($uid); ?>-titles">

            <?php $__currentLoopData = $serviceNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <option value="<?php echo e($name); ?>"></option>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </datalist>

    <?php endif; ?>

</div><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/clinic/invoice-form.blade.php ENDPATH**/ ?>
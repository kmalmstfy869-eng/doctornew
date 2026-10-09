<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['patient' => null]));

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

foreach (array_filter((['patient' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // لو $patient موجود (صفحة المريض) بيكون محدد ومقفول. غير كده (صفحة كل الملفات) بنعرض بحث المرضى المسجلين فقط.
    $locked = $patient !== null;
    $maxMb = (int) config('clinic.patient_files_max_file_mb', 25);

    $bag = $errors->getBag('patient_file');
    $hasErrors = $bag->any();

    $action = $locked
        ? route('clinic.patients.files.store', $patient)
        : route('clinic.files.store');

    // بعد فشل الرفع من صفحة كل الملفات نرجّع المريض المختار.
    $oldPatient = null;
    if (! $locked && $hasErrors && old('patient_id')) {
        $p = auth()->user()?->clinicDoctor()?->patients()->find(old('patient_id'));
        $oldPatient = $p ? ['id' => $p->id, 'name' => $p->name, 'phone' => $p->phone] : null;
    }
?>

<?php if (! $__env->hasRenderedOnce('modal-variants-css')): $__env->markAsRenderedOnce('modal-variants-css'); ?>
    <?php $__env->startPush('extra_style'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/clinic/modal_variants.css')); ?>">
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<div x-data="{
        open: <?php echo \Illuminate\Support\Js::from($hasErrors)->toHtml() ?>,
        busy: false,
        locked: <?php echo \Illuminate\Support\Js::from($locked)->toHtml() ?>,
        fileName: '',
        clientError: '',
        fileErr: <?php echo \Illuminate\Support\Js::from($bag->first('file') ?? '')->toHtml() ?>,
        patientErr: <?php echo \Illuminate\Support\Js::from($bag->first('patient_id') ?? '')->toHtml() ?>,
        maxMb: <?php echo \Illuminate\Support\Js::from($maxMb)->toHtml() ?>,
        maxBytes: <?php echo \Illuminate\Support\Js::from($maxMb * 1024 * 1024)->toHtml() ?>,
        allowed: ['application/pdf', 'image/jpeg', 'image/png', 'image/webp'],
        initialPatient: <?php echo \Illuminate\Support\Js::from($oldPatient)->toHtml() ?>,

        init() {
            if (this.initialPatient) {
                this.$nextTick(() => this.setPatient(this.initialPatient));
            }
        },

        // فحص سريع في المتصفح للتسهيل بس. الفحص الحقيقي بيتم في السيرفر.
        pick(e) {
            const f = e.target.files[0];
            this.clientError = '';
            this.fileErr = '';
            this.fileName = '';
            if (!f) return;
            if (f.size > this.maxBytes) {
                this.clientError = 'حجم الملف أكبر من ' + this.maxMb + ' ميجا.';
                e.target.value = '';
                return;
            }
            if (!this.allowed.includes(f.type)) {
                this.clientError = 'نوع الملف غير مسموح. المسموح: PDF, JPG, PNG, WEBP.';
                e.target.value = '';
                return;
            }
            this.fileName = f.name;
        },

        openModal() {
            this.busy = false;
            this.fileName = '';
            this.clientError = '';
            this.fileErr = '';
            this.patientErr = '';
            this.$refs.form.reset();
            this.setPatient(null);
            this.open = true;
        },

        submit(e) {
            this.patientErr = '';
            if (!this.locked) {
                const id = this.$refs.form.querySelector('[data-patient-search-id]');
                if (!id || !id.value) {
                    e.preventDefault();
                    this.patientErr = 'اختر المريض أولًا.';
                    return;
                }
            }
            if (!this.fileName) {
                e.preventDefault();
                this.clientError = 'اختر ملفًا أولًا.';
                return;
            }
            this.busy = true;
        },

        // نفس فكرة rxSetPatient في فورم الروشتة: بنظبط عناصر البحث الجاهزة (patient_search.js).
        setPatient(p) {
            const box = this.$refs.form.querySelector('[data-patient-search]');
            if (!box) return;
            const q = (s) => box.querySelector(s);
            if (q('[data-patient-search-id]')) q('[data-patient-search-id]').value = p ? p.id : '';
            if (q('[data-patient-search-input]')) q('[data-patient-search-input]').value = '';
            const results = q('[data-patient-search-results]');
            if (results) { results.innerHTML = ''; results.classList.add('hidden'); }
            if (q('[data-patient-search-selected-name]')) q('[data-patient-search-selected-name]').textContent = p ? (p.name || '') : '';
            if (q('[data-patient-search-selected-phone]')) q('[data-patient-search-selected-phone]').textContent = p ? (p.phone || 'لا يوجد رقم هاتف') : '';
            if (q('[data-patient-search-selected]')) q('[data-patient-search-selected]').classList.toggle('hidden', !p);
            if (q('[data-patient-search-picker]')) q('[data-patient-search-picker]').classList.toggle('hidden', !!p);
        },
    }"
    @pf-upload-open.window="openModal()">

    <div x-cloak x-show="open" x-transition.opacity :class="{ 'open': open }" class="modal-overlay"
        @click.self="open = false" @keydown.escape.window="open = false">

        <div x-show="open" x-transition @click.stop class="modal-panel pf-upload-modal modal-panel--create">

            <div class="modal-head">
                <span class="modal-head__icon"><i data-lucide="upload" class="size-5"></i></span>

                <div class="min-w-0 flex-1">
                    <h3 class="modal-head__title">رفع ملف جديد</h3>
                    <p class="modal-head__sub">PDF أو صورة (JPG, PNG, WEBP) حتى <?php echo e($maxMb); ?> ميجا.</p>
                </div>

                <button type="button" class="btn btn-icon" @click="open = false" aria-label="إغلاق">
                    <i data-lucide="x" class="size-5"></i>
                </button>
            </div>

            <form x-ref="form" method="POST" action="<?php echo e($action); ?>" enctype="multipart/form-data"
                @submit="submit($event)">
                <?php echo csrf_field(); ?>

                <?php if($locked): ?>
                    
                    <div class="rounded-xl border border-border/60 bg-muted/30 p-4">
                        <div class="flex min-w-0 items-center gap-3">
                            <div
                                class="grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft font-bold text-primary">
                                <?php echo e(mb_substr($patient->name, 0, 2)); ?>

                            </div>
                            <div class="min-w-0">
                                <p class="truncate font-semibold"><?php echo e($patient->name); ?></p>
                                <p class="mt-1 text-xs text-muted-foreground">
                                    <?php echo e($patient->phone ?: 'لا يوجد رقم هاتف'); ?></p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    
                    <div data-patient-search data-patient-search-url="<?php echo e(route('clinic.bookings.patients.search')); ?>">

                        <input type="hidden" name="patient_id" value="" data-patient-search-id>

                        <div data-patient-search-selected class="hidden rounded-xl border border-border/60 bg-muted/30 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div
                                        class="grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft font-bold text-primary">
                                        <i data-lucide="user-round" class="size-5"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p data-patient-search-selected-name class="truncate font-semibold"></p>
                                        <p data-patient-search-selected-phone class="mt-1 text-xs text-muted-foreground">
                                        </p>
                                    </div>
                                </div>
                                <button type="button" data-patient-search-change
                                    class="btn btn-outline btn-sm shrink-0">تغيير</button>
                            </div>
                        </div>

                        <div data-patient-search-picker>
                            <label class="field-label">البحث عن المريض</label>
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

                        <p class="bq-field-error mt-2" x-show="patientErr"><span x-text="patientErr"></span></p>
                    </div>
                <?php endif; ?>

                
                <div class="mt-4">
                    <label class="field-label">الملف</label>

                    <label class="pf-drop">
                        <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.webp,application/pdf,image/jpeg,image/png,image/webp"
                            @change="pick($event)">
                        <i data-lucide="paperclip" class="size-5"></i>
                        <span class="pf-drop__text" x-text="fileName || 'اضغط لاختيار ملف'"></span>
                        <span class="pf-drop__hint">PDF, JPG, PNG, WEBP — حتى <?php echo e($maxMb); ?> ميجا</span>
                    </label>

                    <p class="bq-field-error mt-2" x-show="clientError || fileErr">
                        <span x-text="clientError || fileErr"></span>
                    </p>
                </div>

                <div class="bq-modal-footer">
                    <button type="button" class="dropdown-item danger" @click="open = false">إلغاء</button>

                    <button type="submit" class="btn btn-default btn-submit" :disabled="busy">
                        <i data-lucide="upload" class="size-4"></i>
                        <span x-text="busy ? 'جاري الرفع...' : 'رفع الملف'">رفع الملف</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php if(! $locked): ?>
    <?php if (! $__env->hasRenderedOnce('bq-patient-search-js')): $__env->markAsRenderedOnce('bq-patient-search-js'); ?>
        <?php $__env->startPush('extra_java'); ?>
            <script src="<?php echo e(asset('js/clinic/patient_search.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/clinic/file-upload-modal.blade.php ENDPATH**/ ?>
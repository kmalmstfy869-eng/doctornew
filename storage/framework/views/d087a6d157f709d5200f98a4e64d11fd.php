<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'booking' => null,
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
    'booking' => null,
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


<div
    id="edit-payment-modal"
    class="modal-overlay <?php if($errors->payment->any()): ?> open <?php endif; ?>"
    data-edit-payment-modal>

    <div class="modal-panel max-w-lg modal-panel--edit">

        
        <div class="modal-head">

            <span class="modal-head__icon">
                <i
                    data-lucide="wallet"
                    class="h-5 w-5">
                </i>
            </span>

            <div class="min-w-0 flex-1">

                <h3 class="modal-head__title">
                    تعديل الدفع
                </h3>

                <p
                    id="edit-payment-patient"
                    class="modal-head__sub truncate">
                </p>

            </div>

            <button
                type="button"
                class="btn btn-icon shrink-0"
                data-modal-close
                aria-label="إغلاق">

                <i
                    data-lucide="x"
                    class="h-5 w-5">
                </i>

            </button>

        </div>


        
        <form
            method="POST"
            id="edit-payment-form"
            data-edit-payment-form
            action="<?php echo e($errors->payment->any() && old('_payment_booking_id') ? route('clinic.bookings.payment', old('_payment_booking_id')) : ''); ?>">

            <?php echo csrf_field(); ?>

            <?php echo method_field('PATCH'); ?>

            <input
                type="hidden"
                name="_payment_booking_id"
                value="<?php echo e(old('_payment_booking_id')); ?>">


            
            <div>

                <label
                    for="edit-payment-price"
                    class="field-label">

                    السعر الإجمالي

                </label>

                <input
                    name="price"
                    id="edit-payment-price"
                    type="number"
                    min="0"
                    step="0.01"
                    inputmode="decimal"
                    class="field-input mt-2 <?php $__errorArgs = ['price', 'payment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e(old('price')); ?>"
                    required>

                <?php $__errorArgs = ['price', 'payment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                    <p class="bq-field-error">

                        <i
                            data-lucide="circle-alert"
                            class="h-4 w-4 shrink-0">
                        </i>

                        <span>
                            <?php echo e($message); ?>

                        </span>

                    </p>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            </div>


            
            <div class="mt-4">

                <label
                    for="edit-payment-paid"
                    class="field-label">

                    إجمالي المدفوع حتى الآن

                </label>

                <input
                    name="paid"
                    id="edit-payment-paid"
                    type="number"
                    min="0"
                    step="0.01"
                    inputmode="decimal"
                    class="field-input mt-2 <?php $__errorArgs = ['paid', 'payment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e(old('paid')); ?>"
                    required>

                <?php $__errorArgs = ['paid', 'payment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                    <p class="bq-field-error">

                        <i
                            data-lucide="circle-alert"
                            class="h-4 w-4 shrink-0">
                        </i>

                        <span>
                            <?php echo e($message); ?>

                        </span>

                    </p>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            </div>


            
            <p class="mt-3 text-xs leading-5 text-muted-foreground">

                المبلغ المدفوع هو إجمالي ما دفعه المريض حتى الآن،
                وليس قيمة الدفعة الجديدة فقط.

            </p>


            
            <div class="bq-pay-row mt-5">

                
                <div>

                    <span class="text-sm text-muted-foreground">
                        إجمالي السعر
                    </span>

                    <strong
                        id="edit-payment-total-preview"
                        class="text-foreground">

                        0 ج.م

                    </strong>

                </div>


                
                <div>

                    <span class="text-sm text-muted-foreground">
                        المدفوع
                    </span>

                    <strong
                        id="edit-payment-paid-preview"
                        class="text-success">

                        0 ج.م

                    </strong>

                </div>


                
                <div>

                    <span class="text-sm text-muted-foreground">
                        المتبقي
                    </span>

                    <strong
                        id="edit-payment-remaining-preview"
                        class="text-warning">

                        0 ج.م

                    </strong>

                </div>

            </div>


            
            <div class="bq-modal-footer">

                <button
                    type="button"
                    class="btn btn-ghost"
                    data-modal-close>

                    إلغاء

                </button>

                <button
                    type="submit"
                    class="btn btn-primary btn-submit">

                    <i
                        data-lucide="save"
                        class="h-4 w-4">
                    </i>

                    <span>
                        حفظ التعديل

                    </span>

                </button>

            </div>

        </form>

    </div>

</div><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/clinic/edit-payment-modal.blade.php ENDPATH**/ ?>
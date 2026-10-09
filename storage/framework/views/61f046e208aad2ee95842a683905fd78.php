<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['stats']));

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

foreach (array_filter((['stats']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // الإعلان بيظهر بس لما يتبقى جيجا واحدة أو أقل، وبيتحول لأحمر لما المساحة تخلص.
    $show = $stats['remaining_bytes'] <= 1024 ** 3;
    $isFull = $stats['remaining_bytes'] <= 0;

    $extraGb = (int) config('clinic.extra_storage_gb', 25);
    $extraPrice = (int) config('clinic.extra_storage_price', 200);

    // رسالة الواتساب الجاهزة، فيها مساحة الدكتور الحالية عشان الدعم يرد بسرعة.
    $waText = "مرحبًا، أرغب في زيادة مساحة ملفات المرضى (+{$extraGb} GB بسعر {$extraPrice} ج.م شهريًا).\n"
        . "المساحة الحالية: {$stats['limit_label']}\n"
        . "المستخدم: {$stats['used_label']}\n"
        . "المتبقي: {$stats['remaining_label']}";
?>

<?php if($show): ?>
    <aside class="pf-upsell <?php echo e($isFull ? 'pf-upsell--full' : ''); ?>" role="alert">

        <div class="pf-upsell__main">

            <span class="pf-upsell__icon">
                <i data-lucide="<?php echo e($isFull ? 'alert-octagon' : 'alert-triangle'); ?>" class="size-5"></i>
            </span>

            <div class="min-w-0">

                <h3 class="pf-upsell__title">
                    <?php echo e($isFull ? 'امتلأت مساحة ملفات المرضى' : 'مساحة ملفات المرضى على وشك الانتهاء'); ?>

                </h3>

                <p class="pf-upsell__text">
                    <?php if($isFull): ?>
                        لن تتمكن من رفع ملفات جديدة حتى تزيد المساحة أو تحذف ملفات قديمة.
                    <?php else: ?>
                        المتبقي لك
                        <b dir="ltr"><?php echo e($stats['remaining_label']); ?></b>
                        فقط. زوّد مساحتك الآن حتى لا يتوقف رفع الملفات.
                    <?php endif; ?>
                </p>

                <div class="pf-upsell__chips">
                    <span class="pf-upsell__chip">كل <?php echo e($extraGb); ?> جيجا إضافية</span>
                    <span class="pf-upsell__chip"><?php echo e($extraPrice); ?> ج.م شهريًا</span>
                    <span class="pf-upsell__chip">1000 ج.م سنويا</span>
                </div>

            </div>

        </div>

        <a href="<?php echo e(\App\Support\Whatsapp::link($waText)); ?>" target="_blank" rel="noopener noreferrer"
            class="pf-upsell__btn">
            <i data-lucide="message-circle" class="size-5"></i>
            <span>اضغط لزيادة المساحة</span>
        </a>

    </aside>
<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/clinic/storage-upsell.blade.php ENDPATH**/ ?>
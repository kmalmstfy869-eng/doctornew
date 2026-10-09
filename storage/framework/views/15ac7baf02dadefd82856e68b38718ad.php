<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['stats', 'compact' => false]));

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

foreach (array_filter((['stats', 'compact' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $level = $stats['percent'] >= 95 ? 'text-destructive' : ($stats['percent'] >= 80 ? 'text-warning' : 'text-primary');
?>

<section class="clinic-surface-card pf-storage <?php echo e($compact ? 'pf-storage--compact' : ''); ?>" aria-label="مساحة ملفات المرضى">

    <div class="pf-storage__head">
        <div class="pf-storage__title">
            <span class="pf-storage__icon bg-primary-soft text-primary">
                <i data-lucide="hard-drive" class="size-5"></i>
            </span>
            <div class="min-w-0">
                <h2>مساحة ملفات المرضى</h2>
                <p class="pf-storage__sub text-muted-foreground tabular-nums" dir="ltr">
                    <?php echo e($stats['used_label']); ?> / <?php echo e($stats['limit_label']); ?>

                </p>
            </div>
        </div>

        <?php if(trim((string) $slot) !== ''): ?>
            <div class="pf-storage__action"><?php echo e($slot); ?></div>
        <?php endif; ?>
    </div>

    <div class="pf-storage__meter">
        <div class="pf-storage__bar <?php echo e($level); ?>" role="progressbar" aria-valuemin="0" aria-valuemax="100"
            aria-valuenow="<?php echo e($stats['percent']); ?>">
            <span style="width: <?php echo e(max($stats['percent'], $stats['used_bytes'] > 0 ? 1 : 0)); ?>%"></span>
        </div>
        <span class="pf-storage__percent tabular-nums <?php echo e($level); ?>"><?php echo e($stats['percent']); ?>%</span>
    </div>

    <dl class="pf-storage__stats">
        <div>
            <dt class="text-muted-foreground">المستخدم</dt>
            <dd class="tabular-nums" dir="ltr"><?php echo e($stats['used_label']); ?></dd>
        </div>
        <div>
            <dt class="text-muted-foreground">المتبقي</dt>
            <dd class="tabular-nums" dir="ltr"><?php echo e($stats['remaining_label']); ?></dd>
        </div>
        <div>
            <dt class="text-muted-foreground">الإجمالي</dt>
            <dd class="tabular-nums" dir="ltr"><?php echo e($stats['limit_label']); ?></dd>
        </div>
    </dl>

</section>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/clinic/storage-card.blade.php ENDPATH**/ ?>
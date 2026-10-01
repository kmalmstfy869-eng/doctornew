<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['logo', 'title', 'content']));

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

foreach (array_filter((['logo', 'title', 'content']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="empty-results" id="emptyResults">

    <i class="<?php echo e($logo); ?>"></i>

    <h3>

        <?php echo e($title); ?>


    </h3>

    <p>

        <?php echo e($content); ?>


    </p>

</div>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/home/banner/no_results.blade.php ENDPATH**/ ?>
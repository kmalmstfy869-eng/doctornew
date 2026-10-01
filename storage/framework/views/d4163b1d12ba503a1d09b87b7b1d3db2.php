<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['link', 'number', 'name', 'title', 'logo']));

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

foreach (array_filter((['link', 'number', 'name', 'title', 'logo']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<a href="<?php echo e($link); ?>" class="specialty-card">

    <div class="card-top">

        <div class="specialty-icon">

            <i class="<?php echo e($logo); ?>"></i>

        </div>

        <span class="specialty-number">

            <?php echo e($number); ?>


        </span>

    </div>

    <h3>

        <?php echo e($name); ?>


    </h3>

    <p>

        <?php echo e($title); ?>

    </p>

    <div class="card-bottom">

        <span class="doctor-count">

            <i class="fa-solid fa-user-doctor"></i>

            عرض الأطباء

        </span>

        <span class="arrow">

            <i class="fa-solid fa-arrow-left"></i>

        </span>

    </div>

</a>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/home/specialties/card_specialties.blade.php ENDPATH**/ ?>
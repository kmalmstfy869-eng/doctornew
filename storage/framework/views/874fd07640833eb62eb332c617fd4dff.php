<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['nav', 'title', 'link','route']));

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

foreach (array_filter((['nav', 'title', 'link','route']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<section class="home-section">

    <div class="site-container">

        <div class="home-jobs-banner">

            <div>

                <span>

                    <?php echo e($nav); ?>

                </span>

                <h2>

                    <?php echo e($title); ?>


                </h2>

                <p>

                    <?php echo e($slot); ?>


                </p>

            </div>

            <a href="<?php echo e($route); ?>" class="home-jobs-button">

                <?php echo e($link); ?>


                <i class="fa-solid fa-arrow-left"></i>

            </a>

        </div>

    </div>

</section>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/home/banner/firstbanner.blade.php ENDPATH**/ ?>
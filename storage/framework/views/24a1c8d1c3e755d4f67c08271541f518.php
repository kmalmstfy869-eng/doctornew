<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title', 'address', 'contet1', 'content_continuation', 'note']));

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

foreach (array_filter((['title', 'address', 'contet1', 'content_continuation', 'note']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<section class="doctors-hero">

    <div class="doctors-hero-content">


        <div class="doctors-breadcrumb">

            <a href="<?php echo e(route('home')); ?>">

                الرئيسية

            </a>


            <i class="fa-solid fa-angle-left"></i>


            <span>


                <?php echo e($title); ?>


            </span>

        </div>


        <div class="doctors-hero-badge">

            <i class="fa-solid fa-user-doctor"></i>

            <?php echo e($address); ?>


        </div>


        <h1>


            <?php echo e($contet1); ?>


            <span>

                <?php echo e($content_continuation); ?>


            </span>

        </h1>


        <p class="doctors-hero-text">

            <?php echo e($note); ?>


        </p>


    </div>

</section>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/home/hero/secondhero.blade.php ENDPATH**/ ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['doctors', 'favoriteIds' => []]));

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

foreach (array_filter((['doctors', 'favoriteIds' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="public-doctors-grid">
    <?php if($doctors && $doctors->isNotEmpty()): ?>
        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginalfcb79bfddd8883b2eb3ba145cda84b40 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfcb79bfddd8883b2eb3ba145cda84b40 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.doctors.card_doctor_clinic_system_component','data' => ['doctor' => $doctor,'favoriteIds' => $favoriteIds]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.doctors.card_doctor_clinic_system_component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['doctor' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($doctor),'favorite-ids' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($favoriteIds)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfcb79bfddd8883b2eb3ba145cda84b40)): ?>
<?php $attributes = $__attributesOriginalfcb79bfddd8883b2eb3ba145cda84b40; ?>
<?php unset($__attributesOriginalfcb79bfddd8883b2eb3ba145cda84b40); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfcb79bfddd8883b2eb3ba145cda84b40)): ?>
<?php $component = $__componentOriginalfcb79bfddd8883b2eb3ba145cda84b40; ?>
<?php unset($__componentOriginalfcb79bfddd8883b2eb3ba145cda84b40); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/home/doctors/doctors_grid.blade.php ENDPATH**/ ?>
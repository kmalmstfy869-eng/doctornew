<?php if($doctors->isNotEmpty()): ?>

    <div class="doctors-grid" id="doctorsGrid">

        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginalfcb79bfddd8883b2eb3ba145cda84b40 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfcb79bfddd8883b2eb3ba145cda84b40 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.doctors.card_doctor_clinic_system_component','data' => ['doctor' => $doctor]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.doctors.card_doctor_clinic_system_component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['doctor' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($doctor)]); ?>
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

    </div>

    <?php echo e($doctors->links('vendor.pagination.custom')); ?>


<?php else: ?>

    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء مطابقون','content' => 'جرب البحث باسم آخر أو غيّر التخصص والمنطقة.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء مطابقون','content' => 'جرب البحث باسم آخر أو غيّر التخصص والمنطقة.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $attributes = $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $component = $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>

<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/doctors/_grid.blade.php ENDPATH**/ ?>
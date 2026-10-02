<?php if($Specialties->isNotEmpty()): ?>
    <div class="specialties-grid" id="specialtiesGrid">

        <?php $__currentLoopData = $Specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (isset($component)) { $__componentOriginal2e84b417be6e8946efc2d044a58156a4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2e84b417be6e8946efc2d044a58156a4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.specialties.card_specialties','data' => ['link' => route('specialties.show', $specialty->slug),'number' => str_pad(
                ($Specialties->currentPage() - 1) * $Specialties->perPage() + $loop->iteration,
                2,
                '0',
                STR_PAD_LEFT,
            ),'name' => $specialty->name,'title' => $specialty->title,'logo' => $specialty->logo]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.specialties.card_specialties'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('specialties.show', $specialty->slug)),'number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(str_pad(
                ($Specialties->currentPage() - 1) * $Specialties->perPage() + $loop->iteration,
                2,
                '0',
                STR_PAD_LEFT,
            )),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialty->name),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialty->title),'logo' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialty->logo)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2e84b417be6e8946efc2d044a58156a4)): ?>
<?php $attributes = $__attributesOriginal2e84b417be6e8946efc2d044a58156a4; ?>
<?php unset($__attributesOriginal2e84b417be6e8946efc2d044a58156a4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2e84b417be6e8946efc2d044a58156a4)): ?>
<?php $component = $__componentOriginal2e84b417be6e8946efc2d044a58156a4; ?>
<?php unset($__componentOriginal2e84b417be6e8946efc2d044a58156a4); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

    <?php echo e($Specialties->links('vendor.pagination.custom')); ?>

<?php else: ?>
    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-stethoscope','title' => 'لا توجد تخصصات مطابقة','content' => 'جرب البحث باسم تخصص آخر أو غيّر معايير البحث.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-stethoscope','title' => 'لا توجد تخصصات مطابقة','content' => 'جرب البحث باسم تخصص آخر أو غيّر معايير البحث.']); ?>
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
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/specialty/_grid.blade.php ENDPATH**/ ?>
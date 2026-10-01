<?php $__empty_1 = true; $__currentLoopData = $dashboardQueue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <li class="flex items-center gap-3 rounded-lg border border-border px-3 py-2">

        <span class="grid size-8 shrink-0 place-items-center rounded-lg bg-primary-soft text-sm font-bold text-primary">
            <?php echo e($index + 1); ?>

        </span>

        <div class="min-w-0 flex-1">

            <p class="truncate text-sm font-semibold">
                <?php echo e($booking->patient_name); ?>

            </p>

            <p class="text-xs text-muted-foreground">
                <?php if($booking->arrived_at): ?>
                    وصل <?php echo e($booking->arrived_at->format('H:i')); ?>

                <?php else: ?>
                    لم يسجل وصول
                <?php endif; ?>
            </p>

        </div>

        <?php if($booking->status === 'in_progress'): ?>

            <span class="badge badge-purple">
                داخل الكشف
            </span>

        <?php else: ?>

            <span class="badge badge-warning">
                منتظر
            </span>

        <?php endif; ?>

    </li>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

    <li>
        <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-users-slash','title' => 'الطابور فارغ حالياً','content' => 'لا يوجد مرضى في طابور الانتظار في الوقت الحالي.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-users-slash','title' => 'الطابور فارغ حالياً','content' => 'لا يوجد مرضى في طابور الانتظار في الوقت الحالي.']); ?>
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
    </li>

<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/dashboard/partials/queue-list.blade.php ENDPATH**/ ?>
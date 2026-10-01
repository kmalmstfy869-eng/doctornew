<?php $__empty_1 = true; $__currentLoopData = $scheduleSlots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <li class="flex items-center justify-between gap-2 rounded-lg border border-border px-3 py-2">

        <span class="text-sm font-semibold tabular-nums">
            <?php echo e($slot['start_label']); ?> <?php echo e($slot['start_period']); ?> - <?php echo e($slot['end_label']); ?> <?php echo e($slot['end_period']); ?>

        </span>

        <?php if($slot['status'] === 'available'): ?>

            <span class="badge badge-success">
                متاح
            </span>

        <?php elseif($slot['status'] === 'booked'): ?>

            <span class="flex items-center gap-2">

                <span class="truncate text-xs text-muted-foreground">
                    <?php echo e(str_replace('بواسطة : ', '', $slot['label'])); ?>

                </span>

                <span class="badge badge-info">
                    محجوز
                </span>

            </span>

        <?php elseif($slot['status'] === 'blocked'): ?>

            <span class="badge badge-danger">
                مغلق
            </span>

        <?php else: ?>

            <span class="badge badge-warning">
                انتهى وقته
            </span>

        <?php endif; ?>

    </li>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

    <li>
        <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-regular fa-calendar-xmark','title' => 'لا يوجد جدول عمل اليوم','content' => 'لا يوجد مواعيد مفعّلة لهذا اليوم.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-regular fa-calendar-xmark','title' => 'لا يوجد جدول عمل اليوم','content' => 'لا يوجد مواعيد مفعّلة لهذا اليوم.']); ?>
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
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/dashboard/partials/schedule-list.blade.php ENDPATH**/ ?>
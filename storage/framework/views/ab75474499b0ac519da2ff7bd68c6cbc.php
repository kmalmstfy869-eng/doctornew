<?php
    $statusLabels = [
        'pending' => 'بانتظار التأكيد',
        'confirmed' => 'مؤكد',
        'in_progress' => 'داخل الكشف',
        'completed' => 'تم الكشف',
        'cancelled' => 'ملغي',
        'no_show' => 'لم يحضر',
    ];

    $statusClasses = [
        'pending' => 'badge-warning',
        'confirmed' => 'badge-info',
        'in_progress' => 'badge-purple',
        'completed' => 'badge-success',
        'cancelled' => 'badge-danger',
        'no_show' => 'badge-danger',
    ];
?>

<?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <?php
        $statusLabel = $statusLabels[$booking->status] ?? $booking->status;
        $statusClass = $statusClasses[$booking->status] ?? 'badge-info';
        $sourceLabel = $booking->booking_type === 'online' ? 'أونلاين' : 'من العيادة';
        $sourceClass = $booking->booking_type === 'online' ? 'badge-primary' : 'badge-purple';
    ?>

    <li class="rounded-lg border border-border px-3 py-2">

        <div class="flex items-center justify-between gap-2">

            <p class="truncate text-sm font-semibold">
                <?php echo e($booking->patient_name); ?>

            </p>

            <span class="badge <?php echo e($statusClass); ?>">
                <?php echo e($statusLabel); ?>

            </span>

        </div>

        <div class="mt-1.5 flex items-center gap-2 text-xs text-muted-foreground">

            <span class="tabular-nums">
                <?php if($booking->start_time): ?>
                    <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('h:i A')); ?>

                <?php else: ?>
                    <?php echo e($booking->created_at->format('h:i A')); ?>

                <?php endif; ?>
            </span>

            <span>•</span>

            <span class="badge <?php echo e($sourceClass); ?>">
                <?php echo e($sourceLabel); ?>

            </span>

        </div>

    </li>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

    <li>
        <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-magnifying-glass','title' => 'لا توجد حجوزات','content' => 'لم يتم تسجيل أي حجوزات بعد.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-magnifying-glass','title' => 'لا توجد حجوزات','content' => 'لم يتم تسجيل أي حجوزات بعد.']); ?>
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
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/dashboard/partials/recent-bookings.blade.php ENDPATH**/ ?>
<?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php

        $price = (float) ($booking->price ?? 0);
        $paid = (float) ($booking->paid ?? 0);

        if ($paid <= 0) {
            $paymentLabel = 'غير مدفوع';
            $paymentClass = 'text-muted-foreground';
        } elseif ($paid >= $price) {
            $paymentLabel = 'مدفوع بالكامل';
            $paymentClass = 'text-success';
        } else {
            $paymentLabel = 'مدفوع جزئيًا';
            $paymentClass = 'text-warning';
        }

        $statusLabels = [
            'pending' => 'في انتظار حضوره',
            'confirmed' => 'حضر للعيادة',
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

        $statusLabel = $statusLabels[$booking->status] ?? $booking->status;

        $statusClass = $statusClasses[$booking->status] ?? 'badge-info';

        $sourceLabel = $booking->booking_type === 'online' ? 'أونلاين' : 'من العيادة';

        $sourceClass = $booking->booking_type === 'online' ? 'badge-primary' : 'badge-purple';

    ?>


    <div class="clinic-surface-card border border-border p-4">

        <div class="flex items-start justify-between gap-3">

            <div class="flex min-w-0 items-center gap-3">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-soft text-primary">

                    <i data-lucide="user-round" class="h-5 w-5"></i>

                </div>


                <div class="min-w-0">

                    <?php if($isClinicSystem && $booking->patient_id): ?>
                        <a href="<?php echo e(route('clinic.patients.show', $booking->patient_id)); ?>"
                            class="block truncate font-bold text-primary hover:underline">

                            <?php echo e($booking->patient_name); ?>


                        </a>
                    <?php else: ?>
                        <h3 class="truncate font-bold text-foreground">
                            <?php echo e($booking->patient_name); ?>

                        </h3>
                    <?php endif; ?>

                    <p class="mt-1 text-xs text-muted-foreground">
                        🧡<?php echo e(str_pad(($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration, 2, '0', STR_PAD_LEFT)); ?>

                    </p>

                </div>

            </div>


            <div class="dropdown relative">

                <button type="button" class="btn btn-icon-sm" data-dropdown-trigger
                    aria-label="إجراءات الحجز">

                    <i data-lucide="more-horizontal"></i>

                </button>


                <div class="dropdown-menu min-w-[220px]">

                    <?php if($booking->patient_id && $isClinicSystem): ?>
                        <a href="<?php echo e(route('clinic.patients.show', $booking->patient_id)); ?>"
                            class="dropdown-item">

                            <i data-lucide="folder-open"></i>

                            عرض ملف المريض

                        </a>
                    <?php endif; ?>


                    <button type="button" class="dropdown-item" data-edit-service
                        data-id="<?php echo e($booking->id); ?>" data-name="<?php echo e($booking->patient_name); ?>"
                        data-service="<?php echo e($booking->service ?? ''); ?>">

                        <i data-lucide="clipboard-pen"></i>

                        <?php echo e($booking->service ? 'تعديل الخدمة' : 'تحديد الخدمة'); ?>


                    </button>


                    <button type="button" class="dropdown-item" data-edit-payment
                        data-id="<?php echo e($booking->id); ?>" data-name="<?php echo e($booking->patient_name); ?>"
                        data-price="<?php echo e($price); ?>" data-paid="<?php echo e($paid); ?>">

                        <i data-lucide="wallet"></i>

                        تعديل الدفع

                    </button>


                    <?php if($booking->status === 'pending' && !$booking->arrived_at): ?>
                        <form method="POST"
                            action="<?php echo e(route('clinic.bookings.arrive', $booking)); ?>">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>

                            <button type="submit" class="dropdown-item">

                                <i data-lucide="user-round-check"></i>

                                تسجيل وصول

                            </button>

                        </form>
                    <?php endif; ?>


                    <?php if($booking->arrived_at && $booking->status === 'confirmed'): ?>
                        <form method="POST" action="<?php echo e(route('clinic.bookings.start', $booking)); ?>">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>

                            <button type="submit" class="dropdown-item">

                                <i data-lucide="stethoscope"></i>

                                بدء الكشف

                            </button>

                        </form>
                    <?php endif; ?>


                    <?php if($booking->status === 'pending' && !$booking->arrived_at): ?>
                        <form method="POST"
                            action="<?php echo e(route('clinic.bookings.no-show', $booking)); ?>">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>

                            <button type="submit" class="dropdown-item">

                                <i data-lucide="user-x"></i>

                                لم يحضر

                            </button>

                        </form>
                    <?php endif; ?>


                    <?php if($booking->status === 'pending'): ?>
                        <button type="button" class="dropdown-item danger"
                            data-cancel-booking="<?php echo e($booking->id); ?>"
                            data-cancel-name="<?php echo e($booking->patient_name); ?>">

                            <i data-lucide="trash-2"></i>

                            إلغاء الحجز

                        </button>
                    <?php endif; ?>

                </div>

            </div>

        </div>


        <div class="mt-4 grid grid-cols-2 gap-3">

            <div class="rounded-xl bg-muted p-3">

                <p class="text-xs text-muted-foreground">
                    الخدمة
                </p>

                <p class="mt-1 text-sm font-semibold text-foreground">
                    <?php echo e($booking->service ?? 'لم تحدد'); ?>

                </p>

            </div>


            <div class="rounded-xl bg-muted p-3">

                <p class="text-xs text-muted-foreground">
                    المصدر
                </p>

                <p class="mt-1">

                    <span class="badge <?php echo e($sourceClass); ?>">
                        <?php echo e($sourceLabel); ?>

                    </span>

                </p>

            </div>


            <div class="rounded-xl bg-muted p-3">

                <p class="text-xs text-muted-foreground">
                    التاريخ
                </p>

                <p class="mt-1 text-sm font-semibold text-foreground">

                    <?php echo e(\Carbon\Carbon::parse($booking->appointment_date)->format('Y-m-d')); ?>


                </p>

            </div>


            <div class="rounded-xl bg-muted p-3">

                <p class="text-xs text-muted-foreground">
                    موعد الدخول المتوقع
                </p>

                <p class="mt-1 text-sm font-semibold text-foreground">

                    <?php if($booking->start_time): ?>
                        <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('h:i A')); ?>

                    <?php else: ?>
                        بدون وقت
                    <?php endif; ?>

                </p>

            </div>

        </div>


        <div
            class="mt-3 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-border p-3">

            <div>

                <p class="text-xs text-muted-foreground">
                    الدفع
                </p>

                <p class="mt-1 text-sm font-semibold <?php echo e($paymentClass); ?>">
                    <?php echo e($paymentLabel); ?>

                </p>

                <p class="mt-1 text-xs text-muted-foreground">

                    <?php echo e(number_format($paid, 0)); ?>


                    /

                    <?php echo e(number_format($price, 0)); ?>


                    ج.م

                </p>

            </div>


            <div class="text-left">

                <p class="text-xs text-muted-foreground">
                    الحالة
                </p>

                <div class="mt-1">

                    <span class="badge <?php echo e($statusClass); ?>">
                        <?php echo e($statusLabel); ?>

                    </span>

                </div>

            </div>

        </div>


        <?php if($booking->patient?->phone || $booking->patient_phone): ?>
            <div class="mt-3 flex items-center gap-2 text-xs text-muted-foreground">

                <i data-lucide="phone" class="h-3.5 w-3.5"></i>

                <?php echo e($booking->patient?->phone ?? $booking->patient_phone); ?>


            </div>
        <?php endif; ?>

    </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-magnifying-glass','title' => 'لا توجد حجوزات','content' => 'لم يتم العثور على حجوزات مطابقة للبحث أو الفلاتر المحددة.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-magnifying-glass','title' => 'لا توجد حجوزات','content' => 'لم يتم العثور على حجوزات مطابقة للبحث أو الفلاتر المحددة.']); ?>
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
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/booking/partials/mobile-cards.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'لوحة تحكم العيادة | دليل الأطباء'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <main class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

        
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">
                <h1 class="truncate text-xl font-bold sm:text-2xl">لوحة التحكم</h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    مرحبًا د.<?php echo e(Auth::user()->name ?? 'مدير النظام'); ?> — إليك ملخص عيادتك اليوم.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">

                <a href="<?php echo e(route('clinic.bookings.index')); ?>" class="btn btn-default btn-sm">
                    <i data-lucide="plus" class="size-4"></i>
                    حجز جديد
                </a>

                <?php if($isClinicSystem): ?>
                    <a href="<?php echo e(route('clinic.patients')); ?>" class="btn btn-outline btn-sm">
                        <i data-lucide="user-plus" class="size-4"></i>
                        مريض جديد
                    </a>
                <?php endif; ?>

                <a href="<?php echo e(route('clinic.slots.index')); ?>" class="btn btn-outline btn-sm">
                    <i data-lucide="calendar-clock" class="size-4"></i>
                    المواعيد المتاحة
                </a>

            </div>
        </div>


        
        <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-5">

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">حجوزات اليوم</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-total-booking"><?php echo e($TotalBooking ?? 0); ?></p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-primary">
                        <i data-lucide="calendar-check" class="size-5"></i>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">حجوزات أونلاين</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-booking-online"><?php echo e($TotalBookingOnline ?? 0); ?></p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-info">
                        <i data-lucide="globe" class="size-5"></i>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">حجوزات العيادة</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-booking-clinic"><?php echo e($TotalBookingClinic ?? 0); ?></p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-purple">
                        <i data-lucide="hospital" class="size-5"></i>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">المرضى المنتظرون</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-waiting"><?php echo e($waitingPatients ?? 0); ?></p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-warning">
                        <i data-lucide="clock" class="size-5"></i>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">تم الكشف عليهم</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-completed"><?php echo e($completedPatients ?? 0); ?></p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-success">
                        <i data-lucide="check-circle-2" class="size-5"></i>
                    </span>
                </div>
            </div>

        </div>


        
        <div class="mt-3 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-5">

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">مواعيد متاحة</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-slots-available"><?php echo e($slotsStats['available']); ?></p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-success">
                        <i data-lucide="calendar-clock" class="size-5"></i>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">ملغاة / لم يحضر</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-cancelled"><?php echo e($cancelledPatients ?? 0); ?></p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-danger">
                        <i data-lucide="user-x" class="size-5"></i>
                    </span>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">مواعيد مغلقة</p>
                        <p class="mt-2 text-2xl font-bold tabular-nums" id="stat-slots-blocked"><?php echo e($slotsStats['blocked']); ?></p>
                    </div>
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-danger">
                        <i data-lucide="calendar-x" class="size-5"></i>
                    </span>
                </div>
            </div>

            
            <?php if($isClinicSystem): ?>
                <?php if (! ($isAssistant)): ?>
                    <div class="stat-card">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">إيرادات اليوم</p>
                                <p class="mt-2 text-2xl font-bold tabular-nums">
                                    <?php echo e(\App\Support\Money::fmt($income['today'])); ?> ج.م
                                </p>
                            </div>
                            <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-success">
                                <i data-lucide="circle-dollar-sign" class="size-5"></i>
                            </span>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-xs font-medium text-muted-foreground sm:text-sm">إيرادات الشهر</p>
                                <p class="mt-2 text-2xl font-bold tabular-nums">
                                    <?php echo e(\App\Support\Money::fmt($income['month'])); ?> ج.م
                                </p>
                            </div>
                            <span class="grid size-10 shrink-0 place-items-center rounded-xl badge-primary">
                                <i data-lucide="trending-up" class="size-5"></i>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php if (! ($isAssistant)): ?>
                    
                    <div class="stat-card col-span-2 lg:col-span-2">
                        <div class="flex h-full items-center justify-between gap-4">

                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="grid size-9 shrink-0 place-items-center rounded-xl badge-primary">
                                        <i data-lucide="sparkles" class="size-4"></i>
                                    </span>
                                    <p class="text-sm font-bold">نظام العيادة</p>
                                </div>

                                <p class="mt-2 text-xs leading-5 text-muted-foreground">
                                    احصل على إدارة المرضى والملفات الطبية
                                    والإيرادات والتقارير بشكل متكامل.
                                </p>
                            </div>

                            <a href="<?php echo e(route('doctor.subscription')); ?>" class="btn btn-default btn-sm shrink-0">
                                <i data-lucide="arrow-up-circle" class="size-4"></i>
                                الترقية
                            </a>

                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>


        
        <div class="mt-4 grid gap-4 lg:grid-cols-2">

            <?php if (! ($isAssistant)): ?>

                <?php if($isClinicSystem): ?>
                    
                    <div class="section-card">

                        <div class="section-card-header">
                            <h2 class="text-sm font-bold sm:text-base">الإيرادات — آخر ٧ أيام</h2>
                        </div>

                        <div class="section-card-body">
                            <div class="h-56 w-full">
                                <div class="mini-chart">
                                    <?php $__currentLoopData = $revenueChart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="bar-col" title="<?php echo e(\App\Support\Money::fmt($day['total'])); ?> ج.م">
                                            <div class="bar" style="height:<?php echo e($day['height']); ?>%; background-color:var(--primary);"></div>
                                            <span class="bar-label"><?php echo e($day['label']); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php else: ?>
                    
                    <div class="section-card">
                        <div class="section-card-body">

                            <div class="flex min-h-56 flex-col items-center justify-center text-center">

                                <span class="grid size-14 place-items-center rounded-2xl bg-primary/10 text-primary">
                                    <i data-lucide="chart-no-axes-combined" class="size-7"></i>
                                </span>

                                <h2 class="mt-4 text-base font-bold">تقارير الإيرادات</h2>

                                <p class="mt-2 max-w-md text-sm leading-6 text-muted-foreground">
                                    تابع إيرادات عيادتك يوميًا وشهريًا
                                    واعرف أداء الحجوزات بالتفصيل مع نظام العيادة.
                                </p>

                                <a href="<?php echo e(route('doctor.subscription')); ?>" class="btn btn-default btn-sm mt-4">
                                    <i data-lucide="lock-open" class="size-4"></i>
                                    فتح الميزة
                                </a>

                            </div>

                        </div>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

            
            <div class="section-card <?php echo e($isAssistant ? 'lg:col-span-2' : ''); ?>">

                <div class="section-card-header">
                    <h2 class="text-sm font-bold sm:text-base">الحجوزات — أونلاين مقابل العيادة</h2>
                </div>

                <div class="section-card-body">

                    <div class="h-56 w-full">
                        <div class="mini-chart">
                            <?php $__currentLoopData = $bookingsChart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bar-col">
                                    <div style="display:flex;gap:3px;align-items:flex-end;height:100%;width:100%;justify-content:center;"
                                         title="<?php echo e($day['label']); ?>: أونلاين <?php echo e($day['online']); ?> / عيادة <?php echo e($day['clinic']); ?>">
                                        <div class="bar" style="height:<?php echo e($day['onlineHeight']); ?>%;background-color:var(--chart-1);max-width:.7rem;"></div>
                                        <div class="bar" style="height:<?php echo e($day['clinicHeight']); ?>%;background-color:var(--chart-4);max-width:.7rem;"></div>
                                    </div>
                                    <span class="bar-label"><?php echo e($day['label']); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="mt-3 flex items-center gap-4 text-xs text-muted-foreground">
                        <span class="flex items-center gap-1.5">
                            <span class="size-2.5 rounded-full" style="background-color:var(--chart-1)"></span>
                            أونلاين
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="size-2.5 rounded-full" style="background-color:var(--chart-4)"></span>
                            العيادة
                        </span>
                    </div>

                </div>
            </div>

        </div>


        
        <div class="mt-4 grid gap-4 lg:grid-cols-3">

            
            <div class="section-card">
                <div class="section-card-header">
                    <h2 class="text-sm font-bold sm:text-base">جدول اليوم</h2>
                    <a href="<?php echo e(route('clinic.slots.index')); ?>" class="text-xs font-semibold text-primary">عرض الكل</a>
                </div>
                <div class="section-card-body">
                    <ul id="schedule-list" class="clinic-scroll-y max-h-72 space-y-2 pe-1">
                        <?php echo $__env->make('doctor.clinic.dashboard.partials.schedule-list', ['scheduleSlots' => $scheduleSlots], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </ul>
                </div>
            </div>

            
            <div class="section-card">
                <div class="section-card-header">
                    <h2 class="text-sm font-bold sm:text-base">طابور الانتظار</h2>
                    <a href="<?php echo e(route('clinic.bookings.index')); ?>" class="text-xs font-semibold text-primary">إدارة الطابور</a>
                </div>
                <div class="section-card-body">
                    <ul id="queue-list" class="space-y-2">
                        <?php echo $__env->make('doctor.clinic.dashboard.partials.queue-list', ['dashboardQueue' => $dashboardQueue], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </ul>
                </div>
            </div>

            
            <div class="section-card">
                <div class="section-card-header">
                    <h2 class="text-sm font-bold sm:text-base">آخر الحجوزات</h2>
                    <a href="<?php echo e(route('clinic.bookings.index')); ?>" class="text-xs font-semibold text-primary">عرض الكل</a>
                </div>
                <div class="section-card-body">
                    <ul id="recent-bookings-list" class="space-y-2">
                        <?php echo $__env->make('doctor.clinic.dashboard.partials.recent-bookings', ['recentBookings' => $recentBookings], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </ul>
                </div>
            </div>

        </div>

    </main>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra_java'); ?>
    <script>
        window.ClinicDashboardConfig = {
            queueDataUrl: <?php echo json_encode(route('clinic.dashboard.queue-data'), 15, 512) ?>,
        };
    </script>

    <script src="<?php echo e(asset('js/clinic/dashboard.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('doctor.layouts.app_clinc', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/index.blade.php ENDPATH**/ ?>
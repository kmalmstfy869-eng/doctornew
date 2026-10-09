<?php $__env->startSection('title', 'الحجوزات والطابور | دليل الأطباء'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
    <?php if($isClinicSystem): ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/doctor/clinic/clinic-live-messages.css')); ?>">
    <?php endif; ?>
<?php $__env->stopPush(); ?>
    <?php if (! $__env->hasRenderedOnce('modal-variants-css')): $__env->markAsRenderedOnce('modal-variants-css'); ?>
        <?php $__env->startPush('extra_style'); ?>
            <link rel="stylesheet" href="<?php echo e(asset('css/clinic/modal_variants.css')); ?>">
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
<?php $__env->startSection('content'); ?>

    <div class="w-full min-w-0 px-4 py-6 sm:px-6 lg:px-8">

        <div class="mx-auto w-full max-w-[1360px]">

            
            <?php if($isClinicSystem): ?>
                <div id="clinic-live-messages" class="clinic-live-messages" hidden></div>
            <?php endif; ?>

            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <div class="mb-2 flex items-center gap-2 text-sm text-muted-foreground">

                        <span>
                            نظام العيادة
                        </span>

                        <i data-lucide="chevron-left" class="h-4 w-4"></i>

                        <span class="text-foreground">
                            الحجوزات والطابور
                        </span>

                    </div>

                    <h1 class="text-2xl font-bold tracking-tight text-foreground sm:text-3xl">
                        الحجوزات والطابور
                    </h1>

                    <p class="mt-1 text-sm text-muted-foreground">
                        إدارة الحجوزات ومتابعة المرضى وتنظيم طابور العيادة.
                    </p>

                </div>

                <div class="flex flex-wrap items-center gap-2">

                    <button type="button" class="btn btn-default" data-modal-open="new-booking-modal">

                        <i data-lucide="plus" class="h-4 w-4"></i>

                        حجز جديد

                    </button>

                </div>

            </div>


            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                <div class="stat-card">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-sm text-muted-foreground">
                                في الطابور
                            </p>

                            <p id="stat-queue-count" class="mt-1 text-2xl font-bold text-foreground">
                                <?php echo e($queueCount); ?>

                            </p>

                        </div>

                        <div class="badge-warning flex h-11 w-11 items-center justify-center rounded-xl">

                            <i data-lucide="users-round" class="h-5 w-5"></i>

                        </div>

                    </div>

                </div>


                <div class="stat-card">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-sm text-muted-foreground">
                                داخل الكشف
                            </p>

                            <p id="stat-exam-count" class="mt-1 text-2xl font-bold text-foreground">
                                <?php echo e($examCount); ?>

                            </p>

                        </div>

                        <div class="badge-purple flex h-11 w-11 items-center justify-center rounded-xl">

                            <i data-lucide="stethoscope" class="h-5 w-5"></i>

                        </div>

                    </div>

                </div>


                <div class="stat-card">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-sm text-muted-foreground">
                                تم الكشف اليوم
                            </p>

                            <p id="stat-done-count" class="mt-1 text-2xl font-bold text-foreground">
                                <?php echo e($doneCount); ?>

                            </p>

                        </div>

                        <div class="badge-success flex h-11 w-11 items-center justify-center rounded-xl">

                            <i data-lucide="circle-check-big" class="h-5 w-5"></i>

                        </div>

                    </div>

                </div>


                <div class="stat-card">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <p class="text-sm text-muted-foreground">
                                حجوزات اليوم
                            </p>

                            <p id="stat-total-count" class="mt-1 text-2xl font-bold text-foreground">
                                <?php echo e($total); ?>

                            </p>

                        </div>

                        <div class="badge-info flex h-11 w-11 items-center justify-center rounded-xl">

                            <i data-lucide="calendar-days" class="h-5 w-5"></i>

                        </div>

                    </div>

                </div>

            </div>


            <div class="mb-6">

                <div class="clinic-surface-card overflow-hidden">

                    <div class="section-card-header">

                        <div>

                            <h2 class="text-lg font-bold text-foreground">
                                المريض الحالي
                            </h2>

                            <p class="mt-1 text-sm text-muted-foreground">
                                المريض الموجود حاليًا داخل الكشف.
                            </p>

                        </div>

                        <span class="badge badge-purple">

                            <i data-lucide="stethoscope" class="h-3.5 w-3.5"></i>

                            داخل الكشف

                        </span>

                    </div>


                    <div class="p-4 sm:p-5">

                        <div id="current-exam-list">

                            <?php $__currentLoopData = $currentExam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bq-current-card <?php if(!$loop->last): ?> mb-4 <?php endif; ?>">

                                    <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">

                                        <div class="flex min-w-0 items-center gap-4">

                                            <div
                                                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-primary-soft text-primary">

                                                <i data-lucide="user-round" class="h-7 w-7"></i>

                                            </div>

                                            <div class="min-w-0">

                                                <div class="flex flex-wrap items-center gap-2">

                                                    <h3 class="truncate text-lg font-bold text-foreground">
                                                        <?php echo e($exam->patient_name ?? 'مريض بدون اسم'); ?>

                                                    </h3>

                                                    <span class="badge badge-purple">
                                                        داخل الكشف
                                                    </span>

                                                </div>

                                                <div
                                                    class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-sm text-muted-foreground">

                                                    <?php if($exam->service): ?>
                                                        <span class="flex items-center gap-1.5">

                                                            <i data-lucide="stethoscope" class="h-3.5 w-3.5"></i>

                                                            <?php echo e($exam->service); ?>


                                                        </span>
                                                    <?php endif; ?>

                                                    <?php if($exam->started_at): ?>
                                                        <span class="flex items-center gap-1.5">

                                                            <i data-lucide="clock-3" class="h-3.5 w-3.5"></i>

                                                            بدأ <?php echo e($exam->started_at->format('H:i')); ?>


                                                        </span>
                                                    <?php endif; ?>

                                                    <?php if($exam->patient_phone): ?>
                                                        <span class="flex items-center gap-1.5">

                                                            <i data-lucide="phone" class="h-3.5 w-3.5"></i>

                                                            <?php echo e($exam->patient_phone); ?>


                                                        </span>
                                                    <?php endif; ?>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="flex flex-wrap gap-2">

                                            <?php if($exam->patient_id && $isClinicSystem): ?>
                                                <a href="<?php echo e(route('clinic.patients.show', $exam->patient_id)); ?>"
                                                    class="btn btn-outline">

                                                    <i data-lucide="folder-open" class="h-4 w-4"></i>

                                                    ملف المريض

                                                </a>
                                            <?php endif; ?>

                                            <form method="POST" action="<?php echo e(route('clinic.bookings.finish', $exam)); ?>">

                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>

                                                <button type="submit" class="btn btn-default">

                                                    <i data-lucide="circle-check-big" class="h-4 w-4"></i>

                                                    إنهاء الكشف

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>


                        <div id="current-exam-empty" class="<?php echo e($currentExam->count() ? 'hidden' : ''); ?>">

                            <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد مريض داخل الكشف','content' => 'عند بدء الكشف على أحد المرضى من طابور الانتظار سيظهر هنا.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد مريض داخل الكشف','content' => 'عند بدء الكشف على أحد المرضى من طابور الانتظار سيظهر هنا.']); ?>
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

                        </div>

                    </div>

                </div>

            </div>


            <div class="mb-6">

                <div class="clinic-surface-card overflow-hidden">

                    <div class="section-card-header">

                        <div>

                            <h2 class="text-lg font-bold text-foreground">
                                طابور الانتظار
                            </h2>

                            <p class="mt-1 text-sm text-muted-foreground">
                                ترتيب المرضى الحالي في الطابور.
                            </p>

                        </div>

                        <span id="queue-count-badge" class="badge badge-warning">

                            <?php echo e($queueCount); ?>


                            <?php echo e($queueCount == 1 ? 'مريض' : 'مرضى'); ?>


                        </span>

                    </div>


                    <div class="p-4 sm:p-5">

                        <div id="queue-list">

                            <?php $__currentLoopData = $queuePatients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="clinic-surface-card mb-3 border border-border p-4 last:mb-0">

                                    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

                                        <div class="flex min-w-0 items-center gap-3">

                                            <div class="bq-queue-num">
                                                <?php echo e($loop->iteration); ?>

                                            </div>

                                            <div class="bq-queue-info">

                                                <div class="bq-queue-title">
                                                    <?php if($isClinicSystem && $booking->patient_id): ?>
                                                        <a href="<?php echo e(route('clinic.patients.show', $booking->patient_id)); ?>"
                                                            class="text-xl font-semibold text-primary hover:underline">

                                                            <?php echo e($booking->patient_name); ?>


                                                        </a>
                                                    <?php else: ?>
                                                        <p class="text-xl font-semibold">
                                                            <?php echo e($booking->patient_name); ?>

                                                        </p>
                                                    <?php endif; ?>
                                                    <span
                                                        class="badge <?php echo e($booking->booking_type === 'online' ? 'badge-primary' : 'badge-purple'); ?>">
                                                        <?php echo e($booking->booking_type === 'online' ? 'أونلاين' : 'من العيادة'); ?>

                                                    </span>

                                                    <?php if($booking->booking_type === 'online' && $booking->arrival_status): ?>
                                                        <span class="badge badge-success">
                                                            <?php echo e($booking->arrival_status); ?>

                                                        </span>
                                                    <?php endif; ?>

                                                </div>

                                                <div class="bq-queue-meta">

                                                    <span class="bq-queue-meta-item bq-queue-service">
                                                        <i data-lucide="clipboard-list"></i>
                                                        <span><?php echo e($booking->service ?? 'لم تحدد'); ?></span>
                                                    </span>

                                                    <?php if($booking->start_time): ?>
                                                        <span class="bq-queue-meta-item">
                                                            <i data-lucide="clock-3"></i>
                                                            <span>
                                                                موعد:
                                                                <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('h:i A')); ?>

                                                            </span>
                                                        </span>
                                                    <?php endif; ?>

                                                    <?php if($booking->arrived_at): ?>
                                                        <span class="bq-queue-meta-item">
                                                            <i data-lucide="log-in"></i>
                                                            <span>
                                                                وصول:
                                                                <?php echo e($booking->arrived_at->format('h:i A')); ?>

                                                            </span>
                                                        </span>
                                                    <?php endif; ?>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="bq-queue-actions">

                                            <?php if($isClinicSystem && $booking->patient_id): ?>
                                                <a href="<?php echo e(route('clinic.patients.show', $booking->patient_id)); ?>"
                                                    class="btn btn-outline btn-sm">

                                                    <i data-lucide="folder-open" class="h-4 w-4"></i>

                                                    ملف المريض

                                                </a>
                                            <?php endif; ?>

                                            <form method="POST" action="<?php echo e(route('clinic.bookings.call', $booking)); ?>">

                                                <?php echo csrf_field(); ?>

                                                <button type="submit" class="btn btn-outline btn-sm">

                                                    <i data-lucide="megaphone" class="h-4 w-4"></i>

                                                    استدعاء

                                                </button>

                                            </form>

                                            <form method="POST" action="<?php echo e(route('clinic.bookings.start', $booking)); ?>">

                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>

                                                <button type="submit" class="btn btn-default btn-sm">

                                                    <i data-lucide="stethoscope" class="h-4 w-4"></i>

                                                    بدء الكشف

                                                </button>

                                            </form>

                                            <button type="button" class="btn btn-destructive" aria-label="حذف الحجز"
                                                data-cancel-booking="<?php echo e($booking->id); ?>"
                                                data-cancel-name="<?php echo e($booking->patient_name); ?>">

                                                <i data-lucide="trash-2" class="size-4">
                                                </i>

                                            </button>

                                        </div>

                                    </div>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>

                        <div id="queue-empty" class="<?php echo e($queuePatients->count() ? 'hidden' : ''); ?>">

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

                        </div>

                    </div>

                </div>

            </div>


            <div class="clinic-surface-card overflow-hidden">

                <div class="section-card-header">

                    <div>

                        <h2 class="text-lg font-bold text-foreground">
                            الحجوزات
                        </h2>

                        <p class="mt-1 text-sm text-muted-foreground">
                            جميع الحجوزات وحالة كل حجز.
                        </p>

                    </div>


                    <a href="<?php echo e(route('clinic.history')); ?>" class="btn btn-default">
                        <i data-lucide="history" class="h-4 w-4"></i>
                        سجل الحجوزات
                    </a>

                </div>


                <form method="GET" action="<?php echo e(route('clinic.bookings.index')); ?>"
                    class="bq-toolbar border-b border-border p-4">

                    <div class="relative flex min-w-0 flex-1 items-center">

                        <input name="search" type="text" class="field-input w-full pl-24 pr-4"
                            value="<?php echo e(request('search')); ?>" placeholder="ابحث باسم المريض أو الهاتف...">

                        <?php if(request('search') || request('status') || request('source')): ?>
                            <a href="<?php echo e(route('clinic.bookings.index')); ?>"
                                class="btn btn-destructive btn-sm absolute left-2 z-10 flex items-center justify-center gap-1"
                                title="إلغاء البحث">

                                <span class="text-xs font-bold leading-none">
                                    ✕
                                </span>

                            </a>
                        <?php endif; ?>

                    </div>


                    <select name="status" class="field-select">

                        <option value="" <?php if(request('status', '') === ''): echo 'selected'; endif; ?>>
                            كل الحالات
                        </option>

                        <option value="pending" <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>>
                            في انتظار الحضور
                        </option>

                        <option value="confirmed" <?php if(request('status') === 'confirmed'): echo 'selected'; endif; ?>>
                            حضر للعيادة
                        </option>

                        <option value="in_progress" <?php if(request('status') === 'in_progress'): echo 'selected'; endif; ?>>
                            داخل الكشف
                        </option>

                        <option value="completed" <?php if(request('status') === 'completed'): echo 'selected'; endif; ?>>
                            تم الكشف
                        </option>

                        <option value="no_show" <?php if(request('status') === 'no_show'): echo 'selected'; endif; ?>>
                            لم يحضر
                        </option>

                        <option value="cancelled" <?php if(request('status') === 'cancelled'): echo 'selected'; endif; ?>>
                            ملغي
                        </option>

                    </select>


                    <select name="source" class="field-select">

                        <option value="" <?php if(request('source', '') === ''): echo 'selected'; endif; ?>>
                            كل المصادر
                        </option>

                        <option value="online" <?php if(request('source') === 'online'): echo 'selected'; endif; ?>>
                            أونلاين
                        </option>

                        <option value="clinic" <?php if(request('source') === 'clinic'): echo 'selected'; endif; ?>>
                            من العيادة
                        </option>

                    </select>


                    <button type="submit" class="btn btn-default">

                        <i data-lucide="search" class="h-4 w-4"></i>

                        بحث

                    </button>

                </form>


                <div class="border-b border-border px-4 py-3 sm:px-5">

                    <span id="bookings-count-label" class="text-sm text-muted-foreground">

                        <?php echo e($bookings->total()); ?>


                        <?php echo e($bookings->total() == 1 ? 'حجز' : 'حجوزات'); ?>


                    </span>

                </div>


                <div class="hidden overflow-x-auto lg:block">

                    <table class="clinic-table w-full">

                        <thead>

                            <tr>

                                <th>المريض</th>
                                <th>الحجز</th>
                                <th>الخدمة</th>
                                <th>المصدر</th>
                                <th>التاريخ</th>
                                <th>موعد الدخول المتوقع</th>
                                <th>الدفع</th>
                                <th>الحالة</th>
                                <th class="text-center">إجراءات</th>

                            </tr>

                        </thead>


                        <tbody id="bookings-tbody">
                            <?php echo $__env->make('doctor.clinic.booking.partials.table-body', [
                                'bookings' => $bookings,
                                'isClinicSystem' => $isClinicSystem,
                            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </tbody>

                    </table>

                </div>


                <div id="bookings-mobile-list" class="grid gap-3 p-4 lg:hidden">
                    <?php echo $__env->make('doctor.clinic.booking.partials.mobile-cards', [
                        'bookings' => $bookings,
                        'isClinicSystem' => $isClinicSystem,
                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>


                <div id="bookings-pagination-wrapper">
                    <?php echo $__env->make('doctor.clinic.booking.partials.pagination', ['bookings' => $bookings], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

            </div>

        </div>

    </div>


    

    <div id="new-booking-modal" class="modal-overlay">

        <div class="modal-panel modal-lg modal-panel--create">

            <div class="modal-head">

                <span class="modal-head__icon">
                    <i data-lucide="calendar-plus" class="h-5 w-5"></i>
                </span>

                <div class="min-w-0 flex-1">

                    <h3 class="modal-head__title">
                        حجز جديد
                    </h3>

                    <p class="modal-head__sub">
                        أضف حجزًا جديدًا للمريض.
                    </p>

                </div>

                <button type="button" class="btn btn-icon" data-modal-close>

                    <i data-lucide="x" class="h-5 w-5"></i>

                </button>

            </div>


            <form method="POST" action="<?php echo e(route('clinic.bookings.store')); ?>" id="new-booking-form">

                <?php echo csrf_field(); ?>

                <?php if($isClinicSystem): ?>
                    <div class="mb-5">

                        <label class="field-label mb-2">
                            نوع المريض
                        </label>

                        <div class="bq-mode-switch">

                            <button type="button" id="mode-existing" class="bq-mode-btn">

                                <i data-lucide="user-round-check" class="h-5 w-5"></i>

                                <span>
                                    مريض موجود
                                </span>

                            </button>

                            <button type="button" id="mode-new" class="bq-mode-btn">

                                <i data-lucide="user-round-plus" class="h-5 w-5"></i>

                                <span>
                                    مريض جديد
                                </span>

                            </button>

                        </div>

                    </div>


                    <div id="existing-patient-fields">

                        <label class="field-label">
                            البحث عن المريض
                        </label>

                        <div class="relative mt-2">

                            <input id="patient-search" type="text" class="field-input pr-10" autocomplete="off"
                                placeholder="ابحث بالاسم أو رقم الهاتف...">

                        </div>

                        <div id="patient-search-results"
                            class="hidden mt-2 max-h-56 overflow-y-auto rounded-xl border border-border bg-card divide-y divide-border">
                        </div>

                        <input type="hidden" name="patient_id" id="patient-select" value="<?php echo e(old('patient_id')); ?>">

                        <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    <?php echo e($message); ?>

                                </span>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div id="patient-selected-info" class="mt-3 hidden rounded-xl border border-border bg-muted p-4">

                            <div class="flex items-center justify-between gap-3">

                                <div class="min-w-0">

                                    <p id="patient-selected-name" class="truncate font-semibold text-foreground"></p>

                                    <p id="patient-selected-phone" class="mt-1 text-xs text-muted-foreground"></p>

                                </div>

                                <button type="button" id="patient-selected-clear" class="btn btn-outline btn-sm">
                                    تغيير
                                </button>

                            </div>

                        </div>

                    </div>


                    <div id="new-patient-fields">

                        <label class="field-label">
                            اسم المريض
                        </label>

                        <div class="relative mt-2">

                            <input name="new_patient_name" id="new-patient-name" type="text"
                                class="field-input pr-10 <?php $__errorArgs = ['new_patient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="اكتب اسم المريض" value="<?php echo e(old('new_patient_name')); ?>">

                        </div>

                        <?php $__errorArgs = ['new_patient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    <?php echo e($message); ?>

                                </span>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                        <label class="field-label mt-4">
                            رقم الهاتف
                        </label>

                        <div class="relative mt-2">

                            <input name="patient_phone" id="new-patient-phone" type="text" inputmode="tel"
                                class="field-input pr-10 <?php $__errorArgs = ['patient_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="اكتب رقم الهاتف" value="<?php echo e(old('patient_phone')); ?>">

                        </div>

                        <?php $__errorArgs = ['patient_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    <?php echo e($message); ?>

                                </span>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                        <p class="mt-2 text-xs text-muted-foreground">
                            عند إدخال رقم الهاتف، سيتم إنشاء ملف طبي للمريض تلقائيًا، ويمكنك استخدامه لاحقًا في متابعة
                            بياناته وحجوزاته.
                        </p>

                    </div>
                <?php else: ?>
                    <div>

                        <label class="field-label">
                            اسم المريض
                        </label>

                        <div class="relative mt-2">

                            <input name="new_patient_name" id="new-patient-name" type="text"
                                class="field-input pr-10 <?php $__errorArgs = ['new_patient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="اكتب اسم المريض" value="<?php echo e(old('new_patient_name')); ?>">

                        </div>

                        <?php $__errorArgs = ['new_patient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    <?php echo e($message); ?>

                                </span>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                        <label class="field-label mt-4">
                            رقم الهاتف
                        </label>

                        <div class="relative mt-2">

                            <input name="patient_phone" id="new-patient-phone" type="text" inputmode="tel"
                                class="field-input pr-10 <?php $__errorArgs = ['patient_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="اكتب رقم الهاتف" value="<?php echo e(old('patient_phone')); ?>">

                        </div>

                        <?php $__errorArgs = ['patient_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    <?php echo e($message); ?>

                                </span>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                        <p class="mt-2 text-xs text-muted-foreground">
                            يتم تسجيل بيانات المريض مع الحجز فقط.
                        </p>

                    </div>
                <?php endif; ?>


                <div class="mt-5">

                    <label class="field-label">
                        الخدمة
                    </label>

                    <select name="service" id="booking-service"
                        class="field-select mt-2 <?php $__errorArgs = ['service'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

                        <option value="">
                            اختر الخدمة
                        </option>

                        <option value="كشف" <?php if(old('service') === 'كشف'): echo 'selected'; endif; ?>>
                            كشف
                        </option>

                        <option value="استشارة" <?php if(old('service') === 'استشارة'): echo 'selected'; endif; ?>>
                            استشارة
                        </option>

                        <option value="متابعة" <?php if(old('service') === 'متابعة'): echo 'selected'; endif; ?>>
                            متابعة
                        </option>

                        <option value="إعادة كشف" <?php if(old('service') === 'إعادة كشف'): echo 'selected'; endif; ?>>
                            إعادة كشف
                        </option>

                        <option value="إجراء آخر" <?php if(old('service') === 'إجراء آخر'): echo 'selected'; endif; ?>>
                            إجراء آخر
                        </option>

                    </select>

                    <?php $__errorArgs = ['service'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="bq-field-error">

                            <i data-lucide="circle-alert"></i>

                            <span>
                                <?php echo e($message); ?>

                            </span>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                </div>


                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-3">

                    <div>

                        <label class="field-label">
                            التاريخ
                        </label>

                        <input name="appointment_date" id="booking-date" type="date"
                            class="field-input mt-2 <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            value="<?php echo e(old('appointment_date', today()->format('Y-m-d'))); ?>" required>

                        <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    <?php echo e($message); ?>

                                </span>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    <div>

                        <label class="field-label">
                            السعر
                        </label>

                        <input name="price" id="booking-price" type="number" min="0" step="0.01"
                            class="field-input mt-2 <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            value="<?php echo e(old('price', 0)); ?>" required>

                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    <?php echo e($message); ?>

                                </span>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    <div>

                        <label class="field-label">
                            المبلغ المدفوع
                        </label>

                        <input name="paid" id="booking-paid" type="number" min="0" step="0.01"
                            class="field-input mt-2 <?php $__errorArgs = ['paid'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('paid', 0)); ?>"
                            required>

                        <?php $__errorArgs = ['paid'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="bq-field-error">

                                <i data-lucide="circle-alert"></i>

                                <span>
                                    <?php echo e($message); ?>

                                </span>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                </div>


                <div class="bq-pay-row mt-5">

                    <div>

                        <span class="text-sm text-muted-foreground">
                            إجمالي الحجز
                        </span>

                        <strong id="booking-total-preview" class="text-foreground">
                            <?php echo e(number_format((float) old('price', 0), 2)); ?> ج.م
                        </strong>

                    </div>


                    <div>

                        <span class="text-sm text-muted-foreground">
                            المدفوع
                        </span>

                        <strong id="booking-paid-preview" class="text-success">
                            <?php echo e(number_format((float) old('paid', 0), 2)); ?> ج.م
                        </strong>

                    </div>


                    <div>

                        <span class="text-sm text-muted-foreground">
                            المتبقي
                        </span>

                        <strong id="booking-remaining-preview" class="text-warning">

                            <?php echo e(number_format(max(0, (float) old('price', 0) - (float) old('paid', 0)), 2)); ?>


                            ج.م

                        </strong>

                    </div>

                </div>


                <div class="bq-modal-footer">

                    <button type="button" class="btn btn-ghost" data-modal-close>
                        إلغاء
                    </button>

                    <button type="submit" class="btn btn-default btn-submit">

                        <i data-lucide="calendar-plus" class="h-4 w-4"></i>

                        حفظ الحجز

                    </button>

                </div>

            </form>

        </div>

    </div>


    

    <div id="edit-service-modal" class="modal-overlay">

        <div class="modal-panel max-w-lg modal-panel--edit">

            <div class="modal-head">

                <span class="modal-head__icon">
                    <i data-lucide="clipboard-list" class="h-5 w-5"></i>
                </span>

                <div class="min-w-0 flex-1">

                    <h3 class="modal-head__title">
                        تحديد الخدمة
                    </h3>

                    <p id="edit-service-patient" class="modal-head__sub"></p>

                </div>


                <button type="button" class="btn btn-icon" data-modal-close>

                    <i data-lucide="x" class="h-5 w-5"></i>

                </button>

            </div>


            <form method="POST" id="edit-service-form">

                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>


                <div>

                    <label class="field-label">
                        الخدمة
                    </label>

                    <select name="service" id="edit-service-select"
                        class="field-select mt-2 <?php $__errorArgs = ['service', 'service'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

                        <option value="">
                            لم تحدد
                        </option>

                        <option value="كشف">
                            كشف
                        </option>

                        <option value="استشارة">
                            استشارة
                        </option>

                        <option value="متابعة">
                            متابعة
                        </option>

                        <option value="إعادة كشف">
                            إعادة كشف
                        </option>

                        <option value="إجراء آخر">
                            إجراء آخر
                        </option>

                    </select>

                    <?php $__errorArgs = ['service', 'service'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="bq-field-error">

                            <i data-lucide="circle-alert"></i>

                            <span>
                                <?php echo e($message); ?>

                            </span>

                        </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                </div>


                <p class="mt-3 text-xs text-muted-foreground">
                    يمكنك تحديد الخدمة الآن حتى لو لم يحددها المريض عند الحجز.
                </p>


                <div class="bq-modal-footer">

                    <button type="button" class="btn btn-ghost" data-modal-close>
                        إلغاء
                    </button>


                    <button type="submit" class="btn btn-primary btn-submit">

                        <i data-lucide="save" class="h-4 w-4"></i>

                        حفظ الخدمة

                    </button>

                </div>

            </form>

        </div>

    </div>



    <?php if (isset($component)) { $__componentOriginalfa971874f0cc23530af77fd742593001 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa971874f0cc23530af77fd742593001 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.edit-payment-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.edit-payment-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa971874f0cc23530af77fd742593001)): ?>
<?php $attributes = $__attributesOriginalfa971874f0cc23530af77fd742593001; ?>
<?php unset($__attributesOriginalfa971874f0cc23530af77fd742593001); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa971874f0cc23530af77fd742593001)): ?>
<?php $component = $__componentOriginalfa971874f0cc23530af77fd742593001; ?>
<?php unset($__componentOriginalfa971874f0cc23530af77fd742593001); ?>
<?php endif; ?>

    

    <div id="cancel-booking-modal" class="modal-overlay">

        <div class="modal-panel max-w-lg">

            <div class="bq-modal-header">

                <div>

                    <h3 class="text-lg font-bold text-foreground">
                        إلغاء الحجز
                    </h3>

                    <p class="mt-1 text-sm text-muted-foreground">
                        هل تريد إلغاء هذا الحجز؟
                    </p>

                </div>


                <button type="button" class="btn btn-icon" data-modal-close>

                    <i data-lucide="x" class="h-5 w-5"></i>

                </button>

            </div>


            <div class="rounded-xl border border-destructive/20 bg-destructive/5 p-4">

                <div class="flex items-start gap-3">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-destructive/10 text-destructive">

                        <i data-lucide="triangle-alert" class="h-5 w-5"></i>

                    </div>


                    <div>

                        <p class="font-semibold text-foreground">
                            تأكيد إلغاء الحجز
                        </p>

                        <p id="cancel-booking-text" class="mt-1 text-sm leading-6 text-muted-foreground"></p>

                    </div>

                </div>

            </div>


            <div class="bq-modal-footer">

                <button type="button" class="btn btn-ghost" data-modal-close>
                    رجوع
                </button>


                <form method="POST" id="cancel-booking-form">

                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <button type="submit" class="btn btn-destructive">

                        <i data-lucide="trash-2" class="h-4 w-4"></i>

                        إلغاء الحجز

                    </button>

                </form>

            </div>

        </div>

    </div>


    <div id="toast-container" class="bq-toast-wrap"></div>


    <?php $__env->startPush('extra_java'); ?>
        <?php
            // الرسائل المباشرة: لدكتور Clinic System ومساعديه الفعّالين بس
            $liveRole = $isClinicSystem
                ? \App\Models\ClinicMessage::roleFor(auth()->user(), auth()->user()->clinicDoctor())
                : null;

            $liveMessagesConfig = $liveRole
                ? [
                    'role' => $liveRole,
                    'indexUrl' => route('clinic.messages.index'),
                    'callUrlTemplate' => route('clinic.messages.call', ['booking' => '__BOOKING_ID__']),
                    'missingUrlTemplate' => route('clinic.messages.missing', ['booking' => '__BOOKING_ID__']),
                    'resolveUrlTemplate' => route('clinic.messages.resolve', ['message' => '__MESSAGE_ID__']),
                    'deleteUrlTemplate' => route('clinic.messages.destroy', ['message' => '__MESSAGE_ID__']),
                ]
                : null;
        ?>

        <script>
            window.BookingPageConfig = {
                csrfToken: <?php echo json_encode(csrf_token(), 15, 512) ?>,
                isClinicSystem: <?php echo json_encode((bool) $isClinicSystem, 15, 512) ?>,
                queueDataUrl: <?php echo json_encode(route('clinic.queue.data'), 15, 512) ?>,
                patientSearchUrl: <?php echo json_encode(route('clinic.bookings.patients.search'), 15, 512) ?>,
                callUrlTemplate: <?php echo json_encode(route('clinic.bookings.call', ['booking' => '__BOOKING_ID__']), 512) ?>,
                startUrlTemplate: <?php echo json_encode(route('clinic.bookings.start', ['booking' => '__BOOKING_ID__']), 512) ?>,
                finishUrlTemplate: <?php echo json_encode(route('clinic.bookings.finish', ['booking' => '__BOOKING_ID__']), 512) ?>,
                serviceUrlTemplate: <?php echo json_encode(route('clinic.bookings.update-service', ['booking' => '__BOOKING_ID__']), 512) ?>,
                bookingsBaseUrl: <?php echo json_encode(url('/clinic/bookings'), 15, 512) ?>,
                patientMode: <?php echo json_encode(old('new_patient_name') || old('patient_phone') ? 'new' : 'existing', 15, 512) ?>,
                hasNewBookingErrors: <?php echo json_encode($errors->any() && !$errors->payment->any() && !$errors->service->any(), 15, 512) ?>,
                hasPaymentErrors: <?php echo json_encode($errors->payment->any(), 15, 512) ?>,
                hasServiceErrors: <?php echo json_encode($errors->service->any(), 15, 512) ?>,
                liveMessages: <?php echo json_encode($liveMessagesConfig, 15, 512) ?>,
            };
        </script>


        <script src="<?php echo e(asset('js/clinic/booking-index.js')); ?>"></script>

        <?php if($liveMessagesConfig): ?>
            <script src="<?php echo e(asset('js/clinic/live-messages.js')); ?>"></script>
        <?php endif; ?>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('doctor.layouts.app_clinc', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/booking/index.blade.php ENDPATH**/ ?>
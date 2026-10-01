<?php $__env->startSection('title', 'لوحة التحكم | دليل الأطباء'); ?>

<?php $__env->startSection('content'); ?>


    <div class="dashboard-content">

        
        <div class="welcome-row">

            <div class="welcome-text">

                <h2>
                    أهلاً <?php echo e(\Illuminate\Support\Facades\Auth::user()->name ?? 'admin'); ?> 👋
                </h2>

                <p>
                    إليك ملخص حالة موقع دليل الأطباء اليوم
                </p>

            </div>

            <div class="date-box">

                <i class="fa-regular fa-calendar"></i>

                <?php echo e(\Carbon\Carbon::now()->translatedFormat('l d F')); ?>


            </div>

        </div>


        
        <div class="stats-grid">

            
            <div class="stat-card">

                <div class="stat-icon blue-icon">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>

                <div class="stat-info">

                    <p>
                        إجمالي الأطباء
                    </p>

                    <h3>
                        <?php echo e($totalDoctors); ?>

                    </h3>

                    <span class="stat-change up">

                        <i class="fa-solid fa-arrow-up"></i>

                        <?php echo e($totalDoctorsThisMonth); ?> طبيب هذا الشهر

                    </span>

                </div>

            </div>


            
            <div class="stat-card">

                <div class="stat-icon orange-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>

                <div class="stat-info">

                    <p>
                        طلبات الإضافة
                    </p>

                    <h3>
                        <?php echo e($totalDoctorpending); ?>

                    </h3>

                </div>

            </div>


            
            <div class="stat-card">

                <div class="stat-icon green-icon">
                    <i class="fa-regular fa-eye"></i>
                </div>

                <div class="stat-info">

                    <p>
                        زيارات الموقع
                    </p>

                    <h3>
                        48,920
                    </h3>

                </div>

            </div>


            
            <div class="stat-card">

                <div class="stat-icon purple-icon">
                    <i class="fa-solid fa-user-check"></i>
                </div>

                <div class="stat-info">

                    <p>
                        الأطباء المشتركون
                    </p>

                    <h3>
                        <?php echo e($subscribedDoctors); ?>

                    </h3>

                    <span class="stat-change up">

                        <i class="fa-solid fa-arrow-up"></i>

                        <?php echo e($subscribedDoctorsThisMonth); ?> أطباء اشتركوا هذا الشهر

                    </span>

                </div>

            </div>

        </div>


        
        <div class="dashboard-grid">

            
            <div class="dashboard-card requests-card">

                <div class="card-header">

                    <div>

                        <h3>
                            طلبات إضافة الأطباء
                        </h3>

                        <p>
                            طلبات جديدة تحتاج إلى مراجعة
                        </p>

                    </div>

                    <?php if($pendingDoctor->isNotEmpty()): ?>
                        <a href="<?php echo e(route('admin.pending_doctors.index')); ?>" class="card-link">

                            عرض كل الطلبات

                            <i class="fa-solid fa-arrow-left"></i>

                        </a>
                    <?php endif; ?>

                </div>


                <?php if($pendingDoctor->isNotEmpty()): ?>

                    <div class="doctor-pending-table-wrapper">

                        <table class="doctor-pending-table">

                            <thead>

                                <tr>

                                    <th>
                                        الطبيب
                                    </th>

                                    <th>
                                        التخصص
                                    </th>

                                    <th>
                                        المحافظة
                                    </th>

                                    <th>
                                        تاريخ الطلب
                                    </th>

                                    <th>
                                        الحالة
                                    </th>

                                    <th>
                                        الإجراءات
                                    </th>

                                </tr>

                            </thead>

                            <tbody id="requestsBody">

                                <?php $__currentLoopData = $pendingDoctor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($doctor->id); ?>" data-name="<?php echo e($doctor->user->name); ?>"
                                        data-phone="<?php echo e($doctor->phone); ?>" data-specialty="<?php echo e($doctor->specialty->name); ?>"
                                        data-area="<?php echo e($doctor->area?->name ?? 'لم تحدد'); ?>" data-status="قيد المراجعة">

                                        
                                        <td>

                                            <div class="doctor-pending-doctor-info">

                                                <div class="doctor-pending-avatar">

                                                    <?php if($doctor->doctor_image): ?>
                                                        <img src="<?php echo e(asset('storage/' . $doctor->doctor_image)); ?>"
                                                            alt="صورة الطبيب">
                                                    <?php else: ?>
                                                        <i class="fa-solid fa-user-doctor"></i>
                                                    <?php endif; ?>

                                                </div>

                                                <div>

                                                    <div class="doctor-pending-name">

                                                        د. <?php echo e($doctor->user->name); ?>


                                                    </div>

                                                    <div class="doctor-pending-phone">

                                                        <?php echo e($doctor->phone); ?>


                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        
                                        <td>

                                            <span class="doctor-pending-specialty">

                                                <?php echo e($doctor->specialty->name); ?>


                                            </span>

                                        </td>


                                        
                                        <td>

                                            <?php echo e($doctor->area->name); ?>


                                        </td>


                                        
                                        <td>

                                            <span class="doctor-pending-date">

                                                <?php echo e($doctor->created_at->translatedFormat('d F Y')); ?>


                                            </span>

                                        </td>


                                        
                                        <td>

                                            <span class="doctor-pending-status">

                                                <i class="fa-solid fa-clock"></i>

                                                <?php echo e($doctor->subscription?->plan_id == 1 ? 'لم يشترك' : 'اشتراك منتهي'); ?>


                                            </span>

                                        </td>


                                        
                                        <td>

                                            <div class="doctor-pending-actions">

                                                
                                                <button type="button" class="doctor-pending-action view"
                                                    title="عرض التفاصيل">

                                                    <i class="fa-solid fa-eye"></i>

                                                </button>


                                                
                                                <form action="<?php echo e(route('admin.doctor_pending.approve', $doctor->id)); ?>"
                                                    method="POST"
                                                    onsubmit="return confirm('هل أنت متأكد من إضافة الدكتور وظهوره في الموقع؟')">

                                                    <?php echo csrf_field(); ?>

                                                    <button type="submit" class="doctor-pending-action accept"
                                                        title="قبول ظهور الطبيب">

                                                        <i class="fa-solid fa-check"></i>

                                                    </button>

                                                </form>


                                                
                                                <form action="<?php echo e(route('admin.doctor_pending.reject', $doctor->id)); ?>"
                                                    method="POST"
                                                    onsubmit="return confirm('هل أنت متأكد من رفض طلب إضافة الدكتور؟')">

                                                    <?php echo csrf_field(); ?>

                                                    <button type="submit" class="doctor-pending-action reject"
                                                        title="رفض">

                                                        <i class="fa-solid fa-xmark"></i>

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>

                        </table>

                    </div>
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-user-doctor','title' => 'لا توجد طلبات إضافة حاليًا','content' => 'لم يتم العثور على أطباء في انتظار المراجعة']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-user-doctor','title' => 'لا توجد طلبات إضافة حاليًا','content' => 'لم يتم العثور على أطباء في انتظار المراجعة']); ?>
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

            </div>


            
            <?php if((int) $totalDoctors > 0): ?>

                <div class="dashboard-card">

                    <div class="card-header">

                        <div>

                            <h3>
                                توزيع الأطباء
                            </h3>

                            <p>
                                حسب التخصصات
                            </p>

                        </div>

                    </div>


                    <div class="specialties-content">

                        
                        <div class="doughnut-box">

                            <canvas id="specialtiesChart"></canvas>

                            <div class="chart-center">

                                <strong>
                                    <?php echo e($totalDoctors); ?>

                                </strong>

                                <span>
                                    طبيب
                                </span>

                            </div>

                        </div>


                        
                        <div class="specialties-list">

                            <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="specialty-row">

                                    <div class="specialty-name">

                                        <span
                                            class="specialty-color <?php echo e(['blue-color', 'green-color', 'orange-color', 'purple-color'][$index] ?? 'other-color'); ?>"></span>

                                        <?php echo e($specialty->specialty?->name ?? 'تخصص غير محدد'); ?>


                                    </div>

                                    <strong>
                                        <?php echo e($specialty->total); ?>

                                    </strong>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            <?php if($otherDoctors > 0): ?>
                                <div class="specialty-row">

                                    <div class="specialty-name">

                                        <span class="specialty-color other-color"></span>

                                        تخصصات أخرى

                                    </div>

                                    <strong>
                                        <?php echo e($otherDoctors); ?>

                                    </strong>

                                </div>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>
            <?php else: ?>
                <div class="dashboard-card">

                    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء حاليًا','content' => 'لم يتم العثور على أطباء لعرض توزيع التخصصات']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء حاليًا','content' => 'لم يتم العثور على أطباء لعرض توزيع التخصصات']); ?>
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

            <?php endif; ?>

        </div>


        
        <div class="bottom-grid">


            
            <div class="dashboard-card reviews-card doctor-latest-reviews">

                <div class="reviews-header doctor-reviews-header">

                    <div class="reviews-header-content">

                        <h3>
                            آخر التقييمات
                        </h3>

                        <p>
                            أحدث تقييمات المرضى للأطباء
                        </p>

                    </div>

                    <a href="<?php echo e(route('ratings.index')); ?>" class="reviews-card-link">

                        <span>
                            عرض الكل
                        </span>

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>

                </div>


                <div class="doctor-reviews-list">

                    <?php $__empty_1 = true; $__currentLoopData = $latestRatings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <article class="doctor-review-item">


                            
                            <div class="doctor-review-patient">

                                <div class="doctor-review-avatar">

                                    <?php echo e(mb_substr($rating->user->name ?? 'م', 0, 1)); ?>


                                </div>

                                <div class="doctor-review-patient-info">

                                    <strong>
                                        <?php echo e($rating->user->name ?? 'مستخدم غير معروف'); ?>

                                    </strong>

                                    <span>
                                        <?php echo e($rating->created_at?->diffForHumans() ?? 'ليس له وقت انشاء'); ?>

                                    </span>

                                </div>

                            </div>


                            
                            <div class="doctor-review-content">

                                <div class="doctor-review-heading">

                                    <div class="doctor-review-doctor">

                                        <strong>
                                            د. <?php echo e($rating->doctor->user->name ?? 'طبيب غير معروف'); ?>

                                        </strong>

                                        <span>
                                            تقييم للطبيب
                                        </span>

                                    </div>


                                    <?php
                                        $ratingValue = (int) $rating->rating;
                                    ?>

                                    <div class="doctor-review-stars" aria-label="التقييم <?php echo e($ratingValue); ?> من 5">

                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $ratingValue): ?>
                                                <i class="fa-solid fa-star doctor-star-filled"></i>
                                            <?php else: ?>
                                                <i class="fa-regular fa-star doctor-star-empty"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>

                                    </div>

                                </div>


                                
                                <div class="doctor-review-comment-area">

                                    <span class="doctor-review-comment-label">
                                        التعليق
                                    </span>

                                    <?php if($rating->comment): ?>
                                        <p class="doctor-review-comment-text">
                                            <?php echo e($rating->comment); ?>

                                        </p>
                                    <?php else: ?>
                                        <p class="doctor-review-comment-empty">
                                            لا يوجد تعليق
                                        </p>
                                    <?php endif; ?>

                                </div>

                            </div>


                            
                            <div class="doctor-review-actions">

                                <a href="<?php echo e(route('ratings.edit', $rating->id)); ?>" class="doctor-review-edit-btn"
                                    title="تعديل التقييم">

                                    <i class="fa-regular fa-pen-to-square"></i>

                                    <span>
                                        تعديل
                                    </span>

                                </a>


                                <form action="<?php echo e(route('ratings.destroy', $rating->id)); ?>" method="POST"
                                    class="doctor-review-delete-form"
                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟')">

                                    <?php echo csrf_field(); ?>

                                    <?php echo method_field('DELETE'); ?>

                                    <button type="submit" class="doctor-review-delete-btn" title="حذف التقييم">

                                        <i class="fa-regular fa-trash-can"></i>

                                        <span>
                                            حذف
                                        </span>

                                    </button>

                                </form>

                            </div>

                        </article>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-star','title' => 'لا توجد تقييمات حتى الآن','content' => 'لم يتم العثور على تقييمات حاليًا']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-star','title' => 'لا توجد تقييمات حتى الآن','content' => 'لم يتم العثور على تقييمات حاليًا']); ?>
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

                </div>

            </div>


            
            <div class="dashboard-card subscriptions-card">

                <div class="card-header">

                    <div>

                        <h3>
                            اشتراكات قربت تخلص
                        </h3>

                        <p>
                            تحتاج متابعة أو تجديد
                        </p>

                    </div>

                    <a href="<?php echo e(route('admin.subscribed_doctors.index')); ?>" class="card-link">

                        عرض الكل

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>

                </div>


                <div class="subscriptions-list">

                    <?php $__empty_1 = true; $__currentLoopData = $expiringDoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="subscription-item">


                            
                            <div class="subscription-doctor">

                                <div class="subscription-avatar">

                                    <?php echo e(mb_substr($doctor?->user?->name ?? 'ط', 0, 1)); ?>


                                </div>

                                <div>

                                    <strong>
                                        د.<?php echo e($doctor?->user?->name ?? 'طبيب'); ?>

                                    </strong>

                                    <span>
                                        <?php echo e($doctor->specialty?->name ?? 'بدون تخصص'); ?>

                                    </span>

                                </div>

                            </div>


                            
                            <div class="subscription-date">

                                <span class="days danger-days">

                                    متبقي <?php echo e($doctor->remaining_days); ?> يوم

                                </span>

                            </div>


                            
                            <a href="<?php echo e(route('admin.doctor.edit', $doctor->id)); ?>"
                                class="doctor-pending-action edit-btn" title="تجديد الطبيب">

                                <span>
                                    تجديد
                                </span>

                            </a>

                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-calendar-check','title' => 'لا توجد اشتراكات قاربت على الانتهاء','content' => 'لم يتم العثور على أطباء قاربت اشتراكاتهم على الانتهاء']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-calendar-check','title' => 'لا توجد اشتراكات قاربت على الانتهاء','content' => 'لم يتم العثور على أطباء قاربت اشتراكاتهم على الانتهاء']); ?>
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

                </div>

            </div>

        </div>

    </div>


    
    <?php if (isset($component)) { $__componentOriginal18f92e20fcf6134528f9202ba4a51344 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18f92e20fcf6134528f9202ba4a51344 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.doctor_pending_modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.doctor_pending_modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18f92e20fcf6134528f9202ba4a51344)): ?>
<?php $attributes = $__attributesOriginal18f92e20fcf6134528f9202ba4a51344; ?>
<?php unset($__attributesOriginal18f92e20fcf6134528f9202ba4a51344); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18f92e20fcf6134528f9202ba4a51344)): ?>
<?php $component = $__componentOriginal18f92e20fcf6134528f9202ba4a51344; ?>
<?php unset($__componentOriginal18f92e20fcf6134528f9202ba4a51344); ?>
<?php endif; ?>


<?php $__env->stopSection(); ?>



<script>
    window.specialtiesData = <?php echo json_encode($specialties, 15, 512) ?>;

    window.otherDoctors = <?php echo e($otherDoctors); ?>;
</script>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'الإشعارات | لوحة تحكم الطبيب'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/notifications.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/no_results.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <main class="doctor-notifications-page">

        <div class="notifications-container">

            
            <div class="notifications-header">

                <div class="notifications-title">

                    <div class="notifications-title-icon">
                        <i class="fa-solid fa-bell"></i>
                    </div>

                    <div>
                        <h1>الإشعارات</h1>
                        <p>تابع آخر التنبيهات والتحديثات الخاصة بحسابك</p>
                    </div>

                </div>


                <div class="notifications-header-actions">

                    <div class="notifications-count">
                        <?php echo e($notifications->total()); ?> إشعار
                    </div>

                    <?php if($notifications->total() > 0): ?>
                        <form action="<?php echo e(route('doctor.notifications.destroyAll')); ?>" method="POST"
                            onsubmit="return confirm('هل أنت متأكد من حذف جميع الإشعارات؟');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button type="submit" class="delete-all-notifications">
                                <i class="fa-solid fa-trash-can"></i>
                                حذف الكل
                            </button>

                        </form>
                    <?php endif; ?>

                </div>

            </div>


            
            <div class="notifications-list">

                <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="notification-card-wrapper">

                        <a href="<?php echo e(route('doctor.notifications.read', $notification->id)); ?>"
                            class="notification-card <?php echo e(!$notification->is_read ? 'unread' : ''); ?>">

                            <div class="notification-icon">

                                <?php if($notification->type === 'rating'): ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php elseif($notification->type === 'subscription'): ?>
                                    <i class="fa-solid fa-crown"></i>
                                <?php elseif($notification->type === 'profile'): ?>
                                    <i class="fa-solid fa-user-doctor"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-bell"></i>
                                <?php endif; ?>

                            </div>


                            <div class="notification-content">

                                <div class="notification-top">

                                    <h3>
                                        <?php echo e($notification->title); ?>

                                    </h3>

                                    <?php if(!$notification->is_read): ?>
                                        <span class="notification-new">
                                            جديد
                                        </span>
                                    <?php endif; ?>

                                </div>


                                <p>
                                    <?php echo e($notification->message); ?>

                                </p>


                                <span class="notification-time">

                                    <i class="fa-regular fa-clock"></i>

                                    <?php echo e($notification->created_at->diffForHumans()); ?>


                                </span>

                            </div>


                            <div class="notification-arrow">

                                <i class="fa-solid fa-chevron-left"></i>

                            </div>

                        </a>


                        
                        <form action="<?php echo e(route('doctor.notifications.destroy', $notification->id)); ?>" method="POST"
                            class="delete-notification-form" onsubmit="return confirm('هل تريد حذف هذا الإشعار؟');">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button type="submit" class="delete-notification-btn" title="حذف الإشعار">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>

                        </form>

                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-bell','title' => 'أنت على اطلاع بكل شيء','content' => 'لا توجد إشعارات جديدة حاليًا. سنخبرك هنا بأي تحديث مهم يخص حسابك أو ملفك الطبي.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-bell','title' => 'أنت على اطلاع بكل شيء','content' => 'لا توجد إشعارات جديدة حاليًا. سنخبرك هنا بأي تحديث مهم يخص حسابك أو ملفك الطبي.']); ?>
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


            
            <?php if($notifications->hasPages()): ?>
                <div class="notifications-pagination">
                    <?php echo e($notifications->links()); ?>

                </div>
            <?php endif; ?>

        </div>

    </main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/dashboard/notifications/index.blade.php ENDPATH**/ ?>
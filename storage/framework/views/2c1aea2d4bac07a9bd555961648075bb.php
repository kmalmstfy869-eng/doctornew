<div class="profile-page">


    

    <div class="profile-back">

        <a href="<?php echo e(route($link)); ?>" class="profile-back-btn">

            <i class="fa-solid fa-arrow-right"></i>

            رجوع

        </a>

    </div>


    

    <div class="profile-page-header">

        <div class="profile-header-icon">

            <i class="fa-solid fa-user-gear"></i>

        </div>

        <div class="profile-header-content">

            <h1>
                إعدادات الحساب
            </h1>

            <p>
                إدارة بيانات حسابك وإعدادات الأمان
            </p>

        </div>

    </div>


    

    <div class="profile-container">


        

        <section class="profile-section profile-information-card">

            <div class="profile-section-icon">

                <i class="fa-solid fa-user-pen"></i>

            </div>

            <div class="profile-section-content">

                <?php echo $__env->make('settings.sections.personal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            </div>

        </section>



        

        <?php if(isset($jobs)): ?>
            <section class="profile-section profile-jobs-card">

                <div class="profile-section-icon">

                    <i class="fa-solid fa-briefcase"></i>

                </div>

                <div class="profile-section-content">

                    <?php echo $__env->make('settings.sections.jobs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                </div>

            </section>
        <?php endif; ?>



        

        <?php if(isset($favorites)): ?>
            <section class="profile-section profile-favorites-card">

                <div class="profile-section-icon">

                    <i class="fa-solid fa-heart"></i>

                </div>

                <div class="profile-section-content">

                    <?php echo $__env->make('settings.sections.favorites', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                </div>

            </section>
        <?php endif; ?>





        

        <?php if(isset($flagnotifications)): ?>
            <section class="profile-section profile-notifications-control-card">

                <div class="notifications-control-content">

                    

                    <div class="notifications-control-info">

                        <div class="notifications-control-icon">

                            <i class="fa-solid fa-bell"></i>

                        </div>


                        <div class="notifications-control-text">

                            <span class="notifications-control-label">
                                الإشعارات
                            </span>

                            <h2>
                                التحكم في إشعارات الحساب
                            </h2>

                            <p id="notificationsStatus">
                                <?php echo e($flagnotifications ? 'الإشعارات مفعلة حاليًا.' : 'الإشعارات متوقفة حاليًا.'); ?>

                            </p>

                        </div>

                    </div>


                    

                    <div class="notifications-toggle-wrapper">

                        <span class="notifications-toggle-status" id="notificationsToggleStatus">
                            <?php echo e($flagnotifications ? 'مفعلة' : 'متوقفة'); ?>

                        </span>


                        <button type="button" id="notificationsToggle"
                            class="notifications-toggle <?php echo e($flagnotifications ? 'is-active' : ''); ?>"
                            aria-label="تفعيل أو إيقاف إشعارات المتصفح"
                            aria-pressed="<?php echo e($flagnotifications ? 'true' : 'false'); ?>"
                            data-active="<?php echo e($flagnotifications ? '1' : '0'); ?>">

                            <span class="notifications-toggle-track"></span>

                            <span class="notifications-toggle-thumb">

                                <i class="fa-solid fa-bell"></i>

                            </span>

                        </button>

                    </div>

                </div>

            </section>
        <?php endif; ?>



        

        <section class="profile-section profile-password-card">

            <div class="profile-section-icon">

                <i class="fa-solid fa-lock"></i>

            </div>

            <div class="profile-section-content">

                <?php echo $__env->make('settings.sections.password', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            </div>

        </section>



        

        <section class="profile-section profile-delete-card">

            <div class="profile-section-icon">

                <i class="fa-solid fa-user-xmark"></i>

            </div>

            <div class="profile-section-content">

                <?php echo $__env->make('settings.sections.delete-account', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            </div>

        </section>


    </div>


</div>




<?php if(isset($flagnotifications)): ?>
    <script>
        window.pushConfig = {

            controllerActive: <?php echo json_encode($flagnotifications ?? false, 15, 512) ?>,

            vapidPublicKey: <?php echo json_encode(config('webpush.vapid.public_key'), 15, 512) ?>,

            statusUrl: <?php echo json_encode(route('doctor.push-subscription.status'), 15, 512) ?>,

            subscribeUrl: <?php echo json_encode(route('doctor.push-subscription.store'), 15, 512) ?>,

            disableUrl: <?php echo json_encode(route('doctor.push-subscription.disable'), 15, 512) ?>,

            csrfToken: <?php echo json_encode(csrf_token(), 15, 512) ?>,

        };
    </script>
<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/settings/index.blade.php ENDPATH**/ ?>
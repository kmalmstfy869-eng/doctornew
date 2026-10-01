<section class="welcome">

    <?php if($isSubscribed): ?>
        

        <div class="welcome-main">

            <div class="welcome-content">

                
                <div class="welcome-header">

                    <div class="welcome-label">
                        ✦ حسابك يعمل بشكل ممتاز
                    </div>

                    <div class="welcome-status <?php echo e($isExpiringSoon ? 'welcome-status-warning' : ''); ?>">
                        <i></i>
                        <?php echo e($subscriptionStatus); ?>

                    </div>

                </div>


                
                <h1>
                    أهلاً بك، د. <?php echo e($doctorName); ?>

                </h1>

                <p>
                    ملفك الطبي أصبح أقوى، وظهورك أمام المرضى
                    في تحسن مستمر. تابع أداء صفحتك وطوّر
                    حضورك الطبي من مكان واحد.
                </p>


                
                <div class="welcome-subscription-summary">

                    
                    <div class="welcome-summary-item">

                        <div class="welcome-summary-icon">
                            ♛
                        </div>

                        <div class="welcome-summary-content">

                            <span>
                                الباقة الحالية
                            </span>

                            <strong>
                                <?php echo e($planName); ?>

                            </strong>

                        </div>

                    </div>


                    
                    <div class="welcome-summary-item">

                        <div class="welcome-summary-icon">
                            ◷
                        </div>

                        <div class="welcome-summary-content">

                            <span>
                                صلاحية الاشتراك
                            </span>

                            <strong>
                                <?php echo e($remainingDaysText); ?>

                            </strong>

                        </div>

                    </div>


                    
                    <div class="welcome-summary-item">

                        <div class="welcome-summary-icon">
                            ✓
                        </div>

                        <div class="welcome-summary-content">

                            <span>
                                حالة الاشتراك
                            </span>

                            <strong>
                                <?php echo e($subscriptionStatus); ?>

                            </strong>

                        </div>

                    </div>

                </div>


                
                <div class="welcome-statistics">

                    
                    <div class="welcome-stat">

                        <div class="welcome-stat-icon">
                            ◉
                        </div>

                        <div class="welcome-stat-info">

                            <span>
                                مشاهدات الملف
                            </span>

                            <strong>
                                0
                            </strong>

                        </div>

                    </div>


                    
                    <div class="welcome-stat">

                        <div class="welcome-stat-icon">
                            ★
                        </div>

                        <div class="welcome-stat-info">

                            <span>
                                تقييم المرضى
                            </span>

                            <strong>
                                <?php echo e($rating); ?>

                            </strong>

                        </div>

                    </div>


                    
                    <div class="welcome-stat">

                        <div class="welcome-stat-icon">
                            ♥
                        </div>

                        <div class="welcome-stat-info">

                            <span>
                                مرات الحفظ
                            </span>

                            <strong>
                                0
                            </strong>

                        </div>

                    </div>

                </div>


                
                <a href="PUT_YOUR_ROUTE_HERE" class="welcome-subscription-note welcome-subscription-btn">

                    <div class="welcome-subscription-icon">
                        ♛
                    </div>

                    <div class="welcome-subscription-text">

                        <strong>
                            راقب اشتراكك باستمرار
                        </strong>

                        <span>
                            تابع حالة باقتك ومدة صلاحيتها
                            واستفد من المميزات المتاحة لك.
                        </span>

                    </div>

                    <span class="welcome-subscription-arrow">
                        ←
                    </span>

                </a>

            </div>

        </div>


        



        <div class="doctor-profile-progress-card">

            <div class="doctor-profile-progress-head">

                <div class="doctor-profile-progress-heading">

                    <span class="doctor-profile-progress-eyebrow">
                        ملفك الطبي
                    </span>

                    <h3>
                        اكتمال الملف
                    </h3>

                    <p>
                        أكمل بيانات ملفك ليظهر للمرضى بصورة أفضل.
                    </p>

                </div>


                <div class="doctor-profile-progress-score">

                    <strong>
                        <?php echo e($completion); ?>%
                    </strong>

                    <span>
                        مكتمل
                    </span>

                </div>

            </div>


            <div class="doctor-profile-progress-track">

                <div class="doctor-profile-progress-fill" style="width: <?php echo e($completion); ?>%;">
                </div>

            </div>


            <div class="doctor-profile-progress-message">

                <span class="doctor-profile-progress-message-icon">
                    <?php echo e($completion == 100 ? '✓' : '✓'); ?>

                </span>

                <div>

                    <?php if($completion == 100): ?>
                        <strong>
                            ملفك مكتمل بالكامل
                        </strong>

                        <span>
                            رائع! ملفك الطبي جاهز بالكامل أمام المرضى.
                        </span>
                    <?php elseif($completion >= 85): ?>
                        <strong>
                            ملفك جيد جدًا
                        </strong>

                        <span>
                            تبقى بعض البيانات البسيطة لإكمال ملفك.
                        </span>
                    <?php else: ?>
                        <strong>
                            كمّل ملفك
                        </strong>

                        <span>
                            تبقى بعض البيانات لإكمال ملفك بالشكل الأمثل.
                        </span>
                    <?php endif; ?>

                </div>

            </div>


            <div class="doctor-profile-progress-list">

                <div class="doctor-profile-progress-item is-done">

                    <span class="doctor-profile-progress-check">
                        ✓
                    </span>

                    <span>
                        البيانات الأساسية
                    </span>

                </div>


                <div class="doctor-profile-progress-item is-done">

                    <span class="doctor-profile-progress-check">
                        ✓
                    </span>

                    <span>
                        التخصص
                    </span>

                </div>


                <div class="doctor-profile-progress-item is-done">

                    <span class="doctor-profile-progress-check">
                        ✓
                    </span>

                    <span>
                        العنوان
                    </span>

                </div>


                <div class="doctor-profile-progress-item is-done">

                    <span class="doctor-profile-progress-check">
                        ✓
                    </span>

                    <span>
                        مواعيد العمل
                    </span>

                </div>


                <div class="doctor-profile-progress-item <?php echo e($hasClinicPhotos ? 'is-done' : ''); ?>">

                    <span class="doctor-profile-progress-check">
                        <?php echo e($hasClinicPhotos ? '✓' : '+'); ?>

                    </span>

                    <span>
                        صور العيادة
                    </span>

                </div>


                <div class="doctor-profile-progress-item <?php echo e($hasProfilePhoto ? 'is-done' : ''); ?>">

                    <span class="doctor-profile-progress-check">
                        <?php echo e($hasProfilePhoto ? '✓' : '+'); ?>

                    </span>

                    <span>
                        الصورة الشخصية
                    </span>

                </div>

            </div>


            <?php if($completion < 100): ?>
                <a href="<?php echo e(route('doctor.profile.edit')); ?>" class="doctor-profile-progress-button">

                    <span>
                        إكمال الملف الطبي
                    </span>

                    <span class="doctor-profile-progress-arrow">
                        ←
                    </span>

                </a>
            <?php endif; ?>

        </div>
    <?php else: ?>
        

        <div class="welcome-main welcome-not-subscribed">

            <div class="welcome-content">

                <div class="welcome-label welcome-label-warning">
                    ✦ طوّر ظهورك الطبي
                </div>


                <h1>
                    أهلاً بك، د. <?php echo e($doctorName); ?>

                </h1>


                <p>
                    ملفك الطبي موجود على دليل الأطباء،
                    ويمكنك تطويره للحصول على ظهور أفضل
                    ومميزات أكثر أمام المرضى.
                </p>


                
                <div class="welcome-subscription-hint">

                    <div class="welcome-hint-icon">
                        ♛
                    </div>


                    <div class="welcome-hint-content">

                        <strong>
                            جاهز تخلي حسابك أقوى؟
                        </strong>

                        <span>
                            بالاشتراك تحصل على ظهور أفضل،
                            استقبال الحجوزات أونلاين،
                            ومع الباقات الأعلى يمكنك الحصول على
                            <b>نظام عيادة كامل</b>
                            لإدارة الحجوزات والمرضى والدخل من مكان واحد.
                        </span>

                    </div>

                </div>


                
                <a href="" class="welcome-subscribe-btn">

                    <span>
                        ابدأ الاشتراك الآن
                    </span>

                    <span class="welcome-subscribe-arrow">
                        ←
                    </span>

                </a>

            </div>

        </div>


        

        <div class="today-card today-card-not-subscribed">

            <div class="today-top">

                <div class="today-title">

                    <strong>
                        حسابك غير مشترك
                    </strong>

                    <span>
                        اشترك الآن واستفد من المميزات
                    </span>

                </div>


                <div class="subscription-status">

                    <i></i>

                    غير مشترك

                </div>

            </div>


            <div class="not-subscribed-content">

                <div class="not-subscribed-icon">
                    ♛
                </div>

                <div class="not-subscribed-text">

                    <strong>
                        اجعل ملفك الطبي أقوى
                    </strong>

                    <span>
                        الاشتراك يساعدك على تحسين ظهور ملفك
                        والاستفادة من المميزات المتاحة حسب الباقة.
                    </span>

                </div>

            </div>


            <a href="" class="welcome-subscribe-btn">

                <span>
                    عرض الباقات والاشتراك
                </span>

                <span>
                    ←
                </span>

            </a>

        </div>

    <?php endif; ?>

</section>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/dashboard/topbar.blade.php ENDPATH**/ ?>
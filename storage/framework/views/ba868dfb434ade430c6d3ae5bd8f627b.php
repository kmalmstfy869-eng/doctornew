<section class="welcome <?php echo e($isSubscribed ? '' : 'welcome-guest'); ?>">

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
                        <div class="welcome-stat-icon">◉</div>
                        <div class="welcome-stat-info">
                            <span>مشاهدات الملف</span>
                            <strong><?php echo e(number_format($profileViews)); ?></strong>
                            <small>من <?php echo e(number_format($uniqueVisitors)); ?> زائر مختلف</small>
                        </div>
                    </div>

                    <div class="welcome-stat">
                        <div class="welcome-stat-icon">★</div>
                        <div class="welcome-stat-info">
                            <span>تقييم المرضى</span>
                            <strong><?php echo e($rating); ?></strong>
                        </div>
                    </div>

                    <div class="welcome-stat">
                        <div class="welcome-stat-icon">♥</div>
                        <div class="welcome-stat-info">
                            <span>مرات الحفظ</span>
                            <strong><?php echo e(number_format($favoritesCount)); ?></strong>
                        </div>
                    </div>

                </div>

                
                
                <a href="<?php echo e(route('doctor.subscription')); ?>"
                    class="welcome-subscription-note welcome-subscription-btn">

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
        

        <div class="gx">
            <div class="gx-glow"></div>
            <div class="gx-dots"></div>

            
            <div class="gx-main">

                <span class="gx-label">✦ طوّر ظهورك الطبي</span>

                <h1>أهلاً بك، د. <?php echo e($doctorName); ?></h1>

                <p>ملفك ظاهر للمرضى الآن. هذه نظرة سريعة على اهتمامهم بملفك.</p>

                <div class="gx-stats">
                    <div class="gx-stat">
                        <span class="gx-stat-ico">◉</span>
                        <div>
                            <small>مشاهدات الملف</small>
                            <strong><?php echo e(number_format($profileViews)); ?></strong>
                            <em>من <?php echo e(number_format($uniqueVisitors)); ?> زائر مختلف</em>
                        </div>
                    </div>

                    <div class="gx-stat">
                        <span class="gx-stat-ico">♥</span>
                        <div>
                            <small>مرات الحفظ</small>
                            <strong><?php echo e(number_format($favoritesCount)); ?></strong>
                            <em>أضافوك إلى المفضلة</em>
                        </div>
                    </div>
                </div>

                <div class="gx-tip">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>الأطباء المشتركون يظهرون أولاً في نتائج البحث ويحصلون على مشاهدات وحجوزات أكثر.</span>
                </div>

            </div>

            
            <aside class="gx-offer">

                <div class="gx-offer-head">
                    <span class="gx-crown">♛</span>
                    <div>
                        <b>اجعل ملفك الأقوى</b>
                        <small>حسابك غير مشترك حالياً</small>
                    </div>
                </div>

                <ul class="gx-list">
                    <li>
                        <i class="fa-solid fa-circle-check"></i>
                        <span>ظهور أفضل وشارة <b>طبيب موثوق</b></span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check"></i>
                        <span>صورتك وتقييماتك وموقعك على الخريطة</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check"></i>
                        <span>حجز المواعيد أونلاين من ملفك</span>
                    </li>
                    <li class="is-top">
                        <i class="fa-solid fa-crown"></i>
                        <span>نظام عيادة كامل: حجوزات ومرضى ودخل</span>
                    </li>
                </ul>

                <a href="<?php echo e(route('doctor.subscription')); ?>" class="gx-btn">
                    <span>عرض الباقات والاشتراك</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <small class="gx-note">
                    <i class="fa-solid fa-shield-halved"></i> يمكنك الترقية في أي وقت
                </small>

            </aside>

        </div>
    <?php endif; ?>

</section>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/dashboard/topbar.blade.php ENDPATH**/ ?>
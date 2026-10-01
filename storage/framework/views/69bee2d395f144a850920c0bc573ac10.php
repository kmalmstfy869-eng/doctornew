<section class="subscription" id="subscription">

    <?php if($doctor && $doctor->hasFeature('subscription')): ?>

        

        <div class="subscription-main">

            <span class="sub-label">
                الاشتراك الحالي
            </span>


            <div class="sub-heading">

                <h2>
                    <?php echo e($plan?->name ?? 'اشتراك نشط'); ?>

                </h2>

                <span class="sub-status">
                    نشط
                </span>

            </div>


            <p class="sub-description">

                <?php if($planSlug && str_starts_with($planSlug, 'prime-')): ?>
                    اشتراك Prime يمنحك ظهورًا أفضل
                    ومعلومات أكثر عن الطبيب والعيادة.
                <?php elseif($planSlug && str_starts_with($planSlug, 'professional-')): ?>
                    اشتراك Professional يتيح لك
                    استقبال الحجوزات أونلاين وإدارتها.
                <?php elseif($planSlug && str_starts_with($planSlug, 'clinic-system-')): ?>
                    اشتراك Clinic System يمنحك
                    نظامًا متكاملًا لإدارة العيادة.
                <?php else: ?>
                    اشتراكك يمنحك مزايا إضافية
                    لإدارة حضورك على المنصة.
                <?php endif; ?>

            </p>


            <div class="sub-progress">

                <div class="sub-progress-head">

                    <span>
                        الفترة الحالية
                    </span>

                    <span>
                        من <?php echo e(number_format($totalDays, 1)); ?> يوم
                        — متبقي <?php echo e(number_format($remainingDays, 1)); ?> يوم
                    </span>

                </div>


                <div class="sub-progress-bar">

                    <div style="width: <?php echo e($progress); ?>%;"></div>

                </div>

            </div>


            <div class="sub-features">

                <?php $__currentLoopData = $plan?->features ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="sub-feature">
                        ✓ <?php echo e($feature); ?>

                    </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </div>


        <div class="subscription-side">

            <span class="expire-label">
                تاريخ التجديد
            </span>


            <div class="expire-date">
                <?php echo e($renewalDate ?? 'غير محدد'); ?>

            </div>


            <a href="#" class="upgrade-btn">
                إدارة الاشتراك
            </a>

        </div>
    <?php else: ?>
        

        <div class="subscription-main">

            <span class="sub-label">
                الاشتراك الحالي
            </span>


            <div class="sub-heading">

                <h2>
                    <?php echo e('free'); ?>

                </h2>

                <span class="sub-status free-status">
                    مجاني
                </span>

            </div>


            <p class="sub-description">

                أنت تستخدم الحساب المجاني حاليًا.
                اشترك الآن للحصول على ظهور أفضل
                ومزايا إضافية تساعدك في الوصول
                إلى المزيد من المرضى.

            </p>


            <div class="sub-features">

                <span class="sub-feature">
                    ✓ ملف طبي أساسي
                </span>

                <span class="sub-feature">
                    ✓ ظهور الطبيب في دليل الأطباء
                </span>

                <span class="sub-feature">
                    ✓ عرض بيانات التواصل ومواعيد العمل
                </span>

                <span class="sub-feature">
                    ✓ إمكانية الترقية إلى باقات متقدمة
                </span>


            </div>

        </div>


        <div class="subscription-side">

            <span class="expire-label">
                طوّر حسابك
            </span>


            <div class="expire-date">
                احصل على مزايا أكثر
            </div>


            <a href="#" class="upgrade-btn">
                اشترك الآن
            </a>

        </div>

    <?php endif; ?>

</section>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/dashboard/subscription.blade.php ENDPATH**/ ?>
<aside class="sidebar" id="sidebar">




<div class="logo">

    <div class="logo-mark">
        د
    </div>

    <div class="logo-info">
        <strong>دليل الأطباء</strong>
        <span>بوابة الطبيب</span>
    </div>

</div>




<div class="sidebar-section">
    الرئيسية
</div>


<nav class="side-nav">

    

    <a href="<?php echo e(route('doctor.dashboard')); ?>"
        class="<?php echo e(request()->routeIs('doctor.dashboard') ? 'side-link active' : 'side-link'); ?>">

        <span class="side-icon"><i class="fa-solid fa-house"></i></span>

        <span>
            نظرة عامة
        </span>

    </a>


    

    <a href="<?php echo e(route('doctor.profile.show')); ?>"
        class="<?php echo e(request()->routeIs('doctor.profile.show') ? 'side-link active' : 'side-link'); ?>">

        <span class="side-icon"><i class="fa-solid fa-id-card"></i></span>

        <span>
            ملفي الطبي
        </span>

    </a>


    

    <a href="<?php echo e(route('doctor.profile.edit')); ?>"
        class="<?php echo e(request()->routeIs('doctor.profile.edit') ? 'side-link active' : 'side-link'); ?>">

        <span class="side-icon"><i class="fa-solid fa-pen-to-square"></i></span>

        <span>
            تعديل ملفي الطبي
        </span>

    </a>


    

    <?php if($doctor->hasFeature('subscription')): ?>

        <a href="<?php echo e(route('doctor.reviews')); ?>"
            class="<?php echo e(request()->routeIs('doctor.reviews') ? 'side-link active' : 'side-link'); ?>">

            <span class="side-icon">
                <i class="fa-solid fa-star"></i>
            </span>

            <span>
                التقييمات
            </span>

            <?php if($newRatingsCount > 0): ?>

                <span class="sidebar-badge">
                    <?php echo e($newRatingsCount); ?>

                </span>

            <?php endif; ?>

        </a>

    <?php endif; ?>


    

    <a href="<?php echo e(route('doctor.notifications.index')); ?>"
        class="<?php echo e(request()->routeIs('doctor.notifications.*') ? 'side-link active' : 'side-link'); ?>">

        <span class="side-icon">
            <i class="fa-regular fa-bell"></i>
        </span>

        <span>
            الإشعارات
        </span>

        <?php if($notificationsCount > 0): ?>
            <span class="sidebar-badge notification-badge">
                <?php echo e($notificationsCount > 99 ? '99+' : $notificationsCount); ?>

            </span>
        <?php endif; ?>

    </a>

</nav>




<div class="sidebar-section">
    إدارة الحساب
</div>


<nav class="side-nav">

    

    <a href="#subscription" class="side-link">

        <span class="side-icon">
            <i class="fa-solid fa-crown"></i>
        </span>

        <span>
            الاشتراك
        </span>

    </a>


    

    <a href="<?php echo e(route('doctor.profile_doctor')); ?>"
        class="<?php echo e(request()->routeIs('doctor.profile_doctor') ? 'side-link active' : 'side-link'); ?>">

        <span class="side-icon">
            ⚙
        </span>

        <span>
            الإعدادات
        </span>

    </a>




    <a href="<?php echo e(route('doctor.help')); ?>" class="<?php echo e(request()->routeIs('doctor.help') ? 'side-link active' : 'side-link'); ?>">

        <span class="side-icon">
            ?
        </span>

        <span>
            المساعدة
        </span>

    </a>

</nav>




<div class="sidebar-spacer"></div>




<?php if(!$doctor->hasFeature('subscription')): ?>

    <div class="system-entry subscription-entry">

        <div class="system-entry-top">

            <div class="system-icon">
                ♛
            </div>

            <div>

                <strong>
                    طوّر حسابك
                </strong>

                <span>
                    مميزات أكثر لطبيبك
                </span>

            </div>

        </div>


        <p class="system-entry-text">

            اشترك الآن للحصول على مميزات إضافية
            مثل الحجز أونلاين ونظام إدارة العيادة.

        </p>


        <a href="#subscription" class="system-entry-button">

            الاشتراك الآن ←

        </a>

    </div>


<?php elseif(str_starts_with($planSlug, 'prime-')): ?>

    <div class="system-entry subscription-entry">

        <div class="system-entry-top">

            <div class="system-icon">
                ★
            </div>

            <div>

                <strong>
                    باقة Prime
                </strong>

                <span>
                    اشتراكك مفعل
                </span>

            </div>

        </div>


        <p class="system-entry-text">

            استمتع بمميزات Prime،
            وقم بالترقية لتفعيل الحجز أونلاين
            وإدارة الحجوزات.

        </p>


        <a href="#subscription" class="system-entry-button">

            ترقية الاشتراك ←

        </a>

    </div>


<?php elseif($doctor->hasFeature('booking') && str_starts_with($planSlug, 'professional-')): ?>

    <div class="system-entry subscription-entry">

        <div class="system-entry-top">

            <div class="system-icon">
                📅
            </div>

            <div>

                <strong>
                    نظام الحجوزات
                </strong>

                <span>
                    متاح ضمن اشتراكك
                </span>

            </div>

        </div>


        <p class="system-entry-text">

            استقبل حجوزات مرضاك أونلاين
            وتابع مواعيدك وحجوزاتك من مكان واحد.

        </p>


        <a href="<?php echo e(route("clinic.dashboard")); ?>" class="system-entry-button">

            إدارة الحجوزات ←

        </a>

    </div>


<?php elseif(str_starts_with($planSlug, 'clinic-system-')): ?>

    <div class="system-entry subscription-entry">

        <div class="system-entry-top">

            <div class="system-icon">
                ✚
            </div>

            <div>

                <strong>
                    نظام العيادة
                </strong>

                <span>
                    متاح ضمن اشتراكك
                </span>

            </div>

        </div>


        <p class="system-entry-text">

            إدارة الحجوزات والعملاء والدخل
            والعيادة بالكامل من مكان واحد.

        </p>


        <a href="<?php echo e(route('clinic.dashboard')); ?>"
            class="system-entry-button">

            الدخول إلى نظام العيادة ←

        </a>

    </div>

<?php endif; ?>




<div class="sidebar-profile">

    <div class="profile-avatar">

        <?php if($doctorImage): ?>

            <img
                src="<?php echo e(asset('storage/' . $doctorImage)); ?>"
                alt="د. <?php echo e($doctorname); ?>"
            >

        <?php else: ?>

            <div class="med-doctor-image-placeholder">

                <div class="med-placeholder-icon">
                    <span>♙</span>
                </div>

            </div>

        <?php endif; ?>

    </div>


    <div class="profile-info">

        <strong>
            د. <?php echo e($doctorname); ?>

        </strong>

        <span>
            <?php echo e($doctor->subscription?->plan?->name ?? 'غير مشترك'); ?>

        </span>

    </div>


    

    <form
        action="<?php echo e(route('logout')); ?>"
        method="POST"
        class="sidebar-logout-form"
    >

        <?php echo csrf_field(); ?>

        <button
            type="submit"
            class="sidebar-logout"
            title="تسجيل الخروج"
            aria-label="تسجيل الخروج"
        >

            <span class="sidebar-logout-icon">
                ⇥
            </span>

        </button>

    </form>

</div>


</aside>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/dashboard/sidebar.blade.php ENDPATH**/ ?>
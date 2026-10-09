<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['doctor', 'doctorname', 'notifications']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['doctor', 'doctorname', 'notifications']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<header class="topbar" id="dashboard-header">


    <div class="header-info">

        <button class="mobile-menu" type="button" onclick="openSidebar()" aria-label="فتح القائمة">

            <i class="fa-solid fa-bars"></i>

        </button>


        <div class="header-icon">
            <i class="fa-solid fa-stethoscope"></i>
        </div>


        <div class="header-title">

            <strong>
                لوحة تحكم الطبيب
            </strong>

            <span>
                أهلاً بك د. <?php echo e($doctorname); ?> —
                تابع ملفك وحضورك الطبي
            </span>

        </div>

    </div>


    <div class="top-actions">


        

        <button class="top-btn" type="button" id="themeButton" onclick="toggleDark()" title="الوضع الليلي"
            aria-label="تغيير الوضع">

            ☾

        </button>


        

        <a href="<?php echo e(route('doctor.notifications.index')); ?>" class="top-btn" title="الإشعارات" aria-label="الإشعارات">

            <i class="fa-regular fa-bell"></i>

            <?php if(isset($notifications) && $notifications > 0): ?>
                <span class="notification"></span>
            <?php endif; ?>

        </a>


        


        <div class="top-doctor">

            <div class="profile-avatar">
                <?php if(
                    $doctor->doctor_image &&
                        \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->doctor_image)): ?>
                    <img src="<?php echo e(asset('storage/' . $doctor->doctor_image)); ?>" alt="د. <?php echo e($doctorname); ?>"
                        class="top-doctor-image">
                <?php else: ?>
                    <div class="med-doctor-image-placeholder">

                        <div class="med-placeholder-icon">
                            <span><i class="fa-solid fa-user-doctor"></i></span>
                        </div>

                    </div>
                <?php endif; ?>

            </div>


            <div class="top-doctor-info">

                <strong>
                    د. <?php echo e($doctorname); ?>

                </strong>

                <span>
                    <?php echo e($doctor->specialty?->name ?? 'طبيب'); ?>

                </span>

            </div>

        </div>
    </div>

</header>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/dashboard/header.blade.php ENDPATH**/ ?>
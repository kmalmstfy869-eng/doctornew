<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['doctor', 'doctorname']));

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

foreach (array_filter((['doctor', 'doctorname']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $planSlug = strtolower($doctor->subscription?->plan?->slug ?? '');
    $doctorImage = $doctor->doctor_image;

    $planLabel = match (true) {
        str_starts_with($planSlug, 'clinic-system-') => 'Clinic System',
        str_starts_with($planSlug, 'professional-') => 'Professional',
        str_starts_with($planSlug, 'prime-') => 'Prime',
        default => 'مجاني',
    };

    $durationLabel = match (true) {
        str_ends_with($planSlug, '-monthly') => 'شهري',
        str_ends_with($planSlug, '-3-months') => '3 شهور',
        str_ends_with($planSlug, '-yearly') => 'سنوي',
        default => null,
    };
$isPending = $doctor->status === 'pending';
?>

<div class="panel" id="account-summary">


    <div class="panel-head">

        <div class="panel-title">

            <strong>
                ملخص حسابك
            </strong>

            <span>
                نظرة سريعة على بياناتك وحالة ملفك الطبي
            </span>

        </div>

    </div>


    <div class="account-summary">


        <div class="account-intro">

            <div class="account-avatar">

                <?php if($doctorImage): ?>
                    <img src="<?php echo e(asset('storage/' . $doctorImage)); ?>" alt="د. <?php echo e($doctorname); ?>"
                        class="account-doctor-image">
                <?php else: ?>
                    <div class="med-doctor-image-placeholder">

                        <div class="med-placeholder-icon">
                            <span>♙</span>
                        </div>

                    </div>
                <?php endif; ?>

            </div>

            <div class="account-intro-info">

                <strong>
                    د. <?php echo e($doctorname); ?>

                </strong>

                <span>
                    <?php echo e($doctor->specialty?->name ?? 'التخصص غير محدد'); ?>

                </span>


            <?php if($isPending): ?>
            <div class="account-status is-pending">
                <i></i>
                قيد المراجعة
            </div>
        <?php else: ?>
            <div class="account-status">
                <i></i>
                الحساب نشط
            </div>
        <?php endif; ?>
            </div>

        </div>


        <div class="account-info-grid">


            <div class="account-row">

                <div class="account-row-icon">
                    ★
                </div>

                <div class="account-row-content">

                    <span>
                        التخصص
                    </span>

                    <strong>
                        <?php echo e($doctor->specialty?->name ?? 'غير محدد'); ?>

                    </strong>

                </div>

            </div>


            <div class="account-row">

                <div class="account-row-icon">
                    ◉
                </div>

                <div class="account-row-content">

                    <span>
                        المنطقة
                    </span>

                    <strong>
                        <?php echo e($doctor->area?->name ?? 'غير محددة'); ?>

                    </strong>

                </div>

            </div>


            <div class="account-row">

                <div class="account-row-icon">
                    ☆
                </div>

                <div class="account-row-content">

                    <span>
                        التقييم
                    </span>

                    <strong>
                        <?php
                            $averageRating = $doctor->rating()->avg('rating');
                        ?>
                        <?php if($doctor->hasFeature('subscription')): ?>
                            <?php echo e($averageRating ? number_format($averageRating, 1) . ' / 5' : 'لا توجد تقييمات'); ?>

                        <?php else: ?>
                            <?php echo e('الميزة غير متوفرة'); ?>

                        <?php endif; ?>
                    </strong>

                </div>

            </div>


            <a href="<?php echo e(route('doctor.subscription')); ?>" class="account-row">

                <div class="account-row-icon">
                    ♛
                </div>

                <div class="account-row-content">

                    <span>
                        الاشتراك
                    </span>

                    <strong>
                        <?php if($doctor->hasFeature('subscription')): ?>
                            <?php echo e($planLabel); ?><?php echo e($durationLabel ? ' · ' . $durationLabel : ''); ?>

                        <?php else: ?>
                            مجاني
                        <?php endif; ?>
                    </strong>

                </div>

            </a>

        </div>


        <div class="account-actions">

            <a href="<?php echo e(route('doctor.profile.show')); ?>" class="account-action primary">

                مشاهدة الملف الطبي

            </a>


            <a href="<?php echo e(route('doctor.profile.edit')); ?>" class="account-action secondary">

                تعديل الملف

            </a>

        </div>

    </div>

</div>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/dashboard/acount.blade.php ENDPATH**/ ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['doctor', 'favoriteIds' => []]));

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

foreach (array_filter((['doctor', 'favoriteIds' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<article class="doctor-card">

    <div class="doctor-cover">

        <?php if($doctor->hasFeature('booking')): ?>
            <span class="subscription-badge premium">

                <i class="fa-solid fa-crown"></i>

                طبيب مميز

            </span>
        <?php endif; ?>

    </div>


    <?php
        $isFav = in_array($doctor->id, $favoriteIds);
    ?>

    <form method="POST" action="<?php echo e(route('favorites.toggle', $doctor->id)); ?>">
        <?php echo csrf_field(); ?>

        <button type="submit" class="doctor-favorite <?php echo e($isFav ? 'is-active' : ''); ?>" aria-label="المفضلة">

            <i class="<?php echo e($isFav ? 'fa-solid' : 'fa-regular'); ?> fa-heart"></i>

        </button>
    </form>

    <!-- صورة الطبيب -->

    <?php if(
        $doctor->doctor_image &&
            $doctor->hasFeature('subscription') &&
            \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->doctor_image)): ?>
        <div class="doctor-image">

            <img src="<?php echo e(asset('storage/' . $doctor->doctor_image)); ?>" alt="د.<?php echo e($doctor->user->name); ?>"
                class="med-doctor-image">

        </div>
    <?php else: ?>
        <div class="doctor-image">

            <div class="image-unavailable">

                <i class="fa-solid fa-user-doctor"></i>

                <span>
                    الصورة غير متوفرة
                </span>

            </div>

        </div>
    <?php endif; ?>


    <div class="doctor-content">


        <!-- بيانات الطبيب -->

        <div class="doctor-top">

            <div class="doctor-name">

                <h3 class="doctor-name-title">

                    <span>
                        د. <?php echo e($doctor->user?->name ?? 'طبيب'); ?>

                    </span>


                    <?php if($doctor->hasFeature('subscription')): ?>
                        <i class="fa-solid fa-circle-check verified-badge"></i>
                    <?php endif; ?>

                </h3>


                <p>
                    <?php echo e($doctor->specialty?->title ?? 'التخصص غير محدد'); ?>

                </p>

            </div>

        </div>


        <!-- التقييم -->

        <?php
            $ratings = $doctor->rating;
        ?>


        <?php if($ratings->isNotEmpty() && $doctor->hasFeature('subscription')): ?>

            <?php

                $averageRating = $ratings->avg('rating');

                $fullStars = floor($averageRating);

                $hasHalfStar = $averageRating - $fullStars >= 0.5;

            ?>


            <div class="rating-row">

                <div class="stars">

                    <?php for($i = 1; $i <= $fullStars; $i++): ?>
                        <i class="fa-solid fa-star"></i>
                    <?php endfor; ?>


                    <?php if($hasHalfStar): ?>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    <?php endif; ?>


                    <?php for($i = $fullStars + ($hasHalfStar ? 1 : 0); $i < 5; $i++): ?>
                        <i class="fa-regular fa-star"></i>
                    <?php endfor; ?>

                </div>


                <span class="rating-number">

                    <?php echo e(number_format($averageRating, 1)); ?>



                    <small>
                        (<?php echo e($ratings->count()); ?> تقييم)
                    </small>

                </span>

            </div>
        <?php else: ?>
            <div class="limited-info">

                <i class="fa-solid fa-lock"></i>

                التقييم غير متاح الآن

            </div>

        <?php endif; ?>


        <!-- تفاصيل الطبيب -->

        <div class="doctor-details">

            <div class="doctor-detail">

                <i class="fa-solid fa-location-dot"></i>

                <?php echo e($doctor->area?->name ?? 'المنطقة غير محددة'); ?>


            </div>


            <span class="doctor-detail">

                <i class="fa-solid fa-briefcase-medical"></i>

                <?php echo e($doctor->experience ?? 0); ?>


                سنة خبرة

            </span>

        </div>


        <!-- الخدمات -->

        <div class="doctor-services">

            <span class="service-tag">
                كشف طبي
            </span>

            <span class="service-tag">
                متابعة دورية
            </span>

            <span class="service-tag">
                استشارات
            </span>

        </div>


        <!-- زر الملف -->

        <a href="<?php echo e(route('doctors.show', $doctor->id)); ?>" class="doctor-button-card">

            <?php if($doctor->hasFeature('booking')): ?>
                عرض الملف الطبي و احجز الان
            <?php else: ?>
                عرض الملف الطبي
            <?php endif; ?>

        </a>

    </div>

</article>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/home/doctors/card_doctor_clinic_system_component.blade.php ENDPATH**/ ?>
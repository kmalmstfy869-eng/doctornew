<?php $__env->startSection('title', 'تفاصيل الدكتور | دليل الأطباء'); ?>

<?php $__env->startSection('content'); ?>

    <main class="med-profile-page">

        <div class="med-container">

            
            <div class="breadcrumb">

                <a href="<?php echo e(route('home')); ?>">
                    الرئيسية
                </a>

                <i class="fa-solid fa-chevron-left"></i>

                <a href="<?php echo e(route('doctors.index')); ?>">
                    الاطباء
                </a>

                <i class="fa-solid fa-chevron-left"></i>

                <span>
                    تفاصيل الطبيب
                </span>

            </div>


            
            <section class="med-doctor-hero">

                <div class="med-doctor-main">

                    
                    <div class="med-doctor-image-wrap">

                        <?php if($doctorImageExists): ?>
                            <img src="<?php echo e(asset('storage/' . $doctor->doctor_image)); ?>" alt="د.<?php echo e($doctor->user->name); ?>"
                                class="med-doctor-image">

                            <span class="med-verified-badge">

                                <i class="fa-solid fa-circle-check"></i>

                                طبيب موثوق

                            </span>
                        <?php else: ?>
                            <div class="med-doctor-image-placeholder">

                                <div class="med-placeholder-icon">

                                    <i class="fa-solid fa-user-doctor"></i>

                                </div>

                                <strong>
                                    صورة الطبيب غير متاحة
                                </strong>

                                <span>
                                    لم يتم إضافة صورة للملف الطبي
                                </span>

                            </div>
                        <?php endif; ?>

                    </div>


                    
                    <div class="med-doctor-info">

                        <div class="med-doctor-name-row">

                            <div>

                                <span class="med-doctor-label">
                                    الملف الطبي
                                </span>

                                <h1 class="med-doctor-name">

                                    <span class="med-doctor-name-icon">

                                        <i class="fa-solid fa-user-doctor"></i>

                                    </span>

                                    <span>
                                        د. <?php echo e($doctor?->user?->name ?? 'اسم الطبيب'); ?>

                                    </span>

                                </h1>

                                <p class="med-doctor-job">
                                    <?php echo e($doctor?->specialty?->title); ?>

                                </p>

                            </div>


                            <div class="med-doctor-buttons">

                                <button type="button" class="med-share-button" id="medShareButton"
                                    aria-label="مشاركة الصفحة" title="مشاركة الصفحة">

                                    <i class="fa-solid fa-share-nodes"></i>

                                </button>


                                <?php if(auth()->guard()->check()): ?>

                                    <button type="button" class="med-favorite-button" id="medFavoriteButton"
                                        aria-label="إضافة إلى المفضلة">

                                        <i class="fa-regular fa-heart"></i>

                                    </button>

                                <?php endif; ?>

                            </div>

                        </div>


                        
                        <div class="med-doctor-meta">

                            <?php if($doctor->hasFeature('subscription')): ?>
                                <span>

                                    <i class="fa-solid fa-star"></i>

                                    <?php echo e(number_format($doctor?->rating?->avg('rating') ?? 0, 1)); ?>


                                    <small>
                                        (<?php echo e($doctor?->rating?->count()); ?> تقييم)
                                    </small>

                                </span>
                            <?php endif; ?>


                            <span>

                                <i class="fa-solid fa-briefcase"></i>

                                <?php echo e($doctor?->experience); ?>


                                سنة خبرة

                            </span>


                            <span>

                                <i class="fa-solid fa-location-dot"></i>

                                <?php echo e($doctor?->area?->name); ?>


                            </span>

                        </div>


                        
                        <div class="med-doctor-actions">

                            <a href="tel:<?php echo e($doctor?->phone); ?>" class="med-primary-action">

                                <i class="fa-solid fa-phone"></i>

                                اتصل بالعيادة

                            </a>


                            <a href="https://wa.me/<?php echo e($doctor?->whatsapp); ?>" target="_blank" rel="noopener"
                                class="med-whatsapp-action">

                                <i class="fa-brands fa-whatsapp"></i>

                                تواصل عبر واتساب

                            </a>


                            <?php if($doctor->hasFeature('booking')): ?>
                                <a href="#med-booking" class="med-book-now-action">

                                    <i class="fa-regular fa-calendar-check"></i>

                                    احجز الآن

                                </a>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </section>



            <div class="med-profile-layout">

                <div class="med-profile-content">


                    
                    <section class="med-content-card">

                        <div class="med-card-title">

                            <div class="med-card-title-icon">

                                <i class="fa-solid fa-user-doctor"></i>

                            </div>

                            <div>

                                <h2>
                                    نبذة عن الطبيب
                                </h2>

                                <p>
                                    معلومات وخبرة الطبيب
                                </p>

                            </div>

                        </div>


                        <p class="med-about-text">
                            <?php echo e($doctor?->bio); ?>

                        </p>

                    </section>



                    
                    <?php if(!empty($doctor?->working_hours)): ?>
                        <section class="med-content-card med-working-hours-card">

                            <div class="med-card-title">

                                <div class="med-card-title-icon">

                                    <i class="fa-regular fa-clock"></i>

                                </div>

                                <div>

                                    <span class="med-section-kicker">
                                        مواعيد العيادة
                                    </span>

                                    <h2>
                                        مواعيد العمل
                                    </h2>

                                    <p>
                                        مواعيد استقبال المرضى داخل العيادة
                                    </p>

                                </div>

                            </div>


                            <div class="med-working-hours-box">

                                <div class="med-working-hours-icon">

                                    <i class="fa-regular fa-calendar-days"></i>

                                </div>

                                <div class="med-working-hours-content">

                                    <strong>
                                        مواعيد العيادة
                                    </strong>

                                    <p>
                                        <?php echo e($doctor?->working_hours); ?>

                                    </p>

                                </div>

                            </div>

                        </section>
                    <?php endif; ?>



                    
                    <?php if($doctor->hasFeature('subscription') && !empty($doctor?->services)): ?>
                        <section class="med-content-card">

                            <div class="med-card-title">

                                <div class="med-card-title-icon">

                                    <i class="fa-solid fa-stethoscope"></i>

                                </div>

                                <div>

                                    <span class="med-section-kicker">
                                        الخدمات الطبية
                                    </span>

                                    <h2>
                                        الخدمات الطبية
                                    </h2>

                                    <p>
                                        أهم الخدمات المتاحة داخل العيادة
                                    </p>

                                </div>

                            </div>


                            <div class="med-services-grid">

                                <?php $__currentLoopData = $doctor?->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="med-service-card">

                                        <div class="med-service-icon">

                                            <i class="fa-solid fa-heart-pulse"></i>

                                        </div>

                                        <div>

                                            <h3>
                                                <?php echo e($item); ?>

                                            </h3>

                                        </div>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>

                        </section>
                    <?php endif; ?>



                    
                    <?php if($doctor->hasFeature('subscription') && $existingClinicImages->isNotEmpty()): ?>
                        <section class="med-content-card">

                            <div class="med-card-title">

                                <div class="med-card-title-icon">

                                    <i class="fa-solid fa-images"></i>

                                </div>

                                <div>

                                    <span class="med-section-kicker">
                                        <?php echo e($doctor?->clinic_name); ?>

                                    </span>

                                    <h2>
                                        صور العيادة
                                    </h2>

                                    <p>
                                        تعرف على مكان العيادة وتجهيزاتها
                                    </p>

                                </div>

                            </div>


                            <div class="med-gallery">

                                <?php $__currentLoopData = $existingClinicImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="med-gallery-image" data-image="<?php echo e(asset('storage/' . $image)); ?>">

                                        <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="صورة العيادة">

                                        <div class="med-image-overlay">

                                            <i class="fa-solid fa-expand"></i>

                                        </div>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>

                        </section>
                    <?php endif; ?>



                    
                    <?php if($doctor->hasFeature('booking')): ?>
                        <section class="med-content-card med-booking-card" id="med-booking">

                            <div class="med-card-title">

                                <div class="med-card-title-icon">

                                    <i class="fa-regular fa-calendar-check"></i>

                                </div>

                                <div>

                                    <span class="med-section-kicker">
                                        حجز إلكتروني
                                    </span>

                                    <h2>
                                        حجز موعد
                                    </h2>

                                    <p>
                                        اختر اليوم ثم اختر الساعة المناسبة لك
                                    </p>

                                </div>

                            </div>


                            <div class="med-booking-info">

                                <div>

                                    <strong>
                                        المواعيد المتاحة
                                    </strong>

                                    <span>
                                        اختر اليوم لعرض جميع المواعيد المتاحة
                                    </span>

                                </div>

                                <div class="med-booking-available">

                                    <i class="fa-solid fa-circle"></i>

                                    متاح للحجز

                                </div>

                            </div>



                            <div class="med-days-list">

                                <?php $__empty_1 = true; $__currentLoopData = $bookingDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="med-day-accordion <?php echo e($index === 0 ? 'active' : ''); ?>"
                                        data-day-index="<?php echo e($index); ?>" data-date="<?php echo e($day['date']); ?>">

                                        <button type="button" class="med-day-header">

                                            <div class="med-day-info">

                                                <span class="med-day-name">
                                                    <?php echo e($day['day_name']); ?>

                                                </span>

                                                <strong>
                                                    <?php echo e($day['formatted_date']); ?>

                                                </strong>

                                            </div>


                                            <div class="med-day-header-meta">

                                                <span>
                                                    <?php echo e($day['slots_count']); ?> موعد
                                                </span>

                                                <i class="fa-solid fa-chevron-down"></i>

                                            </div>

                                        </button>


                                        <div class="med-day-times">

                                            <?php $__currentLoopData = $day['slots']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $isBooked = $slot['is_booked'];
                                                    $isExpired = $slot['is_expired'] ?? false;
                                                    $slotTime = \Carbon\Carbon::createFromFormat(
                                                        'H:i',
                                                        $slot['start_time'],
                                                    );
                                                ?>

                                                <button type="button"
                                                    class="med-slot-button <?php echo e($isBooked ? 'booked' : ''); ?> <?php echo e($isExpired && !$isBooked ? 'expired' : ''); ?>"
                                                    data-date="<?php echo e($day['date']); ?>"
                                                    data-start="<?php echo e($slot['start_time']); ?>"
                                                    <?php echo e($isBooked || $isExpired ? 'disabled' : ''); ?>

                                                    aria-disabled="<?php echo e($isBooked || $isExpired ? 'true' : 'false'); ?>"
                                                    title="<?php echo e($isBooked ? 'هذا الموعد محجوز بالفعل' : ($isExpired ? 'هذا الموعد انتهى' : 'اختيار هذا الموعد')); ?>">

                                                    <span class="med-slot-time">

                                                        <?php echo e($slotTime->format('h:i')); ?>


                                                        <?php echo e($slotTime->format('A') === 'AM' ? 'ص' : 'م'); ?>


                                                    </span>


                                                    <?php if($isBooked): ?>
                                                        <span class="med-slot-booked-label">
                                                            محجوز
                                                        </span>
                                                    <?php elseif($isExpired): ?>
                                                        <span class="med-slot-expired-label">
                                                            انتهى
                                                        </span>
                                                    <?php endif; ?>

                                                </button>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </div>

                                    </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-calendar-xmark','title' => 'لا توجد حجوزات لهذا الدكتور','content' => 'لا توجد حجوزات متاحة حاليًا لهذا الدكتور.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-calendar-xmark','title' => 'لا توجد حجوزات لهذا الدكتور','content' => 'لا توجد حجوزات متاحة حاليًا لهذا الدكتور.']); ?>
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



                            
                            <?php if($bookingDays->isNotEmpty()): ?>
                                <div class="med-selected-appointment">

                                    <div class="med-selected-info">

                                        <div class="med-selected-icon">

                                            <i class="fa-regular fa-calendar-check"></i>

                                        </div>

                                        <div>

                                            <span>
                                                الموعد المختار
                                            </span>

                                            <strong id="medSelectedText">
                                                لم يتم اختيار موعد بعد
                                            </strong>

                                        </div>

                                    </div>


                                    <button type="button" class="med-confirm-button" id="medConfirmBooking" disabled>

                                        تأكيد الحجز

                                        <i class="fa-solid fa-arrow-left"></i>

                                    </button>

                                </div>
                            <?php endif; ?>

                        </section>
                    <?php endif; ?>



                    
                    <?php if($doctor->hasFeature('subscription') && !empty($doctor?->rating)): ?>
                        <section class="med-content-card">

                            <div class="med-card-title">

                                <div class="med-card-title-icon">

                                    <i class="fa-solid fa-star"></i>

                                </div>

                                <div>

                                    <span class="med-section-kicker">
                                        آراء المرضى
                                    </span>

                                    <h2>
                                        تقييمات المرضى
                                    </h2>

                                    <p>
                                        تجارب وآراء المرضى السابقين
                                    </p>

                                </div>

                            </div>


                            <?php
                                $averageRating = $doctor?->rating->avg('rating') ?? 0;
                            ?>


                            <div class="med-review-summary">

                                <div class="med-big-rating">

                                    <strong>
                                        <?php echo e(number_format($averageRating, 1)); ?>

                                    </strong>

                                    <div class="med-review-stars">

                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= floor($averageRating)): ?>
                                                <i class="fa-solid fa-star"></i>
                                            <?php else: ?>
                                                <i class="fa-regular fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>

                                    </div>

                                    <span>
                                        من 5
                                    </span>

                                </div>


                                <div class="med-review-summary-text">

                                    <?php
                                        $ratingText = match (true) {
                                            $averageRating >= 4 => 'تقييم ممتاز',
                                            $averageRating >= 3 => 'تقييم جيد جدًا',
                                            $averageRating >= 2 => 'تقييم جيد',
                                            $averageRating > 0 => 'تقييم ضعيف',
                                            default => 'لا يوجد تقييم',
                                        };
                                    ?>

                                    <h3>
                                        <?php echo e($ratingText); ?>

                                    </h3>

                                    <p>

                                        بناءً على

                                        <?php echo e($doctor?->rating?->count()); ?>


                                        تقييم من المرضى.

                                    </p>

                                </div>

                            </div>



                            
                            <form action="<?php echo e(route('ratings.store')); ?>" method="POST" id="medReviewForm">

                                <?php echo csrf_field(); ?>


                                <div class="med-review-field">

                                    <label>
                                        تقييمك
                                    </label>


                                    <div class="med-star-rating">

                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <button type="button" data-rating="<?php echo e($i); ?>"
                                                aria-label="<?php echo e($i); ?> نجوم">

                                                <i class="fa-solid fa-star"></i>

                                            </button>
                                        <?php endfor; ?>


                                        <span id="medRatingLabel">
                                            اختر التقييم
                                        </span>

                                    </div>


                                    <input type="hidden" name="rating" id="medRatingValue">

                                    <input type="hidden" name="doctor_id" value="<?php echo e($doctor->id); ?>">


                                    <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="field-error">
                                            <?php echo e($message); ?>

                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>


                                <div class="med-review-field">

                                    <label>
                                        اكتب تجربتك
                                    </label>


                                    <textarea name="comment" class="med-review-textarea" placeholder="اكتب رأيك وتجربتك مع الطبيب..." required><?php echo e(old('comment')); ?></textarea>


                                    <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="field-error">
                                            <?php echo e($message); ?>

                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>


                                <button type="submit" class="med-submit-review">

                                    <i class="fa-solid fa-paper-plane"></i>

                                    إرسال التقييم

                                </button>

                            </form>



                            
                            <?php $__empty_1 = true; $__currentLoopData = $ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <article class="med-review-item">

                                    <div class="med-review-head">

                                        <div class="med-review-user">

                                            <div class="med-user-avatar">

                                                <?php echo e(mb_substr($rating?->user?->name ?? 'م', 0, 1)); ?>


                                            </div>

                                            <div>

                                                <h4>
                                                    <?php echo e($rating?->user?->name ?? 'مستخدم'); ?>

                                                </h4>

                                                <span>
                                                    <?php echo e($rating?->created_at?->diffForHumans()); ?>

                                                </span>

                                            </div>

                                        </div>


                                        <div class="med-review-stars">

                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php if($i <= $rating?->rating): ?>
                                                    <i class="fa-solid fa-star"></i>
                                                <?php else: ?>
                                                    <i class="fa-regular fa-star"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>

                                        </div>

                                    </div>


                                    <?php if(!empty($rating?->comment)): ?>
                                        <p>
                                            <?php echo e($rating?->comment); ?>

                                        </p>
                                    <?php endif; ?>

                                </article>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <div class="med-no-reviews">

                                    <i class="fa-regular fa-star"></i>

                                    <h3>
                                        لا توجد تقييمات حتى الآن
                                    </h3>

                                    <p>
                                        كن أول شخص يقيّم هذا الطبيب.
                                    </p>

                                </div>
                            <?php endif; ?>


                            <?php if($ratings?->hasPages()): ?>
                                <div class="med-reviews-pagination">

                                    <?php echo e($ratings->withQueryString()->fragment('reviews')->links('vendor.pagination.custom')); ?>


                                </div>
                            <?php endif; ?>

                        </section>
                    <?php endif; ?>

                </div>



                
                <aside class="med-profile-sidebar">


                    
                    <section class="med-sidebar-card med-contact-card">

                        <div class="med-sidebar-heading">

                            <div class="med-sidebar-icon">

                                <i class="fa-solid fa-headset"></i>

                            </div>

                            <div>

                                <h3>
                                    تواصل مع العيادة
                                </h3>

                                <p>
                                    تواصل معنا مباشرة
                                </p>

                            </div>

                        </div>


                        <a href="tel:<?php echo e($doctor?->phone); ?>" class="med-sidebar-contact phone">

                            <div>

                                <i class="fa-solid fa-phone"></i>

                            </div>

                            <span>

                                <small>
                                    اتصل بالعيادة
                                </small>

                                <strong>
                                    <?php echo e($doctor?->phone); ?>

                                </strong>

                            </span>

                            <i class="fa-solid fa-chevron-left"></i>

                        </a>


                        <button type="button" class="med-copy-number" id="medCopyNumber"
                            data-phone="<?php echo e($doctor?->phone); ?>">

                            <i class="fa-regular fa-copy"></i>

                            نسخ رقم الهاتف

                        </button>


                        <a href="https://wa.me/<?php echo e($doctor?->whatsapp); ?>" target="_blank" rel="noopener"
                            class="med-sidebar-contact whatsapp">

                            <div>

                                <i class="fa-brands fa-whatsapp"></i>

                            </div>

                            <span>

                                <small>
                                    تواصل عبر
                                </small>

                                <strong>
                                    واتساب
                                </strong>

                            </span>

                            <i class="fa-solid fa-chevron-left"></i>

                        </a>

                    </section>



                    
                    <section class="med-sidebar-card" id="med-clinic">

                        <div class="med-sidebar-heading">

                            <div class="med-sidebar-icon">

                                <i class="fa-solid fa-hospital"></i>

                            </div>

                            <div>

                                <h3>
                                    معلومات العيادة
                                </h3>

                                <p>
                                    مكان العيادة وموقعها
                                </p>

                            </div>

                        </div>


                        <h4 class="med-clinic-name">
                            <?php echo e($doctor?->clinic_name); ?>

                        </h4>


                        <div class="med-address">

                            <i class="fa-solid fa-location-dot"></i>

                            <span>
                                <?php echo e($doctor?->address); ?>

                            </span>

                        </div>


                        <div class="med-address">

                            <i class="fa-regular fa-clock"></i>

                            <span>
                                <?php echo e($doctor?->working_hours); ?>

                            </span>

                        </div>


                        <?php if($mapSrc && $doctor->hasFeature('subscription')): ?>
                            <div class="med-map-box">
                                <iframe src="<?php echo e($mapSrc); ?>" loading="lazy" allowfullscreen></iframe>
                            </div>

                            <a href="<?php echo e($doctor->google_maps_url); ?>" target="_blank" rel="noopener"
                                class="med-map-button">
                                <i class="fa-solid fa-location-arrow"></i>
                                فتح الموقع على الخريطة
                            </a>
                        <?php endif; ?>

                    </section>



                    
                    <section class="med-sidebar-card med-price-card">

                        <span>
                            سعر الكشف
                        </span>

                        <strong>

                            <?php echo e($doctor?->consultation_price); ?>


                            <small>
                                جنيه
                            </small>

                        </strong>

                        <p>
                            شامل الاستشارة الطبية
                        </p>


                        <?php if($doctor->hasFeature('booking')): ?>
                            <a href="#med-booking" class="med-book-sidebar">

                                احجز موعدك الآن

                                <i class="fa-solid fa-arrow-left"></i>

                            </a>
                        <?php endif; ?>

                    </section>

                </aside>

            </div>

        </div>

    </main>


    
    <section class="med-similar-section">

        <div class="med-container">

            <div class="med-section-header">

                <div>

                    <span>
                        اقتراحات لك
                    </span>

                    <h2>
                        أطباء مشابهون
                    </h2>

                </div>


                <a href="<?php echo e(route('doctors.index')); ?>">

                    عرض جميع الأطباء

                    <i class="fa-solid fa-arrow-left"></i>

                </a>

            </div>


            <?php if($similar_doctors?->isNotEmpty()): ?>
                <?php if (isset($component)) { $__componentOriginal180de1d4172bcfb057394935755eb005 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal180de1d4172bcfb057394935755eb005 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.doctors.doctors_grid','data' => ['doctors' => $similar_doctors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.doctors.doctors_grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['doctors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($similar_doctors)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal180de1d4172bcfb057394935755eb005)): ?>
<?php $attributes = $__attributesOriginal180de1d4172bcfb057394935755eb005; ?>
<?php unset($__attributesOriginal180de1d4172bcfb057394935755eb005); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal180de1d4172bcfb057394935755eb005)): ?>
<?php $component = $__componentOriginal180de1d4172bcfb057394935755eb005; ?>
<?php unset($__componentOriginal180de1d4172bcfb057394935755eb005); ?>
<?php endif; ?>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء مطابقون','content' => 'جرب البحث باسم آخر أو غيّر التخصص والمنطقة.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء مطابقون','content' => 'جرب البحث باسم آخر أو غيّر التخصص والمنطقة.']); ?>
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

    </section>


    
    <div class="med-image-modal" id="medImageModal">

        <button type="button" class="med-close-modal" id="medCloseModal">

            <i class="fa-solid fa-xmark"></i>

        </button>


        <img src="" alt="صورة العيادة" id="medModalImage">

    </div>


    
    <?php if($doctor->hasFeature('booking')): ?>
        <div class="med-patient-booking-modal" id="medPatientBookingModal" aria-hidden="true">

            <div class="med-patient-booking-overlay" id="medPatientBookingOverlay"></div>


            <div class="med-patient-booking-dialog" role="dialog" aria-modal="true"
                aria-labelledby="medPatientBookingTitle">

                <button type="button" class="med-patient-booking-close" id="medPatientBookingClose" aria-label="إغلاق">

                    <i class="fa-solid fa-xmark"></i>

                </button>


                <div class="med-patient-booking-header">

                    <div class="med-patient-booking-header-icon">

                        <i class="fa-solid fa-calendar-check"></i>

                    </div>

                    <div>

                        <span>
                            تأكيد الموعد
                        </span>

                        <h2 id="medPatientBookingTitle">
                            بيانات المريض
                        </h2>

                        <p>
                            أدخل بيانات المريض لإرسال طلب الحجز
                        </p>

                    </div>

                </div>


                <div class="med-patient-selected-slot">

                    <div class="med-patient-selected-slot-icon">

                        <i class="fa-regular fa-calendar-days"></i>

                    </div>

                    <div>

                        <span>
                            الموعد المختار
                        </span>

                        <strong id="medModalSelectedAppointment">
                            لم يتم اختيار موعد
                        </strong>

                    </div>

                </div>


                <form method="POST" action="<?php echo e(route('onlinebooking.store', ['doctor' => $doctor->id])); ?>"
                    id="medPatientBookingForm">

                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="appointment_date" id="medAppointmentDate"
                        value="<?php echo e(old('appointment_date')); ?>">

                    <input type="hidden" name="start_time" id="medStartTime" value="<?php echo e(old('start_time')); ?>">


                    <div class="med-patient-booking-fields">

                        <div class="med-patient-booking-field">

                            <label for="patient_name">

                                اسم المريض

                                <span>*</span>

                            </label>

                            <input type="text" id="patient_name" name="patient_name"
                                value="<?php echo e(old('patient_name')); ?>" placeholder="أدخل اسم المريض" required>

                            <?php $__errorArgs = ['patient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="field-error">
                                    <?php echo e($message); ?>

                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>


                        <div class="med-patient-booking-field">

                            <label for="patient_phone">

                                رقم الهاتف

                                <span>*</span>

                            </label>

                            <input type="tel" id="patient_phone" name="patient_phone"
                                value="<?php echo e(old('patient_phone')); ?>" placeholder="01xxxxxxxxx" required
                                inputmode="numeric">

                            <?php $__errorArgs = ['patient_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="field-error">
                                    <?php echo e($message); ?>

                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>

                    </div>


                    <div class="med-patient-booking-actions">

                        <button type="button" class="med-patient-booking-cancel" id="medPatientBookingCancel">

                            إلغاء

                        </button>


                        <button type="submit" class="med-patient-booking-submit">

                            تأكيد وإرسال الحجز

                            <i class="fa-solid fa-arrow-left"></i>

                        </button>

                    </div>

                </form>

            </div>

        </div>
    <?php endif; ?>


    
    <?php if($doctor->hasFeature('booking')): ?>
        <?php $__env->startPush('scripts'); ?>
            <script>
                window.medBookingData = {
                    hasOldBookingData: <?php echo json_encode(old('patient_name') !== null || old('patient_phone') !== null || old('appointment_date') !== null || old('start_time') !== null, 15, 512) ?>,
                    hasBookingValidationErrors: <?php echo json_encode($errors->has('patient_name') || $errors->has('patient_phone'), 15, 512) ?>,
                    appointmentDate: <?php echo json_encode(old('appointment_date', ''), 512) ?>,
                    startTime: <?php echo json_encode(old('start_time', ''), 512) ?>
                };
            </script>

            <script src="<?php echo e(asset('js/clinic/booking_user.js')); ?>"></script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/doctors/doctor_details.blade.php ENDPATH**/ ?>
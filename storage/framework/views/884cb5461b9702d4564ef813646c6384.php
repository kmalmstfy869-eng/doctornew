<?php $__env->startSection('title', 'اشتراكاتي | لوحة تحكم الطبيب'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/plans.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="sp-page" id="spPage">

        
        <section class="sp-hero">

            <div class="sp-hero-content">

                <?php if($isSubscribed): ?>

                    <span class="sp-label">✦ اشتراك نشط</span>

                    <h1>باقة <?php echo e($currentTier['name']); ?></h1>

                    <p><?php echo e($currentTier['desc']); ?></p>

                    <div class="sp-hero-actions">

                        <?php if($expiringSoon): ?>
                            <a href="<?php echo e($renewLink); ?>" target="_blank" rel="noopener" class="sp-btn sp-btn-light">
                                تجديد الاشتراك
                            </a>
                        <?php endif; ?>

                        <?php if (! ($isHighest)): ?>
                            <a href="#sp-plans" class="sp-btn sp-btn-ghost">
                                ترقية الاشتراك
                            </a>
                        <?php endif; ?>

                    </div>

                <?php else: ?>

                    <span class="sp-label">✦ طوّر ظهورك الطبي</span>

                    <h1>اختر الباقة المناسبة لك</h1>

                    <p>
                        الاشتراك يرفع ظهور ملفك أمام المرضى ويفتح لك الحجز أونلاين وأدوات إدارة العيادة.
                        للاشتراك تواصل معنا وسيتم تفعيل باقتك.
                    </p>

                    <div class="sp-hero-actions">
                        <a href="#sp-plans" class="sp-btn sp-btn-light">استعرض الباقات</a>
                    </div>

                <?php endif; ?>

            </div>

            <?php if($isSubscribed): ?>
                <div class="sp-hero-stats">

                    <div class="sp-stat">
                        <span>المدة</span>
                        <strong><?php echo e($currentDuration ?? '—'); ?></strong>
                    </div>

                    <div class="sp-stat">
                        <span>الأيام المتبقية</span>
                        <strong><?php echo e($daysLeft !== null ? $daysLeft . ' يوم' : '—'); ?></strong>
                    </div>

                    <div class="sp-stat">
                        <span>تاريخ البداية</span>
                        <strong><?php echo e($subscription->start_date?->translatedFormat('j F Y') ?? '—'); ?></strong>
                    </div>

                    <div class="sp-stat">
                        <span>تاريخ الانتهاء</span>
                        <strong><?php echo e($subscription->end_date?->translatedFormat('j F Y') ?? '—'); ?></strong>
                    </div>

                </div>
            <?php endif; ?>

        </section>


        
        <?php if($isSubscribed && $expiringSoon): ?>
            <section class="sp-alert">

                <div class="sp-alert-text">
                    <strong>اشتراكك ينتهي قريبًا</strong>
                    <span>جدّد الآن للحفاظ على مميزات ملفك الطبي دون انقطاع.</span>
                </div>

                <a href="<?php echo e($renewLink); ?>" target="_blank" rel="noopener" class="sp-btn sp-btn-warning">
                    جدّد الآن
                </a>

            </section>
        <?php endif; ?>


        
        <div class="sp-heading sp-heading-center" id="sp-plans">
            <h2><?php echo e($isSubscribed ? 'الباقات' : 'اختر الباقة المناسبة لك'); ?></h2>
            <p><?php echo e($isSubscribed ? 'باقتك الحالية وخيارات الترقية' : 'كل باقة تمنحك مزايا تطوّر ظهور ملفك الطبي'); ?></p>

            <?php if (! ($isHighest)): ?>
                <div class="sp-duration">
                    <?php $__currentLoopData = $durations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dKey => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" data-duration="<?php echo e($dKey); ?>" class="<?php echo e($dKey === $initialDuration ? 'active' : ''); ?>">
                            <?php echo e($d['label']); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <section class="sp-plans">

            <?php $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $featured = $tier['key'] === 'professional'; ?>

                <article class="sp-plan <?php echo e($tier['state'] === 'current' ? 'is-current' : ''); ?> <?php echo e($tier['state'] === 'lower' ? 'is-lower' : ''); ?> <?php echo e($featured && $tier['state'] !== 'current' ? 'is-featured' : ''); ?>">

                    <?php if($tier['state'] === 'current'): ?>
                        <span class="sp-plan-tag">باقتك الحالية</span>
                    <?php elseif($featured): ?>
                        <span class="sp-plan-tag gold"><i class="fa-solid fa-star"></i> الأفضل للأطباء</span>
                    <?php endif; ?>

                    <div class="sp-plan-icon">
                        <i class="fa-solid <?php echo e($tier['icon']); ?>"></i>
                    </div>

                    <div class="sp-plan-name">
                        <h3><?php echo e($tier['name']); ?></h3>
                        <p><?php echo e($tier['desc']); ?></p>
                    </div>

                    <?php $__currentLoopData = $tier['durations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dKey => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="sp-price" data-d="<?php echo e($dKey); ?>" <?php if($dKey !== $initialDuration): ?> hidden <?php endif; ?>>
                            <strong><?php echo e(number_format($d['price'])); ?></strong>
                            <span>جنيه / <?php echo e($d['unit']); ?></span>
                            <?php if($d['locked'] ?? false): ?>
                                <em class="sp-price-lock">سعرك الحالي</em>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <ul class="sp-features">
                        <?php $__currentLoopData = $tier['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><i class="fa-solid fa-check"></i><?php echo e($feature); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__currentLoopData = $tier['off']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="off"><i class="fa-solid fa-xmark"></i><?php echo e($feature); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <?php if($tier['state'] === 'new' || $tier['state'] === 'upgrade'): ?>

                        <?php $__currentLoopData = $tier['durations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dKey => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($d['link']); ?>" target="_blank" rel="noopener"
                                class="sp-btn <?php echo e($featured ? 'sp-btn-primary' : 'sp-btn-outline'); ?> sp-btn-block"
                                data-d="<?php echo e($dKey); ?>" <?php if($dKey !== $initialDuration): ?> hidden <?php endif; ?>>
                                <?php echo e($tier['state'] === 'new' ? 'تواصل معنا للاشتراك' : 'ترقية اشتراكك'); ?>

                                <i class="fa-solid fa-crown"></i>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php elseif($tier['state'] === 'current'): ?>

                        <span class="sp-btn sp-btn-current sp-btn-block">باقتك الحالية</span>

                    <?php endif; ?>

                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </section>


        
        <?php if (! ($isSubscribed)): ?>
            <section class="sp-compare-wrap">

                <div class="sp-compare-title">
                    <h2>الفرق الذي سيظهر في ملفك</h2>
                    <p>الاشتراك يفتح لك إمكانية إضافة معلومات أكثر للمرضى</p>
                </div>

                <div class="sp-compare">

                    <div class="sp-compare-box after">
                        <div class="sp-compare-head">
                            <span class="sp-compare-icon"><i class="fa-solid fa-circle-check"></i></span>
                            <h3>بعد الاشتراك</h3>
                        </div>
                        <ul>
                            <li><i class="fa-solid fa-circle-check"></i> ملف طبي متكامل بشارة طبيب موثوق</li>
                            <li><i class="fa-solid fa-circle-check"></i> صورتك وصور العيادة وموقعها على الخريطة</li>
                            <li><i class="fa-solid fa-circle-check"></i> الخدمات الطبية وتقييمات المرضى</li>
                            <li><i class="fa-solid fa-circle-check"></i> حجز أونلاين ونظام عيادة (حسب الباقة)</li>
                        </ul>
                    </div>

                    <div class="sp-compare-box before">
                        <div class="sp-compare-head">
                            <span class="sp-compare-icon"><i class="fa-solid fa-lock"></i></span>
                            <h3>قبل الاشتراك</h3>
                        </div>
                        <ul>
                            <li><i class="fa-solid fa-circle-xmark"></i> معلومات أساسية فقط</li>
                            <li><i class="fa-solid fa-circle-xmark"></i> بدون صورة شخصية أو صور عيادة</li>
                            <li><i class="fa-solid fa-circle-xmark"></i> بدون خدمات أو تقييمات أو خريطة</li>
                            <li><i class="fa-solid fa-circle-xmark"></i> بدون حجز أونلاين</li>
                        </ul>
                    </div>

                </div>

            </section>
        <?php endif; ?>




    </div>

    <script>
        (function () {
            const buttons = document.querySelectorAll('.sp-duration button');

            function setDuration(d) {
                buttons.forEach(b => b.classList.toggle('active', b.dataset.duration === d));
                document.querySelectorAll('#spPage [data-d]').forEach(el => {
                    el.hidden = el.dataset.d !== d;
                });
            }

            buttons.forEach(b => b.addEventListener('click', () => setDuration(b.dataset.duration)));
        })();
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/dashboard/subscription/index.blade.php ENDPATH**/ ?>
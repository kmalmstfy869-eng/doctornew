<?php $__env->startSection('title', ' احصائيات مشاهده الملف |لوحة تحكم الطبيب'); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/stats.css')); ?>">
<?php $__env->stopPush(); ?>


<div class="st-page">

    
    <div class="st-head">
        <div>
            <h1>إحصائيات الملف</h1>
            <p>تابع مشاهدات ملفك وزواره على المنصة</p>
        </div>

        <?php if($hasAccess): ?>
            <div class="st-tabs">
                <?php $__currentLoopData = $ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('doctor.stats', ['range' => $key])); ?>" class="<?php echo e($range === $key ? 'active' : ''); ?>"><?php echo e($label); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if(! $hasAccess): ?>

        
        <div class="st-grid two">
            <div class="st-card c-indigo">
                <div class="st-card-top">
                    <span class="st-icon"><i class="fa-solid fa-eye"></i></span>
                    <span class="st-chip">منذ البداية</span>
                </div>
                <div class="st-body">
                    <div class="st-value"><?php echo e(number_format($allTime['views'])); ?></div>
                    <div class="st-label">إجمالي مشاهدات الملف</div>
                </div>
            </div>

            <div class="st-card c-sky">
                <div class="st-card-top">
                    <span class="st-icon"><i class="fa-solid fa-user-group"></i></span>
                    <span class="st-chip">منذ البداية</span>
                </div>
                <div class="st-body">
                    <div class="st-value"><?php echo e(number_format($allTime['unique_visitors'])); ?></div>
                    <div class="st-label">زوار فريدون</div>
                </div>
            </div>
        </div>

        <div class="st-locked">
            <div class="st-fake" aria-hidden="true">
                <div class="st-fake-cards"><div></div><div></div><div></div><div></div></div>
                <div class="st-fake-chart">
                    <svg viewBox="0 0 800 300" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="fk" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0" stop-color="#4f46e5" stop-opacity=".35"/>
                                <stop offset="1" stop-color="#4f46e5" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <path d="M0 240 C80 220 120 250 200 200 S340 120 420 150 S560 60 640 90 S760 30 800 20 L800 300 L0 300Z" fill="url(#fk)"/>
                        <path d="M0 240 C80 220 120 250 200 200 S340 120 420 150 S560 60 640 90 S760 30 800 20" fill="none" stroke="#4f46e5" stroke-width="4" stroke-linecap="round"/>
                        <path d="M0 260 C90 250 140 260 220 225 S360 170 440 185 S580 130 660 140 S760 100 800 90" fill="none" stroke="#0ea5e9" stroke-width="3" stroke-dasharray="8 7" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>

            <div class="st-lock-veil"></div>

            <div class="st-lock-wrap">
                <div class="st-lock-card">
                    <div class="st-crown"><i class="fa-solid fa-crown"></i></div>
                    <h2>اعرف تفاصيل مشاهدات ملفك</h2>
                    <p>اشترك الآن وافتح التحليلات الكاملة لتتابع نمو ملفك يومًا بيوم.</p>

                    <ul class="st-perks">
                        <li><i class="fa-solid fa-chart-line"></i> رسم بياني تفصيلي</li>
                        <li><i class="fa-solid fa-calendar-week"></i> أنشط أيام الأسبوع</li>
                        <li><i class="fa-solid fa-trophy"></i> أفضل يوم لملفك</li>
                        <li><i class="fa-solid fa-gauge-high"></i> متوسط المشاهدات اليومي</li>
                    </ul>

                    <a href="<?php echo e(route('doctor.subscription')); ?>" class="st-cta">
                        <i class="fa-solid fa-crown"></i> اشترك الآن
                    </a>
                </div>
            </div>
        </div>

    <?php else: ?>

        
        <div class="st-grid">
            <div class="st-card c-indigo">
                <div class="st-card-top">
                    <span class="st-icon"><i class="fa-solid fa-eye"></i></span>
                    <span class="st-chip"><i class="fa-regular fa-clock"></i> <?php echo e($ranges[$range]); ?></span>
                </div>
                <div class="st-body">
                    <div class="st-value"><?php echo e(number_format($current['views'])); ?></div>
                    <div class="st-label">مشاهدات الملف</div>
                </div>
            </div>

            <div class="st-card c-sky">
                <div class="st-card-top">
                    <span class="st-icon"><i class="fa-solid fa-user-group"></i></span>
                    <span class="st-chip"><?php echo e(number_format($returning)); ?> متكررة</span>
                </div>
                <div class="st-body">
                    <div class="st-value"><?php echo e(number_format($current['unique_visitors'])); ?></div>
                    <div class="st-label">زوار فريدون</div>
                </div>
            </div>

            <div class="st-card c-green">
                <div class="st-card-top">
                    <span class="st-icon"><i class="fa-solid fa-chart-simple"></i></span>
                    <span class="st-chip">اليوم: <?php echo e(number_format($today['views'])); ?></span>
                </div>
                <div class="st-body">
                    <div class="st-value"><?php echo e($average); ?></div>
                    <div class="st-label">متوسط المشاهدات يوميًا</div>
                </div>
            </div>

            <div class="st-card c-amber">
                <div class="st-card-top">
                    <span class="st-icon"><i class="fa-solid fa-infinity"></i></span>
                    <span class="st-chip">منذ البداية</span>
                </div>
                <div class="st-body">
                    <div class="st-value"><?php echo e(number_format($allTime['views'])); ?></div>
                    <div class="st-label">إجمالي المشاهدات</div>
                </div>
            </div>
        </div>

        
        <div class="st-row">
            <div class="st-panel">
                <h3>أداء الملف</h3>
                <p class="sub">المشاهدات والزوار خلال <?php echo e($ranges[$range]); ?></p>
                <div class="st-legend">
                    <span><i style="background:#4f46e5"></i>المشاهدات</span>
                    <span><i style="background:#0ea5e9"></i>الزوار الفريدون</span>
                </div>
                <div class="st-chart"><canvas id="stChart"></canvas></div>
            </div>

            <div class="st-panel">
                <h3>أنشط أيام الأسبوع</h3>
                <p class="sub">توزيع المشاهدات على أيام الأسبوع</p>
                <div class="st-wd">
                    <?php $__currentLoopData = $weekdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="st-wd-row <?php echo e($w['top'] ? 'top' : ''); ?>">
                            <span><?php echo e($w['name']); ?></span>
                            <div class="st-bar"><span style="width:<?php echo e($w['percent']); ?>%"></span></div>
                            <b><?php echo e($w['views']); ?></b>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php if($bestDay): ?>
                    <div class="st-best">
                        <i class="fa-solid fa-trophy"></i>
                        <span>أفضل يوم: <?php echo e($bestDay['label']); ?> (<?php echo e($bestDay['views']); ?> مشاهدة)</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    <?php endif; ?>
</div>

<?php if($hasAccess): ?>
    <?php $__env->startPush('scripts'); ?>
        <script>window.STATS_CHART = <?php echo json_encode($chart, 15, 512) ?>;</script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
        <script src="<?php echo e(asset('js/doctor/stats.js')); ?>?v=<?php echo e(@filemtime(public_path('js/doctor/stats.js')) ?: time()); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/dashboard/stats/index.blade.php ENDPATH**/ ?>
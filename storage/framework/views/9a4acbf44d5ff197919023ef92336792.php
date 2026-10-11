<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin/site-stats.css')); ?>?v=<?php echo e(@filemtime(public_path('css/admin/site-stats.css')) ?: time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'إحصائيات الزيارات | لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'إحصائيات الزيارات'); ?>
<?php $__env->startSection('page-description', 'مشاهدات الموقع وزواره'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $chip = function ($v) {
            if ($v === null) return null;
            return ['cls' => $v >= 0 ? 'up' : 'down', 'icon' => $v >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down', 'txt' => abs($v) . '%'];
        };
        $vc = $chip($viewsChange);
        $uc = $chip($uniqueChange);
    ?>

    <div class="as-page" dir="rtl">

        
        <div class="as-head">
            <div>
                <h2>إحصائيات الموقع</h2>
                <p>إجمالي المشاهدات والزوار على المنصة</p>
            </div>
            <div class="as-tabs">
                <?php $__currentLoopData = $ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('admin.stats', ['range' => $key])); ?>" class="<?php echo e($range === $key ? 'active' : ''); ?>"><?php echo e($label); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="as-grid">
            <div class="as-card c-indigo">
                <div class="as-card-top">
                    <span class="as-icon"><i class="fa-solid fa-eye"></i></span>
                    <?php if($vc): ?>
                        <span class="as-chip <?php echo e($vc['cls']); ?>"><i class="fa-solid <?php echo e($vc['icon']); ?>"></i> <?php echo e($vc['txt']); ?></span>
                    <?php else: ?>
                        <span class="as-chip"><i class="fa-regular fa-clock"></i> <?php echo e($ranges[$range]); ?></span>
                    <?php endif; ?>
                </div>
                <div class="as-value"><?php echo e(number_format($current['views'])); ?></div>
                <div class="as-label">إجمالي الزيارات</div>
            </div>

            <div class="as-card c-sky">
                <div class="as-card-top">
                    <span class="as-icon"><i class="fa-solid fa-user-group"></i></span>
                    <?php if($uc): ?>
                        <span class="as-chip <?php echo e($uc['cls']); ?>"><i class="fa-solid <?php echo e($uc['icon']); ?>"></i> <?php echo e($uc['txt']); ?></span>
                    <?php else: ?>
                        <span class="as-chip"><?php echo e(number_format($returning)); ?> متكررة</span>
                    <?php endif; ?>
                </div>
                <div class="as-value"><?php echo e(number_format($current['unique'])); ?></div>
                <div class="as-label">الزوار الفريدون</div>
            </div>

            <div class="as-card c-green">
                <div class="as-card-top">
                    <span class="as-icon"><i class="fa-solid fa-chart-simple"></i></span>
                    <span class="as-chip">اليوم: <?php echo e(number_format($today['views'])); ?></span>
                </div>
                <div class="as-value"><?php echo e($average); ?></div>
                <div class="as-label">متوسط الزيارات يوميًا</div>
            </div>

            <div class="as-card c-amber">
                <div class="as-card-top">
                    <span class="as-icon"><i class="fa-solid fa-infinity"></i></span>
                    <span class="as-chip">منذ البداية</span>
                </div>
                <div class="as-value"><?php echo e(number_format($allTime['views'])); ?></div>
                <div class="as-label">إجمالي كل الأوقات</div>
            </div>
        </div>
        <p class="as-note">النسبة على الكروت مقارنة بالفترة السابقة بنفس الطول.</p>

        
        <div class="as-row">
            <div class="dashboard-card as-panel">
                <h3>أداء الموقع</h3>
                <p class="sub">الزيارات والزوار خلال <?php echo e($ranges[$range]); ?></p>
                <div class="as-legend">
                    <span><i style="background:#4f46e5"></i>الزيارات</span>
                    <span><i style="background:#0ea5e9"></i>الزوار الفريدون</span>
                </div>
                <div class="as-chart"><canvas id="asChart"></canvas></div>
                <script type="application/json" id="asChartData"><?php echo json_encode($chart, 15, 512) ?></script>
            </div>

            <div class="dashboard-card as-panel">
                <h3>أنشط أيام الأسبوع</h3>
                <p class="sub">توزيع الزيارات على أيام الأسبوع</p>
                <div class="as-wd">
                    <?php $__currentLoopData = $weekdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="as-wd-row <?php echo e($w['top'] ? 'top' : ''); ?>">
                            <span><?php echo e($w['name']); ?></span>
                            <div class="as-bar"><span style="width:<?php echo e($w['percent']); ?>%"></span></div>
                            <b><?php echo e(number_format($w['views'])); ?></b>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php if($bestDay): ?>
                    <div class="as-best">
                        <i class="fa-solid fa-trophy"></i>
                        <span>أفضل يوم: <?php echo e($bestDay['label']); ?> (<?php echo e(number_format($bestDay['views'])); ?> زيارة)</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="dashboard-card as-panel">
            <h3>مصدر الزيارات</h3>
            <p class="sub">الصفحة الرئيسية مقابل صفحات الأطباء خلال <?php echo e($ranges[$range]); ?></p>

            <div class="as-split">
                <?php $__currentLoopData = [
                    ['key' => 'home', 'name' => 'الصفحة الرئيسية', 'icon' => 'fa-house', 'color' => '#4f46e5'],
                    ['key' => 'profiles', 'name' => 'صفحات الأطباء (إجمالي)', 'icon' => 'fa-user-doctor', 'color' => '#0ea5e9'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $v = $split[$s['key']]['views'];
                        $pct = round($v / $splitMax * 100);
                    ?>
                    <div class="as-split-row">
                        <div class="as-split-top">
                            <span><i class="fa-solid <?php echo e($s['icon']); ?>" style="color:<?php echo e($s['color']); ?>"></i> <?php echo e($s['name']); ?></span>
                            <b><?php echo e(number_format($v)); ?> <small>/ <?php echo e(number_format($split[$s['key']]['unique'])); ?> زائر</small></b>
                        </div>
                        <div class="as-bar"><span style="width:<?php echo e($v > 0 ? max($pct, 2) : 0); ?>%;background:<?php echo e($s['color']); ?>"></span></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra_java'); ?>
    <script src="<?php echo e(asset('js/admin/site-stats.js')); ?>?v=<?php echo e(@filemtime(public_path('js/admin/site-stats.js')) ?: time()); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/stats/index.blade.php ENDPATH**/ ?>
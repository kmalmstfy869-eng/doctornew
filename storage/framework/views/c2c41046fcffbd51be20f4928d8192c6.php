<?php use \App\Services\PatientFileService; ?>

<?php $__env->startSection('title', 'ملفات المرضى والتخزين | لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'ملفات المرضى والتخزين'); ?>
<?php $__env->startSection('page-description', 'نظرة عامة على الملفات والنسخ الاحتياطية ومساحات الأطباء'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.storage._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="stats-grid">

        <a href="<?php echo e(route('admin.storage.files')); ?>" class="stat-card ap-link-card">
            <div class="stat-icon blue-icon"><i class="fa-solid fa-folder-open"></i></div>
            <div class="stat-info">
                <p>ملفات المرضى</p>
                <h3><?php echo e(number_format($totalFiles)); ?></h3>
            </div>
        </a>

        <a href="<?php echo e(route('admin.storage.quotas')); ?>" class="stat-card ap-link-card">
            <div class="stat-icon purple-icon"><i class="fa-solid fa-hard-drive"></i></div>
            <div class="stat-info">
                <p>المساحة المستخدمة (Primary)</p>
                <h3 dir="ltr"><?php echo e(PatientFileService::formatBytes($usedBytes)); ?></h3>
            </div>
        </a>

        <a href="<?php echo e(route('admin.storage.files')); ?>" class="stat-card ap-link-card">
            <div class="stat-icon ap-icon-teal"><i class="fa-solid fa-cloud"></i></div>
            <div class="stat-info">
                <p>حجم النسخ الاحتياطية</p>
                <h3 dir="ltr"><?php echo e(PatientFileService::formatBytes($backupBytes)); ?></h3>
                <span class="ap-hint">من سجلات النسخ</span>
            </div>
        </a>

        <a href="<?php echo e(route('admin.storage.files', ['status' => 'done'])); ?>" class="stat-card ap-link-card">
            <div class="stat-icon green-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div class="stat-info">
                <p>اتنسخ</p>
                <h3><?php echo e(number_format($backedUp)); ?></h3>
            </div>
        </a>

        <a href="<?php echo e(route('admin.storage.files', ['status' => 'pending'])); ?>" class="stat-card ap-link-card">
            <div class="stat-icon orange-icon"><i class="fa-solid fa-hourglass-half"></i></div>
            <div class="stat-info">
                <p>لسه ما اتنسخش</p>
                <h3><?php echo e(number_format($pending)); ?></h3>
                <span class="ap-hint">مستني دوره في الـ Backup الجاي</span>
            </div>
        </a>

        <a href="<?php echo e(route('admin.storage.files', ['status' => 'failed'])); ?>" class="stat-card ap-link-card">
            <div class="stat-icon ap-icon-red"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="stat-info">
                <p>فشل نسخها</p>
                <h3><?php echo e(number_format($failed)); ?></h3>
            </div>
        </a>

        <a href="<?php echo e(route('admin.storage.restore')); ?>" class="stat-card ap-link-card">
            <div class="stat-icon blue-icon"><i class="fa-solid fa-rotate-left"></i></div>
            <div class="stat-info">
                <p>ملفات قابلة للاسترجاع</p>
                <h3><?php echo e(number_format($restorable)); ?></h3>
                <span class="ap-hint">منهم <?php echo e(number_format($deletedKept)); ?> الأصل اتحذف</span>
            </div>
        </a>

        <a href="<?php echo e(route('admin.storage.quotas', ['limit' => 'attention'])); ?>" class="stat-card ap-link-card">
            <div class="stat-icon ap-icon-red"><i class="fa-solid fa-gauge-high"></i></div>
            <div class="stat-info">
                <p>أطباء قربوا من الحد</p>
                <h3><?php echo e(number_format($attention->count())); ?></h3>
                <span class="ap-hint"><?php echo e(config('clinic.patient_files_near_limit_percent', 90)); ?>% أو أكتر</span>
            </div>
        </a>

    </div>

    <div class="ap-grid-2" style="margin-top:1rem">

        
        <div class="dashboard-card ap-card">
            <div class="ap-card__head">
                <div>
                    <h3>آخر تشغيل للنسخ الاحتياطي</h3>
                    <p>الجدولة اليومية الساعة 4 الفجر بتوقيت القاهرة</p>
                </div>
                <?php echo $__env->make('admin.storage._run_button', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div class="ap-card__body">
                <?php if($lastRun): ?>
                    <div class="ap-kv">
                        <div><span>الحالة</span><b><span class="ap-badge ap-badge--<?php echo e($lastRun->status_tone); ?>"><?php echo e($lastRun->status_label); ?></span></b></div>
                        <div><span>بدأ</span><b><?php echo e($lastRun->started_label); ?></b></div>
                        <div><span>المدة</span><b><?php echo e($lastRun->duration_label); ?></b></div>
                        <div><span>اتنسخ</span><b><?php echo e($lastRun->copied_count); ?> (<?php echo e(PatientFileService::formatBytes((int) $lastRun->copied_bytes)); ?>)</b></div>
                        <div><span>فشل</span><b><?php echo e($lastRun->failed_count); ?></b></div>
                        <div><span>اتمسح بعد الاحتفاظ</span><b><?php echo e($lastRun->purged_count); ?></b></div>
                        <div style="grid-column:1/-1"><span>آخر تشغيل ناجح</span><b><?php echo e($lastSuccess ? $lastSuccess->finished_label : 'لسه مفيش تشغيل ناجح'); ?></b></div>
                    </div>

                    <?php if($lastRun->error): ?>
                        <div class="ap-alert ap-alert--bad" style="margin-top:1rem"><?php echo e($lastRun->error); ?></div>
                    <?php endif; ?>

                    <a href="<?php echo e(route('admin.storage.runs')); ?>" class="ap-btn ap-btn--ghost ap-btn--sm" style="margin-top:1rem">كل التشغيلات</a>
                <?php else: ?>
                    <div class="ap-empty">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <h4>مفيش تشغيل لسه</h4>
                        <p>دوس "شغّل Backup الآن" أو استنى الجدولة اليومية.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="dashboard-card ap-card">
            <div class="ap-card__head">
                <div>
                    <h3>أطباء قربوا من الحد</h3>
                    <p>الأعلى استهلاكًا</p>
                </div>
                <a href="<?php echo e(route('admin.storage.quotas')); ?>" class="ap-btn ap-btn--ghost ap-btn--sm">إدارة المساحات</a>
            </div>

            <div class="ap-card__body">
                <?php $__empty_1 = true; $__currentLoopData = $attention->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $limit = (float) $d->patient_files_quota_gb * 1073741824;
                        $used = (int) $d->used_bytes;
                        $pct = $limit > 0 ? min(100, round($used / $limit * 100, 1)) : 100;
                        $tone = $used >= $limit ? 'bad' : 'warn';
                    ?>
                    <div style="margin-bottom:1rem">
                        <div style="display:flex;justify-content:space-between;gap:.5rem;font-size:.85rem;font-weight:800">
                            <span>د. <?php echo e($d->doctor_name); ?></span>
                            <span dir="ltr"><?php echo e(PatientFileService::formatBytes($used)); ?> / <?php echo e(rtrim(rtrim(number_format((float) $d->patient_files_quota_gb, 2), '0'), '.')); ?> GB</span>
                        </div>
                        <div class="ap-meter-row" style="margin-top:.4rem">
                            <div class="ap-meter ap-meter--<?php echo e($tone); ?>" style="flex:1"><span style="width: <?php echo e(max($pct, 2)); ?>%"></span></div>
                            <small><?php echo e($pct); ?>%</small>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="ap-empty">
                        <i class="fa-solid fa-circle-check"></i>
                        <h4>كله تمام</h4>
                        <p>مفيش طبيب قرب من حد المساحة.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/storage/overview.blade.php ENDPATH**/ ?>
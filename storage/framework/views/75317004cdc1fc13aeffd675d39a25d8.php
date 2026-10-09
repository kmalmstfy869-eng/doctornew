<?php use \App\Services\PatientFileService; ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'سجل النسخ الاحتياطي | لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'سجل تشغيل النسخ الاحتياطي'); ?>
<?php $__env->startSection('page-description', 'كل تشغيل للـ Backup ونتيجته'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.storage._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="dashboard-card ap-card">

        <div class="ap-card__head">
            <div>
                <h3>التشغيلات</h3>
                <p><?php echo e($runs->total()); ?> تشغيل • "جزئي" مش بيتحسب نجاح كامل</p>
            </div>
            <?php echo $__env->make('admin.storage._run_button', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <form method="GET" class="ap-filters">
            <div class="ap-field">
                <label>الحالة</label>
                <select name="status" class="ap-input" onchange="this.form.submit()">
                    <option value="">الكل</option>
                    <option value="success" <?php if($status === 'success'): echo 'selected'; endif; ?>>ناجح</option>
                    <option value="partial" <?php if($status === 'partial'): echo 'selected'; endif; ?>>جزئي</option>
                    <option value="failed" <?php if($status === 'failed'): echo 'selected'; endif; ?>>فشل</option>
                    <option value="running" <?php if($status === 'running'): echo 'selected'; endif; ?>>شغال / معلّق</option>
                </select>
            </div>
            <div class="ap-field">
                <label>من</label>
                <input type="date" name="from" value="<?php echo e($from); ?>" class="ap-input" onchange="this.form.submit()">
            </div>
            <div class="ap-field">
                <label>إلى</label>
                <input type="date" name="to" value="<?php echo e($to); ?>" class="ap-input" onchange="this.form.submit()">
            </div>
            <a href="<?php echo e(route('admin.storage.runs')); ?>" class="ap-btn ap-btn--ghost">مسح الفلاتر</a>
        </form>

        <?php if($runs->isEmpty()): ?>
            <div class="ap-empty">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <h4>لا توجد تشغيلات</h4>
                <p>مفيش تشغيل مطابق للفلاتر.</p>
            </div>
        <?php else: ?>
            <div class="ap-table-wrap">
                <table class="ap-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>البداية</th>
                            <th>النهاية</th>
                            <th>المدة</th>
                            <th>الحالة</th>
                            <th>اتنسخ</th>
                            <th>فشل</th>
                            <th>اتمسح</th>
                            <th>الحجم</th>
                            <th>الخطأ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $runs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $run): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td data-label="#"><span class="ap-num"><?php echo e($run->id); ?></span></td>
                                <td data-label="البداية"><?php echo e($run->started_label); ?></td>
                                <td data-label="النهاية"><?php echo e($run->finished_label); ?></td>
                                <td data-label="المدة"><?php echo e($run->duration_label); ?></td>
                                <td data-label="الحالة"><span class="ap-badge ap-badge--<?php echo e($run->status_tone); ?>"><?php echo e($run->status_label); ?></span></td>
                                <td data-label="اتنسخ"><span class="ap-num"><?php echo e($run->copied_count); ?></span></td>
                                <td data-label="فشل"><span class="ap-num <?php echo e($run->failed_count ? 'ap-minus' : ''); ?>"><?php echo e($run->failed_count); ?></span></td>
                                <td data-label="اتمسح"><span class="ap-num"><?php echo e($run->purged_count); ?></span></td>
                                <td data-label="الحجم"><span class="ap-num" dir="ltr"><?php echo e(PatientFileService::formatBytes((int) $run->copied_bytes)); ?></span></td>
                                <td data-label="الخطأ">
                                    <?php if($run->error): ?>
                                        <details><summary class="ap-minus" style="cursor:pointer">عرض</summary><div class="ap-err"><?php echo e($run->error); ?></div></details>
                                    <?php else: ?>
                                        <span class="ap-sub">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="ap-card__foot"><?php echo e($runs->links('vendor.pagination.custom')); ?></div>
        <?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/storage/runs.blade.php ENDPATH**/ ?>
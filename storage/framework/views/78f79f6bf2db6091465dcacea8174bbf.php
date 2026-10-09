<?php use \App\Services\PatientFileService; ?>

<?php if($rows->isEmpty()): ?>
    <div class="ap-empty">
        <i class="fa-regular fa-folder-open"></i>
        <h4><?php echo e(request()->hasAny(['search', 'doctor_id', 'status', 'type', 'from', 'to']) ? 'لا توجد نتائج مطابقة' : 'لا توجد بيانات'); ?></h4>
        <p>جرّب تغيّر البحث أو الفلاتر.</p>
    </div>
<?php elseif($view === 'deleted'): ?>

    
    <div class="ap-table-wrap">
        <table class="ap-table">
            <thead>
                <tr>
                    <th>الملف</th>
                    <th>الدكتور / المريض</th>
                    <th>حجم النسخة</th>
                    <th>اتحذف من الـ Primary</th>
                    <th>تتمسح بعد</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $expires = $b->source_deleted_at->copy()->addDays($retention);
                        $left = max(0, (int) ceil(now()->diffInDays($expires, false)));
                    ?>
                    <tr>
                        <td data-label="الملف">
                            <div>
                                <div class="ap-title"><?php echo e($b->original_name); ?></div>
                                <div class="ap-sub"><?php echo e(str_starts_with((string) $b->mime_type, 'image/') ? 'صورة' : 'PDF'); ?></div>
                            </div>
                        </td>
                        <td data-label="الدكتور / المريض">
                            <div>
                                <div class="ap-title">د. <?php echo e($b->doctor_name ?? '—'); ?></div>
                                <div class="ap-sub"><?php echo e($b->patient_name ?? 'مريض محذوف'); ?></div>
                            </div>
                        </td>
                        <td data-label="حجم النسخة"><span class="ap-num" dir="ltr"><?php echo e(PatientFileService::formatBytes((int) $b->size)); ?></span></td>
                        <td data-label="اتحذف"><?php echo e($b->source_deleted_at->copy()->timezone('Africa/Cairo')->translatedFormat('d M Y')); ?></td>
                        <td data-label="تتمسح بعد"><span class="ap-badge <?php echo e($left <= 5 ? 'ap-badge--bad' : 'ap-badge--warn'); ?>"><?php echo e($left); ?> يوم</span></td>
                        <td data-label=""><?php echo $__env->make('admin.storage._restore_btn', ['id' => $b->id, 'deleted' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

<?php else: ?>

    
    <div class="ap-table-wrap">
        <table class="ap-table">
            <thead>
                <tr>
                    <th>الملف</th>
                    <th>الدكتور / المريض</th>
                    <th>الحجم</th>
                    <th>تاريخ الرفع</th>
                    <th>الـ Primary</th>
                    <th>النسخة الاحتياطية</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td data-label="الملف">
                            <div>
                                <div class="ap-title"><?php echo e($f->original_name); ?></div>
                                <div class="ap-sub">#<?php echo e($f->id); ?> • <?php echo e(str_starts_with((string) $f->mime_type, 'image/') ? 'صورة' : 'PDF'); ?></div>
                            </div>
                        </td>
                        <td data-label="الدكتور / المريض">
                            <div>
                                <div class="ap-title">د. <?php echo e($f->doctor_name ?? '—'); ?></div>
                                <div class="ap-sub"><?php echo e($f->patient_name ?? 'مريض محذوف'); ?></div>
                            </div>
                        </td>
                        <td data-label="الحجم"><span class="ap-num" dir="ltr"><?php echo e(PatientFileService::formatBytes((int) $f->size)); ?></span></td>
                        <td data-label="تاريخ الرفع"><?php echo e($f->created_at?->copy()->timezone('Africa/Cairo')->translatedFormat('d M Y')); ?></td>
                        <td data-label="الـ Primary">
                            <span class="ap-badge <?php echo e($f->primary_ok ? 'ap-badge--ok' : 'ap-badge--bad'); ?>"><?php echo e($f->primary_ok ? 'موجود' : 'مفقود'); ?></span>
                        </td>
                        <td data-label="النسخة الاحتياطية">
                            <div>
                                <?php if($f->backed_up_at): ?>
                                    <span class="ap-badge ap-badge--ok"><i class="fa-solid fa-check"></i> اتنسخ</span>
                                    <div class="ap-sub"><?php echo e(\Carbon\Carbon::parse($f->backed_up_at)->timezone('Africa/Cairo')->translatedFormat('d M Y - h:i A')); ?></div>
                                <?php elseif($f->backup_last_error): ?>
                                    <span class="ap-badge ap-badge--bad"><i class="fa-solid fa-xmark"></i> فشل النسخ</span>
                                    <div class="ap-err"><?php echo e($f->backup_last_error); ?></div>
                                <?php else: ?>
                                    <span class="ap-badge ap-badge--warn"><i class="fa-solid fa-hourglass-half"></i> لسه ما اتنسخش</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td data-label="إجراء">
                            
                            <?php if(! $f->primary_ok && $f->backup_id): ?>
                                <?php echo $__env->make('admin.storage._restore_btn', ['id' => $f->backup_id, 'deleted' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php else: ?>
                                <span class="ap-sub">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/storage/_files_list.blade.php ENDPATH**/ ?>
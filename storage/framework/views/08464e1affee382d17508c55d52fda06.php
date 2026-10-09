<?php use \App\Services\PatientFileService; ?>

<?php if($rows->isEmpty()): ?>
    <div class="ap-empty">
        <i class="fa-solid fa-box-archive"></i>
        <h4>لا توجد نسخ</h4>
        <p>مفيش نسخ احتياطية مطابقة للبحث.</p>
    </div>
<?php else: ?>
    <div class="ap-table-wrap">
        <table class="ap-table">
            <thead>
                <tr>
                    <th>الملف</th>
                    <th>الدكتور / المريض</th>
                    <th>تاريخ النسخة</th>
                    <th>الأصل في الـ Primary</th>
                    <th>سجل الداتابيز</th>
                    <th>الحالة</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $deleted = (bool) $b->source_deleted_at;
                        $needs = ! $b->primary_ok || ! $b->row_ok;
                    ?>
                    <tr>
                        <td data-label="الملف">
                            <div>
                                <div class="ap-title"><?php echo e($b->original_name); ?></div>
                                <div class="ap-sub" dir="ltr" style="text-align:start"><?php echo e(PatientFileService::formatBytes((int) $b->size)); ?></div>
                            </div>
                        </td>
                        <td data-label="الدكتور / المريض">
                            <div>
                                <div class="ap-title">د. <?php echo e($b->doctor_name ?? '—'); ?></div>
                                <div class="ap-sub"><?php echo e($b->patient_name ?? 'مريض محذوف'); ?></div>
                            </div>
                        </td>
                        <td data-label="تاريخ النسخة"><?php echo e($b->backed_up_at?->copy()->timezone('Africa/Cairo')->translatedFormat('d M Y')); ?></td>
                        <td data-label="الأصل"><span class="ap-badge <?php echo e($b->primary_ok ? 'ap-badge--ok' : 'ap-badge--bad'); ?>"><?php echo e($b->primary_ok ? 'موجود' : 'مفقود'); ?></span></td>
                        <td data-label="السجل"><span class="ap-badge <?php echo e($b->row_ok ? 'ap-badge--ok' : 'ap-badge--bad'); ?>"><?php echo e($b->row_ok ? 'موجود' : 'ناقص'); ?></span></td>
                        <td data-label="الحالة">
                            <?php if($deleted): ?>
                                <span class="ap-badge ap-badge--warn">اتحذف عمدًا</span>
                                <div class="ap-sub">يتمسح بعد <?php echo e(max(0, (int) ceil(now()->diffInDays($b->source_deleted_at->copy()->addDays($retention), false)))); ?> يوم</div>
                            <?php elseif($needs): ?>
                                <span class="ap-badge ap-badge--bad">ضايع (محتاج استرجاع)</span>
                            <?php else: ?>
                                <span class="ap-badge ap-badge--ok">سليم</span>
                            <?php endif; ?>
                        </td>
                        <td data-label="إجراء">
                            <?php if($deleted || $needs): ?>
                                <?php echo $__env->make('admin.storage._restore_btn', ['id' => $b->id, 'deleted' => $deleted], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/storage/_restore_list.blade.php ENDPATH**/ ?>
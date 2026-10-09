<?php use \App\Services\PatientFileService; ?>

<?php if($doctors->isEmpty()): ?>
    <div class="ap-empty">
        <i class="fa-solid fa-user-doctor"></i>
        <h4>لا يوجد أطباء</h4>
        <p>مفيش طبيب مطابق للبحث أو الفلتر.</p>
    </div>
<?php else: ?>
    <div class="ap-table-wrap">
        <table class="ap-table">
            <thead>
                <tr>
                    <th>الدكتور</th>
                    <th>المسموح</th>
                    <th>المستخدم</th>
                    <th>المتبقي</th>
                    <th>الاستهلاك</th>
                    <th>الملفات</th>
                    <th>الحالة</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $quotaGb = (float) $d->patient_files_quota_gb;
                        $limitBytes = $quotaGb * 1073741824;
                        $used = (int) $d->used_bytes;
                        $pct = $limitBytes > 0 ? min(100, round($used / $limitBytes * 100, 1)) : 100;
                        $full = $used >= $limitBytes;
                        $near = ! $full && $pct >= config('clinic.patient_files_near_limit_percent', 90);
                        $tone = $full ? 'bad' : ($near ? 'warn' : 'ok');
                        $quotaLabel = rtrim(rtrim(number_format($quotaGb, 3), '0'), '.');
                    ?>
                    <tr>
                        <td data-label="الدكتور">
                            <div>
                                <div class="ap-title">د. <?php echo e($d->doctor_name); ?></div>
                                <div class="ap-sub"><?php echo e($d->doctor_email); ?></div>
                            </div>
                        </td>
                        <td data-label="المسموح"><span class="ap-num" dir="ltr"><?php echo e($quotaLabel); ?> GB</span></td>
                        <td data-label="المستخدم"><span class="ap-num" dir="ltr"><?php echo e(PatientFileService::formatBytes($used)); ?></span></td>
                        <td data-label="المتبقي"><span class="ap-num" dir="ltr"><?php echo e(PatientFileService::formatBytes((int) max(0, $limitBytes - $used), true)); ?></span></td>
                        <td data-label="الاستهلاك">
                            <div class="ap-meter-row">
                                <div class="ap-meter ap-meter--<?php echo e($tone); ?>" style="flex:1"><span style="width: <?php echo e($used > 0 ? max($pct, 2) : 0); ?>%"></span></div>
                                <small><?php echo e($pct); ?>%</small>
                            </div>
                        </td>
                        <td data-label="الملفات"><span class="ap-num"><?php echo e(number_format($d->files_count)); ?></span></td>
                        <td data-label="الحالة">
                            <span class="ap-badge ap-badge--<?php echo e($tone); ?>"><?php echo e($full ? 'ممتلئ' : ($near ? 'قرب من الحد' : 'طبيعي')); ?></span>
                        </td>
                        <td data-label="إجراء">
                            <button type="button" class="ap-btn ap-btn--primary ap-btn--sm"
                                @click="$dispatch('ap-quota-open', <?php echo \Illuminate\Support\Js::from([
                                    'id' => $d->id,
                                    'name' => $d->doctor_name,
                                    'quota' => $quotaGb,
                                    'used' => PatientFileService::formatBytes($used),
                                    'used_bytes' => $used,
                                    'files' => (int) $d->files_count,
                                ])->toHtml() ?>)">
                                <i class="fa-solid fa-sliders"></i> تعديل
                            </button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/storage/_quotas_list.blade.php ENDPATH**/ ?>
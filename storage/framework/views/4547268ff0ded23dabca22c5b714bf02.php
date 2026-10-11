<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet"
        href="<?php echo e(asset('css/admin/job-details.css')); ?>?v=<?php echo e(@filemtime(public_path('css/admin/job-details.css')) ?: time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'لوحة الإدارة | تفاصيل الوظيفة'); ?>

<?php $__env->startSection('page-title', 'تفاصيل الوظيفة'); ?>

<?php $__env->startSection('page-description', 'عرض جميع تفاصيل الوظيفة'); ?>

<?php $__env->startSection('content'); ?>

    <?php
        $money = fn ($v) => ($v !== null && $v !== '') ? number_format((float) $v) . ' ج.م' : 'غير محدد';
        $deadline = $job->application_deadline
            ? \Carbon\Carbon::parse($job->application_deadline)->format('Y-m-d')
            : 'غير محدد';
        $waNumber = preg_replace('/\D/', '', (string) $job->whatsapp);
    ?>

    <div class="jd-page">

        
        <header class="users-card jd-card jd-hero">

            <div class="title-icon">
                <i class="fa-solid fa-briefcase"></i>
            </div>

            <div class="jd-hero__main">
                <h2><?php echo e($job->title); ?></h2>

                <p class="jd-hero__sub">
                    <?php echo e($job->company_name); ?> — نشرها <strong><?php echo e($job->user->name); ?></strong>
                </p>

                <div class="jd-chips">
                    <?php if($job->location): ?>
                        <span class="jd-chip"><i class="fa-solid fa-location-dot"></i> <?php echo e($job->location); ?></span>
                    <?php endif; ?>
                    <span class="jd-chip"><i class="fa-solid fa-business-time"></i> <?php echo e($job->job_type); ?></span>
                    <span class="jd-chip"><i class="fa-solid fa-medal"></i> <?php echo e($job->experience); ?></span>
                    <span class="jd-chip"><i class="fa-solid fa-users"></i> <?php echo e($job->vacancies); ?> وظيفة مطلوبة</span>
                </div>
            </div>

            <div class="jd-hero__status">
                <?php if($job->status === 'pending'): ?>

                    <span class="status-badge pending">
                        <i class="fa-solid fa-clock"></i>
                        قيد المراجعة
                    </span>

                <?php elseif($job->status === 'approved'): ?>

                    <span class="status-badge has-jobs">
                        <i class="fa-solid fa-circle-check"></i>
                        مقبولة
                    </span>

                <?php else: ?>

                    <span class="status-badge rejected">
                        <i class="fa-solid fa-circle-xmark"></i>
                        مرفوضة
                    </span>

                <?php endif; ?>
            </div>

        </header>


        
        <div class="jd-grid">

            <section class="users-card jd-card">
                <div class="jd-sec__head">
                    <i class="fa-solid fa-address-book"></i>
                    <h3>التواصل والنشر</h3>
                </div>
                <dl class="jd-list">
                    <div class="jd-row">
                        <dt>رقم الهاتف</dt>
                        <dd>
                            <?php if($job->phone): ?>
                                <a class="jd-link" href="tel:<?php echo e($job->phone); ?>">
                                    <i class="fa-solid fa-phone"></i><?php echo e($job->phone); ?>

                                </a>
                            <?php else: ?>
                                <span class="jd-muted">غير محدد</span>
                            <?php endif; ?>
                        </dd>
                    </div>
                    <div class="jd-row">
                        <dt>واتساب</dt>
                        <dd>
                            <?php if($waNumber): ?>
                                <a class="jd-link jd-link--wa" href="https://wa.me/<?php echo e($waNumber); ?>" target="_blank" rel="noopener">
                                    <i class="fa-brands fa-whatsapp"></i><?php echo e($job->whatsapp); ?>

                                </a>
                            <?php else: ?>
                                <span class="jd-muted">غير محدد</span>
                            <?php endif; ?>
                        </dd>
                    </div>
                    <div class="jd-row">
                        <dt>صاحب الوظيفة</dt>
                        <dd><?php echo e($job->user->name); ?></dd>
                    </div>
                    <div class="jd-row">
                        <dt>تاريخ النشر</dt>
                        <dd><?php echo e($job->created_at?->format('Y-m-d')); ?></dd>
                    </div>
                </dl>
            </section>

            <section class="users-card jd-card">
                <div class="jd-sec__head">
                    <i class="fa-solid fa-list-check"></i>
                    <h3>تفاصيل الوظيفة</h3>
                </div>
                <dl class="jd-list">
                    <div class="jd-row"><dt>اسم الوظيفة</dt><dd><?php echo e($job->title); ?></dd></div>
                    <div class="jd-row"><dt>اسم الشركة</dt><dd><?php echo e($job->company_name); ?></dd></div>
                    <div class="jd-row"><dt>التصنيف</dt><dd><?php echo e($job->category); ?></dd></div>
                    <div class="jd-row"><dt>المؤهل</dt><dd><?php echo e($job->qualification); ?></dd></div>
                    <div class="jd-row"><dt>الموقع</dt><dd><?php echo e($job->location ?? 'غير محدد'); ?></dd></div>
                    <div class="jd-row"><dt>نوع العمل</dt><dd><?php echo e($job->job_type); ?></dd></div>
                    <div class="jd-row"><dt>الخبرة</dt><dd><?php echo e($job->experience); ?></dd></div>
                </dl>
            </section>

            <section class="users-card jd-card">
                <div class="jd-sec__head">
                    <i class="fa-solid fa-sack-dollar"></i>
                    <h3>الراتب والدوام</h3>
                </div>
                <dl class="jd-list">
                    <div class="jd-row"><dt>الحد الأدنى للراتب</dt><dd><?php echo e($money($job->salary_min)); ?></dd></div>
                    <div class="jd-row"><dt>الحد الأقصى للراتب</dt><dd><?php echo e($money($job->salary_max)); ?></dd></div>
                    <div class="jd-row"><dt>عدد الوظائف المطلوبة</dt><dd><?php echo e($job->vacancies); ?></dd></div>
                    <div class="jd-row"><dt>ساعات العمل</dt><dd><?php echo e($job->working_hours ?? 'غير محدد'); ?></dd></div>
                    <div class="jd-row"><dt>أيام العمل</dt><dd><?php echo e($job->working_days ?? 'غير محدد'); ?></dd></div>
                    <div class="jd-row"><dt>آخر موعد للتقديم</dt><dd><?php echo e($deadline); ?></dd></div>
                </dl>
            </section>

        </div>


        
        <section class="users-card jd-card">
            <div class="jd-sec__head">
                <i class="fa-solid fa-align-right"></i>
                <h3>الوصف</h3>
            </div>
            <div class="jd-desc__body"><?php echo e(trim((string) $job->description) !== '' ? $job->description : 'لا يوجد وصف.'); ?></div>
        </section>


        
        <div class="users-card jd-card jd-actions">

            <?php if($job->status !== 'approved'): ?>

                <form method="POST" action="<?php echo e(route('admin.jobs.approve', $job->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <button type="submit" class="jd-btn jd-btn--ok" title="قبول الوظيفة">
                        <i class="fa-solid fa-check"></i> قبول
                    </button>
                </form>

            <?php endif; ?>


            <?php if($job->status !== 'rejected'): ?>

                <form method="POST" action="<?php echo e(route('admin.jobs.reject', $job->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <button type="submit" class="jd-btn jd-btn--reject" title="رفض الوظيفة">
                        <i class="fa-solid fa-xmark"></i> رفض
                    </button>
                </form>

            <?php endif; ?>


            <form method="POST" action="<?php echo e(route('admin.jobs.destroy', $job->id)); ?>"
                onsubmit="return confirm('هل أنت متأكد من حذف هذه الوظيفة؟');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>

                <button type="submit" class="jd-btn jd-btn--delete" title="حذف الوظيفة">
                    <i class="fa-solid fa-trash"></i> حذف
                </button>
            </form>

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/jobs/job_show.blade.php ENDPATH**/ ?>
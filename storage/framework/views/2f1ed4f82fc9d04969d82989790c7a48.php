


<div class="profile-form">

    <div class="profile-form-header">

        <div>

            <h2>
                وظائفي
            </h2>

            <p>
                إدارة الوظائف التي قمت بنشرها على الموقع.
            </p>

        </div>

        <a href="<?php echo e(route('jobs.create')); ?>"
           class="settings-primary-button">

            <i class="fa-solid fa-plus"></i>

            نشر وظيفة

        </a>

    </div>


    <?php if($jobs->count()): ?>

        <div class="jobs-list">

            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="job-item">

                    <div class="job-item-icon">

                        <i class="fa-solid fa-briefcase"></i>

                    </div>


                    <div class="job-item-content">

                        <h3>
                            <?php echo e($job->title); ?>

                        </h3>

                        <div class="job-item-meta">

                            <span>

                                <i class="fa-regular fa-calendar"></i>

                                <?php echo e($job->created_at->format('Y-m-d')); ?>


                            </span>


                            <?php if($job->status === 'pending'): ?>

                                <span class="job-status pending">

                                    <i class="fa-solid fa-clock"></i>

                                    قيد المراجعة

                                </span>

                            <?php elseif($job->status === 'approved'): ?>

                                <span class="job-status approved">

                                    <i class="fa-solid fa-circle-check"></i>

                                    منشورة

                                </span>

                            <?php elseif($job->status === 'rejected'): ?>

                                <span class="job-status rejected">

                                    <i class="fa-solid fa-circle-xmark"></i>

                                    مرفوضة

                                </span>

                            <?php endif; ?>

                        </div>

                    </div>


                    <div class="job-item-actions">

                        <a
                            href="<?php echo e(route('jobs.show', $job)); ?>"
                            class="job-action view">

                            <i class="fa-solid fa-eye"></i>

                            عرض

                        </a>


                        <a
                            href="<?php echo e(route('jobs.edit', $job)); ?>"
                            class="job-action edit">

                            <i class="fa-solid fa-pen"></i>

                            تعديل

                        </a>


                        <form
                            action="<?php echo e(route('jobs.destroy', $job)); ?>"
                            method="POST"
                            onsubmit="return confirm('هل أنت متأكد من حذف هذه الوظيفة؟');">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button
                                type="submit"
                                class="job-action delete">

                                <i class="fa-solid fa-trash"></i>

                                حذف

                            </button>

                        </form>

                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    <?php else: ?>

        <div class="empty-state">

            <div class="empty-state-icon">

                <i class="fa-solid fa-briefcase"></i>

            </div>

            <h3>
                لا توجد وظائف
            </h3>

            <p>
                لم تقم بنشر أي وظيفة حتى الآن.
            </p>

            <a href="<?php echo e(route('jobs.create')); ?>"
               class="settings-primary-button">

                <i class="fa-solid fa-plus"></i>

                نشر وظيفة جديدة

            </a>

        </div>

    <?php endif; ?>

</div>

<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/settings/sections/jobs.blade.php ENDPATH**/ ?>
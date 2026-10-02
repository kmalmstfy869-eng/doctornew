<?php if($jobs->isNotEmpty()): ?>

    <div class="jobs-list" id="jobsList">

        <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="job-card">

                <div class="job-card-top">
                    <div class="job-icon">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                </div>

                <span class="job-category">
                    <?php echo e($job->category); ?>

                </span>

                <h3 class="job-title">
                    <?php echo e($job->title); ?>

                </h3>

                <p class="company-name">
                    <?php echo e($job->company_name); ?>

                </p>

                <div class="job-info">

                    <div class="job-info-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <?php echo e($job->location ?? 'لم يتم التحديد'); ?>

                    </div>

                    <div class="job-info-item">
                        <i class="fa-solid fa-clock"></i>
                        <?php echo e($job->job_type); ?>

                    </div>

                </div>

                <div class="job-salary">

                    <span class="salary-label">
                        الراتب المتوقع
                    </span>

                    <span class="salary-value">
                        <?php if($job->salary_min && $job->salary_max): ?>
                            <?php echo e($job->salary_min); ?> - <?php echo e($job->salary_max); ?> جنيه
                        <?php elseif($job->salary_min): ?>
                            من <?php echo e($job->salary_min); ?> جنيه
                        <?php elseif($job->salary_max): ?>
                            حتى <?php echo e($job->salary_max); ?> جنيه
                        <?php else: ?>
                            غير محدد
                        <?php endif; ?>
                    </span>

                </div>

                <div class="job-footer">
                    <a href="<?php echo e(route('jobs.show', $job->id)); ?>" class="details-btn">
                        عرض التفاصيل
                    </a>
                </div>

            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

    <div class="pagination" id="pagination">
        <?php echo e($jobs->links('vendor.pagination.custom')); ?>

    </div>

<?php else: ?>

    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-briefcase','title' => 'لا توجد وظائف الآن','content' => 'جرّب تغيير كلمة البحث أو ابحث في وقت لاحق']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-briefcase','title' => 'لا توجد وظائف الآن','content' => 'جرّب تغيير كلمة البحث أو ابحث في وقت لاحق']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $attributes = $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $component = $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>

<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/jobs/_grid.blade.php ENDPATH**/ ?>
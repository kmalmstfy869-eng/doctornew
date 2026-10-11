<?php $__env->startSection('title', 'لوحة الإدارة | الوظائف'); ?>

<?php $__env->startSection('page-title', 'الوظائف'); ?>

<?php $__env->startSection('page-description', 'عرض وإدارة الوظائف المنشورة على المنصة'); ?>

<?php $__env->startSection('content'); ?>

    <div class="users-page">

        <div class="users-header">

            <div class="users-title">

                <div class="title-icon">
                    <i class="fa-solid fa-briefcase"></i>
                </div>

                <div>

                    <h2>
                        <?php if(isset($user) && $user): ?>
                            وظائف <?php echo e($user->name); ?>

                        <?php else: ?>
                            جميع الوظائف
                        <?php endif; ?>
                    </h2>

                    <p>
                        <?php if(isset($user) && $user): ?>
                            جميع الوظائف التي قام المستخدم بنشرها
                        <?php else: ?>
                            جميع الوظائف المنشورة على المنصة
                        <?php endif; ?>
                    </p>

                </div>
            <div class="users-count-card">

                <div class="users-count-icon">

                    <i class="fa-solid fa-users"></i>

                </div>

                <div class="users-count-data">

                    <span>
                        إجمالي الوظائف
                    </span>

                    <strong>
                        <?php echo e($jobs->total()); ?>

                    </strong>

                </div>

            </div>
            </div>


            <?php if(isset($user) && $user): ?>
                <a href="<?php echo e(route('admin.jobs.index')); ?>" class="doctor-button-card">

                    عرض جميع الوظائف

                    <i class="fa-solid fa-briefcase"></i>

                </a>
            <?php endif; ?>

        </div>


        <div class="users-card">

            <div class="table-responsive">

                <table class="users-table">

                    <thead>

                        <tr>

                            <th>

                            </th>

                            <th>
                                الوظيفة
                            </th>

                            <th>
                                بواسطة
                            </th>

                            <th>
                                الشركة
                            </th>

                            <th>
                                التصنيف
                            </th>

                            <th>
                                نوع العمل
                            </th>

                            <th>
                                المكان
                            </th>

                            <th>
                                الحالة
                            </th>

                            <th>
                                تاريخ النشر
                            </th>

                            <th>
                                الإجراءات
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>

                                <td>
                                    🧡<?php echo e($jobs->firstItem() + $loop->index); ?>

                                </td>


                                <td>

                                    <div class="user-info">

                                        <div class="user-avatar">

                                            <i class="fa-solid fa-briefcase"></i>

                                        </div>

                                        <div class="user-data">

                                            <strong>
                                                <?php echo e($job->title); ?>

                                            </strong>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <?php echo e($job->user->name ?? 'مستخدم غير معروف'); ?>


                                </td>


                                <td>
                                    <?php echo e($job->company_name); ?>

                                </td>


                                <td>
                                    <?php echo e($job->category); ?>

                                </td>


                                <td>
                                    <?php echo e($job->job_type); ?>

                                </td>


                                <td>
                                    <?php echo e($job->location ?? 'غير محدد'); ?>

                                </td>


                                <td>

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

                                </td>


                                <td>

                                    <?php echo e($job->created_at?->format('Y-m-d')); ?>


                                </td>


                                <td>

                                    <div class="user-actions">


                                        <a href="<?php echo e(route('admin.jobs.show', $job->id)); ?>" class="action-btn"
                                            title="عرض الوظيفة">

                                            <i class="fa-solid fa-eye"></i>

                                        </a>


                                        <?php if($job->status !== 'approved'): ?>
                                            <form method="POST" action="<?php echo e(route('admin.jobs.approve', $job->id)); ?>"
                                                style="display:inline;">

                                                <?php echo csrf_field(); ?>

                                                <?php echo method_field('PATCH'); ?>

                                                <button type="submit" class="action-btn" title="قبول الوظيفة">

                                                    <i class="fa-solid fa-check"></i>

                                                </button>

                                            </form>
                                        <?php endif; ?>


                                        <?php if($job->status !== 'rejected'): ?>
                                            <form method="POST" action="<?php echo e(route('admin.jobs.reject', $job->id)); ?>"
                                                style="display:inline;">

                                                <?php echo csrf_field(); ?>

                                                <?php echo method_field('PATCH'); ?>

                                                <button type="submit" class="action-btn" title="رفض الوظيفة">

                                                    <i class="fa-solid fa-xmark"></i>

                                                </button>

                                            </form>
                                        <?php endif; ?>


                                        <form method="POST" action="<?php echo e(route('admin.jobs.destroy', $job->id)); ?>"
                                            style="display:inline;"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذه الوظيفة؟');">

                                            <?php echo csrf_field(); ?>

                                            <?php echo method_field('DELETE'); ?>

                                            <button type="submit" class="action-btn delete-btn" title="حذف الوظيفة">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </form>


                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td colspan="10">

                                    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-briefcase','title' => 'لا توجد وظائف','content' => 'لم يتم العثور على أي وظائف منشورة.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-briefcase','title' => 'لا توجد وظائف','content' => 'لم يتم العثور على أي وظائف منشورة.']); ?>
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

                                </td>

                            </tr>
                        <?php endif; ?>

                    </tbody>

                </table>

            </div>


            <?php echo e($jobs->withQueryString()->links('vendor.pagination.custom')); ?>



        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/jobs/index.blade.php ENDPATH**/ ?>
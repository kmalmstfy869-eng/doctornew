```blade


<?php $__env->startSection('title', 'لوحة الإدارة | المستخدمون'); ?>

<?php $__env->startSection('page-title', 'المستخدمون'); ?>

<?php $__env->startSection('page-description', 'عرض وإدارة المستخدمين ومعرفة الوظائف التي قاموا بنشرها'); ?>

<?php $__env->startSection('content'); ?>

    <div class="users-page">

        


        <div class="users-header">

            <div class="users-title">

                <div class="title-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div>

                    <h2>
                        المستخدمون
                    </h2>

                    <p>
                        جميع المستخدمين المسجلين على المنصة
                    </p>

                </div>

            </div>


            <div class="users-count-card">

                <div class="users-count-icon">

                    <i class="fa-solid fa-users"></i>

                </div>

                <div class="users-count-data">

                    <span>
                        إجمالي المستخدمين
                    </span>

                    <strong>
                        <?php echo e($users->total()); ?>

                    </strong>

                </div>

            </div>

        </div>




        

        <div class="users-card">

            <div class="table-responsive">

                <table class="users-table">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                المستخدم
                            </th>

                            <th>
                                البريد الإلكتروني
                            </th>

                            <th>
                                رقم الهاتف
                            </th>

                            <th>
                                الوظائف
                            </th>

                            <th>
                                عدد الوظائف
                            </th>

                            <th>
                                تاريخ التسجيل
                            </th>

                            <th>
                                الإجراءات
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>

                                

                                <td>
                                    <?php echo e($users->firstItem() + $loop->index); ?>

                                </td>


                                

                                <td>

                                    <div class="user-info">

                                        <div class="user-avatar">

                                            <i class="fa-solid fa-user"></i>

                                        </div>

                                        <div class="user-data">

                                            <strong>
                                                <?php echo e($user->name); ?>

                                            </strong>

                                        </div>

                                    </div>

                                </td>


                                

                                <td>

                                    <?php echo e($user->email); ?>


                                </td>


                                

                                <td>

                                    <?php echo e($user->phone ?? 'غير مسجل'); ?>


                                </td>


                                

                                <td>

                                    <?php if($user->jobs->count() > 0): ?>
                                        <span class="status-badge has-jobs">

                                            <i class="fa-solid fa-briefcase"></i>

                                            نشر وظائف

                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge no-jobs">

                                            <i class="fa-solid fa-minus"></i>

                                            لم ينشر

                                        </span>
                                    <?php endif; ?>

                                </td>


                                

                                <td>

                                    <span class="jobs-count">

                                        <?php echo e($user->jobs->count()); ?>


                                    </span>

                                </td>


                                

                                <td>

                                    <?php echo e($user->created_at?->format('Y-m-d')); ?>


                                </td>


                                

                                <td>

                                    <div class="user-actions">

                                        <?php if($user->jobs->count() > 0): ?>
                                            <a href="<?php echo e(route('admin.user.jobs', $user->id)); ?>" class="action-btn"
                                                title="عرض الوظائف">

                                                <i class="fa-solid fa-briefcase"></i>

                                            </a>
                                        <?php else: ?>
                                            <span class="action-disabled">

                                                <i class="fa-solid fa-briefcase"></i>

                                            </span>
                                        <?php endif; ?>


                                        

                                        <form method="POST" action="<?php echo e(route('admin.users.destroy', $user->id)); ?>"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">

                                            <?php echo csrf_field(); ?>

                                            <?php echo method_field('DELETE'); ?>

                                            <button type="submit" class="action-btn delete-btn" title="حذف المستخدم">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>

                                <td colspan="8">

                                    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-users','title' => 'لا يوجد مستخدمون','content' => 'لم يتم العثور على أي مستخدمين.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-users','title' => 'لا يوجد مستخدمون','content' => 'لم يتم العثور على أي مستخدمين.']); ?>
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


            <?php echo e($users->withQueryString()->links('vendor.pagination.custom')); ?>



        </div>

    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/users/index.blade.php ENDPATH**/ ?>
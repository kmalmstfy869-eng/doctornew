<?php $__env->startSection('title', 'لوحة التحكم | التخصصات'); ?>

<?php $__env->startSection('content'); ?>

    <div class="doctor-pending-page">

        

        <div class="doctor-pending-topbar">

            
            <div class="doctor-pending-page-title">

                <h1>
                    التخصصات الطبية
                </h1>

                <p>
                    إدارة التخصصات الموجودة في دليل الأطباء
                </p>

            </div>


            
            <form action="<?php echo e(route('admin.specialties.create')); ?>" method="GET">

                <button type="submit" class="doctor-button-card">

                    <i class="fa-solid fa-plus"></i>

                    إضافة تخصص

                </button>

            </form>

        </div>


        

        <div class="doctor-pending-stats">

            
            <div class="doctor-pending-stat-card">

                <div class="doctor-pending-stat-icon blue">

                    <i class="fa-solid fa-stethoscope"></i>

                </div>

                <div class="doctor-pending-stat-data">

                    <h3>
                        <?php echo e($specialties->total() ?? 0); ?>

                    </h3>

                    <p>
                        إجمالي التخصصات
                    </p>

                </div>

            </div>


            
            <div class="doctor-pending-stat-card">

                <div class="doctor-pending-stat-icon yellow">

                    <i class="fa-solid fa-user-doctor"></i>

                </div>

                <div class="doctor-pending-stat-data">

                    <h3>
                        <?php echo e($totalDoctors ?? 0); ?>

                    </h3>

                    <p>
                        إجمالي الأطباء
                    </p>

                </div>

            </div>


            
            <div class="doctor-pending-stat-card">

                <div class="doctor-pending-stat-icon red">

                    <i class="fa-solid fa-user-slash"></i>

                </div>

                <div class="doctor-pending-stat-data">

                    <h3>
                        <?php echo e($emptySpecialties ?? 0); ?>

                    </h3>

                    <p>
                        تخصصات بدون أطباء
                    </p>

                </div>

            </div>

        </div>


        

        <div class="doctor-pending-requests-card">

            
            <div class="doctor-pending-card-header">

                <div>

                    <h2>
                        قائمة التخصصات
                    </h2>

                    <p>
                        جميع التخصصات المسجلة في النظام
                    </p>

                </div>





            </div>


            

            <?php if($specialties->isNotEmpty()): ?>

                <div class="doctor-pending-table-wrapper">

                    <table class="doctor-pending-table">

                        <thead>

                            <tr>

                                <th>
                                    ترتيب الموقع
                                </th>

                                <th>
                                    التخصص
                                </th>

                                <th>
                                    العنوان
                                </th>

                                <th>
                                    عدد الأطباء
                                </th>

                                <th>
                                    الإجراءات
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>

                                    
                                    <td>

                                        <span class="doctor-pending-specialty">

                                            <?php echo e($specialty->sort_order); ?>


                                        </span>

                                    </td>


                                    
                                    <td>

                                        <div class="doctor-pending-doctor-info">

                                            <div class="doctor-pending-avatar">

                                                <i class="<?php echo e($specialty->logo); ?>"></i>

                                            </div>

                                            <div>

                                                <div class="doctor-pending-name">

                                                    <?php echo e($specialty->name); ?>


                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    
                                    <td>

                                        <span class="doctor-pending-specialty">

                                            <?php echo e($specialty->title); ?>


                                        </span>

                                    </td>


                                    
                                    <td>

                                        <span class="doctor-pending-specialty">

                                            <?php echo e($specialty->doctors_count ?? 0); ?>


                                            طبيب

                                        </span>

                                    </td>


                                    

                                    <td>

                                        <div class="doctor-pending-actions">

                                            <a href="<?php echo e(route('admin.specialties.edit', ['specialty' => $specialty->id])); ?>"
                                                title="تعديل التخصص">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            
                                            <form action="<?php echo e(route('admin.specialties.destroy', $specialty->id)); ?>"
                                                method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا التخصص نهائيًا؟')">

                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>

                                                <button type="submit" class="doctor-pending-action reject"
                                                    title="حذف التخصص">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table>

                </div>


                
                <div class="doctor-pending-pagination">

                    <?php echo e($specialties->links('vendor.pagination.custom')); ?>


                </div>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-stethoscope','title' => 'لا يوجد تخصصات','content' => 'لم يتم العثور على تخصصات مسجلة حاليًا']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-stethoscope','title' => 'لا يوجد تخصصات','content' => 'لم يتم العثور على تخصصات مسجلة حاليًا']); ?>
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

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/specialties/index.blade.php ENDPATH**/ ?>
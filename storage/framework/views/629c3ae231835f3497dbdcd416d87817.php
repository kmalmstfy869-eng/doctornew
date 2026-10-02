<?php $__env->startSection('title', 'لوحة التحكم | طلبات إضافة الأطباء'); ?>

<?php $__env->startSection('content'); ?>


    <div class="doctor-pending-page">

        
        <div class="doctor-pending-topbar">

            <div class="doctor-pending-page-title">
                <h1>طلبات إضافة الأطباء</h1>
                <p>مراجعة الطلبات الجديدة وقبول أو رفض إضافة الطبيب</p>
            </div>

            
            <?php if($pendingDoctor->isNotEmpty()): ?>
                <form action="<?php echo e(route('admin.doctors_pending.approve_all')); ?>" method="POST"
                    onsubmit="return confirm('هل أنت متأكد من قبول جميع طلبات إضافة الأطباء؟')">

                    <?php echo csrf_field(); ?>

                    <button type="submit" class="doctor-button-card">
                        قبول الكل
                        <i class="fa-solid fa-check-double"></i>
                    </button>

                </form>
            <?php endif; ?>

        </div>

        
        <div class="doctor-pending-stats">

            
            <div class="doctor-pending-stat-card">
                <div class="doctor-pending-stat-icon blue">
                    <i class="fa-solid fa-file-circle-plus"></i>
                </div>
                <div class="doctor-pending-stat-data">
                    <h3><?php echo e($pendingDoctor->total() ?? 0); ?></h3>
                    <p>إجمالي الطلبات</p>
                </div>
            </div>

            
            <div class="doctor-pending-stat-card">
                <div class="doctor-pending-stat-icon yellow">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="doctor-pending-stat-data">
                    <h3><?php echo e($pendingDoctor->total() ?? 0); ?></h3>
                    <p>طلبات في انتظار المراجعة</p>
                </div>
            </div>

            
            <div class="doctor-pending-stat-card">
                <div class="doctor-pending-stat-icon red">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <div class="doctor-pending-stat-data">
                    <h3><?php echo e($pendingDoctorsToday ?? 0); ?></h3>
                    <p>طلبات وصلت اليوم</p>
                </div>
            </div>

        </div>

        
        <div class="doctor-pending-requests-card">

            
            <div class="doctor-pending-card-header">

                <div>
                    <h2>قائمة طلبات الإضافة</h2>
                    <p>جميع طلبات الأطباء الجديدة</p>
                </div>

                
                <div class="doctor-pending-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="searchInput" placeholder="ابحث باسم الطبيب أو رقم الهاتف...">
                </div>

            </div>

            
            <?php if($pendingDoctor->isNotEmpty()): ?>

                <div class="doctor-pending-table-wrapper">

                    <table class="doctor-pending-table">

                        <thead>

                            <tr>

                                
                                <th>ID</th>

                                <th>الطبيب</th>

                                <th>التخصص</th>

                                <th>المحافظة</th>

                                <th>تاريخ الطلب</th>

                                <th>الحالة</th>

                                <th>الإجراءات</th>

                            </tr>

                        </thead>


                        <tbody id="requestsBody">

                            <?php $__currentLoopData = $pendingDoctor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-id="<?php echo e($doctor->id); ?>" data-name="<?php echo e($doctor->user->name); ?>"
                                    data-phone="<?php echo e($doctor->phone); ?>" data-specialty="<?php echo e($doctor->specialty->name); ?>"
                                    data-area="<?php echo e($doctor->area->name); ?>" data-status="قيد المراجعة">

                                    
                                    <td>
                                        <span class="doctor-pending-doctor-id">
                                            #<?php echo e($doctor->id); ?>

                                        </span>
                                    </td>


                                    
                                    <td>

                                        <div class="doctor-pending-doctor-info">

                                            <div class="doctor-pending-avatar">

                                                <?php if($doctor->doctor_image): ?>
                                                    <img src="<?php echo e(asset('storage/' . $doctor->doctor_image)); ?>"
                                                        alt="صورة الطبيب">
                                                <?php else: ?>
                                                    <i class="fa-solid fa-user-doctor"></i>
                                                <?php endif; ?>

                                            </div>

                                            <div>

                                                <div class="doctor-pending-name">
                                                    د. <?php echo e($doctor->user->name); ?>

                                                </div>

                                                <div class="doctor-pending-phone">
                                                    <?php echo e($doctor->phone); ?>

                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    
                                    <td>

                                        <span class="doctor-pending-specialty">
                                            <?php echo e($doctor->specialty->name); ?>

                                        </span>

                                    </td>


                                    
                                    <td>
                                        <?php echo e($doctor->area->name); ?>

                                    </td>


                                    
                                    <td>

                                        <span class="doctor-pending-date">
                                            <?php echo e($doctor->created_at->translatedFormat('d F Y')); ?>

                                        </span>

                                    </td>


                                    
                                    <td>

                                        <span class="doctor-pending-status">

                                            <i class="fa-solid fa-clock"></i>

                                            قيد المراجعة

                                        </span>

                                    </td>


                                    
                                    <td>

                                        <div class="doctor-pending-actions">

                                            
                                            <button type="button" class="doctor-pending-action view" title="عرض التفاصيل">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>


                                            
                                            <form action="<?php echo e(route('admin.doctor_pending.approve', $doctor->id)); ?>"
                                                method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من إضافة الدكتور وظهوره في الموقع؟')">

                                                <?php echo csrf_field(); ?>

                                                <button type="submit" class="doctor-pending-action accept"
                                                    title="قبول ظهور الطبيب">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>

                                            </form>


                                            
                                            <form action="<?php echo e(route('admin.doctor_pending.reject', $doctor->id)); ?>"
                                                method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من رفض طلب إضافة الدكتور؟')">

                                                <?php echo csrf_field(); ?>

                                                <button type="submit" class="doctor-pending-action reject" title="رفض">
                                                    <i class="fa-solid fa-xmark"></i>
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
                    <?php echo e($pendingDoctor->links('vendor.pagination.custom')); ?>

                </div>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-user-doctor','title' => 'لا توجد طلبات إضافة حاليًا','content' => 'لم يتم العثور على أطباء في انتظار المراجعة']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-user-doctor','title' => 'لا توجد طلبات إضافة حاليًا','content' => 'لم يتم العثور على أطباء في انتظار المراجعة']); ?>
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


    
    <?php if (isset($component)) { $__componentOriginal18f92e20fcf6134528f9202ba4a51344 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18f92e20fcf6134528f9202ba4a51344 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.doctor_pending_modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.doctor_pending_modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18f92e20fcf6134528f9202ba4a51344)): ?>
<?php $attributes = $__attributesOriginal18f92e20fcf6134528f9202ba4a51344; ?>
<?php unset($__attributesOriginal18f92e20fcf6134528f9202ba4a51344); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18f92e20fcf6134528f9202ba4a51344)): ?>
<?php $component = $__componentOriginal18f92e20fcf6134528f9202ba4a51344; ?>
<?php unset($__componentOriginal18f92e20fcf6134528f9202ba4a51344); ?>
<?php endif; ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/doctors/doctors_pending.blade.php ENDPATH**/ ?>
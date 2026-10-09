<?php $__env->startSection('title', 'لوحة التحكم | الأطباء غير المشتركين'); ?>

<?php $__env->startSection('content'); ?>

<div class="doctor-pending-page">

    
    <div class="doctor-pending-topbar">
        <div class="doctor-pending-page-title">
            <h1>الأطباء المرفضون </h1>
            <p>إدارة الأطباء المرفضون من الدليل </p>
        </div>
    </div>

    
    <div class="doctor-pending-stats">

        
        <div class="doctor-pending-stat-card">
            <div class="doctor-pending-stat-icon blue">
                <i class="fa-solid fa-file-circle-plus"></i>
            </div>
            <div class="doctor-pending-stat-data">
                <h3><?php echo e($doctors->total() ?? 0); ?></h3>
                <p>إجمالي المرفضون </p>
            </div>
        </div>

        
        <div class="doctor-pending-stat-card">
            <div class="doctor-pending-stat-icon yellow">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="doctor-pending-stat-data">
                <h3><?php echo e($expiredDoctors ?? 0); ?></h3>
                <p>كان لديهم اشتراك </p>
            </div>
        </div>

        
        <div class="doctor-pending-stat-card">
            <div class="doctor-pending-stat-icon red">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <div class="doctor-pending-stat-data">
                <h3><?php echo e($unsubscribedDoctors ?? 0); ?></h3>
                <p>لم يشتركوا </p>
            </div>
        </div>

    </div>

    
    <div class="doctor-pending-requests-card">

        
        <div class="doctor-pending-card-header">

            <div>
                <h2>قائمة الأطباء</h2>
                <p>جميع الأطباء المرفضون</p>
            </div>

            
            <div class="doctor-pending-search">
                <i class="fa-solid fa-magnifying-glass"></i>
      <input type="search" data-live-search value="<?php echo e(request('search')); ?>"
    placeholder="ابحث بالاسم أو الهاتف أو التخصص أو المنطقة أو الـ ID..." autocomplete="off">
            </div>

        </div>

       <div id="live-results">
        <?php if($doctors->isNotEmpty()): ?>

            <div class="doctor-pending-table-wrapper">

                <table class="doctor-pending-table">

                    <thead>

                        <tr>

                            
                            <th>ID</th>

                            <th>الطبيب</th>

                            <th>التخصص</th>

                            <th>المنطقة</th>

                            <th>تاريخ الإضافة</th>

                            <th>الحالة</th>

                            <th>الإجراءات</th>

                        </tr>

                    </thead>


                    <tbody id="requestsBody">

                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr
                                data-id="<?php echo e($doctor->id); ?>"
                                data-name="<?php echo e($doctor->user->name ?? ''); ?>"
                                data-phone="<?php echo e($doctor->phone ?? ''); ?>"
                                data-specialty="<?php echo e($doctor->specialty->name ?? ''); ?>"
                                data-area="<?php echo e($doctor->area->name ?? ''); ?>"
                                data-status="<?php echo e($doctor->subscription->plan->name == 'free' ? 'لم يشترك ' : 'اشتراك منتهي'); ?>"
                            >

                                
                                <td>

                                    <span class="doctor-pending-doctor-id">
                                        #<?php echo e($doctor->id); ?>

                                    </span>

                                </td>


                                
                                <td>

                                    <div class="doctor-pending-doctor-info">

                                        <div class="doctor-pending-avatar">

                                            <?php if(!empty($doctor->doctor_image)): ?>

                                                <img
                                                    src="<?php echo e(asset('storage/' . $doctor->doctor_image)); ?>"
                                                    alt="صورة الطبيب"
                                                >

                                            <?php else: ?>

                                                <i class="fa-solid fa-user-doctor"></i>

                                            <?php endif; ?>

                                        </div>

                                        <div>

                                            <div class="doctor-pending-name">
                                                د. <?php echo e($doctor->user->name ?? 'غير محدد'); ?>

                                            </div>

                                            <div class="doctor-pending-phone">
                                                <?php echo e($doctor->phone ?? '—'); ?>

                                            </div>

                                        </div>

                                    </div>

                                </td>


                                
                                <td>

                                    <span class="doctor-pending-specialty">
                                        <?php echo e($doctor->specialty->name ?? '—'); ?>

                                    </span>

                                </td>


                                
                                <td>
                                    <?php echo e($doctor->area->name ?? '—'); ?>

                                </td>


                                
                                <td>

                                    <span class="doctor-pending-date">
                                        <?php echo e($doctor->created_at ? $doctor->created_at->translatedFormat('d F Y') : '—'); ?>

                                    </span>

                                                <?php if($doctor->user?->email_verified_at): ?>
                                                    <span class="email-verify-badge verified"
                                                        title="تم التأكيد في <?php echo e($doctor->user->email_verified_at->translatedFormat('d F Y')); ?>">
                                                        <i class="fa-solid fa-circle-check"></i> إيميل مؤكَّد
                                                    </span>
                                                <?php else: ?>
                                                    <span class="email-verify-badge unverified" title="لم يؤكد الإيميل بعد">
                                                        <i class="fa-solid fa-circle-xmark"></i> غير مؤكَّد
                                                    </span>
                                                <?php endif; ?>
                                </td>


                                
                                <td>

                                    <span class="doctor-pending-status">

                                        <i class="fa-solid fa-circle-exclamation"></i>

                                        <?php echo e($doctor->subscription->plan->name == 'free'
                                            ? 'لم يشترك '
                                            : 'اشتراك منتهي'); ?>


                                    </span>

                                </td>


                                
                                <td>

                                    <div class="doctor-pending-actions">

                                        
                                        <button
                                            type="button"
                                            class="doctor-pending-action view"
                                            title="عرض التفاصيل"
                                        >
                                            <i class="fa-solid fa-eye"></i>
                                        </button>


                                        
                                        <form
                                            action="<?php echo e(route('admin.rejected_doctor.restore', $doctor->id)); ?>"
                                            method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من اعاده الدكتور وظهوره في الموقع؟')"
                                        >

                                            <?php echo csrf_field(); ?>

                                            <button
                                                type="submit"
                                                class="doctor-pending-action accept"
                                                title="قبول ظهور الطبيب"
                                            >
                                                <i class="fa-solid fa-check"></i>
                                            </button>

                                        </form>


                                        
                                        <form
                                            action="<?php echo e(route('admin.rejected_doctors.destroy', $doctor->id)); ?>"
                                            method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا الطبيب نهائيا؟')"
                                        >

                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button
                                                type="submit"
                                                class="doctor-pending-action delete-btn"
                                                title="حذف الطبيب"
                                            >
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

                <?php echo e($doctors->links('vendor.pagination.custom')); ?>


            </div>


        <?php else: ?>

            <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء','content' => 'لم يتم العثور على أطباء مرفضون حاليًا']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء','content' => 'لم يتم العثور على أطباء مرفضون حاليًا']); ?>
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
<?php $__env->startPush('extra_java'); ?>
    <script src="<?php echo e(asset('js/admin/live-search.js')); ?>?v=<?php echo e(@filemtime(public_path('js/admin/live-search.js')) ?: time()); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/doctors/rejected_doctors.blade.php ENDPATH**/ ?>
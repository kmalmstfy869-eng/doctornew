<?php $__env->startSection('title', 'لوحة التحكم | تعديل المنطقة'); ?>

<?php $__env->startSection('content'); ?>

    <div class="doctor-edit-page">

        

        <div class="doctor-edit-header">

            <div class="doctor-edit-title">

                <div class="title-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>

                <div class="title-content">

                    <span class="title-small">
                        إدارة المناطق
                    </span>

                    <h1>
                        تعديل المنطقة
                    </h1>

                    <p>
                        تعديل بيانات المنطقة في دليل الأطباء
                    </p>

                </div>

            </div>


            <a href="<?php echo e(route('admin.areas.index')); ?>" class="back-btn">

                <i class="fa-solid fa-arrow-right"></i>

                <span>
                    رجوع
                </span>

            </a>

        </div>


        

        <div class="doctor-edit-layout">


            

            <aside class="doctor-profile-card">

                <div class="profile-card-title">

                    <div class="profile-title-icon">

                        <i class="fa-solid fa-location-dot"></i>

                    </div>

                    <div>

                        <h2>
                            المنطقة
                        </h2>

                        <p>
                            البيانات التي تظهر في دليل الأطباء
                        </p>

                    </div>

                </div>


                

                <div class="profile-image-area">

                    <div class="profile-image-wrapper">

                        <div class="doctor-default-image">

                            <i class="fa-solid fa-location-dot"></i>

                        </div>

                    </div>

                </div>


                

                <div class="profile-doctor-info">

                    <span class="doctor-profile-label">
                        المنطقة الحالية
                    </span>

                    <h3>
                        <?php echo e($area->name); ?>

                    </h3>

                    <p>

                        <i class="fa-solid fa-link"></i>

                        <?php echo e($area->slug); ?>


                    </p>

                </div>


                

                <div class="subscription-status subscribed">

                    <span class="status-icon">

                        <i class="fa-solid fa-check"></i>

                    </span>

                    <span>
                        المنطقة موجودة في الموقع
                    </span>

                </div>

            </aside>


            

            <main class="doctor-form-content">

                <form action="<?php echo e(route('admin.areas.update', $area)); ?>" method="POST">

                    <?php echo csrf_field(); ?>

                    <?php echo method_field('PUT'); ?>


                    

                    <div class="edit-card">

                        <div class="card-title">

                            <div class="card-title-icon">

                                <i class="fa-solid fa-location-dot"></i>

                            </div>

                            <div>

                                <h2>
                                    بيانات المنطقة
                                </h2>

                                <p>
                                    تعديل البيانات الأساسية للمنطقة
                                </p>

                            </div>

                        </div>


                        <div class="form-grid">


                            

                            <div class="form-group">

                                <label for="name">
                                    اسم المنطقة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <input
                                        id="name"
                                        type="text"
                                        name="name"
                                        value="<?php echo e(old('name', $area->name)); ?>"
                                        placeholder="مثال: الرحمانية"
                                        required
                                    >

                                </div>

                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                                    <small class="field-error">
                                        <?php echo e($message); ?>

                                    </small>

                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>


                            

                            <div class="form-group">

                                <label for="slug">
                                    الرابط المختصر
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-link"></i>

                                    <input
                                        id="slug"
                                        type="text"
                                        name="slug"
                                        value="<?php echo e(old('slug', $area->slug)); ?>"
                                        placeholder="مثال: sidi-bishr"
                                        required
                                    >

                                </div>

                                <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                                    <small class="field-error">
                                        <?php echo e($message); ?>

                                    </small>

                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>


                        </div>

                    </div>


                    

                    <div class="save-section">

                        <button
                            type="submit"
                            class="save-btn"
                        >

                            <i class="fa-solid fa-floppy-disk"></i>

                            <span>
                                حفظ التعديلات
                            </span>

                        </button>

                    </div>

                </form>

            </main>

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/areas/edit_area.blade.php ENDPATH**/ ?>
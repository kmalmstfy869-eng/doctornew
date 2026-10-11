<?php $__env->startSection('title', 'لوحة التحكم | تعديل التخصص'); ?>

<?php $__env->startSection('content'); ?>


    <div class="doctor-edit-page">

        

        <div class="doctor-edit-header">

            <div class="doctor-edit-title">

                <div class="title-icon">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>

                <div class="title-content">

                    <span class="title-small">
                        إدارة التخصصات
                    </span>

                    <h1>
                        تعديل التخصص
                    </h1>

                    <p>
                        تعديل بيانات التخصص الطبي
                    </p>

                </div>

            </div>


            <a href="<?php echo e(route('admin.specialties.index')); ?>" class="back-btn">

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

                        <i class="fa-solid fa-stethoscope"></i>

                    </div>

                    <div>

                        <h2>
                            التخصص الطبي
                        </h2>

                        <p>
                            البيانات التي تظهر في دليل الأطباء
                        </p>

                    </div>

                </div>


                

                <div class="profile-image-area">

                    <div class="profile-image-wrapper">

                        <div class="doctor-default-image">

                            <i class="<?php echo e($specialty->logo); ?>"></i>

                        </div>

                    </div>

                </div>


                <div class="upload-note">

                    <i class="fa-solid fa-circle-info"></i>

                    <span>
                        شعار التخصص المستخدم في الموقع
                    </span>

                </div>


                

                <div class="profile-doctor-info">

                    <span class="doctor-profile-label">
                        التخصص
                    </span>

                    <h3>
                        <?php echo e($specialty->name); ?>

                    </h3>

                    <p>

                        <i class="fa-solid fa-heading"></i>

                        <?php echo e($specialty->title); ?>


                    </p>

                </div>


                

                <div class="subscription-status subscribed">

                    <span class="status-icon">

                        <i class="fa-solid fa-check"></i>

                    </span>

                    <span>
                        التخصص موجود في الموقع
                    </span>

                </div>

            </aside>


            

            <main class="doctor-form-content">

                <form action="<?php echo e(route('admin.specialties.update', $specialty)); ?>" method="POST">

                    <?php echo csrf_field(); ?>

                    <?php echo method_field('PUT'); ?>


                    

                    <div class="edit-card">

                        <div class="card-title">

                            <div class="card-title-icon">

                                <i class="fa-solid fa-stethoscope"></i>

                            </div>

                            <div>

                                <h2>
                                    بيانات التخصص
                                </h2>

                                <p>
                                    تعديل البيانات الأساسية للتخصص
                                </p>

                            </div>

                        </div>


                        <div class="form-grid">


                            

                            <div class="form-group">

                                <label for="name">
                                    اسم التخصص
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-stethoscope"></i>

                                    <input id="name" type="text" name="name"
                                        value="<?php echo e(old('name', $specialty->name)); ?>" placeholder="مثال: طب القلب" required>

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

                                <label for="sort_order">
                                    ترتيب الظهور
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-arrow-down-1-9"></i>

                                    <input id="sort_order" type="number" name="sort_order"
                                        value="<?php echo e(old('sort_order', $specialty->sort_order)); ?>" placeholder="مثال: 1"
                                        min="0" required>

                                </div>

                                <?php $__errorArgs = ['sort_order'];
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


                            

                            <div class="form-group full">

                                <label for="title">
                                    عنوان التخصص
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-heading"></i>

                                    <input id="title" type="text" name="title"
                                        value="<?php echo e(old('title', $specialty->title)); ?>"
                                        placeholder="مثال: أفضل أطباء القلب في مصر" required>

                                </div>

                                <?php $__errorArgs = ['title'];
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

                                    <input id="slug" type="text" name="slug"
                                        value="<?php echo e(old('slug', $specialty->slug)); ?>" placeholder="مثال: cardiology"
                                        required>

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


                            

                            <div class="form-group">

                                <label for="logo">
                                    شعار التخصص
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-icons"></i>

                                    <input id="logo" type="text" name="logo"
                                        value="<?php echo e(old('logo', $specialty->logo)); ?>"
                                        placeholder="مثال: fa-solid fa-heart-pulse" required>

                                </div>

                                <?php $__errorArgs = ['logo'];
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

                        <button type="submit" class="save-btn">

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

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/specialties/edit_specialty.blade.php ENDPATH**/ ?>
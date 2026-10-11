<?php $__env->startSection('title', 'إرسال إشعار | لوحة تحكم الإدارة'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin/notifications.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <main class="admin-notification-page">

        <div class="admin-notification-container">

            
            <div class="notification-page-header">

                <div class="notification-page-title">

                    <div class="notification-page-icon">
                        <i class="fa-solid fa-bell"></i>
                    </div>

                    <div>

                        <h1>
                            إرسال إشعار
                        </h1>

                        <p>
                            إرسال إشعار مباشر إلى أحد الأطباء
                        </p>

                    </div>

                </div>

            </div>


            
            <section class="notification-form-card">


                
                <div class="notification-form-header">

                    <div class="notification-form-header-icon">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>

                    <div>

                        <h2>
                            بيانات الإشعار
                        </h2>

                        <p>
                            اكتب بيانات الإشعار واختر الصفحة التي سيفتحها الطبيب
                        </p>

                    </div>

                </div>


                
                <form
                    action="<?php echo e(route('admin.notifications.store')); ?>"
                    method="POST"
                    class="notification-form"
                >

                    <?php echo csrf_field(); ?>


                    
                    <div class="notification-form-group">

                        <label
                            for="doctor_id"
                            class="notification-form-label"
                        >
                            رقم الطبيب

                            <span class="required">
                                *
                            </span>
                        </label>

                        <div class="notification-input-wrapper">

                            <span class="notification-input-icon">
                                <i class="fa-solid fa-user-doctor"></i>
                            </span>

                            <input
                                type="number"
                                id="doctor_id"
                                name="doctor_id"
                                value="<?php echo e(old('doctor_id')); ?>"
                                class="notification-form-input <?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="مثال: 15"
                                min="1"
                                required
                            >

                        </div>

                        <?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                            <div class="notification-field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <?php echo e($message); ?>

                            </div>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <small class="notification-field-hint">
                            أدخل رقم الطبيب الموجود في جدول الأطباء.
                        </small>

                    </div>


                    
                    <div class="notification-form-group">

                        <label
                            for="title"
                            class="notification-form-label"
                        >
                            عنوان الإشعار

                            <span class="required">
                                *
                            </span>
                        </label>

                        <div class="notification-input-wrapper">

                            <span class="notification-input-icon">
                                <i class="fa-solid fa-heading"></i>
                            </span>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="<?php echo e(old('title')); ?>"
                                class="notification-form-input <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="مثال: تم قبول حسابك"
                                maxlength="255"
                                required
                            >

                        </div>

                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                            <div class="notification-field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <?php echo e($message); ?>

                            </div>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="notification-form-group">

                        <label
                            for="message"
                            class="notification-form-label"
                        >
                            نص الإشعار

                            <span class="required">
                                *
                            </span>
                        </label>

                        <div class="notification-textarea-wrapper">

                            <span class="notification-textarea-icon">
                                <i class="fa-solid fa-message"></i>
                            </span>

                            <textarea
                                id="message"
                                name="message"
                                class="notification-form-textarea <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="اكتب هنا تفاصيل الإشعار الذي سيصل إلى الطبيب..."
                                rows="6"
                                required
                            ><?php echo e(old('message')); ?></textarea>

                        </div>

                        <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                            <div class="notification-field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <?php echo e($message); ?>

                            </div>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>


                    
                    <div class="notification-form-group">

                        <label
                            for="page"
                            class="notification-form-label"
                        >
                            الصفحة التي سيفتحها الإشعار

                            <span class="required">
                                *
                            </span>
                        </label>

                        <div class="notification-input-wrapper">

                            <span class="notification-input-icon">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </span>

                            <select
                                id="page"
                                name="page"
                                class="notification-form-input notification-form-select <?php $__errorArgs = ['page'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required
                            >

                                <option value="">
                                    اختر الصفحة
                                </option>

                                <option
                                    value="notifications"
                                    <?php echo e(old('page') === 'notifications' ? 'selected' : ''); ?>

                                >
                                    الإشعارات
                                </option>

                                <option
                                    value="reviews"
                                    <?php echo e(old('page') === 'reviews' ? 'selected' : ''); ?>

                                >
                                    التقييمات
                                </option>

                                <option
                                    value="subscription"
                                    <?php echo e(old('page') === 'subscription' ? 'selected' : ''); ?>

                                >
                                    الاشتراك
                                </option>

                                <option
                                    value="profile"
                                    <?php echo e(old('page') === 'profile' ? 'selected' : ''); ?>

                                >
                                    الملف الطبي
                                </option>

                                <option
                                    value="dashboard"
                                    <?php echo e(old('page') === 'dashboard' ? 'selected' : ''); ?>

                                >
                                    الصفحة الرئيسية
                                </option>

                            </select>

                        </div>

                        <?php $__errorArgs = ['page'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                            <div class="notification-field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <?php echo e($message); ?>

                            </div>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <small class="notification-field-hint">
                            اختر الصفحة التي سيتم فتحها عند ضغط الطبيب على الإشعار.
                        </small>

                    </div>


                    
                    <div class="notification-info-box">

                        <div class="notification-info-icon">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>

                        <div class="notification-info-content">

                            <strong>
                                ملاحظة
                            </strong>

                            <p>
                                سيتم حفظ الإشعار في قاعدة البيانات،
                                وإرساله للطبيب عبر إشعار المتصفح إذا كان قد فعّل
                                إشعارات المتصفح.
                            </p>

                        </div>

                    </div>


                    
                    <div class="notification-form-actions">

                        <a
                            href="<?php echo e(route('admin.notifications')); ?>"
                            class="notification-cancel-btn"
                        >
                            <i class="fa-solid fa-arrow-right"></i>

                            <span>
                                إلغاء
                            </span>
                        </a>


                        <button
                            type="submit"
                            class="notification-submit-btn"
                        >

                            <i class="fa-solid fa-paper-plane"></i>

                            <span>
                                إرسال الإشعار
                            </span>

                        </button>

                    </div>

                </form>

            </section>

        </div>

    </main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/notifications/create.blade.php ENDPATH**/ ?>
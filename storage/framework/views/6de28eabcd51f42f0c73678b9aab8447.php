<?php $__env->startSection('title', 'تعديل الملف الطبي | لوحة تحكم الطبيب'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/subscription.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin/edit.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <form action="<?php echo e(route('doctor.profile.update')); ?>" method="POST" enctype="multipart/form-data" id="doctorProfileForm">
        <?php echo method_field('PUT'); ?>
        <?php echo csrf_field(); ?>

        <input type="hidden" id="deletedDoctorImage" name="deleted_doctor_image"
            value="<?php echo e(old('deleted_doctor_image', '')); ?>">

        <input type="hidden" id="deletedClinicImages" name="deleted_clinic_images"
            value="<?php echo e(old('deleted_clinic_images', '[]')); ?>">

        <section class="subscription" id="subscription">

            <div class="subscription-main">

                <span class="sub-label">
                    الملف الطبي
                </span>

                <div class="sub-heading">
                    <h2>
                        تعديل ملفي الطبي
                    </h2>
                </div>

                <span class="sub-status free-status">
                    حدّث معلوماتك الطبية ومعلومات عيادتك التي تظهر للمرضى.
                </span>

                <div class="sub-features">

                    <span class="sub-feature">
                        ✓ اجعل مرضى أكثر يجدونك بسهولة
                    </span>

                    <span class="sub-feature">
                        ✓ زوّد فرص ظهورك وحجز المرضى
                    </span>

                    <span class="sub-feature">
                        ✓ اجعل ملفك الطبي أكثر احترافية
                    </span>

                    <span class="sub-feature">
                        ✓ استفيد من مميزات حصرية للأطباء المشتركين
                    </span>

                </div>

                <?php if($doctor->hasFeature('booking')): ?>
                    <div class="booking-notice">

                        <div class="booking-notice-icon">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>

                        <div class="booking-notice-content">

                            <span class="booking-notice-title">
                                تنبيه بخصوص الحجوزات
                            </span>

                            <p>
                                هذه الصفحة مخصصة لتعديل بيانات ملفك الطبي
                                وبيانات العيادة التي تظهر للمرضى.

                                <strong>
                                    إدارة الحجوزات ومواعيد الحجز القادمة من الموقع
                                </strong>

                                تتم من خلال صفحة إدارة العيادة أو الحجوزات.
                            </p>

                        </div>

                    </div>
                <?php endif; ?>

            </div>

            <div class="subscription-side">

                <span class="expire-label">
                    طوّر حسابك
                </span>

                <div class="expire-date">
                    شاهد ملفك كما يظهر للآخرين
                </div>

                <a href="<?php echo e(route('doctor.profile.show')); ?>" class="upgrade-btn">
                    ملفي الطبي
                </a>

            </div>

        </section>

        <section class="doctor-edit-page" dir="rtl">

            <div class="doctor-edit-layout">

                <aside class="doctor-profile-card">

                    <?php if($doctor->hasFeature('subscription')): ?>

                        <div class="profile-card-title">

                            <div class="profile-title-icon">
                                <i class="fa-solid fa-image"></i>
                            </div>

                            <div>

                                <h2>
                                    الصورة الشخصية
                                </h2>

                                <p>
                                    الصورة التي ستظهر بجانب اسمك في الملف الطبي
                                </p>

                            </div>

                        </div>

                        <div class="profile-image-area">

                            <div class="profile-image-wrapper" id="doctorProfileImageWrapper"
                                data-original-image="<?php echo e($doctor->doctor_image ?? ''); ?>">

                                <?php if($doctor->doctor_image): ?>
                                    <img src="<?php echo e(asset('storage/' . ltrim($doctor->doctor_image, '/'))); ?>"
                                        alt="<?php echo e($doctor_name); ?>" class="doctor-profile-image" id="doctorProfileImage">
                                <?php else: ?>
                                    <div class="doctor-default-image" id="doctorDefaultImage">
                                        <i class="fa-solid fa-user-doctor"></i>
                                    </div>
                                <?php endif; ?>

                                <button type="button" id="removeDoctorImageBtn" class="profile-image-remove"
                                    aria-label="حذف الصورة" title="حذف الصورة"
                                    style="<?php echo e($doctor->doctor_image ? 'display: flex;' : 'display: none;'); ?>">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>

                                <div class="profile-image-actions">

                                    <label for="doctorImageInput" class="change-profile-btn" title="اختيار صورة جديدة">
                                        <i class="fa-solid fa-camera"></i>
                                    </label>

                                </div>

                            </div>

                        </div>

                        <label for="doctorImageInput" class="upload-profile">

                            <span class="upload-profile-icon">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </span>

                            <span class="upload-profile-text">

                                <strong>
                                    رفع صورة جديدة
                                </strong>

                                <small>
                                    اضغط هنا لاختيار صورة الطبيب
                                </small>

                            </span>

                            <input type="file" id="doctorImageInput" name="doctor_image"
                                accept="image/jpeg,image/png,image/jpg">

                        </label>

                        <?php $__errorArgs = ['doctor_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="field-error">

                                <i class="fa-solid fa-circle-exclamation"></i>

                                <span>
                                    <?php echo e($message); ?>

                                </span>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <?php $__errorArgs = ['deleted_doctor_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="field-error">

                                <i class="fa-solid fa-circle-exclamation"></i>

                                <span>
                                    <?php echo e($message); ?>

                                </span>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div class="upload-note">

                            <i class="fa-solid fa-circle-info"></i>

                            <span>
                                JPG أو PNG — الحد الأقصى 2MB
                            </span>

                        </div>
                    <?php else: ?>
                        <div class="subscribe-card">

                            <div class="subscribe-card-icon">
                                <i class="fa-solid fa-crown"></i>
                            </div>

                            <span class="subscribe-card-label">
                                ✦ طوّر ظهورك
                            </span>

                            <h2>
                                لسه مش مشترك؟

                                <br>

                                <strong>
                                    فايتك كتير!
                                </strong>
                            </h2>

                            <p class="subscribe-card-text">
                                اشترك الآن وخلي ملفك الطبي يظهر بشكل أفضل،
                                واستفيد من المميزات الإضافية اللي تساعدك
                                توصل لعدد أكبر من المرضى.
                            </p>

                            <div class="subscribe-benefits">

                                <div class="subscribe-benefit">

                                    <span>
                                        <i class="fa-solid fa-circle-check"></i>
                                    </span>

                                    <p>
                                        خلّي مرضى أكتر يلاقوك بسهولة
                                    </p>

                                </div>

                                <div class="subscribe-benefit">

                                    <span>
                                        <i class="fa-solid fa-circle-check"></i>
                                    </span>

                                    <p>
                                        زوّد فرص ظهورك وحجز المرضى
                                    </p>

                                </div>

                                <div class="subscribe-benefit">

                                    <span>
                                        <i class="fa-solid fa-circle-check"></i>
                                    </span>

                                    <p>
                                        استفيد من مميزات حصرية للأطباء
                                    </p>

                                </div>

                            </div>

                            <a href="#" class="subscribe-card-btn">

                                <span>
                                    شوف الباقات
                                </span>

                                <i class="fa-solid fa-arrow-left"></i>

                            </a>

                            <div class="subscribe-card-note">

                                <i class="fa-solid fa-sparkles"></i>

                                <span>
                                    ابدأ دلوقتي وطور حسابك
                                </span>

                            </div>

                        </div>

                    <?php endif; ?>

                    <div class="profile-doctor-info">

                        <span class="doctor-profile-label">
                            الملف الطبي
                        </span>

                        <h3>
                            بيانات الطبيب
                        </h3>

                        <p>
                            <i class="fa-solid fa-stethoscope"></i>
                            يمكنك تعديل بياناتك من النموذج
                        </p>

                    </div>

                    <div class="subscription-status subscribed">

                        <span class="status-icon">
                            <i class="fa-solid fa-check"></i>
                        </span>

                        <span>
                            الملف الطبي معتمد
                        </span>

                    </div>

                </aside>

                <main class="doctor-form-content">

                    <div class="edit-card">

                        <div class="card-title">

                            <div class="card-title-icon">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>

                            <div>

                                <h2>
                                    المعلومات الأساسية
                                </h2>

                                <p>
                                    بيانات التعريف بك كطبيب داخل المنصة
                                </p>

                            </div>

                        </div>

                        <div class="form-grid">

                            <div class="form-group">

                                <label for="doctorName">
                                    اسم الطبيب
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-user"></i>

                                    <input id="doctorName" type="text" name="name"
                                        value="<?php echo e(old('name', $doctor_name ?? $doctor->user->name)); ?>"
                                        placeholder="مثال: د. أحمد محمود">

                                </div>

                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                            <div class="form-group">

                                <label for="specialty">
                                    التخصص
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-stethoscope"></i>

                                    <select id="specialty" name="specialty_id">

                                        <option value="">
                                            اختر التخصص
                                        </option>

                                        <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($specialty->id); ?>" <?php if(old('specialty_id', $doctor->specialty_id) == $specialty->id): echo 'selected'; endif; ?>>
                                                <?php echo e($specialty->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>

                                </div>

                                <?php $__errorArgs = ['specialty_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                            <div class="form-group">

                                <label for="area">
                                    المنطقة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <select id="area" name="area_id">

                                        <option value="">
                                            اختر المنطقة
                                        </option>

                                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($area->id); ?>" <?php if(old('area_id', $doctor->area_id) == $area->id): echo 'selected'; endif; ?>>
                                                <?php echo e($area->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>

                                </div>

                                <?php $__errorArgs = ['area_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                            <div class="form-group">

                                <label for="phone">
                                    رقم الهاتف
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-phone"></i>

                                    <input id="phone" type="text" name="phone"
                                        value="<?php echo e(old('phone', $doctor->phone)); ?>" placeholder="مثال: 01012345678">

                                </div>

                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                            <div class="form-group">

                                <label for="whatsapp">
                                    رقم واتساب
                                </label>

                                <div class="input-wrapper whatsapp-input">

                                    <i class="fa-brands fa-whatsapp"></i>

                                    <input id="whatsapp" type="text" name="whatsapp"
                                        value="<?php echo e(old('whatsapp', $doctor->whatsapp)); ?>" placeholder="مثال: 01012345678">

                                </div>

                                <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                            <div class="form-group">

                                <label for="experience">
                                    سنوات الخبرة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-user-clock"></i>

                                    <input id="experience" type="number" name="experience" min="0"
                                        value="<?php echo e(old('experience', $doctor->experience)); ?>"
                                        placeholder="عدد سنوات الخبرة">

                                    <span class="input-unit">
                                        سنة
                                    </span>

                                </div>

                                <?php $__errorArgs = ['experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                        </div>

                    </div>

                    <div class="edit-card">

                        <div class="card-title">

                            <div class="card-title-icon">
                                <i class="fa-solid fa-hospital"></i>
                            </div>

                            <div>

                                <h2>
                                    معلومات العيادة
                                </h2>

                                <p>
                                    تفاصيل العيادة التي تظهر للمرضى عند الحجز
                                </p>

                            </div>

                        </div>

                        <div class="form-grid">

                            <div class="form-group">

                                <label for="clinicName">
                                    اسم العيادة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-house-medical"></i>

                                    <input id="clinicName" type="text" name="clinic_name"
                                        value="<?php echo e(old('clinic_name', $doctor->clinic_name)); ?>"
                                        placeholder="مثال: عيادة النور التخصصية">

                                </div>

                                <?php $__errorArgs = ['clinic_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                            <div class="form-group">

                                <label for="consultationPrice">
                                    سعر الكشف
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-money-bill-wave"></i>

                                    <input id="consultationPrice" type="number" name="consultation_price"
                                        min="0" step="0.01"
                                        value="<?php echo e(old('consultation_price', $doctor->consultation_price)); ?>"
                                        placeholder="مثال: 300">

                                    <span class="input-unit">
                                        جنيه
                                    </span>

                                </div>

                                <?php $__errorArgs = ['consultation_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                            <div class="form-group full">

                                <label for="address">
                                    عنوان العيادة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <input id="address" type="text" name="address"
                                        value="<?php echo e(old('address', $doctor->address)); ?>"
                                        placeholder="مثال: 12 شارع التحرير، الدور الثالث">

                                </div>

                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                            <?php if($doctor->hasFeature('subscription')): ?>
                                <div class="form-group full">

                                    <label for="googleMap">
                                        موقع العيادة على Google Maps
                                    </label>

                                    <div class="input-wrapper">

                                        <i class="fa-solid fa-map-location-dot"></i>

                                        <input id="googleMap" type="url" name="google_maps_url"
                                            value="<?php echo e(old('google_maps_url', $doctor->google_maps_url)); ?>"
                                            placeholder="https://maps.google.com/...">

                                    </div>

                                    <?php $__errorArgs = ['google_maps_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="field-error">
                                            <i class="fa-solid fa-circle-exclamation"></i>
                                            <span><?php echo e($message); ?></span>
                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>
                            <?php endif; ?>

                            <div class="form-group full">

                                <label for="workingHours">
                                    مواعيد العمل
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-regular fa-clock"></i>

                                    <input id="workingHours" type="text" name="working_hours"
                                        value="<?php echo e(old('working_hours', $doctor->working_hours)); ?>"
                                        placeholder="مثال: السبت - الخميس من 5 م إلى 10 م">

                                </div>

                                <?php $__errorArgs = ['working_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                        </div>

                    </div>

                    <div class="edit-card">

                        <div class="card-title">

                            <div class="card-title-icon">
                                <i class="fa-solid fa-book-medical"></i>
                            </div>

                            <div>

                                <h2>
                                    نبذة عن الطبيب
                                </h2>

                                <p>
                                    نبذة مختصرة تساعد المرضى على التعرف عليك
                                </p>

                            </div>

                        </div>

                        <div class="form-grid">

                            <div class="form-group full">

                                <label for="bio">
                                    نبذة مختصرة
                                </label>

                                <div class="textarea-box">

                                    <textarea id="bio" name="bio" rows="5" placeholder="اكتب نبذة مختصرة عن الطبيب وخبرته وتخصصه..."><?php echo e(old('bio', $doctor->bio)); ?></textarea>

                                </div>

                                <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                        </div>

                    </div>

                    <?php if($doctor->hasFeature('subscription')): ?>
                    <div class="edit-card">

                        <div class="card-title">

                            <div class="card-title-icon">
                                <i class="fa-solid fa-list-check"></i>
                            </div>

                            <div>

                                <h2>
                                    الخدمات الطبية
                                </h2>

                                <p>
                                    أضف الخدمات التي تقدمها داخل العيادة
                                </p>

                            </div>

                        </div>
                        <div class="form-group full">

                            <label for="serviceInput">
                                إضافة خدمة جديدة
                            </label>

                            <div class="input-wrapper">

                                <i class="fa-solid fa-plus"></i>

                                <input type="text" id="serviceInput" placeholder="مثال: الكشف الطبي">

                                <button type="button" id="addServiceBtn" class="service-add-btn">

                                    <i class="fa-solid fa-plus"></i>

                                    <span>
                                        إضافة
                                    </span>

                                </button>

                            </div>

                        </div>

                        <div id="servicesList" class="doctor-services-list"></div>

                        <input type="hidden" id="services" name="services"
                            value="<?php echo e(old('services', json_encode($doctor->services ?? [], JSON_UNESCAPED_UNICODE))); ?>">

                        <div class="input-hint">

                            <i class="fa-solid fa-circle-info"></i>

                            <span>
                                يمكنك إضافة أكثر من خدمة، واضغط على × لحذف أي خدمة.
                            </span>

                        </div>

                        <?php $__errorArgs = ['services'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span><?php echo e($message); ?></span>
                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                        <div class="edit-card">

                            <div class="card-title">

                                <div class="card-title-icon">
                                    <i class="fa-solid fa-images"></i>
                                </div>

                                <div>

                                    <h2>
                                        صور العيادة
                                    </h2>

                                    <p>
                                        أضف حتى 3 صور توضح شكل العيادة للمرضى
                                    </p>

                                </div>

                            </div>

                            <div class="form-group full">

                                <label class="field-label">
                                    صور العيادة
                                </label>

                                <div id="clinicImagesPreview" class="clinic-images-preview">

                                    <?php if(!empty($doctor->clinic_images)): ?>

                                        <?php $__currentLoopData = $doctor->clinic_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="clinic-image-preview-item existing-clinic-image"
                                                data-existing-image="<?php echo e($image); ?>">

                                                <img src="<?php echo e(asset('storage/' . ltrim($image, '/'))); ?>"
                                                    alt="صورة العيادة" loading="lazy">

                                                <button type="button"
                                                    class="clinic-image-remove existing-clinic-image-remove"
                                                    data-image="<?php echo e($image); ?>" aria-label="حذف الصورة">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php endif; ?>

                                    <label for="clinicImagesInput" class="clinic-images-dropzone">

                                        <i class="fa-solid fa-cloud-arrow-up"></i>

                                        <strong>
                                            إضافة صورة
                                        </strong>

                                        <span>
                                            حتى 3 صور
                                        </span>

                                        <input type="file" id="clinicImagesInput" name="clinic_images[]"
                                            accept="image/jpeg,image/png,image/jpg" multiple>

                                    </label>

                                </div>

                                <div id="clinicImagesCount" class="clinic-images-count">

                                    <span class="count-icon">
                                        <i class="fa-solid fa-images"></i>
                                    </span>

                                    <span class="count-text">
                                        يمكنك إضافة صور للعيادة
                                    </span>

                                </div>

                                <?php $__errorArgs = ['clinic_images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                        </div>

                    <?php endif; ?>

                    <?php $__errorArgs = ['deleted_clinic_images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span><?php echo e($message); ?></span>
                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <div class="save-section">

                        <button type="submit" class="save-btn" id="saveDoctorProfileBtn">

                            <i class="fa-solid fa-floppy-disk"></i>

                            <span>
                                حفظ التغييرات
                            </span>

                        </button>

                    </div>

                </main>

            </div>

        </section>

    </form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/dashboard/doctor_profile/edit.blade.php ENDPATH**/ ?>
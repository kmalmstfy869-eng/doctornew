<?php $__env->startSection('title', 'لوحة التحكم | إضافة طبيب جديد'); ?>

<?php $__env->startSection('content'); ?>

    <div class="doctor-edit-page">

        

        <div class="doctor-edit-header">

            <div class="doctor-edit-title">

                <div class="title-icon">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>

                <div class="title-content">

                    <span class="title-small">
                        إدارة الأطباء
                    </span>

                    <h1>
                        إضافة طبيب جديد
                    </h1>

                    <p>
                        إضافة بيانات الطبيب والعيادة والاشتراك
                    </p>

                </div>

            </div>

            <a href="<?php echo e(route('admin.dashboard')); ?>" class="back-btn">

                <i class="fa-solid fa-arrow-right"></i>

                <span>
                    خروج
                </span>

            </a>

        </div>


        

        <div class="doctor-edit-layout">


            

            <aside class="doctor-profile-card">


                

                <div class="profile-card-title">

                    <div class="profile-title-icon">
                        <i class="fa-solid fa-image"></i>
                    </div>

                    <div>

                        <h2>
                            صورة الطبيب
                        </h2>

                        <p>
                            الصورة التي ستظهر في دليل الأطباء
                        </p>

                    </div>

                </div>


                

                <div class="profile-image-area">

                    <div class="profile-image-wrapper">

                        <div id="doctorImageDefault" class="doctor-default-image">

                            <i class="fa-solid fa-user-doctor"></i>

                        </div>

<img id="doctorImagePreview" src="" alt="صورة الطبيب" class="doctor-profile-image"
    style="display:none;">
                        <div class="profile-image-actions">

                            <label for="doctorImageInput" class="change-profile-btn" title="اختيار صورة جديدة">

                                <i class="fa-solid fa-camera"></i>

                            </label>

                        </div>

                    </div>

                </div>


                

                <?php $__errorArgs = ['doctor_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="profile-image-error">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        <span>
                            <?php echo e($message); ?>

                        </span>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                

                <label for="doctorImageInput" class="upload-profile">

                    <span class="upload-profile-icon">

                        <i class="fa-solid fa-cloud-arrow-up"></i>

                    </span>

                    <span class="upload-profile-text">

                        <strong>
                            اختيار صورة الطبيب
                        </strong>

                        <small>
                            اضغط هنا لاختيار صورة جديدة
                        </small>

                    </span>

                    <input type="file" id="doctorImageInput" name="doctor_image" form="createDoctorForm"
                        accept="image/jpeg,image/png,image/jpg">

                </label>


                <div class="upload-note">

                    <i class="fa-solid fa-circle-info"></i>

                    <span>
                        JPG أو PNG — الحد الأقصى 5MB
                    </span>

                </div>


                

                <div class="profile-doctor-info">

                    <span class="doctor-profile-label">
                        الطبيب
                    </span>

                    <h3>
                        طبيب جديد
                    </h3>

                    <p>

                        <i class="fa-solid fa-stethoscope"></i>

                        سيتم تحديد التخصص من النموذج

                    </p>

                </div>


                

                <?php if($showSubscriptionForm): ?>
                    <div class="subscription-status subscribed">

                        <span class="status-icon">

                            <i class="fa-solid fa-check"></i>

                        </span>

                        <span>
                            سيتم إضافة اشتراك للطبيب
                        </span>

                    </div>
                <?php else: ?>
                    <div class="subscription-status unsubscribed">

                        <span class="status-icon">

                            <i class="fa-solid fa-user-slash"></i>

                        </span>

                        <span>
                            بدون اشتراك
                        </span>

                    </div>
                <?php endif; ?>

            </aside>


            

            <main class="doctor-form-content">


                

                <form id="createDoctorForm" action="<?php echo e(route('admin.doctor.store')); ?>" method="POST"
                    enctype="multipart/form-data">

                    <?php echo csrf_field(); ?>


                    

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
                                    البيانات الأساسية للطبيب التي تظهر في الدليل
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

                                    <input id="doctorName" type="text" name="name" value="<?php echo e(old('name')); ?>"
                                        placeholder="اكتب اسم الطبيب" required>

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

                                <label for="email">
                                    البريد الإلكتروني
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-envelope"></i>

                                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>"
                                        placeholder="example@email.com" required>

                                </div>

                                <?php $__errorArgs = ['email'];
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

                                <label for="password">
                                    كلمة المرور
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-lock"></i>

                                    <input id="password" type="password" name="password" placeholder="اكتب كلمة المرور"
                                        required>

                                </div>

                                <?php $__errorArgs = ['password'];
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

                                <label for="password">
                                    تاكيد كلمه المرور
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-lock"></i>

                                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder=" اكتب كلمه المرور مره اخرى  "
                                        required>

                                </div>

                                <?php $__errorArgs = ['password_confirmation'];
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

                                <label for="specialty">
                                    التخصص
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-stethoscope"></i>

                                    <select id="specialty" name="specialty_id" required>

                                        <option value="">
                                            اختر التخصص
                                        </option>

                                        <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($specialty->id); ?>" <?php if(old('specialty_id') == $specialty->id): echo 'selected'; endif; ?>>

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
                                    <small class="field-error">
                                        <?php echo e($message); ?>

                                    </small>
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

                                    <select id="area" name="area_id" required>

                                        <option value="">
                                            اختر المنطقة
                                        </option>

                                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($area->id); ?>" <?php if(old('area_id') == $area->id): echo 'selected'; endif; ?>>

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
                                    <small class="field-error">
                                        <?php echo e($message); ?>

                                    </small>
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

                                    <input id="phone" type="text" name="phone" value="<?php echo e(old('phone')); ?>"
                                        placeholder="مثال: 01012345678">

                                </div>

                                <?php $__errorArgs = ['phone'];
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

                                <label for="experience">
                                    سنوات الخبرة
                                </label>

                                <div class="input-wrapper">



                                    <input id="experience" type="number" name="experience"
                                        value="<?php echo e(old('experience')); ?>" placeholder="عدد سنوات الخبرة" min="0">

                                    <span class="input-unit">
                                        سنة
                                    </span>

                                </div>

                                <?php $__errorArgs = ['experience'];
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

                                <label for="whatsapp">
                                    رقم واتساب
                                </label>

                                <div class="input-wrapper whatsapp-input">

                                    <i class="fa-brands fa-whatsapp"></i>

                                    <input id="whatsapp" type="text" name="whatsapp" value="<?php echo e(old('whatsapp')); ?>"
                                        placeholder="مثال: 01012345678">

                                </div>

                                <?php $__errorArgs = ['whatsapp'];
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

                                <label for="consultationPrice">
                                    سعر الكشف
                                </label>

                                <div class="input-wrapper">



                                    <input id="consultationPrice" type="number" name="consultation_price"
                                        value="<?php echo e(old('consultation_price')); ?>" placeholder="مثال: 300" min="0">

                                    <span class="input-unit">
                                        جنيه
                                    </span>

                                </div>

                                <?php $__errorArgs = ['consultation_price'];
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

                                <label for="bio">
                                    نبذة عن الطبيب
                                </label>

                                <div class="textarea-box">

                                    <textarea id="bio" name="bio" rows="5" placeholder="اكتب نبذة مختصرة عن الطبيب وخبرته وتخصصه..."><?php echo e(old('bio')); ?></textarea>

                                </div>

                                <?php $__errorArgs = ['bio'];
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
                                    بيانات ومعلومات العيادة الأساسية
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
                                        value="<?php echo e(old('clinic_name')); ?>" placeholder="اكتب اسم العيادة">

                                </div>

                                <?php $__errorArgs = ['clinic_name'];
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

                                <label for="address">
                                    عنوان العيادة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <input id="address" type="text" name="address" value="<?php echo e(old('address')); ?>"
                                        placeholder="اكتب عنوان العيادة">

                                </div>

                                <?php $__errorArgs = ['address'];
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

                                <label for="workingHours">
                                    مواعيد العمل
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-regular fa-clock"></i>

                                    <input id="workingHours" type="text" name="working_hours"
                                        value="<?php echo e(old('working_hours')); ?>" placeholder="مثال: من 4 مساءً إلى 10 مساءً">

                                </div>

                                <?php $__errorArgs = ['working_hours'];
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


                    

                    <?php if($showSubscriptionForm): ?>

                        <div class="edit-card subscription-card">


                            

                            <div class="subscription-header">

                                <div class="card-title subscription-title">

                                    <div class="card-title-icon crown">

                                        <i class="fa-solid fa-crown"></i>

                                    </div>

                                    <div>

                                        <h2>
                                            اشتراك الطبيب
                                        </h2>

                                        <p>
                                            إضافة الاشتراك مع إنشاء الطبيب
                                        </p>

                                    </div>

                                </div>


                                <span class="subscription-badge active">

                                    <i class="fa-solid fa-circle-check"></i>

                                    سيتم تفعيل الاشتراك

                                </span>

                            </div>


                            

                            <div class="subscription-section">

                                <div class="section-heading">

                                    <div class="section-heading-icon">

                                        <i class="fa-solid fa-box-open"></i>

                                    </div>

                                    <div>

                                        <strong>
                                            بيانات الاشتراك
                                        </strong>

                                        <span>
                                            الباقة والتاريخ والسعر
                                        </span>

                                    </div>

                                </div>


                                <div class="subscription-form-grid">


                                    

                                    <div class="form-group">

                                        <label for="subscriptionPlan">
                                            الباقة
                                        </label>

                                        <div class="input-wrapper">

                                            <i class="fa-solid fa-box"></i>

                                            <select id="subscriptionPlan" name="plan_id" required>

                                                <option value="">
                                                    اختر الباقة
                                                </option>

                                                <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($plan->id); ?>" <?php if(old('plan_id') == $plan->id): echo 'selected'; endif; ?>>

                                                        <?php echo e($plan->name); ?> -
                                                        <?php echo e($plan->price); ?> جنيه -
                                                        <?php echo e(round($plan->duration / 30)); ?> شهر

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </select>

                                        </div>

                                        <?php $__errorArgs = ['plan_id'];
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

                                        <label for="subscriptionStartDate">
                                            تاريخ البداية
                                        </label>

                                        <div class="input-wrapper">

                                            <input id="subscriptionStartDate" type="date" name="start_date"
                                                value="<?php echo e(old('start_date', now()->format('Y-m-d'))); ?>"
                                                min="<?php echo e(now()->format('Y-m-d')); ?>" required>

                                        </div>

                                        <?php $__errorArgs = ['start_date'];
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

                                        <label for="subscriptionPrice">
                                            سعر الاشتراك
                                        </label>

                                        <div class="input-wrapper">

                                            <input id="subscriptionPrice" type="number" name="price" min="0"
                                                value="<?php echo e(old('price')); ?>" placeholder="مثال: 300" required>

                                            <span class="input-unit">
                                                جنيه
                                            </span>

                                        </div>

                                        <?php $__errorArgs = ['price'];
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


                            

                            <div class="subscription-section">

                                <div class="section-heading">

                                    <div class="section-heading-icon star">

                                        <i class="fa-solid fa-star"></i>

                                    </div>

                                    <div>

                                        <strong>
                                            البيانات الإضافية
                                        </strong>

                                        <span>
                                            الخدمات والموقع وصور العيادة
                                        </span>

                                    </div>

                                </div>


                                <div class="subscription-extra-grid">


                                    

                                    <div class="form-group full">

                                        <label for="services">
                                            خدمات الطبيب
                                        </label>

                                        <div class="textarea-box">

                                            <textarea id="services" name="services" rows="4" placeholder="اكتب كل خدمة في سطر منفصل"><?php echo e(old('services')); ?></textarea>

                                        </div>

                                        <?php $__errorArgs = ['services'];
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

                                        <?php $__errorArgs = ['services.*'];
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

                                        <label for="googleMapsUrl">
                                            موقع العيادة على Google Maps
                                        </label>

                                        <div class="input-wrapper">

                                            <i class="fa-solid fa-map-location-dot"></i>

                                            <input id="googleMapsUrl" type="url" name="google_maps_url"
                                                value="<?php echo e(old('google_maps_url')); ?>"
                                                placeholder="https://maps.google.com/...">

                                        </div>

                                        <?php $__errorArgs = ['google_maps_url'];
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

                                        <label class="field-label">
                                            صور العيادة
                                        </label>


                                        

                                        <div id="clinicImagesPreview" class="clinic-images-preview">
                                        </div>


                                        

                                        <div class="clinic-images-upload">

                                            <label for="clinicImagesInput" class="clinic-images-dropzone">

                                                <i class="fa-solid fa-images"></i>

                                                <strong>
                                                    أضف صور للعيادة
                                                </strong>

                                                <input type="file" id="clinicImagesInput" name="clinic_images[]"
                                                    accept="image/jpeg,image/png,image/jpg" multiple>

                                            </label>

                                        </div>


                                        

                                        <div id="clinicImagesCount" class="clinic-images-count">

                                            <span class="count-icon">

                                                <i class="fa-solid fa-images"></i>

                                            </span>

                                            <span class="count-text">
                                                لم يتم اختيار صور جديدة
                                            </span>

                                        </div>


                                        <div class="input-hint">

                                            <i class="fa-solid fa-circle-info"></i>

                                            يمكنك إضافة حتى 3 صور للعيادة.

                                        </div>


                                        <?php $__errorArgs = ['clinic_images'];
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

                                        <?php $__errorArgs = ['clinic_images.*'];
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

                        </div>

                    <?php endif; ?>


                    

                    <div class="save-section">

                        <button type="submit" class="save-btn" data-submit-form="createDoctorForm">

                            <i class="fa-solid fa-floppy-disk"></i>

                            <span>
                                حفظ الطبيب
                            </span>

                        </button>

                    </div>

                </form>


                

                <?php if(!$showSubscriptionForm): ?>
                    <div class="edit-card no-subscription-card">

                        <div class="empty-subscription">

                            <div class="empty-icon">

                                <i class="fa-solid fa-user-slash"></i>

                            </div>

                            <div class="empty-content">

                                <span class="empty-label">
                                    الاشتراك
                                </span>

                                <h2>
                                    إنشاء الطبيب بدون اشتراك
                                </h2>

                                <p>
                                    يمكنك إنشاء الطبيب أولًا بدون اشتراك،
                                    أو فتح نموذج الاشتراك لإرسال بيانات الطبيب والاشتراك معًا.
                                </p>

                            </div>

                        </div>


                        <a href="<?php echo e(route('admin.doctor.create', ['subscribe' => 1])); ?>" class="activate-btn">

                            <i class="fa-solid fa-plus"></i>

                            <span>
                                إضافة اشتراك مع الطبيب
                            </span>

                        </a>

                    </div>
                <?php else: ?>
                    <div class="edit-card no-subscription-card">

                        <div class="empty-subscription">

                            <div class="empty-icon">

                                <i class="fa-solid fa-crown"></i>

                            </div>

                            <div class="empty-content">

                                <span class="empty-label">
                                    الاشتراك
                                </span>

                                <h2>
                                    الاشتراك مفتوح
                                </h2>

                                <p>
                                    سيتم إرسال بيانات الطبيب والاشتراك في نفس العملية.
                                </p>

                            </div>

                        </div>


                        <a href="<?php echo e(route('admin.doctor.create')); ?>" class="subscription-btn cancel-btn">

                            <i class="fa-solid fa-xmark"></i>

                            <span>
                                إنشاء الطبيب بدون اشتراك
                            </span>

                        </a>

                    </div>
                <?php endif; ?>

            </main>

        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/doctors/add_doctor.blade.php ENDPATH**/ ?>
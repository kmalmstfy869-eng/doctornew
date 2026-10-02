<?php $__env->startSection('title', 'دليل الأطباء | تسجيل الطبيب'); ?>

<?php $__env->startSection('content'); ?>

    <div class="doctor-register-page">


        <div class="doctor-register-bg-circle doctor-register-circle-one"></div>
        <div class="doctor-register-bg-circle doctor-register-circle-two"></div>

        <main class="doctor-register-main">

            

            <div class="doctor-register-heading">

                <div class="doctor-register-heading-content">

                    <div class="doctor-register-heading-badge">
                        <span></span>
                        انضم إلى شبكة الأطباء
                    </div>

                    <h1>
                        أنشئ ملفك الطبي
                        <span>الاحترافي</span>
                    </h1>

                    <p>
                        أنشئ حسابك وأضف بيانات عيادتك وتخصصك
                        حتى يتمكن المرضى من العثور عليك بسهولة
                        والتعرف على خدماتك.
                    </p>

                </div>

                <div class="doctor-register-note">

                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 21C12 21 19 17.5 19 11V5.5L12 3L5 5.5V11C5 17.5 12 21 12 21Z" stroke="currentColor"
                            stroke-width="1.7" />

                        <path d="M8.5 12L10.7 14.2L15.5 9.5" stroke="currentColor" stroke-width="1.7"
                            stroke-linecap="round" />
                    </svg>

                    بياناتك تظهر للمرضى بعد اعتماد الحساب

                </div>

            </div>


            

            <div class="doctor-register-layout">


                

                <aside class="doctor-register-preview">

                    <div class="doctor-register-preview-content">

                        <div class="doctor-register-preview-top">

                            <span class="doctor-register-preview-label">
                                معاينة الملف الطبي
                            </span>

                            <span class="doctor-register-preview-status">
                                <span></span>
                                ملف جديد
                            </span>

                        </div>


                        <div class="doctor-register-avatar">

                            <svg viewBox="0 0 24 24" fill="none">

                                <circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.6" />

                                <path d="M5 20C5.6 15.9 8.1 13.5 12 13.5C15.9 13.5 18.4 15.9 19 20" stroke="currentColor"
                                    stroke-width="1.6" stroke-linecap="round" />

                                <path d="M17 4V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />

                                <path d="M15 6H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />

                            </svg>

                        </div>


                        <div class="doctor-register-preview-name" id="previewName">
                            اسم الدكتور
                        </div>

                        <div class="doctor-register-preview-specialty" id="previewSpecialty">
                            التخصص الطبي
                        </div>


                        <div class="doctor-register-preview-details">


                            

                            <div class="doctor-register-preview-item">

                                <div class="doctor-register-preview-item-icon">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <path d="M4 10L12 4L20 10" stroke="currentColor" stroke-width="1.6"
                                            stroke-linecap="round" stroke-linejoin="round" />

                                        <path d="M6 9V19H18V9" stroke="currentColor" stroke-width="1.6" />

                                        <path d="M9 19V14H15V19" stroke="currentColor" stroke-width="1.6" />

                                    </svg>

                                </div>

                                <div>

                                    <strong>العيادة</strong>

                                    <span id="previewClinic">
                                        اسم العيادة
                                    </span>

                                </div>

                            </div>


                            

                            <div class="doctor-register-preview-item">

                                <div class="doctor-register-preview-item-icon">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <path
                                            d="M12 21C16 17 19 14.1 19 10C19 6.13 15.87 3 12 3C8.13 3 5 6.13 5 10C5 14.1 8 17 12 21Z"
                                            stroke="currentColor" stroke-width="1.6" />

                                        <circle cx="12" cy="10" r="2.5" stroke="currentColor"
                                            stroke-width="1.6" />

                                    </svg>

                                </div>

                                <div>

                                    <strong>المنطقة</strong>

                                    <span id="previewArea">
                                        لم يتم اختيارها
                                    </span>

                                </div>

                            </div>


                            

                            <div class="doctor-register-preview-item">

                                <div class="doctor-register-preview-item-icon">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <path d="M12 6V18" stroke="currentColor" stroke-width="1.6"
                                            stroke-linecap="round" />

                                        <path
                                            d="M15 8.5C15 7.12 13.66 6 12 6C10.34 6 9 7.12 9 8.5C9 9.88 10.34 11 12 11C13.66 11 15 12.12 15 13.5C15 14.88 13.66 16 12 16C10.34 16 9 14.88 9 13.5"
                                            stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />

                                    </svg>

                                </div>

                                <div>

                                    <strong>سعر الكشف</strong>

                                    <span id="previewPrice">
                                        لم يحدد بعد
                                    </span>

                                </div>

                            </div>

                        </div>


                        <div class="doctor-register-preview-message">

                            <strong>
                                ملفك يبدأ من هنا
                            </strong>

                            أكمل بياناتك الأساسية ليظهر ملفك
                            بشكل احترافي أمام المرضى داخل دليل الأطباء.

                        </div>

                    </div>

                </aside>


                

                <section class="doctor-register-form-card">

                    <form id="doctorRegistrationForm" action="<?php echo e(route('doctor_join.store')); ?>" method="POST">

                        <?php echo csrf_field(); ?>


                        

                        <div class="doctor-register-section">

                            <div class="doctor-register-section-title">

                                <div class="doctor-register-section-number">
                                    01
                                </div>

                                <div>

                                    <h2>
                                        البيانات الأساسية
                                    </h2>

                                    <p>
                                        المعلومات الأساسية التي ستظهر في ملفك
                                    </p>

                                </div>

                            </div>


                            <div class="doctor-register-fields-grid">


                                

                                <div class="doctor-register-field">

                                    <label for="doctor_name">
                                        اسم الدكتور
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <span class="doctor-register-field-icon">
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <circle cx="12" cy="8" r="3.5" stroke="currentColor"
                                                    stroke-width="1.6" />

                                                <path d="M5 20C5.6 15.9 8.1 13.5 12 13.5C15.9 13.5 18.4 15.9 19 20"
                                                    stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                                            </svg>
                                        </span>

                                        <input type="text" id="doctor_name" name="name"
                                            value="<?php echo e(old('name')); ?>" placeholder="د. أحمد محمد">

                                    </div>

                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>


                                

                                <div class="doctor-register-field">

                                    <label for="clinic_name">
                                        اسم العيادة
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <input type="text" id="clinic_name" name="clinic_name"
                                            value="<?php echo e(old('clinic_name')); ?>" placeholder="عيادة الدكتور أحمد">

                                    </div>

                                    <?php $__errorArgs = ['clinic_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>


                                

                                <div class="doctor-register-field">

                                    <label for="specialty">
                                        التخصص
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <select id="specialty" name="specialty_id">

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
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>


                                

                                <div class="doctor-register-field">

                                    <label for="area">
                                        المنطقة
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <select id="area" name="area_id">

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
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>

                            </div>

                        </div>


                        

                        <div class="doctor-register-section">

                            <div class="doctor-register-section-title">

                                <div class="doctor-register-section-number">
                                    02
                                </div>

                                <div>

                                    <h2>
                                        بيانات الحساب
                                    </h2>

                                    <p>
                                        البيانات التي تستخدمها للدخول إلى حسابك
                                    </p>

                                </div>

                            </div>


                            <div class="doctor-register-fields-grid">


                                

                                <div class="doctor-register-field doctor-register-field-full">

                                    <label for="email">
                                        البريد الإلكتروني
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>"
                                            placeholder="doctor@example.com" autocomplete="email">

                                    </div>

                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>


                                

                                <div class="doctor-register-field">

                                    <label for="registerPassword">
                                        كلمة المرور
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <input type="password" id="registerPassword" name="password"
                                            class="doctor-register-password-input" placeholder="••••••••"
                                            autocomplete="new-password">

                                        <button type="button" class="doctor-login-password-toggle"
                                            id="doctorRegisterTogglePassword" aria-label="إظهار كلمة المرور">

                                            <svg viewBox="0 0 24 24" fill="none">

                                                <path
                                                    d="M2.5 12C4.5 8 8 6 12 6C16 6 19.5 8 21.5 12C19.5 16 16 18 12 18C8 18 4.5 16 2.5 12Z"
                                                    stroke="currentColor" stroke-width="1.6" />

                                                <circle cx="12" cy="12" r="2.5" stroke="currentColor"
                                                    stroke-width="1.6" />

                                            </svg>

                                        </button>

                                    </div>

                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>


                                    <div class="doctor-register-password-strength">

                                        <div class="doctor-register-strength-bars">

                                            <span class="doctor-register-strength-bar" id="doctorRegisterBar1"></span>

                                            <span class="doctor-register-strength-bar" id="doctorRegisterBar2"></span>

                                            <span class="doctor-register-strength-bar" id="doctorRegisterBar3"></span>

                                            <span class="doctor-register-strength-bar" id="doctorRegisterBar4"></span>

                                        </div>

                                        <span class="doctor-register-strength-text" id="doctorRegisterStrengthText">
                                            قوة كلمة المرور
                                        </span>

                                    </div>

                                </div>


                                

                                <div class="doctor-register-field">

                                    <label for="registerPasswordConfirmation">
                                        تأكيد كلمة المرور
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <input type="password" id="registerPasswordConfirmation"
                                            name="password_confirmation" class="doctor-register-password-input"
                                            placeholder="أعد كتابة كلمة المرور" autocomplete="new-password">

                                        <button type="button" class="doctor-login-password-toggle"
                                            id="doctorRegisterTogglePasswordConfirmation" aria-label="إظهار كلمة المرور">

                                            <svg viewBox="0 0 24 24" fill="none">

                                                <path
                                                    d="M2.5 12C4.5 8 8 6 12 6C16 6 19.5 8 21.5 12C19.5 16 16 18 12 18C8 18 4.5 16 2.5 12Z"
                                                    stroke="currentColor" stroke-width="1.6" />

                                                <circle cx="12" cy="12" r="2.5" stroke="currentColor"
                                                    stroke-width="1.6" />

                                            </svg>

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        

                        <div class="doctor-register-section">

                            <div class="doctor-register-section-title">

                                <div class="doctor-register-section-number">
                                    03
                                </div>

                                <div>

                                    <h2>
                                        معلومات التواصل والعيادة
                                    </h2>

                                    <p>
                                        المعلومات التي تساعد المريض على الوصول إليك
                                    </p>

                                </div>

                            </div>


                            <div class="doctor-register-fields-grid">


                                

                                <div class="doctor-register-field">

                                    <label for="phone">
                                        رقم الهاتف
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <input type="tel" id="phone" name="phone" value="<?php echo e(old('phone')); ?>"
                                            placeholder="01XXXXXXXXX">

                                    </div>

                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>


                                

                                <div class="doctor-register-field">

                                    <label for="whatsapp">
                                        رقم الواتساب
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <input type="tel" id="whatsapp" name="whatsapp"
                                            value="<?php echo e(old('whatsapp')); ?>" placeholder="01XXXXXXXXX">

                                    </div>


                                    <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>


                                

                                <div class="doctor-register-field doctor-register-field-full">

                                    <label for="location">
                                        موقع العيادة
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <input type="text" id="location" name="location"
                                            value="<?php echo e(old('location')); ?>"
                                            placeholder="مثال: شارع الجمهورية، بجوار مستشفى..." required>

                                    </div>

                                    <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>


                                

                                <div class="doctor-register-field doctor-register-field-full">

                                    <label for="working_hours">
                                        مواعيد العمل
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <input type="text" id="working_hours" name="working_hours"
                                            value="<?php echo e(old('working_hours')); ?>"
                                            placeholder="مثال: من 5 مساءً إلى 10 مساءً، السبت إلى الخميس" required>

                                    </div>

                                    <?php $__errorArgs = ['working_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>


                                

                                <div class="doctor-register-field">

                                    <label for="price">
                                        سعر الكشف
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <input type="number" id="price" name="consultation_price"
                                            value="<?php echo e(old('consultation_price')); ?>" class="doctor-register-price-input"
                                            placeholder="300" min="0">

                                        <span class="doctor-register-price-currency">
                                            جنيه
                                        </span>

                                    </div>

                                    <?php $__errorArgs = ['consultation_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>


                                

                                <div class="doctor-register-field">

                                    <label for="experience">
                                        سنوات الخبرة
                                        <span class="doctor-register-required">*</span>
                                    </label>

                                    <div class="doctor-register-input-wrap">

                                        <input type="number" id="experience" name="experience"
                                            value="<?php echo e(old('experience')); ?>" placeholder="مثال: 10" min="0">

                                    </div>

                                    <?php $__errorArgs = ['experience'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="field-error">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>

                            </div>

                        </div>


                        

                        <div class="doctor-register-section">

                            <div class="doctor-register-section-title">

                                <div class="doctor-register-section-number">
                                    04
                                </div>

                                <div>

                                    <h2>
                                        نبذة عنك
                                    </h2>

                                    <p>
                                        عرّف المرضى بخبرتك وتخصصك وخدماتك
                                    </p>

                                </div>

                            </div>


                            <div class="doctor-register-field doctor-register-bio-field">

                                <label for="bio">
                                    نبذة عن الدكتور
                                    <span class="doctor-register-required">*</span>
                                </label>

                                <div class="doctor-register-input-wrap">

                                    <textarea id="bio" name="bio" maxlength="500"
                                        placeholder="اكتب نبذة مختصرة عن خبرتك، تخصصك، الخدمات التي تقدمها..."><?php echo e(old('bio')); ?></textarea>

                                    <span class="doctor-register-char-count" id="doctorRegisterCharCount">
                                        0 / 500
                                    </span>

                                </div>

                                <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="field-error">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>


                            

                            <label class="doctor-register-terms">

                                <input type="checkbox" id="terms" name="terms" value="1" checked>

                                <span>

                                    أوافق على

                                    <a href="#">
                                        شروط الاستخدام
                                    </a>

                                    و

                                    <a href="#">
                                        سياسة الخصوصية
                                    </a>

                                    وأقر بأن البيانات التي أدخلتها
                                    صحيحة.

                                </span>

                            </label>


                            <?php $__errorArgs = ['terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="field-error">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>


                        

                        <div class="doctor-register-form-footer">

                            <div class="doctor-register-privacy">

                                <div class="doctor-register-privacy-icon">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <path d="M12 21C12 21 19 17.5 19 11V5.5L12 3L5 5.5V11C5 17.5 12 21 12 21Z"
                                            stroke="currentColor" stroke-width="1.7" />

                                        <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="1.7"
                                            stroke-linecap="round" />

                                    </svg>

                                </div>

                                <span>
                                    معلوماتك محفوظة بأمان
                                    <br>
                                    وتخضع للمراجعة قبل النشر
                                </span>

                            </div>


                            <button type="submit" class="doctor-register-submit">

                                إنشاء حساب الطبيب

                                <svg viewBox="0 0 24 24" fill="none">

                                    <path d="M5 12H19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />

                                    <path d="M13 6L19 12L13 18" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round" />

                                </svg>

                            </button>

                        </div>

                    </form>

                </section>

            </div>

        </main>

    </div>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/password_strength.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/auth/doctor_register.blade.php ENDPATH**/ ?>
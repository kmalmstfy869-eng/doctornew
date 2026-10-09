<?php $__env->startSection('title', 'لوحة التحكم | تعديل بيانات الطبيب'); ?>

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
                        تعديل بيانات الطبيب
                    </h1>

                    <p>
                        إدارة البيانات الشخصية والعيادة والاشتراك
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

                        <?php if($doctor->doctor_image): ?>
                            <img id="doctorImagePreview" src="<?php echo e(asset('storage/' . $doctor->doctor_image)); ?>"
                                alt="<?php echo e($doctor->user->name); ?>" class="profile-image">

                            <div id="doctorImageDefault" class="doctor-default-image" style="display:none;">

                                <i class="fa-solid fa-user-doctor"></i>

                            </div>
                        <?php else: ?>
                            <div id="doctorImageDefault" class="doctor-default-image">

                                <i class="fa-solid fa-user-doctor"></i>

                            </div>

                            <img id="doctorImagePreview" src="" alt="صورة الطبيب" class="profile-image"
                                style="display:none;">
                        <?php endif; ?>


                        

                        <div class="profile-image-actions">

                            

                            <label for="doctorImageInput" class="change-profile-btn" title="اختيار صورة جديدة">

                                <i class="fa-solid fa-camera"></i>

                            </label>


                            

                            <?php if($doctor->doctor_image): ?>
                                <form method="POST" action="<?php echo e(route('admin.doctor.deleteImage', $doctor)); ?>"
                                    class="delete-profile-image-form"
                                    onsubmit="return confirm('هل أنت متأكد من حذف صورة الطبيب؟')">

                                    <?php echo csrf_field(); ?>

                                    <button type="submit" class="delete-profile-btn" title="حذف صورة الطبيب">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>
                            <?php endif; ?>

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

                    <input type="file" id="doctorImageInput" name="doctor_image" form="editDoctorForm"
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
                        د. <?php echo e($doctor->user->name); ?>

                    </h3>

                    <p>

                        <i class="fa-solid fa-stethoscope"></i>

                        <?php echo e($doctor->specialty->name ?? 'بدون تخصص'); ?>


                    </p>

                </div>


                

                <?php if($isCurrentlySubscribed): ?>
                    

                    <div class="subscription-status subscribed">

                        <span class="status-icon">
                            <i class="fa-solid fa-check"></i>
                        </span>

                        <span>
                            الطبيب مشترك حاليًا
                        </span>

                    </div>
                <?php elseif($hasPreviousSubscription): ?>
                    

                    <div class="subscription-status expired">

                        <span class="status-icon">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </span>

                        <span>
                            الاشتراك منتهي
                        </span>

                    </div>
                <?php else: ?>
                    

                    <div class="subscription-status unsubscribed">

                        <span class="status-icon">
                            <i class="fa-solid fa-user-slash"></i>
                        </span>

                        <span>
                            لم يشترك من قبل
                        </span>

                    </div>
                <?php endif; ?>


                

                <?php if($doctor->whatsapp): ?>
                    <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $doctor->whatsapp)); ?>" target="_blank"
                        rel="noopener" class="whatsapp-btn">

                        <span class="whatsapp-icon">
                            <i class="fa-brands fa-whatsapp"></i>
                        </span>

                        <span>
                            التواصل عبر واتساب
                        </span>

                        <i class="fa-solid fa-arrow-up-left-from-circle"></i>

                    </a>
                <?php endif; ?>

            </aside>


            

            <main class="doctor-form-content">


                

                <form id="editDoctorForm" action="<?php echo e(route('admin.doctor.update', $doctor)); ?>" method="POST"
                    enctype="multipart/form-data">

                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>


                    

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

                                    <input id="doctorName" type="text" name="name"
                                        value="<?php echo e(old('name', $doctor->user->name)); ?>" placeholder="اكتب اسم الطبيب"
                                        required>

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

                                <label for="specialty">
                                    التخصص
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-stethoscope"></i>

                                    <select id="specialty" name="specialty_id" required>

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
                                    اختر المنطقة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <select id="area" name="area_id" required>

                                        <?php $__currentLoopData = \App\Models\Area::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

                                    <input id="phone" type="text" name="phone"
                                        value="<?php echo e(old('phone', $doctor->phone)); ?>" placeholder="مثال: 01012345678">

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

                                    <i class="fa-solid fa-user-clock"></i>

                                    <input id="experience" type="number" name="experience"
                                        value="<?php echo e(old('experience', $doctor->experience)); ?>"
                                        placeholder="عدد سنوات الخبرة" min="0">

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

                                    <input id="whatsapp" type="text" name="whatsapp"
                                        value="<?php echo e(old('whatsapp', $doctor->whatsapp)); ?>" placeholder="مثال: 01012345678">

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

                                    <i class="fa-solid fa-money-bill-wave"></i>

                                    <input id="consultationPrice" type="number" name="consultation_price"
                                        value="<?php echo e(old('consultation_price', $doctor->consultation_price)); ?>"
                                        placeholder="مثال: 300" min="0">

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

                                    <textarea id="bio" name="bio" rows="5" placeholder="اكتب نبذة مختصرة عن الطبيب وخبرته وتخصصه..."><?php echo e(old('bio', $doctor->bio)); ?></textarea>

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
                                        value="<?php echo e(old('clinic_name', $doctor->clinic_name)); ?>"
                                        placeholder="اكتب اسم العيادة">

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

                                    <input id="address" type="text" name="address"
                                        value="<?php echo e(old('address', $doctor->address)); ?>" placeholder="اكتب عنوان العيادة">

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
                                        value="<?php echo e(old('working_hours', $doctor->working_hours)); ?>"
                                        placeholder="مثال: من 4 مساءً إلى 10 مساءً">

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


                    

                    <div class="save-section">

                        <button type="submit" class="save-btn" data-submit-form="editDoctorForm">

                            <i class="fa-solid fa-floppy-disk"></i>

                            <span>
                                حفظ التغييرات
                            </span>

                        </button>

                    </div>

                </form>


                

                <?php if($showSubscriptionForm || $hasPreviousSubscription): ?>

                    <div class="edit-card subscription-card">


                        

                        <div class="subscription-header">

                            <div class="card-title subscription-title">

                                <div class="card-title-icon <?php echo e($isCurrentlySubscribed ? 'crown' : ''); ?>">

                                    <i class="fa-solid <?php echo e($isCurrentlySubscribed ? 'fa-crown' : 'fa-credit-card'); ?>"></i>

                                </div>

                                <div>

                                    <h2>

                                        <?php if($isCurrentlySubscribed): ?>
                                            الاشتراك الحالي
                                        <?php else: ?>
                                            الاشتراك السابق - يمكن تفعيله من جديد
                                        <?php endif; ?>

                                    </h2>

                                    <p>

                                        <?php if($isCurrentlySubscribed): ?>
                                            يمكنك تعديل بيانات الاشتراك الحالية
                                        <?php else: ?>
                                            الاشتراك السابق انتهى ويمكنك تفعيله من جديد باستخدام البيانات الحالية
                                        <?php endif; ?>

                                    </p>

                                </div>

                            </div>


                            

                            <?php if($isCurrentlySubscribed): ?>
                                <span class="subscription-badge active">

                                    <i class="fa-solid fa-circle-check"></i>

                                    مشترك حاليًا

                                </span>
                            <?php elseif($hasPreviousSubscription): ?>
                                <span class="subscription-badge expired">

                                    <i class="fa-solid fa-clock-rotate-left"></i>

                                    منتهي

                                </span>
                            <?php endif; ?>

                        </div>


                        

                        <div class="current-plan">

                            <div class="plan-icon">

                                <i class="fa-solid fa-crown"></i>

                            </div>

                            <div class="plan-details">

                                <strong>
                                    <?php echo e($subscription->plan->name); ?>

                                </strong>

                                <span>
                                    الباقة الحالية -
                                    <?php echo e(round($subscription->plan->duration / 30)); ?> شهر
                                </span>

                                <?php if($isCurrentlySubscribed): ?>
                                    <span class="subscription-state-text">
                                        الاشتراك ساري حاليًا
                                    </span>
                                <?php else: ?>
                                    <span class="subscription-state-text">
                                        الاشتراك منتهي ويمكن تفعيله مرة أخرى
                                    </span>
                                <?php endif; ?>

                            </div>

                        </div>


                        

                        <form id="subscribeDoctorForm" method="POST"
                            action="<?php echo e(route('admin.doctor.subscribe', $doctor)); ?>" enctype="multipart/form-data">

                            <?php echo csrf_field(); ?>


                            

                            <div class="subscription-section">

                                <div class="section-heading">

                                    <div class="section-heading-icon">

                                        <i class="fa-solid fa-box-open"></i>

                                    </div>

                                    <div>

                                        <strong>

                                            <?php if($isCurrentlySubscribed): ?>
                                                تعديل بيانات الاشتراك
                                            <?php else: ?>
                                                إعادة تفعيل الاشتراك
                                            <?php endif; ?>

                                        </strong>

                                        <span>

                                            <?php if($isCurrentlySubscribed): ?>
                                                يمكنك تعديل الباقة والتاريخ والسعر
                                            <?php else: ?>
                                                راجع البيانات القديمة ثم قم بتفعيل الاشتراك من جديد
                                            <?php endif; ?>

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
                                                    <option value="<?php echo e($plan->id); ?>" <?php if(old('plan_id', $subscription?->plan_id) == $plan->id): echo 'selected'; endif; ?>>

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
                                                value="<?php echo e(old('start_date', $subscription ? $subscription->start_date->format('Y-m-d') : now()->format('Y-m-d'))); ?>"
                                                required>

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
                                                value="<?php echo e(old('price', $subscription ? $subscription->price : null)); ?>"
                                                placeholder="مثال: 300" required>

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

                                            <textarea id="services" name="services" rows="4" placeholder="اكتب كل خدمة في سطر منفصل"><?php echo e(old('services', is_array($doctor->services) ? implode("\n", $doctor->services) : '')); ?></textarea>

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
                                                value="<?php echo e(old('google_maps_url', $doctor->google_maps_url ?? '')); ?>"
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


                                        

                                        <?php if(!empty($doctor->clinic_images)): ?>

                                            <div class="clinic-images-preview">

                                                <?php $__currentLoopData = $doctor->clinic_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="clinic-image-preview-item old-clinic-image"
                                                        data-image="<?php echo e($image); ?>">

                                                        <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="صورة العيادة">

                                                        <label class="clinic-image-delete">

                                                            <input type="checkbox" name="delete_clinic_images[]"
                                                                value="<?php echo e($image); ?>">

                                                            <span>
                                                                ×
                                                            </span>

                                                        </label>

                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>

                                        <?php endif; ?>


                                        

                                        <div id="clinicImagesPreview" class="clinic-images-preview">
                                        </div>


                                        

                                        <div class="clinic-images-upload">

                                            <label for="clinicImagesInput" class="clinic-images-dropzone">

                                                <i class="fa-solid fa-images"></i>

                                                <strong>
                                                    أضف صور جديدة للعيادة
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

                                            لو عايز تحذف صورة قديمة، علم على علامة × الموجودة عليها، وعند تحديدها هتتحول
                                            علامة × للون الأخضر.
                                            ولو عايز تضيف صور جديدة، اختارها من المربع بالأعلى.

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

                                        <?php $__errorArgs = ['delete_clinic_images'];
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


                            

                            <div class="subscription-actions">


                                

                                <?php if($showSubscriptionForm): ?>
                                    <a href="<?php echo e(route('admin.doctor.edit', $doctor)); ?>"
                                        class="subscription-btn cancel-btn">

                                        <i class="fa-solid fa-xmark"></i>

                                        <span>
                                            إلغاء
                                        </span>

                                    </a>
                                <?php endif; ?>


                                

                                <button type="submit" class="subscription-btn activate-btn"
                                    data-submit-form="subscribeDoctorForm">

                                    <i class="fa-solid fa-check"></i>

                                    <span>

                                        <?php if($isCurrentlySubscribed): ?>
                                            حفظ بيانات الاشتراك
                                        <?php else: ?>
                                            إعادة تفعيل الاشتراك
                                        <?php endif; ?>

                                    </span>

                                </button>

                            </div>

                        </form>


                        

                        <?php if($isCurrentlySubscribed): ?>
                            <form method="POST" action="<?php echo e(route('admin.doctor.cancelSubscription', $doctor)); ?>"
                                class="cancel-subscription-form"
                                onsubmit="return confirm('هل أنت متأكد من إلغاء اشتراك الطبيب؟')">

                                <?php echo csrf_field(); ?>

                                <button type="submit" class="cancel-subscription-btn">

                                    <i class="fa-regular fa-circle-xmark"></i>

                                    <span>
                                        إلغاء اشتراك الطبيب
                                    </span>

                                </button>

                            </form>
                        <?php elseif($hasPreviousSubscription): ?>
                            

                            <div class="expired-subscription-notice">



                                <div>

                                    <strong>
                                        الاشتراك السابق منتهي
                                    </strong>

                                    <span>
                                        يمكنك إعادة تفعيله من خلال النموذج أعلاه.
                                    </span>

                                </div>

                            </div>
                        <?php endif; ?>


                    </div>
                <?php else: ?>
                    

                    <div class="edit-card no-subscription-card">

                        <div class="empty-subscription">

                            <div class="empty-icon">

                                <i class="fa-solid fa-user-slash"></i>

                            </div>

                            <div class="empty-content">

                                <span class="empty-label">
                                    حالة الاشتراك
                                </span>

                                <h2>
                                    لم يشترك من قبل
                                </h2>

                                <p>
                                    هذا الطبيب لا يوجد له أي اشتراك سابق.
                                    يمكنك إضافة اشتراك جديد لإتاحة المميزات الإضافية للطبيب.
                                </p>

                            </div>

                        </div>


                        <a href="<?php echo e(route('admin.doctor.edit', [
                            'doctor' => $doctor,
                            'subscribe' => 1,
                        ])); ?>"
                            class="activate-btn">

                            <i class="fa-solid fa-plus"></i>

                            <span>
                                إضافة اشتراك
                            </span>

                        </a>

                    </div>

                <?php endif; ?>

            </main>

        </div>

    </div>




<?php $__env->stopSection(); ?>
<?php $__env->startPush('extra_java'); ?>
    <script src="<?php echo e(asset('js/admin/image-lightbox.js')); ?>?v=<?php echo e(@filemtime(public_path('js/admin/image-lightbox.js')) ?: time()); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/doctors/edit_doctor.blade.php ENDPATH**/ ?>
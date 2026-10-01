<?php $__env->startSection('title', 'إنشاء وظيفة | دليل الأطباء'); ?>

<?php $__env->startSection('content'); ?>

    

    <section class="home-section">

        <div class="site-container">

            <div class="home-jobs-banner">

                <div>

                    <span>
                        ساعد الآخرين
                    </span>

                    <h2>
                        أضف وظيفة جديدة
                    </h2>

                    <p>
                        أدخل بيانات الوظيفة لتظهر للباحثين عن عمل
                    </p>

                </div>

                <a href="<?php echo e(route('jobs.index')); ?>" class="home-jobs-button">

                    العودة للوظائف

                    <i class="fa-solid fa-arrow-left"></i>

                </a>

            </div>

        </div>

    </section>


    

    <main>

        <div class="container">

            <form
                method="POST"
                action="<?php echo e(route('job.store')); ?>"
                class="form-layout"
            >

                <?php echo csrf_field(); ?>


                <div>


                    

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-briefcase"></i>

                            بيانات الوظيفة

                        </h3>


                        <div class="form-grid">


                            

                            <div class="form-group">

                                <label>

                                    اسم الوظيفة

                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    value="<?php echo e(old('title')); ?>"
                                    placeholder="مثال: طبيب أسنان"
                                >

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

                                <label>

                                    مجال الوظيفة

                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="category"
                                    value="<?php echo e(old('category')); ?>"
                                    placeholder="مثال: طب وصحة"
                                >

                                <?php $__errorArgs = ['category'];
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

                                <label>

                                    اسم العيادة أو الجهة أو الدكتور

                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="company_name"
                                    value="<?php echo e(old('company_name')); ?>"
                                    placeholder="اسم المستشفى أو العيادة"
                                >

                                <?php $__errorArgs = ['company_name'];
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

                                <label>

                                    نوع الدوام

                                    <span class="required">*</span>

                                </label>

                                <select name="job_type">

                                    <option value="">
                                        اختر نوع الدوام
                                    </option>

                                    <option
                                        value="دوام كامل"
                                        <?php echo e(old('job_type') == 'دوام كامل' ? 'selected' : ''); ?>

                                    >
                                        دوام كامل
                                    </option>

                                    <option
                                        value="دوام جزئي"
                                        <?php echo e(old('job_type') == 'دوام جزئي' ? 'selected' : ''); ?>

                                    >
                                        دوام جزئي
                                    </option>

                                    <option
                                        value="العمل عن بعد"
                                        <?php echo e(old('job_type') == 'العمل عن بعد' ? 'selected' : ''); ?>

                                    >
                                        العمل عن بعد
                                    </option>

                                </select>

                                <?php $__errorArgs = ['job_type'];
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

                                <label>
                                    عدد الموظفين المطلوبين
                                </label>

                                <input
                                    type="number"
                                    name="vacancies"
                                    value="<?php echo e(old('vacancies', 1)); ?>"
                                    min="1"
                                    placeholder="مثال: 2"
                                >

                                <?php $__errorArgs = ['vacancies'];
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

                                <label>
                                    آخر موعد للتقديم
                                </label>

                                <input
                                    type="date"
                                    name="application_deadline"
                                    value="<?php echo e(old('application_deadline')); ?>"
                                >

                                <?php $__errorArgs = ['application_deadline'];
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

                    </section>


                    

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-location-dot"></i>

                            مكان العمل

                        </h3>


                        <div class="form-grid">

                            <div class="form-group full">

                                <label>

                                    عنوان مكان العمل

                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="location"
                                    value="<?php echo e(old('location')); ?>"
                                    placeholder="مثال: دمنهور، شارع الجمهورية، بجوار المستشفى العام"
                                >

                                <?php $__errorArgs = ['location'];
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

                    </section>


                    

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-money-bill-wave"></i>

                            الراتب والخبرة

                        </h3>


                        <div class="form-grid">


                            

                            <div class="form-group">

                                <label>
                                    الراتب من
                                </label>

                                <input
                                    type="number"
                                    name="salary_min"
                                    value="<?php echo e(old('salary_min')); ?>"
                                    min="0"
                                    placeholder="مثال: 3000"
                                >

                                <?php $__errorArgs = ['salary_min'];
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

                                <label>
                                    الراتب إلى
                                </label>

                                <input
                                    type="number"
                                    name="salary_max"
                                    value="<?php echo e(old('salary_max')); ?>"
                                    min="0"
                                    placeholder="مثال: 9000"
                                >

                                <?php $__errorArgs = ['salary_max'];
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

                                <label>
                                    الخبرة المطلوبة
                                </label>

                                <select name="experience">

                                    <option value="">
                                        اختر الخبرة
                                    </option>

                                    <option
                                        value="أقل من سنة"
                                        <?php echo e(old('experience') == 'أقل من سنة' ? 'selected' : ''); ?>

                                    >
                                        أقل من سنة
                                    </option>

                                    <option
                                        value="من سنة إلى 3 سنوات"
                                        <?php echo e(old('experience') == 'من سنة إلى 3 سنوات' ? 'selected' : ''); ?>

                                    >
                                        من سنة إلى 3 سنوات
                                    </option>

                                    <option
                                        value="من 3 إلى 5 سنوات"
                                        <?php echo e(old('experience') == 'من 3 إلى 5 سنوات' ? 'selected' : ''); ?>

                                    >
                                        من 3 إلى 5 سنوات
                                    </option>

                                    <option
                                        value="أكثر من 5 سنوات"
                                        <?php echo e(old('experience') == 'أكثر من 5 سنوات' ? 'selected' : ''); ?>

                                    >
                                        أكثر من 5 سنوات
                                    </option>

                                </select>

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

                                <label>
                                    المؤهل المطلوب
                                </label>

                                <input
                                    type="text"
                                    name="qualification"
                                    value="<?php echo e(old('qualification')); ?>"
                                    placeholder="مثال: بكالوريوس طب"
                                >

                                <?php $__errorArgs = ['qualification'];
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

                    </section>


                    

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-clock"></i>

                            مواعيد العمل

                        </h3>


                        <div class="form-grid">


                            <div class="form-group">

                                <label>
                                    ساعات العمل
                                </label>

                                <input
                                    type="text"
                                    name="working_hours"
                                    value="<?php echo e(old('working_hours')); ?>"
                                    placeholder="مثال: 8 ساعات يوميًا"
                                >

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


                            <div class="form-group">

                                <label>
                                    أيام العمل
                                </label>

                                <input
                                    type="text"
                                    name="working_days"
                                    value="<?php echo e(old('working_days')); ?>"
                                    placeholder="مثال: من السبت إلى الخميس"
                                >

                                <?php $__errorArgs = ['working_days'];
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

                    </section>


                    

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-file-lines"></i>

                            تفاصيل الوظيفة

                        </h3>


                        <div class="form-grid">

                            <div class="form-group full">

                                <label>

                                    وصف الوظيفة

                                    <span class="required">*</span>

                                </label>

                                <textarea
                                    name="description"
                                    placeholder="اكتب وصفًا واضحًا عن الوظيفة والمسؤوليات..."
                                ><?php echo e(old('description')); ?></textarea>

                                <?php $__errorArgs = ['description'];
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

                    </section>


                    

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-phone"></i>

                            بيانات التواصل

                        </h3>


                        <div class="form-grid">


                            

                            <div class="form-group">

                                <label>

                                    رقم الهاتف

                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="tel"
                                    name="phone"
                                    value="<?php echo e(old('phone')); ?>"
                                    placeholder="01XXXXXXXXX"
                                >

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

                                <label>
                                    رقم واتساب
                                </label>

                                <input
                                    type="tel"
                                    name="whatsapp"
                                    value="<?php echo e(old('whatsapp')); ?>"
                                    placeholder="01XXXXXXXXX"
                                >

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

                        </div>

                    </section>


                    

                    <div class="form-actions">

                        <button
                            type="submit"
                            class="details-btn"
                        >

                            إرسال الوظيفة للمراجعة



                        </button>

                    </div>

                </div>


                

                <aside class="sidebar">

                    <div class="info-card">

                        <h3>
                            قبل إرسال الوظيفة
                        </h3>

                        <ul class="info-list">

                            <li>

                                <i class="fa-solid fa-circle-check"></i>

                                اكتب اسم وظيفة واضحًا.

                            </li>

                            <li>

                                <i class="fa-solid fa-circle-check"></i>

                                أدخل مكان العمل والراتب إن أمكن.

                            </li>

                            <li>

                                <i class="fa-solid fa-circle-check"></i>

                                تأكد من صحة رقم التواصل.

                            </li>

                            <li>

                                <i class="fa-solid fa-circle-check"></i>

                                سيتم مراجعة الوظيفة قبل ظهورها.

                            </li>

                            <li>

                                <i class="fa-solid fa-circle-check"></i>

                                بمجرد مراجعة الوظيفة سيتم نشرها.

                            </li>

                        </ul>

                    </div>

                </aside>

            </form>

        </div>

    </main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/jobs/create_jobs.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'جميع الأطباء | دليل الأطباء'); ?>

<?php $__env->startSection('content'); ?>

    <?php if (isset($component)) { $__componentOriginal4638470e2252daaacf3a7056bec03606 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4638470e2252daaacf3a7056bec03606 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.hero.secondhero','data' => ['title' => 'جميع الأطباء','address' => 'دليل الأطباء المعتمد','contet1' => 'ابحث عن الطبيب','contentContinuation' => 'المناسب لك','note' => 'تصفح الأطباء حسب التخصص والمحافظة، وشاهد البيانات المتاحة لكل طبيب بسهولة.','home' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.hero.secondhero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'جميع الأطباء','address' => 'دليل الأطباء المعتمد','contet1' => 'ابحث عن الطبيب','content_continuation' => 'المناسب لك','note' => 'تصفح الأطباء حسب التخصص والمحافظة، وشاهد البيانات المتاحة لكل طبيب بسهولة.','home' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4638470e2252daaacf3a7056bec03606)): ?>
<?php $attributes = $__attributesOriginal4638470e2252daaacf3a7056bec03606; ?>
<?php unset($__attributesOriginal4638470e2252daaacf3a7056bec03606); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4638470e2252daaacf3a7056bec03606)): ?>
<?php $component = $__componentOriginal4638470e2252daaacf3a7056bec03606; ?>
<?php unset($__componentOriginal4638470e2252daaacf3a7056bec03606); ?>
<?php endif; ?>

    <section class="doctors-search-area">

        <div class="doctors-search-panel">

            <div class="doctors-search-row">

                <div class="field">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="text" id="doctorSearch" placeholder="ابحث باسم الطبيب أو التخصص...">

                </div>

                <div class="field">

                    <i class="fa-solid fa-stethoscope"></i>

                    <select id="specialtyFilter">
                        <?php if($specialties?->isNotEmpty()): ?>
                            <option value="all">
                                كل التخصصات
                            </option>
                            <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($specialty?->id); ?>">
                                    <?php echo e($specialty?->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <option value="" disabled selected>
                                لا يوجد تخصصات الآن
                            </option>
                        <?php endif; ?>
                    </select>

                </div>

                <div class="field">

                    <i class="fa-solid fa-location-dot"></i>

                    <select id="cityFilter">
                        <?php if($areas?->isNotEmpty()): ?>
                            <option value="all">
                                كل المناطق
                            </option>
                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($area?->id); ?>">
                                    <?php echo e($area?->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <option value="" disabled selected>
                                لا توجد مناطق الآن
                            </option>
                        <?php endif; ?>
                    </select>

                </div>

                <button type="button" class="doctors-search-button" id="searchButton">

                    <i class="fa-solid fa-search"></i>

                    بحث

                </button>

            </div>

            <div class="doctors-search-info">

                <p>

                    تم العثور على

                    <strong id="resultCount">

                        <?php echo e($doctors?->total() ?? 0); ?>


                    </strong>

                    طبيب

                </p>

                <button type="button" class="clear-button" id="clearFilters">

                    <i class="fa-solid fa-rotate-right"></i>

                    مسح البحث والفلاتر

                </button>

            </div>

        </div>

    </section>

    <section class="doctors-section">

        <div class="container">

            

            <div class="section-heading">

                <div>

                    <span class="section-label">

                        <i class="fa-solid fa-users"></i>

                        قائمة الأطباء

                    </span>

                    <h2>

                        جميع الأطباء
                        <?php if(isset($name)): ?>
                            لتخصص <?php echo e($name); ?>

                        <?php endif; ?>

                    </h2>

                    <p>
                        اختر الطبيب واطلع على ملفه والبيانات المتاحة.
                    </p>

                </div>

                <div class="sort-box">

                    <i class="fa-solid fa-arrow-down-wide-short"></i>

                    <select id="sortDoctors">

                        <option value="default">
                            الترتيب الافتراضي
                        </option>

                        <option value="name">
                            الاسم من أ إلى ي
                        </option>

                        <option value="premium">
                            المشتركون أولاً
                        </option>

                    </select>

                </div>

            </div>

            <?php if($doctors?->isNotEmpty()): ?>

                <div class="doctors-grid" id="doctorsGrid">

                    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginalfcb79bfddd8883b2eb3ba145cda84b40 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfcb79bfddd8883b2eb3ba145cda84b40 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.doctors.card_doctor_clinic_system_component','data' => ['doctor' => $doctor]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.doctors.card_doctor_clinic_system_component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['doctor' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($doctor)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfcb79bfddd8883b2eb3ba145cda84b40)): ?>
<?php $attributes = $__attributesOriginalfcb79bfddd8883b2eb3ba145cda84b40; ?>
<?php unset($__attributesOriginalfcb79bfddd8883b2eb3ba145cda84b40); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfcb79bfddd8883b2eb3ba145cda84b40)): ?>
<?php $component = $__componentOriginalfcb79bfddd8883b2eb3ba145cda84b40; ?>
<?php unset($__componentOriginalfcb79bfddd8883b2eb3ba145cda84b40); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>

                <?php echo e($doctors->links('vendor.pagination.custom')); ?>


            <?php else: ?>

                <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء مطابقون','content' => 'جرب البحث باسم آخر أو غيّر التخصص والمحافظة.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء مطابقون','content' => 'جرب البحث باسم آخر أو غيّر التخصص والمحافظة.']); ?>
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

    </section>

    <?php if (isset($component)) { $__componentOriginal7467471fa22351805a182d948e9da6fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7467471fa22351805a182d948e9da6fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.firstbanner','data' => ['nav' => 'هل أنت طبيب؟','title' => 'أنشئ ملفك الطبي وعرّف المرضى بخدماتك','link' => 'انضم لدليل الأطباء','route' => route('doctor_join')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.firstbanner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['nav' => 'هل أنت طبيب؟','title' => 'أنشئ ملفك الطبي وعرّف المرضى بخدماتك','link' => 'انضم لدليل الأطباء','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('doctor_join'))]); ?>

        سجّل كطبيب، للظهور في الموقع والوصول إلى المرضى.

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7467471fa22351805a182d948e9da6fe)): ?>
<?php $attributes = $__attributesOriginal7467471fa22351805a182d948e9da6fe; ?>
<?php unset($__attributesOriginal7467471fa22351805a182d948e9da6fe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7467471fa22351805a182d948e9da6fe)): ?>
<?php $component = $__componentOriginal7467471fa22351805a182d948e9da6fe; ?>
<?php unset($__componentOriginal7467471fa22351805a182d948e9da6fe); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/doctors/doctors.blade.php ENDPATH**/ ?>
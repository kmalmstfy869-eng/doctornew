<?php $__env->startSection('title', 'دليل الأطباء | ابحث عن طبيبك'); ?>



<?php $__env->startSection('content'); ?>

    <main>
        <?php if (isset($component)) { $__componentOriginald36d3951f1394463954edb61ffc76839 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald36d3951f1394463954edb61ffc76839 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.hero.firsthero','data' => ['nav' => ' دليل طبي موثوق ومراجع','title' => 'اعثر على طبيبك','titleContinue' => ' بسهولة وثقة','note1' => ' ملفات طبية موثوقة','anser1' => 'بيانات يراجعها الموقع','note2' => ' تقييمات المستخدمين','anser2' => 'تجارب تساعدك على الاختيار','home' => true,'areas' => $areas]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.hero.firsthero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['nav' => ' دليل طبي موثوق ومراجع','title' => 'اعثر على طبيبك','title_continue' => ' بسهولة وثقة','note1' => ' ملفات طبية موثوقة','anser1' => 'بيانات يراجعها الموقع','note2' => ' تقييمات المستخدمين','anser2' => 'تجارب تساعدك على الاختيار','home' => true,'areas' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($areas)]); ?>

            ابحث باسم الطبيب أو التخصص أو المحافظة،
            واطّلع على بيانات العيادة والخدمات المتاحة
            قبل التواصل.
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald36d3951f1394463954edb61ffc76839)): ?>
<?php $attributes = $__attributesOriginald36d3951f1394463954edb61ffc76839; ?>
<?php unset($__attributesOriginald36d3951f1394463954edb61ffc76839); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald36d3951f1394463954edb61ffc76839)): ?>
<?php $component = $__componentOriginald36d3951f1394463954edb61ffc76839; ?>
<?php unset($__componentOriginald36d3951f1394463954edb61ffc76839); ?>
<?php endif; ?>

        <section class="home-section">

            <div class="site-container">

                <div class="home-section-head">

                    <div>

                        <span class="home-section-label">

                            <i class="fa-solid fa-stethoscope"></i>

                            التخصصات الطبية

                        </span>

                        <h2>

                            اختر التخصص المناسب

                        </h2>

                        <p>

                            تصفح التخصصات وابحث عن الطبيب المناسب لك.

                        </p>

                    </div>

                    <a href="<?php echo e(route('specialties.index')); ?>" class="home-all-link">

                        عرض جميع التخصصات

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>

                </div>

                <div class="specialties-grid">






                    <?php if($specialties->isNotEmpty()): ?>

                        <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal2e84b417be6e8946efc2d044a58156a4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2e84b417be6e8946efc2d044a58156a4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.specialties.card_specialties','data' => ['link' => route('specialties.show', $specialty->slug),'number' => str_pad($loop->iteration, 2, '0', STR_PAD_LEFT),'name' => $specialty->name,'title' => $specialty->title,'logo' => $specialty->logo]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.specialties.card_specialties'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('specialties.show', $specialty->slug)),'number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(str_pad($loop->iteration, 2, '0', STR_PAD_LEFT)),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialty->name),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialty->title),'logo' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialty->logo)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2e84b417be6e8946efc2d044a58156a4)): ?>
<?php $attributes = $__attributesOriginal2e84b417be6e8946efc2d044a58156a4; ?>
<?php unset($__attributesOriginal2e84b417be6e8946efc2d044a58156a4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2e84b417be6e8946efc2d044a58156a4)): ?>
<?php $component = $__componentOriginal2e84b417be6e8946efc2d044a58156a4; ?>
<?php unset($__componentOriginal2e84b417be6e8946efc2d044a58156a4); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-stethoscope','title' => 'لا توجد تخصصات الان','content' => 'لم يتم اضافه تخصصات او يوجد مشكله بالموقع  ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-stethoscope','title' => 'لا توجد تخصصات الان','content' => 'لم يتم اضافه تخصصات او يوجد مشكله بالموقع  ']); ?>
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
        </section>

        <section class="home-doctors-section">

            <div class="site-container">

                <div class="home-section-head">

                    <div>

                        <span class="home-section-label">

                            <i class="fa-solid fa-star"></i>

                            أطباء مميزون

                        </span>

                        <h2>

                            أطباء موثوقون

                        </h2>

                        <p>

                            اطّلع على الملفات الطبية وبيانات العيادات.

                        </p>

                    </div>

                    <a href="<?php echo e(route('doctors.index')); ?>" class="home-all-link">

                        عرض جميع الأطباء

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>

                </div>

                <?php if($doctors->isNotEmpty()): ?>
                    <?php if (isset($component)) { $__componentOriginal180de1d4172bcfb057394935755eb005 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal180de1d4172bcfb057394935755eb005 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.doctors.doctors_grid','data' => ['doctors' => $doctors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.doctors.doctors_grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['doctors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($doctors)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal180de1d4172bcfb057394935755eb005)): ?>
<?php $attributes = $__attributesOriginal180de1d4172bcfb057394935755eb005; ?>
<?php unset($__attributesOriginal180de1d4172bcfb057394935755eb005); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal180de1d4172bcfb057394935755eb005)): ?>
<?php $component = $__componentOriginal180de1d4172bcfb057394935755eb005; ?>
<?php unset($__componentOriginal180de1d4172bcfb057394935755eb005); ?>
<?php endif; ?>
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء حاليًا','content' => 'لم يتم إضافة أطباء حتى الآن.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-user-doctor','title' => 'لا يوجد أطباء حاليًا','content' => 'لم يتم إضافة أطباء حتى الآن.']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.firstbanner','data' => ['nav' => ' فرص عمل جديدة','title' => 'ابحث عن فرصتك القادمة','link' => 'عرض الوظائف ','route' => route('jobs.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.firstbanner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['nav' => ' فرص عمل جديدة','title' => 'ابحث عن فرصتك القادمة','link' => 'عرض الوظائف ','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('jobs.index'))]); ?>

            تصفح الوظائف المتاحة في المجالات الطبية.

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


        <section class="home-join-section">

            <div class="site-container">

                <div class="home-join-card">

                    <div>

                        <span class="home-section-label">

                            <i class="fa-solid fa-user-doctor"></i>

                            هل أنت طبيب؟

                        </span>

                        <h2>

                            اجعل الوصول إليك أسهل

                        </h2>

                        <p>

                            أنشئ حسابك، واختر الباقة المناسبة،
                            وأضف بيانات ملفك الطبي.
                            بعد مراجعة البيانات يظهر ملفك للزوار.

                        </p>

                        <div class="home-join-features">

                            <span>

                                <i class="fa-solid fa-check"></i>

                                ملف طبي احترافي

                            </span>

                            <span>

                                <i class="fa-solid fa-check"></i>

                                إحصائيات المشاهدات

                            </span>

                            <span>

                                <i class="fa-solid fa-check"></i>

                                إدارة سهلة للبيانات

                            </span>

                        </div>

                        <a href="<?php echo e(route('doctor_join')); ?>" class="home-join-button">

                            أنشئ حساب طبيب

                            <i class="fa-solid fa-arrow-left"></i>

                        </a>

                    </div>

                    <div class="home-join-visual">

                        <i class="fa-solid fa-user-doctor"></i>

                    </div>

                </div>

            </div>

        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/index.blade.php ENDPATH**/ ?>
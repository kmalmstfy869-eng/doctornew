<?php $__env->startSection('title', 'كل التخصصات الطبية | دليل الأطباء'); ?>


<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal4638470e2252daaacf3a7056bec03606 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4638470e2252daaacf3a7056bec03606 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.hero.secondhero','data' => ['title' => 'التخصصات الطبية','address' => 'ابحث حسب التخصص','contet1' => 'كل التخصصات','contentContinuation' => 'الطبية','note' => 'اختر التخصص المناسب وتصفح الأطباء بسهولة.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.hero.secondhero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'التخصصات الطبية','address' => 'ابحث حسب التخصص','contet1' => 'كل التخصصات','content_continuation' => 'الطبية','note' => 'اختر التخصص المناسب وتصفح الأطباء بسهولة.']); ?>
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


    <div class="specialties-search-wrapper">

        <form class="specialties-search-box" id="specialties-searchForm">

            <div class="specialties-search-input">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="text" id="specialties-searchInput" placeholder="ابحث عن تخصص...">

            </div>


            <button type="submit" class="specialties-search-button">

                <i class="fa-solid fa-search"></i>

                بحث

            </button>

        </form>

    </div>






    <section class="specialties-section">

        <div class="container">


            <div class="section-top">

                <div>

                    <span class="section-badge">

                        <i class="fa-solid fa-layer-group"></i>

                        دليل التخصصات

                    </span>


                    <h2>

                        استكشف التخصصات

                    </h2>


                    <p>

                        اختر التخصص ثم شاهد الأطباء.

                    </p>

                </div>


                <div class="result-box">

                    تم العثور على

                    <strong id="resultNumber">

                        12

                    </strong>

                    تخصص

                </div>

            </div>


            <!-- الفلاتر -->

            <div class="filters">

                <button class="filter-button active" data-filter="all">

                    الكل

                </button>


                <button class="filter-button" data-filter="general">

                    تخصصات عامة

                </button>


                <button class="filter-button" data-filter="surgery">

                    تخصصات جراحية

                </button>


                <button class="filter-button" data-filter="children">

                    الأطفال

                </button>


                <button class="filter-button" data-filter="women">

                    النساء

                </button>


                <button class="filter-button" data-filter="mental">

                    الصحة النفسية

                </button>

            </div>

            <?php if($Specialties->isNotEmpty()): ?>
                <div class="specialties-grid" id="specialtiesGrid">

                    <?php $__currentLoopData = $Specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal2e84b417be6e8946efc2d044a58156a4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2e84b417be6e8946efc2d044a58156a4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.specialties.card_specialties','data' => ['link' => route('specialties.show', $specialty->slug),'number' => str_pad(
                            ($Specialties->currentPage() - 1) * $Specialties->perPage() + $loop->iteration,
                            2,
                            '0',
                            STR_PAD_LEFT,
                        ),'name' => $specialty->name,'title' => $specialty->title,'logo' => $specialty->logo]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.specialties.card_specialties'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('specialties.show', $specialty->slug)),'number' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(str_pad(
                            ($Specialties->currentPage() - 1) * $Specialties->perPage() + $loop->iteration,
                            2,
                            '0',
                            STR_PAD_LEFT,
                        )),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialty->name),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialty->title),'logo' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialty->logo)]); ?>
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

                </div>

                <?php echo e($Specialties->links('vendor.pagination.custom')); ?>

            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-stethoscope','title' => 'لا توجد تخصصات مطابقة','content' => 'جرب البحث باسم تخصص آخر أو غيّر معايير البحث. ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-stethoscope','title' => 'لا توجد تخصصات مطابقة','content' => 'جرب البحث باسم تخصص آخر أو غيّر معايير البحث. ']); ?>
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


        <?php if (isset($component)) { $__componentOriginal7467471fa22351805a182d948e9da6fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7467471fa22351805a182d948e9da6fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.firstbanner','data' => ['nav' => 'هل أنت طبيب؟','title' => 'أضف تخصصك وعرّف المرضى بخدماتك','link' => 'انضم كطبيب','route' => route('doctor_join')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.firstbanner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['nav' => 'هل أنت طبيب؟','title' => 'أضف تخصصك وعرّف المرضى بخدماتك','link' => 'انضم كطبيب','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('doctor_join'))]); ?>

            أنشئ حسابك وابدأ في بناء ملفك الطبي.

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
    </div>

</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/specialty/specialty.blade.php ENDPATH**/ ?>
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

                <input type="text" id="specialties-searchInput" value="<?php echo e(request('q')); ?>"
                    placeholder="ابحث عن تخصص...">

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

                    <strong id="resultNumber"><?php echo e($Specialties->total()); ?></strong>

                    تخصص

                </div>

            </div>


            <div id="specialtiesResults" data-url="<?php echo e(route('specialties.index')); ?>">
                <?php echo $__env->make('home.specialty._grid', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>


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

    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/search_specialties.js')); ?>"></script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/specialty/specialty.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'الوظائف المتاحه | دليل الأطباء'); ?>

<?php $__env->startSection('content'); ?>

    <?php if (isset($component)) { $__componentOriginal4638470e2252daaacf3a7056bec03606 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4638470e2252daaacf3a7056bec03606 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.hero.secondhero','data' => ['title' => 'الوظائف','address' => 'أحدث فرص العمل','contet1' => 'فرصتك للعمل','contentContinuation' => 'في المجال الطبي','note' => 'اكتشف أحدث الوظائف والفرص المتاحة في المستشفيات والعيادات والمراكز الطبية، وابحث عن الوظيفة المناسبة لخبراتك ومهاراتك.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.hero.secondhero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'الوظائف','address' => 'أحدث فرص العمل','contet1' => 'فرصتك للعمل','content_continuation' => 'في المجال الطبي','note' => 'اكتشف أحدث الوظائف والفرص المتاحة في المستشفيات والعيادات والمراكز الطبية، وابحث عن الوظيفة المناسبة لخبراتك ومهاراتك.']); ?>
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

        <form class="specialties-search-box" id="jobs-searchForm">

            <div class="specialties-search-input">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="text" id="jobs-searchInput" value="<?php echo e(request('q')); ?>"
                    placeholder="ابحث عن وظيفة...">

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

                        دليل الوظائف

                    </span>

                    <h2>
                        استكشف الوظائف
                    </h2>

                </div>

                <div class="result-box">

                    تم العثور على

                    <strong id="resultNumber"><?php echo e($totaljobs ?? 0); ?></strong>

                    وظيفة

                </div>

            </div>


            <main id="jobs">

                <div id="jobsResults" data-url="<?php echo e(route('jobs.index')); ?>">
                    <?php echo $__env->make('home.jobs._grid', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

            </main>

        </div>

    </section>


    <section class="post-job-section">

        <div class="container">

            <div class="post-job-card">

                <div class="post-job-content">

                    <div class="post-job-icon">

                        <i class="fa-solid fa-bullhorn"></i>

                    </div>


                    <div class="post-job-text">

                        <h2>
                            هل لديك وظيفة شاغرة؟
                        </h2>

                        <p>
                            انشر وظيفتك الآن ووصل إلى الباحثين عن عمل
                            في المجال الطبي بسهولة.
                        </p>

                    </div>

                </div>


                <a href="<?php echo e(route('jobs.create')); ?>" class="post-job-button">

                    <i class="fa-solid fa-plus"></i>

                    أضف وظيفة

                </a>

            </div>

        </div>

    </section>

    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/search_jobs.js')); ?>"></script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/jobs/jobs.blade.php ENDPATH**/ ?>
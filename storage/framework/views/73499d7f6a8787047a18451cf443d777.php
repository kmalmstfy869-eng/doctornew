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

        <form class="specialties-search-box" id="specialties-searchForm">

            <div class="specialties-search-input">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="text" id="specialties-searchInput" placeholder="ابحث عن وظيفة...">

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

                    <strong id="resultNumber">
                        <?php echo e($totaljobs??0); ?>

                    </strong>

                    وظيفة

                </div>

            </div>


            <main id="jobs">

                <?php if($jobs?->isNotEmpty()): ?>

                    <div class="jobs-list" id="jobsList">

                        <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="job-card">

                                <div class="job-card-top">

                                    <div class="job-icon">

                                        <i class="fa-solid fa-briefcase"></i>

                                    </div>

                                </div>


                                <span class="job-category">

                                    <?php echo e($job->category); ?>


                                </span>


                                <h3 class="job-title">

                                    <?php echo e($job->title); ?>


                                </h3>


                                <p class="company-name">

                                    <?php echo e($job->company_name); ?>


                                </p>


                                <div class="job-info">

                                    <div class="job-info-item">

                                        <i class="fa-solid fa-location-dot"></i>

                                        <?php echo e($job->location ?? 'لم يتم التحديد'); ?>


                                    </div>


                                    <div class="job-info-item">

                                        <i class="fa-solid fa-clock"></i>

                                        <?php echo e($job->job_type); ?>


                                    </div>

                                </div>


                                <div class="job-salary">

                                    <span class="salary-label">
                                        الراتب المتوقع
                                    </span>

                                    <span class="salary-value">

                                        <?php if($job->salary_min && $job->salary_max): ?>
                                            <?php echo e($job->salary_min); ?> - <?php echo e($job->salary_max); ?> جنيه
                                        <?php elseif($job->salary_min): ?>
                                            من <?php echo e($job->salary_min); ?> جنيه
                                        <?php elseif($job->salary_max): ?>
                                            حتى <?php echo e($job->salary_max); ?> جنيه
                                        <?php else: ?>
                                            غير محدد
                                        <?php endif; ?>

                                    </span>

                                </div>


                                <div class="job-footer">

                                    <a href="<?php echo e(route('jobs.show', $job->id)); ?>" class="details-btn">

                                        عرض التفاصيل

                                    </a>




                                </div>

                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>


                    <div class="pagination" id="pagination">

                        <?php echo e($jobs->links('vendor.pagination.custom')); ?>


                    </div>
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-briefcase','title' => 'لا توجد وظائف الآن','content' => 'جرّب تغيير كلمة البحث أو الفلاتر أو ابحث في وقت لاحق']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-briefcase','title' => 'لا توجد وظائف الآن','content' => 'جرّب تغيير كلمة البحث أو الفلاتر أو ابحث في وقت لاحق']); ?>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/jobs/jobs.blade.php ENDPATH**/ ?>
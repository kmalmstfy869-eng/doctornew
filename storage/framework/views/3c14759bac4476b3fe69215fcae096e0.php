<?php $__env->startSection('title', 'تفاصيل الوظيفة | دليل الأطباء'); ?>

<?php $__env->startSection('content'); ?>

    <section class="page-header">

        <div class="container">

            <div class="breadcrumb">

                <a href="<?php echo e(route('home')); ?>">
                    الرئيسية
                </a>

                <i class="fa-solid fa-chevron-left"></i>

                <a href="<?php echo e(route('jobs.index')); ?>">
                    الوظائف
                </a>

                <i class="fa-solid fa-chevron-left"></i>

                <span>
                    تفاصيل الوظيفة
                </span>

            </div>

        </div>

    </section>


    <main class="job-details-section">

        <div class="container">

            <div class="details-grid">


                <div class="main-card">


                    <div class="job-details-hero">

                        <div class="job-details-hero-top">

                            <div class="job-details-title-area">

                                <div class="job-details-icon">

                                    <i class="fa-solid fa-briefcase"></i>

                                </div>


                                <div>

                                    <span class="job-details-category">

                                        <?php echo e($job->category); ?>


                                    </span>


                                    <h1 class="job-details-title">

                                        <?php echo e($job->title); ?>


                                    </h1>


                                    <p class="company-name">

                                        <?php echo e($job->company_name); ?>


                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="job-details-hero-actions">

                            <button type="button" class="med-share-button" id="medShareButton" aria-label="مشاركة الصفحة"
                                title="مشاركة الصفحة">

                                <i class="fa-solid fa-share-nodes"></i>

                            </button>

                        </div>

                    </div>


                    <div class="job-details-data">


                        <div class="data-item">

                            <div class="data-icon">

                                <i class="fa-solid fa-location-dot"></i>

                            </div>


                            <div class="data-text">

                                <span>
                                    مكان العمل
                                </span>

                                <strong>
                                    <?php echo e($job->location ?? 'لم يتم التحديد'); ?>

                                </strong>

                            </div>

                        </div>


                        <div class="data-item">

                            <div class="data-icon">

                                <i class="fa-solid fa-clock"></i>

                            </div>


                            <div class="data-text">

                                <span>
                                    نوع الدوام
                                </span>

                                <strong>
                                    <?php echo e($job->job_type); ?>

                                </strong>

                            </div>

                        </div>


                        <div class="data-item">

                            <div class="data-icon">

                                <i class="fa-solid fa-money-bill-wave"></i>

                            </div>


                            <div class="data-text">

                                <span>
                                    الراتب
                                </span>

                                <strong>

                                    <?php if($job->salary_min && $job->salary_max): ?>
                                        <?php echo e($job->salary_min); ?> - <?php echo e($job->salary_max); ?> جنيه
                                    <?php elseif($job->salary_min): ?>
                                        من <?php echo e($job->salary_min); ?> جنيه
                                    <?php elseif($job->salary_max): ?>
                                        حتى <?php echo e($job->salary_max); ?> جنيه
                                    <?php else: ?>
                                        غير محدد
                                    <?php endif; ?>

                                </strong>

                            </div>

                        </div>


                        <div class="data-item">

                            <div class="data-icon">

                                <i class="fa-solid fa-calendar-days"></i>

                            </div>


                            <div class="data-text">

                                <span>
                                    تاريخ النشر
                                </span>

                                <strong>

                                    <?php echo e($job->created_at->translatedFormat('d F Y')); ?>


                                </strong>

                            </div>

                        </div>


                        <div class="data-item">

                            <div class="data-icon">

                                <i class="fa-solid fa-briefcase"></i>

                            </div>


                            <div class="data-text">

                                <span>
                                    الخبرة
                                </span>

                                <strong>
                                    <?php echo e($job->experience); ?>

                                </strong>

                            </div>

                        </div>


                        <div class="data-item">

                            <div class="data-icon">

                                <i class="fa-solid fa-graduation-cap"></i>

                            </div>


                            <div class="data-text">

                                <span>
                                    المؤهل
                                </span>

                                <strong>
                                    <?php echo e($job->qualification); ?>

                                </strong>

                            </div>

                        </div>


                    </div>


                    <div class="details-content">


                        <section class="content-section">

                            <h2 class="section-title">

                                <i class="fa-solid fa-file-lines"></i>

                                وصف الوظيفة

                            </h2>


                            <p class="section-text">

                                <?php echo e($job->description); ?>


                            </p>

                        </section>


                        <section class="content-section">

                            <h2 class="section-title">

                                <i class="fa-solid fa-circle-info"></i>

                                معلومات إضافية

                            </h2>


                            <div class="extra-info">


                                <div class="extra-item">

                                    <span>
                                        عدد الوظائف المطلوبة
                                    </span>

                                    <strong>

                                        <?php echo e($job->vacancies); ?>


                                        وظيفة

                                    </strong>

                                </div>


                                <div class="extra-item">

                                    <span>
                                        ساعات العمل
                                    </span>

                                    <strong>

                                        <?php echo e($job->working_hours ?? 'غير محدد'); ?>


                                    </strong>

                                </div>


                                <div class="extra-item">

                                    <span>
                                        أيام العمل
                                    </span>

                                    <strong>

                                        <?php echo e($job->working_days ?? 'غير محدد'); ?>


                                    </strong>

                                </div>


                                <div class="extra-item">

                                    <span>
                                        آخر موعد للتقديم
                                    </span>

                                    <strong>

                                        <?php if($job->application_deadline): ?>
                                            <?php echo e(\Carbon\Carbon::parse($job->application_deadline)->translatedFormat('d F Y')); ?>

                                        <?php else: ?>
                                            غير محدد
                                        <?php endif; ?>

                                    </strong>

                                </div>


                            </div>

                        </section>


                    </div>

                </div>


                <aside class="sidebar">


                    <div class="apply-card">

                        <h3>
                            مهتم بالوظيفة؟
                        </h3>


                        <p>

                            تواصل مع صاحب الوظيفة مباشرة لمعرفة تفاصيل التقديم.

                        </p>


                        <a href="https://wa.me/<?php echo e($job->whatsapp); ?>" target="_blank" class="apply-btn">

                            <i class="fa-brands fa-whatsapp"></i>

                            تواصل للتقديم

                        </a>


                        <a href="tel:<?php echo e($job->phone); ?>" class="contact-btn">

                            <i class="fa-solid fa-phone"></i>

                            اتصل بصاحب الوظيفة

                        </a>

                    </div>


                    <div class="publisher-card">

                        <h3 class="publisher-title">

                            تم نشر الوظيفة بواسطة

                        </h3>


                        <div class="publisher-info">

                            <div class="company-logo">

                                <i class="fa-solid fa-building"></i>

                            </div>


                            <div>

                                <h4>

                                    <?php echo e($job->company_name); ?>


                                </h4>


                                <p>

                                    عضو منذ

                                    <?php echo e($job->user?->created_at?->format('Y') ?? 'غير محدد'); ?>


                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="security-note">

                        <div>

                            <i class="fa-solid fa-shield-halved"></i>

                            <strong>
                                تنبيه مهم
                            </strong>

                        </div>


                        <p>

                            لا تدفع أي أموال مقابل التقديم على الوظيفة،
                            وتأكد من بيانات صاحب العمل قبل إرسال أي معلومات شخصية.

                        </p>

                    </div>


                </aside>


            </div>

        </div>

    </main>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/jobs/jobs_details.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'تقييماتي | لوحة تحكم الطبيب'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/ratings.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/readability/ratings.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/reviews-page.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


    <div class="doctor-reviews-page">

        

        <div class="doctor-reviews-header">

            <div class="doctor-reviews-title">

                <div class="reviews-title-icon">
                    <i class="fa-solid fa-star"></i>
                </div>

                <div class="reviews-title-content">

                    <span class="reviews-title-small">
                        إدارة التقييمات
                    </span>

                    <h1>
                        تقييمات المرضى
                    </h1>

                    <p>
                        عرض جميع تقييمات المرضى
                    </p>

                </div>

            </div>


            

            <div class="reviews-header-stats">

                <div class="reviews-stat-item">

                    <div class="reviews-stat-icon rating">
                        <i class="fa-solid fa-star"></i>
                    </div>

                    <div class="reviews-stat-info">

                        <span>
                            متوسط التقييم
                        </span>

                        <?php
                            $averageRating = $doctor->rating()->avg('rating');
                        ?>

                        <strong>
                            <?php echo e($averageRating ? number_format($averageRating, 1) . ' / 5' : 'لا توجد تقييمات'); ?>

                        </strong>

                    </div>

                </div>


                <div class="reviews-count-badge">

                    <i class="fa-solid fa-comments"></i>

                    <span>
                        <?php echo e($reviews->total()); ?> تقييم
                    </span>

                </div>

            </div>

        </div>


        

        <div class="reviews-card">


            <div class="reviews-card-header">

                <div>

                    <h2>
                        <i class="fa-solid fa-star"></i>
                        آخر التقييمات

                    </h2>

                    <p>
                    <?php if(request('search')): ?>
                    نتائج البحث عن: <strong>"<?php echo e(request('search')); ?>"</strong> <span class="results-count">
                    — <?php echo e($reviews->total()); ?> نتيجة </span>
                    <?php else: ?>
                    التقييمات التي قام المرضى بإضافتها لك <span class="results-count">
                    — <?php echo e($reviews->total()); ?> تقييم </span>
                    <?php endif; ?>

                    </p>

                </div>



                

                <form action="<?php echo e(route('doctor.reviews')); ?>" method="GET" class="reviews-search-form">

                    <div class="reviews-search-box">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                            placeholder="ابحث باسم المريض...">

                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('doctor.reviews')); ?>" class="reviews-search-clear" title="إلغاء البحث">

                                <i class="fa-solid fa-xmark"></i>

                            </a>
                        <?php endif; ?>

                    </div>


                    <button type="submit" class="reviews-search-button">

                        <i class="fa-solid fa-search"></i>

                        بحث

                    </button>

                </form>

            </div>


            

            <?php if($reviews->isEmpty()): ?>

                <div class="reviews-empty">

                    <div class="reviews-empty-icon">
                        <i class="fa-regular fa-star"></i>
                    </div>

                    <h3>

                        <?php if(request('search')): ?>
                            لا توجد نتائج للبحث
                        <?php else: ?>
                            لا توجد تقييمات
                        <?php endif; ?>

                    </h3>

                    <p>

                        <?php if(request('search')): ?>
                            لم يتم العثور على تقييمات للمريض المطلوب.
                        <?php else: ?>
                            لم يتم إضافة أي تقييمات لك حتى الآن.
                        <?php endif; ?>

                    </p>

                </div>
            <?php else: ?>
                

                <div class="reviews-list">

                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="review-item doctor-review-item">

                            

                            <div class="review-user doctor-review-user">

                                <div class="review-user-avatar">

                                    <i class="fa-solid fa-user"></i>

                                </div>

                                <div class="review-user-info">

                                    <span class="review-label">
                                        صاحب التقييم
                                    </span>

                                    <strong>
                                        <?php echo e($review->user?->name ?? 'مستخدم غير معروف'); ?>

                                    </strong>

                                </div>

                            </div>


                            

                            <div class="review-rating doctor-review-rating">

                                <span class="review-label">
                                    التقييم
                                </span>

                                <div class="stars">

                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php if($i <= $review->rating): ?>
                                            <i class="fa-solid fa-star active"></i>
                                        <?php else: ?>
                                            <i class="fa-regular fa-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                </div>

                                <strong>
                                    <?php echo e($review->rating); ?>/5
                                </strong>

                            </div>


                            

                            <div class="review-comment doctor-review-comment">

                                <span class="review-label">
                                    التعليق
                                </span>

                                <div class="comment-box">

                                    <i class="fa-solid fa-quote-right"></i>

                                    <p>
                                        <?php echo e($review->comment ?? 'لم يكتب المستخدم تعليقًا.'); ?>

                                    </p>

                                </div>

                            </div>


                            

                            <div class="review-date doctor-review-date">

                                <i class="fa-regular fa-calendar"></i>

                                <div>

                                    <span class="review-label">
                                        تاريخ التقييم
                                    </span>

                                    <strong>
                                        <?php echo e($review->created_at?->format('Y/m/d')); ?>

                                    </strong>

                                </div>

                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>


                

                <div class="reviews-pagination">

                    <?php echo e($reviews->withQueryString()->links('vendor.pagination.custom')); ?>


                </div>

            <?php endif; ?>

        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/dashboard/ratings/index.blade.php ENDPATH**/ ?>
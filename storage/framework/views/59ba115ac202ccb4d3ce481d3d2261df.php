<?php $__env->startSection('title', 'لوحة التحكم | التقييمات'); ?>

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
                    تقييمات الأطباء
                </h1>

                <p>
                    عرض ومراجعة جميع تقييمات المستخدمين للأطباء
                </p>

            </div>

        </div>


        

        <div class="reviews-header-stats">

            <div class="reviews-stat-item">

                <div class="reviews-stat-icon doctors">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>

                <div class="reviews-stat-info">

                    <span>
                        الأطباء المقيّمين
                    </span>

                    <strong>
                        <?php echo e(\App\Models\Rating::distinct('doctor_id')->count('doctor_id')); ?>

                    </strong>

                </div>

            </div>


            <div class="reviews-stat-item">

                <div class="reviews-stat-icon rating">
                    <i class="fa-solid fa-star"></i>
                </div>

                <div class="reviews-stat-info">

                    <span>
                        متوسط التقييم
                    </span>

                    <strong>
                        <?php echo e(number_format($reviews->avg('rating'), 1)); ?>/5
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
                    التقييمات التي قام المستخدمون بإضافتها للأطباء
                </p>

            </div>


            

            <form action="<?php echo e(route('admin.ratings.index')); ?>" method="get" class="reviews-search-form">

                <div class="reviews-search-box">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="text"
                        name="search"
                        value="<?php echo e(request('search')); ?>"
                        placeholder="ابحث باسم الطبيب...">

                    <?php if(request('search')): ?>

                        <a href="<?php echo e(route('admin.ratings.index')); ?>"
                            class="reviews-search-clear"
                            title="إلغاء البحث">

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
                        لم يتم العثور على تقييمات للطبيب المطلوب.
                    <?php else: ?>
                        لم يتم إضافة أي تقييمات للأطباء حتى الآن.
                    <?php endif; ?>

                </p>

            </div>

        <?php else: ?>

            

            <div class="reviews-list">

                <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="review-item">

                        

                        <div class="review-user">

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

                                <?php if($review->user?->email): ?>

                                    <small>
                                        <?php echo e($review->user->email); ?>

                                    </small>

                                <?php endif; ?>

                            </div>

                        </div>


                        

                        <div class="review-doctor">

                            <div class="review-doctor-avatar">

                                <i class="fa-solid fa-user-doctor"></i>

                            </div>

                            <div class="review-doctor-info">

                                <span class="review-label">
                                    الطبيب
                                </span>

                                <strong>
                                    <?php echo e($review->doctor?->user?->name ?? 'طبيب غير معروف'); ?>

                                </strong>

                                <?php if($review->doctor?->specialty): ?>

                                    <small>
                                        <?php echo e($review->doctor->specialty->name); ?>

                                    </small>

                                <?php endif; ?>

                            </div>

                        </div>


                        

                        <div class="review-rating">

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


                        

                        <div class="review-comment">

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


                        

                        <div class="review-date">

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


                        

                        <div class="review-status">

                            <?php if($review->status === 'approved'): ?>

                                <span class="review-status-badge approved">

                                    <i class="fa-solid fa-circle-check"></i>

                                    مقبول

                                </span>

                            <?php else: ?>

                                <span class="review-status-badge rejected">

                                    <i class="fa-solid fa-circle-xmark"></i>

                                    مرفوض

                                </span>

                            <?php endif; ?>

                        </div>


                        

                        <div class="review-actions">

                            <span class="review-label">
                                الإجراءات
                            </span>

                            <div class="review-actions-buttons">

                                <a href="<?php echo e(route('admin.ratings.edit', $review->id)); ?>"
                                    class="review-action-btn edit"
                                    title="تعديل">

                                    <i class="fa-solid fa-pen"></i>

                                </a>


                                <form action="<?php echo e(route('admin.ratings.destroy', $review->id)); ?>"
                                    method="POST"
                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟');">

                                    <?php echo csrf_field(); ?>

                                    <?php echo method_field('DELETE'); ?>

                                    <button type="submit"
                                        class="review-action-btn delete"
                                        title="حذف">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>

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

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/ratings/index.blade.php ENDPATH**/ ?>
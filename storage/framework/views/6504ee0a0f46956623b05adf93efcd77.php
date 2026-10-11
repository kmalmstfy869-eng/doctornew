<?php $__env->startSection('title', 'لوحة التحكم | رسائل المستخدمين'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin/message.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="doctor-reviews-page">

        <div class="doctor-reviews-header">
            <div class="doctor-reviews-title">
                <div class="reviews-title-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="reviews-title-content">
                    <span class="reviews-title-small">تواصل معنا</span>
                    <h1>رسائل المستخدمين</h1>
                    <p>عرض الرسائل التي أرسلها المستخدمون من صفحة تواصل معنا</p>
                </div>
            </div>

            <div class="reviews-header-stats">
                <div class="reviews-count-badge">
                    <i class="fa-solid fa-comments"></i>
                    <span><?php echo e(method_exists($messages, 'total') ? $messages->total() : $messages->count()); ?> رسالة</span>
                </div>
            </div>
        </div>

        <div class="reviews-card">

            <div class="reviews-card-header">
                <div>
                    <h2><i class="fa-solid fa-envelope-open-text"></i> آخر الرسائل</h2>
                    <p>الرسائل الواردة من المستخدمين</p>
                </div>
            </div>

            <?php if($messages->isEmpty()): ?>

                <div class="reviews-empty">
                    <div class="reviews-empty-icon">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <h3>لا توجد رسائل</h3>
                    <p>لم يتم استلام أي رسائل من المستخدمين حتى الآن.</p>
                </div>
            <?php else: ?>
                <div class="reviews-list">

                    <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="review-item cm-item">

                            
                            <div class="review-user">
                                <div class="review-user-avatar">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div class="review-user-info">
                                    <span class="review-label">المرسل</span>
                                    <strong><?php echo e(filled($message->name) ? $message->name : 'لم يدخل اسم'); ?></strong>
                                    <?php if(filled($message->phone)): ?>
                                        <small dir="ltr"><?php echo e($message->phone); ?></small>
                                    <?php else: ?>
                                        <small>لم يدخل رقم هاتف</small>
                                    <?php endif; ?>
                                </div>
                            </div>

                            
                            <div class="review-comment">
                                <span class="review-label">الرسالة</span>
                                <div class="comment-box">
                                    <i class="fa-solid fa-quote-right"></i>
                                    <p><?php echo e($message->message); ?></p>
                                </div>
                            </div>

                            
                            <div class="review-date">
                                <i class="fa-regular fa-calendar"></i>
                                <div>
                                    <span class="review-label">التاريخ</span>
                                    <strong><?php echo e($message->created_at?->format('Y/m/d')); ?></strong>
                                </div>
                            </div>

                            
                            <div class="review-actions">
                                <span class="review-label">الإجراءات</span>
                                <div class="review-actions-buttons">
                                    <form action="<?php echo e(route('admin.contact.destroy', $message->id)); ?>" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="review-action-btn delete" title="حذف">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>

                <?php if(method_exists($messages, 'links')): ?>
                    <div class="reviews-pagination">
                        <?php echo e($messages->links('vendor.pagination.custom')); ?>

                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/contact/index.blade.php ENDPATH**/ ?>
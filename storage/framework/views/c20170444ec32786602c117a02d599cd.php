<?php $__env->startSection('title', 'لوحة التحكم | تعديل التقييم'); ?>

<?php $__env->startSection('content'); ?>

    <div class="doctor-review-edit-page">

        

        <div class="doctor-review-edit-header">

            <div class="doctor-review-edit-title">

                <div class="edit-title-icon">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>

                <div class="edit-title-content">

                    <span>
                        إدارة التقييمات
                    </span>

                    <h1>
                        تعديل التقييم
                    </h1>

                    <p>
                        تعديل بيانات وتقييم المستخدم للطبيب
                    </p>

                </div>

            </div>

            <a href="<?php echo e(route('admin.ratings.index')); ?>" class="edit-back-button">

                <i class="fa-solid fa-arrow-right"></i>

                العودة للتقييمات

            </a>

        </div>


        

        <div class="doctor-review-edit-card">

            <form
                action="<?php echo e(route('admin.ratings.update', $review->id)); ?>"
                method="POST"
            >

                <?php echo csrf_field(); ?>

                <?php echo method_field('PUT'); ?>


                

                <div class="edit-info-grid">

                    

                    <div class="edit-info-box">

                        <div class="edit-info-icon user">
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <div class="edit-info-content">

                            <span>
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


                    

                    <div class="edit-info-box">

                        <div class="edit-info-icon doctor">
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>

                        <div class="edit-info-content">

                            <span>
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

                </div>


                

                <div class="edit-form-section">

                    <div class="edit-section-title">

                        <div class="edit-section-icon rating">
                            <i class="fa-solid fa-star"></i>
                        </div>

                        <div>

                            <h2>
                                التقييم
                            </h2>

                            <p>
                                اختر عدد النجوم المناسب للتقييم
                            </p>

                        </div>

                    </div>


                    <div class="edit-rating-wrapper">

                        <div class="edit-stars">

                            <?php for($i = 1; $i <= 5; $i++): ?>

                                <button
                                    type="button"
                                    class="edit-star-button <?php echo e($i <= $review->rating ? 'active' : ''); ?>"
                                    data-rating="<?php echo e($i); ?>"
                                    aria-label="<?php echo e($i); ?> نجوم"
                                >

                                    <i class="fa-solid fa-star"></i>

                                </button>

                            <?php endfor; ?>

                        </div>


                        <div class="edit-rating-value">

                            <strong id="editRatingValue">
                                <?php echo e($review->rating); ?>/5
                            </strong>

                            <span id="editRatingText">

                                <?php switch($review->rating):

                                    case (1): ?>
                                        سيئ
                                        <?php break; ?>

                                    <?php case (2): ?>
                                        مقبول
                                        <?php break; ?>

                                    <?php case (3): ?>
                                        جيد
                                        <?php break; ?>

                                    <?php case (4): ?>
                                        ممتاز
                                        <?php break; ?>

                                    <?php case (5): ?>
                                        ممتاز جدًا
                                        <?php break; ?>

                                <?php endswitch; ?>

                            </span>

                        </div>

                    </div>


                    <input
                        type="hidden"
                        name="rating"
                        id="editRatingInput"
                        value="<?php echo e(old('rating', $review->rating)); ?>"
                    >


                    <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                        <span class="edit-field-error">
                            <?php echo e($message); ?>

                        </span>

                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                </div>


                

                <div class="edit-form-section">

                    <div class="edit-section-title">

                        <div class="edit-section-icon comment">
                            <i class="fa-solid fa-comment"></i>
                        </div>

                        <div>

                            <h2>
                                التعليق
                            </h2>

                            <p>
                                تعديل نص تجربة المستخدم
                            </p>

                        </div>

                    </div>


                    <div class="edit-textarea-wrapper">

                        <textarea
                            name="comment"
                            class="edit-review-textarea"
                            placeholder="اكتب تعليق التقييم..."
                            required
                        ><?php echo e(old('comment', $review->comment)); ?></textarea>

                    </div>


                    <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                        <span class="edit-field-error">
                            <?php echo e($message); ?>

                        </span>

                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                </div>


                

                <div class="edit-form-section">

                    <div class="edit-section-title">

                        <div class="edit-section-icon status">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                        <div>

                            <h2>
                                حالة التقييم
                            </h2>

                            <p>
                                تحديد حالة التقييم داخل النظام
                            </p>

                        </div>

                    </div>


                    <div class="edit-status-options">


                        

                        <label class="edit-status-option approved">

                            <input
                                type="radio"
                                name="status"
                                value="approved"
                                <?php echo e(old('status', $review->status) === 'approved' ? 'checked' : ''); ?>

                            >

                            <div class="edit-status-content">

                                <div class="edit-status-option-icon">

                                    <i class="fa-solid fa-circle-check"></i>

                                </div>

                                <div>

                                    <strong>
                                        مقبول
                                    </strong>

                                    <span>
                                        التقييم ظاهر ومقبول
                                    </span>

                                </div>

                            </div>

                        </label>





                        

                        <label class="edit-status-option rejected">

                            <input
                                type="radio"
                                name="status"
                                value="rejected"
                                <?php echo e(old('status', $review->status) === 'rejected' ? 'checked' : ''); ?>

                            >

                            <div class="edit-status-content">

                                <div class="edit-status-option-icon">

                                    <i class="fa-solid fa-circle-xmark"></i>

                                </div>

                                <div>

                                    <strong>
                                        مرفوض
                                    </strong>

                                    <span>
                                        التقييم غير مقبول
                                    </span>

                                </div>

                            </div>

                        </label>

                    </div>


                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                        <span class="edit-field-error">
                            <?php echo e($message); ?>

                        </span>

                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                </div>


                

                <div class="edit-form-actions">

                    <a
                        href="<?php echo e(route('admin.ratings.index')); ?>"
                        class="edit-cancel-button"
                    >

                        <i class="fa-solid fa-xmark"></i>

                        إلغاء

                    </a>


                    <button
                        type="submit"
                        class="edit-save-button"
                    >

                        <i class="fa-solid fa-floppy-disk"></i>

                        حفظ التعديلات

                    </button>

                </div>

            </form>

        </div>

    </div>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/ratings/edit_rating.blade.php ENDPATH**/ ?>
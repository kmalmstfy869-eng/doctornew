<?php if(session()->has('success') || session()->has('error')): ?>

    <?php
        $isSuccess = session()->has('success');
        $message = session('success') ?? session('error');
    ?>

    <div
        class="flash-message <?php echo e($isSuccess ? 'flash-success' : 'flash-error'); ?>"
        role="alert"
    >

        
        <div class="flash-icon">

            <?php if($isSuccess): ?>

                <i class="fa-solid fa-check"></i>

            <?php else: ?>

                <i class="fa-solid fa-xmark"></i>

            <?php endif; ?>

        </div>


        
        <div class="flash-content">

            <strong>
                <?php echo e($isSuccess ? 'تمت العملية بنجاح' : 'حدث خطأ'); ?>

            </strong>

            <span>
                <?php echo e($message); ?>

            </span>

        </div>


        
        <button
            type="button"
            class="flash-close"
            aria-label="إغلاق الرسالة"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>


        
        <div class="flash-progress"></div>

    </div>

<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/home/info/flash-message.blade.php ENDPATH**/ ?>
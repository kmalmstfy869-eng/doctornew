
<?php if($paginator->hasPages()): ?>
<div class="pagination">

    
    <?php if($paginator->onFirstPage()): ?>

        <span class="page-button disabled">
            <i class="fa-solid fa-angle-right"></i>
        </span>

    <?php else: ?>

        <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="page-button">
            <i class="fa-solid fa-angle-right"></i>
        </a>

    <?php endif; ?>


    <?php

        $current = $paginator->currentPage();
        $last = $paginator->lastPage();

        $start = max(1, $current - 1);
        $end = min($last, $start + 3);

        $start = max(1, $end - 3);

    ?>


    <?php for($page = $start; $page <= $end; $page++): ?>

        <?php if($page == $current): ?>

            <span class="page-button active">
                <?php echo e($page); ?>

            </span>

        <?php else: ?>

            <a href="<?php echo e($paginator->url($page)); ?>" class="page-button">
                <?php echo e($page); ?>

            </a>

        <?php endif; ?>

    <?php endfor; ?>


    <?php if($paginator->hasMorePages()): ?>

        <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="page-button">
            <i class="fa-solid fa-angle-left"></i>
        </a>

    <?php else: ?>

        <span class="page-button disabled">
            <i class="fa-solid fa-angle-left"></i>
        </span>

    <?php endif; ?>

</div>
<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/vendor/pagination/custom.blade.php ENDPATH**/ ?>

<?php
    $items = [
        ['admin.storage.overview', 'fa-gauge-high', 'نظرة عامة'],
        ['admin.storage.files', 'fa-folder-open', 'الملفات والنسخ'],
        ['admin.storage.runs', 'fa-clock-rotate-left', 'سجل التشغيل'],
        ['admin.storage.restore', 'fa-rotate-left', 'الاسترجاع'],
        ['admin.storage.quotas', 'fa-sliders', 'مساحات الأطباء'],
    ];
?>

<nav class="ap-tabs">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$r, $icon, $label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route($r)); ?>" class="ap-tab <?php echo e(request()->routeIs($r) ? 'is-active' : ''); ?>">
            <i class="fa-solid <?php echo e($icon); ?>"></i><span><?php echo e($label); ?></span>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</nav>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/storage/_nav.blade.php ENDPATH**/ ?>
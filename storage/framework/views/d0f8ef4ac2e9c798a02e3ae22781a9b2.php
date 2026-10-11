<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'مساحات الأطباء | لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'مساحات الأطباء'); ?>
<?php $__env->startSection('page-description', 'تابع استهلاك ملفات المرضى لكل طبيب'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.storage.partials._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if($errors->any()): ?>
        <div class="ap-alert ap-alert--bad">
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>

    <div class="dashboard-card ap-card">

        <div class="ap-card__head">
            <div>
                <h3>مساحات الأطباء</h3>
                <p id="ap-count"><?php echo e($doctors->total()); ?> طبيب • المساحة الأساسية <?php echo e(rtrim(rtrim(number_format($defaultGb, 2), '0'), '.')); ?> GB + اشتراكات المساحة</p>
            </div>
            <a href="<?php echo e(route('admin.storage.extra.index')); ?>" class="ap-btn ap-btn--primary">
                <i class="fa-solid fa-cubes-stacked"></i> اشتراكات المساحة
            </a>
        </div>

        <form method="GET" action="<?php echo e(route('admin.storage.quotas')); ?>" class="ap-filters">
            <div class="ap-field ap-field--grow">
                <label>بحث</label>
                <input type="text" name="search" value="<?php echo e($search); ?>" class="ap-input" autocomplete="off"
                    placeholder="اسم الدكتور أو الإيميل"
                    data-live-search data-live-search-url="<?php echo e(route('admin.storage.quotas')); ?>"
                    data-live-search-target="#ap-list" data-live-search-pagination="#ap-pagination"
                    data-live-search-count="#ap-count" data-live-search-preserve="#f-limit,#f-sort">
            </div>
            <div class="ap-field">
                <label>الاستهلاك</label>
                <select name="limit" id="f-limit" class="ap-input" onchange="this.form.submit()">
                    <option value="">الكل</option>
                    <option value="attention" <?php if($limit === 'attention'): echo 'selected'; endif; ?>>قرب من الحد أو ممتلئ</option>
                    <option value="near" <?php if($limit === 'near'): echo 'selected'; endif; ?>>قرب من الحد</option>
                    <option value="full" <?php if($limit === 'full'): echo 'selected'; endif; ?>>ممتلئ</option>
                </select>
            </div>
            <div class="ap-field">
                <label>الترتيب</label>
                <select name="sort" id="f-sort" class="ap-input" onchange="this.form.submit()">
                    <option value="percent" <?php if($sort === 'percent'): echo 'selected'; endif; ?>>نسبة الاستهلاك</option>
                    <option value="used" <?php if($sort === 'used'): echo 'selected'; endif; ?>>المساحة المستخدمة</option>
                    <option value="name" <?php if($sort === 'name'): echo 'selected'; endif; ?>>الاسم</option>
                </select>
            </div>
            <a href="<?php echo e(route('admin.storage.quotas')); ?>" class="ap-btn ap-btn--ghost">مسح الفلاتر</a>
        </form>

        <div id="ap-list">
            <?php echo $__env->make('admin.storage.partials._quotas_list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div id="ap-pagination" class="ap-card__foot"><?php echo e($doctors->links('vendor.pagination.custom')); ?></div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra_java'); ?>
    <script src="<?php echo e(asset('js/clinic/live_search.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/storage/quotas.blade.php ENDPATH**/ ?>
<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'استرجاع ملفات المرضى | لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'استرجاع ملفات المرضى'); ?>
<?php $__env->startSection('page-description', 'استرجاع ملف معين أو الملفات الناقصة من النسخة الاحتياطية'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.storage._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if($errors->any()): ?>
        <div class="ap-alert ap-alert--bad">
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>

    
    <div class="dashboard-card ap-card">
        <div class="ap-card__head">
            <div>
                <h3>استرجاع الملفات الناقصة</h3>
                <p>بيرجّع الملفات اللي مش موجودة في الـ Primary من النسخة الاحتياطية. الملفات اللي اتحذفت عمدًا مش بتتسترجع هنا.</p>
            </div>

            <form method="POST" action="<?php echo e(route('admin.storage.restore.preview')); ?>" x-data="{ busy: false }" @submit="busy = true">
                <?php echo csrf_field(); ?>
                <button type="submit" class="ap-btn ap-btn--ghost" :disabled="busy">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span x-text="busy ? 'جاري الفحص...' : 'معاينة اللي هيتسترجع'">معاينة اللي هيتسترجع</span>
                </button>
            </form>
        </div>

        <?php if($preview): ?>
            <div class="ap-card__body">
                <div class="ap-kv">
                    <div><span>هيتسترجع</span><b><?php echo e($preview['count']); ?></b></div>
                    <div><span>موجود وسليم (هيتخطى)</span><b><?php echo e($preview['skipped']); ?></b></div>
                    <div><span>مشاكل في الفحص</span><b><?php echo e($preview['failed']); ?></b></div>
                </div>

                <?php if($preview['count'] > 0): ?>
                    <details style="margin-top:1rem">
                        <summary style="cursor:pointer;font-weight:800">أسماء الملفات اللي هتتسترجع</summary>
                        <ul style="margin-top:.5rem;padding-inline-start:1.2rem;font-size:.85rem">
                            <?php $__currentLoopData = $preview['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($n); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($preview['more'] > 0): ?><li>و <?php echo e($preview['more']); ?> ملف تانيين</li><?php endif; ?>
                        </ul>
                    </details>

                    <form method="POST" action="<?php echo e(route('admin.storage.restore.all')); ?>" x-data="{ busy: false }"
                        @submit="if (confirm('هيتم استرجاع <?php echo e($preview['count']); ?> ملف للتخزين الأساسي. متأكد؟')) { busy = true } else { $event.preventDefault() }"
                        style="margin-top:1rem">
                        <?php echo csrf_field(); ?>
                        <label class="ap-check" style="color:inherit;margin-bottom:.75rem">
                            <input type="checkbox" name="confirm" value="1" required>
                            أؤكد استرجاع الملفات الناقصة (النسخة الاحتياطية الأصلية بتفضل زي ما هي)
                        </label>
                        <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span x-text="busy ? 'جاري الاسترجاع... متقفلش الصفحة' : 'استرجاع الناقص'">استرجاع الناقص</span>
                        </button>
                    </form>
                <?php else: ?>
                    <div class="ap-alert ap-alert--ok" style="margin-top:1rem">مفيش ملفات ناقصة، كله موجود.</div>
                <?php endif; ?>

                <?php if(! empty($preview['errors'])): ?>
                    <div class="ap-alert ap-alert--warn" style="margin-top:1rem">
                        مشاكل أثناء الفحص:
                        <ul><?php $__currentLoopData = $preview['errors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e['name']); ?>: <?php echo e($e['error']); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if($result): ?>
            <div class="ap-card__body" style="border-top:1px solid rgba(127,127,127,.18)">
                <h4 style="margin:0 0 .75rem;font-weight:800">نتيجة آخر استرجاع جماعي</h4>
                <div class="ap-kv">
                    <div><span>اتسترجع</span><b class="ap-plus"><?php echo e($result['restored']); ?></b></div>
                    <div><span>اتخطى</span><b><?php echo e($result['skipped']); ?></b></div>
                    <div><span>فشل</span><b class="<?php echo e($result['failed'] ? 'ap-minus' : ''); ?>"><?php echo e($result['failed']); ?></b></div>
                </div>

                <?php if(! empty($result['errors'])): ?>
                    <div class="ap-alert ap-alert--bad" style="margin-top:1rem">
                        تفاصيل الفشل:
                        <ul><?php $__currentLoopData = $result['errors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e['name']); ?>: <?php echo e($e['error']); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    
    <div x-data>
        <div class="dashboard-card ap-card">

            <div class="ap-card__head">
                <div>
                    <h3>استرجاع ملف معين</h3>
                    <p id="ap-count"><?php echo e($rows->total()); ?> نسخة احتياطية</p>
                </div>
            </div>

            <form method="GET" action="<?php echo e(route('admin.storage.restore')); ?>" class="ap-filters">
                <div class="ap-field ap-field--grow">
                    <label>بحث</label>
                    <input type="text" name="search" value="<?php echo e($search); ?>" class="ap-input" autocomplete="off"
                        placeholder="اسم الملف أو المريض أو الدكتور"
                        data-live-search data-live-search-url="<?php echo e(route('admin.storage.restore')); ?>"
                        data-live-search-target="#ap-list" data-live-search-pagination="#ap-pagination"
                        data-live-search-count="#ap-count" data-live-search-preserve="#f-scope">
                </div>
                <div class="ap-field">
                    <label>عرض</label>
                    <select name="scope" id="f-scope" class="ap-input" onchange="this.form.submit()">
                        <option value="">كل النسخ</option>
                        <option value="deleted" <?php if($scope === 'deleted'): echo 'selected'; endif; ?>>الأصل اتحذف عمدًا</option>
                        <option value="no_record" <?php if($scope === 'no_record'): echo 'selected'; endif; ?>>سجل الداتابيز ناقص</option>
                    </select>
                </div>
                <a href="<?php echo e(route('admin.storage.restore')); ?>" class="ap-btn ap-btn--ghost">مسح الفلاتر</a>
            </form>

            <div id="ap-list">
                <?php echo $__env->make('admin.storage._restore_list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div id="ap-pagination" class="ap-card__foot"><?php echo e($rows->links('vendor.pagination.custom')); ?></div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra_java'); ?>
    <script src="<?php echo e(asset('js/clinic/live_search.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/storage/restore.blade.php ENDPATH**/ ?>
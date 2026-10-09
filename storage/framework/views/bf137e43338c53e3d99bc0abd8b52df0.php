<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'الملفات والنسخ | لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'الملفات والنسخ الاحتياطية'); ?>
<?php $__env->startSection('page-description', 'اعرف كل ملف اتنسخ ولا لأ، واسترجع اللي ناقص'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.storage._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div x-data>

        <div class="dashboard-card ap-card">

            <div class="ap-card__head">
                <div>
                    <h3><?php echo e($view === 'deleted' ? 'نسخ الملفات المحذوفة من الـ Primary' : 'ملفات المرضى'); ?></h3>
                    <p id="ap-count"><?php echo e($rows->total()); ?> <?php echo e($view === 'deleted' ? 'نسخة' : 'ملف'); ?></p>
                </div>

                <div class="ap-seg">
                    <a href="<?php echo e(route('admin.storage.files')); ?>" class="<?php echo e($view === 'current' ? 'is-active' : ''); ?>">الملفات الحالية</a>
                    <a href="<?php echo e(route('admin.storage.files', ['view' => 'deleted'])); ?>" class="<?php echo e($view === 'deleted' ? 'is-active' : ''); ?>">الأصل اتحذف</a>
                </div>
            </div>

            <form method="GET" action="<?php echo e(route('admin.storage.files')); ?>" class="ap-filters">
                <input type="hidden" name="view" id="f-view" value="<?php echo e($view); ?>">

                <div class="ap-field ap-field--grow">
                    <label>بحث</label>
                    <input type="text" name="search" value="<?php echo e($search); ?>" class="ap-input" autocomplete="off"
                        placeholder="اسم الملف أو المريض أو الدكتور أو رقم الملف"
                        data-live-search data-live-search-url="<?php echo e(route('admin.storage.files')); ?>"
                        data-live-search-target="#ap-list" data-live-search-pagination="#ap-pagination"
                        data-live-search-count="#ap-count"
                        data-live-search-preserve="#f-view,#f-doctor,#f-status,#f-type,#f-from,#f-to">
                </div>

                <div class="ap-field">
                    <label>الدكتور</label>
                    <select name="doctor_id" id="f-doctor" class="ap-input" onchange="this.form.submit()">
                        <option value="">الكل</option>
                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($d->id); ?>" <?php if((int) request('doctor_id') === $d->id): echo 'selected'; endif; ?>>د. <?php echo e($d->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <?php if($view === 'current'): ?>
                    <div class="ap-field">
                        <label>حالة النسخ</label>
                        <select name="status" id="f-status" class="ap-input" onchange="this.form.submit()">
                            <option value="">الكل</option>
                            <option value="done" <?php if(request('status') === 'done'): echo 'selected'; endif; ?>>اتنسخ</option>
                            <option value="pending" <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>>لسه ما اتنسخش</option>
                            <option value="failed" <?php if(request('status') === 'failed'): echo 'selected'; endif; ?>>فشل النسخ</option>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="ap-field">
                    <label>النوع</label>
                    <select name="type" id="f-type" class="ap-input" onchange="this.form.submit()">
                        <option value="">الكل</option>
                        <option value="pdf" <?php if(request('type') === 'pdf'): echo 'selected'; endif; ?>>PDF</option>
                        <option value="image" <?php if(request('type') === 'image'): echo 'selected'; endif; ?>>صورة</option>
                    </select>
                </div>

                <div class="ap-field">
                    <label>من (<?php echo e($view === 'deleted' ? 'تاريخ الحذف' : 'تاريخ الرفع'); ?>)</label>
                    <input type="date" name="from" id="f-from" value="<?php echo e(request('from')); ?>" class="ap-input" onchange="this.form.submit()">
                </div>

                <div class="ap-field">
                    <label>إلى</label>
                    <input type="date" name="to" id="f-to" value="<?php echo e(request('to')); ?>" class="ap-input" onchange="this.form.submit()">
                </div>

                <a href="<?php echo e(route('admin.storage.files', ['view' => $view])); ?>" class="ap-btn ap-btn--ghost">مسح الفلاتر</a>
            </form>

            <div id="ap-list">
                <?php echo $__env->make('admin.storage._files_list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div id="ap-pagination" class="ap-card__foot">
                <?php echo e($rows->links('vendor.pagination.custom')); ?>

            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra_java'); ?>
    <script src="<?php echo e(asset('js/clinic/live_search.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/storage/files.blade.php ENDPATH**/ ?>
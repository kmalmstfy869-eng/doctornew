<?php use \App\Services\PatientFileService; ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'مساحات الأطباء | لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'مساحات الأطباء'); ?>
<?php $__env->startSection('page-description', 'حدد مساحة ملفات المرضى لكل طبيب وتابع الاستهلاك'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.storage._nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if($errors->any()): ?>
        <div class="ap-alert ap-alert--bad">
            <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>

    <div x-data>

        <div class="dashboard-card ap-card">

            <div class="ap-card__head">
                <div>
                    <h3>مساحات الأطباء</h3>
                    <p id="ap-count"><?php echo e($doctors->total()); ?> طبيب • المساحة الافتراضية <?php echo e(rtrim(rtrim(number_format($defaultGb, 2), '0'), '.')); ?> GB</p>
                </div>
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
                <?php echo $__env->make('admin.storage._quotas_list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div id="ap-pagination" class="ap-card__foot"><?php echo e($doctors->links('vendor.pagination.custom')); ?></div>

        </div>

        
        <div x-data="apQuota()" @ap-quota-open.window="open($event.detail)" x-cloak>
            <div x-show="show" class="ap-modal" @click.self="show = false" @keydown.escape.window="show = false">

                <form method="POST" :action="action" class="dashboard-card ap-modal__panel"
                    @submit="if (!confirm('تأكيد تعديل المساحة؟')) { $event.preventDefault() } else { busy = true }">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <div class="ap-modal__head">
                        <h3>تعديل مساحة <span x-text="name"></span></h3>
                        <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" @click="show = false">إغلاق</button>
                    </div>

                    <div class="ap-kv" style="grid-template-columns:repeat(3,1fr)">
                        <div><span>المساحة الحالية</span><b dir="ltr"><span x-text="old"></span> GB</b></div>
                        <div><span>المستخدم</span><b dir="ltr" x-text="used"></b></div>
                        <div><span>الملفات</span><b x-text="files"></b></div>
                    </div>

                    <div class="ap-field" style="margin-top:1rem">
                        <label>المساحة الجديدة (GB)</label>
                        <input type="number" step="0.5" min="1" name="quota_gb" x-model="quota" class="ap-input" required>
                        <div class="ap-quick">
                            <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" @click="add(25)">+25 GB</button>
                            <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" @click="add(50)">+50 GB</button>
                            <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" @click="add(100)">+100 GB</button>
                            <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" @click="quota = old">رجّعها زي ما كانت</button>
                        </div>
                    </div>

                    <div class="ap-alert ap-alert--warn" style="margin-top:1rem" x-show="below">
                        الاستهلاك الحالي أكبر من المساحة الجديدة: الرفع الجديد هيتوقف، والملفات الموجودة تفضل (عرض وتحميل وحذف).
                    </div>

                    <div style="margin-top:1rem" x-show="added > 0">
                        <label class="ap-check" style="color:inherit">
                            <input type="checkbox" name="record_income" value="1" x-model="income"
                                @change="if (income && !amount) amount = suggested">
                            سجّل زيادة المساحة كإيراد في المالية (<?php echo e($extraGb); ?> GB = <?php echo e($extraPrice); ?> ج.م)
                        </label>
                        <div class="ap-field" style="margin-top:.6rem" x-show="income">
                            <label>المبلغ (ج.م)</label>
                            <input type="number" step="0.01" min="0.01" name="income_amount" x-model="amount" class="ap-input" :disabled="!income">
                        </div>
                    </div>

                    <div class="ap-modal__foot">
                        <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy">حفظ المساحة</button>
                        <button type="button" class="ap-btn ap-btn--ghost" @click="show = false">إلغاء</button>
                    </div>
                </form>

            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra_java'); ?>
    <script src="<?php echo e(asset('js/clinic/live_search.js')); ?>"></script>
    <script>
        // حالة مودال تعديل المساحة.
        function apQuota() {
            return {
                show: false, busy: false, action: '', name: '', old: 0, quota: '', used: '', files: 0, usedBytes: 0,
                income: false, amount: '',
                extraGb: <?php echo e($extraGb); ?>, price: <?php echo e($extraPrice); ?>,
                template: <?php echo json_encode(route('admin.storage.quotas.update', '__ID__'), 512) ?>,

                open(d) {
                    this.action = this.template.replace('__ID__', d.id);
                    this.name = 'د. ' + d.name;
                    this.old = +d.quota;
                    this.quota = d.quota;
                    this.used = d.used;
                    this.files = d.files;
                    this.usedBytes = +d.used_bytes;
                    this.income = false;
                    this.amount = '';
                    this.busy = false;
                    this.show = true;
                },
                add(n) { this.quota = Math.round(((+this.quota || 0) + n) * 1000) / 1000; },
                get added() { return Math.max(0, (+this.quota || 0) - this.old); },
                get suggested() { return Math.ceil(this.added / this.extraGb) * this.price; },
                get below() { return (+this.quota || 0) * 1073741824 < this.usedBytes; },
            };
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/storage/quotas.blade.php ENDPATH**/ ?>
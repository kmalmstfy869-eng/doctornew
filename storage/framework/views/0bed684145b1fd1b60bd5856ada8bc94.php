<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'المالية | لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'المالية'); ?>
<?php $__env->startSection('page-description', 'كل اللي داخل وكل اللي خارج'); ?>

<?php $__env->startSection('content'); ?>
    <div class="finance-page" dir="rtl">

        <?php
            $fmt = fn($n) => \App\Support\Money::fmt($n);
            $labels = \App\Models\FinanceEntry::allCategories();
        ?>

        <?php if($errors->any()): ?>
            <div class="ap-alert ap-alert--bad">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($e); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div x-data>

            
            <div class="dashboard-card ap-card">
                <div class="ap-card__head">
                    <div>
                        <h3>الفترة: <?php echo e(\Carbon\Carbon::parse($from)->translatedFormat('d M Y')); ?> -
                            <?php echo e(\Carbon\Carbon::parse($to)->translatedFormat('d M Y')); ?></h3>
                        <p>الافتراضي الشهر الحالي</p>
                    </div>
                    <button type="button" class="ap-btn ap-btn--primary" @click="$dispatch('ap-fin-open')">
                        <i class="fa-solid fa-plus"></i> إضافة حركة
                    </button>
                </div>

                <form method="GET" action="<?php echo e(route('admin.finance.index')); ?>" class="ap-filters" id="finance-filters">
                    <div class="ap-field">
                        <label>من</label>
                        <input type="date" name="from" value="<?php echo e($from); ?>" class="ap-input">
                    </div>
                    <div class="ap-field">
                        <label>إلى</label>
                        <input type="date" name="to" value="<?php echo e($to); ?>" class="ap-input">
                    </div>
                    <div class="ap-field">
                        <label>النوع</label>
                        <select name="type" class="ap-input">
                            <option value="">الكل</option>
                            <option value="income" <?php if($type === 'income'): echo 'selected'; endif; ?>>داخل</option>
                            <option value="expense" <?php if($type === 'expense'): echo 'selected'; endif; ?>>خارج</option>
                        </select>
                    </div>
                    <div class="ap-field">
                        <label>التصنيف</label>
                        <select name="category" class="ap-input">
                            <option value="">الكل</option>
                            <optgroup label="داخل">
                                <?php $__currentLoopData = $categories['income']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($k); ?>" <?php if($category === $k): echo 'selected'; endif; ?>><?php echo e($v); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </optgroup>
                            <optgroup label="خارج">
                                <?php $__currentLoopData = $categories['expense']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($k); ?>" <?php if($category === $k): echo 'selected'; endif; ?>><?php echo e($v); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </optgroup>
                        </select>
                    </div>
                    <div class="ap-field ap-field--grow">
                        <label>بحث في البيان</label>
                        <input type="text" name="search" value="<?php echo e($search); ?>" class="ap-input"
                            placeholder="اكتب للبحث..." autocomplete="off">
                    </div>
                    <a href="<?php echo e(route('admin.finance.index')); ?>" class="ap-btn ap-btn--ghost">الشهر الحالي</a>
                </form>
            </div>

            
            <div id="finance-results">

                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon green-icon"><i class="fa-solid fa-arrow-down-long"></i></div>
                        <div class="stat-info">
                            <p>إجمالي الداخل</p>
                            <h3 class="ap-plus"><?php echo e($fmt($income)); ?> ج.م</h3>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon ap-icon-red"><i class="fa-solid fa-arrow-up-long"></i></div>
                        <div class="stat-info">
                            <p>إجمالي الخارج</p>
                            <h3 class="ap-minus"><?php echo e($fmt($expense)); ?> ج.م</h3>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon blue-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                        <div class="stat-info">
                            <p>الصافي</p>
                            <h3 class="<?php echo e($net < 0 ? 'ap-minus' : 'ap-plus'); ?>">
                                <?php echo e($net < 0 ? '−' : ''); ?><?php echo e($fmt(abs($net))); ?> ج.م</h3>
                        </div>
                    </div>
                </div>

                <div class="ap-grid-2" style="margin-top:1rem">

                    
                    <div class="dashboard-card ap-card">
                        <div class="ap-card__head">
                            <div>
                                <h3>حسب التصنيف</h3>
                                <p>في الفترة المحددة</p>
                            </div>
                        </div>
                        <div class="ap-card__body">
                            <?php $__empty_1 = true; $__currentLoopData = $byCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $base = $row->type === 'income' ? max($income, 0.01) : max($expense, 0.01);
                                    $p = min(100, round(($row->total / $base) * 100));
                                ?>
                                <div style="margin-bottom:1rem">
                                    <div
                                        style="display:flex;justify-content:space-between;gap:.5rem;font-size:.85rem;font-weight:800">
                                        <span>
                                            <span
                                                class="ap-badge <?php echo e($row->type === 'income' ? 'ap-badge--ok' : 'ap-badge--bad'); ?>"><?php echo e($row->type === 'income' ? 'داخل' : 'خارج'); ?></span>
                                            <?php echo e($labels[$row->category] ?? $row->category); ?> (<?php echo e($row->n); ?>)
                                        </span>
                                        <span><?php echo e($fmt($row->total)); ?> ج.م</span>
                                    </div>
                                    <div class="ap-meter <?php echo e($row->type === 'income' ? '' : 'ap-meter--bad'); ?>"
                                        style="margin-top:.4rem"><span style="width: <?php echo e(max($p, 2)); ?>%"></span></div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-chart-pie','title' => 'لا توجد تصنيفات','content' => 'مفيش حركات في الفترة أو الفلاتر دي عشان نعرضها حسب التصنيف.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-chart-pie','title' => 'لا توجد تصنيفات','content' => 'مفيش حركات في الفترة أو الفلاتر دي عشان نعرضها حسب التصنيف.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $attributes = $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $component = $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="dashboard-card ap-card">
                        <div class="ap-card__head">
                            <div>
                                <h3>آخر 6 شهور</h3>
                                <p>بغض النظر عن الفلتر</p>
                            </div>
                        </div>
                        <?php if($months->isEmpty()): ?>
                            <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-calendar','title' => 'لا توجد بيانات','content' => 'سجّل أول حركة عشان تظهر مقارنة آخر 6 شهور.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-calendar','title' => 'لا توجد بيانات','content' => 'سجّل أول حركة عشان تظهر مقارنة آخر 6 شهور.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $attributes = $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $component = $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>
                        <?php else: ?>
                            <div class="ap-table-wrap">
                                <table class="ap-table">
                                    <thead>
                                        <tr>
                                            <th>الشهر</th>
                                            <th>داخل</th>
                                            <th>خارج</th>
                                            <th>الصافي</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $n = $m->income - $m->expense; ?>
                                            <tr>
                                                <td data-label="الشهر">
                                                    <?php echo e(\Carbon\Carbon::createFromFormat('Y-m', $m->ym)->translatedFormat('F Y')); ?>

                                                </td>
                                                <td data-label="داخل"><span
                                                        class="ap-num ap-plus"><?php echo e($fmt($m->income)); ?></span></td>
                                                <td data-label="خارج"><span
                                                        class="ap-num ap-minus"><?php echo e($fmt($m->expense)); ?></span></td>
                                                <td data-label="الصافي"><span
                                                        class="ap-num <?php echo e($n < 0 ? 'ap-minus' : 'ap-plus'); ?>"><?php echo e($n < 0 ? '−' : ''); ?><?php echo e($fmt(abs($n))); ?></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

                
                <div class="dashboard-card ap-card">
                    <div class="ap-card__head">
                        <div>
                            <h3>الحركات</h3>
                            <p><?php echo e($entries->total()); ?> حركة</p>
                        </div>
                    </div>

                    <?php if($entries->isEmpty()): ?>
                        <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-receipt','title' => 'لا توجد حركات','content' => 'مفيش حركات بتطابق البحث أو الفلاتر دلوقتي. جرّب تغيّر الفلتر أو دوس على إضافة حركة.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-receipt','title' => 'لا توجد حركات','content' => 'مفيش حركات بتطابق البحث أو الفلاتر دلوقتي. جرّب تغيّر الفلتر أو دوس على إضافة حركة.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $attributes = $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $component = $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>
                    <?php else: ?>
                        <div class="ap-table-wrap">
                            <table class="ap-table">
                                <thead>
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>النوع</th>
                                        <th>التصنيف</th>
                                        <th>البيان</th>
                                        <th>المبلغ</th>
                                        <th>الحذف</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td data-label="التاريخ"><?php echo e($e->entry_date->translatedFormat('d M Y')); ?></td>
                                            <td data-label="النوع"><span
                                                    class="ap-badge <?php echo e($e->type === 'income' ? 'ap-badge--ok' : 'ap-badge--bad'); ?>"><?php echo e($e->type === 'income' ? 'داخل' : 'خارج'); ?></span>
                                            </td>
                                            <td data-label="التصنيف"><?php echo e($e->category_label); ?></td>
                                            <td data-label="البيان">
                                                <div>
                                                    <div class="ap-title"><?php echo e($e->title); ?></div>
                                                    <?php if($e->note): ?>
                                                        <div class="ap-sub"><?php echo e($e->note); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td data-label="المبلغ"><span
                                                    class="ap-num <?php echo e($e->type === 'income' ? 'ap-plus' : 'ap-minus'); ?>"><?php echo e($e->type === 'income' ? '+' : '−'); ?><?php echo e($fmt($e->amount)); ?>

                                                    ج.م</span></td>
                                            <td data-label="">
                                                <form method="POST" action="<?php echo e(route('admin.finance.destroy', $e)); ?>"
                                                    onsubmit="return confirm('حذف الحركة دي نهائيًا؟')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="ap-btn ap-btn--danger ap-btn--sm"><i
                                                            class="fa-regular fa-trash-can"></i> حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="ap-card__foot"><?php echo e($entries->links('vendor.pagination.custom')); ?></div>
                    <?php endif; ?>
                </div>

            </div>

            

            <div x-data="apFinance()" data-categories="<?php echo e(json_encode($categories)); ?>"
                data-old-type="<?php echo e(old('type', 'income')); ?>" data-old-category="<?php echo e(old('category')); ?>"
                data-has-errors="<?php echo e($errors->financeStore->any() ? '1' : '0'); ?>" @ap-fin-open.window="show = true"
                x-cloak>
                <div x-show="show" class="ap-modal" @click.self="show = false" @keydown.escape.window="show = false">
                    <form method="POST" action="<?php echo e(route('admin.finance.store')); ?>"
                        class="dashboard-card ap-modal__panel" @submit="busy = true">
                        <?php echo csrf_field(); ?>

                        <div class="ap-modal__head">
                            <h3>إضافة حركة</h3>
                            <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm"
                                @click="show = false">إغلاق</button>
                        </div>

                        <?php if($errors->financeStore->any()): ?>
                            <div class="ap-alert ap-alert--bad" style="margin-bottom:1rem">
                                <ul>
                                    <?php $__currentLoopData = $errors->financeStore->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($err); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="ap-seg" style="width:100%;margin-bottom:1rem">
                            <button type="button" style="flex:1" :class="type === 'income' ? 'is-active' : ''"
                                @click="setType('income')">داخل</button>
                            <button type="button" style="flex:1" :class="type === 'expense' ? 'is-active' : ''"
                                @click="setType('expense')">خارج</button>
                        </div>
                        <input type="hidden" name="type" :value="type">

                        <div class="ap-form-grid ap-form-grid--2">
                            <div class="ap-field">
                                <label>التصنيف</label>
                                <select name="category" x-model="category" class="ap-input" required>
                                    <template x-for="(label, key) in cats[type]" :key="key">
                                        <option :value="key" x-text="label" :selected="key === category">
                                        </option>
                                    </template>
                                </select>
                            </div>
                            <div class="ap-field">
                                <label>التاريخ</label>
                                <input type="date" name="entry_date"
                                    value="<?php echo e(old('entry_date', now('Africa/Cairo')->toDateString())); ?>" class="ap-input"
                                    required>
                            </div>
                            <div class="ap-field" style="grid-column:1/-1">
                                <label>البيان</label>
                                <input type="text" name="title" value="<?php echo e(old('title')); ?>" maxlength="150"
                                    class="ap-input" placeholder="مثال: اشتراك د. أحمد - باقة Clinic System" required>
                            </div>
                            <div class="ap-field">
                                <label>المبلغ (ج.م)</label>
                                <input type="number" name="amount" value="<?php echo e(old('amount')); ?>" step="0.01"
                                    min="0.01" class="ap-input" required>
                            </div>
                            <div class="ap-field">
                                <label>ملاحظة (اختياري)</label>
                                <input type="text" name="note" value="<?php echo e(old('note')); ?>" maxlength="1000"
                                    class="ap-input">
                            </div>
                        </div>

                        <div class="ap-modal__foot">
                            <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy">حفظ
                                الحركة</button>
                            <button type="button" class="ap-btn ap-btn--ghost" @click="show = false">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra_java'); ?>
    <script src="<?php echo e(asset('js/admin/finance.js')); ?>?v=<?php echo e(filemtime(public_path('js/admin/finance.js'))); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/finance/index.blade.php ENDPATH**/ ?>
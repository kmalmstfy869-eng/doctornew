<?php $__env->startPush('extra_style'); ?>
    
    <link rel="stylesheet"
        href="<?php echo e(asset('css/admin/extra-storage.css')); ?>?v=<?php echo e(@filemtime(public_path('css/admin/extra-storage.css')) ?: time()); ?>">
    <link rel="stylesheet"
        href="<?php echo e(asset('css/admin/plans.css')); ?>?v=<?php echo e(@filemtime(public_path('css/admin/plans.css')) ?: time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'الباقات | لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'الباقات'); ?>
<?php $__env->startSection('page-description', 'الأسعار والمميزات وترتيب الظهور'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $fmt = fn($n) => \App\Support\Money::fmt($n);

        $reopen = $errors->planTier->any() ? ($payloads[old('tier')] ?? null) : null;
        $old = $reopen
            ? [
                'description' => old('description'),
                'features' => array_values((array) old('features', [])),
                'best_plan' => old('best_plan'),
                'prices' => (array) old('prices', []),
            ]
            : null;
    ?>

    <div class="pl-page" dir="rtl" x-data>

        <p class="pl-hint">
            <i class="fa-solid fa-lock"></i>
            الاسم والـ slug والمدة ثابتين لأن الكود معتمد عليهم. الوصف والمميزات بتتطبق على كل مدد الباقة.
        </p>

        
        <div class="pl-tiers">
            <?php $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $first = $rows->first();
                    $base = $first->duration > 0 ? $first->price / ($first->duration / 30) : 0;
                    $subs = $rows->sum('active_subs');
                    $maxSubs = max(1, (int) $rows->max('active_subs'));
                ?>
                <article class="dashboard-card pl-tier" data-tier="<?php echo e($key); ?>">
                    <header class="pl-tier__head">
                        <div class="pl-tier__top">
                            <h3 class="pl-name" dir="ltr"><?php echo e(ucwords($first->name)); ?></h3>
                        </div>
                        <p class="pl-desc"><?php echo e(trim((string) $first->description) ?: 'بدون وصف'); ?></p>
                    </header>

                    <ol class="pl-ladder">
                        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $per = $p->duration > 0 ? $p->price / ($p->duration / 30) : 0;
                                $w = round(((int) $p->active_subs / $maxSubs) * 100); // الأكتر مشتركين = شريط ممتلئ
                                $save = $base > 0 ? max(0, round((1 - $per / $base) * 100)) : 0;
                            ?>
                            <li class="pl-rung">
                                <span class="pl-rung__label"><?php echo e($p->durationLabel()); ?></span>
                                <span class="pl-rung__price"><?php echo e($fmt($p->price)); ?> <small>ج.م</small></span>
                                <span class="pl-rung__meta">
                                    ≈ <?php echo e($fmt($per)); ?> ج.م / شهر
                                    <?php if($p->the_best): ?>
                                        <span class="pl-best pl-best--sm"><i class="fa-solid fa-crown"></i> الأفضل</span>
                                    <?php endif; ?>
                                    <?php if($save > 0): ?>
                                        <em class="pl-save">وفّر <?php echo e($save); ?>%</em>
                                    <?php endif; ?>
                                </span>
                                <span class="pl-rung__subs"><b><?php echo e($p->active_subs); ?></b> مشترك</span>
                                <span class="pl-bar" aria-hidden="true"><i style="--w: <?php echo e($w); ?>%"></i></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ol>

                    <ul class="pl-feats">
                        <?php $__empty_1 = true; $__currentLoopData = ($first->features ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li><i class="fa-solid fa-check"></i><span><?php echo e(is_string($f) ? $f : json_encode($f, JSON_UNESCAPED_UNICODE)); ?></span></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="pl-empty">لا توجد مميزات</li>
                        <?php endif; ?>
                    </ul>

                    <footer class="pl-tier__foot">
                        <span class="pl-total"><b><?php echo e($subs); ?></b> مشترك فعّال</span>
                        <button type="button" class="ap-btn ap-btn--primary ap-btn--sm"
                            data-plan="<?php echo e(json_encode($payloads[$key], JSON_UNESCAPED_UNICODE)); ?>"
                            @click="$dispatch('ap-plan-edit-open', JSON.parse($el.dataset.plan))">
                            <i class="fa-solid fa-pen"></i> تعديل
                        </button>
                    </footer>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <?php if($free): ?>
            <?php $f0 = $free->first(); ?>
            <section class="dashboard-card pl-free" data-tier="free">
                <div class="pl-free__id">
                    <h3 class="pl-name" dir="ltr">Free</h3>
                    <span class="pl-chip pl-chip--solid">مجانية</span>
                </div>
                <div class="pl-free__body">
                    <p class="pl-desc"><?php echo e(trim((string) $f0->description) ?: 'بدون وصف'); ?></p>
                    <div class="pl-free__chips">
                        <?php $__currentLoopData = ($f0->features ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="pl-chip"><?php echo e(is_string($f) ? $f : json_encode($f, JSON_UNESCAPED_UNICODE)); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="pl-free__act">
                    <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm"
                        data-plan="<?php echo e(json_encode($payloads['free'], JSON_UNESCAPED_UNICODE)); ?>"
                        @click="$dispatch('ap-plan-edit-open', JSON.parse($el.dataset.plan))">
                        <i class="fa-solid fa-pen"></i> تعديل
                    </button>
                </div>
            </section>
        <?php endif; ?>

        
        <section class="dashboard-card pl-orderbox" x-data="apPlanOrder()"
            data-items="<?php echo e(json_encode($orderItems, JSON_UNESCAPED_UNICODE)); ?>">
            <div class="pl-orderbox__head">
                <h3>ترتيب الظهور</h3>
                <p>الأطباء بيظهروا حسب ترتيب باقتهم، الأعلى في القائمة الأول. الباقة المجانية دايمًا في الآخر.</p>
            </div>

            <?php if($errors->planOrder->any()): ?>
                <div class="ap-alert ap-alert--bad">
                    <ul><?php $__currentLoopData = $errors->planOrder->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.plans.order')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" name="order_token" value="<?php echo e($orderToken); ?>">

                <ol class="pl-order">
                    <template x-for="(it, i) in items" :key="it.id">
                        <li class="pl-ord" :data-tier="it.tier">
                            <input type="hidden" name="order[]" :value="it.id">
                            <span class="pl-ord__rank" x-text="i + 1"></span>
                            <span class="pl-ord__name">
                                <b dir="ltr" x-text="it.tier_label"></b>
                                <span x-text="it.label"></span>
                            </span>
                            <span class="pl-ord__price" x-text="it.price + ' ج.م'"></span>
                            <span class="pl-ord__btns">
                                <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" aria-label="تحريك لفوق"
                                    @click="move(i, -1)" :disabled="i === 0"><i class="fa-solid fa-arrow-up"></i></button>
                                <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" aria-label="تحريك لتحت"
                                    @click="move(i, 1)" :disabled="i === items.length - 1"><i class="fa-solid fa-arrow-down"></i></button>
                            </span>
                        </li>
                    </template>
                </ol>

                <div class="pl-savebar">
                    <span class="pl-savebar__msg" x-show="dirty()" x-cloak>الترتيب اتغيّر ولسه ما اتحفظش.</span>
                    <button type="submit" class="ap-btn ap-btn--primary">حفظ الترتيب</button>
                </div>
            </form>
        </section>

        
        <div x-data="apPlanTier()" data-reopen="<?php echo e(json_encode($reopen, JSON_UNESCAPED_UNICODE)); ?>"
            data-old="<?php echo e(json_encode($old, JSON_UNESCAPED_UNICODE)); ?>" @ap-plan-edit-open.window="open($event.detail)">
            <template x-teleport="body">
                <div class="ext-modal" x-show="show" x-cloak x-effect="document.body.style.overflow = show ? 'hidden' : ''"
                    @click.self="show = false" @keydown.escape.window="show = false">
                    <form method="POST" :action="plan ? plan.url : '#'" class="ext-panel" @submit="submit($event)">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="tier" :value="plan ? plan.key : ''">
                        <input type="hidden" name="plan_token" :value="plan ? plan.token : ''">

                        <div class="ext-panel__head">
                            <h3>تعديل باقة <span dir="ltr" x-text="plan ? plan.title : ''"></span></h3>
                            <button type="button" class="ext-x" @click="show = false">×</button>
                        </div>

                        <div class="ext-panel__body">
                            <?php if($errors->planTier->any()): ?>
                                <div class="ap-alert ap-alert--bad">
                                    <ul><?php $__currentLoopData = $errors->planTier->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                                </div>
                            <?php endif; ?>

                            <template x-if="plan">
                                <div class="ext-stack">

                                    <template x-if="!plan.is_free">
                                        <div class="ap-field">
                                            <label>الأسعار (ج.م)</label>
                                            <div class="pl-prices">
                                                <template x-for="pl in plan.plans" :key="pl.id">
                                                    <div class="pl-price-row">
                                                        <span class="pl-price-row__label" x-text="pl.label"></span>
                                                        <input type="number" :name="'prices[' + pl.id + ']'" x-model="prices[pl.id]"
                                                            step="0.01" min="0" class="ap-input" required>
                                                        <small x-show="perMonth(pl)" x-text="'≈ ' + perMonth(pl) + ' ج.م / شهر'"></small>
                                                    </div>
                                                </template>
                                            </div>
                                            <p class="pl-warn" x-show="ladderWarn()" x-text="ladderWarn()"></p>
                                        </div>
                                    </template>

                                    <div class="ap-field">
                                        <label>الوصف</label>
                                        <textarea name="description" x-model="description" rows="3" maxlength="1000" class="ap-input"></textarea>
                                    </div>

                                    <div class="ap-field">
                                        <label>المميزات <small>(حتى 12)</small></label>
                                        <div class="pl-feat-list">
                                            <template x-for="(f, i) in features" :key="f.id">
                                                <div class="pl-feat">
                                                    <input type="text" name="features[]" x-model="f.text" maxlength="120"
                                                        class="ap-input" placeholder="اكتب الميزة...">
                                                    <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" aria-label="لفوق"
                                                        @click="move(i, -1)" :disabled="i === 0"><i class="fa-solid fa-arrow-up"></i></button>
                                                    <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" aria-label="لتحت"
                                                        @click="move(i, 1)" :disabled="i === features.length - 1"><i class="fa-solid fa-arrow-down"></i></button>
                                                    <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" aria-label="حذف"
                                                        @click="removeFeature(i)"><i class="fa-solid fa-trash"></i></button>
                                                </div>
                                            </template>
                                        </div>
                                        <button type="button" class="ext-link" @click="addFeature()" x-show="features.length < 12">
                                            <i class="fa-solid fa-plus"></i> إضافة ميزة
                                        </button>
                                    </div>

                                    <template x-if="!plan.is_free">
                                        <div class="ap-field">
                                            <label>المدة الأفضل <small>(بتظهر للأطباء بشارة «الأفضل للأطباء»)</small></label>
                                            <div class="pl-best-pick">
                                                <label class="pl-check">
                                                    <input type="radio" name="best_plan" value="" x-model="bestPlan">
                                                    <span>بدون</span>
                                                </label>
                                                <template x-for="pl in plan.plans" :key="'best' + pl.id">
                                                    <label class="pl-check">
                                                        <input type="radio" name="best_plan" :value="pl.id" x-model="bestPlan">
                                                        <span x-text="pl.label"></span>
                                                    </label>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                </div>
                            </template>
                        </div>

                        <div class="ext-panel__foot">
                            <p class="pl-warn pl-warn--foot" x-show="ladderWarn()" x-text="ladderWarn()"></p>
                            <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy">حفظ التعديلات</button>
                            <button type="button" class="ap-btn ap-btn--ghost" @click="show = false">إلغاء</button>
                        </div>
                    </form>
                </div>
            </template>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra_java'); ?>
    <script src="<?php echo e(asset('js/admin/plans.js')); ?>?v=<?php echo e(@filemtime(public_path('js/admin/plans.js')) ?: time()); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/plans/index.blade.php ENDPATH**/ ?>
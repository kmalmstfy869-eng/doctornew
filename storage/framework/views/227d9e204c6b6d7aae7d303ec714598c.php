<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo e(asset('css/admin/subscriptions.css')); ?>?v=<?php echo e(@filemtime(public_path('css/admin/subscriptions.css')) ?: time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'إدارة الاشتراكات | لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'إدارة الاشتراكات'); ?>
<?php $__env->startSection('page-description', 'متابعة اشتراكات الأطباء وتجديدها وترقية الباقات'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $fmt = fn($n) => \App\Support\Money::fmt($n);
        $today = now('Africa/Cairo')->toDateString();

        // إعادة فتح المودال لو فيه أخطاء (كل مودال له error bag خاص)
        $reopenChange = $errors->subChange->any()
            ? $subs->firstWhere('id', (int) old('sub_id'))?->upgrade_modal
            : null;
        $reopenRenew = $errors->subRenew->any()
            ? $subs->firstWhere('id', (int) old('sub_id'))?->upgrade_modal
            : null;
    ?>

    <div class="sub-page" dir="rtl" x-data>

        
        <div class="dashboard-card ap-card">
            <div class="ap-card__head">
                <div>
                    <h3>اشتراكات الأطباء</h3>
                    <p>كل الباقات المدفوعة (ماعدا المجانية)</p>
                </div>
                <button type="button" class="ap-btn ap-btn--primary" @click="$dispatch('ap-sub-add-open')">
                    <i class="fa-solid fa-plus"></i> إضافة اشتراك
                </button>
            </div>
            <div class="ap-filters">
                <div class="ap-field ap-field--grow">
                    <label>بحث باسم الطبيب</label>
                    <input type="text" id="sub-search" value="<?php echo e($search); ?>" class="ap-input"
                        placeholder="اكتب اسم الطبيب..." autocomplete="off">
                </div>
            </div>
        </div>

        
        <div id="sub-results">

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon green-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="stat-info">
                        <p>اشتراكات سارية</p>
                        <h3><?php echo e($counts['active']); ?></h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon sub-icon-amber"><i class="fa-solid fa-hourglass-half"></i></div>
                    <div class="stat-info">
                        <p>تنتهي خلال <?php echo e($soonDays); ?> أيام</p>
                        <h3><?php echo e($counts['soon']); ?></h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon ap-icon-red"><i class="fa-solid fa-clock-rotate-left"></i></div>
                    <div class="stat-info">
                        <p>منتهية</p>
                        <h3><?php echo e($counts['expired']); ?></h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue-icon"><i class="fa-solid fa-sack-dollar"></i></div>
                    <div class="stat-info">
                        <p>إيراد الاشتراكات (الشهر)</p>
                        <h3 class="ap-plus"><?php echo e($fmt($monthIncome)); ?> ج.م</h3>
                    </div>
                </div>
            </div>

            <div class="dashboard-card ap-card" style="margin-top:1rem">
                <div class="ap-card__head">
                    <div class="sub-tabs">
                        <?php $__currentLoopData = ['all' => 'الكل', 'active' => 'سارية', 'soon' => 'قاربت تنتهي', 'expired' => 'منتهية']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a data-sub-nav
                                href="<?php echo e(route('admin.subscriptions.index', array_filter(['state' => $k === 'all' ? null : $k, 'search' => $search]))); ?>"
                                class="sub-tab <?php echo e($state === $k ? 'is-active' : ''); ?>">
                                <?php echo e($label); ?> <b><?php echo e($counts[$k]); ?></b>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <?php if($subs->isEmpty()): ?>
                    <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-ticket','title' => 'لا توجد اشتراكات','content' => 'مفيش اشتراكات بتطابق البحث أو التبويب دلوقتي.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-ticket','title' => 'لا توجد اشتراكات','content' => 'مفيش اشتراكات بتطابق البحث أو التبويب دلوقتي.']); ?>
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
                                    <th>الطبيب</th>
                                    <th>الباقة</th>
                                    <th>السعر / المدفوع</th>
                                    <th>المدة</th>
                                    <th>الحالة</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $subs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $left = $s->days_left;
                                        $run = $s->is_running;
                                        $st = !$run ? 'expired' : ($left <= $soonDays ? 'soon' : 'ok');
                                        $totalDays = max(1, (int) $s->start_date->diffInDays($s->end_date));
                                        $usedPct = $run ? min(100, max(2, round((1 - $left / $totalDays) * 100))) : 100;
                                        $planPrice = (float) $s->plan->price;
                                        $paid = (float) $s->price;
                                        $disc = max($planPrice - $paid, 0);
                                        $extra = max($paid - $planPrice, 0);
                                        $diffPrice = abs($planPrice - $paid) > 0.009;
                                        $name = $s->doctor?->user?->name ?? '—';
                                        $payload = json_encode($s->upgrade_modal, JSON_UNESCAPED_UNICODE);
                                        // الترقية حسب مستوى الباقة (tier) المحسوب على السيرفر، وليس السعر
                                        $myTier = (int) ($s->upgrade_modal['plan_tier'] ?? -1);
                                        $canUpgrade = $run && $myTier >= 0 && $plans->contains(fn($p) => (int) $p['tier'] > $myTier);
                                    ?>
                                    <tr>
                                        <td data-label="الطبيب">
                                            <div class="sub-doc">
                                                <span class="sub-avatar"><?php echo e(mb_substr($name, 0, 1)); ?></span>
                                                <div>
                                                    <div class="ap-title">د. <?php echo e($name); ?></div>
                                                    <div class="ap-sub"><?php echo e($s->doctor?->specialty?->name ?? 'بدون تخصص'); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="الباقة">
                                            <span class="sub-plan"><?php echo e($s->plan->name); ?></span>
                                            <div class="ap-sub"><?php echo e(round($s->plan->duration / 30)); ?> شهر</div>
                                        </td>
                                        <td data-label="السعر / المدفوع">
                                            <?php if($diffPrice): ?>
                                                <div class="sub-price">
                                                    <div class="sub-price__old">
                                                        <span>سعر الباقة</span>
                                                        <s><?php echo e($fmt($planPrice)); ?> ج.م</s>
                                                    </div>
                                                    <div class="sub-price__paid">
                                                        <span>دفع فعلياً</span>
                                                        <b><?php echo e($fmt($paid)); ?> ج.م</b>
                                                    </div>
                                                    <?php if($disc > 0): ?>
                                                        <span class="sub-price__tag is-disc"><i class="fa-solid fa-arrow-trend-down"></i>
                                                            خصم <?php echo e($fmt($disc)); ?> ج.م</span>
                                                    <?php else: ?>
                                                        <span class="sub-price__tag is-extra"><i class="fa-solid fa-arrow-trend-up"></i>
                                                            زيادة <?php echo e($fmt($extra)); ?> ج.م</span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="sub-price">
                                                    <div class="sub-price__paid">
                                                        <span>دفع (سعر الباقة)</span>
                                                        <b><?php echo e($fmt($paid)); ?> ج.م</b>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td data-label="المدة">
                                            <div class="sub-meter sub-meter--<?php echo e($st); ?>"><span
                                                    style="width: <?php echo e($usedPct); ?>%"></span></div>
                                            <div class="ap-sub">
                                                <?php echo e($s->start_date->translatedFormat('d M Y')); ?> →
                                                <?php echo e($s->end_date->translatedFormat('d M Y')); ?>

                                            </div>
                                        </td>
                                        <td data-label="الحالة">
                                            <?php if($st === 'expired'): ?>
                                                <span class="sub-state sub-state--expired"><i class="fa-solid fa-circle-xmark"></i>
                                                    منتهي</span>
                                            <?php elseif($st === 'soon'): ?>
                                                <span class="sub-state sub-state--soon"><i class="fa-solid fa-hourglass-half"></i>
                                                    باقي <?php echo e($left); ?> يوم</span>
                                            <?php else: ?>
                                                <span class="sub-state sub-state--ok"><i class="fa-solid fa-circle-check"></i>
                                                    باقي <?php echo e($left); ?> يوم</span>
                                            <?php endif; ?>
                                        </td>
                                        <td data-label="">
                                            <div class="sub-actions">
                                                <?php if($canUpgrade): ?>
                                                    <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm"
                                                        data-sub="<?php echo e($payload); ?>"
                                                        @click="$dispatch('ap-sub-change-open', JSON.parse($el.dataset.sub))">
                                                        <i class="fa-solid fa-arrow-up-right-dots"></i> ترقية الباقة
                                                    </button>
                                                <?php endif; ?>
                                                <button type="button"
                                                    class="ap-btn ap-btn--sm <?php echo e($st === 'ok' ? 'ap-btn--ghost' : 'ap-btn--primary'); ?>"
                                                    data-sub="<?php echo e($payload); ?>"
                                                    @click="$dispatch('ap-sub-renew-open', JSON.parse($el.dataset.sub))">
                                                    <i class="fa-solid fa-rotate"></i> تجديد
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="ap-card__foot"><?php echo e($subs->links('vendor.pagination.custom')); ?></div>
                <?php endif; ?>
            </div>
        </div>

        
        <div x-data="apSubAdd()" data-plans="<?php echo e(json_encode($plans)); ?>"
            data-search-url="<?php echo e(route('admin.subscriptions.doctors')); ?>" data-today="<?php echo e($today); ?>"
            data-has-errors="<?php echo e($errors->subAdd->any() ? '1' : '0'); ?>" data-old-doctor-id="<?php echo e(old('doctor_id')); ?>"
            data-old-doctor-name="<?php echo e(old('doctor_name')); ?>" data-old-plan="<?php echo e(old('plan_id')); ?>"
            data-old-start="<?php echo e(old('start_date')); ?>" data-old-amount="<?php echo e(old('amount')); ?>"
            @ap-sub-add-open.window="open()" x-cloak>
            <div x-show="show" class="ap-modal" @click.self="show = false" @keydown.escape.window="show = false">
                <form method="POST" action="<?php echo e(route('admin.subscriptions.store')); ?>"
                    class="dashboard-card ap-modal__panel sub-modal-wide" @submit="busy = true">
                    <?php echo csrf_field(); ?>
                    <div class="ap-modal__head">
                        <h3>إضافة اشتراك لطبيب</h3>
                        <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" @click="show = false">إغلاق</button>
                    </div>

                    <?php if($errors->subAdd->any()): ?>
                        <div class="ap-alert ap-alert--bad" style="margin-bottom:1rem">
                            <ul><?php $__currentLoopData = $errors->subAdd->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($err); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" name="doctor_id" :value="doctor ? doctor.id : ''">
                    <input type="hidden" name="doctor_name" :value="doctor ? doctor.name : ''">
                    <input type="hidden" name="plan_id" :value="planId">

                    <div class="ap-form-grid ap-form-grid--2">
                        <div class="ap-field" style="grid-column:1/-1">
                            <label>الطبيب</label>

                            <div class="sub-picked" x-show="doctor">
                                <span class="sub-avatar" x-text="doctor ? (doctor.name || '').charAt(0) : ''"></span>
                                <strong x-text="doctor ? 'د. ' + doctor.name : ''"></strong>
                                <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm"
                                    @click="doctor = null; search()">تغيير</button>
                            </div>

                            <div x-show="!doctor" class="sub-search">
                                <input type="text" class="ap-input" x-model="q" @input.debounce.300ms="search()"
                                    @focus="search()" placeholder="ابحث باسم الطبيب أو رقم تليفونه..."
                                    autocomplete="off">
                                <div class="sub-search__list" x-show="results.length">
                                    <template x-for="d in results" :key="d.id">
                                        <button type="button" class="sub-search__item" @click="pick(d)">
                                            <span class="sub-avatar" x-text="(d.name || '').charAt(0)"></span>
                                            <span>
                                                <strong x-text="'د. ' + d.name"></strong>
                                                <small x-text="[d.specialty, d.phone].filter(Boolean).join(' • ')"></small>
                                            </span>
                                        </button>
                                    </template>
                                </div>
                                <p class="sub-hint" x-show="searched && !loading && !results.length">
                                    مفيش أطباء مطابقين (أو عنده اشتراك ساري).</p>
                            </div>
                        </div>

                        <div class="ap-field" style="grid-column:1/-1">
                            <label>اختر الباقة</label>
                            <div class="plan-grid">
                                <template x-for="p in plans" :key="p.id">
                                    <button type="button" class="plan-card"
                                        :class="{ 'is-selected': String(p.id) === String(planId) }"
                                        @click="planId = String(p.id); onPlan()">
                                        <span class="plan-card__check"><i class="fa-solid fa-check"></i></span>
                                        <span class="plan-card__name" x-text="p.name"></span>
                                        <span class="plan-card__dur"><i class="fa-regular fa-calendar"></i> <span
                                                x-text="dur(p.duration)"></span></span>
                                        <span class="plan-card__price"><b x-text="money(p.price)"></b> <small>ج.م</small></span>
                                        <span class="plan-card__per"
                                            x-text="'≈ ' + money(p.price / Math.max(1, p.duration / 30)) + ' ج.م / شهر'"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="ap-field">
                            <label>تاريخ البداية</label>
                            <input type="date" name="start_date" x-model="start" class="ap-input" required>
                        </div>
                        <div class="ap-field">
                            <label>المبلغ المدفوع (ج.م)</label>
                            <input type="number" name="amount" x-model="amount" step="0.01" min="0"
                                class="ap-input" required>
                        </div>

                        
                        <div class="sub-paynote" style="grid-column:1/-1"
                            x-show="plan && amount !== '' && amount !== null && Math.abs(Number(amount) - Number(plan.price)) > 0.009"
                            x-transition x-cloak>
                            <div class="sub-paynote__icon"><i class="fa-solid fa-scale-balanced"></i></div>
                            <div class="sub-paynote__body">
                                <strong>المبلغ المدفوع مختلف عن سعر الباقة</strong>
                                <div class="sub-paynote__nums">
                                    <span>سعر الباقة <s x-text="plan ? money(plan.price) + ' ج.م' : ''"></s></span>
                                    <span>المدفوع فعلياً <b x-text="money(amount) + ' ج.م'"></b></span>
                                </div>
                            </div>
                            <span class="sub-paynote__tag"
                                :class="plan && Number(amount) < Number(plan.price) ? 'is-disc' : 'is-extra'"
                                x-text="plan ? (Number(amount) < Number(plan.price)
                                    ? 'خصم ' + money(Number(plan.price) - Number(amount)) + ' ج.م'
                                    : 'زيادة ' + money(Number(amount) - Number(plan.price)) + ' ج.م') : ''"></span>
                        </div>

                        <div class="ap-field" style="grid-column:1/-1">
                            <label>ملاحظة (اختياري)</label>
                            <input type="text" name="note" maxlength="500" class="ap-input"
                                value="<?php echo e(old('note')); ?>">
                        </div>
                    </div>

                    <div class="sub-summary" x-show="plan">
                        <div><span>سعر الباقة</span><b x-text="plan ? money(plan.price) + ' ج.م' : ''"></b></div>
                        <div><span>المدة</span><b x-text="plan ? dur(plan.duration) : ''"></b></div>
                        <div><span>تبدأ من</span><b x-text="start || '—'"></b></div>
                        <div><span>ينتهي في</span><b x-text="end || '—'"></b></div>
                        <div><span>الخصم</span><b x-text="money(discount) + ' ج.م'"></b></div>
                    </div>

                    <div class="ap-modal__foot">
                        <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy || !doctor || !plan">حفظ
                            الاشتراك</button>
                        <button type="button" class="ap-btn ap-btn--ghost" @click="show = false">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>

        
        <div x-data="apSubChange()" data-plans="<?php echo e(json_encode($plans)); ?>" data-today="<?php echo e($today); ?>"
            data-has-errors="<?php echo e($errors->subChange->any() ? '1' : '0'); ?>"
            data-reopen="<?php echo e(json_encode($reopenChange, JSON_UNESCAPED_UNICODE)); ?>" data-old-plan="<?php echo e(old('plan_id')); ?>"
            @ap-sub-change-open.window="open($event.detail)" x-cloak>
            <div x-show="show" class="ap-modal" @click.self="show = false" @keydown.escape.window="show = false">
                <form method="POST" :action="sub && sub.url_change ? sub.url_change : '#'"
                    class="dashboard-card ap-modal__panel sub-modal-wide" @submit="busy = true">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="sub_id" :value="sub ? sub.id : ''">
                    <input type="hidden" name="plan_id" :value="planId">
                    <input type="hidden" name="sub_token" :value="sub ? sub.token : ''">

                    <div class="ap-modal__head">
                        <h3>ترقية الباقة — <span x-text="sub ? 'د. ' + sub.doctor : ''"></span></h3>
                        <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" @click="show = false">إغلاق</button>
                    </div>

                    <?php if($errors->subChange->any()): ?>
                        <div class="ap-alert ap-alert--bad" style="margin-bottom:1rem">
                            <ul><?php $__currentLoopData = $errors->subChange->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($err); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>

                    <template x-if="sub">
                        <div>
                            <div class="sub-summary sub-summary--4">
                                <div><span>الباقة الحالية</span><b x-text="sub.plan_name"></b></div>
                                <div><span>سعرها الحالي</span><b x-text="money(sub.plan_price) + ' ج.م'"></b></div>
                                <div><span>دفع فيها</span><b x-text="money(sub.paid) + ' ج.م'"></b></div>
                                <div><span>باقي</span><b x-text="sub.left + ' يوم'"></b></div>
                            </div>

                            
                            <div class="sub-paynote is-soft" x-show="Math.abs(Number(sub.paid) - Number(sub.plan_price)) > 0.009" x-cloak>
                                <div class="sub-paynote__icon"><i class="fa-solid fa-circle-info"></i></div>
                                <div class="sub-paynote__body">
                                    <strong>الباقة الحالية مدفوعة بسعر مختلف عن سعرها الأصلي</strong>
                                    <div class="sub-paynote__nums">
                                        <span>سعرها <s x-text="money(sub.plan_price) + ' ج.م'"></s></span>
                                        <span>دفع فعلياً <b x-text="money(sub.paid) + ' ج.م'"></b></span>
                                    </div>
                                </div>
                            </div>

                            <div class="ap-form-grid ap-form-grid--2" style="margin-top:1rem">
                                <div class="ap-field" style="grid-column:1/-1">
                                    <label>اختر الباقة الأعلى للترقية</label>
                                    <div class="plan-grid">
                                        <template x-for="p in plans" :key="p.id">
                                            <button type="button" class="plan-card plan-card--tiered"
                                                :class="{
                                                    'is-selected': String(p.id) === String(planId),
                                                    'is-current': isCurrent(p),
                                                    'is-lower': isLower(p),
                                                    'is-up': isUp(p)
                                                }"
                                                :disabled="!isUp(p)"
                                                @click="if (isUp(p)) { planId = String(p.id); onPlan(); }">
                                                <span class="plan-card__check"><i class="fa-solid fa-check"></i></span>

                                                
                                                <span class="plan-card__status plan-card__status--current" x-show="isCurrent(p)">
                                                    <i class="fa-solid fa-bookmark"></i> باقتك الحالية
                                                </span>
                                                <span class="plan-card__status plan-card__status--up" x-show="isUp(p)">
                                                    <i class="fa-solid fa-arrow-up"></i> متاحة للترقية
                                                </span>
                                                <span class="plan-card__status plan-card__status--lower" x-show="isLower(p)">
                                                    <i class="fa-solid fa-lock"></i> غير متاحة للترقية
                                                </span>

                                                <span class="plan-card__body">
                                                    <span class="plan-card__name" x-text="p.name"></span>
                                                    <span class="plan-card__dur"><i class="fa-regular fa-calendar"></i> <span
                                                            x-text="dur(p.duration)"></span></span>
                                                    <span class="plan-card__price"><b x-text="money(p.price)"></b>
                                                        <small>ج.م</small></span>
                                                    <span class="plan-card__per"
                                                        x-text="'≈ ' + money(p.price / Math.max(1, p.duration / 30)) + ' ج.م / شهر'"></span>
                                                </span>

                                                <span class="plan-card__reason" x-show="isLower(p)" x-text="lockReason(p)"></span>
                                            </button>
                                        </template>
                                    </div>

                                </div>

                                <template x-if="plan">
                                    <div class="sub-diff" style="grid-column:1/-1">
                                        <div><span>سعر الباقة الجديدة</span><b x-text="money(plan.price) + ' ج.م'"></b></div>
                                        <div><span>المدة المتبقية في الاشتراك الحالي</span><b x-text="sub.left + ' يوم'"></b></div>
                                        <div><span>الرصيد المتبقي من الاشتراك السابق</span><b x-text="'− ' + money(creditUsed) + ' ج.م'"></b></div>
                                        <div class="is-total"><span>المبلغ المطلوب دفعه الآن</span><b x-text="money(due) + ' ج.م'"></b></div>
                                        <div><span>سعر التجديدات القادمة</span><b x-text="money(plan.price) + ' ج.م'"></b></div>
                                        <div><span>ينتهي الاشتراك الجديد في</span><b x-text="end || '—'"></b></div>
                                    </div>
                                </template>

                                <div class="sub-paynote is-soft" style="grid-column:1/-1" x-show="plan && bonusDays > 0" x-cloak>
                                    <div class="sub-paynote__icon"><i class="fa-solid fa-gift"></i></div>
                                    <div class="sub-paynote__body">
                                        <strong>الرصيد المتبقي أكبر من سعر الباقة الجديدة</strong>
                                        <div class="sub-paynote__nums">
                                            <span>الزيادة تتحول إلى <b x-text="bonusDays + ' يوم إضافي'"></b> في الاشتراك الجديد</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="ap-field" style="grid-column:1/-1">
                                    <label>ملاحظة (اختياري)</label>
                                    <input type="text" name="note" maxlength="500" class="ap-input"
                                        value="<?php echo e(old('note')); ?>">
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="ap-modal__foot">
                        <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy || !plan"
                            x-text="plan ? ('تأكيد الترقية ودفع ' + money(due) + ' ج.م') : 'تأكيد الترقية'"></button>
                        <button type="button" class="ap-btn ap-btn--ghost" @click="show = false">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>

        
        <div x-data="apSubRenew()" data-plans="<?php echo e(json_encode($plans)); ?>" data-today="<?php echo e($today); ?>"
            data-has-errors="<?php echo e($errors->subRenew->any() ? '1' : '0'); ?>"
            data-reopen="<?php echo e(json_encode($reopenRenew, JSON_UNESCAPED_UNICODE)); ?>" data-old-plan="<?php echo e(old('plan_id')); ?>"
            data-old-start="<?php echo e(old('start_date')); ?>" data-old-amount="<?php echo e(old('amount')); ?>"
            @ap-sub-renew-open.window="open($event.detail)" x-cloak>
            <div x-show="show" class="ap-modal" @click.self="show = false" @keydown.escape.window="show = false">
                <form method="POST" :action="sub && sub.url_renew ? sub.url_renew : '#'"
                    class="dashboard-card ap-modal__panel sub-modal-wide" @submit="busy = true">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="sub_id" :value="sub ? sub.id : ''">
                    <input type="hidden" name="plan_id" :value="planId">

                    <div class="ap-modal__head">
                        <h3>تجديد الاشتراك — <span x-text="sub ? 'د. ' + sub.doctor : ''"></span></h3>
                        <button type="button" class="ap-btn ap-btn--ghost ap-btn--sm" @click="show = false">إغلاق</button>
                    </div>

                    <?php if($errors->subRenew->any()): ?>
                        <div class="ap-alert ap-alert--bad" style="margin-bottom:1rem">
                            <ul><?php $__currentLoopData = $errors->subRenew->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($err); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>

                    <template x-if="sub">
                        <div>
                            <div class="sub-summary sub-summary--3">
                                <div><span>الباقة الحالية</span><b x-text="sub.plan_name"></b></div>
                                <div><span>ينتهي في</span><b x-text="sub.end || '—'"></b></div>
                                <div><span>الحالة</span><b
                                        :class="sub.running ? 'sub-ok-text' : 'sub-bad-text'"
                                        x-text="sub.running ? ('باقي ' + sub.days_left + ' يوم') : 'منتهي'"></b></div>
                            </div>

                            <div class="ap-form-grid ap-form-grid--2" style="margin-top:1rem">
                                <div class="ap-field" style="grid-column:1/-1" x-show="!sub.running">
                                    <label>اختر باقة التجديد</label>
                                    <div class="plan-grid">
                                        <template x-for="p in plans" :key="p.id">
                                            <button type="button" class="plan-card"
                                                :class="{ 'is-selected': String(p.id) === String(planId) }"
                                                @click="planId = String(p.id); onPlan()">
                                                <span class="plan-card__check"><i class="fa-solid fa-check"></i></span>
                                                <span class="plan-card__name" x-text="p.name"></span>
                                                <span class="plan-card__dur"><i class="fa-regular fa-calendar"></i> <span
                                                        x-text="dur(p.duration)"></span></span>
                                                <span class="plan-card__price"><b x-text="money(p.price)"></b>
                                                    <small>ج.م</small></span>
                                                <span class="plan-card__per"
                                                    x-text="'≈ ' + money(p.price / Math.max(1, p.duration / 30)) + ' ج.م / شهر'"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                                <div class="ap-field" x-show="!sub.running">
                                    <label>تاريخ بداية التجديد</label>
                                    <input type="date" name="start_date" x-model="start" class="ap-input"
                                        :required="!sub.running">
                                </div>
                                <div class="ap-field">
                                    <label>المبلغ المدفوع (ج.م)</label>
                                    <input type="number" name="amount" x-model="amount" step="0.01" min="0"
                                        class="ap-input" required>
                                </div>

                                
                                <div class="sub-paynote" style="grid-column:1/-1"
                                    x-show="plan && amount !== '' && amount !== null && Math.abs(Number(amount) - Number(plan.price)) > 0.009"
                                    x-transition x-cloak>
                                    <div class="sub-paynote__icon"><i class="fa-solid fa-scale-balanced"></i></div>
                                    <div class="sub-paynote__body">
                                        <strong>المبلغ المدفوع مختلف عن سعر الباقة</strong>
                                        <div class="sub-paynote__nums">
                                            <span>سعر الباقة <s x-text="plan ? money(plan.price) + ' ج.م' : ''"></s></span>
                                            <span>المدفوع فعلياً <b x-text="money(amount) + ' ج.م'"></b></span>
                                        </div>
                                    </div>
                                    <span class="sub-paynote__tag"
                                        :class="plan && Number(amount) < Number(plan.price) ? 'is-disc' : 'is-extra'"
                                        x-text="plan ? (Number(amount) < Number(plan.price)
                                            ? 'خصم ' + money(Number(plan.price) - Number(amount)) + ' ج.م'
                                            : 'زيادة ' + money(Number(amount) - Number(plan.price)) + ' ج.م') : ''"></span>
                                </div>

                                <div class="ap-field" style="grid-column:1/-1">
                                    <label>ملاحظة (اختياري)</label>
                                    <input type="text" name="note" maxlength="500" class="ap-input"
                                        value="<?php echo e(old('note')); ?>">
                                </div>
                            </div>

                            <div class="sub-summary" x-show="plan" style="margin-top:1rem">
                                <div><span>سعر الباقة</span><b x-text="plan ? money(plan.price) + ' ج.م' : ''"></b></div>
                                <div><span>المدة المضافة</span><b x-text="plan ? dur(plan.duration) : ''"></b></div>
                                <div><span>يبدأ التجديد من</span><b x-text="(sub.running ? sub.end : start) || '—'"></b></div>
                                <div><span>ينتهي بعد التجديد</span><b x-text="end || '—'"></b></div>
                                <div><span>الخصم</span><b x-text="money(discount) + ' ج.م'"></b></div>
                            </div>
                        </div>
                    </template>

                    <div class="ap-modal__foot">
                        <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy || !plan">تأكيد التجديد
                            وتسجيله في المالية</button>
                        <button type="button" class="ap-btn ap-btn--ghost" @click="show = false">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('extra_java'); ?>
    <script
        src="<?php echo e(asset('js/admin/subscriptions.js')); ?>?v=<?php echo e(@filemtime(public_path('js/admin/subscriptions.js')) ?: time()); ?>">
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/subscriptions/index.blade.php ENDPATH**/ ?>
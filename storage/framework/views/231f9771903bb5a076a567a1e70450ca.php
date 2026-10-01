<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['notifications']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['notifications']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="panel" id="notifications">


    <div class="panel-head">

        <div class="panel-title">

            <strong>
                الإشعارات
            </strong>

            <span>
                آخر التنبيهات والتحديثات الخاصة بحسابك
            </span>

        </div>


        <a href="<?php echo e(route('doctor.notifications.index')); ?>" class="account-action secondary">

            عرض جميع الاشعارات
        </a>

    </div>


    <div class="notifications">

        <?php if(isset($notifications) && $notifications->count()): ?>

            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('doctor.notifications.read', $notification->id)); ?>"
                    class="notification-item <?php echo e(!$notification->is_read ? 'unread' : ''); ?>">

                    <div class="notification-icon">
                        <i class="fa-solid fa-bell"></i>
                    </div>


                    <div class="notification-content">

                        <strong>
                            <?php echo e($notification->title); ?>

                        </strong>

                        <span>
                            <?php echo e($notification->message); ?>

                        </span>

                    </div>


                    <div class="notification-meta">

                        <div class="notification-time">
                            <?php echo e($notification->created_at?->diffForHumans()); ?>

                        </div>


                        <?php if($notification->is_read): ?>
                            <button type="button" class="notification-read"
                                onclick="event.preventDefault(); event.stopPropagation(); showToast('تم تعليم الإشعار كمقروء')"
                                title="تعليم كمقروء">
                                ✓
                            </button>
                        <?php endif; ?>

                    </div>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-bell','title' => 'أنت على اطلاع بكل شيء','content' => 'لا توجد إشعارات جديدة حاليًا. سنخبرك هنا بأي تحديث مهم يخص حسابك أو ملفك الطبي.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-bell','title' => 'أنت على اطلاع بكل شيء','content' => 'لا توجد إشعارات جديدة حاليًا. سنخبرك هنا بأي تحديث مهم يخص حسابك أو ملفك الطبي.']); ?>
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
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/dashboard/norification.blade.php ENDPATH**/ ?>
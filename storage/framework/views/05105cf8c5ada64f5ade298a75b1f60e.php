<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="bq-no-print"> <?php echo $__env->yieldContent('title'); ?> </title>
    <meta name="description" content="ملخص يومي لحالة العيادة: الحجوزات، الطابور، المواعيد والإيرادات.">
    <meta property="og:title" content="لوحة التحكم">
    <meta property="og:description" content="ملخص يومي لحالة العيادة: الحجوزات، الطابور، المواعيد والإيرادات.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="<?php echo e(asset('logo/favicon.png')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('logo/favicon.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('logo/favicon.png')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/clinic/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/base/tokens.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/clinic/theme.css')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/clinic/responsive.css')); ?>">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    <?php echo $__env->yieldPushContent('extra_style'); ?>
</head>

<body class="min-h-screen w-full overflow-x-hidden bg-background text-foreground">
<?php if (isset($component)) { $__componentOriginala8f550a34e28b6945cc8aaed05b19904 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8f550a34e28b6945cc8aaed05b19904 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.info.flash-message','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.info.flash-message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8f550a34e28b6945cc8aaed05b19904)): ?>
<?php $attributes = $__attributesOriginala8f550a34e28b6945cc8aaed05b19904; ?>
<?php unset($__attributesOriginala8f550a34e28b6945cc8aaed05b19904); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8f550a34e28b6945cc8aaed05b19904)): ?>
<?php $component = $__componentOriginala8f550a34e28b6945cc8aaed05b19904; ?>
<?php unset($__componentOriginala8f550a34e28b6945cc8aaed05b19904); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginaldb4b9618127dce7cebb6daef00ff88b0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldb4b9618127dce7cebb6daef00ff88b0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldb4b9618127dce7cebb6daef00ff88b0)): ?>
<?php $attributes = $__attributesOriginaldb4b9618127dce7cebb6daef00ff88b0; ?>
<?php unset($__attributesOriginaldb4b9618127dce7cebb6daef00ff88b0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldb4b9618127dce7cebb6daef00ff88b0)): ?>
<?php $component = $__componentOriginaldb4b9618127dce7cebb6daef00ff88b0; ?>
<?php unset($__componentOriginaldb4b9618127dce7cebb6daef00ff88b0); ?>
<?php endif; ?>
    <div id="drawer-overlay" class="clinic-no-print fixed inset-0 z-40 hidden bg-foreground/45 lg:hidden"
        style="backdrop-filter:blur(2px)">
    </div>

    <div class="clinic-content-area">

        <?php if (isset($component)) { $__componentOriginale528c23e2bec95f56f2976dc948a49a7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale528c23e2bec95f56f2976dc948a49a7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale528c23e2bec95f56f2976dc948a49a7)): ?>
<?php $attributes = $__attributesOriginale528c23e2bec95f56f2976dc948a49a7; ?>
<?php unset($__attributesOriginale528c23e2bec95f56f2976dc948a49a7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale528c23e2bec95f56f2976dc948a49a7)): ?>
<?php $component = $__componentOriginale528c23e2bec95f56f2976dc948a49a7; ?>
<?php unset($__componentOriginale528c23e2bec95f56f2976dc948a49a7); ?>
<?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>

    </div>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="<?php echo e(asset('js/clinic/app.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('extra_java'); ?>
</body>

</html>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/layouts/app_clinc.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b1020">

    <title><?php echo $__env->yieldContent('title'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('logo/favicon.png')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('logo/favicon.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('logo/favicon.png')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/app.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/sidebar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/base/tokens.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/theme.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/responsive.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/readability/app.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/readability/sidebar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/ux.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <?php echo $__env->yieldPushContent('extra_style'); ?>
</head>


<body>

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

    <div class="app">

        <div class="background">
            <div class="grid-bg"></div>
            <div class="blob one"></div>
            <div class="blob two"></div>
        </div>


        <div class="overlay" id="overlay" onclick="closeSidebar()">
        </div>

        <?php if (isset($component)) { $__componentOriginal7307eba7767d55b43cc5fa67060b8701 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7307eba7767d55b43cc5fa67060b8701 = $attributes; } ?>
<?php $component = App\View\Components\Doctor\Dashboard\Sidebar::resolve(['doctor' => $doctor,'doctorname' => $doctor_name] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.dashboard.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Doctor\Dashboard\Sidebar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7307eba7767d55b43cc5fa67060b8701)): ?>
<?php $attributes = $__attributesOriginal7307eba7767d55b43cc5fa67060b8701; ?>
<?php unset($__attributesOriginal7307eba7767d55b43cc5fa67060b8701); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7307eba7767d55b43cc5fa67060b8701)): ?>
<?php $component = $__componentOriginal7307eba7767d55b43cc5fa67060b8701; ?>
<?php unset($__componentOriginal7307eba7767d55b43cc5fa67060b8701); ?>
<?php endif; ?>

        <main class="main">

            <?php if (isset($component)) { $__componentOriginal021ab777a509e8ac4a3f20fcd78311de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal021ab777a509e8ac4a3f20fcd78311de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.dashboard.header','data' => ['doctor' => $doctor,'doctorname' => $doctor_name,'notifications' => $notificationsheader]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.dashboard.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['doctor' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($doctor),'doctorname' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($doctor_name),'notifications' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notificationsheader)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal021ab777a509e8ac4a3f20fcd78311de)): ?>
<?php $attributes = $__attributesOriginal021ab777a509e8ac4a3f20fcd78311de; ?>
<?php unset($__attributesOriginal021ab777a509e8ac4a3f20fcd78311de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal021ab777a509e8ac4a3f20fcd78311de)): ?>
<?php $component = $__componentOriginal021ab777a509e8ac4a3f20fcd78311de; ?>
<?php unset($__componentOriginal021ab777a509e8ac4a3f20fcd78311de); ?>
<?php endif; ?>


            <?php echo $__env->yieldContent('content'); ?>

            <?php if (isset($component)) { $__componentOriginala81a2311028b266cb9e7c51efcab8f14 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala81a2311028b266cb9e7c51efcab8f14 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.dashboard.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.dashboard.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala81a2311028b266cb9e7c51efcab8f14)): ?>
<?php $attributes = $__attributesOriginala81a2311028b266cb9e7c51efcab8f14; ?>
<?php unset($__attributesOriginala81a2311028b266cb9e7c51efcab8f14); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala81a2311028b266cb9e7c51efcab8f14)): ?>
<?php $component = $__componentOriginala81a2311028b266cb9e7c51efcab8f14; ?>
<?php unset($__componentOriginala81a2311028b266cb9e7c51efcab8f14); ?>
<?php endif; ?>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/layouts/app.blade.php ENDPATH**/ ?>
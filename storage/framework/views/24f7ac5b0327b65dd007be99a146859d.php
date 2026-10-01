<?php $__env->startSection('title', ' الصفحة الرئيسية|لوحة تحكم الطبيب'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/topbar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/account&notification.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/subscription.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/no_results.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/readability/topbar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/readability/account-notification.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/readability/subscription.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal6dbffe04897c1afba1436b5a93e7af4e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6dbffe04897c1afba1436b5a93e7af4e = $attributes; } ?>
<?php $component = App\View\Components\Doctor\Dashboard\Topbar::resolve(['doctor' => $doctor,'doctorname' => $doctor_name] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.dashboard.topbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Doctor\Dashboard\Topbar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6dbffe04897c1afba1436b5a93e7af4e)): ?>
<?php $attributes = $__attributesOriginal6dbffe04897c1afba1436b5a93e7af4e; ?>
<?php unset($__attributesOriginal6dbffe04897c1afba1436b5a93e7af4e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6dbffe04897c1afba1436b5a93e7af4e)): ?>
<?php $component = $__componentOriginal6dbffe04897c1afba1436b5a93e7af4e; ?>
<?php unset($__componentOriginal6dbffe04897c1afba1436b5a93e7af4e); ?>
<?php endif; ?>


    <section class="account-grid">

        <?php if (isset($component)) { $__componentOriginalcce49ee99bad4ae8a1da4c9b45ef189d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcce49ee99bad4ae8a1da4c9b45ef189d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.dashboard.acount','data' => ['doctor' => $doctor,'doctorname' => $doctor_name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.dashboard.acount'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['doctor' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($doctor),'doctorname' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($doctor_name)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcce49ee99bad4ae8a1da4c9b45ef189d)): ?>
<?php $attributes = $__attributesOriginalcce49ee99bad4ae8a1da4c9b45ef189d; ?>
<?php unset($__attributesOriginalcce49ee99bad4ae8a1da4c9b45ef189d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcce49ee99bad4ae8a1da4c9b45ef189d)): ?>
<?php $component = $__componentOriginalcce49ee99bad4ae8a1da4c9b45ef189d; ?>
<?php unset($__componentOriginalcce49ee99bad4ae8a1da4c9b45ef189d); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal0d6bedc8292d8d00c9b61c8d062ef93f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0d6bedc8292d8d00c9b61c8d062ef93f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.dashboard.norification','data' => ['notifications' => $notifications]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.dashboard.norification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['notifications' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($notifications)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0d6bedc8292d8d00c9b61c8d062ef93f)): ?>
<?php $attributes = $__attributesOriginal0d6bedc8292d8d00c9b61c8d062ef93f; ?>
<?php unset($__attributesOriginal0d6bedc8292d8d00c9b61c8d062ef93f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d6bedc8292d8d00c9b61c8d062ef93f)): ?>
<?php $component = $__componentOriginal0d6bedc8292d8d00c9b61c8d062ef93f; ?>
<?php unset($__componentOriginal0d6bedc8292d8d00c9b61c8d062ef93f); ?>
<?php endif; ?>

    </section>

    <?php if (isset($component)) { $__componentOriginal704fcd5fecafbaf4b82c7590ff0485f9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal704fcd5fecafbaf4b82c7590ff0485f9 = $attributes; } ?>
<?php $component = App\View\Components\Doctor\Dashboard\Subscription::resolve(['doctor' => $doctor] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.dashboard.subscription'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Doctor\Dashboard\Subscription::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal704fcd5fecafbaf4b82c7590ff0485f9)): ?>
<?php $attributes = $__attributesOriginal704fcd5fecafbaf4b82c7590ff0485f9; ?>
<?php unset($__attributesOriginal704fcd5fecafbaf4b82c7590ff0485f9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal704fcd5fecafbaf4b82c7590ff0485f9)): ?>
<?php $component = $__componentOriginal704fcd5fecafbaf4b82c7590ff0485f9; ?>
<?php unset($__componentOriginal704fcd5fecafbaf4b82c7590ff0485f9); ?>
<?php endif; ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/dashboard/index.blade.php ENDPATH**/ ?>
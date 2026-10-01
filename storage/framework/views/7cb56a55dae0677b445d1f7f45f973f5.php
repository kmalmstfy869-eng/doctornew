<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>
        <?php echo $__env->yieldContent('title', 'لوحة الإدارة | دليل الأطباء'); ?>
    </title>


    

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <?php echo $__env->yieldPushContent('extra_style'); ?>

    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    

    <link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin/edit.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/ratings.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home/settings.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/base/tokens.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin/theme.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin/responsive.css')); ?>">

</head>


<body>


    

    <aside class="sidebar">


        

        <div class="sidebar-logo">

            <div class="logo-icon">

                <i class="fa-solid fa-heart-pulse"></i>

            </div>

            <div class="logo-text">

                <h2>
                    دليل الأطباء
                </h2>

                <p>
                    لوحة الإدارة والتحكم
                </p>

            </div>

        </div>


        

        <div class="menu-title">

            القائمة الرئيسية

        </div>


        <ul class="sidebar-menu">


            

            <li>

                <a href="<?php echo e(route('admin.dashboard')); ?>"
                    class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">

                    <i class="fa-solid fa-chart-pie"></i>

                    <span>
                        لوحة التحكم
                    </span>

                </a>

            </li>


            

            <li class="doctors-menu">

                <details
                    <?php echo e(request()->routeIs('admin.subscribed_doctors.*') ||
                    request()->routeIs('admin.unsubscribed_doctors.*') ||
                    request()->routeIs('admin.rejected_doctors.*') ||
                    request()->routeIs('admin.pending_doctors.*') ||
                    request()->routeIs('admin.doctor.create')
                        ? 'open'
                        : ''); ?>>

                    <summary class="doctors-menu-btn">

                        <span class="menu-button-content">

                            <i class="fa-solid fa-user-doctor"></i>

                            <span>
                                إدارة الأطباء
                            </span>

                        </span>

                        <i class="fa-solid fa-chevron-down doctors-arrow"></i>

                    </summary>


                    <ul class="doctors-submenu">


                        <li>

                            <a href="<?php echo e(route('admin.subscribed_doctors.index')); ?>"
                                class="<?php echo e(request()->routeIs('admin.subscribed_doctors.*') ? 'submenu-active' : ''); ?>">

                                <i class="fa-solid fa-user-doctor"></i>

                                <span>
                                    الأطباء المشتركين
                                </span>

                            </a>

                        </li>


                        <li>

                            <a href="<?php echo e(route('admin.unsubscribed_doctors.index')); ?>"
                                class="<?php echo e(request()->routeIs('admin.unsubscribed_doctors.*') ? 'submenu-active' : ''); ?>">

                                <i class="fa-solid fa-users"></i>

                                <span>
                                    الأطباء غير المشتركين
                                </span>

                            </a>

                        </li>



                        <li>

                            <a href="<?php echo e(route('admin.rejected_doctors.index')); ?>"
                                class="<?php echo e(request()->routeIs('admin.rejected_doctors.*') ? 'submenu-active' : ''); ?>">

                                <i class="fa-solid fa-circle-xmark"></i>

                                <span>
                                    الأطباء المرفوضون
                                </span>

                            </a>

                        </li>



                        <li>

                            <a href="<?php echo e(route('admin.pending_doctors.index')); ?>"
                                class="<?php echo e(request()->routeIs('admin.pending_doctors.*') ? 'submenu-active' : ''); ?>">

                                <i class="fa-solid fa-clock"></i>

                                <span>
                                    طلبات الانضمام
                                </span>

                            </a>

                        </li>

                        <li>

                            <a href="<?php echo e(route('admin.doctor.create')); ?>"
                                class="<?php echo e(request()->routeIs('admin.doctor.create') ? 'submenu-active' : ''); ?>">

                                <i class="fa-solid fa-user-plus"></i>

                                <span>
                                    إضافة طبيب
                                </span>

                            </a>

                        </li>


                    </ul>

                </details>

            </li>




            

            <li class="doctors-menu">

                <details
                    <?php echo e(request()->routeIs('admin.subscriptions.*') || request()->routeIs('admin.plans.*') ? 'open' : ''); ?>>

                    <summary class="doctors-menu-btn">

                        <span class="menu-button-content">

                            <i class="fa-solid fa-credit-card"></i>

                            <span>
                                الاشتراكات
                            </span>

                        </span>

                        <i class="fa-solid fa-chevron-down doctors-arrow"></i>

                    </summary>


                    <ul class="doctors-submenu">


                        

                        <li>

                            <a 
                                class="<?php echo e(request()->routeIs('admin.subscriptions.*') ? 'submenu-active' : ''); ?>">

                                <i class="fa-solid fa-user-doctor"></i>

                                <span>
                                    اشتراكات الأطباء
                                </span>

                            </a>

                        </li>


                        

                        <li>

                            <a 
                                class="<?php echo e(request()->routeIs('admin.plans.*') ? 'submenu-active' : ''); ?>">

                                <i class="fa-solid fa-layer-group"></i>

                                <span>
                                    الباقات
                                </span>

                            </a>

                        </li>


                        

                        <li>

                            <a 
                                class="<?php echo e(request()->routeIs('admin.subscription_income.*') ? 'submenu-active' : ''); ?>">

                                <i class="fa-solid fa-money-bill-trend-up"></i>

                                <span>
                                    دخل الاشتراكات
                                </span>

                            </a>

                        </li>


                    </ul>

                </details>

            </li>



            <li>

                <a href="<?php echo e(route('admin.specialties.index')); ?>"
                    class="<?php echo e(request()->routeIs('admin.specialties.*') ? 'active' : ''); ?>">

                    <i class="fa-solid fa-stethoscope"></i>

                    <span>
                        التخصصات
                    </span>

                </a>

            </li>

            <li>

                <a href="<?php echo e(route('admin.areas.index')); ?>"
                    class="<?php echo e(request()->routeIs('admin.areas.*') ? 'active' : ''); ?>">

                    <i class="fa-solid fa-location-dot"></i>

                    <span>
                        المناطق
                    </span>

                </a>

            </li>




            <li>

                <a href="<?php echo e(route('ratings.index')); ?>" class="<?php echo e(request()->routeIs('ratings.*') ? 'active' : ''); ?>">

                    <i class="fa-solid fa-star"></i>

                    <span>
                        التقييمات
                    </span>

                </a>

            </li>


            

            <li>

                <a
                    href="<?php echo e(route('admin.jobs.index')); ?>"class="<?php echo e(request()->routeIs('admin.jobs.*') || request()->routeIs('admin.user.jobs') ? 'active' : ''); ?>">

                    <i class="fa-solid fa-briefcase"></i>

                    <span>
                        الوظائف
                    </span>

                </a>

            </li>


            

<li>

    <a href="<?php echo e(route('admin.users')); ?>"
        class="<?php echo e(request()->routeIs('admin.users') ? 'active' : ''); ?>">

        <i class="fa-solid fa-users"></i>

        <span>
            المستخدمون
        </span>

    </a>

</li>




<li>

    <a href="<?php echo e(route('admin.contact')); ?>"
        class="<?php echo e(request()->routeIs('admin.contact') ? 'active' : ''); ?>">

        <i class="fa-solid fa-envelope"></i>

        <span>
            رسائل المستخدمين
        </span>

        <?php if(($messagesCount ?? 0) > 0): ?>

            <span class="sidebar-badge">
                <?php echo e($messagesCount > 99 ? '99+' : $messagesCount); ?>

            </span>

        <?php endif; ?>

    </a>

</li>




<li>

    <a href="<?php echo e(route('admin.notifications')); ?>"
        class="<?php echo e(request()->routeIs('admin.notifications') ? 'active' : ''); ?>">

        <i class="fa-solid fa-bell"></i>

        <span>
            الإشعارات
        </span>

    </a>

</li>
            

            <li>

                <a href="<?php echo e(route('admin.profile_admin')); ?>"
                    class="<?php echo e(request()->routeIs('admin.profile_admin') ? 'active' : ''); ?>">

                    <i class="fa-solid fa-gear"></i>

                    <span>
                        الإعدادات
                    </span>

                </a>

            </li>


        </ul>


        

        <div class="sidebar-bottom">

            <div class="admin-box">


                <div class="admin-avatar">

                    <i class="fa-solid fa-user-shield"></i>

                </div>


                <div class="admin-data">

                    <h4>
                        <?php echo e(Auth::user()->name ?? 'مدير النظام'); ?>

                    </h4>

                    <p>
                        مدير النظام
                    </p>

                </div>


                <form method="POST" action="<?php echo e(route('logout')); ?>">

                    <?php echo csrf_field(); ?>

                    <button type="submit" class="logout-btn" title="تسجيل الخروج">

                        <i class="fa-solid fa-right-from-bracket"></i>

                    </button>

                </form>


            </div>

        </div>


    </aside>

    <div class="admin-sidebar-overlay" id="adminSidebarOverlay" hidden></div>

    

    <main class="main-content">


        

        <header class="top-header">


            

            <div class="header-right">


                

                <button type="button" class="mobile-menu" id="mobileMenuButton" aria-label="فتح القائمة" aria-expanded="false">

                    <i class="fa-solid fa-bars"></i>

                </button>


                

                <div class="header-title">

                    <h1>
                        <?php echo $__env->yieldContent('page-title', 'لوحة التحكم'); ?>
                    </h1>

                    <p>
                        <?php echo $__env->yieldContent('page-description', 'إدارة ومتابعة منصة دليل الأطباء'); ?>
                    </p>

                </div>


            </div>



            

            <div class="header-actions">


                

                <button type="button" class="theme-toggle" id="themeButton" title="تغيير المظهر"
                    aria-label="تغيير المظهر">

                    <i class="fa-solid fa-moon" id="themeIcon"></i>

                </button>


                

                <button type="button" class="header-btn" title="الإشعارات">

                    <i class="fa-regular fa-bell"></i>

                    <?php if(($notificationsCount ?? 0) > 0): ?>
                        <span class="notification-dot"></span>
                    <?php endif; ?>

                </button>


                

                <div class="admin-header">


                    <div class="admin-header-avatar">

                        <i class="fa-solid fa-user-shield"></i>

                    </div>


                    <div class="admin-header-text">

                        <h4>
                            <?php echo e(Auth::user()->name ?? 'مدير النظام'); ?>

                        </h4>

                        <p>
                            مدير النظام
                        </p>

                    </div>


                </div>


            </div>


        </header>



        
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


        <div class="dashboard-content">

            <?php echo $__env->yieldContent('content'); ?>

        </div>


    </main>



    
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="<?php echo e(asset('js/app_admin.js')); ?>"></script>
    <script src="<?php echo e(asset('js/core/admin-nav.js')); ?>"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="<?php echo e(asset('sw.js')); ?>"></script>




</body>

</html>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/layout/app.blade.php ENDPATH**/ ?>
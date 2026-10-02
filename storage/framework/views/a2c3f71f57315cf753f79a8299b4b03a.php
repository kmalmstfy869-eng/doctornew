<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>
        <?php echo $__env->yieldContent('title', 'دليل الأطباء'); ?>
    </title>


    
    <link rel="icon" type="image/png" href="<?php echo e(asset('logo/favicon.png')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('logo/favicon.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('logo/favicon.png')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/home/doctor_details.css')); ?>">

    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">




    <link rel="stylesheet" href="<?php echo e(asset('css/home/test.css')); ?>">





    <link rel="stylesheet" href="<?php echo e(asset('css/auth/auth.css')); ?>">

    
    <link rel="stylesheet" href="<?php echo e(asset('css/home/settings.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/base/tokens.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/layouts/public-nav.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/theme.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/responsive.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/refine.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/type-scale.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/cards-doctor.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/cards-job.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/doctor-profile.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/job-details.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/auth-pages.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/job-form.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/contact.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/public/ui-enhancements.css')); ?>">

    <?php echo $__env->yieldPushContent('styles'); ?>

</head>


<body>



    <div class="top-bar">

        <div class="site-container top-bar-content">


            <div class="top-bar-info">

                <span>

                    <i class="fa-solid fa-shield-heart"></i>

                    منصة طبية موثوقة

                </span>


                <span>

                    <i class="fa-solid fa-location-dot"></i>

                    ابحث عن الأطباء في محافظتك

                </span>

            </div>



            <div class="top-bar-links">

                <a href="<?php echo e(route('contact.index')); ?>">
                    تواصل معنا
                </a>

                <a href="<?php echo e(route('faq')); ?>">
                    الأسئلة الشائعة
                </a>



            </div>


        </div>

    </div>



    

    <header class="site-header">

        <div class="site-container header-content">


            

            <a href="<?php echo e(route('home')); ?>" class="site-logo">


                <div class="site-logo-icon">

                    <i class="fa-solid fa-heart-pulse"></i>

                </div>


                <div class="site-logo-text">

                    <h1>
                        دليل الأطباء
                    </h1>

                    <p>
                        طبيبك أقرب مما تتخيل
                    </p>

                </div>


            </a>



            

            <nav class="main-navigation">


                <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">

                    الرئيسية

                </a>


                <a href="<?php echo e(route('specialties.index')); ?>"
                    class="<?php echo e(request()->routeIs('specialties.index') ? 'active' : ''); ?>">

                    التخصصات

                </a>


                <a href="<?php echo e(route('doctors.index')); ?>"
                    class="<?php echo e(request()->routeIs('doctors.*', 'specialties.show') ? 'active' : ''); ?>">

                    الأطباء

                </a>


                <a href="<?php echo e(route('jobs.index')); ?>" class="<?php echo e(request()->routeIs('jobs.*') ? 'active' : ''); ?>">

                    الوظائف

                </a>


                <a href="<?php echo e(route('about')); ?>" class="<?php echo e(request()->routeIs('about') ? 'active' : ''); ?>">

                    من نحن

                </a>


            </nav>



            

            <div class="header-actions">

                <button type="button" class="public-nav-toggle" id="publicNavToggle" aria-label="فتح القائمة"
                    aria-expanded="false" aria-controls="publicMobileNav">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <button type="button" class="theme-toggle" id="themeButton" aria-label="تغيير وضع الموقع">

                    <i class="fa-solid fa-moon" id="themeIcon">
                    </i>

                </button>


                <?php if(auth()->guard()->check()): ?>

                    <div class="header-user">


                        <a href="<?php echo e(route('profile')); ?>" class="header-profile-button" title="الملف الشخصي">

                            <i class="fa-solid fa-user"></i>

                            <span>
                                الملف الشخصي
                            </span>

                        </a>


                        

                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="logout-form">

                            <?php echo csrf_field(); ?>

                            <button type="submit" class="header-logout-button">

                                <i class="fa-solid fa-right-from-bracket"></i>

                                <span>
                                    تسجيل الخروج
                                </span>

                            </button>

                        </form>

                    </div>

                <?php endif; ?>







                <?php if(auth()->guard()->guest()): ?>


                    <a href="<?php echo e(route('login')); ?>" class="header-login-button">

                        تسجيل الدخول

                    </a>



                <?php endif; ?>


                <?php if(isset($page_job)): ?>
                    <a href="<?php echo e(route('jobs.create')); ?>" class="header-join-button">

                        <i class="fa-solid fa-user-doctor"></i>

                        أضف وظيفه

                    </a>
                <?php else: ?>
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('doctor_join')); ?>" class="header-join-button">

                            <i class="fa-solid fa-user-doctor"></i>

                            انضم كطبيب

                        </a>
                    <?php endif; ?>
                <?php endif; ?>




            </div>


        </div>

    </header>

    <div class="public-nav-overlay" id="publicNavOverlay" hidden></div>

    <nav class="public-mobile-nav" id="publicMobileNav" aria-label="قائمة الموقع">

        <div class="public-mobile-nav-head">
            <div class="public-mobile-nav-brand">
                <span class="public-mobile-nav-logo-icon">
                    <i class="fa-solid fa-heart-pulse"></i>
                </span>
                <div>
                    <strong>دليل الأطباء</strong>
                    <small>طبيبك أقرب مما تتخيل</small>
                </div>
            </div>
            <button type="button" class="public-mobile-nav-close" id="publicNavClose" aria-label="إغلاق القائمة">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="public-mobile-nav-section">
            <span class="public-mobile-nav-label">التنقل السريع</span>

            <a href="<?php echo e(route('home')); ?>"
                class="public-mobile-nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">
                <i class="fa-solid fa-house"></i>
                <span>الرئيسية</span>
            </a>

            <a href="<?php echo e(route('specialties.index')); ?>"
                class="public-mobile-nav-link <?php echo e(request()->routeIs('specialties.index') ? 'active' : ''); ?>">
                <i class="fa-solid fa-stethoscope"></i>
                <span>التخصصات</span>
            </a>

            <a href="<?php echo e(route('doctors.index')); ?>"
                class="public-mobile-nav-link <?php echo e(request()->routeIs('doctors.*', 'specialties.show') ? 'active' : ''); ?>">
                <i class="fa-solid fa-user-doctor"></i>
                <span>الأطباء</span>
            </a>

            <a href="<?php echo e(route('jobs.index')); ?>"
                class="public-mobile-nav-link <?php echo e(request()->routeIs('jobs.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-briefcase"></i>
                <span>الوظائف</span>
            </a>

            <a href="<?php echo e(route('about')); ?>"
                class="public-mobile-nav-link <?php echo e(request()->routeIs('about') ? 'active' : ''); ?>">
                <i class="fa-solid fa-circle-info"></i>
                <span>من نحن</span>
            </a>
        </div>

        <div class="public-mobile-nav-section">
            <span class="public-mobile-nav-label">المساعدة والدعم</span>

            
            <a href="<?php echo e(route('contact.index')); ?>"
                class="public-mobile-nav-link <?php echo e(request()->routeIs('contact.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-headset"></i>
                <span>تواصل معنا</span>
            </a>

            
            <a href="<?php echo e(route('faq')); ?>"
                class="public-mobile-nav-link <?php echo e(request()->routeIs('faq') ? 'active' : ''); ?>">
                <i class="fa-solid fa-circle-question"></i>
                <span>الأسئلة الشائعة</span>
            </a>
        </div>

        <div class="public-mobile-auth-area">
            <?php if(auth()->guard()->check()): ?>
                <div class="public-mobile-user-card">
                    <div class="public-mobile-user-info">
                        <span class="public-mobile-user-avatar">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <div>
                            <strong>حسابي</strong>
                            <small><?php echo e(auth()->user()->name ?? 'مستخدم'); ?></small>
                        </div>
                    </div>
                    <div class="public-mobile-user-actions">
                        <a href="<?php echo e(route('profile')); ?>" class="public-mobile-btn-profile">
                            <i class="fa-solid fa-id-badge"></i>
                            الملف الشخصي
                        </a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="public-mobile-logout-form">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="public-mobile-btn-logout">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                خروج
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(auth()->guard()->guest()): ?>
                <div class="public-mobile-guest-actions">
                    <a href="<?php echo e(route('login')); ?>" class="public-mobile-auth-btn is-login">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>تسجيل الدخول</span>
                    </a>

                    <?php if(isset($page_job)): ?>
                        <a href="<?php echo e(route('jobs.create')); ?>" class="public-mobile-auth-btn is-join">
                            <i class="fa-solid fa-plus"></i>
                            <span>أضف وظيفه</span>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('doctor_join')); ?>" class="public-mobile-auth-btn is-join">
                            <i class="fa-solid fa-user-doctor"></i>
                            <span>انضم كطبيب</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

    </nav>

    
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

    <main>

        <?php echo $__env->yieldContent('content'); ?>

    </main>



    

    <footer class="site-footer">

        <div class="site-container">

            <div class="footer-grid">

                
                <div class="footer-brand-col">
                    <div class="footer-logo">
                        <div class="footer-logo-icon">
                            <i class="fa-solid fa-heart-pulse"></i>
                        </div>
                        <h3>دليل الأطباء</h3>
                    </div>

                    <p class="footer-description">
                        منصة طبية شاملة تساعدك على الوصول إلى أفضل الأطباء، التعرف على تخصصاتهم، واستكشاف الخدمات الطبية
                        بسهولة وثقة.
                    </p>

                    <div class="footer-trust-badge">
                        <i class="fa-solid fa-shield-heart"></i>
                        <span>منصة موثوقة في خدمتك</span>
                    </div>
                </div>

                
                <div>
                    <h3 class="footer-col-title">استكشف</h3>
                    <div class="footer-links">
                        <a href="<?php echo e(route('doctors.index')); ?>">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>الأطباء</span>
                        </a>
                        <a href="<?php echo e(route('specialties.index')); ?>">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>التخصصات</span>
                        </a>
                        <a href="<?php echo e(route('jobs.index')); ?>">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>الوظائف</span>
                        </a>
                    </div>
                </div>

                
                <div>
                    <h3 class="footer-col-title">للأطباء</h3>
                    <div class="footer-links">
                        <a href="<?php echo e(route('doctor_join')); ?>">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>انضم كطبيب</span>
                        </a>
                        <a href="<?php echo e(route('jobs.create')); ?>">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>إضافة وظيفة</span>
                        </a>
                    </div>
                </div>

                
                <div>
                    <h3 class="footer-col-title">المساعدة</h3>
                    <div class="footer-links">
                        <a href="<?php echo e(route('about')); ?>">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>من نحن</span>
                        </a>
                        <a href="<?php echo e(route('contact.index')); ?>">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>تواصل معنا</span>
                        </a>
                    </div>
                </div>

            </div>

            <div class="footer-bottom">
                © 2026 دليل الأطباء — جميع الحقوق محفوظة
            </div>

        </div>

    </footer>



    

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('js/core/public-nav.js')); ?>"></script>
    <script src="<?php echo e(asset('js/doctor_details.js')); ?>"></script>
    <script src="<?php echo e(asset('sw.js')); ?>"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    

    <?php echo $__env->yieldPushContent('scripts'); ?>


</body>

</html>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/layout/app.blade.php ENDPATH**/ ?>
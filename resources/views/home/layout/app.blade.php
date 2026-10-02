<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'دليل الأطباء')
    </title>


    {{-- =====================================================
         Google Font - Cairo
    ====================================================== --}}
    <link rel="icon" type="image/png" href="{{ asset('logo/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('logo/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home/doctor_details.css') }}">

    {{-- =====================================================
         Font Awesome
    ====================================================== --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">




    <link rel="stylesheet" href="{{ asset('css/home/test.css') }}">





    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('css/home/profile.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/home/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/tokens.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/public-nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/refine.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/type-scale.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/cards-doctor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/cards-job.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/doctor-profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/job-details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/auth-pages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/job-form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/ui-enhancements.css') }}">

    @stack('styles')

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

                <a href="{{ route('contact.index') }}">
                    تواصل معنا
                </a>

                <a href="{{ route('faq') }}">
                    الأسئلة الشائعة
                </a>



            </div>


        </div>

    </div>



    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <header class="site-header">

        <div class="site-container header-content">


            {{-- =================================================
                 LOGO
            ================================================== --}}

            <a href="{{ route('home') }}" class="site-logo">


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



            {{-- =================================================
                 NAVIGATION
            ================================================== --}}

            <nav class="main-navigation">


                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">

                    الرئيسية

                </a>


                <a href="{{ route('specialties.index') }}"
                    class="{{ request()->routeIs('specialties.index') ? 'active' : '' }}">

                    التخصصات

                </a>


                <a href="{{ route('doctors.index') }}"
                    class="{{ request()->routeIs('doctors.*', 'specialties.show') ? 'active' : '' }}">

                    الأطباء

                </a>


                <a href="{{ route('jobs.index') }}" class="{{ request()->routeIs('jobs.*') ? 'active' : '' }}">

                    الوظائف

                </a>


                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">

                    من نحن

                </a>


            </nav>



            {{-- =================================================
                 HEADER ACTIONS
            ================================================== --}}

            <div class="header-actions">

                <button type="button" class="public-nav-toggle" id="publicNavToggle" aria-label="فتح القائمة"
                    aria-expanded="false" aria-controls="publicMobileNav">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <button type="button" class="theme-toggle" id="themeButton" aria-label="تغيير وضع الموقع">

                    <i class="fa-solid fa-moon" id="themeIcon">
                    </i>

                </button>


                @auth

                    <div class="header-user">


                        <a href="{{ route('profile') }}" class="header-profile-button" title="الملف الشخصي">

                            <i class="fa-solid fa-user"></i>

                            <span>
                                الملف الشخصي
                            </span>

                        </a>


                        {{-- =================================================
             تسجيل الخروج
        ================================================== --}}

                        <form method="POST" action="{{ route('logout') }}" class="logout-form">

                            @csrf

                            <button type="submit" class="header-logout-button">

                                <i class="fa-solid fa-right-from-bracket"></i>

                                <span>
                                    تسجيل الخروج
                                </span>

                            </button>

                        </form>

                    </div>

                @endauth







                @guest


                    <a href="{{ route('login') }}" class="header-login-button">

                        تسجيل الدخول

                    </a>



                @endguest


                @if (isset($page_job))
                    <a href="{{ route('jobs.create') }}" class="header-join-button">

                        <i class="fa-solid fa-user-doctor"></i>

                        أضف وظيفه

                    </a>
                @else
                    @guest
                        <a href="{{ route('doctor_join') }}" class="header-join-button">

                            <i class="fa-solid fa-user-doctor"></i>

                            انضم كطبيب

                        </a>
                    @endguest
                @endif




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

            <a href="{{ route('home') }}"
                class="public-mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                <span>الرئيسية</span>
            </a>

            <a href="{{ route('specialties.index') }}"
                class="public-mobile-nav-link {{ request()->routeIs('specialties.index') ? 'active' : '' }}">
                <i class="fa-solid fa-stethoscope"></i>
                <span>التخصصات</span>
            </a>

            <a href="{{ route('doctors.index') }}"
                class="public-mobile-nav-link {{ request()->routeIs('doctors.*', 'specialties.show') ? 'active' : '' }}">
                <i class="fa-solid fa-user-doctor"></i>
                <span>الأطباء</span>
            </a>

            <a href="{{ route('jobs.index') }}"
                class="public-mobile-nav-link {{ request()->routeIs('jobs.*') ? 'active' : '' }}">
                <i class="fa-solid fa-briefcase"></i>
                <span>الوظائف</span>
            </a>

            <a href="{{ route('about') }}"
                class="public-mobile-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-info"></i>
                <span>من نحن</span>
            </a>
        </div>

        <div class="public-mobile-nav-section">
            <span class="public-mobile-nav-label">المساعدة والدعم</span>

            {{-- تواصل معنا --}}
            <a href="{{ route('contact.index') }}"
                class="public-mobile-nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                <i class="fa-solid fa-headset"></i>
                <span>تواصل معنا</span>
            </a>

            {{-- الأسئلة الشائعة --}}
            <a href="{{ route('faq') }}"
                class="public-mobile-nav-link {{ request()->routeIs('faq') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-question"></i>
                <span>الأسئلة الشائعة</span>
            </a>
        </div>

        <div class="public-mobile-auth-area">
            @auth
                <div class="public-mobile-user-card">
                    <div class="public-mobile-user-info">
                        <span class="public-mobile-user-avatar">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <div>
                            <strong>حسابي</strong>
                            <small>{{ auth()->user()->name ?? 'مستخدم' }}</small>
                        </div>
                    </div>
                    <div class="public-mobile-user-actions">
                        <a href="{{ route('profile') }}" class="public-mobile-btn-profile">
                            <i class="fa-solid fa-id-badge"></i>
                            الملف الشخصي
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="public-mobile-logout-form">
                            @csrf
                            <button type="submit" class="public-mobile-btn-logout">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                خروج
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <div class="public-mobile-guest-actions">
                    <a href="{{ route('login') }}" class="public-mobile-auth-btn is-login">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>تسجيل الدخول</span>
                    </a>

                    @if (isset($page_job))
                        <a href="{{ route('jobs.create') }}" class="public-mobile-auth-btn is-join">
                            <i class="fa-solid fa-plus"></i>
                            <span>أضف وظيفه</span>
                        </a>
                    @else
                        <a href="{{ route('doctor_join') }}" class="public-mobile-auth-btn is-join">
                            <i class="fa-solid fa-user-doctor"></i>
                            <span>انضم كطبيب</span>
                        </a>
                    @endif
                </div>
            @endguest
        </div>

    </nav>

    {{-- =====================================================
         PAGE CONTENT
    ====================================================== --}}
    <x-home.info.flash-message />

    <main>

        @yield('content')

    </main>



    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <footer class="site-footer">

        <div class="site-container">

            <div class="footer-grid">

                {{-- Column 1: Brand & Description --}}
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

                {{-- Column 2: Explore --}}
                <div>
                    <h3 class="footer-col-title">استكشف</h3>
                    <div class="footer-links">
                        <a href="{{ route('doctors.index') }}">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>الأطباء</span>
                        </a>
                        <a href="{{ route('specialties.index') }}">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>التخصصات</span>
                        </a>
                        <a href="{{ route('jobs.index') }}">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>الوظائف</span>
                        </a>
                    </div>
                </div>

                {{-- Column 3: For Doctors --}}
                <div>
                    <h3 class="footer-col-title">للأطباء</h3>
                    <div class="footer-links">
                        <a href="{{ route('doctor_join') }}">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>انضم كطبيب</span>
                        </a>
                        <a href="{{ route('jobs.create') }}">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>إضافة وظيفة</span>
                        </a>
                    </div>
                </div>

                {{-- Column 4: Help --}}
                <div>
                    <h3 class="footer-col-title">المساعدة</h3>
                    <div class="footer-links">
                        <a href="{{ route('about') }}">
                            <i class="fa-solid fa-angle-left"></i>
                            <span>من نحن</span>
                        </a>
                        <a href="{{ route('contact.index') }}">
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



    {{-- =====================================================
         JAVASCRIPT
    ====================================================== --}}

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/core/public-nav.js') }}"></script>
    <script src="{{ asset('js/doctor_details.js') }}"></script>
    <script src="{{ asset('sw.js') }}"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- =====================================================
         PAGE EXTRA JS
    ====================================================== --}}

    @stack('scripts')


</body>

</html>

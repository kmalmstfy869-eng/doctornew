<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('logo/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('logo/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo/favicon.png') }}">
    <title>@yield('title', 'لوحة الإدارة | دليل الأطباء')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    @stack('extra_style')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/ratings.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/tokens.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/responsive.css') }}">
    {{-- ستايل صفحات الأدمن الجديدة (كل الـ selectors بتبدأ بـ ap-) --}}
    <link rel="stylesheet" href="{{ asset('css/admin/admin-pro.css') }}">
</head>

<body>

    <aside class="sidebar">

        <div class="sidebar-logo">
            <div class="logo-icon"><i class="fa-solid fa-heart-pulse"></i></div>
            <div class="logo-text">
                <h2>دليل الأطباء</h2>
                <p>لوحة الإدارة والتحكم</p>
            </div>
        </div>

        <div class="menu-title">القائمة الرئيسية</div>

        <ul class="sidebar-menu">

            {{-- ===== الرئيسية ===== --}}
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i><span>لوحة التحكم</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.stats') }}" class="{{ request()->routeIs('admin.stats') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i><span>إحصائيات الزيارات</span>
                </a>
            </li>
            {{-- ===== الأطباء ===== --}}
            <li class="ap-menu-label">الأطباء</li>

            <li class="doctors-menu">
                <details
                    {{ request()->routeIs('admin.subscribed_doctors.*') ||
                    request()->routeIs('admin.unsubscribed_doctors.*') ||
                    request()->routeIs('admin.rejected_doctors.*') ||
                    request()->routeIs('admin.pending_doctors.*') ||
                    request()->routeIs('admin.doctor.create')
                        ? 'open'
                        : '' }}>
                    <summary class="doctors-menu-btn">
                        <span class="menu-button-content">
                            <i class="fa-solid fa-user-doctor"></i><span>إدارة الأطباء</span>
                        </span>
                        <i class="fa-solid fa-chevron-down doctors-arrow"></i>
                    </summary>
                    <ul class="doctors-submenu">
                        <li>
                            <a href="{{ route('admin.subscribed_doctors.index') }}"
                                class="{{ request()->routeIs('admin.subscribed_doctors.*') ? 'submenu-active' : '' }}">
                                <i class="fa-solid fa-user-doctor"></i><span>الأطباء المشتركين</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.unsubscribed_doctors.index') }}"
                                class="{{ request()->routeIs('admin.unsubscribed_doctors.*') ? 'submenu-active' : '' }}">
                                <i class="fa-solid fa-users"></i><span>الأطباء غير المشتركين</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.rejected_doctors.index') }}"
                                class="{{ request()->routeIs('admin.rejected_doctors.*') ? 'submenu-active' : '' }}">
                                <i class="fa-solid fa-circle-xmark"></i><span>الأطباء المرفوضون و المحذفون</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pending_doctors.index') }}"
                                class="{{ request()->routeIs('admin.pending_doctors.*') ? 'submenu-active' : '' }}">
                                <i class="fa-solid fa-clock"></i><span>طلبات الانضمام</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.doctor.create') }}"
                                class="{{ request()->routeIs('admin.doctor.create') ? 'submenu-active' : '' }}">
                                <i class="fa-solid fa-user-plus"></i><span>إضافة طبيب</span>
                            </a>
                        </li>
                    </ul>
                </details>
            </li>


            {{-- ===== الاشتراكات والمالية ===== --}}
            <li class="menu-title">الاشتراكات والمالية</li>

            <li class="doctors-menu">
                <details
                    {{ request()->routeIs('admin.plans.*') || request()->routeIs('admin.subscriptions.*') ? 'open' : '' }}>
                    <summary class="doctors-menu-btn">
                        <span class="menu-button-content">
                            <i class="fa-solid fa-credit-card"></i><span>الاشتراكات</span>
                        </span>
                        <i class="fa-solid fa-chevron-down doctors-arrow"></i>
                    </summary>
                    <ul class="doctors-submenu">
                        {{-- لسه ما اتعملوش: هيتفعلوا لما نعمل صفحاتهم --}}
                        <li>
                            <a class="ap-soon" aria-disabled="true">
                                <i class="fa-solid fa-layer-group"></i><span>الباقات</span>
                                <em class="ap-soon-tag">قريبًا</em>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.subscriptions.index') }}"
                                class="{{ request()->routeIs('admin.subscriptions.*') ? 'submenu-active' : '' }}">
                                <i class="fa-solid fa-ticket"></i><span>إدارة الاشتراكات</span>
                            </a>
                        </li>
                    </ul>
                </details>
            </li>

            <li>
                <a href="{{ route('admin.finance.index') }}"
                    class="{{ request()->routeIs('admin.finance.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wallet"></i><span>المالية (داخل وخارج)</span>
                </a>
            </li>

            {{-- ===== ملفات المرضى والتخزين ===== --}}
            <li class="menu-title">ملفات المرضى</li>

            <li class="doctors-menu">
                <details {{ request()->routeIs('admin.storage.*') ? 'open' : '' }}>
                    <summary class="doctors-menu-btn">
                        <span class="menu-button-content">
                            <i class="fa-solid fa-hard-drive"></i><span>التخزين والنسخ</span>
                        </span>
                        <i class="fa-solid fa-chevron-down doctors-arrow"></i>
                    </summary>
                    <ul class="doctors-submenu">
                        <li>
                            <a href="{{ route('admin.storage.overview') }}"
                                class="{{ request()->routeIs('admin.storage.overview') ? 'submenu-active' : '' }}">
                                <i class="fa-solid fa-gauge-high"></i><span>نظرة عامة</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.storage.files') }}"
                                class="{{ request()->routeIs('admin.storage.files') ? 'submenu-active' : '' }}">
                                <i class="fa-solid fa-folder-open"></i><span>الملفات والنسخ</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.storage.runs') }}"
                                class="{{ request()->routeIs('admin.storage.runs*') ? 'submenu-active' : '' }}">
                                <i class="fa-solid fa-clock-rotate-left"></i><span>سجل التشغيل</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.storage.restore') }}"
                                class="{{ request()->routeIs('admin.storage.restore*') ? 'submenu-active' : '' }}">
                                <i class="fa-solid fa-rotate-left"></i><span>الاسترجاع</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.storage.quotas') }}"
                                class="{{ request()->routeIs('admin.storage.quotas*') ? 'submenu-active' : '' }}">
                                <i class="fa-solid fa-sliders"></i><span>مساحات الأطباء</span>
                            </a>
                        </li>
                    </ul>
                </details>
            </li>

            {{-- ===== المحتوى ===== --}}
            <li class="menu-title">المحتوى</li>

            <li>
                <a href="{{ route('admin.specialties.index') }}"
                    class="{{ request()->routeIs('admin.specialties.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-stethoscope"></i><span>التخصصات</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.areas.index') }}"
                    class="{{ request()->routeIs('admin.areas.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-location-dot"></i><span>المناطق</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.ratings.index') }}"
                    class="{{ request()->routeIs('admin.ratings.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-star"></i><span>التقييمات</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.jobs.index') }}"
                    class="{{ request()->routeIs('admin.jobs.*') || request()->routeIs('admin.user.jobs') ? 'active' : '' }}">
                    <i class="fa-solid fa-briefcase"></i><span>الوظائف</span>
                </a>
            </li>

            {{-- ===== المستخدمون والتواصل ===== --}}
            <li class="menu-title">المستخدمون والتواصل</li>

            <li>
                <a href="{{ route('admin.users') }}"
                    class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i><span>المستخدمون</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.contact') }}"
                    class="{{ request()->routeIs('admin.contact') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope"></i><span>رسائل المستخدمين</span>
                    @if (($messagesCount ?? 0) > 0)
                        <span class="sidebar-badge">{{ $messagesCount > 99 ? '99+' : $messagesCount }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.notifications') }}"
                    class="{{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
                    <i class="fa-solid fa-bell"></i><span>الإشعارات</span>
                </a>
            </li>

            {{-- ===== النظام ===== --}}
            <li class="menu-title">النظام</li>

            <li>
                <a href="{{ route('admin.profile_admin') }}"
                    class="{{ request()->routeIs('admin.profile_admin') ? 'active' : '' }}">
                    <i class="fa-solid fa-gear"></i><span>الإعدادات</span>
                </a>
            </li>

        </ul>

        <div class="sidebar-bottom">
            <div class="admin-box">
                <div class="admin-avatar"><i class="fa-solid fa-user-shield"></i></div>
                <div class="admin-data">
                    <h4>{{ Auth::user()->name ?? 'مدير النظام' }}</h4>
                    <p>مدير النظام</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
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
                <button type="button" class="mobile-menu" id="mobileMenuButton" aria-label="فتح القائمة"
                    aria-expanded="false">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="header-title">
                    <h1>@yield('page-title', 'لوحة التحكم')</h1>
                    <p>@yield('page-description', 'إدارة ومتابعة منصة دليل الأطباء')</p>
                </div>
            </div>

            <div class="header-actions">
                <button type="button" class="theme-toggle" id="themeButton" title="تغيير المظهر"
                    aria-label="تغيير المظهر">
                    <i class="fa-solid fa-moon" id="themeIcon"></i>
                </button>

                <button type="button" class="header-btn" title="الإشعارات">
                    <i class="fa-regular fa-bell"></i>
                    @if (($notificationsCount ?? 0) > 0)
                        <span class="notification-dot"></span>
                    @endif
                </button>

                <div class="admin-header">
                    <div class="admin-header-avatar"><i class="fa-solid fa-user-shield"></i></div>
                    <div class="admin-header-text">
                        <h4>{{ Auth::user()->name ?? 'مدير النظام' }}</h4>
                        <p>مدير النظام</p>
                    </div>
                </div>
            </div>

        </header>

        <x-home.info.flash-message />

        <div class="dashboard-content">
            @yield('content')
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="{{ asset('js/app_admin.js') }}"></script>
    <script src="{{ asset('js/core/admin-nav.js') }}"></script>

    {{-- سكربتات الصفحات (زي live_search.js) --}}
    @stack('extra_java')

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('sw.js') }}"></script>
    <script src="{{ asset('js/core/table-cards.js') }}"></script>
</body>

</html>

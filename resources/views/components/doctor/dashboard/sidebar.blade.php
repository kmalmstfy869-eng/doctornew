<aside class="sidebar" id="sidebar">


{{-- =====================================================
     LOGO
====================================================== --}}

<div class="logo">

    <div class="logo-mark">
        د
    </div>

    <div class="logo-info">
        <strong>دليل الأطباء</strong>
        <span>بوابة الطبيب</span>
    </div>

</div>


{{-- =====================================================
     MAIN
====================================================== --}}

<div class="sidebar-section">
    الرئيسية
</div>


<nav class="side-nav">

    {{-- Dashboard --}}

    <a href="{{ route('doctor.dashboard') }}"
        class="{{ request()->routeIs('doctor.dashboard') ? 'side-link active' : 'side-link' }}">

        <span class="side-icon"><i class="fa-solid fa-house"></i></span>

        <span>
            نظرة عامة
        </span>

    </a>


    {{-- Medical Profile --}}

    <a href="{{ route('doctor.profile.show') }}"
        class="{{ request()->routeIs('doctor.profile.show') ? 'side-link active' : 'side-link' }}">

        <span class="side-icon"><i class="fa-solid fa-id-card"></i></span>

        <span>
            ملفي الطبي
        </span>

    </a>


    {{-- Edit Profile --}}

    <a href="{{ route('doctor.profile.edit') }}"
        class="{{ request()->routeIs('doctor.profile.edit') ? 'side-link active' : 'side-link' }}">

        <span class="side-icon"><i class="fa-solid fa-pen-to-square"></i></span>

        <span>
            تعديل ملفي الطبي
        </span>

    </a>


    {{-- Reviews --}}

    @if ($doctor->hasFeature('subscription'))

        <a href="{{ route('doctor.reviews') }}"
            class="{{ request()->routeIs('doctor.reviews') ? 'side-link active' : 'side-link' }}">

            <span class="side-icon">
                <i class="fa-solid fa-star"></i>
            </span>

            <span>
                التقييمات
            </span>

            @if ($newRatingsCount > 0)

                <span class="sidebar-badge">
                    {{ $newRatingsCount }}
                </span>

            @endif

        </a>

    @endif


    {{-- Notifications --}}

    <a href="{{ route('doctor.notifications.index') }}"
        class="{{ request()->routeIs('doctor.notifications.*') ? 'side-link active' : 'side-link' }}">

        <span class="side-icon">
            <i class="fa-regular fa-bell"></i>
        </span>

        <span>
            الإشعارات
        </span>

        @if ($notificationsCount > 0)
            <span class="sidebar-badge notification-badge">
                {{ $notificationsCount > 99 ? '99+' : $notificationsCount }}
            </span>
        @endif

    </a>

</nav>


{{-- =====================================================
     ACCOUNT
====================================================== --}}

<div class="sidebar-section">
    إدارة الحساب
</div>


<nav class="side-nav">

    {{-- Subscription --}}

    <a href="#subscription" class="side-link">

        <span class="side-icon">
            <i class="fa-solid fa-crown"></i>
        </span>

        <span>
            الاشتراك
        </span>

    </a>


    {{-- Settings --}}

    <a href="{{ route('doctor.profile_doctor') }}"
        class="{{ request()->routeIs('doctor.profile_doctor') ? 'side-link active' : 'side-link' }}">

        <span class="side-icon">
            ⚙
        </span>

        <span>
            الإعدادات
        </span>

    </a>




    <a href="{{ route('doctor.help') }}" class="{{ request()->routeIs('doctor.help') ? 'side-link active' : 'side-link' }}">

        <span class="side-icon">
            ?
        </span>

        <span>
            المساعدة
        </span>

    </a>

</nav>


{{-- =====================================================
     FLEX SPACER
====================================================== --}}

<div class="sidebar-spacer"></div>


{{-- =====================================================
     SUBSCRIPTION CARD
====================================================== --}}

@if (!$doctor->hasFeature('subscription'))

    <div class="system-entry subscription-entry">

        <div class="system-entry-top">

            <div class="system-icon">
                ♛
            </div>

            <div>

                <strong>
                    طوّر حسابك
                </strong>

                <span>
                    مميزات أكثر لطبيبك
                </span>

            </div>

        </div>


        <p class="system-entry-text">

            اشترك الآن للحصول على مميزات إضافية
            مثل الحجز أونلاين ونظام إدارة العيادة.

        </p>


        <a href="#subscription" class="system-entry-button">

            الاشتراك الآن ←

        </a>

    </div>


@elseif (str_starts_with($planSlug, 'prime-'))

    <div class="system-entry subscription-entry">

        <div class="system-entry-top">

            <div class="system-icon">
                ★
            </div>

            <div>

                <strong>
                    باقة Prime
                </strong>

                <span>
                    اشتراكك مفعل
                </span>

            </div>

        </div>


        <p class="system-entry-text">

            استمتع بمميزات Prime،
            وقم بالترقية لتفعيل الحجز أونلاين
            وإدارة الحجوزات.

        </p>


        <a href="#subscription" class="system-entry-button">

            ترقية الاشتراك ←

        </a>

    </div>


@elseif ($doctor->hasFeature('booking') && str_starts_with($planSlug, 'professional-'))

    <div class="system-entry subscription-entry">

        <div class="system-entry-top">

            <div class="system-icon">
                📅
            </div>

            <div>

                <strong>
                    نظام الحجوزات
                </strong>

                <span>
                    متاح ضمن اشتراكك
                </span>

            </div>

        </div>


        <p class="system-entry-text">

            استقبل حجوزات مرضاك أونلاين
            وتابع مواعيدك وحجوزاتك من مكان واحد.

        </p>


        <a href="{{ route("clinic.dashboard") }}" class="system-entry-button">

            إدارة الحجوزات ←

        </a>

    </div>


@elseif (str_starts_with($planSlug, 'clinic-system-'))

    <div class="system-entry subscription-entry">

        <div class="system-entry-top">

            <div class="system-icon">
                ✚
            </div>

            <div>

                <strong>
                    نظام العيادة
                </strong>

                <span>
                    متاح ضمن اشتراكك
                </span>

            </div>

        </div>


        <p class="system-entry-text">

            إدارة الحجوزات والعملاء والدخل
            والعيادة بالكامل من مكان واحد.

        </p>


        <a href="{{ route('clinic.dashboard') }}"
            class="system-entry-button">

            الدخول إلى نظام العيادة ←

        </a>

    </div>

@endif


{{-- =====================================================
     DOCTOR PROFILE + LOGOUT
====================================================== --}}

<div class="sidebar-profile">

    <div class="profile-avatar">

        @if ($doctorImage)

            <img
                src="{{ asset('storage/' . $doctorImage) }}"
                alt="د. {{ $doctorname }}"
            >

        @else

            <div class="med-doctor-image-placeholder">

                <div class="med-placeholder-icon">
                    <span>♙</span>
                </div>

            </div>

        @endif

    </div>


    <div class="profile-info">

        <strong>
            د. {{ $doctorname }}
        </strong>

        <span>
            {{ $doctor->subscription?->plan?->name ?? 'غير مشترك' }}
        </span>

    </div>


    {{-- Logout Icon --}}

    <form
        action="{{ route('logout') }}"
        method="POST"
        class="sidebar-logout-form"
    >

        @csrf

        <button
            type="submit"
            class="sidebar-logout"
            title="تسجيل الخروج"
            aria-label="تسجيل الخروج"
        >

            <span class="sidebar-logout-icon">
                ⇥
            </span>

        </button>

    </form>

</div>


</aside>

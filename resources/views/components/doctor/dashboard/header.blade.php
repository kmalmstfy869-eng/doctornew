@props(['doctor', 'doctorname' ,'notifications'])
<header class="topbar" id="dashboard-header">


    <div class="header-info">

        <button class="mobile-menu" type="button" onclick="openSidebar()" aria-label="فتح القائمة">

            <i class="fa-solid fa-bars"></i>

        </button>


        <div class="header-icon">
            <i class="fa-solid fa-stethoscope"></i>
        </div>


        <div class="header-title">

            <strong>
                لوحة تحكم الطبيب
            </strong>

            <span>
                أهلاً بك د. {{ $doctorname }} —
                تابع ملفك وحضورك الطبي
            </span>

        </div>

    </div>


    <div class="top-actions">


        {{-- DARK MODE --}}

        <button class="top-btn" type="button" id="themeButton" onclick="toggleDark()" title="الوضع الليلي"
            aria-label="تغيير الوضع">

            ☾

        </button>


        {{-- NOTIFICATIONS --}}

        <a href="{{ route('doctor.notifications.index') }}" class="top-btn" title="الإشعارات" aria-label="الإشعارات">

            <i class="fa-regular fa-bell"></i>

            @if (isset($notifications) && $notifications > 0)
            <span class="notification"></span>
            @endif

        </a>


        {{-- DOCTOR --}}


<div class="top-doctor">

    <div class="profile-avatar">

        @if ($doctor->doctor_image)

            <img
                src="{{ asset('storage/' . $doctor->doctor_image) }}"
                alt="د. {{ $doctorname }}"
                class="top-doctor-image"
            >

        @else

            <div class="med-doctor-image-placeholder">

                <div class="med-placeholder-icon">
                    <span><i class="fa-solid fa-user-doctor"></i></span>
                </div>

            </div>

        @endif

    </div>


    <div class="top-doctor-info">

        <strong>
            د. {{ $doctorname }}
        </strong>

        <span>
            {{ $doctor->specialty?->name ?? 'طبيب' }}
        </span>

    </div>

</div>
    </div>

</header>

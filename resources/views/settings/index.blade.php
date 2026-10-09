<div class="profile-page">


    {{-- =====================================================
     BACK BUTTON
====================================================== --}}

    <div class="profile-back">

        <a href="{{ route($link) }}" class="profile-back-btn">

            <i class="fa-solid fa-arrow-right"></i>

            رجوع

        </a>

    </div>


    {{-- =====================================================
     PROFILE HEADER
====================================================== --}}

    <div class="profile-page-header">

        <div class="profile-header-icon">

            <i class="fa-solid fa-user-gear"></i>

        </div>

        <div class="profile-header-content">

            <h1>
                إعدادات الحساب
            </h1>

            <p>
                إدارة بيانات حسابك وإعدادات الأمان
            </p>

        </div>

    </div>


    {{-- =====================================================
     PROFILE CONTENT
====================================================== --}}

    <div class="profile-container">


        {{-- =================================================
         PERSONAL INFORMATION
    ================================================== --}}

        <section class="profile-section profile-information-card">

            <div class="profile-section-icon">

                <i class="fa-solid fa-user-pen"></i>

            </div>

            <div class="profile-section-content">

                @include('settings.sections.personal')

            </div>

        </section>



        {{-- =================================================
         USER JOBS
    ================================================== --}}

        @if (isset($jobs))
            <section class="profile-section profile-jobs-card">

                <div class="profile-section-icon">

                    <i class="fa-solid fa-briefcase"></i>

                </div>

                <div class="profile-section-content">

                    @include('settings.sections.jobs')

                </div>

            </section>
        @endif



        {{-- =================================================
         USER FAVORITES
    ================================================== --}}

        @if (isset($favorites))
            <section class="profile-section profile-favorites-card">

                <div class="profile-section-icon">

                    <i class="fa-solid fa-heart"></i>

                </div>

                <div class="profile-section-content">

                    @include('settings.sections.favorites')

                </div>

            </section>
        @endif





        {{-- =================================================
         PUSH NOTIFICATIONS CONTROL
    ================================================== --}}

        @if (isset($flagnotifications))
            <section class="profile-section profile-notifications-control-card">

                <div class="notifications-control-content">

                    {{-- =================================================
                     INFORMATION
                ================================================== --}}

                    <div class="notifications-control-info">

                        <div class="notifications-control-icon">

                            <i class="fa-solid fa-bell"></i>

                        </div>


                        <div class="notifications-control-text">

                            <span class="notifications-control-label">
                                الإشعارات
                            </span>

                            <h2>
                                التحكم في إشعارات الحساب
                            </h2>

                            <p id="notificationsStatus">
                                {{ $flagnotifications ? 'الإشعارات مفعلة حاليًا.' : 'الإشعارات متوقفة حاليًا.' }}
                            </p>

                        </div>

                    </div>


                    {{-- =================================================
                     TOGGLE
                ================================================== --}}

                    <div class="notifications-toggle-wrapper">

                        <span class="notifications-toggle-status" id="notificationsToggleStatus">
                            {{ $flagnotifications ? 'مفعلة' : 'متوقفة' }}
                        </span>


                        <button type="button" id="notificationsToggle"
                            class="notifications-toggle {{ $flagnotifications ? 'is-active' : '' }}"
                            aria-label="تفعيل أو إيقاف إشعارات المتصفح"
                            aria-pressed="{{ $flagnotifications ? 'true' : 'false' }}"
                            data-active="{{ $flagnotifications ? '1' : '0' }}">

                            <span class="notifications-toggle-track"></span>

                            <span class="notifications-toggle-thumb">

                                <i class="fa-solid fa-bell"></i>

                            </span>

                        </button>

                    </div>

                </div>

            </section>
        @endif



        {{-- =================================================
         UPDATE PASSWORD
    ================================================== --}}

        <section class="profile-section profile-password-card">

            <div class="profile-section-icon">

                <i class="fa-solid fa-lock"></i>

            </div>

            <div class="profile-section-content">

                @include('settings.sections.password')

            </div>

        </section>



        {{-- =================================================
         DELETE ACCOUNT
    ================================================== --}}

        <section class="profile-section profile-delete-card">

            <div class="profile-section-icon">

                <i class="fa-solid fa-user-xmark"></i>

            </div>

            <div class="profile-section-content">

                @include('settings.sections.delete-account')

            </div>

        </section>


    </div>


</div>


{{-- =====================================================
     PUSH NOTIFICATIONS CONFIGURATION
====================================================== --}}

@if (isset($flagnotifications))
    <script>
        window.pushConfig = {

            controllerActive: @json($flagnotifications ?? false),

            vapidPublicKey: @json(config('webpush.vapid.public_key')),

            statusUrl: @json(route('doctor.push-subscription.status')),

            subscribeUrl: @json(route('doctor.push-subscription.store')),

            disableUrl: @json(route('doctor.push-subscription.disable')),

            csrfToken: @json(csrf_token()),

        };
    </script>
@endif

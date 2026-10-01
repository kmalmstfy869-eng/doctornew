<section class="welcome">

    @if ($isSubscribed)
        {{-- =========================
            ACTIVE SUBSCRIPTION
        ========================== --}}

        <div class="welcome-main">

            <div class="welcome-content">

                {{-- Header --}}
                <div class="welcome-header">

                    <div class="welcome-label">
                        ✦ حسابك يعمل بشكل ممتاز
                    </div>

                    <div class="welcome-status {{ $isExpiringSoon ? 'welcome-status-warning' : '' }}">
                        <i></i>
                        {{ $subscriptionStatus }}
                    </div>

                </div>


                {{-- Welcome --}}
                <h1>
                    أهلاً بك، د. {{ $doctorName }}
                </h1>

                <p>
                    ملفك الطبي أصبح أقوى، وظهورك أمام المرضى
                    في تحسن مستمر. تابع أداء صفحتك وطوّر
                    حضورك الطبي من مكان واحد.
                </p>


                {{-- Subscription Summary --}}
                <div class="welcome-subscription-summary">

                    {{-- Plan --}}
                    <div class="welcome-summary-item">

                        <div class="welcome-summary-icon">
                            ♛
                        </div>

                        <div class="welcome-summary-content">

                            <span>
                                الباقة الحالية
                            </span>

                            <strong>
                                {{ $planName }}
                            </strong>

                        </div>

                    </div>


                    {{-- Expiration --}}
                    <div class="welcome-summary-item">

                        <div class="welcome-summary-icon">
                            ◷
                        </div>

                        <div class="welcome-summary-content">

                            <span>
                                صلاحية الاشتراك
                            </span>

                            <strong>
                                {{ $remainingDaysText }}
                            </strong>

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="welcome-summary-item">

                        <div class="welcome-summary-icon">
                            ✓
                        </div>

                        <div class="welcome-summary-content">

                            <span>
                                حالة الاشتراك
                            </span>

                            <strong>
                                {{ $subscriptionStatus }}
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- Profile Statistics --}}
                <div class="welcome-statistics">

                    {{-- Views --}}
                    <div class="welcome-stat">

                        <div class="welcome-stat-icon">
                            ◉
                        </div>

                        <div class="welcome-stat-info">

                            <span>
                                مشاهدات الملف
                            </span>

                            <strong>
                                0
                            </strong>

                        </div>

                    </div>


                    {{-- Rating --}}
                    <div class="welcome-stat">

                        <div class="welcome-stat-icon">
                            ★
                        </div>

                        <div class="welcome-stat-info">

                            <span>
                                تقييم المرضى
                            </span>

                            <strong>
                                {{ $rating }}
                            </strong>

                        </div>

                    </div>


                    {{-- Favorites --}}
                    <div class="welcome-stat">

                        <div class="welcome-stat-icon">
                            ♥
                        </div>

                        <div class="welcome-stat-info">

                            <span>
                                مرات الحفظ
                            </span>

                            <strong>
                                0
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- Subscription Action --}}
                <a href="PUT_YOUR_ROUTE_HERE" class="welcome-subscription-note welcome-subscription-btn">

                    <div class="welcome-subscription-icon">
                        ♛
                    </div>

                    <div class="welcome-subscription-text">

                        <strong>
                            راقب اشتراكك باستمرار
                        </strong>

                        <span>
                            تابع حالة باقتك ومدة صلاحيتها
                            واستفد من المميزات المتاحة لك.
                        </span>

                    </div>

                    <span class="welcome-subscription-arrow">
                        ←
                    </span>

                </a>

            </div>

        </div>


        {{-- =========================
            PROFILE COMPLETION
        ========================== --}}



        <div class="doctor-profile-progress-card">

            <div class="doctor-profile-progress-head">

                <div class="doctor-profile-progress-heading">

                    <span class="doctor-profile-progress-eyebrow">
                        ملفك الطبي
                    </span>

                    <h3>
                        اكتمال الملف
                    </h3>

                    <p>
                        أكمل بيانات ملفك ليظهر للمرضى بصورة أفضل.
                    </p>

                </div>


                <div class="doctor-profile-progress-score">

                    <strong>
                        {{ $completion }}%
                    </strong>

                    <span>
                        مكتمل
                    </span>

                </div>

            </div>


            <div class="doctor-profile-progress-track">

                <div class="doctor-profile-progress-fill" style="width: {{ $completion }}%;">
                </div>

            </div>


            <div class="doctor-profile-progress-message">

                <span class="doctor-profile-progress-message-icon">
                    {{ $completion == 100 ? '✓' : '✓' }}
                </span>

                <div>

                    @if ($completion == 100)
                        <strong>
                            ملفك مكتمل بالكامل
                        </strong>

                        <span>
                            رائع! ملفك الطبي جاهز بالكامل أمام المرضى.
                        </span>
                    @elseif ($completion >= 85)
                        <strong>
                            ملفك جيد جدًا
                        </strong>

                        <span>
                            تبقى بعض البيانات البسيطة لإكمال ملفك.
                        </span>
                    @else
                        <strong>
                            كمّل ملفك
                        </strong>

                        <span>
                            تبقى بعض البيانات لإكمال ملفك بالشكل الأمثل.
                        </span>
                    @endif

                </div>

            </div>


            <div class="doctor-profile-progress-list">

                <div class="doctor-profile-progress-item is-done">

                    <span class="doctor-profile-progress-check">
                        ✓
                    </span>

                    <span>
                        البيانات الأساسية
                    </span>

                </div>


                <div class="doctor-profile-progress-item is-done">

                    <span class="doctor-profile-progress-check">
                        ✓
                    </span>

                    <span>
                        التخصص
                    </span>

                </div>


                <div class="doctor-profile-progress-item is-done">

                    <span class="doctor-profile-progress-check">
                        ✓
                    </span>

                    <span>
                        العنوان
                    </span>

                </div>


                <div class="doctor-profile-progress-item is-done">

                    <span class="doctor-profile-progress-check">
                        ✓
                    </span>

                    <span>
                        مواعيد العمل
                    </span>

                </div>


                <div class="doctor-profile-progress-item {{ $hasClinicPhotos ? 'is-done' : '' }}">

                    <span class="doctor-profile-progress-check">
                        {{ $hasClinicPhotos ? '✓' : '+' }}
                    </span>

                    <span>
                        صور العيادة
                    </span>

                </div>


                <div class="doctor-profile-progress-item {{ $hasProfilePhoto ? 'is-done' : '' }}">

                    <span class="doctor-profile-progress-check">
                        {{ $hasProfilePhoto ? '✓' : '+' }}
                    </span>

                    <span>
                        الصورة الشخصية
                    </span>

                </div>

            </div>


            @if ($completion < 100)
                <a href="{{ route('doctor.profile.edit') }}" class="doctor-profile-progress-button">

                    <span>
                        إكمال الملف الطبي
                    </span>

                    <span class="doctor-profile-progress-arrow">
                        ←
                    </span>

                </a>
            @endif

        </div>
    @else
        {{-- =========================
            NOT SUBSCRIBED DOCTOR
        ========================== --}}

        <div class="welcome-main welcome-not-subscribed">

            <div class="welcome-content">

                <div class="welcome-label welcome-label-warning">
                    ✦ طوّر ظهورك الطبي
                </div>


                <h1>
                    أهلاً بك، د. {{ $doctorName }}
                </h1>


                <p>
                    ملفك الطبي موجود على دليل الأطباء،
                    ويمكنك تطويره للحصول على ظهور أفضل
                    ومميزات أكثر أمام المرضى.
                </p>


                {{-- Subscription Hint --}}
                <div class="welcome-subscription-hint">

                    <div class="welcome-hint-icon">
                        ♛
                    </div>


                    <div class="welcome-hint-content">

                        <strong>
                            جاهز تخلي حسابك أقوى؟
                        </strong>

                        <span>
                            بالاشتراك تحصل على ظهور أفضل،
                            استقبال الحجوزات أونلاين،
                            ومع الباقات الأعلى يمكنك الحصول على
                            <b>نظام عيادة كامل</b>
                            لإدارة الحجوزات والمرضى والدخل من مكان واحد.
                        </span>

                    </div>

                </div>


                {{-- Subscribe Button --}}
                <a href="" class="welcome-subscribe-btn">

                    <span>
                        ابدأ الاشتراك الآن
                    </span>

                    <span class="welcome-subscribe-arrow">
                        ←
                    </span>

                </a>

            </div>

        </div>


        {{-- =========================
            SUBSCRIPTION CTA CARD
        ========================== --}}

        <div class="today-card today-card-not-subscribed">

            <div class="today-top">

                <div class="today-title">

                    <strong>
                        حسابك غير مشترك
                    </strong>

                    <span>
                        اشترك الآن واستفد من المميزات
                    </span>

                </div>


                <div class="subscription-status">

                    <i></i>

                    غير مشترك

                </div>

            </div>


            <div class="not-subscribed-content">

                <div class="not-subscribed-icon">
                    ♛
                </div>

                <div class="not-subscribed-text">

                    <strong>
                        اجعل ملفك الطبي أقوى
                    </strong>

                    <span>
                        الاشتراك يساعدك على تحسين ظهور ملفك
                        والاستفادة من المميزات المتاحة حسب الباقة.
                    </span>

                </div>

            </div>


            <a href="" class="welcome-subscribe-btn">

                <span>
                    عرض الباقات والاشتراك
                </span>

                <span>
                    ←
                </span>

            </a>

        </div>

    @endif

</section>

<section class="welcome {{ $isSubscribed ? '' : 'welcome-guest' }}">

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

                    <div class="welcome-stat">
                        <div class="welcome-stat-icon">◉</div>
                        <div class="welcome-stat-info">
                            <span>مشاهدات الملف</span>
                            <strong>{{ number_format($profileViews) }}</strong>
                            <small>من {{ number_format($uniqueVisitors) }} زائر مختلف</small>
                        </div>
                    </div>

                    <div class="welcome-stat">
                        <div class="welcome-stat-icon">★</div>
                        <div class="welcome-stat-info">
                            <span>تقييم المرضى</span>
                            <strong>{{ $rating }}</strong>
                        </div>
                    </div>

                    <div class="welcome-stat">
                        <div class="welcome-stat-icon">♥</div>
                        <div class="welcome-stat-info">
                            <span>مرات الحفظ</span>
                            <strong>{{ number_format($favoritesCount) }}</strong>
                        </div>
                    </div>

                </div>

                {{-- Subscription Action --}}
                {{-- Subscription Action --}}
                <a href="{{ route('doctor.subscription') }}"
                    class="welcome-subscription-note welcome-subscription-btn">

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
        {{-- NOT SUBSCRIBED: كارت واحد (ترحيب + إحصائيات | عرض الاشتراك) --}}

        <div class="gx">
            <div class="gx-glow"></div>
            <div class="gx-dots"></div>

            {{-- يمين: الترحيب والإحصائيات --}}
            <div class="gx-main">

                <span class="gx-label">✦ طوّر ظهورك الطبي</span>

                <h1>أهلاً بك، د. {{ $doctorName }}</h1>

                <p>ملفك ظاهر للمرضى الآن. هذه نظرة سريعة على اهتمامهم بملفك.</p>

                <div class="gx-stats">
                    <div class="gx-stat">
                        <span class="gx-stat-ico">◉</span>
                        <div>
                            <small>مشاهدات الملف</small>
                            <strong>{{ number_format($profileViews) }}</strong>
                            <em>من {{ number_format($uniqueVisitors) }} زائر مختلف</em>
                        </div>
                    </div>

                    <div class="gx-stat">
                        <span class="gx-stat-ico">♥</span>
                        <div>
                            <small>مرات الحفظ</small>
                            <strong>{{ number_format($favoritesCount) }}</strong>
                            <em>أضافوك إلى المفضلة</em>
                        </div>
                    </div>
                </div>

                <div class="gx-tip">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <span>الأطباء المشتركون يظهرون أولاً في نتائج البحث ويحصلون على مشاهدات وحجوزات أكثر.</span>
                </div>

            </div>

            {{-- شمال: عرض الاشتراك --}}
            <aside class="gx-offer">

                <div class="gx-offer-head">
                    <span class="gx-crown">♛</span>
                    <div>
                        <b>اجعل ملفك الأقوى</b>
                        <small>حسابك غير مشترك حالياً</small>
                    </div>
                </div>

                <ul class="gx-list">
                    <li>
                        <i class="fa-solid fa-circle-check"></i>
                        <span>ظهور أفضل وشارة <b>طبيب موثوق</b></span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check"></i>
                        <span>صورتك وتقييماتك وموقعك على الخريطة</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check"></i>
                        <span>حجز المواعيد أونلاين من ملفك</span>
                    </li>
                    <li class="is-top">
                        <i class="fa-solid fa-crown"></i>
                        <span>نظام عيادة كامل: حجوزات ومرضى ودخل</span>
                    </li>
                </ul>

                <a href="{{ route('doctor.subscription') }}" class="gx-btn">
                    <span>عرض الباقات والاشتراك</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <small class="gx-note">
                    <i class="fa-solid fa-shield-halved"></i> يمكنك الترقية في أي وقت
                </small>

            </aside>

        </div>
    @endif

</section>

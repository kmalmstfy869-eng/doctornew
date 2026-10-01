<section class="subscription" id="subscription">

    @if ($doctor && $doctor->hasFeature('subscription'))

        {{-- =========================
            ACTIVE SUBSCRIPTION
        ========================== --}}

        <div class="subscription-main">

            <span class="sub-label">
                الاشتراك الحالي
            </span>


            <div class="sub-heading">

                <h2>
                    {{ $plan?->name ?? 'اشتراك نشط' }}
                </h2>

                <span class="sub-status">
                    نشط
                </span>

            </div>


            <p class="sub-description">

                @if ($planSlug && str_starts_with($planSlug, 'prime-'))
                    اشتراك Prime يمنحك ظهورًا أفضل
                    ومعلومات أكثر عن الطبيب والعيادة.
                @elseif ($planSlug && str_starts_with($planSlug, 'professional-'))
                    اشتراك Professional يتيح لك
                    استقبال الحجوزات أونلاين وإدارتها.
                @elseif ($planSlug && str_starts_with($planSlug, 'clinic-system-'))
                    اشتراك Clinic System يمنحك
                    نظامًا متكاملًا لإدارة العيادة.
                @else
                    اشتراكك يمنحك مزايا إضافية
                    لإدارة حضورك على المنصة.
                @endif

            </p>


            <div class="sub-progress">

                <div class="sub-progress-head">

                    <span>
                        الفترة الحالية
                    </span>

                    <span>
                        من {{ number_format($totalDays, 1) }} يوم
                        — متبقي {{ number_format($remainingDays, 1) }} يوم
                    </span>

                </div>


                <div class="sub-progress-bar">

                    <div style="width: {{ $progress }}%;"></div>

                </div>

            </div>


            <div class="sub-features">

                @foreach ($plan?->features ?? [] as $feature)
                    <span class="sub-feature">
                        ✓ {{ $feature }}
                    </span>
                @endforeach

            </div>

        </div>


        <div class="subscription-side">

            <span class="expire-label">
                تاريخ التجديد
            </span>


            <div class="expire-date">
                {{ $renewalDate ?? 'غير محدد' }}
            </div>


            <a href="#" class="upgrade-btn">
                إدارة الاشتراك
            </a>

        </div>
    @else
        {{-- =========================
            FREE / NO ACTIVE SUBSCRIPTION
        ========================== --}}

        <div class="subscription-main">

            <span class="sub-label">
                الاشتراك الحالي
            </span>


            <div class="sub-heading">

                <h2>
                    {{ 'free' }}
                </h2>

                <span class="sub-status free-status">
                    مجاني
                </span>

            </div>


            <p class="sub-description">

                أنت تستخدم الحساب المجاني حاليًا.
                اشترك الآن للحصول على ظهور أفضل
                ومزايا إضافية تساعدك في الوصول
                إلى المزيد من المرضى.

            </p>


            <div class="sub-features">

                <span class="sub-feature">
                    ✓ ملف طبي أساسي
                </span>

                <span class="sub-feature">
                    ✓ ظهور الطبيب في دليل الأطباء
                </span>

                <span class="sub-feature">
                    ✓ عرض بيانات التواصل ومواعيد العمل
                </span>

                <span class="sub-feature">
                    ✓ إمكانية الترقية إلى باقات متقدمة
                </span>


            </div>

        </div>


        <div class="subscription-side">

            <span class="expire-label">
                طوّر حسابك
            </span>


            <div class="expire-date">
                احصل على مزايا أكثر
            </div>


            <a href="#" class="upgrade-btn">
                اشترك الآن
            </a>

        </div>

    @endif

</section>

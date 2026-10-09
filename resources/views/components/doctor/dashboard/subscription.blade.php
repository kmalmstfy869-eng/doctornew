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
                    {{ $plan?->name ? \Illuminate\Support\Str::headline($plan->name) : 'اشتراك نشط' }}
                </h2>

                <span class="sub-status">
                    نشط
                </span>

            </div>


            <p class="sub-description">

                @if ($planSlug && str_starts_with($planSlug, 'prime-'))
                    تفتح لك باقة Prime إحصائيات الملف التفصيلية والتقييمات،
                    مع ظهور أفضل في نتائج البحث.
                @elseif ($planSlug && str_starts_with($planSlug, 'professional-'))
                    كل مزايا Prime، بالإضافة إلى الحجز أونلاين
                    وإدارة الحجوزات من نظام الحجوزات.
                @elseif ($planSlug && str_starts_with($planSlug, 'clinic-system-'))
                    نظام العيادة: إدارة المرضى والحجوزات والدخل والتقارير
                    من مكان واحد.
                @else
                    اشتراكك يفتح لك مزايا إضافية
                    لإدارة ملفك وحضورك على المنصة.
                @endif

            </p>


            <div class="sub-progress">

                <div class="sub-progress-head">

                    <span>
                        مدة الاشتراك
                    </span>

                    <span>
                        متبقي {{ number_format(ceil($remainingDays)) }} يوم
                        من {{ number_format(round($totalDays)) }} يوم
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


            <a href="{{ route('doctor.subscription') }}" class="upgrade-btn">
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
                    مجاني
                </h2>

                <span class="sub-status free-status">
                    مجاني
                </span>

            </div>


            <p class="sub-description">

                حسابك المجاني يعرض بياناتك الأساسية في دليل الأطباء.
                اشترك لتفتح إحصائيات الملف والتقييمات
                وتظهر أفضل في نتائج البحث.

            </p>


            <div class="sub-features">

                <span class="sub-feature">
                    ✓ ملف طبي أساسي
                </span>

                <span class="sub-feature">
                    ✓ ظهورك في دليل الأطباء
                </span>

                <span class="sub-feature">
                    ✓ بيانات التواصل ومواعيد العمل
                </span>

                <span class="sub-feature">
                    ✓ إجمالي مشاهدات ملفك
                </span>

            </div>

        </div>


        <div class="subscription-side">

            <span class="expire-label">
                طوّر حسابك
            </span>


            <div class="expire-date">
                إحصائيات وتقييمات وحجز أونلاين
            </div>


            <a href="{{ route('doctor.subscription') }}" class="upgrade-btn">
                اشترك الآن
            </a>

        </div>

    @endif

</section>

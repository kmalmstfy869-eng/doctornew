@extends('doctor.layouts.app')

@section('title', 'اشتراكاتي | لوحة تحكم الطبيب')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/plans.css') }}">
@endpush

@section('content')

    <div class="sp-page" id="spPage">

        {{-- ================= HERO ================= --}}
        <section class="sp-hero">

            <div class="sp-hero-content">

                @if ($isSubscribed)

                    <span class="sp-label">✦ اشتراك نشط</span>

                    <h1>باقة {{ $currentTier['name'] }}</h1>

                    <p>{{ $currentTier['desc'] }}</p>

                    <div class="sp-hero-actions">

                        @if ($expiringSoon)
                            <a href="{{ $renewLink }}" target="_blank" rel="noopener" class="sp-btn sp-btn-light">
                                تجديد الاشتراك
                            </a>
                        @endif

                        @unless ($isHighest)
                            <a href="#sp-plans" class="sp-btn sp-btn-ghost">
                                ترقية الاشتراك
                            </a>
                        @endunless

                    </div>

                @else

                    <span class="sp-label">✦ طوّر ظهورك الطبي</span>

                    <h1>اختر الباقة المناسبة لك</h1>

                    <p>
                        الاشتراك يرفع ظهور ملفك أمام المرضى ويفتح لك الحجز أونلاين وأدوات إدارة العيادة.
                        للاشتراك تواصل معنا وسيتم تفعيل باقتك.
                    </p>

                    <div class="sp-hero-actions">
                        <a href="#sp-plans" class="sp-btn sp-btn-light">استعرض الباقات</a>
                    </div>

                @endif

            </div>

            @if ($isSubscribed)
                <div class="sp-hero-stats">

                    <div class="sp-stat">
                        <span>المدة</span>
                        <strong>{{ $currentDuration ?? '—' }}</strong>
                    </div>

                    <div class="sp-stat">
                        <span>الأيام المتبقية</span>
                        <strong>{{ $daysLeft !== null ? $daysLeft . ' يوم' : '—' }}</strong>
                    </div>

                    <div class="sp-stat">
                        <span>تاريخ البداية</span>
                        <strong>{{ $subscription->start_date?->translatedFormat('j F Y') ?? '—' }}</strong>
                    </div>

                    <div class="sp-stat">
                        <span>تاريخ الانتهاء</span>
                        <strong>{{ $subscription->end_date?->translatedFormat('j F Y') ?? '—' }}</strong>
                    </div>

                </div>
            @endif

        </section>


        {{-- ================= RENEW ALERT ================= --}}
        @if ($isSubscribed && $expiringSoon)
            <section class="sp-alert">

                <div class="sp-alert-text">
                    <strong>اشتراكك ينتهي قريبًا</strong>
                    <span>جدّد الآن للحفاظ على مميزات ملفك الطبي دون انقطاع.</span>
                </div>

                <a href="{{ $renewLink }}" target="_blank" rel="noopener" class="sp-btn sp-btn-warning">
                    جدّد الآن
                </a>

            </section>
        @endif


        {{-- ================= PLANS ================= --}}
        <div class="sp-heading sp-heading-center" id="sp-plans">
            <h2>{{ $isSubscribed ? 'الباقات' : 'اختر الباقة المناسبة لك' }}</h2>
            <p>{{ $isSubscribed ? 'باقتك الحالية وخيارات الترقية' : 'كل باقة تمنحك مزايا تطوّر ظهور ملفك الطبي' }}</p>

            @unless ($isHighest)
                <div class="sp-duration">
                    @foreach ($durations as $dKey => $d)
                        <button type="button" data-duration="{{ $dKey }}" class="{{ $dKey === $initialDuration ? 'active' : '' }}">
                            {{ $d['label'] }}
                        </button>
                    @endforeach
                </div>
            @endunless
        </div>

        <section class="sp-plans">

            @foreach ($tiers as $tier)
                @php $featured = $tier['key'] === 'professional'; @endphp

                <article class="sp-plan {{ $tier['state'] === 'current' ? 'is-current' : '' }} {{ $tier['state'] === 'lower' ? 'is-lower' : '' }} {{ $featured && $tier['state'] !== 'current' ? 'is-featured' : '' }}">

                    @if ($tier['state'] === 'current')
                        <span class="sp-plan-tag">باقتك الحالية</span>
                    @elseif ($featured)
                        <span class="sp-plan-tag gold"><i class="fa-solid fa-star"></i> الأفضل للأطباء</span>
                    @endif

                    <div class="sp-plan-icon">
                        <i class="fa-solid {{ $tier['icon'] }}"></i>
                    </div>

                    <div class="sp-plan-name">
                        <h3>{{ $tier['name'] }}</h3>
                        <p>{{ $tier['desc'] }}</p>
                    </div>

                    @foreach ($tier['durations'] as $dKey => $d)
                        <div class="sp-price" data-d="{{ $dKey }}" @if ($dKey !== $initialDuration) hidden @endif>
                            <strong>{{ number_format($d['price']) }}</strong>
                            <span>جنيه / {{ $d['unit'] }}</span>
                            @if ($d['locked'] ?? false)
                                <em class="sp-price-lock">سعرك الحالي</em>
                            @endif
                        </div>
                    @endforeach

                    <ul class="sp-features">
                        @foreach ($tier['features'] as $feature)
                            <li><i class="fa-solid fa-check"></i>{{ $feature }}</li>
                        @endforeach

                        @foreach ($tier['off'] as $feature)
                            <li class="off"><i class="fa-solid fa-xmark"></i>{{ $feature }}</li>
                        @endforeach
                    </ul>

                    @if ($tier['state'] === 'new' || $tier['state'] === 'upgrade')

                        @foreach ($tier['durations'] as $dKey => $d)
                            <a href="{{ $d['link'] }}" target="_blank" rel="noopener"
                                class="sp-btn {{ $featured ? 'sp-btn-primary' : 'sp-btn-outline' }} sp-btn-block"
                                data-d="{{ $dKey }}" @if ($dKey !== $initialDuration) hidden @endif>
                                {{ $tier['state'] === 'new' ? 'تواصل معنا للاشتراك' : 'ترقية اشتراكك' }}
                                <i class="fa-solid fa-crown"></i>
                            </a>
                        @endforeach

                    @elseif ($tier['state'] === 'current')

                        <span class="sp-btn sp-btn-current sp-btn-block">باقتك الحالية</span>

                    @endif

                </article>
            @endforeach

        </section>


        {{-- ================= GUEST: BEFORE / AFTER ================= --}}
        @unless ($isSubscribed)
            <section class="sp-compare-wrap">

                <div class="sp-compare-title">
                    <h2>الفرق الذي سيظهر في ملفك</h2>
                    <p>الاشتراك يفتح لك إمكانية إضافة معلومات أكثر للمرضى</p>
                </div>

                <div class="sp-compare">

                    <div class="sp-compare-box after">
                        <div class="sp-compare-head">
                            <span class="sp-compare-icon"><i class="fa-solid fa-circle-check"></i></span>
                            <h3>بعد الاشتراك</h3>
                        </div>
                        <ul>
                            <li><i class="fa-solid fa-circle-check"></i> ملف طبي متكامل بشارة طبيب موثوق</li>
                            <li><i class="fa-solid fa-circle-check"></i> صورتك وصور العيادة وموقعها على الخريطة</li>
                            <li><i class="fa-solid fa-circle-check"></i> الخدمات الطبية وتقييمات المرضى</li>
                            <li><i class="fa-solid fa-circle-check"></i> حجز أونلاين ونظام عيادة (حسب الباقة)</li>
                        </ul>
                    </div>

                    <div class="sp-compare-box before">
                        <div class="sp-compare-head">
                            <span class="sp-compare-icon"><i class="fa-solid fa-lock"></i></span>
                            <h3>قبل الاشتراك</h3>
                        </div>
                        <ul>
                            <li><i class="fa-solid fa-circle-xmark"></i> معلومات أساسية فقط</li>
                            <li><i class="fa-solid fa-circle-xmark"></i> بدون صورة شخصية أو صور عيادة</li>
                            <li><i class="fa-solid fa-circle-xmark"></i> بدون خدمات أو تقييمات أو خريطة</li>
                            <li><i class="fa-solid fa-circle-xmark"></i> بدون حجز أونلاين</li>
                        </ul>
                    </div>

                </div>

            </section>
        @endunless




    </div>

    <script>
        (function () {
            const buttons = document.querySelectorAll('.sp-duration button');

            function setDuration(d) {
                buttons.forEach(b => b.classList.toggle('active', b.dataset.duration === d));
                document.querySelectorAll('#spPage [data-d]').forEach(el => {
                    el.hidden = el.dataset.d !== d;
                });
            }

            buttons.forEach(b => b.addEventListener('click', () => setDuration(b.dataset.duration)));
        })();
    </script>

@endsection

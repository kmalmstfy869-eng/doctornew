@extends('doctor.layouts.app')

@section('title', 'ملفي الطبي | لوحة تحكم الطبيب')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/doctor_details.css') }}">
@endpush

@section('content')

    <main class="med-profile-page">

        <div class="med-container">

            {{-- =========================================================
                DOCTOR HERO
            ========================================================== --}}

            <section class="med-doctor-hero">

                <div class="med-doctor-main">

                    {{-- Doctor Image --}}
                    <div class="med-doctor-image-wrap">

                        @if (
                            $doctor->hasFeature('subscription') &&
                                !empty($doctor?->doctor_image) &&
                                \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->doctor_image))
                            <img src="{{ asset('storage/' . $doctor->doctor_image) }}" alt="د.{{ $doctor_name }}"
                                class="med-doctor-image">

                            <span class="med-verified-badge">
                                <i class="fa-solid fa-circle-check"></i>
                                طبيب موثوق
                            </span>
                        @else
                            <div class="med-doctor-image-placeholder">

                                <div class="med-placeholder-icon">
                                    <i class="fa-solid fa-user-doctor"></i>
                                </div>

                                <strong>
                                    صورة الطبيب غير متاحة
                                </strong>

                                <span>
                                    لم يتم إضافة صورة للملف الطبي
                                </span>

                            </div>
                        @endif

                    </div>


                    {{-- Doctor Information --}}
                    <div class="med-doctor-info">

                        <div class="med-doctor-name-row">

                            <div>

                                <span class="med-doctor-label">
                                    الملف الطبي
                                </span>

                                <h1 class="med-doctor-name">

                                    <span class="med-doctor-name-icon">
                                        <i class="fa-solid fa-user-doctor"></i>
                                    </span>

                                    <span>
                                        د. {{ $doctor_name ?? 'اسم الطبيب' }}
                                    </span>

                                </h1>

                                <p class="med-doctor-job">
                                    {{ $doctor?->specialty?->title }}
                                </p>

                            </div>


                            {{-- Buttons --}}
                            <div class="med-doctor-buttons">

                                <button type="button" class="med-share-button med-view-only-action"
                                    aria-label="مشاركة الصفحة" title="مشاركة الصفحة">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </button>

                            </div>

                        </div>


                        {{-- Doctor Meta --}}
                        <div class="med-doctor-meta">

                            @if ($doctor->hasFeature('subscription'))
                                <span>

                                    <i class="fa-solid fa-star"></i>

                                    {{ number_format($doctor?->rating?->avg('rating') ?? 0, 1) }}

                                    <small>
                                        ({{ $doctor?->rating?->count() }} تقييم)
                                    </small>

                                </span>
                            @endif


                            <span>

                                <i class="fa-solid fa-briefcase"></i>

                                {{ $doctor?->experience }}

                                سنة خبرة

                            </span>


                            <span>

                                <i class="fa-solid fa-location-dot"></i>

                                {{ $doctor?->area?->name }}

                            </span>

                        </div>


                        {{-- Actions --}}
                        <div class="med-doctor-actions">

                            {{-- Phone --}}
                            <a href="tel:{{ $doctor?->phone }}" class="med-primary-action  med-view-only-action">
                                <i class="fa-solid fa-phone"></i>
                                اتصل بالعيادة
                            </a>


                            {{-- WhatsApp --}}
                            <a href="https://wa.me/{{ $doctor?->whahtsapp }}" target="_blank" rel="noopener"
                                class="med-whatsapp-action  med-view-only-action">
                                <i class="fa-brands fa-whatsapp"></i>
                                تواصل عبر واتساب
                            </a>


                            {{-- Booking --}}
                            @if ($doctor->hasFeature('booking'))
                                <button type="button" class="med-book-now-action med-view-only-action">
                                    <i class="fa-regular fa-calendar-check"></i>
                                    احجز الآن
                                </button>
                            @endif

                        </div>

                    </div>

                </div>

            </section>


            {{-- =========================================================
                PROFILE LAYOUT
            ========================================================== --}}

            <div class="med-profile-layout">

                {{-- =====================================================
                    MAIN CONTENT
                ====================================================== --}}

                <div class="med-profile-content">


                    {{-- =================================================
                        About Doctor
                    ================================================== --}}

                    <section class="med-content-card">

                        <div class="med-card-title">

                            <div class="med-card-title-icon">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>

                            <div>

                                <h2>
                                    نبذة عن الطبيب
                                </h2>

                                <p>
                                    معلومات وخبرة الطبيب
                                </p>

                            </div>

                        </div>


                        <p class="med-about-text">
                            {{ $doctor?->bio }}
                        </p>

                    </section>


                    {{-- =================================================
                        Working Hours
                    ================================================== --}}

                    @if (!empty($doctor?->working_hours))
                        <section class="med-content-card med-working-hours-card">

                            <div class="med-card-title">

                                <div class="med-card-title-icon">
                                    <i class="fa-regular fa-clock"></i>
                                </div>

                                <div>

                                    <span class="med-section-kicker">
                                        مواعيد العيادة
                                    </span>

                                    <h2>
                                        مواعيد العمل
                                    </h2>

                                    <p>
                                        مواعيد استقبال المرضى داخل العيادة
                                    </p>

                                </div>

                            </div>


                            <div class="med-working-hours-box">

                                <div class="med-working-hours-icon">
                                    <i class="fa-regular fa-calendar-days"></i>
                                </div>

                                <div class="med-working-hours-content">

                                    <strong>
                                        مواعيد العيادة
                                    </strong>

                                    <p>
                                        {{ $doctor?->working_hours }}
                                    </p>

                                </div>

                            </div>

                        </section>
                    @endif


                    {{-- =================================================
                        Services
                    ================================================== --}}

                    @if ($doctor->hasFeature('subscription') && !empty($doctor?->services))

                        <section class="med-content-card">

                            <div class="med-card-title">

                                <div class="med-card-title-icon">
                                    <i class="fa-solid fa-stethoscope"></i>
                                </div>

                                <div>

                                    <span class="med-section-kicker">
                                        الخدمات الطبية
                                    </span>

                                    <h2>
                                        الخدمات الطبية
                                    </h2>

                                    <p>
                                        أهم الخدمات المتاحة داخل العيادة
                                    </p>

                                </div>

                            </div>


                            <div class="med-services-grid">

                                @foreach ($doctor?->services as $item)
                                    <div class="med-service-card">

                                        <div class="med-service-icon">
                                            <i class="fa-solid fa-heart-pulse"></i>
                                        </div>

                                        <div>

                                            <h3>
                                                {{ $item }}
                                            </h3>

                                        </div>

                                    </div>
                                @endforeach

                            </div>

                        </section>

                    @endif


                    {{-- =================================================
                        Clinic Images
                    ================================================== --}}

                    @if ($doctor?->hasFeature('subscription') && !empty($doctor?->clinic_images))

                        <section class="med-content-card">

                            <div class="med-card-title">

                                <div class="med-card-title-icon">
                                    <i class="fa-solid fa-images"></i>
                                </div>

                                <div>

                                    <span class="med-section-kicker">
                                        {{ $doctor?->clinic_name }}
                                    </span>

                                    <h2>
                                        صور العيادة
                                    </h2>

                                    <p>
                                        تعرف على مكان العيادة وتجهيزاتها
                                    </p>

                                </div>

                            </div>


                            <div class="med-gallery">

                                @foreach ($doctor?->clinic_images as $image)
                                    <div class="med-gallery-image" data-image="{{ asset('storage/' . $image) }}">

                                        <img src="{{ asset('storage/' . $image) }}" alt="صورة العيادة">

                                        <div class="med-image-overlay">
                                            <i class="fa-solid fa-expand"></i>
                                        </div>

                                    </div>
                                @endforeach

                            </div>

                        </section>

                    @endif


                    {{-- =================================================
                        Booking
                    ================================================== --}}

                    @if ($doctor->hasFeature('booking'))

                        <section class="med-content-card med-booking-card" id="med-booking">

                            <div class="med-card-title">

                                <div class="med-card-title-icon">
                                    <i class="fa-regular fa-calendar-check"></i>
                                </div>

                                <div>

                                    <span class="med-section-kicker">
                                        حجز إلكتروني
                                    </span>

                                    <h2>
                                        حجز موعد
                                    </h2>

                                    <p>
                                        اختر اليوم ثم اختر الساعة المناسبة لك
                                    </p>

                                </div>

                            </div>


                            <div class="med-booking-info">

                                <div>

                                    <strong>
                                        المواعيد المتاحة
                                    </strong>

                                    <span>
                                        اختر اليوم لعرض جميع المواعيد المتاحة
                                    </span>

                                </div>


                                <div class="med-booking-available">

                                    <i class="fa-solid fa-circle"></i>

                                    متاح للحجز

                                </div>

                            </div>


                            <div class="med-days-list">

                                {{-- Day 1 --}}

                                <div class="med-day-accordion active" data-day-index="0">

                                    <button type="button" class="med-day-header med-view-only-action">

                                        <div class="med-day-info">

                                            <span class="med-day-name">
                                                اليوم
                                            </span>

                                            <strong>
                                                السبت 22 أغسطس
                                            </strong>

                                        </div>


                                        <div class="med-day-header-meta">

                                            <span>
                                                20 موعد متاح
                                            </span>

                                            <i class="fa-solid fa-chevron-down"></i>

                                        </div>

                                    </button>


                                    <div class="med-day-times">

                                        @foreach (['04:00 م', '04:30 م', '05:00 م', '05:30 م', '06:00 م', '06:30 م', '07:00 م', '07:30 م', '08:00 م', '08:30 م', '09:00 م', '09:30 م', '10:00 م', '10:30 م', '11:00 م', '11:30 م', '12:00 ص', '12:30 ص', '01:00 ص', '01:30 ص'] as $time)
                                            <button type="button" class="med-view-only-action"
                                                data-time="{{ $time }}">
                                                {{ $time }}
                                            </button>
                                        @endforeach

                                    </div>

                                </div>

                            </div>


                            <div class="med-selected-appointment">

                                <div class="med-selected-info">

                                    <div class="med-selected-icon">
                                        <i class="fa-regular fa-calendar-check"></i>
                                    </div>

                                    <div>

                                        <span>
                                            الموعد المختار
                                        </span>

                                        <strong id="medSelectedText">
                                            لم يتم اختيار موعد بعد
                                        </strong>

                                    </div>

                                </div>


                                <button type="button" class="med-confirm-button med-view-only-action"
                                    id="medConfirmBooking">
                                    تأكيد الحجز
                                    <i class="fa-solid fa-arrow-left"></i>
                                </button>

                            </div>

                        </section>

                    @endif


                    {{-- =================================================
                        Reviews
                    ================================================== --}}

                    @if ($doctor->hasFeature('subscription') && !empty($doctor?->rating))

                        <section class="med-content-card" id="reviews">

                            <div class="med-card-title">

                                <div class="med-card-title-icon">
                                    <i class="fa-solid fa-star"></i>
                                </div>

                                <div>

                                    <span class="med-section-kicker">
                                        آراء المرضى
                                    </span>

                                    <h2>
                                        تقييمات المرضى
                                    </h2>

                                    <p>
                                        تجارب وآراء المرضى السابقين
                                    </p>

                                </div>

                            </div>


                            @php
                                $averageRating = $doctor?->rating->avg('rating') ?? 0;
                            @endphp


                            <div class="med-review-summary">

                                <div class="med-big-rating">

                                    <strong>
                                        {{ number_format($averageRating, 1) }}
                                    </strong>

                                    <div class="med-review-stars">

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($averageRating))
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor

                                    </div>

                                    <span>
                                        من 5
                                    </span>

                                </div>


                                <div class="med-review-summary-text">

                                    @php

                                        $ratingText = match (true) {
                                            $averageRating >= 4 => 'تقييم ممتاز',

                                            $averageRating >= 3 => 'تقييم جيد جدًا',

                                            $averageRating >= 2 => 'تقييم جيد',

                                            $averageRating > 0 => 'تقييم ضعيف',

                                            default => 'لا يوجد تقييم',
                                        };

                                    @endphp


                                    <h3>
                                        {{ $ratingText }}
                                    </h3>

                                    <p>
                                        بناءً على
                                        {{ $doctor?->rating?->count() }}
                                        تقييم من المرضى.
                                    </p>

                                </div>

                            </div>


                            {{-- Review Form - View Only --}}

                            <div class="med-review-form">

                                <div class="med-review-field">

                                    <label>
                                        تقييمك
                                    </label>


                                    <div class="med-star-rating">

                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" class="med-view-only-action"
                                                data-rating="{{ $i }}" aria-label="{{ $i }} نجوم">
                                                <i class="fa-solid fa-star"></i>
                                            </button>
                                        @endfor


                                        <span id="medRatingLabel">
                                            اختر التقييم
                                        </span>

                                    </div>

                                </div>


                                <div class="med-review-field">

                                    <label>
                                        اكتب تجربتك
                                    </label>

                                    <textarea class="med-review-textarea med-view-only-action" placeholder="اكتب رأيك وتجربتك مع الطبيب..." readonly></textarea>

                                </div>


                                <button type="button" class="med-submit-review med-view-only-action">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    إرسال التقييم
                                </button>

                            </div>


                            {{-- Reviews List --}}

                            @forelse ($ratings as $rating)
                                <article class="med-review-item">

                                    <div class="med-review-head">

                                        <div class="med-review-user">

                                            <div class="med-user-avatar">
                                                {{ mb_substr($rating?->user?->name ?? 'م', 0, 1) }}
                                            </div>

                                            <div>

                                                <h4>
                                                    {{ $rating?->user?->name ?? 'مستخدم' }}
                                                </h4>

                                                <span>
                                                    {{ $rating?->created_at?->diffForHumans() }}
                                                </span>

                                            </div>

                                        </div>


                                        <div class="med-review-stars">

                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $rating?->rating)
                                                    <i class="fa-solid fa-star"></i>
                                                @else
                                                    <i class="fa-regular fa-star"></i>
                                                @endif
                                            @endfor

                                        </div>

                                    </div>


                                    @if (!empty($rating?->comment))
                                        <p>
                                            {{ $rating?->comment }}
                                        </p>
                                    @endif

                                </article>

                            @empty

                                <div class="med-no-reviews">

                                    <i class="fa-regular fa-star"></i>

                                    <h3>
                                        لا توجد تقييمات حتى الآن
                                    </h3>

                                    <p>
                                        كن أول شخص يقيّم هذا الطبيب.
                                    </p>

                                </div>
                            @endforelse

                        </section>

                    @endif

                </div>


                {{-- =====================================================
                    SIDEBAR
                ====================================================== --}}

                <aside class="med-profile-sidebar">


                    {{-- Contact --}}
                    <section class="med-sidebar-card med-contact-card">

                        <div class="med-sidebar-heading">

                            <div class="med-sidebar-icon">
                                <i class="fa-solid fa-headset"></i>
                            </div>

                            <div>

                                <h3>
                                    تواصل مع العيادة
                                </h3>

                                <p>
                                    تواصل معنا مباشرة
                                </p>

                            </div>

                        </div>


                        <a href="tel:{{ $doctor?->phone }}" class="med-sidebar-contact phone med-view-only-action">

                            <div>
                                <i class="fa-solid fa-phone"></i>
                            </div>

                            <span>

                                <small>
                                    اتصل بالعيادة
                                </small>

                                <strong>
                                    {{ $doctor?->phone }}
                                </strong>

                            </span>

                            <i class="fa-solid fa-chevron-left"></i>

                        </a>


                        <button type="button" class="med-copy-number med-view-only-action"
                            data-phone="{{ $doctor?->phone }}">

                            <i class="fa-regular fa-copy"></i>

                            نسخ رقم الهاتف

                        </button>


                        <a href="https://wa.me/{{ $doctor?->whahtsapp }}" target="_blank" rel="noopener"
                            class="med-sidebar-contact whatsapp med-view-only-action">

                            <div>
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>

                            <span>

                                <small>
                                    تواصل عبر
                                </small>

                                <strong>
                                    واتساب
                                </strong>

                            </span>

                            <i class="fa-solid fa-chevron-left"></i>

                        </a>

                    </section>


                    {{-- Clinic --}}
                    <section class="med-sidebar-card" id="med-clinic">

                        <div class="med-sidebar-heading">

                            <div class="med-sidebar-icon">
                                <i class="fa-solid fa-hospital"></i>
                            </div>

                            <div>

                                <h3>
                                    معلومات العيادة
                                </h3>

                                <p>
                                    مكان العيادة وموقعها
                                </p>

                            </div>

                        </div>


                        <h4 class="med-clinic-name">
                            {{ $doctor?->clinic_name }}
                        </h4>


                        <div class="med-address">

                            <i class="fa-solid fa-location-dot"></i>

                            <span>
                                {{ $doctor?->address }}
                            </span>

                        </div>


                        <div class="med-address">

                            <i class="fa-regular fa-clock"></i>

                            <span>
                                {{ $doctor?->working_hours }}
                            </span>

                        </div>


                        @if (!empty($doctor?->google_maps_url) && $doctor?->hasFeature('subscription'))
                            <div class="med-map-box">

                                <iframe src="{{ $doctor?->google_maps_url }}" loading="lazy" allowfullscreen></iframe>

                            </div>


                            <a href="{{ $doctor?->google_maps_url }}" target="_blank" rel="noopener"
                                class="med-map-button med-view-only-action">

                                <i class="fa-solid fa-location-arrow"></i>

                                فتح الموقع على الخريطة

                            </a>
                        @endif

                    </section>


                    {{-- Price --}}
                    <section class="med-sidebar-card med-price-card">

                        <span>
                            سعر الكشف
                        </span>


                        <strong>

                            {{ $doctor?->consultation_price }}

                            <small>
                                جنيه
                            </small>

                        </strong>


                        <p>
                            شامل الاستشارة الطبية
                        </p>


                        @if ($doctor->hasFeature('booking'))
                            <a href="#med-booking" class="med-book-sidebar med-view-only-action">
                                احجز موعدك الآن
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        @endif

                    </section>

                </aside>

            </div>

        </div>

    </main>


    {{-- ================================================================
        IMAGE MODAL
    ================================================================= --}}

    <div class="med-image-modal" id="medImageModal">

        <button type="button" class="med-close-modal" id="medCloseModal">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <img src="" alt="صورة العيادة" id="medModalImage">

    </div>

@endsection

@extends('home.layout.app')

@section('title', 'تفاصيل الدكتور | دليل الأطباء')

@section('content')

    <main class="med-profile-page">

        <div class="med-container">

            {{-- Breadcrumb --}}
            <div class="breadcrumb">

                <a href="{{ route('home') }}">
                    الرئيسية
                </a>

                <i class="fa-solid fa-chevron-left"></i>

                <a href="{{ route('doctors.index') }}">
                    الاطباء
                </a>

                <i class="fa-solid fa-chevron-left"></i>

                <span>
                    تفاصيل الطبيب
                </span>

            </div>


            {{-- Doctor Hero --}}
            <section class="med-doctor-hero">

                <div class="med-doctor-main">

                    {{-- Doctor Image --}}
                    <div class="med-doctor-image-wrap">

                        @if ($doctorImageExists)
                            <img src="{{ asset('storage/' . $doctor->doctor_image) }}" alt="د.{{ $doctor->user->name }}"
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
                                        د. {{ $doctor?->user?->name ?? 'اسم الطبيب' }}
                                    </span>

                                </h1>

                                <p class="med-doctor-job">
                                    {{ $doctor?->specialty?->title }}
                                </p>

                            </div>


                            <div class="med-doctor-buttons">

                                <button type="button" class="med-share-button" id="medShareButton"
                                    aria-label="مشاركة الصفحة" title="مشاركة الصفحة">

                                    <i class="fa-solid fa-share-nodes"></i>

                                </button>


                                @auth

                                    <button type="button" class="med-favorite-button" id="medFavoriteButton"
                                        aria-label="إضافة إلى المفضلة">

                                        <i class="fa-regular fa-heart"></i>

                                    </button>

                                @endauth

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

                            <a href="tel:{{ $doctor?->phone }}" class="med-primary-action">

                                <i class="fa-solid fa-phone"></i>

                                اتصل بالعيادة

                            </a>


                            <a href="https://wa.me/{{ $doctor?->whatsapp }}" target="_blank" rel="noopener"
                                class="med-whatsapp-action">

                                <i class="fa-brands fa-whatsapp"></i>

                                تواصل عبر واتساب

                            </a>


                            @if ($doctor->hasFeature('booking'))
                                <a href="#med-booking" class="med-book-now-action">

                                    <i class="fa-regular fa-calendar-check"></i>

                                    احجز الآن

                                </a>
                            @endif

                        </div>

                    </div>

                </div>

            </section>



            <div class="med-profile-layout">

                <div class="med-profile-content">


                    {{-- About Doctor --}}
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



                    {{-- Working Hours --}}
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



                    {{-- Services --}}
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



                    {{-- Clinic Images --}}
                    @if ($doctor->hasFeature('subscription') && $existingClinicImages->isNotEmpty())
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

                                @foreach ($existingClinicImages as $image)
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



                    {{-- Booking --}}
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

                                @forelse ($bookingDays as $index => $day)
                                    <div class="med-day-accordion {{ $index === 0 ? 'active' : '' }}"
                                        data-day-index="{{ $index }}" data-date="{{ $day['date'] }}">

                                        <button type="button" class="med-day-header">

                                            <div class="med-day-info">

                                                <span class="med-day-name">
                                                    {{ $day['day_name'] }}
                                                </span>

                                                <strong>
                                                    {{ $day['formatted_date'] }}
                                                </strong>

                                            </div>


                                            <div class="med-day-header-meta">

                                                <span>
                                                    {{ $day['slots_count'] }} موعد
                                                </span>

                                                <i class="fa-solid fa-chevron-down"></i>

                                            </div>

                                        </button>


                                        <div class="med-day-times">

                                            @foreach ($day['slots'] as $slot)
                                                @php
                                                    $isBooked = $slot['is_booked'];
                                                    $isExpired = $slot['is_expired'] ?? false;
                                                    $slotTime = \Carbon\Carbon::createFromFormat(
                                                        'H:i',
                                                        $slot['start_time'],
                                                    );
                                                @endphp

                                                <button type="button"
                                                    class="med-slot-button {{ $isBooked ? 'booked' : '' }} {{ $isExpired && !$isBooked ? 'expired' : '' }}"
                                                    data-date="{{ $day['date'] }}"
                                                    data-start="{{ $slot['start_time'] }}"
                                                    {{ $isBooked || $isExpired ? 'disabled' : '' }}
                                                    aria-disabled="{{ $isBooked || $isExpired ? 'true' : 'false' }}"
                                                    title="{{ $isBooked ? 'هذا الموعد محجوز بالفعل' : ($isExpired ? 'هذا الموعد انتهى' : 'اختيار هذا الموعد') }}">

                                                    <span class="med-slot-time">

                                                        {{ $slotTime->format('h:i') }}

                                                        {{ $slotTime->format('A') === 'AM' ? 'ص' : 'م' }}

                                                    </span>


                                                    @if ($isBooked)
                                                        <span class="med-slot-booked-label">
                                                            محجوز
                                                        </span>
                                                    @elseif ($isExpired)
                                                        <span class="med-slot-expired-label">
                                                            انتهى
                                                        </span>
                                                    @endif

                                                </button>
                                            @endforeach

                                        </div>

                                    </div>

                                @empty

                                    <x-home.banner.no_results logo="fa-solid fa-calendar-xmark"
                                        title="لا توجد حجوزات لهذا الدكتور"
                                        content="لا توجد حجوزات متاحة حاليًا لهذا الدكتور." />
                                @endforelse

                            </div>



                            {{-- Selected Appointment --}}
                            @if ($bookingDays->isNotEmpty())
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


                                    <button type="button" class="med-confirm-button" id="medConfirmBooking" disabled>

                                        تأكيد الحجز

                                        <i class="fa-solid fa-arrow-left"></i>

                                    </button>

                                </div>
                            @endif

                        </section>
                    @endif



                    {{-- Reviews --}}
                    @if ($doctor->hasFeature('subscription') && !empty($doctor?->rating))
                        <section class="med-content-card">

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



                            {{-- Add Review --}}
                            <form action="{{ route('ratings.store') }}" method="POST" id="medReviewForm">

                                @csrf


                                <div class="med-review-field">

                                    <label>
                                        تقييمك
                                    </label>


                                    <div class="med-star-rating">

                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" data-rating="{{ $i }}"
                                                aria-label="{{ $i }} نجوم">

                                                <i class="fa-solid fa-star"></i>

                                            </button>
                                        @endfor


                                        <span id="medRatingLabel">
                                            اختر التقييم
                                        </span>

                                    </div>


                                    <input type="hidden" name="rating" id="medRatingValue">

                                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">


                                    @error('rating')
                                        <span class="field-error">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>


                                <div class="med-review-field">

                                    <label>
                                        اكتب تجربتك
                                    </label>


                                    <textarea name="comment" class="med-review-textarea" placeholder="اكتب رأيك وتجربتك مع الطبيب..." required>{{ old('comment') }}</textarea>


                                    @error('comment')
                                        <span class="field-error">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>


                                <button type="submit" class="med-submit-review">

                                    <i class="fa-solid fa-paper-plane"></i>

                                    إرسال التقييم

                                </button>

                            </form>



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


                            @if ($ratings?->hasPages())
                                <div class="med-reviews-pagination">

                                    {{ $ratings->withQueryString()->fragment('reviews')->links('vendor.pagination.custom') }}

                                </div>
                            @endif

                        </section>
                    @endif

                </div>



                {{-- Sidebar --}}
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


                        <a href="tel:{{ $doctor?->phone }}" class="med-sidebar-contact phone">

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


                        <button type="button" class="med-copy-number" id="medCopyNumber"
                            data-phone="{{ $doctor?->phone }}">

                            <i class="fa-regular fa-copy"></i>

                            نسخ رقم الهاتف

                        </button>


                        <a href="https://wa.me/{{ $doctor?->whatsapp }}" target="_blank" rel="noopener"
                            class="med-sidebar-contact whatsapp">

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


                        @if ($mapSrc && $doctor->hasFeature('subscription'))
                            <div class="med-map-box">
                                <iframe src="{{ $mapSrc }}" loading="lazy" allowfullscreen></iframe>
                            </div>

                            <a href="{{ $doctor->google_maps_url }}" target="_blank" rel="noopener"
                                class="med-map-button">
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
                            <a href="#med-booking" class="med-book-sidebar">

                                احجز موعدك الآن

                                <i class="fa-solid fa-arrow-left"></i>

                            </a>
                        @endif

                    </section>

                </aside>

            </div>

        </div>

    </main>


    {{-- Similar Doctors --}}
    <section class="med-similar-section">

        <div class="med-container">

            <div class="med-section-header">

                <div>

                    <span>
                        اقتراحات لك
                    </span>

                    <h2>
                        أطباء مشابهون
                    </h2>

                </div>


                <a href="{{ route('doctors.index') }}">

                    عرض جميع الأطباء

                    <i class="fa-solid fa-arrow-left"></i>

                </a>

            </div>


            @if ($similar_doctors?->isNotEmpty())
                <x-home.doctors.doctors_grid :doctors="$similar_doctors" />
            @else
                <x-home.banner.no_results logo="fa-solid fa-user-doctor" title="لا يوجد أطباء مطابقون"
                    content="جرب البحث باسم آخر أو غيّر التخصص والمنطقة." />
            @endif

        </div>

    </section>


    {{-- Clinic Image Modal --}}
    <div class="med-image-modal" id="medImageModal">

        <button type="button" class="med-close-modal" id="medCloseModal">

            <i class="fa-solid fa-xmark"></i>

        </button>


        <img src="" alt="صورة العيادة" id="medModalImage">

    </div>


    {{-- Patient Booking Modal --}}
    @if ($doctor->hasFeature('booking'))
        <div class="med-patient-booking-modal" id="medPatientBookingModal" aria-hidden="true">

            <div class="med-patient-booking-overlay" id="medPatientBookingOverlay"></div>


            <div class="med-patient-booking-dialog" role="dialog" aria-modal="true"
                aria-labelledby="medPatientBookingTitle">

                <button type="button" class="med-patient-booking-close" id="medPatientBookingClose" aria-label="إغلاق">

                    <i class="fa-solid fa-xmark"></i>

                </button>


                <div class="med-patient-booking-header">

                    <div class="med-patient-booking-header-icon">

                        <i class="fa-solid fa-calendar-check"></i>

                    </div>

                    <div>

                        <span>
                            تأكيد الموعد
                        </span>

                        <h2 id="medPatientBookingTitle">
                            بيانات المريض
                        </h2>

                        <p>
                            أدخل بيانات المريض لإرسال طلب الحجز
                        </p>

                    </div>

                </div>


                <div class="med-patient-selected-slot">

                    <div class="med-patient-selected-slot-icon">

                        <i class="fa-regular fa-calendar-days"></i>

                    </div>

                    <div>

                        <span>
                            الموعد المختار
                        </span>

                        <strong id="medModalSelectedAppointment">
                            لم يتم اختيار موعد
                        </strong>

                    </div>

                </div>


                <form method="POST" action="{{ route('onlinebooking.store', ['doctor' => $doctor->id]) }}"
                    id="medPatientBookingForm">

                    @csrf

                    <input type="hidden" name="appointment_date" id="medAppointmentDate"
                        value="{{ old('appointment_date') }}">

                    <input type="hidden" name="start_time" id="medStartTime" value="{{ old('start_time') }}">


                    <div class="med-patient-booking-fields">

                        <div class="med-patient-booking-field">

                            <label for="patient_name">

                                اسم المريض

                                <span>*</span>

                            </label>

                            <input type="text" id="patient_name" name="patient_name"
                                value="{{ old('patient_name') }}" placeholder="أدخل اسم المريض" required>

                            @error('patient_name')
                                <span class="field-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>


                        <div class="med-patient-booking-field">

                            <label for="patient_phone">

                                رقم الهاتف

                                <span>*</span>

                            </label>

                            <input type="tel" id="patient_phone" name="patient_phone"
                                value="{{ old('patient_phone') }}" placeholder="01xxxxxxxxx" required
                                inputmode="numeric">

                            @error('patient_phone')
                                <span class="field-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>


                    <div class="med-patient-booking-actions">

                        <button type="button" class="med-patient-booking-cancel" id="medPatientBookingCancel">

                            إلغاء

                        </button>


                        <button type="submit" class="med-patient-booking-submit">

                            تأكيد وإرسال الحجز

                            <i class="fa-solid fa-arrow-left"></i>

                        </button>

                    </div>

                </form>

            </div>

        </div>
    @endif


    {{-- Booking JavaScript (لازم جوه section عشان يظهر) --}}
    @if ($doctor->hasFeature('booking'))
        @push('scripts')
            <script>
                window.medBookingData = {
                    hasOldBookingData: @json(old('patient_name') !== null || old('patient_phone') !== null || old('appointment_date') !== null || old('start_time') !== null),
                    hasBookingValidationErrors: @json($errors->has('patient_name') || $errors->has('patient_phone')),
                    appointmentDate: @json(old('appointment_date', '')),
                    startTime: @json(old('start_time', ''))
                };
            </script>

            <script src="{{ asset('js/clinic/booking_user.js') }}"></script>
        @endpush
    @endif

@endsection

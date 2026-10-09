@extends('doctor.layouts.app')

@section('title', 'تقييماتي | لوحة تحكم الطبيب')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/ratings.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/readability/ratings.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/reviews-page.css') }}">
@endpush

@section('content')


    <div class="doctor-reviews-page">

        {{-- =========================================================
    HEADER
    ========================================================== --}}

        <div class="doctor-reviews-header">

            <div class="doctor-reviews-title">

                <div class="reviews-title-icon">
                    <i class="fa-solid fa-star"></i>
                </div>

                <div class="reviews-title-content">

                    <span class="reviews-title-small">
                        إدارة التقييمات
                    </span>

                    <h1>
                        تقييمات المرضى
                    </h1>

                    <p>
                        عرض جميع تقييمات المرضى
                    </p>

                </div>

            </div>


            {{-- =====================================================
        STATISTICS
        ====================================================== --}}

            <div class="reviews-header-stats">

                <div class="reviews-stat-item">

                    <div class="reviews-stat-icon rating">
                        <i class="fa-solid fa-star"></i>
                    </div>

                    <div class="reviews-stat-info">

                        <span>
                            متوسط التقييم
                        </span>

                        @php
                            $averageRating = $doctor->rating()->avg('rating');
                        @endphp

                        <strong>
                            {{ $averageRating ? number_format($averageRating, 1) . ' / 5' : 'لا توجد تقييمات' }}
                        </strong>

                    </div>

                </div>


                <div class="reviews-count-badge">

                    <i class="fa-solid fa-comments"></i>

                    <span>
                        {{ $reviews->total() }} تقييم
                    </span>

                </div>

            </div>

        </div>


        {{-- =========================================================
    REVIEWS CARD
    ========================================================== --}}

        <div class="reviews-card">


            <div class="reviews-card-header">

                <div>

                    <h2>
                        <i class="fa-solid fa-star"></i>
                        آخر التقييمات

                    </h2>

                    <p>
                    @if (request('search'))
                    نتائج البحث عن: <strong>"{{ request('search') }}"</strong> <span class="results-count">
                    — {{ $reviews->total() }} نتيجة </span>
                    @else
                    التقييمات التي قام المرضى بإضافتها لك <span class="results-count">
                    — {{ $reviews->total() }} تقييم </span>
                    @endif

                    </p>

                </div>



                {{-- =================================================
            SEARCH
            ================================================== --}}

                <form action="{{ route('doctor.reviews') }}" method="GET" class="reviews-search-form">

                    <div class="reviews-search-box">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="ابحث باسم المريض...">

                        @if (request('search'))
                            <a href="{{ route('doctor.reviews') }}" class="reviews-search-clear" title="إلغاء البحث">

                                <i class="fa-solid fa-xmark"></i>

                            </a>
                        @endif

                    </div>


                    <button type="submit" class="reviews-search-button">

                        <i class="fa-solid fa-search"></i>

                        بحث

                    </button>

                </form>

            </div>


            {{-- =====================================================
        EMPTY
        ====================================================== --}}

            @if ($reviews->isEmpty())

                <div class="reviews-empty">

                    <div class="reviews-empty-icon">
                        <i class="fa-regular fa-star"></i>
                    </div>

                    <h3>

                        @if (request('search'))
                            لا توجد نتائج للبحث
                        @else
                            لا توجد تقييمات
                        @endif

                    </h3>

                    <p>

                        @if (request('search'))
                            لم يتم العثور على تقييمات للمريض المطلوب.
                        @else
                            لم يتم إضافة أي تقييمات لك حتى الآن.
                        @endif

                    </p>

                </div>
            @else
                {{-- =================================================
            REVIEWS LIST
            ================================================== --}}

                <div class="reviews-list">

                    @foreach ($reviews as $review)
                        <div class="review-item doctor-review-item">

                            {{-- =====================================
                        USER
                        ====================================== --}}

                            <div class="review-user doctor-review-user">

                                <div class="review-user-avatar">

                                    <i class="fa-solid fa-user"></i>

                                </div>

                                <div class="review-user-info">

                                    <span class="review-label">
                                        صاحب التقييم
                                    </span>

                                    <strong>
                                        {{ $review->user?->name ?? 'مستخدم غير معروف' }}
                                    </strong>

                                </div>

                            </div>


                            {{-- =====================================
                        RATING
                        ====================================== --}}

                            <div class="review-rating doctor-review-rating">

                                <span class="review-label">
                                    التقييم
                                </span>

                                <div class="stars">

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="fa-solid fa-star active"></i>
                                        @else
                                            <i class="fa-regular fa-star"></i>
                                        @endif
                                    @endfor

                                </div>

                                <strong>
                                    {{ $review->rating }}/5
                                </strong>

                            </div>


                            {{-- =====================================
                        COMMENT
                        ====================================== --}}

                            <div class="review-comment doctor-review-comment">

                                <span class="review-label">
                                    التعليق
                                </span>

                                <div class="comment-box">

                                    <i class="fa-solid fa-quote-right"></i>

                                    <p>
                                        {{ $review->comment ?? 'لم يكتب المستخدم تعليقًا.' }}
                                    </p>

                                </div>

                            </div>


                            {{-- =====================================
                        DATE
                        ====================================== --}}

                            <div class="review-date doctor-review-date">

                                <i class="fa-regular fa-calendar"></i>

                                <div>

                                    <span class="review-label">
                                        تاريخ التقييم
                                    </span>

                                    <strong>
                                        {{ $review->created_at?->format('Y/m/d') }}
                                    </strong>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>


                {{-- =================================================
            PAGINATION
            ================================================== --}}

                <div class="reviews-pagination">

                    {{ $reviews->withQueryString()->links('vendor.pagination.custom') }}

                </div>

            @endif

        </div>

    </div>


@endsection

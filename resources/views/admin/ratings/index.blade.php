@extends('admin.layout.app')

@section('title', 'لوحة التحكم | التقييمات')

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
                    تقييمات الأطباء
                </h1>

                <p>
                    عرض ومراجعة جميع تقييمات المستخدمين للأطباء
                </p>

            </div>

        </div>


        {{-- =====================================================
        STATISTICS
        ====================================================== --}}

        <div class="reviews-header-stats">

            <div class="reviews-stat-item">

                <div class="reviews-stat-icon doctors">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>

                <div class="reviews-stat-info">

                    <span>
                        الأطباء المقيّمين
                    </span>

                    <strong>
                        {{ \App\Models\Rating::distinct('doctor_id')->count('doctor_id') }}
                    </strong>

                </div>

            </div>


            <div class="reviews-stat-item">

                <div class="reviews-stat-icon rating">
                    <i class="fa-solid fa-star"></i>
                </div>

                <div class="reviews-stat-info">

                    <span>
                        متوسط التقييم
                    </span>

                    <strong>
                        {{ number_format($reviews->avg('rating'), 1) }}/5
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
                    التقييمات التي قام المستخدمون بإضافتها للأطباء
                </p>

            </div>


            {{-- =================================================
            SEARCH
            ================================================== --}}

            <form action="{{ route('ratings.index') }}" method="GET" class="reviews-search-form">

                <div class="reviews-search-box">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="ابحث باسم الطبيب...">

                    @if (request('search'))

                        <a href="{{ route('ratings.index') }}"
                            class="reviews-search-clear"
                            title="إلغاء البحث">

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
                        لم يتم العثور على تقييمات للطبيب المطلوب.
                    @else
                        لم يتم إضافة أي تقييمات للأطباء حتى الآن.
                    @endif

                </p>

            </div>

        @else

            {{-- =================================================
            REVIEWS LIST
            ================================================== --}}

            <div class="reviews-list">

                @foreach ($reviews as $review)

                    <div class="review-item">

                        {{-- =====================================
                        USER
                        ====================================== --}}

                        <div class="review-user">

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

                                @if ($review->user?->email)

                                    <small>
                                        {{ $review->user->email }}
                                    </small>

                                @endif

                            </div>

                        </div>


                        {{-- =====================================
                        DOCTOR
                        ====================================== --}}

                        <div class="review-doctor">

                            <div class="review-doctor-avatar">

                                <i class="fa-solid fa-user-doctor"></i>

                            </div>

                            <div class="review-doctor-info">

                                <span class="review-label">
                                    الطبيب
                                </span>

                                <strong>
                                    {{ $review->doctor?->user?->name ?? 'طبيب غير معروف' }}
                                </strong>

                                @if ($review->doctor?->specialty)

                                    <small>
                                        {{ $review->doctor->specialty->name }}
                                    </small>

                                @endif

                            </div>

                        </div>


                        {{-- =====================================
                        RATING
                        ====================================== --}}

                        <div class="review-rating">

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

                        <div class="review-comment">

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

                        <div class="review-date">

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


                        {{-- =====================================
                        STATUS
                        ====================================== --}}

                        <div class="review-status">

                            @if ($review->status === 'approved')

                                <span class="review-status-badge approved">

                                    <i class="fa-solid fa-circle-check"></i>

                                    مقبول

                                </span>

                            @else

                                <span class="review-status-badge rejected">

                                    <i class="fa-solid fa-circle-xmark"></i>

                                    مرفوض

                                </span>

                            @endif

                        </div>


                        {{-- =====================================
                        ACTIONS
                        ====================================== --}}

                        <div class="review-actions">

                            <span class="review-label">
                                الإجراءات
                            </span>

                            <div class="review-actions-buttons">

                                <a href="{{ route('ratings.edit', $review->id) }}"
                                    class="review-action-btn edit"
                                    title="تعديل">

                                    <i class="fa-solid fa-pen"></i>

                                </a>


                                <form action="{{ route('ratings.destroy', $review->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟');">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit"
                                        class="review-action-btn delete"
                                        title="حذف">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>

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

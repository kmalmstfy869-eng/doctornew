@props(['doctor', 'favoriteIds' => []])

<article class="doctor-card">

    <div class="doctor-cover">

        @if ($doctor->hasFeature('booking'))
            <span class="subscription-badge premium">

                <i class="fa-solid fa-crown"></i>

                طبيب مميز

            </span>
        @endif

    </div>


    @php
        $isFav = in_array($doctor->id, $favoriteIds);
    @endphp

    <form method="POST" action="{{ route('favorites.toggle', $doctor->id) }}">
        @csrf

        <button type="submit" class="doctor-favorite {{ $isFav ? 'is-active' : '' }}" aria-label="المفضلة">

            <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>

        </button>
    </form>

    <!-- صورة الطبيب -->

    @if (
        $doctor->doctor_image &&
            $doctor->hasFeature('subscription') &&
            \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->doctor_image))
        <div class="doctor-image">

            <img src="{{ asset('storage/' . $doctor->doctor_image) }}" alt="د.{{ $doctor->user->name }}"
                class="med-doctor-image">

        </div>
    @else
        <div class="doctor-image">

            <div class="image-unavailable">

                <i class="fa-solid fa-user-doctor"></i>

                <span>
                    الصورة غير متوفرة
                </span>

            </div>

        </div>
    @endif


    <div class="doctor-content">


        <!-- بيانات الطبيب -->

        <div class="doctor-top">

            <div class="doctor-name">

                <h3 class="doctor-name-title">

                    <span>
                        د. {{ $doctor->user?->name ?? 'طبيب' }}
                    </span>


                    @if ($doctor->hasFeature('subscription'))
                        <i class="fa-solid fa-circle-check verified-badge"></i>
                    @endif

                </h3>


                <p>
                    {{ $doctor->specialty?->title ?? 'التخصص غير محدد' }}
                </p>

            </div>

        </div>


        <!-- التقييم -->

        @php
            $ratings = $doctor->rating;
        @endphp


        @if ($ratings->isNotEmpty() && $doctor->hasFeature('subscription'))

            @php

                $averageRating = $ratings->avg('rating');

                $fullStars = floor($averageRating);

                $hasHalfStar = $averageRating - $fullStars >= 0.5;

            @endphp


            <div class="rating-row">

                <div class="stars">

                    @for ($i = 1; $i <= $fullStars; $i++)
                        <i class="fa-solid fa-star"></i>
                    @endfor


                    @if ($hasHalfStar)
                        <i class="fa-solid fa-star-half-stroke"></i>
                    @endif


                    @for ($i = $fullStars + ($hasHalfStar ? 1 : 0); $i < 5; $i++)
                        <i class="fa-regular fa-star"></i>
                    @endfor

                </div>


                <span class="rating-number">

                    {{ number_format($averageRating, 1) }}


                    <small>
                        ({{ $ratings->count() }} تقييم)
                    </small>

                </span>

            </div>
        @else
            <div class="limited-info">

                <i class="fa-solid fa-lock"></i>

                التقييم غير متاح الآن

            </div>

        @endif


        <!-- تفاصيل الطبيب -->

        <div class="doctor-details">

            <div class="doctor-detail">

                <i class="fa-solid fa-location-dot"></i>

                {{ $doctor->area?->name ?? 'المنطقة غير محددة' }}

            </div>


            <span class="doctor-detail">

                <i class="fa-solid fa-briefcase-medical"></i>

                {{ $doctor->experience ?? 0 }}

                سنة خبرة

            </span>

        </div>


        <!-- الخدمات -->

        <div class="doctor-services">

            <span class="service-tag">
                كشف طبي
            </span>

            <span class="service-tag">
                متابعة دورية
            </span>

            <span class="service-tag">
                استشارات
            </span>

        </div>


        <!-- زر الملف -->

        <a href="{{ route('doctors.show', $doctor->id) }}" class="doctor-button-card">

            @if ($doctor->hasFeature('booking'))
                عرض الملف الطبي و احجز الان
            @else
                عرض الملف الطبي
            @endif

        </a>

    </div>

</article>

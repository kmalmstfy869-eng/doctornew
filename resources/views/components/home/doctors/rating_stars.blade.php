@props(['doctor'])
<div class="med-review-stars">
    @php
        $rating = $doctor->rating->avg('rating') ?? 0;
        $fullStars = floor($rating);
        $hasHalfStar = $rating - $fullStars >= 0.5;
    @endphp

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

<span>
    من {{ $doctor->rating->count() }} اشخاص مختلفيين
</span>

</div>

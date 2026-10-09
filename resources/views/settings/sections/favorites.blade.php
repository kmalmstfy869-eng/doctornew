{{-- resources/views/settings/sections/favorites.blade.php --}}

<div class="profile-form">

    <div class="profile-form-header">
        <div>
            <h2>الأطباء المفضلين</h2>
            <p>الأطباء الذين قمت بإضافتهم إلى قائمة المفضلة.</p>
        </div>
    </div>

    @if ($favorites->isNotEmpty())

        <div class="favorites-grid">

            @foreach ($favorites as $doctor)
                @php
                    $doctorImageExists =
                        $doctor->hasFeature('subscription') &&
                        filled($doctor->doctor_image) &&
                        \Illuminate\Support\Facades\Storage::disk('public')->exists($doctor->doctor_image);

                    $specialtyName = $doctor->specialty?->title ?? $doctor->specialty?->name;
                @endphp

                <div class="favorite-doctor-card">

                    <form method="POST" action="{{ route('favorites.toggle', $doctor->id) }}"
                        class="favorite-remove-form">
                        @csrf
                        <button type="submit" class="favorite-remove-button" title="إزالة من المفضلة"
                            aria-label="إزالة من المفضلة">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    </form>

                    <div class="favorite-doctor-image">
                        @if ($doctorImageExists)
                            <img src="{{ asset('storage/' . $doctor->doctor_image) }}" alt="{{ $doctor->user?->name }}">
                        @else
                            <i class="fa-solid fa-user-doctor"></i>
                        @endif
                    </div>

                    <div class="favorite-doctor-info">

                        <h3>د. {{ $doctor->user?->name ?? 'طبيب' }}</h3>

                        @if ($specialtyName)
                            <p>
                                <i class="fa-solid fa-stethoscope"></i>
                                {{ $specialtyName }}
                            </p>
                        @endif

                        @if ($doctor->area?->name)
                            <p>
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $doctor->area->name }}
                            </p>
                        @endif

                        @if (filled($doctor->consultation_price))
                            <p class="favorite-price">
                                <i class="fa-solid fa-money-bill-wave"></i>
                                سعر الكشف:
                                <strong>{{ number_format($doctor->consultation_price) }} جنيه</strong>
                            </p>
                        @endif

                    </div>

                    <div class="favorite-doctor-actions">

                        <a href="{{ route('doctors.show', $doctor->id) }}" class="favorite-view-button">
                            <i class="fa-solid fa-eye"></i>
                            عرض الطبيب
                        </a>

                    </div>

                </div>
            @endforeach

        </div>
    @else
        <div class="empty-state">

            <div class="empty-state-icon favorite-empty">
                <i class="fa-regular fa-heart"></i>
            </div>

            <h3>لا توجد أطباء مفضلين</h3>

            <p>لم تقم بإضافة أي طبيب إلى المفضلة حتى الآن.</p>

        </div>

    @endif

</div>

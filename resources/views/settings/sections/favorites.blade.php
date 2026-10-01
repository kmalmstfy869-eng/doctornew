{{-- resources/views/settings/sections/favorites.blade.php --}}

<div class="profile-form">

    <div class="profile-form-header">

        <div>

            <h2>
                الأطباء المفضلين
            </h2>

            <p>
                الأطباء الذين قمت بإضافتهم إلى قائمة المفضلة.
            </p>

        </div>

    </div>


    @if ($favorites->count())

        <div class="favorites-grid">

            @foreach ($favorites as $favorite)
                @php
                    $doctor = $favorite->doctor ?? $favorite;
                @endphp

                <div class="favorite-doctor-card">

                    <div class="favorite-doctor-image">

                        @if (!empty($doctor->image))
                            <img src="{{ asset('storage/' . $doctor->image) }}" alt="{{ $doctor->name }}">
                        @else
                            <i class="fa-solid fa-user-doctor"></i>
                        @endif

                    </div>


                    <div class="favorite-doctor-info">

                        <h3>
                            {{ $doctor->name }}
                        </h3>

                        @if (isset($doctor->specialty))
                            <p>
                                <i class="fa-solid fa-stethoscope"></i>

                                {{ $doctor->specialty->name ?? $doctor->specialty }}

                            </p>
                        @endif

                        @if (isset($doctor->area))
                            <p>
                                <i class="fa-solid fa-location-dot"></i>

                                {{ $doctor->area->name ?? $doctor->area }}

                            </p>
                        @endif

                    </div>


                    <div class="favorite-doctor-actions">

                        @if (Route::has('doctors.show'))
                            <a href="{{ route('doctors.show', $doctor) }}" class="favorite-view-button">

                                <i class="fa-solid fa-eye"></i>

                                عرض الطبيب

                            </a>
                        @endif

                    </div>

                </div>
            @endforeach

        </div>
    @else
        <div class="empty-state">

            <div class="empty-state-icon favorite-empty">

                <i class="fa-regular fa-heart"></i>

            </div>

            <h3>
                لا توجد أطباء مفضلين
            </h3>

            <p>
                لم تقم بإضافة أي طبيب إلى المفضلة حتى الآن.
            </p>

        </div>

    @endif

</div>

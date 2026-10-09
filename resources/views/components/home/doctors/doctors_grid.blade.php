@props(['doctors', 'favoriteIds' => []])

<div class="public-doctors-grid">
    @if ($doctors && $doctors->isNotEmpty())
        @foreach ($doctors as $doctor)
            <x-home.doctors.card_doctor_clinic_system_component :doctor="$doctor" :favorite-ids="$favoriteIds" />
        @endforeach
    @endif
</div>

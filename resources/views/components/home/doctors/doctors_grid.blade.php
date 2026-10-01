@props(['doctors'])

<div class="public-doctors-grid">
    @if ($doctors && $doctors->isNotEmpty())
        @foreach ($doctors as $doctor)
            <x-home.doctors.card_doctor_clinic_system_component :doctor="$doctor" />
        @endforeach
    @endif
</div>

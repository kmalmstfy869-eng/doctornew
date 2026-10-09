@if ($doctors->isNotEmpty())

    <div class="doctors-grid" id="doctorsGrid">

        @foreach ($doctors as $doctor)
            <x-home.doctors.card_doctor_clinic_system_component :doctor="$doctor" :favorite-ids="$favoriteIds ?? []"/>
        @endforeach

    </div>

    {{ $doctors->links('vendor.pagination.custom') }}

@else

    <x-home.banner.no_results logo="fa-solid fa-user-doctor" title="لا يوجد أطباء مطابقون"
        content="جرب البحث باسم آخر أو غيّر التخصص والمنطقة." />

@endif

@if ($Specialties->isNotEmpty())
    <div class="specialties-grid" id="specialtiesGrid">

        @foreach ($Specialties as $specialty)
            <x-home.specialties.card_specialties :link="route('specialties.show', $specialty->slug)" :number="str_pad(
                ($Specialties->currentPage() - 1) * $Specialties->perPage() + $loop->iteration,
                2,
                '0',
                STR_PAD_LEFT,
            )" :name="$specialty->name"
                :title="$specialty->title" :logo="$specialty->logo" />
        @endforeach

    </div>

    {{ $Specialties->links('vendor.pagination.custom') }}
@else
    <x-home.banner.no_results logo="fa-solid fa-stethoscope" title="لا توجد تخصصات مطابقة"
        content="جرب البحث باسم تخصص آخر أو غيّر معايير البحث." />
@endif

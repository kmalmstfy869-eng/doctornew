@extends('home.layout.app')

@section('title', 'جميع الأطباء | دليل الأطباء')

@section('content')

    <x-home.hero.secondhero title="جميع الأطباء" address="دليل الأطباء المعتمد" contet1="ابحث عن الطبيب"
        content_continuation="المناسب لك" note="تصفح الأطباء حسب التخصص والمنطقة، وشاهد البيانات المتاحة لكل طبيب بسهولة."
        :home="true" />

    <section class="doctors-search-area">

        <div class="doctors-search-panel">

            <div class="doctors-search-row">

                <div class="field">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="text" id="doctorSearch" value="{{ request('q') }}"
                        placeholder="ابحث باسم الطبيب أو التخصص...">

                </div>

                <div class="field">

                    <i class="fa-solid fa-stethoscope"></i>

                    <select id="specialtyFilter">
                        @if ($specialties?->isNotEmpty())
                            <option value="all">
                                كل التخصصات
                            </option>
                            @foreach ($specialties as $specialty)
                                <option value="{{ $specialty?->id }}" @selected(request('specialty') == $specialty?->id)>
                                    {{ $specialty?->name }}
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled selected>
                                لا يوجد تخصصات الآن
                            </option>
                        @endif
                    </select>

                </div>

                <div class="field">

                    <i class="fa-solid fa-location-dot"></i>

                    <select id="cityFilter">
                        @if ($areas?->isNotEmpty())
                            <option value="all">
                                كل المناطق
                            </option>
                            @foreach ($areas as $area)
                                <option value="{{ $area?->id }}" @selected(request('area') == $area?->id)>
                                    {{ $area?->name }}
                                </option>
                            @endforeach
                        @else
                            <option value="" disabled selected>
                                لا توجد مناطق الآن
                            </option>
                        @endif
                    </select>

                </div>

                <button type="button" class="doctors-search-button" id="searchButton">

                    <i class="fa-solid fa-search"></i>

                    بحث

                </button>

            </div>

            <div class="doctors-search-info">

                <p>

                    تم العثور على

                    <strong id="resultCount">{{ $doctors->total() }}</strong>

                    طبيب

                </p>

                <button type="button" class="clear-button" id="clearFilters">

                    <i class="fa-solid fa-rotate-right"></i>

                    مسح البحث والفلاتر

                </button>

            </div>

        </div>

    </section>

    <section class="doctors-section">

        <div class="container">

            <div class="section-heading">

                <div>

                    <span class="section-label">

                        <i class="fa-solid fa-users"></i>

                        قائمة الأطباء

                    </span>

                    <h2>
                        جميع الأطباء
                        @isset($name)
                            لتخصص {{ $name }}
                        @endisset
                    </h2>

                    <p>
                        اختر الطبيب واطلع على ملفه والبيانات المتاحة.
                    </p>

                </div>

                <div class="sort-box">

                    <i class="fa-solid fa-arrow-down-wide-short"></i>

                    <select id="sortDoctors">

                        <option value="default">
                            الترتيب الافتراضي
                        </option>

                        <option value="price" @selected(request('sort') === 'price')>
                            الأقل سعرًا إلى الأعلى
                        </option>

                    </select>
                </div>

            </div>

            <div id="doctorsResults" data-url="{{ route('doctors.index') }}">
                @include('home.doctors._grid')
            </div>

        </div>

    </section>

    <x-home.banner.firstbanner nav="هل أنت طبيب؟" title="أنشئ ملفك الطبي وعرّف المرضى بخدماتك" link="انضم لدليل الأطباء"
        :route="route('doctor_join')">

        سجّل كطبيب، للظهور في الموقع والوصول إلى المرضى.

    </x-home.banner.firstbanner>

    @push('scripts')
        <script src="{{ asset('js/search_doctor.js') }}"></script>
    @endpush

@endsection


@extends('home.layout.app')

@section('title', 'كل التخصصات الطبية | دليل الأطباء')


@section('content')
    <x-home.hero.secondhero title="التخصصات الطبية" address="ابحث حسب التخصص" contet1="كل التخصصات"
        content_continuation="الطبية" note="اختر التخصص المناسب وتصفح الأطباء بسهولة." />


    <div class="specialties-search-wrapper">

        <form class="specialties-search-box" id="specialties-searchForm">

            <div class="specialties-search-input">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="text" id="specialties-searchInput" value="{{ request('q') }}"
                    placeholder="ابحث عن تخصص...">

            </div>


            <button type="submit" class="specialties-search-button">

                <i class="fa-solid fa-search"></i>

                بحث

            </button>

        </form>

    </div>


    <section class="specialties-section">

        <div class="container">


            <div class="section-top">

                <div>

                    <span class="section-badge">

                        <i class="fa-solid fa-layer-group"></i>

                        دليل التخصصات

                    </span>


                    <h2>

                        استكشف التخصصات

                    </h2>


                    <p>

                        اختر التخصص ثم شاهد الأطباء.

                    </p>

                </div>


                <div class="result-box">

                    تم العثور على

                    <strong id="resultNumber">{{ $Specialties->total() }}</strong>

                    تخصص

                </div>

            </div>


            <div id="specialtiesResults" data-url="{{ route('specialties.index') }}">
                @include('home.specialty._grid')
            </div>


            <x-home.banner.firstbanner nav="هل أنت طبيب؟" title="أضف تخصصك وعرّف المرضى بخدماتك" link="انضم كطبيب"
                :route="route('doctor_join')">

                أنشئ حسابك وابدأ في بناء ملفك الطبي.

            </x-home.banner.firstbanner>
        </div>

    </section>

    @push('scripts')
        <script src="{{ asset('js/search_specialties.js') }}"></script>
    @endpush

@endsection

@extends('home.layout.app')

@section('title', 'كل التخصصات الطبية | دليل الأطباء')


@section('content')
    <x-home.hero.secondhero title="التخصصات الطبية" address="ابحث حسب التخصص" contet1="كل التخصصات"
        content_continuation="الطبية" note="اختر التخصص المناسب وتصفح الأطباء بسهولة." />


    <div class="specialties-search-wrapper">

        <form class="specialties-search-box" id="specialties-searchForm">

            <div class="specialties-search-input">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="text" id="specialties-searchInput" placeholder="ابحث عن تخصص...">

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

                    <strong id="resultNumber">

                        12

                    </strong>

                    تخصص

                </div>

            </div>


            <!-- الفلاتر -->

            <div class="filters">

                <button class="filter-button active" data-filter="all">

                    الكل

                </button>


                <button class="filter-button" data-filter="general">

                    تخصصات عامة

                </button>


                <button class="filter-button" data-filter="surgery">

                    تخصصات جراحية

                </button>


                <button class="filter-button" data-filter="children">

                    الأطفال

                </button>


                <button class="filter-button" data-filter="women">

                    النساء

                </button>


                <button class="filter-button" data-filter="mental">

                    الصحة النفسية

                </button>

            </div>

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
                    content="جرب البحث باسم تخصص آخر أو غيّر معايير البحث. " />
            @endif


        <x-home.banner.firstbanner nav="هل أنت طبيب؟" title="أضف تخصصك وعرّف المرضى بخدماتك" link="انضم كطبيب" :route="route('doctor_join')">

            أنشئ حسابك وابدأ في بناء ملفك الطبي.

        </x-home.banner.firstbanner>
    </div>

</section>

@endsection

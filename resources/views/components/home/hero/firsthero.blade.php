@props([
    'nav',
    'title',
    'title_continue',
    'note1',
    'anser1',
    'note2',
    'anser2',
    'home' => false,
    'areas' => null,
])


<section class="home-hero">

    <div class="site-container home-hero-grid">


        {{-- Hero Content --}}
        <div class="home-hero-content">


            {{-- Badge --}}
            <div class="home-hero-badge">

                <i class="fa-solid fa-circle-check"></i>

                {{ $nav }}

            </div>


            {{-- Title --}}
            <h2>

                {{ $title }}

                <span>

                    {{ $title_continue }}

                </span>

            </h2>


            {{-- Description --}}
            <p>

                {{ $slot }}

            </p>


            {{-- Home Page Content --}}
            @if ($home)


                {{-- Search Form --}}
                <form class="home-search-form" id="homeSearchForm" method="GET" action="{{ route('doctors.index') }}">

                    <div class="home-search-field">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input type="text" id="doctorSearchInput" name="q" placeholder="ابحث باسم الطبيب أو التخصص">

                    </div>

                    <div class="home-search-field">

                        <i class="fa-solid fa-location-dot"></i>

                        <select id="governorateSelect" name="area">
                            @if ($areas?->isNotEmpty())
                                <option value="all">
                                    كل المناطق
                                </option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area?->id }}">
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

                    <button type="submit" class="home-search-button">

                        <i class="fa-solid fa-search"></i>

                        ابحث الآن

                    </button>

                </form>


                {{-- Trust Items --}}
                <div class="home-hero-trust">


                    <div class="home-trust-item">

                        <div class="home-trust-icon">

                            <i class="fa-solid fa-circle-check"></i>

                        </div>

                        <div>

                            <strong>

                                أطباء معتمدون

                            </strong>

                            <span>

                                بيانات تمت مراجعتها

                            </span>

                        </div>

                    </div>


                    <div class="home-trust-line"></div>


                    <div class="home-trust-item">

                        <div class="home-trust-icon">

                            <i class="fa-solid fa-stethoscope"></i>

                        </div>

                        <div>

                            <strong>

                                تخصصات متنوعة

                            </strong>

                            <span>

                                اختر ما يناسبك

                            </span>

                        </div>

                    </div>


                    <div class="home-trust-line"></div>


                    <div class="home-trust-item">

                        <div class="home-trust-icon">

                            <i class="fa-solid fa-location-dot"></i>

                        </div>

                        <div>

                            <strong>

                                بحث حسب المنطقة

                            </strong>

                            <span>

                                طبيب قريب منك

                            </span>

                        </div>

                    </div>


                </div>


            @else


                {{-- Other Pages Buttons --}}
                <div class="hero-buttons">


                    <a
                        href="{{ route('doctors.index') }}"
                        class="btn btn-primary"
                    >

                        اكتشف الأطباء

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>


                    <span
                        class="btn btn-outline"
                        role="button"
                        tabindex="0"
                    >

                        تواصل معنا

                        <i class="fa-solid fa-headset"></i>

                    </span>


                </div>


            @endif


        </div>


        {{-- Hero Visual --}}
        <div class="home-hero-visual">


            <div class="home-visual-circle">

                <div class="home-doctor-visual">

                    <i class="fa-solid fa-user-doctor"></i>

                </div>

            </div>


            {{-- Floating Card One --}}
            <div class="home-floating-card home-floating-card-one">


                <div class="home-floating-icon">

                    <i class="fa-solid fa-circle-check"></i>

                </div>


                <div>

                    <h4>

                        {{ $note1 }}

                    </h4>

                    <p>

                        {{ $anser1 }}

                    </p>

                </div>


            </div>


            {{-- Floating Card Two --}}
            <div class="home-floating-card home-floating-card-two">


                <div class="home-floating-icon">

                    <i class="fa-solid fa-star"></i>

                </div>


                <div>

                    <h4>

                        {{ $note2 }}

                    </h4>

                    <p>

                        {{ $anser2 }}

                    </p>

                </div>


            </div>


        </div>


    </div>

</section>

@extends('home.layout.app')

@section('title', 'الوظائف المتاحه | دليل الأطباء')

@section('content')

    <x-home.hero.secondhero title="الوظائف" address="أحدث فرص العمل" contet1="فرصتك للعمل"
        content_continuation="في المجال الطبي"
        note="اكتشف أحدث الوظائف والفرص المتاحة في المستشفيات والعيادات والمراكز الطبية، وابحث عن الوظيفة المناسبة لخبراتك ومهاراتك." />

    <div class="specialties-search-wrapper">

        <form class="specialties-search-box" id="jobs-searchForm">

            <div class="specialties-search-input">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="text" id="jobs-searchInput" value="{{ request('q') }}"
                    placeholder="ابحث عن وظيفة...">

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

                        دليل الوظائف

                    </span>

                    <h2>
                        استكشف الوظائف
                    </h2>

                </div>

                <div class="result-box">

                    تم العثور على

                    <strong id="resultNumber">{{ $totaljobs ?? 0 }}</strong>

                    وظيفة

                </div>

            </div>


            <main id="jobs">

                <div id="jobsResults" data-url="{{ route('jobs.index') }}">
                    @include('home.jobs._grid')
                </div>

            </main>

        </div>

    </section>


    <section class="post-job-section">

        <div class="container">

            <div class="post-job-card">

                <div class="post-job-content">

                    <div class="post-job-icon">

                        <i class="fa-solid fa-bullhorn"></i>

                    </div>


                    <div class="post-job-text">

                        <h2>
                            هل لديك وظيفة شاغرة؟
                        </h2>

                        <p>
                            انشر وظيفتك الآن ووصل إلى الباحثين عن عمل
                            في المجال الطبي بسهولة.
                        </p>

                    </div>

                </div>


                <a href="{{ route('jobs.create') }}" class="post-job-button">

                    <i class="fa-solid fa-plus"></i>

                    أضف وظيفة

                </a>

            </div>

        </div>

    </section>

    @push('scripts')
        <script src="{{ asset('js/search_jobs.js') }}"></script>
    @endpush

@endsection

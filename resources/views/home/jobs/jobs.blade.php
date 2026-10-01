@extends('home.layout.app')

@section('title', 'الوظائف المتاحه | دليل الأطباء')

@section('content')

    <x-home.hero.secondhero title="الوظائف" address="أحدث فرص العمل" contet1="فرصتك للعمل"
        content_continuation="في المجال الطبي"
        note="اكتشف أحدث الوظائف والفرص المتاحة في المستشفيات والعيادات والمراكز الطبية، وابحث عن الوظيفة المناسبة لخبراتك ومهاراتك." />

    <div class="specialties-search-wrapper">

        <form class="specialties-search-box" id="specialties-searchForm">

            <div class="specialties-search-input">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="text" id="specialties-searchInput" placeholder="ابحث عن وظيفة...">

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

                    <strong id="resultNumber">
                        {{ $totaljobs??0 }}
                    </strong>

                    وظيفة

                </div>

            </div>


            <main id="jobs">

                @if ($jobs?->isNotEmpty())

                    <div class="jobs-list" id="jobsList">

                        @foreach ($jobs as $job)
                            <article class="job-card">

                                <div class="job-card-top">

                                    <div class="job-icon">

                                        <i class="fa-solid fa-briefcase"></i>

                                    </div>

                                </div>


                                <span class="job-category">

                                    {{ $job->category }}

                                </span>


                                <h3 class="job-title">

                                    {{ $job->title }}

                                </h3>


                                <p class="company-name">

                                    {{ $job->company_name }}

                                </p>


                                <div class="job-info">

                                    <div class="job-info-item">

                                        <i class="fa-solid fa-location-dot"></i>

                                        {{ $job->location ?? 'لم يتم التحديد' }}

                                    </div>


                                    <div class="job-info-item">

                                        <i class="fa-solid fa-clock"></i>

                                        {{ $job->job_type }}

                                    </div>

                                </div>


                                <div class="job-salary">

                                    <span class="salary-label">
                                        الراتب المتوقع
                                    </span>

                                    <span class="salary-value">

                                        @if ($job->salary_min && $job->salary_max)
                                            {{ $job->salary_min }} - {{ $job->salary_max }} جنيه
                                        @elseif ($job->salary_min)
                                            من {{ $job->salary_min }} جنيه
                                        @elseif ($job->salary_max)
                                            حتى {{ $job->salary_max }} جنيه
                                        @else
                                            غير محدد
                                        @endif

                                    </span>

                                </div>


                                <div class="job-footer">

                                    <a href="{{ route('jobs.show', $job->id) }}" class="details-btn">

                                        عرض التفاصيل

                                    </a>




                                </div>

                            </article>
                        @endforeach

                    </div>


                    <div class="pagination" id="pagination">

                        {{ $jobs->links('vendor.pagination.custom') }}

                    </div>
                @else
                    <x-home.banner.no_results logo="fa-solid fa-briefcase" title="لا توجد وظائف الآن"
                        content="جرّب تغيير كلمة البحث أو الفلاتر أو ابحث في وقت لاحق" />

                @endif

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

@endsection

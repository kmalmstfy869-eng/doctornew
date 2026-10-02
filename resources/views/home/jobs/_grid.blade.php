@if ($jobs->isNotEmpty())

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
        content="جرّب تغيير كلمة البحث أو ابحث في وقت لاحق" />

@endif

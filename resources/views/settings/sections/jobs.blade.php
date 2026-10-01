
{{-- resources/views/settings/sections/jobs.blade.php --}}

<div class="profile-form">

    <div class="profile-form-header">

        <div>

            <h2>
                وظائفي
            </h2>

            <p>
                إدارة الوظائف التي قمت بنشرها على الموقع.
            </p>

        </div>

        <a href="{{ route('jobs.create') }}"
           class="settings-primary-button">

            <i class="fa-solid fa-plus"></i>

            نشر وظيفة

        </a>

    </div>


    @if ($jobs->count())

        <div class="jobs-list">

            @foreach ($jobs as $job)

                <div class="job-item">

                    <div class="job-item-icon">

                        <i class="fa-solid fa-briefcase"></i>

                    </div>


                    <div class="job-item-content">

                        <h3>
                            {{ $job->title }}
                        </h3>

                        <div class="job-item-meta">

                            <span>

                                <i class="fa-regular fa-calendar"></i>

                                {{ $job->created_at->format('Y-m-d') }}

                            </span>


                            @if ($job->status === 'pending')

                                <span class="job-status pending">

                                    <i class="fa-solid fa-clock"></i>

                                    قيد المراجعة

                                </span>

                            @elseif ($job->status === 'approved')

                                <span class="job-status approved">

                                    <i class="fa-solid fa-circle-check"></i>

                                    منشورة

                                </span>

                            @elseif ($job->status === 'rejected')

                                <span class="job-status rejected">

                                    <i class="fa-solid fa-circle-xmark"></i>

                                    مرفوضة

                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="job-item-actions">

                        <a
                            href="{{ route('jobs.show', $job) }}"
                            class="job-action view">

                            <i class="fa-solid fa-eye"></i>

                            عرض

                        </a>


                        <a
                            href="{{ route('jobs.edit', $job) }}"
                            class="job-action edit">

                            <i class="fa-solid fa-pen"></i>

                            تعديل

                        </a>


                        <form
                            action="{{ route('jobs.destroy', $job) }}"
                            method="POST"
                            onsubmit="return confirm('هل أنت متأكد من حذف هذه الوظيفة؟');">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="job-action delete">

                                <i class="fa-solid fa-trash"></i>

                                حذف

                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-state-icon">

                <i class="fa-solid fa-briefcase"></i>

            </div>

            <h3>
                لا توجد وظائف
            </h3>

            <p>
                لم تقم بنشر أي وظيفة حتى الآن.
            </p>

            <a href="{{ route('jobs.create') }}"
               class="settings-primary-button">

                <i class="fa-solid fa-plus"></i>

                نشر وظيفة جديدة

            </a>

        </div>

    @endif

</div>


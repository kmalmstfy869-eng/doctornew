@extends('admin.layout.app')

@section('title', 'لوحة الإدارة | الوظائف')

@section('page-title', 'الوظائف')

@section('page-description', 'عرض وإدارة الوظائف المنشورة على المنصة')

@section('content')

    <div class="users-page">

        <div class="users-header">

            <div class="users-title">

                <div class="title-icon">
                    <i class="fa-solid fa-briefcase"></i>
                </div>

                <div>

                    <h2>
                        @if (isset($user) && $user)
                            وظائف {{ $user->name }}
                        @else
                            جميع الوظائف
                        @endif
                    </h2>

                    <p>
                        @if (isset($user) && $user)
                            جميع الوظائف التي قام المستخدم بنشرها
                        @else
                            جميع الوظائف المنشورة على المنصة
                        @endif
                    </p>

                </div>

            </div>


            @if (isset($user) && $user)
                <a href="{{ route('admin.jobs.index') }}" class="doctor-button-card">

                    عرض جميع الوظائف

                    <i class="fa-solid fa-briefcase"></i>

                </a>
            @endif

        </div>


        <div class="users-card">

            <div class="table-responsive">

                <table class="users-table">

                    <thead>

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                الوظيفة
                            </th>

                            <th>
                                بواسطة
                            </th>

                            <th>
                                الشركة
                            </th>

                            <th>
                                التصنيف
                            </th>

                            <th>
                                نوع العمل
                            </th>

                            <th>
                                المكان
                            </th>

                            <th>
                                الحالة
                            </th>

                            <th>
                                تاريخ النشر
                            </th>

                            <th>
                                الإجراءات
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($jobs as $job)
                            <tr>

                                <td>
                                    {{ $jobs->firstItem() + $loop->index }}
                                </td>


                                <td>

                                    <div class="user-info">

                                        <div class="user-avatar">

                                            <i class="fa-solid fa-briefcase"></i>

                                        </div>

                                        <div class="user-data">

                                            <strong>
                                                {{ $job->title }}
                                            </strong>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    {{ $job->user->name ?? 'مستخدم غير معروف' }}

                                </td>


                                <td>
                                    {{ $job->company_name }}
                                </td>


                                <td>
                                    {{ $job->category }}
                                </td>


                                <td>
                                    {{ $job->job_type }}
                                </td>


                                <td>
                                    {{ $job->location ?? 'غير محدد' }}
                                </td>


                                <td>

                                    @if ($job->status === 'pending')
                                        <span class="status-badge pending">

                                            <i class="fa-solid fa-clock"></i>

                                            قيد المراجعة

                                        </span>
                                    @elseif ($job->status === 'approved')
                                        <span class="status-badge has-jobs">

                                            <i class="fa-solid fa-circle-check"></i>

                                            مقبولة

                                        </span>
                                    @else
                                        <span class="status-badge rejected">

                                            <i class="fa-solid fa-circle-xmark"></i>

                                            مرفوضة

                                        </span>
                                    @endif

                                </td>


                                <td>

                                    {{ $job->created_at?->format('Y-m-d') }}

                                </td>


                                <td>

                                    <div class="user-actions">


                                        <a href="{{ route('admin.jobs.show', $job->id) }}" class="action-btn"
                                            title="عرض الوظيفة">

                                            <i class="fa-solid fa-eye"></i>

                                        </a>


                                        @if ($job->status !== 'approved')
                                            <form method="POST" action="{{ route('admin.jobs.approve', $job->id) }}"
                                                style="display:inline;">

                                                @csrf

                                                @method('PATCH')

                                                <button type="submit" class="action-btn" title="قبول الوظيفة">

                                                    <i class="fa-solid fa-check"></i>

                                                </button>

                                            </form>
                                        @endif


                                        @if ($job->status !== 'rejected')
                                            <form method="POST" action="{{ route('admin.jobs.reject', $job->id) }}"
                                                style="display:inline;">

                                                @csrf

                                                @method('PATCH')

                                                <button type="submit" class="action-btn" title="رفض الوظيفة">

                                                    <i class="fa-solid fa-xmark"></i>

                                                </button>

                                            </form>
                                        @endif


                                        <form method="POST" action="{{ route('admin.jobs.destroy', $job->id) }}"
                                            style="display:inline;"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذه الوظيفة؟');">

                                            @csrf

                                            @method('DELETE')

                                            <button type="submit" class="action-btn delete-btn" title="حذف الوظيفة">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </form>


                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="10">

                                    <x-home.banner.no_results logo="fa-solid fa-briefcase" title="لا توجد وظائف"
                                        content="لم يتم العثور على أي وظائف منشورة." />

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{ $jobs->withQueryString()->links('vendor.pagination.custom') }}


        </div>

    </div>

@endsection

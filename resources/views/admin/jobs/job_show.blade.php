```blade
@extends('admin.layout.app')

@section('title', 'لوحة الإدارة | تفاصيل الوظيفة')

@section('page-title', 'تفاصيل الوظيفة')

@section('page-description', 'عرض جميع تفاصيل الوظيفة')

@section('content')

    <div class="users-page">

        <div class="users-header">

            <div class="users-title">

                <div class="title-icon">
                    <i class="fa-solid fa-briefcase"></i>
                </div>

                <div>

                    <h2>
                        {{ $job->title }}
                    </h2>

                    <p>
                        تفاصيل الوظيفة المنشورة بواسطة
                        <strong>{{ $job->user->name }}</strong>
                    </p>

                </div>

            </div>

        </div>


        <div class="users-card">

            <div class="table-responsive">

                <table class="users-table">

                    <tbody>

                        <tr>
                            <th>اسم الوظيفة</th>
                            <td>{{ $job->title }}</td>
                        </tr>

                        <tr>
                            <th>اسم الشركة</th>
                            <td>{{ $job->company_name }}</td>
                        </tr>

                        <tr>
                            <th>رقم الهاتف</th>
                            <td>{{ $job->phone }}</td>
                        </tr>

                        <tr>
                            <th>واتساب</th>
                            <td>{{ $job->whatsapp }}</td>
                        </tr>

                        <tr>
                            <th>التصنيف</th>
                            <td>{{ $job->category }}</td>
                        </tr>

                        <tr>
                            <th>المؤهل</th>
                            <td>{{ $job->qualification }}</td>
                        </tr>

                        <tr>
                            <th>الموقع</th>
                            <td>{{ $job->location ?? 'غير محدد' }}</td>
                        </tr>

                        <tr>
                            <th>نوع العمل</th>
                            <td>{{ $job->job_type }}</td>
                        </tr>

                        <tr>
                            <th>الخبرة</th>
                            <td>{{ $job->experience }}</td>
                        </tr>

                        <tr>
                            <th>الحد الأدنى للراتب</th>
                            <td>{{ $job->salary_min ?? 'غير محدد' }}</td>
                        </tr>

                        <tr>
                            <th>الحد الأقصى للراتب</th>
                            <td>{{ $job->salary_max ?? 'غير محدد' }}</td>
                        </tr>

                        <tr>
                            <th>عدد الوظائف المطلوبة</th>
                            <td>{{ $job->vacancies }}</td>
                        </tr>

                        <tr>
                            <th>ساعات العمل</th>
                            <td>{{ $job->working_hours ?? 'غير محدد' }}</td>
                        </tr>

                        <tr>
                            <th>أيام العمل</th>
                            <td>{{ $job->working_days ?? 'غير محدد' }}</td>
                        </tr>

                        <tr>
                            <th>آخر موعد للتقديم</th>
                            <td>{{ $job->application_deadline }}</td>
                        </tr>

                        <tr>
                            <th>الوصف</th>
                            <td>{{ $job->description }}</td>
                        </tr>

                        <tr>

                            <th>
                                الحالة
                            </th>

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

                        </tr>

                        <tr>
                            <th>صاحب الوظيفة</th>
                            <td>{{ $job->user->name }}</td>
                        </tr>

                        <tr>
                            <th>تاريخ النشر</th>
                            <td>{{ $job->created_at?->format('Y-m-d') }}</td>
                        </tr>

                    </tbody>

                </table>

            </div>


            <div class="user-actions" style="margin-top: 20px; display: flex; gap: 10px; align-items: center;">


                @if ($job->status !== 'approved')

                    <form method="POST"
                        action="{{ route('admin.jobs.approve', $job->id) }}">

                        @csrf
                        @method('PATCH')

                        <button type="submit"
                            class="action-btn"
                            title="قبول الوظيفة">

                            <i class="fa-solid fa-check"></i>

                        </button>

                    </form>

                @endif


                @if ($job->status !== 'rejected')

                    <form method="POST"
                        action="{{ route('admin.jobs.reject', $job->id) }}">

                        @csrf
                        @method('PATCH')

                        <button type="submit"
                            class="action-btn"
                            title="رفض الوظيفة">

                            <i class="fa-solid fa-xmark"></i>

                        </button>

                    </form>

                @endif


                <form method="POST"
                    action="{{ route('admin.jobs.destroy', $job->id) }}"
                    onsubmit="return confirm('هل أنت متأكد من حذف هذه الوظيفة؟');">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="action-btn delete-btn"
                        title="حذف الوظيفة">

                        <i class="fa-solid fa-trash"></i>

                    </button>

                </form>


            </div>

        </div>

    </div>

@endsection
```

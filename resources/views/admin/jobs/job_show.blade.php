@extends('admin.layout.app')

@push('extra_style')
    <link rel="stylesheet"
        href="{{ asset('css/admin/job-details.css') }}?v={{ @filemtime(public_path('css/admin/job-details.css')) ?: time() }}">
@endpush

@section('title', 'لوحة الإدارة | تفاصيل الوظيفة')

@section('page-title', 'تفاصيل الوظيفة')

@section('page-description', 'عرض جميع تفاصيل الوظيفة')

@section('content')

    @php
        $money = fn ($v) => ($v !== null && $v !== '') ? number_format((float) $v) . ' ج.م' : 'غير محدد';
        $deadline = $job->application_deadline
            ? \Carbon\Carbon::parse($job->application_deadline)->format('Y-m-d')
            : 'غير محدد';
        $waNumber = preg_replace('/\D/', '', (string) $job->whatsapp);
    @endphp

    <div class="jd-page">

        {{-- ================= الهيدر ================= --}}
        <header class="users-card jd-card jd-hero">

            <div class="title-icon">
                <i class="fa-solid fa-briefcase"></i>
            </div>

            <div class="jd-hero__main">
                <h2>{{ $job->title }}</h2>

                <p class="jd-hero__sub">
                    {{ $job->company_name }} — نشرها <strong>{{ $job->user->name }}</strong>
                </p>

                <div class="jd-chips">
                    @if ($job->location)
                        <span class="jd-chip"><i class="fa-solid fa-location-dot"></i> {{ $job->location }}</span>
                    @endif
                    <span class="jd-chip"><i class="fa-solid fa-business-time"></i> {{ $job->job_type }}</span>
                    <span class="jd-chip"><i class="fa-solid fa-medal"></i> {{ $job->experience }}</span>
                    <span class="jd-chip"><i class="fa-solid fa-users"></i> {{ $job->vacancies }} وظيفة مطلوبة</span>
                </div>
            </div>

            <div class="jd-hero__status">
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
            </div>

        </header>


        {{-- ================= الأقسام ================= --}}
        <div class="jd-grid">

            <section class="users-card jd-card">
                <div class="jd-sec__head">
                    <i class="fa-solid fa-address-book"></i>
                    <h3>التواصل والنشر</h3>
                </div>
                <dl class="jd-list">
                    <div class="jd-row">
                        <dt>رقم الهاتف</dt>
                        <dd>
                            @if ($job->phone)
                                <a class="jd-link" href="tel:{{ $job->phone }}">
                                    <i class="fa-solid fa-phone"></i>{{ $job->phone }}
                                </a>
                            @else
                                <span class="jd-muted">غير محدد</span>
                            @endif
                        </dd>
                    </div>
                    <div class="jd-row">
                        <dt>واتساب</dt>
                        <dd>
                            @if ($waNumber)
                                <a class="jd-link jd-link--wa" href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener">
                                    <i class="fa-brands fa-whatsapp"></i>{{ $job->whatsapp }}
                                </a>
                            @else
                                <span class="jd-muted">غير محدد</span>
                            @endif
                        </dd>
                    </div>
                    <div class="jd-row">
                        <dt>صاحب الوظيفة</dt>
                        <dd>{{ $job->user->name }}</dd>
                    </div>
                    <div class="jd-row">
                        <dt>تاريخ النشر</dt>
                        <dd>{{ $job->created_at?->format('Y-m-d') }}</dd>
                    </div>
                </dl>
            </section>

            <section class="users-card jd-card">
                <div class="jd-sec__head">
                    <i class="fa-solid fa-list-check"></i>
                    <h3>تفاصيل الوظيفة</h3>
                </div>
                <dl class="jd-list">
                    <div class="jd-row"><dt>اسم الوظيفة</dt><dd>{{ $job->title }}</dd></div>
                    <div class="jd-row"><dt>اسم الشركة</dt><dd>{{ $job->company_name }}</dd></div>
                    <div class="jd-row"><dt>التصنيف</dt><dd>{{ $job->category }}</dd></div>
                    <div class="jd-row"><dt>المؤهل</dt><dd>{{ $job->qualification }}</dd></div>
                    <div class="jd-row"><dt>الموقع</dt><dd>{{ $job->location ?? 'غير محدد' }}</dd></div>
                    <div class="jd-row"><dt>نوع العمل</dt><dd>{{ $job->job_type }}</dd></div>
                    <div class="jd-row"><dt>الخبرة</dt><dd>{{ $job->experience }}</dd></div>
                </dl>
            </section>

            <section class="users-card jd-card">
                <div class="jd-sec__head">
                    <i class="fa-solid fa-sack-dollar"></i>
                    <h3>الراتب والدوام</h3>
                </div>
                <dl class="jd-list">
                    <div class="jd-row"><dt>الحد الأدنى للراتب</dt><dd>{{ $money($job->salary_min) }}</dd></div>
                    <div class="jd-row"><dt>الحد الأقصى للراتب</dt><dd>{{ $money($job->salary_max) }}</dd></div>
                    <div class="jd-row"><dt>عدد الوظائف المطلوبة</dt><dd>{{ $job->vacancies }}</dd></div>
                    <div class="jd-row"><dt>ساعات العمل</dt><dd>{{ $job->working_hours ?? 'غير محدد' }}</dd></div>
                    <div class="jd-row"><dt>أيام العمل</dt><dd>{{ $job->working_days ?? 'غير محدد' }}</dd></div>
                    <div class="jd-row"><dt>آخر موعد للتقديم</dt><dd>{{ $deadline }}</dd></div>
                </dl>
            </section>

        </div>


        {{-- ================= الوصف ================= --}}
        <section class="users-card jd-card">
            <div class="jd-sec__head">
                <i class="fa-solid fa-align-right"></i>
                <h3>الوصف</h3>
            </div>
            <div class="jd-desc__body">{{ trim((string) $job->description) !== '' ? $job->description : 'لا يوجد وصف.' }}</div>
        </section>


        {{-- ================= الإجراءات ================= --}}
        <div class="users-card jd-card jd-actions">

            @if ($job->status !== 'approved')

                <form method="POST" action="{{ route('admin.jobs.approve', $job->id) }}">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="jd-btn jd-btn--ok" title="قبول الوظيفة">
                        <i class="fa-solid fa-check"></i> قبول
                    </button>
                </form>

            @endif


            @if ($job->status !== 'rejected')

                <form method="POST" action="{{ route('admin.jobs.reject', $job->id) }}">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="jd-btn jd-btn--reject" title="رفض الوظيفة">
                        <i class="fa-solid fa-xmark"></i> رفض
                    </button>
                </form>

            @endif


            <form method="POST" action="{{ route('admin.jobs.destroy', $job->id) }}"
                onsubmit="return confirm('هل أنت متأكد من حذف هذه الوظيفة؟');">
                @csrf
                @method('DELETE')

                <button type="submit" class="jd-btn jd-btn--delete" title="حذف الوظيفة">
                    <i class="fa-solid fa-trash"></i> حذف
                </button>
            </form>

        </div>

    </div>

@endsection

@extends('admin.layout.app')

@section('title', 'لوحة التحكم | دليل الأطباء')

@section('content')


    <div class="dashboard-content">

        {{-- =========================================================
    | Welcome
    ========================================================== --}}
        <div class="welcome-row">

            <div class="welcome-text">

                <h2>
                    أهلاً {{ \Illuminate\Support\Facades\Auth::user()->name ?? 'admin' }} 👋
                </h2>

                <p>
                    إليك ملخص حالة موقع دليل الأطباء اليوم
                </p>

            </div>

            <div class="date-box">

                <i class="fa-regular fa-calendar"></i>

                {{ \Carbon\Carbon::now()->translatedFormat('l d F') }}

            </div>

        </div>


        {{-- =========================================================
    | Statistics
    ========================================================== --}}
        <div class="stats-grid">

            {{-- إجمالي الأطباء --}}
            <div class="stat-card">

                <div class="stat-icon blue-icon">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>

                <div class="stat-info">

                    <p>
                        إجمالي الأطباء
                    </p>

                    <h3>
                        {{ $totalDoctors }}
                    </h3>

                    <span class="stat-change up">

                        <i class="fa-solid fa-arrow-up"></i>

                        {{ $totalDoctorsThisMonth }} طبيب هذا الشهر

                    </span>

                </div>

            </div>


            {{-- طلبات الإضافة --}}
            <div class="stat-card">

                <div class="stat-icon orange-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>

                <div class="stat-info">

                    <p>
                        طلبات الإضافة
                    </p>

                    <h3>
                        {{ $totalDoctorpending }}
                    </h3>

                </div>

            </div>


            {{-- زيارات الموقع --}}
            <div class="stat-card">

                <div class="stat-icon green-icon">
                    <i class="fa-regular fa-eye"></i>
                </div>

                <div class="stat-info">

                    <p>
                        زيارات الموقع
                    </p>

                    <h3>
                        48,920
                    </h3>

                </div>

            </div>


            {{-- الأطباء المشتركون --}}
            <div class="stat-card">

                <div class="stat-icon purple-icon">
                    <i class="fa-solid fa-user-check"></i>
                </div>

                <div class="stat-info">

                    <p>
                        الأطباء المشتركون
                    </p>

                    <h3>
                        {{ $subscribedDoctors }}
                    </h3>

                    <span class="stat-change up">

                        <i class="fa-solid fa-arrow-up"></i>

                        {{ $subscribedDoctorsThisMonth }} أطباء اشتركوا هذا الشهر

                    </span>

                </div>

            </div>

        </div>


        {{-- =========================================================
    | Requests + Specialties
    ========================================================== --}}
        <div class="dashboard-grid">

            {{-- =====================================================
        | Pending Doctors
        ====================================================== --}}
            <div class="dashboard-card requests-card">

                <div class="card-header">

                    <div>

                        <h3>
                            طلبات إضافة الأطباء
                        </h3>

                        <p>
                            طلبات جديدة تحتاج إلى مراجعة
                        </p>

                    </div>

                    @if ($pendingDoctor->isNotEmpty())
                        <a href="{{ route('admin.pending_doctors.index') }}" class="card-link">

                            عرض كل الطلبات

                            <i class="fa-solid fa-arrow-left"></i>

                        </a>
                    @endif

                </div>


                @if ($pendingDoctor->isNotEmpty())

                    <div class="doctor-pending-table-wrapper">

                        <table class="doctor-pending-table">

                            <thead>

                                <tr>

                                    <th>
                                        الطبيب
                                    </th>

                                    <th>
                                        التخصص
                                    </th>

                                    <th>
                                        المحافظة
                                    </th>

                                    <th>
                                        تاريخ الطلب
                                    </th>

                                    <th>
                                        الحالة
                                    </th>

                                    <th>
                                        الإجراءات
                                    </th>

                                </tr>

                            </thead>

                            <tbody id="requestsBody">

                                @foreach ($pendingDoctor as $doctor)
                                    <tr data-id="{{ $doctor->id }}" data-name="{{ $doctor->user->name }}"
                                        data-phone="{{ $doctor->phone }}" data-specialty="{{ $doctor->specialty->name }}"
                                        data-area="{{ $doctor->area?->name ?? 'لم تحدد' }}" data-status="قيد المراجعة">

                                        {{-- الطبيب --}}
                                        <td>

                                            <div class="doctor-pending-doctor-info">

                                                <div class="doctor-pending-avatar">

                                                    @if ($doctor->doctor_image)
                                                        <img src="{{ asset('storage/' . $doctor->doctor_image) }}"
                                                            alt="صورة الطبيب">
                                                    @else
                                                        <i class="fa-solid fa-user-doctor"></i>
                                                    @endif

                                                </div>

                                                <div>

                                                    <div class="doctor-pending-name">

                                                        د. {{ $doctor->user->name }}

                                                    </div>

                                                    <div class="doctor-pending-phone">

                                                        {{ $doctor->phone }}

                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- التخصص --}}
                                        <td>

                                            <span class="doctor-pending-specialty">

                                                {{ $doctor->specialty->name }}

                                            </span>

                                        </td>


                                        {{-- المحافظة --}}
                                        <td>

                                            {{ $doctor->area->name }}

                                        </td>


                                        {{-- تاريخ الطلب --}}
                                        <td>

                                            <span class="doctor-pending-date">

                                                {{ $doctor->created_at->translatedFormat('d F Y') }}

                                            </span>

                                        </td>


                                        {{-- الحالة --}}
                                        <td>

                                            <span class="doctor-pending-status">

                                                <i class="fa-solid fa-clock"></i>

                                                {{ $doctor->subscription?->plan_id == 1 ? 'لم يشترك' : 'اشتراك منتهي' }}

                                            </span>

                                        </td>


                                        {{-- الإجراءات --}}
                                        <td>

                                            <div class="doctor-pending-actions">

                                                {{-- عرض التفاصيل --}}
                                                <button type="button" class="doctor-pending-action view"
                                                    title="عرض التفاصيل">

                                                    <i class="fa-solid fa-eye"></i>

                                                </button>


                                                {{-- قبول --}}
                                                <form action="{{ route('admin.doctor_pending.approve', $doctor->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('هل أنت متأكد من إضافة الدكتور وظهوره في الموقع؟')">

                                                    @csrf

                                                    <button type="submit" class="doctor-pending-action accept"
                                                        title="قبول ظهور الطبيب">

                                                        <i class="fa-solid fa-check"></i>

                                                    </button>

                                                </form>


                                                {{-- رفض --}}
                                                <form action="{{ route('admin.doctor_pending.reject', $doctor->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('هل أنت متأكد من رفض طلب إضافة الدكتور؟')">

                                                    @csrf

                                                    <button type="submit" class="doctor-pending-action reject"
                                                        title="رفض">

                                                        <i class="fa-solid fa-xmark"></i>

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>
                @else
                    <x-home.banner.no_results logo="fa-solid fa-user-doctor" title="لا توجد طلبات إضافة حاليًا"
                        content="لم يتم العثور على أطباء في انتظار المراجعة" />

                @endif

            </div>


            {{-- =====================================================
        | Specialties Distribution
        ====================================================== --}}
            @if ((int) $totalDoctors > 0)

                <div class="dashboard-card">

                    <div class="card-header">

                        <div>

                            <h3>
                                توزيع الأطباء
                            </h3>

                            <p>
                                حسب التخصصات
                            </p>

                        </div>

                    </div>


                    <div class="specialties-content">

                        {{-- الرسم البياني --}}
                        <div class="doughnut-box">

                            <canvas id="specialtiesChart"></canvas>

                            <div class="chart-center">

                                <strong>
                                    {{ $totalDoctors }}
                                </strong>

                                <span>
                                    طبيب
                                </span>

                            </div>

                        </div>


                        {{-- قائمة التخصصات --}}
                        <div class="specialties-list">

                            @foreach ($specialties as $index => $specialty)
                                <div class="specialty-row">

                                    <div class="specialty-name">

                                        <span
                                            class="specialty-color {{ ['blue-color', 'green-color', 'orange-color', 'purple-color'][$index] ?? 'other-color' }}"></span>

                                        {{ $specialty->specialty?->name ?? 'تخصص غير محدد' }}

                                    </div>

                                    <strong>
                                        {{ $specialty->total }}
                                    </strong>

                                </div>
                            @endforeach


                            @if ($otherDoctors > 0)
                                <div class="specialty-row">

                                    <div class="specialty-name">

                                        <span class="specialty-color other-color"></span>

                                        تخصصات أخرى

                                    </div>

                                    <strong>
                                        {{ $otherDoctors }}
                                    </strong>

                                </div>
                            @endif

                        </div>

                    </div>

                </div>
            @else
                <div class="dashboard-card">

                    <x-home.banner.no_results logo="fa-solid fa-user-doctor" title="لا يوجد أطباء حاليًا"
                        content="لم يتم العثور على أطباء لعرض توزيع التخصصات" />

                </div>

            @endif

        </div>


        {{-- =========================================================
    | Bottom Grid
    ========================================================== --}}
        <div class="bottom-grid">


            {{-- =====================================================
        | Latest Reviews
        ====================================================== --}}
            <div class="dashboard-card reviews-card doctor-latest-reviews">

                <div class="reviews-header doctor-reviews-header">

                    <div class="reviews-header-content">

                        <h3>
                            آخر التقييمات
                        </h3>

                        <p>
                            أحدث تقييمات المرضى للأطباء
                        </p>

                    </div>

                    <a href="{{ route('ratings.index') }}" class="reviews-card-link">

                        <span>
                            عرض الكل
                        </span>

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>

                </div>


                <div class="doctor-reviews-list">

                    @forelse ($latestRatings as $rating)

                        <article class="doctor-review-item">


                            {{-- بيانات المريض --}}
                            <div class="doctor-review-patient">

                                <div class="doctor-review-avatar">

                                    {{ mb_substr($rating->user->name ?? 'م', 0, 1) }}

                                </div>

                                <div class="doctor-review-patient-info">

                                    <strong>
                                        {{ $rating->user->name ?? 'مستخدم غير معروف' }}
                                    </strong>

                                    <span>
                                        {{ $rating->created_at?->diffForHumans() ?? 'ليس له وقت انشاء'}}
                                    </span>

                                </div>

                            </div>


                            {{-- محتوى التقييم --}}
                            <div class="doctor-review-content">

                                <div class="doctor-review-heading">

                                    <div class="doctor-review-doctor">

                                        <strong>
                                            د. {{ $rating->doctor->user->name ?? 'طبيب غير معروف' }}
                                        </strong>

                                        <span>
                                            تقييم للطبيب
                                        </span>

                                    </div>


                                    @php
                                        $ratingValue = (int) $rating->rating;
                                    @endphp

                                    <div class="doctor-review-stars" aria-label="التقييم {{ $ratingValue }} من 5">

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $ratingValue)
                                                <i class="fa-solid fa-star doctor-star-filled"></i>
                                            @else
                                                <i class="fa-regular fa-star doctor-star-empty"></i>
                                            @endif
                                        @endfor

                                    </div>

                                </div>


                                {{-- التعليق --}}
                                <div class="doctor-review-comment-area">

                                    <span class="doctor-review-comment-label">
                                        التعليق
                                    </span>

                                    @if ($rating->comment)
                                        <p class="doctor-review-comment-text">
                                            {{ $rating->comment }}
                                        </p>
                                    @else
                                        <p class="doctor-review-comment-empty">
                                            لا يوجد تعليق
                                        </p>
                                    @endif

                                </div>

                            </div>


                            {{-- الإجراءات --}}
                            <div class="doctor-review-actions">

                                <a href="{{ route('ratings.edit', $rating->id) }}" class="doctor-review-edit-btn"
                                    title="تعديل التقييم">

                                    <i class="fa-regular fa-pen-to-square"></i>

                                    <span>
                                        تعديل
                                    </span>

                                </a>


                                <form action="{{ route('ratings.destroy', $rating->id) }}" method="POST"
                                    class="doctor-review-delete-form"
                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟')">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit" class="doctor-review-delete-btn" title="حذف التقييم">

                                        <i class="fa-regular fa-trash-can"></i>

                                        <span>
                                            حذف
                                        </span>

                                    </button>

                                </form>

                            </div>

                        </article>

                    @empty

                        <x-home.banner.no_results logo="fa-solid fa-star" title="لا توجد تقييمات حتى الآن"
                            content="لم يتم العثور على تقييمات حاليًا" />

                    @endforelse

                </div>

            </div>


            {{-- =====================================================
        | Expiring Subscriptions
        ====================================================== --}}
            <div class="dashboard-card subscriptions-card">

                <div class="card-header">

                    <div>

                        <h3>
                            اشتراكات قربت تخلص
                        </h3>

                        <p>
                            تحتاج متابعة أو تجديد
                        </p>

                    </div>

                    <a href="{{ route('admin.subscribed_doctors.index') }}" class="card-link">

                        عرض الكل

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>

                </div>


                <div class="subscriptions-list">

                    @forelse ($expiringDoctors as $doctor)
                        <div class="subscription-item">


                            {{-- بيانات الطبيب --}}
                            <div class="subscription-doctor">

                                <div class="subscription-avatar">

                                    {{ mb_substr($doctor?->user?->name ?? 'ط', 0, 1) }}

                                </div>

                                <div>

                                    <strong>
                                        د.{{ $doctor?->user?->name ?? 'طبيب' }}
                                    </strong>

                                    <span>
                                        {{ $doctor->specialty?->name ?? 'بدون تخصص' }}
                                    </span>

                                </div>

                            </div>


                            {{-- المدة المتبقية --}}
                            <div class="subscription-date">

                                <span class="days danger-days">

                                    متبقي {{ $doctor->remaining_days }} يوم

                                </span>

                            </div>


                            {{-- التجديد --}}
                            <a href="{{ route('admin.doctor.edit', $doctor->id) }}"
                                class="doctor-pending-action edit-btn" title="تجديد الطبيب">

                                <span>
                                    تجديد
                                </span>

                            </a>

                        </div>

                    @empty

                        <x-home.banner.no_results logo="fa-solid fa-calendar-check"
                            title="لا توجد اشتراكات قاربت على الانتهاء"
                            content="لم يتم العثور على أطباء قاربت اشتراكاتهم على الانتهاء" />
                    @endforelse

                </div>

            </div>

        </div>

    </div>


    {{-- =============================================================
| Pending Doctor Modal
============================================================= --}}
    <x-admin.doctor_pending_modal />


@endsection

{{-- =============================================================
| Chart Data
============================================================= --}}

<script>
    window.specialtiesData = @json($specialties);

    window.otherDoctors = {{ $otherDoctors }};
</script>

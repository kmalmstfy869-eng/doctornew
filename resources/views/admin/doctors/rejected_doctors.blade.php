@extends('admin.layout.app')

@section('title', 'لوحة التحكم | الأطباء غير المشتركين')

@section('content')

```
<div class="doctor-pending-page">

    {{-- Topbar --}}
    <div class="doctor-pending-topbar">
        <div class="doctor-pending-page-title">
            <h1>الأطباء المرفضون </h1>
            <p>إدارة الأطباء المرفضون من الدليل </p>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="doctor-pending-stats">

        {{-- إجمالي المرفضون --}}
        <div class="doctor-pending-stat-card">
            <div class="doctor-pending-stat-icon blue">
                <i class="fa-solid fa-file-circle-plus"></i>
            </div>
            <div class="doctor-pending-stat-data">
                <h3>{{ $doctors->total() ?? 0 }}</h3>
                <p>إجمالي المرفضون </p>
            </div>
        </div>

        {{-- كان لديهم اشتراك --}}
        <div class="doctor-pending-stat-card">
            <div class="doctor-pending-stat-icon yellow">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="doctor-pending-stat-data">
                <h3>{{ $expiredDoctors ?? 0 }}</h3>
                <p>كان لديهم اشتراك </p>
            </div>
        </div>

        {{-- لم يشتركوا --}}
        <div class="doctor-pending-stat-card">
            <div class="doctor-pending-stat-icon red">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <div class="doctor-pending-stat-data">
                <h3>{{ $unsubscribedDoctors ?? 0 }}</h3>
                <p>لم يشتركوا </p>
            </div>
        </div>

    </div>

    {{-- Requests Card --}}
    <div class="doctor-pending-requests-card">

        {{-- Header --}}
        <div class="doctor-pending-card-header">

            <div>
                <h2>قائمة الأطباء</h2>
                <p>جميع الأطباء المرفضون</p>
            </div>

            {{-- Search --}}
            <div class="doctor-pending-search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input
                    type="search"
                    id="searchInput"
                    placeholder="ابحث باسم الطبيب أو رقم الهاتف..."
                >
            </div>

        </div>

        {{-- Table --}}
        @if ($doctors->isNotEmpty())

            <div class="doctor-pending-table-wrapper">

                <table class="doctor-pending-table">

                    <thead>

                        <tr>

                            {{-- ID --}}
                            <th>ID</th>

                            <th>الطبيب</th>

                            <th>التخصص</th>

                            <th>المافظة</th>

                            <th>تاريخ الإضافة</th>

                            <th>الحالة</th>

                            <th>الإجراءات</th>

                        </tr>

                    </thead>


                    <tbody id="requestsBody">

                        @foreach ($doctors as $doctor)

                            <tr
                                data-id="{{ $doctor->id }}"
                                data-name="{{ $doctor->user->name ?? '' }}"
                                data-phone="{{ $doctor->phone ?? '' }}"
                                data-specialty="{{ $doctor->specialty->name ?? '' }}"
                                data-area="{{ $doctor->area->name ?? '' }}"
                                data-status="{{ $doctor->subscription->plan->name == 'free' ? 'لم يشترك ' : 'اشتراك منتهي' }}"
                            >

                                {{-- ID الطبيب --}}
                                <td>

                                    <span class="doctor-pending-doctor-id">
                                        #{{ $doctor->id }}
                                    </span>

                                </td>


                                {{-- الطبيب --}}
                                <td>

                                    <div class="doctor-pending-doctor-info">

                                        <div class="doctor-pending-avatar">

                                            @if (!empty($doctor->doctor_image))

                                                <img
                                                    src="{{ asset('storage/' . $doctor->doctor_image) }}"
                                                    alt="صورة الطبيب"
                                                >

                                            @else

                                                <i class="fa-solid fa-user-doctor"></i>

                                            @endif

                                        </div>

                                        <div>

                                            <div class="doctor-pending-name">
                                                د. {{ $doctor->user->name ?? 'غير محدد' }}
                                            </div>

                                            <div class="doctor-pending-phone">
                                                {{ $doctor->phone ?? '—' }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- التخصص --}}
                                <td>

                                    <span class="doctor-pending-specialty">
                                        {{ $doctor->specialty->name ?? '—' }}
                                    </span>

                                </td>


                                {{-- المحافظة --}}
                                <td>
                                    {{ $doctor->area->name ?? '—' }}
                                </td>


                                {{-- تاريخ الإضافة --}}
                                <td>

                                    <span class="doctor-pending-date">
                                        {{ $doctor->created_at ? $doctor->created_at->translatedFormat('d F Y') : '—' }}
                                    </span>

                                </td>


                                {{-- الحالة --}}
                                <td>

                                    <span class="doctor-pending-status">

                                        <i class="fa-solid fa-circle-exclamation"></i>

                                        {{ $doctor->subscription->plan->name == 'free'
                                            ? 'لم يشترك '
                                            : 'اشتراك منتهي'
                                        }}

                                    </span>

                                </td>


                                {{-- الإجراءات --}}
                                <td>

                                    <div class="doctor-pending-actions">

                                        {{-- عرض التفاصيل --}}
                                        <button
                                            type="button"
                                            class="doctor-pending-action view"
                                            title="عرض التفاصيل"
                                        >
                                            <i class="fa-solid fa-eye"></i>
                                        </button>


                                        {{-- قبول --}}
                                        <form
                                            action="{{ route('admin.rejected_doctor.restore', $doctor->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من اعاده الدكتور وظهوره في الموقع؟')"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="doctor-pending-action accept"
                                                title="قبول ظهور الطبيب"
                                            >
                                                <i class="fa-solid fa-check"></i>
                                            </button>

                                        </form>


                                        {{-- حذف --}}
                                        <form
                                            action="{{ route('admin.rejected_doctors.destroy', $doctor->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا الطبيب نهائيا؟')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="doctor-pending-action delete-btn"
                                                title="حذف الطبيب"
                                            >
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            <div class="doctor-pending-pagination">

                {{ $doctors->links('vendor.pagination.custom') }}

            </div>


        @else

            <x-home.banner.no_results
                logo="fa-solid fa-user-doctor"
                title="لا يوجد أطباء"
                content="لم يتم العثور على أطباء مرفضون حاليًا"
            />

        @endif

    </div>

</div>


{{-- DETAILS MODAL --}}
<x-admin.doctor_pending_modal />
```

@endsection

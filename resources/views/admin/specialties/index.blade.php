@extends('admin.layout.app')

@section('title', 'لوحة التحكم | التخصصات')

@section('content')

    <div class="doctor-pending-page">

        {{-- =========================================================
        TOPBAR
        ========================================================== --}}

        <div class="doctor-pending-topbar">

            {{-- عنوان الصفحة --}}
            <div class="doctor-pending-page-title">

                <h1>
                    التخصصات الطبية
                </h1>

                <p>
                    إدارة التخصصات الموجودة في دليل الأطباء
                </p>

            </div>


            {{-- زر إضافة تخصص --}}
            <form action="{{ route('admin.specialties.create') }}" method="GET">

                <button type="submit" class="doctor-button-card">

                    <i class="fa-solid fa-plus"></i>

                    إضافة تخصص

                </button>

            </form>

        </div>


        {{-- =========================================================
        STATISTICS
        ========================================================== --}}

        <div class="doctor-pending-stats">

            {{-- إجمالي التخصصات --}}
            <div class="doctor-pending-stat-card">

                <div class="doctor-pending-stat-icon blue">

                    <i class="fa-solid fa-stethoscope"></i>

                </div>

                <div class="doctor-pending-stat-data">

                    <h3>
                        {{ $specialties->total() ?? 0 }}
                    </h3>

                    <p>
                        إجمالي التخصصات
                    </p>

                </div>

            </div>


            {{-- إجمالي الأطباء --}}
            <div class="doctor-pending-stat-card">

                <div class="doctor-pending-stat-icon yellow">

                    <i class="fa-solid fa-user-doctor"></i>

                </div>

                <div class="doctor-pending-stat-data">

                    <h3>
                        {{ $totalDoctors ?? 0 }}
                    </h3>

                    <p>
                        إجمالي الأطباء
                    </p>

                </div>

            </div>


            {{-- تخصصات بدون أطباء --}}
            <div class="doctor-pending-stat-card">

                <div class="doctor-pending-stat-icon red">

                    <i class="fa-solid fa-user-slash"></i>

                </div>

                <div class="doctor-pending-stat-data">

                    <h3>
                        {{ $emptySpecialties ?? 0 }}
                    </h3>

                    <p>
                        تخصصات بدون أطباء
                    </p>

                </div>

            </div>

        </div>


        {{-- =========================================================
        SPECIALTIES CARD
        ========================================================== --}}

        <div class="doctor-pending-requests-card">

            {{-- Header --}}
            <div class="doctor-pending-card-header">

                <div>

                    <h2>
                        قائمة التخصصات
                    </h2>

                    <p>
                        جميع التخصصات المسجلة في النظام
                    </p>

                </div>


                {{-- Search --}}
                <div class="doctor-pending-search">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="search" id="searchInput" placeholder="ابحث باسم التخصص...">

                </div>

            </div>


            {{-- =====================================================
            TABLE
            ====================================================== --}}

            @if ($specialties->isNotEmpty())

                <div class="doctor-pending-table-wrapper">

                    <table class="doctor-pending-table">

                        <thead>

                            <tr>

                                <th>
                                    ترتيب الموقع
                                </th>

                                <th>
                                    التخصص
                                </th>

                                <th>
                                    العنوان
                                </th>

                                <th>
                                    عدد الأطباء
                                </th>

                                <th>
                                    الإجراءات
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($specialties as $specialty)
                                <tr>

                                    {{-- ترتيب الموقع --}}
                                    <td>

                                        <span class="doctor-pending-specialty">

                                            {{ $specialty->sort_order }}

                                        </span>

                                    </td>


                                    {{-- التخصص --}}
                                    <td>

                                        <div class="doctor-pending-doctor-info">

                                            <div class="doctor-pending-avatar">

                                                <i class="{{ $specialty->logo }}"></i>

                                            </div>

                                            <div>

                                                <div class="doctor-pending-name">

                                                    {{ $specialty->name }}

                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- العنوان --}}
                                    <td>

                                        <span class="doctor-pending-specialty">

                                            {{ $specialty->title }}

                                        </span>

                                    </td>


                                    {{-- عدد الأطباء --}}
                                    <td>

                                        <span class="doctor-pending-specialty">

                                            {{ $specialty->doctors_count ?? 0 }}

                                            طبيب

                                        </span>

                                    </td>


                                    {{-- الإجراءات --}}

                                    <td>

                                        <div class="doctor-pending-actions">

                                            <a href="{{ route('admin.specialties.edit', ['specialty' => $specialty->id]) }}"
                                                title="تعديل التخصص">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            {{-- حذف --}}
                                            <form action="{{ route('admin.specialties.destroy', $specialty->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا التخصص نهائيًا؟')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="doctor-pending-action reject"
                                                    title="حذف التخصص">
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

                    {{ $specialties->links('vendor.pagination.custom') }}

                </div>
            @else
                <x-home.banner.no_results logo="fa-solid fa-stethoscope" title="لا يوجد تخصصات"
                    content="لم يتم العثور على تخصصات مسجلة حاليًا" />

            @endif

        </div>

    </div>

@endsection

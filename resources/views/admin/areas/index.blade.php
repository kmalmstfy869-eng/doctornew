@extends('admin.layout.app')

@section('title', 'لوحة التحكم | المناطق')

@section('content')

    <div class="doctor-pending-page">

        {{-- =========================================================
        TOPBAR
        ========================================================== --}}

        <div class="doctor-pending-topbar">

            {{-- عنوان الصفحة --}}
            <div class="doctor-pending-page-title">

                <h1>
                    المناطق
                </h1>

                <p>
                    إدارة المناطق الموجودة في دليل الأطباء
                </p>

            </div>


            {{-- زر إضافة تخصص --}}
            <form action="{{ route('admin.areas.create') }}" method="GET">

                <button type="submit" class="doctor-button-card">

                    <i class="fa-solid fa-plus"></i>

                    إضافة منطقه

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
                        {{ $areas->total() ?? 0 }}
                    </h3>

                    <p>
                        إجمالي المناطق
                    </p>

                </div>

            </div>



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



            <div class="doctor-pending-stat-card">

                <div class="doctor-pending-stat-icon red">

                    <i class="fa-solid fa-user-slash"></i>

                </div>

                <div class="doctor-pending-stat-data">

                    <h3>
                        {{ $emptyArea ?? 0 }}
                    </h3>

                    <p>
                        مناطق بدون أطباء
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
                        قائمة المناطق
                    </h2>

                    <p>
                        جميع المناطق المسجلة في النظام
                    </p>

                </div>


                {{-- Search --}}
                <div class="doctor-pending-search">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="search" id="searchInput" placeholder="ابحث باسم المنطقه...">

                </div>

            </div>


            {{-- =====================================================
            TABLE
            ====================================================== --}}

            @if ($areas->isNotEmpty())

                <div class="doctor-pending-table-wrapper">

                    <table class="doctor-pending-table">

                        <thead>

                            <tr>

                                <th>
                                    ترتيب الموقع
                                </th>

                                <th>
                                    المنطقه
                                </th>

                                <th>
                                    slug
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

                            @foreach ($areas as $area)

                                <tr>

                                    {{-- ترتيب الموقع --}}
                                    <td>

                                        <span class="doctor-pending-specialty">

                                              {{ $areas->firstItem() + $loop->index }}

                                        </span>

                                    </td>


                                    {{-- التخصص --}} <td>


                                        <div class="doctor-pending-doctor-info">

                                            <div class="doctor-area-avatar">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </div>

                                            <div class="doctor-area-name">
                                                {{ $area->name }}
                                            </div>

                                        </div>
                                    </td>

                                    <td>
                                        <div class="doctor-pending-doctor-info">





                                            <div class="doctor-area-name">
                                                {{ $area->slug }}
                                            </div>

                                        </div>
                                    </td>





                                    {{-- عدد الأطباء --}}
                                    <td>

                                        <span class="doctor-pending-specialty">

                                            {{ $area->doctors_count ?? 0 }}

                                            طبيب

                                        </span>

                                    </td>


                                    {{-- الإجراءات --}}

                                    <td>

                                        <div class="doctor-pending-actions">

                                            <a href="{{ route('admin.areas.edit', $area->id) }}" title="تعديل التخصص">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            {{-- حذف --}}
                                            <form action="{{ route('admin.areas.destroy', $area->id) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذه المنطقة نهائيًا؟')">

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

                    {{ $areas->links('vendor.pagination.custom') }}

                </div>
            @else
                <x-home.banner.no_results logo="fa-solid fa-stethoscope" title="لا يوجد تخصصات"
                    content="لم يتم العثور على مناطق مسجلة حاليًا" />

            @endif

        </div>

    </div>

@endsection

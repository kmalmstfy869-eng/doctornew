@extends('admin.layout.app')

@section('title', 'لوحة التحكم | طلبات إضافة الأطباء')

@section('content')


    <div class="doctor-pending-page">

        {{-- Topbar --}}
        <div class="doctor-pending-topbar">

            <div class="doctor-pending-page-title">
                <h1>طلبات إضافة الأطباء</h1>
                <p>مراجعة الطلبات الجديدة وقبول أو رفض إضافة الطبيب</p>
            </div>

            {{-- قبول كل الطلبات --}}
            @if ($pendingDoctor->isNotEmpty())
                <form action="{{ route('admin.doctors_pending.approve_all') }}" method="POST"
                    onsubmit="return confirm('هل أنت متأكد من قبول جميع طلبات إضافة الأطباء؟')">

                    @csrf

                    <button type="submit" class="doctor-button-card">
                        قبول الكل
                        <i class="fa-solid fa-check-double"></i>
                    </button>

                </form>
            @endif

        </div>

        {{-- Statistics --}}
        <div class="doctor-pending-stats">

            {{-- إجمالي الطلبات --}}
            <div class="doctor-pending-stat-card">
                <div class="doctor-pending-stat-icon blue">
                    <i class="fa-solid fa-file-circle-plus"></i>
                </div>
                <div class="doctor-pending-stat-data">
                    <h3>{{ $pendingDoctor->total() ?? 0 }}</h3>
                    <p>إجمالي الطلبات</p>
                </div>
            </div>

            {{-- قيد المراجعة --}}
            <div class="doctor-pending-stat-card">
                <div class="doctor-pending-stat-icon yellow">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="doctor-pending-stat-data">
                    <h3>{{ $pendingDoctor->total() ?? 0 }}</h3>
                    <p>طلبات في انتظار المراجعة</p>
                </div>
            </div>

            {{-- طلبات اليوم --}}
            <div class="doctor-pending-stat-card">
                <div class="doctor-pending-stat-icon red">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <div class="doctor-pending-stat-data">
                    <h3>{{ $pendingDoctorsToday ?? 0 }}</h3>
                    <p>طلبات وصلت اليوم</p>
                </div>
            </div>

        </div>

        {{-- Requests Card --}}
        <div class="doctor-pending-requests-card">

            {{-- Header --}}
            <div class="doctor-pending-card-header">

                <div>
                    <h2>قائمة طلبات الإضافة</h2>
                    <p>جميع طلبات الأطباء الجديدة</p>
                </div>

                {{-- Search --}}
                <div class="doctor-pending-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" data-live-search value="{{ request('search') }}"
    placeholder="ابحث بالاسم أو الهاتف أو التخصص أو المنطقة أو الـ ID..." autocomplete="off">
                </div>

            </div>

            <div id="live-results">
            @if ($pendingDoctor->isNotEmpty())

                <div class="doctor-pending-table-wrapper">

                    <table class="doctor-pending-table">

                        <thead>

                            <tr>

                                {{-- ID --}}
                                <th>ID</th>

                                <th>الطبيب</th>

                                <th>التخصص</th>

                                <th>المنطقة</th>

                                <th>تاريخ الطلب</th>

                                <th>الحالة</th>

                                <th>الإجراءات</th>

                            </tr>

                        </thead>


                        <tbody id="requestsBody">

                            @foreach ($pendingDoctor as $doctor)
                                <tr data-id="{{ $doctor->id }}" data-name="{{ $doctor->user->name }}"
                                    data-phone="{{ $doctor->phone }}" data-specialty="{{ $doctor->specialty->name }}"
                                    data-area="{{ $doctor->area->name }}" data-status="قيد المراجعة">

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


                                    {{-- المنطقة --}}
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

                                            قيد المراجعة

                                        </span>

                                    </td>


                                    {{-- الإجراءات --}}
                                    <td>

                                        <div class="doctor-pending-actions">

                                            {{-- عرض --}}
                                            <button type="button" class="doctor-pending-action view" title="عرض التفاصيل">
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

                                                <button type="submit" class="doctor-pending-action reject" title="رفض">
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


                {{-- Pagination --}}
                <div class="doctor-pending-pagination">
                    {{ $pendingDoctor->links('vendor.pagination.custom') }}
                </div>
            @else
                <x-home.banner.no_results logo="fa-solid fa-user-doctor" title="لا توجد طلبات إضافة حاليًا"
                    content="لم يتم العثور على أطباء في انتظار المراجعة" />

            @endif
            </div>
        </div>

    </div>


    {{-- DETAILS MODAL --}}
    <x-admin.doctor_pending_modal />


@endsection
@push('extra_java')
    <script src="{{ asset('js/admin/live-search.js') }}?v={{ @filemtime(public_path('js/admin/live-search.js')) ?: time() }}"></script>
@endpush

@extends('admin.layout.app')

@section('title', 'لوحة التحكم | الأطباء غير المشتركين')

@section('content')

    <div class="doctor-pending-page">

        {{-- Topbar --}}
        <div class="doctor-pending-topbar">
            <div class="doctor-pending-page-title">
                <h1>الأطباء غير المشتركين</h1>
                <p>إدارة الأطباء الموجودين في الدليل بدون اشتراك نشط</p>
            </div>
        </div>

        {{-- Statistics --}}
        <div class="doctor-pending-stats">

            {{-- إجمالي غير المشتركين --}}
            <div class="doctor-pending-stat-card">
                <div class="doctor-pending-stat-icon blue">
                    <i class="fa-solid fa-file-circle-plus"></i>
                </div>
                <div class="doctor-pending-stat-data">
                    <h3>{{ $doctors->total() ?? 0 }}</h3>
                    <p>إجمالي غير المشتركين</p>
                </div>
            </div>

            {{-- انتهى اشتراكهم --}}
            <div class="doctor-pending-stat-card">
                <div class="doctor-pending-stat-icon yellow">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="doctor-pending-stat-data">
                    <h3>{{ $expiredDoctors ?? 0 }}</h3>
                    <p>انتهى اشتراكهم</p>
                </div>
            </div>

            {{-- لم يشتركوا بعد --}}
            <div class="doctor-pending-stat-card">
                <div class="doctor-pending-stat-icon red">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
                <div class="doctor-pending-stat-data">
                    <h3>{{ $unsubscribedDoctors ?? 0 }}</h3>
                    <p>لم يشتركوا بعد</p>
                </div>
            </div>

        </div>

        {{-- Requests Card --}}
        <div class="doctor-pending-requests-card">

            {{-- Header --}}
            <div class="doctor-pending-card-header">
                <div>
                    <h2>قائمة الأطباء</h2>
                    <p>جميع الأطباء غير المشتركين</p>
                </div>

                {{-- Search --}}
                <div class="doctor-pending-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" data-live-search value="{{ request('search') }}"
                        placeholder="ابحث بالاسم أو الهاتف أو التخصص أو المنطقة أو الـ ID..." autocomplete="off">
                </div>
            </div>

            <div id="live-results">
                @if ($doctors->isNotEmpty())

                    <div class="doctor-pending-table-wrapper">

                        <table class="doctor-pending-table">

                            <thead>

                                <tr>

                                    {{-- ID --}}
                                    <th>
                                        ID
                                    </th>

                                    <th>
                                        الطبيب
                                    </th>

                                    <th>
                                        التخصص
                                    </th>

                                    <th>
                                        المنطقة
                                    </th>

                                    <th>
                                        تاريخ الإضافة
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

                                @foreach ($doctors as $doctor)
                                    <tr data-id="{{ $doctor->id }}" data-name="{{ $doctor->user->name ?? '' }}"
                                        data-phone="{{ $doctor->phone ?? '' }}"
                                        data-specialty="{{ $doctor->specialty->name ?? '' }}"
                                        data-area="{{ $doctor->area->name ?? '' }}"
                                        data-status="{{ $doctor->subscription->plan->name == 'free' ? 'لم يشترك ' : 'اشتراك منتهي' }}">

                                        {{-- =========================================
                                         DOCTOR ID
                                    ========================================== --}}
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
                                                        <img src="{{ asset('storage/' . $doctor->doctor_image) }}"
                                                            alt="صورة الطبيب">
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


                                        {{-- المنطقة --}}
                                        <td>
                                            {{ $doctor->area->name ?? '—' }}
                                        </td>


                                        {{-- تاريخ الإضافة --}}
                                        <td>
                                            <div class="doctor-date-cell">
                                                <span class="doctor-pending-date">
                                                    {{ $doctor->created_at ? $doctor->created_at->translatedFormat('d F Y') : '—' }}
                                                </span>

                                                @if ($doctor->user?->email_verified_at)
                                                    <span class="email-verify-badge verified"
                                                        title="تم التأكيد في {{ $doctor->user->email_verified_at->translatedFormat('d F Y') }}">
                                                        <i class="fa-solid fa-circle-check"></i> إيميل مؤكَّد
                                                    </span>
                                                @else
                                                    <span class="email-verify-badge unverified" title="لم يؤكد الإيميل بعد">
                                                        <i class="fa-solid fa-circle-xmark"></i> غير مؤكَّد
                                                    </span>
                                                @endif
                                            </div>
                                        </td>


                                        {{-- الحالة --}}
                                        <td>

                                            <span class="doctor-pending-status">

                                                <i class="fa-solid fa-circle-exclamation"></i>

                                                {{ $doctor->subscription->plan->name == 'free' ? 'لم يشترك ' : 'اشتراك منتهي' }}

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


                                                {{-- تعديل --}}
                                                <a href="{{ route('admin.doctor.edit', $doctor->id) }}"
                                                    class="doctor-pending-action edit-btn" title="تعديل الطبيب">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>


                                                {{-- حذف --}}
                                                <form action="{{ route('admin.doctor.destroy', $doctor->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا الطبيب؟')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="doctor-pending-action delete-btn"
                                                        title="حذف الطبيب">
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
                    <x-home.banner.no_results logo="fa-solid fa-user-doctor" title="لا يوجد أطباء"
                        content="لم يتم العثور على أطباء غير مشتركين حاليًا" />

                @endif

            </div>
        </div>

    </div>


    {{-- DETAILS MODAL --}}
    <x-admin.doctor_pending_modal />

@endsection
@push('extra_java')
    <script
        src="{{ asset('js/admin/live-search.js') }}?v={{ @filemtime(public_path('js/admin/live-search.js')) ?: time() }}">
    </script>
@endpush

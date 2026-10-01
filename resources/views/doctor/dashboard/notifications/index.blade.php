@extends('doctor.layouts.app')

@section('title', 'الإشعارات | لوحة تحكم الطبيب')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/notifications.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/no_results.css') }}">
@endpush

@section('content')

    <main class="doctor-notifications-page">

        <div class="notifications-container">

            {{-- Header --}}
            <div class="notifications-header">

                <div class="notifications-title">

                    <div class="notifications-title-icon">
                        <i class="fa-solid fa-bell"></i>
                    </div>

                    <div>
                        <h1>الإشعارات</h1>
                        <p>تابع آخر التنبيهات والتحديثات الخاصة بحسابك</p>
                    </div>

                </div>


                <div class="notifications-header-actions">

                    <div class="notifications-count">
                        {{ $notifications->total() }} إشعار
                    </div>

                    @if ($notifications->total() > 0)
                        <form action="{{ route('doctor.notifications.destroyAll') }}" method="POST"
                            onsubmit="return confirm('هل أنت متأكد من حذف جميع الإشعارات؟');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="delete-all-notifications">
                                <i class="fa-solid fa-trash-can"></i>
                                حذف الكل
                            </button>

                        </form>
                    @endif

                </div>

            </div>


            {{-- Notifications --}}
            <div class="notifications-list">

                @forelse ($notifications as $notification)
                    <div class="notification-card-wrapper">

                        <a href="{{ route('doctor.notifications.read', $notification->id) }}"
                            class="notification-card {{ !$notification->is_read ? 'unread' : '' }}">

                            <div class="notification-icon">

                                @if ($notification->type === 'rating')
                                    <i class="fa-solid fa-star"></i>
                                @elseif ($notification->type === 'subscription')
                                    <i class="fa-solid fa-crown"></i>
                                @elseif ($notification->type === 'profile')
                                    <i class="fa-solid fa-user-doctor"></i>
                                @else
                                    <i class="fa-solid fa-bell"></i>
                                @endif

                            </div>


                            <div class="notification-content">

                                <div class="notification-top">

                                    <h3>
                                        {{ $notification->title }}
                                    </h3>

                                    @if (!$notification->is_read)
                                        <span class="notification-new">
                                            جديد
                                        </span>
                                    @endif

                                </div>


                                <p>
                                    {{ $notification->message }}
                                </p>


                                <span class="notification-time">

                                    <i class="fa-regular fa-clock"></i>

                                    {{ $notification->created_at->diffForHumans() }}

                                </span>

                            </div>


                            <div class="notification-arrow">

                                <i class="fa-solid fa-chevron-left"></i>

                            </div>

                        </a>


                        {{-- Delete Notification --}}
                        <form action="{{ route('doctor.notifications.destroy', $notification->id) }}" method="POST"
                            class="delete-notification-form" onsubmit="return confirm('هل تريد حذف هذا الإشعار؟');">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="delete-notification-btn" title="حذف الإشعار">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>

                        </form>

                    </div>

                @empty

                    <x-home.banner.no_results logo="fa-solid fa-bell" title="أنت على اطلاع بكل شيء"
                        content="لا توجد إشعارات جديدة حاليًا. سنخبرك هنا بأي تحديث مهم يخص حسابك أو ملفك الطبي." />
                @endforelse

            </div>


            {{-- Pagination --}}
            @if ($notifications->hasPages())
                <div class="notifications-pagination">
                    {{ $notifications->links() }}
                </div>
            @endif

        </div>

    </main>

@endsection

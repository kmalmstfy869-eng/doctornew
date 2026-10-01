@props(['notifications'])

<div class="panel" id="notifications">


    <div class="panel-head">

        <div class="panel-title">

            <strong>
                الإشعارات
            </strong>

            <span>
                آخر التنبيهات والتحديثات الخاصة بحسابك
            </span>

        </div>


        <a href="{{ route('doctor.notifications.index') }}" class="account-action secondary">

            عرض جميع الاشعارات
        </a>

    </div>


    <div class="notifications">

        @if (isset($notifications) && $notifications->count())

            @foreach ($notifications as $notification)
                <a href="{{ route('doctor.notifications.read', $notification->id) }}"
                    class="notification-item {{ !$notification->is_read ? 'unread' : '' }}">

                    <div class="notification-icon">
                        <i class="fa-solid fa-bell"></i>
                    </div>


                    <div class="notification-content">

                        <strong>
                            {{ $notification->title }}
                        </strong>

                        <span>
                            {{ $notification->message }}
                        </span>

                    </div>


                    <div class="notification-meta">

                        <div class="notification-time">
                            {{ $notification->created_at?->diffForHumans() }}
                        </div>


                        @if ($notification->is_read)
                            <button type="button" class="notification-read"
                                onclick="event.preventDefault(); event.stopPropagation(); showToast('تم تعليم الإشعار كمقروء')"
                                title="تعليم كمقروء">
                                ✓
                            </button>
                        @endif

                    </div>

                </a>
            @endforeach
        @else
            <x-home.banner.no_results logo="fa-solid fa-bell" title="أنت على اطلاع بكل شيء"
                content="لا توجد إشعارات جديدة حاليًا. سنخبرك هنا بأي تحديث مهم يخص حسابك أو ملفك الطبي." />

        @endif

    </div>


</div>

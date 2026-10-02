self.addEventListener('push', function (event) {

    if (!event.data) {
        return;
    }

    const data = event.data.json();

    const title = data.title || 'دليل الأطباء';

    const options = {
        body: data.body || 'لديك إشعار جديد من دليل الأطباء.',

        icon: '/logo/favicon.png',

        badge: '/logo/favicon.png',

        dir: 'rtl',
        lang: 'ar',

        data: {
            url: data.data?.url || '/doctor/notifications'
        }
    };

    event.waitUntil(
        self.registration.showNotification(
            title,
            options
        )
    );
});


self.addEventListener('notificationclick', function (event) {

    event.notification.close();

    const targetUrl = event.notification.data?.url;

    if (!targetUrl) {
        return;
    }

    const url = new URL(
        targetUrl,
        self.location.origin
    ).href;

    event.waitUntil(
        clients.openWindow(url)
    );
});


document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const toggle =
        document.getElementById('notificationsToggle');

    const statusText =
        document.getElementById('notificationsStatus');

    const toggleStatus =
        document.getElementById('notificationsToggleStatus');


    if (!toggle) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Controller State
    |--------------------------------------------------------------------------
    |
    | القيمة الأساسية جاية من Blade عن طريق window.pushConfig.
    |
    */

    let controllerActive =
        window.pushConfig?.controllerActive ?? false;


    /*
    |--------------------------------------------------------------------------
    | Push Configuration
    |--------------------------------------------------------------------------
    |
    | القيم دي جاية من Blade عن طريق window.pushConfig.
    |
    */

    const pushConfig = {

        vapidPublicKey:
            window.pushConfig?.vapidPublicKey,

        statusUrl:
            window.pushConfig?.statusUrl,

        subscribeUrl:
            window.pushConfig?.subscribeUrl,

        disableUrl:
            window.pushConfig?.disableUrl,

        csrfToken:
            window.pushConfig?.csrfToken,

    };


    /*
    |--------------------------------------------------------------------------
    | UI
    |--------------------------------------------------------------------------
    */

    function setToggleState(active) {

        toggle.classList.toggle(
            'is-active',
            active
        );


        toggle.setAttribute(
            'aria-pressed',
            active ? 'true' : 'false'
        );


        toggle.dataset.active =
            active ? '1' : '0';


        if (toggleStatus) {

            toggleStatus.textContent =
                active
                    ? 'مفعلة'
                    : 'متوقفة';

            toggleStatus.style.color =
                active
                    ? '#16a34a'
                    : '#64748b';
        }


        if (statusText) {

            statusText.textContent =
                active
                    ? 'الإشعارات مفعلة حاليًا.'
                    : 'الإشعارات متوقفة حاليًا.';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Browser Support
    |--------------------------------------------------------------------------
    */

    function browserSupportsPush() {

        return (
            'serviceWorker' in navigator &&
            'PushManager' in window &&
            'Notification' in window
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VAPID
    |--------------------------------------------------------------------------
    */

    function urlBase64ToUint8Array(base64String) {

        const padding =
            '='.repeat(
                (4 - base64String.length % 4) % 4
            );

        const base64 =
            (
                base64String +
                padding
            )
            .replace(/-/g, '+')
            .replace(/_/g, '/');

        const rawData =
            window.atob(base64);

        return Uint8Array.from(
            [...rawData].map(
                char =>
                    char.charCodeAt(0)
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Service Worker
    |--------------------------------------------------------------------------
    */

    async function getRegistration() {

        if (!browserSupportsPush()) {

            throw new Error(
                'المتصفح لا يدعم إشعارات Push.'
            );
        }


        const registration =
            await navigator.serviceWorker.register(
                '/sw.js'
            );


        await navigator.serviceWorker.ready;


        return registration;
    }


    /*
    |--------------------------------------------------------------------------
    | Request
    |--------------------------------------------------------------------------
    */

    async function sendRequest(
        url,
        body
    ) {

        const response =
            await fetch(
                url,
                {

                    method: 'POST',

                    headers: {

                        'Accept':
                            'application/json',

                        'Content-Type':
                            'application/json',

                        'X-CSRF-TOKEN':
                            pushConfig.csrfToken,

                    },

                    body:
                        JSON.stringify(body),

                }
            );


        let result = {};

        try {

            result =
                await response.json();

        } catch (error) {

            result = {};

        }


        if (!response.ok) {

            throw new Error(
                result.message ||
                'حدث خطأ أثناء الاتصال بالخادم.'
            );
        }


        return result;
    }


    /*
    |--------------------------------------------------------------------------
    | Get Current Browser Subscription
    |--------------------------------------------------------------------------
    */

    async function getSubscription(
        create = false
    ) {

        const registration =
            await getRegistration();


        let subscription =
            await registration
                .pushManager
                .getSubscription();


        /*
        |--------------------------------------------------------------------------
        | إنشاء Subscription
        |--------------------------------------------------------------------------
        |
        | يتم فقط عند الضغط على الزر إذا الجهاز
        | غير موجود في المتصفح.
        |
        */

        if (
            !subscription &&
            create
        ) {

            subscription =
                await registration
                    .pushManager
                    .subscribe({

                        userVisibleOnly:
                            true,

                        applicationServerKey:
                            urlBase64ToUint8Array(
                                pushConfig.vapidPublicKey
                            ),

                    });
        }


        return subscription;
    }


    /*
    |--------------------------------------------------------------------------
    | Check Device
    |--------------------------------------------------------------------------
    |
    | Controller هو اللي يحدد حالة الجهاز.
    |
    */

    async function checkDevice() {

        try {

            const subscription =
                await getSubscription(false);


            /*
            |--------------------------------------------------------------------------
            | لا يوجد Subscription في Browser
            |--------------------------------------------------------------------------
            */

            if (!subscription) {

                setToggleState(false);

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | إرسال Endpoint للـ Controller
            |--------------------------------------------------------------------------
            */

            const result =
                await sendRequest(
                    pushConfig.statusUrl,
                    {
                        endpoint:
                            subscription.endpoint
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Controller هو صاحب القرار
            |--------------------------------------------------------------------------
            */

            controllerActive =
                result.active === true;


            setToggleState(
                controllerActive
            );

        } catch (error) {

            console.error(
                'Push Status Error:',
                error
            );


            setToggleState(false);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Enable
    |--------------------------------------------------------------------------
    |
    | JavaScript:
    | يحصل على Subscription فقط.
    |
    | Controller:
    | create/update + is_active = true
    |--------------------------------------------------------------------------
    */

    async function enableNotifications() {

        if (!browserSupportsPush()) {

            throw new Error(
                'المتصفح لا يدعم إشعارات Push.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Permission
        |--------------------------------------------------------------------------
        */

        let permission =
            Notification.permission;


        if (
            permission === 'default'
        ) {

            /*
            |--------------------------------------------------------------------------
            | رسالة تأكيد عربية قبل نافذة المتصفح
            |--------------------------------------------------------------------------
            */

            const confirmed =
                window.confirm(
                    'هل تريد تفعيل إشعارات دليل الأطباء؟'
                );


            if (!confirmed) {

                throw new Error(
                    'تم إلغاء تفعيل الإشعارات.'
                );
            }


            permission =
                await Notification.requestPermission();
        }


        /*
        |--------------------------------------------------------------------------
        | Browser Permission Denied
        |--------------------------------------------------------------------------
        |
        | إذا كان Chrome مانع الإشعارات للموقع،
        | لا يمكن لـ JavaScript طلب الإذن مرة أخرى.
        | لذلك نوضح للمستخدم خطوات السماح من إعدادات الموقع.
        |
        */

        if (
            permission === 'denied'
        ) {

             throw new Error(
                'إشعارات المتصفح ممنوعة لهذا الموقع.\n\n' +
                'لإعادة تفعيلها:\n' +
                '1. اضغط على علامة القفل 🔒 أو أيقونة إعدادات الموقع بجانب عنوان الموقع.\n' +
                '2. افتح "إعدادات الموقع".\n' +
                '3. عند "الإشعارات" اختر "السماح".\n' +
                '4. ارجع للصفحة واعمل تحديث للصفحة.\n' +
                '5. اضغط على زر تفعيل الإشعارات مرة أخرى.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Subscription
        |--------------------------------------------------------------------------
        */

        const subscription =
            await getSubscription(true);


        if (!subscription) {

            throw new Error(
                'تعذر إنشاء Push Subscription.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Controller
        |--------------------------------------------------------------------------
        */

        const result =
            await sendRequest(
                pushConfig.subscribeUrl,
                subscription.toJSON()
            );


        /*
        |--------------------------------------------------------------------------
        | Controller Success
        |--------------------------------------------------------------------------
        */

        if (
            result.success !== true ||
            result.active !== true
        ) {

            throw new Error(
                result.message ||
                'لم يتم تفعيل الجهاز.'
            );
        }


        controllerActive = true;

        setToggleState(true);
    }


    /*
    |--------------------------------------------------------------------------
    | Disable
    |--------------------------------------------------------------------------
    |
    | لا نعمل unsubscribe().
    |
    | Controller فقط:
    |
    | is_active = false
    |--------------------------------------------------------------------------
    */

    async function disableNotifications() {

        const subscription =
            await getSubscription(false);


        if (!subscription) {

            controllerActive = false;

            setToggleState(false);

            return;
        }


        const result =
            await sendRequest(
                pushConfig.disableUrl,
                {
                    endpoint:
                        subscription.endpoint
                }
            );


        if (
            result.success !== true ||
            result.active !== false
        ) {

            throw new Error(
                result.message ||
                'لم يتم إيقاف الجهاز.'
            );
        }


        controllerActive = false;

        setToggleState(false);
    }


    /*
    |--------------------------------------------------------------------------
    | Initial UI
    |--------------------------------------------------------------------------
    */

    setToggleState(
        controllerActive === true
    );


    /*
    |--------------------------------------------------------------------------
    | Check Real Device State
    |--------------------------------------------------------------------------
    */

    checkDevice();


    /*
    |--------------------------------------------------------------------------
    | Toggle
    |--------------------------------------------------------------------------
    */

    toggle.addEventListener(
        'click',
        async function () {

            if (
                toggle.dataset.loading ===
                'true'
            ) {
                return;
            }


            const isActive =
                toggle.classList.contains(
                    'is-active'
                );


            toggle.dataset.loading =
                'true';

            toggle.disabled =
                true;


            try {

                /*
                |--------------------------------------------------------------------------
                | OFF -> ON
                |--------------------------------------------------------------------------
                */

                if (!isActive) {

                    if (toggleStatus) {

                        toggleStatus.textContent =
                            'جاري التفعيل...';

                        toggleStatus.style.color =
                            '#64748b';
                    }


                    await enableNotifications();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | ON -> OFF
                |--------------------------------------------------------------------------
                */

                if (toggleStatus) {

                    toggleStatus.textContent =
                        'جاري الإيقاف...';

                    toggleStatus.style.color =
                        '#64748b';
                }


                await disableNotifications();

            } catch (error) {

                console.error(
                    'Push Error:',
                    error
                );


                /*
                |--------------------------------------------------------------------------
                | ارجع للحالة الحقيقية من Controller
                |--------------------------------------------------------------------------
                */

                await checkDevice();


                alert(
                    error.message ||
                    'حدث خطأ أثناء معالجة الإشعارات.'
                );

            } finally {

                toggle.disabled =
                    false;

                toggle.dataset.loading =
                    'false';
            }

        }
    );

});

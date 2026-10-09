
(function () {
    'use strict';

    function init() {

        const config = window.BookingPageConfig || {};
        const live = config.liveMessages;
        const root = document.getElementById('clinic-live-messages');

        // الميزة مش متاحة (مش Clinic System أو مش دكتور/مساعد)
        if (!live || !root) {
            return;
        }

        const csrfToken = config.csrfToken || '';
        const role = live.role;

        const POLL_VISIBLE = 2500;
        const POLL_HIDDEN = 15000;
        const REQUEST_TIMEOUT = 8000;
        const BUTTON_COOLDOWN = 30000;

        /* ------------------------------------------------------------------ */
        /* أنواع الرسائل                                                      */
        /* ------------------------------------------------------------------ */

        const TYPES = {
            doctor_call_patient: {
                mod: 'doctor-call',
                icon: 'bell-ring',
                kicker: 'طلب استدعاء من الطبيب',
                headline: 'الطبيب يريد المريض الآن',
                action: 'تم التنفيذ',
            },
            assistant_patient_missing: {
                mod: 'patient-missing',
                icon: 'triangle-alert',
                kicker: 'تنبيه من المساعد',
                headline: 'المريض غير موجود حاليًا',
                action: 'تم',
            },
        };

        /* ------------------------------------------------------------------ */
        /* State                                                              */
        /* ------------------------------------------------------------------ */

        const cards = new Map();        // id -> element
        const dismissed = new Set();    // ids اتقفلت محليًا (عشان polling متر جعهاش)
        const cooldown = new Map();     // bookingId -> timestamp انتهاء الحالة "تم"
        const pending = new Set();      // bookingIds جاري إرسالها

        let lastId = 0;
        let serverOffset = 0;
        let firstLoad = true;
        let inFlight = false;
        let stopped = false;
        let pollTimer = null;

        /* ------------------------------------------------------------------ */
        /* Utils                                                              */
        /* ------------------------------------------------------------------ */

        function refreshIcons() {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function toast(message, type) {
            if (typeof window.showToast === 'function') {
                window.showToast(message, type || 'error');
            }
        }

        function plural(n, one, two, few, many) {
            if (n === 1) return one;
            if (n === 2) return two;
            if (n >= 3 && n <= 10) return `${n} ${few}`;
            return `${n} ${many}`;
        }

        function relativeTime(ts) {
            const serverNow = Date.now() + serverOffset;
            const diff = Math.max(0, Math.floor((serverNow - ts) / 1000));

            if (diff < 5) return 'الآن';

            if (diff < 60) {
                return 'منذ ' + plural(diff, 'ثانية', 'ثانيتين', 'ثوانٍ', 'ثانية');
            }

            const minutes = Math.floor(diff / 60);

            if (minutes < 60) {
                return 'منذ ' + plural(minutes, 'دقيقة', 'دقيقتين', 'دقائق', 'دقيقة');
            }

            const hours = Math.floor(minutes / 60);

            return 'منذ ' + plural(hours, 'ساعة', 'ساعتين', 'ساعات', 'ساعة');
        }

        function formatClock(ts) {
            const date = new Date(ts);

            let hours = date.getHours();
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const suffix = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12 || 12;

            return `${String(hours).padStart(2, '0')}:${minutes} ${suffix}`;
        }

        async function request(url, method, signalTimeout) {
            const controller = new AbortController();
            const timer = setTimeout(function () {
                controller.abort();
            }, signalTimeout || REQUEST_TIMEOUT);

            try {
                return await fetch(url, {
                    method: method,
                    credentials: 'same-origin',
                    signal: controller.signal,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: method === 'GET' ? undefined : '{}',
                });
            } finally {
                clearTimeout(timer);
            }
        }

        /* ------------------------------------------------------------------ */
        /* Message Center UI                                                  */
        /* ------------------------------------------------------------------ */

        root.innerHTML = `
            <div class="clinic-live-messages__head">
                <span class="clinic-live-messages__head-icon">
                    <i data-lucide="messages-square"></i>
                </span>
                <span class="clinic-live-messages__head-title">رسائل العيادة</span>
                <span class="clinic-live-messages__count" data-live-count>0</span>
            </div>
            <div class="clinic-live-messages__list" data-live-list></div>
        `;

        const listEl = root.querySelector('[data-live-list]');
        const countEl = root.querySelector('[data-live-count]');

        refreshIcons();

        function updateShell() {
            countEl.textContent = String(cards.size);

            if (cards.size > 0) {
                root.hidden = false;
                return;
            }

            // نستنى انيميشن الخروج قبل الإخفاء
            setTimeout(function () {
                if (cards.size === 0) {
                    root.hidden = true;
                }
            }, 280);
        }

        function buildCard(m, animate) {
            const type = TYPES[m.type];

            if (!type) {
                return null;
            }

            const ts = Date.parse(m.created_at) || Date.now();
            const name = String(m.patient_name || 'مريض بدون اسم');
            const initial = name.trim().charAt(0) || '؟';

            const el = document.createElement('article');

            el.className =
                `clinic-live-message clinic-live-message--${type.mod}` +
                (animate ? ' is-new' : '');

            el.dataset.id = m.id;
            el.dataset.ts = ts;
            el.setAttribute('role', 'status');

            el.innerHTML = `
                <div class="clinic-live-message__top">

                    <span class="clinic-live-message__icon">
                        <i data-lucide="${type.icon}"></i>
                    </span>

                    <div class="clinic-live-message__titles">
                        <span class="clinic-live-message__kicker">${escapeHtml(type.kicker)}</span>
                        <strong class="clinic-live-message__headline">${escapeHtml(type.headline)}</strong>
                    </div>

                    <button type="button"
                        class="clinic-live-message__close"
                        data-live-action="delete"
                        aria-label="حذف الرسالة"
                        title="حذف الرسالة">
                        <i data-lucide="x"></i>
                    </button>

                </div>

                <div class="clinic-live-message__patient">

                    <span class="clinic-live-message__avatar">${escapeHtml(initial)}</span>

                    <div class="clinic-live-message__patient-info">
                        <strong class="clinic-live-message__name">${escapeHtml(name)}</strong>
                        <span class="clinic-live-message__text">${escapeHtml(m.message || '')}</span>
                    </div>

                </div>

                <div class="clinic-live-message__footer">

                    <div class="clinic-live-message__meta">
                        <i data-lucide="clock-3"></i>
                        <time class="clinic-live-message__ago" data-ago>${escapeHtml(relativeTime(ts))}</time>
                        <span class="clinic-live-message__dot"></span>
                        <span>${escapeHtml(formatClock(ts))}</span>
                        <span class="clinic-live-message__dot"></span>
                        <span>${escapeHtml(m.sender_label || '')}</span>
                    </div>

                    <button type="button"
                        class="clinic-live-message__done"
                        data-live-action="resolve">
                        <i data-lucide="check"></i>
                        ${escapeHtml(type.action)}
                    </button>

                </div>
            `;

            if (animate) {
                setTimeout(function () {
                    el.classList.remove('is-new');
                }, 5200);
            }

            return el;
        }

        function addCard(m, animate) {
            if (cards.has(m.id) || dismissed.has(m.id)) {
                return;
            }

            const el = buildCard(m, animate);

            if (!el) {
                return;
            }

            cards.set(m.id, el);

            // الأحدث فوق
            listEl.prepend(el);

            updateShell();
            refreshIcons();
        }

        function removeCard(id) {
            const el = cards.get(id);

            if (!el) {
                return;
            }

            cards.delete(id);

            el.classList.add('is-leaving');

            setTimeout(function () {
                el.remove();
            }, 260);

            updateShell();
        }

        function updateAgo() {
            cards.forEach(function (el) {
                const ago = el.querySelector('[data-ago]');

                if (ago) {
                    ago.textContent = relativeTime(Number(el.dataset.ts));
                }
            });
        }

        /* ------------------------------------------------------------------ */
        /* Resolve / Delete                                                   */
        /* ------------------------------------------------------------------ */

        async function runAction(id, action) {
            const el = cards.get(id);

            if (!el || el.dataset.busy === '1') {
                return;
            }

            const template =
                action === 'resolve'
                    ? live.resolveUrlTemplate
                    : live.deleteUrlTemplate;

            el.dataset.busy = '1';
            el.classList.add('is-busy');

            try {
                const response = await request(
                    template.replace('__MESSAGE_ID__', encodeURIComponent(id)),
                    action === 'resolve' ? 'PATCH' : 'DELETE'
                );

                if (!response.ok) {
                    throw new Error(String(response.status));
                }

                dismissed.add(id);
                removeCard(id);

            } catch (error) {
                el.dataset.busy = '0';
                el.classList.remove('is-busy');

                toast('تعذر تنفيذ الإجراء، حاول مرة أخرى.', 'error');
            }
        }

        root.addEventListener('click', function (event) {
            const button = event.target.closest('[data-live-action]');

            if (!button) {
                return;
            }

            const card = button.closest('.clinic-live-message');

            if (!card) {
                return;
            }

            runAction(Number(card.dataset.id), button.dataset.liveAction);
        });

        /* ------------------------------------------------------------------ */
        /* Polling                                                            */
        /* ------------------------------------------------------------------ */

        function applyPollData(data) {
            if (data.now) {
                const serverNow = Date.parse(data.now);

                if (!isNaN(serverNow)) {
                    serverOffset = serverNow - Date.now();
                }
            }

            const activeIds = new Set(
                (Array.isArray(data.active_ids) ? data.active_ids : []).map(Number)
            );

            // اللي اتحل/اتحذف من الطرف التاني
            Array.from(cards.keys()).forEach(function (id) {
                if (!activeIds.has(id)) {
                    removeCard(id);
                }
            });

            dismissed.forEach(function (id) {
                if (!activeIds.has(id)) {
                    dismissed.delete(id);
                }
            });

            const messages = Array.isArray(data.messages) ? data.messages : [];

            messages.forEach(function (m) {
                const id = Number(m.id);

                if (id > lastId) {
                    lastId = id;
                }

                if (!activeIds.has(id)) {
                    return;
                }

                m.id = id;

                addCard(m, !firstLoad);
            });

            firstLoad = false;
        }

        function schedule(delay) {
            clearTimeout(pollTimer);

            if (stopped) {
                return;
            }

            pollTimer = setTimeout(
                poll,
                typeof delay === 'number'
                    ? delay
                    : (document.hidden ? POLL_HIDDEN : POLL_VISIBLE)
            );
        }

        async function poll() {
            if (inFlight || stopped) {
                return;
            }

            inFlight = true;

            try {
                const response = await request(
                    `${live.indexUrl}?after_id=${lastId}`,
                    'GET'
                );

                // مفيش صلاحية (اشتراك خلص / تعطيل مساعد / خروج): نوقف بهدوء
                if (response.status === 401 || response.status === 403 || response.status === 419) {
                    stopped = true;
                    return;
                }

                if (!response.ok) {
                    return;
                }

                applyPollData(await response.json());

            } catch (error) {
                // فشل شبكة: نسيب الرسائل زي ما هي ونحاول تاني
            } finally {
                inFlight = false;
                schedule();
            }
        }

        document.addEventListener('visibilitychange', function () {
            if (!document.hidden && !stopped) {
                clearTimeout(pollTimer);
                poll();
            }
        });

        window.addEventListener('online', function () {
            if (!stopped) {
                clearTimeout(pollTimer);
                poll();
            }
        });

        /* ------------------------------------------------------------------ */
        /* أزرار الطابور (استدعاء / المريض غير موجود)                         */
        /* ------------------------------------------------------------------ */

        const BUTTON_LABELS = {
            doctor: {
                idle: ['megaphone', 'استدعاء'],
                loading: ['loader-circle', 'جارٍ الإرسال...'],
                done: ['check', 'تم الاستدعاء'],
            },
            assistant: {
                idle: ['user-round-x', 'المريض غير موجود'],
                loading: ['loader-circle', 'جارٍ الإرسال...'],
                done: ['check', 'تم الإبلاغ'],
            },
        };

        function paintButton(button, state) {
            const label = BUTTON_LABELS[role][state];

            button.dataset.state = state;
            button.disabled = state !== 'idle';

            button.innerHTML =
                `<i data-lucide="${label[0]}" class="h-4 w-4"></i> ${label[1]}`;

            refreshIcons();
        }

        function bookingIdOf(button) {
            return button.dataset.liveCall || button.dataset.liveMissing || '';
        }

        function applyButtonState(button) {
            const id = bookingIdOf(button);
            const until = cooldown.get(id) || 0;

            if (pending.has(id)) {
                paintButton(button, 'loading');
            } else if (until > Date.now()) {
                paintButton(button, 'done');
            } else {
                paintButton(button, 'idle');
            }
        }

        function syncButtons(id) {
            document
                .querySelectorAll('#queue-list .clinic-live-btn')
                .forEach(function (button) {
                    if (!id || bookingIdOf(button) === String(id)) {
                        applyButtonState(button);
                    }
                });
        }

        function decorateQueue() {
            const list = document.getElementById('queue-list');

            if (!list) {
                return;
            }

            list.querySelectorAll('form[action$="/call"]').forEach(function (form) {
                const match = (form.getAttribute('action') || '')
                    .match(/\/bookings\/([^/]+)\/call$/);

                if (!match) {
                    return;
                }

                const id = decodeURIComponent(match[1]);

                const button = document.createElement('button');

                button.type = 'button';
                button.className = `btn btn-outline btn-sm clinic-live-btn clinic-live-btn--${role}`;

                if (role === 'doctor') {
                    button.dataset.liveCall = id;
                } else {
                    button.dataset.liveMissing = id;
                }

                form.replaceWith(button);

                applyButtonState(button);
            });
        }

        async function sendFromButton(button) {
            const id = bookingIdOf(button);

            if (!id || button.disabled || pending.has(id)) {
                return;
            }

            const template =
                role === 'doctor'
                    ? live.callUrlTemplate
                    : live.missingUrlTemplate;

            pending.add(id);
            syncButtons(id);

            try {
                const response = await request(
                    template.replace('__BOOKING_ID__', encodeURIComponent(id)),
                    'POST'
                );

                let data = {};

                try {
                    data = await response.json();
                } catch (e) {
                    data = {};
                }

                if (!response.ok || data.ok === false) {
                    toast(
                        response.status === 419
                            ? 'انتهت الجلسة، حدّث الصفحة وحاول مرة أخرى.'
                            : (data.message || 'تعذر إرسال الرسالة.'),
                        'error'
                    );

                    return;
                }

                cooldown.set(id, Date.now() + BUTTON_COOLDOWN);

                setTimeout(function () {
                    cooldown.delete(id);
                    syncButtons(id);
                }, BUTTON_COOLDOWN);

                if (data.duplicate) {
                    toast('تم إرسال الرسالة بالفعل , و مازالت ظاهرة عند الطرف التاني.', 'success');
                }

            } catch (error) {
                toast('تعذر الاتصال، حاول مرة أخرى.', 'error');

            } finally {
                pending.delete(id);
                syncButtons(id);
            }
        }

        document.addEventListener('click', function (event) {
            const button = event.target.closest('.clinic-live-btn');

            if (button) {
                sendFromButton(button);
            }
        });

        const queueList = document.getElementById('queue-list');

        if (queueList) {
            decorateQueue();

            new MutationObserver(decorateQueue).observe(queueList, {
                childList: true,
                subtree: true,
            });
        }

        /* ------------------------------------------------------------------ */
        /* Start                                                              */
        /* ------------------------------------------------------------------ */

        setInterval(updateAgo, 5000);

        poll();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

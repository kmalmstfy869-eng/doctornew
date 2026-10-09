document.addEventListener('DOMContentLoaded', function() {

    const config = window.BookingPageConfig || {};

    const csrfToken =
        config.csrfToken || '';

    const isClinicSystem =
        !!config.isClinicSystem;

    let patientMode =
        isClinicSystem
            ? (config.patientMode || 'existing')
            : 'new';

    const queueDataUrl =
        config.queueDataUrl;

    const patientSearchUrl =
        config.patientSearchUrl;

    const callUrlTemplate =
        config.callUrlTemplate;

    const startUrlTemplate =
        config.startUrlTemplate;

    const finishUrlTemplate =
        config.finishUrlTemplate;

    const serviceUrlTemplate =
        config.serviceUrlTemplate;

    const bookingsBaseUrl =
        config.bookingsBaseUrl || '';


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


    function debounce(fn, wait) {

        let timeout;

        return function(...args) {

            clearTimeout(timeout);

            timeout = setTimeout(() => {
                fn.apply(this, args);
            }, wait);

        };

    }


    function buildActionUrl(template, id) {

        if (!template) {
            return '#';
        }

        return template.replace(
            '__BOOKING_ID__',
            encodeURIComponent(id)
        );

    }


    function toDateObject(value) {

        if (!value) {
            return null;
        }

        const raw =
            String(value).trim();

        let date;

        if (/^\d{1,2}:\d{2}/.test(raw)) {

            const parts =
                raw.split(':');

            date = new Date();

            date.setHours(
                Number(parts[0]) || 0,
                Number(parts[1]) || 0,
                0,
                0
            );

        } else {

            date = new Date(
                raw.replace(' ', 'T')
            );

        }

        if (isNaN(date.getTime())) {
            return null;
        }

        return date;

    }


    function formatTime12(value) {

        const date =
            toDateObject(value);

        if (!date) {
            return '';
        }

        let hours =
            date.getHours();

        const minutes =
            String(date.getMinutes()).padStart(2, '0');

        const suffix =
            hours >= 12 ? 'PM' : 'AM';

        hours =
            hours % 12 || 12;

        return `${String(hours).padStart(2, '0')}:${minutes} ${suffix}`;

    }


    function formatTime24(value) {

        const date =
            toDateObject(value);

        if (!date) {
            return '';
        }

        const hours =
            String(date.getHours()).padStart(2, '0');

        const minutes =
            String(date.getMinutes()).padStart(2, '0');

        return `${hours}:${minutes}`;

    }


    window.showToast = function(
        message,
        type = 'success'
    ) {

        const container =
            document.getElementById('toast-container');

        if (!container) {
            return;
        }

        const normalizedType =
            type === 'warning'
                ? 'warn'
                : type === 'error'
                    ? 'danger'
                    : type;

        const icon =
            normalizedType === 'danger'
                ? 'circle-x'
                : normalizedType === 'warn'
                    ? 'triangle-alert'
                    : 'circle-check';

        const toast =
            document.createElement('div');

        toast.className =
            `bq-toast ${normalizedType}`;

        toast.innerHTML = `
            <div class="flex items-start gap-3">

                <i data-lucide="${icon}"
                    class="mt-0.5 h-5 w-5 shrink-0"></i>

                <span>
                    ${escapeHtml(message)}
                </span>

            </div>
        `;

        container.appendChild(toast);

        refreshIcons();

        setTimeout(function() {
            toast.remove();
        }, 3200);

    };


    function openModal(id) {

        const modal =
            document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.add('open');

        document.body.classList.add('overflow-hidden');

        refreshIcons();

    }


    function closeModal(id) {

        const modal =
            document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.remove('open');

        if (!document.querySelector('.modal-overlay.open')) {
            document.body.classList.remove('overflow-hidden');
        }

    }


    function closeAllModals() {

        document.querySelectorAll('.modal-overlay.open')
            .forEach(function(modal) {
                modal.classList.remove('open');
            });

        document.body.classList.remove('overflow-hidden');

    }


    function setPatientMode(mode) {

        if (!isClinicSystem) {
            mode = 'new';
        }

        patientMode = mode;

        const existingFields =
            document.getElementById(
                'existing-patient-fields'
            );

        const newFields =
            document.getElementById(
                'new-patient-fields'
            );

        const existingButton =
            document.getElementById(
                'mode-existing'
            );

        const newButton =
            document.getElementById(
                'mode-new'
            );

        /*
        |--------------------------------------------------------------------------
        | الاشتراكات غير Clinic System
        |--------------------------------------------------------------------------
        */

        if (!isClinicSystem) {

            if (existingFields) {
                existingFields.classList.add('hidden');
            }

            if (newFields) {
                newFields.classList.remove('hidden');
            }

            if (existingButton) {
                existingButton.classList.remove('active');
            }

            if (newButton) {
                newButton.classList.add('active');
            }

            return;

        }


        if (
            !existingFields ||
            !newFields ||
            !existingButton ||
            !newButton
        ) {
            return;
        }


        if (mode === 'existing') {

            existingFields.classList.remove('hidden');

            newFields.classList.add('hidden');

            existingButton.classList.add('active');

            newButton.classList.remove('active');

        } else {

            existingFields.classList.add('hidden');

            newFields.classList.remove('hidden');

            existingButton.classList.remove('active');

            newButton.classList.add('active');

            const resultsContainer =
                document.getElementById(
                    'patient-search-results'
                );

            if (resultsContainer) {

                resultsContainer.classList.add('hidden');

                resultsContainer.innerHTML = '';

            }

        }

        refreshIcons();

    }


    function updatePaymentPreview() {

        const priceInput =
            document.getElementById(
                'booking-price'
            );

        const paidInput =
            document.getElementById(
                'booking-paid'
            );

        const price =
            Math.max(
                0,
                Number(priceInput?.value) || 0
            );

        const paid =
            Math.max(
                0,
                Number(paidInput?.value) || 0
            );

        const remaining =
            Math.max(
                0,
                price - paid
            );

        const totalPreview =
            document.getElementById(
                'booking-total-preview'
            );

        const paidPreview =
            document.getElementById(
                'booking-paid-preview'
            );

        const remainingPreview =
            document.getElementById(
                'booking-remaining-preview'
            );

        if (totalPreview) {

            totalPreview.textContent =
                `${price.toFixed(0)} ج.م`;

        }

        if (paidPreview) {

            paidPreview.textContent =
                `${paid.toFixed(0)} ج.م`;

        }

        if (remainingPreview) {

            remainingPreview.textContent =
                `${remaining.toFixed(0)} ج.م`;

        }

    }


    function updateEditPaymentPreview() {

        const priceInput =
            document.getElementById(
                'edit-payment-price'
            );

        const paidInput =
            document.getElementById(
                'edit-payment-paid'
            );

        const price =
            Math.max(
                0,
                Number(priceInput?.value) || 0
            );

        const paid =
            Math.max(
                0,
                Number(paidInput?.value) || 0
            );

        const remaining =
            Math.max(
                0,
                price - paid
            );

        const totalPreview =
            document.getElementById(
                'edit-payment-total-preview'
            );

        const paidPreview =
            document.getElementById(
                'edit-payment-paid-preview'
            );

        const remainingPreview =
            document.getElementById(
                'edit-payment-remaining-preview'
            );

        if (totalPreview) {

            totalPreview.textContent =
                `${price.toFixed(0)} ج.م`;

        }

        if (paidPreview) {

            paidPreview.textContent =
                `${paid.toFixed(0)} ج.م`;

        }

        if (remainingPreview) {

            remainingPreview.textContent =
                `${remaining.toFixed(0)} ج.م`;

        }

    }


    function renderPatientResults(patients) {

        const container =
            document.getElementById(
                'patient-search-results'
            );

        if (!container) {
            return;
        }

        if (!patients.length) {

            container.innerHTML =
                '<div class="p-3 text-sm text-muted-foreground">لا توجد نتائج</div>';

            container.classList.remove('hidden');

            return;

        }

        container.innerHTML =
            patients
                .map(function(patient) {

                    return `
                        <button type="button"
                            class="flex w-full items-center justify-between gap-3 p-3 text-right hover:bg-muted"
                            data-patient-result
                            data-id="${escapeHtml(patient.id)}"
                            data-name="${escapeHtml(patient.name)}"
                            data-phone="${escapeHtml(patient.phone || '')}">

                            <span class="font-medium text-foreground">
                                ${escapeHtml(patient.name)}
                            </span>

                            <span class="text-xs text-muted-foreground">
                                ${escapeHtml(patient.phone || '')}
                            </span>

                        </button>
                    `;

                })
                .join('');

        container.classList.remove('hidden');

    }


    function selectPatient(id, name, phone) {

        const hiddenInput =
            document.getElementById(
                'patient-select'
            );

        const selectedInfo =
            document.getElementById(
                'patient-selected-info'
            );

        const selectedName =
            document.getElementById(
                'patient-selected-name'
            );

        const selectedPhone =
            document.getElementById(
                'patient-selected-phone'
            );

        const searchInput =
            document.getElementById(
                'patient-search'
            );

        const resultsContainer =
            document.getElementById(
                'patient-search-results'
            );

        if (hiddenInput) {
            hiddenInput.value = id;
        }

        if (selectedName) {
            selectedName.textContent = name;
        }

        if (selectedPhone) {
            selectedPhone.textContent =
                phone || 'بدون رقم هاتف';
        }

        if (selectedInfo) {
            selectedInfo.classList.remove('hidden');
        }

        if (searchInput) {

            searchInput.value = '';

            searchInput.classList.add('hidden');

        }

        if (resultsContainer) {

            resultsContainer.classList.add('hidden');

            resultsContainer.innerHTML = '';

        }

    }


    function clearSelectedPatient() {

        const hiddenInput =
            document.getElementById(
                'patient-select'
            );

        const selectedInfo =
            document.getElementById(
                'patient-selected-info'
            );

        const searchInput =
            document.getElementById(
                'patient-search'
            );

        if (hiddenInput) {
            hiddenInput.value = '';
        }

        if (selectedInfo) {
            selectedInfo.classList.add('hidden');
        }

        if (searchInput) {

            searchInput.classList.remove('hidden');

            searchInput.value = '';

            searchInput.focus();

        }

    }


    /*
    |--------------------------------------------------------------------------
    | البحث عن المرضى (مع تجاهل الردود القديمة)
    |--------------------------------------------------------------------------
    */

    let patientSearchSeq = 0;
    let patientSearchController = null;

    const searchPatients =
        debounce(
            async function(query) {

                const resultsContainer =
                    document.getElementById(
                        'patient-search-results'
                    );

                const trimmed =
                    (query || '').trim();

                const seq =
                    ++patientSearchSeq;

                if (patientSearchController) {
                    patientSearchController.abort();
                }

                if (trimmed.length < 2) {

                    if (resultsContainer) {

                        resultsContainer.classList.add(
                            'hidden'
                        );

                        resultsContainer.innerHTML = '';

                    }

                    return;

                }

                if (!patientSearchUrl) {
                    return;
                }

                patientSearchController =
                    new AbortController();

                try {

                    const response =
                        await fetch(
                            `${patientSearchUrl}?search=${encodeURIComponent(trimmed)}`,
                            {
                                credentials:
                                    'same-origin',

                                signal:
                                    patientSearchController.signal,

                                headers: {
                                    'Accept':
                                        'application/json',

                                    'X-Requested-With':
                                        'XMLHttpRequest',
                                },
                            }
                        );

                    if (seq !== patientSearchSeq) {
                        return;
                    }

                    if (!response.ok) {
                        return;
                    }

                    const data =
                        await response.json();

                    if (seq !== patientSearchSeq) {
                        return;
                    }

                    renderPatientResults(
                        Array.isArray(data.patients)
                            ? data.patients
                            : []
                    );

                } catch (error) {

                    return;

                }

            },
            300
        );


    function buildQueueCard(
        booking,
        position,
        isLast
    ) {

        const sourceLabel =
            booking.booking_type === 'online'
                ? 'أونلاين'
                : 'من العيادة';

        const sourceClass =
            booking.booking_type === 'online'
                ? 'badge-primary'
                : 'badge-purple';

        const appointmentTime =
            formatTime12(
                booking.start_time
            );

        const arrivalTime =
            formatTime12(
                booking.arrived_at
            );

        const metaParts = [];


        if (appointmentTime) {

            metaParts.push(`
                <span>
                    موعد:
                    ${escapeHtml(appointmentTime)}
                </span>
            `);

        }


        if (arrivalTime) {

            metaParts.push(`
                <span>
                    وصول:
                    ${escapeHtml(arrivalTime)}
                </span>
            `);

        }


        const arrivalStatus =
            booking.booking_type === 'online' &&
            booking.arrival_status
                ? `
                    <span class="badge badge-success">
                        ${escapeHtml(
                            booking.arrival_status
                        )}
                    </span>
                `
                : '';


        return `
            <div class="clinic-surface-card mb-3 border border-border p-4${isLast ? ' last:mb-0' : ''}">

                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

                    <div class="flex min-w-0 items-center gap-3">

                        <div class="bq-queue-num">
                            ${escapeHtml(position)}
                        </div>

                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                <h3 class="truncate font-bold text-foreground">
                                    ${escapeHtml(
                                        booking.patient_name
                                    )}
                                </h3>

                                <span class="badge ${sourceClass}">
                                    ${escapeHtml(
                                        sourceLabel
                                    )}
                                </span>

                                ${arrivalStatus}

                            </div>

                            <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1 text-xs text-muted-foreground">
                                ${metaParts.join('')}
                            </div>

                        </div>

                    </div>


                    <div class="bq-queue-actions">

                        <form method="POST"
                            action="${escapeHtml(buildActionUrl(
                                callUrlTemplate,
                                booking.id
                            ))}">

                            <input type="hidden"
                                name="_token"
                                value="${escapeHtml(
                                    csrfToken
                                )}">

                            <button type="submit"
                                class="btn btn-outline btn-sm">

                                <i data-lucide="megaphone"
                                    class="h-4 w-4"></i>

                                استدعاء

                            </button>

                        </form>


                        <form method="POST"
                            action="${escapeHtml(buildActionUrl(
                                startUrlTemplate,
                                booking.id
                            ))}">

                            <input type="hidden"
                                name="_token"
                                value="${escapeHtml(
                                    csrfToken
                                )}">

                            <input type="hidden"
                                name="_method"
                                value="PATCH">

                            <button type="submit"
                                class="btn btn-default btn-sm">

                                <i data-lucide="stethoscope"
                                    class="h-4 w-4"></i>

                                بدء الكشف

                            </button>

                        </form>


                        <button type="button"
                            class="btn btn-destructive"
                            aria-label="حذف الحجز"
                            data-cancel-booking="${escapeHtml(
                                booking.id
                            )}"
                            data-cancel-name="${escapeHtml(
                                booking.patient_name
                            )}">

                            <i data-lucide="trash-2"
                                class="size-4"></i>

                        </button>

                    </div>

                </div>

            </div>
        `;

    }


    function buildCurrentExamCard(
        exam,
        isLast
    ) {

        const startedAt =
            formatTime24(
                exam.started_at
            );

        const metaParts = [];


        if (startedAt) {

            metaParts.push(`
                <span class="flex items-center gap-1.5">

                    <i data-lucide="clock-3"
                        class="h-3.5 w-3.5"></i>

                    بدأ ${escapeHtml(startedAt)}

                </span>
            `);

        }


        return `
            <div class="bq-current-card${isLast ? '' : ' mb-4'}">

                <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">

                    <div class="flex min-w-0 items-center gap-4">

                        <div
                            class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-primary-soft text-primary">

                            <i data-lucide="user-round"
                                class="h-7 w-7"></i>

                        </div>

                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                <h3 class="truncate text-lg font-bold text-foreground">
                                    ${escapeHtml(
                                        exam.patient_name ||
                                        'مريض بدون اسم'
                                    )}
                                </h3>

                                <span class="badge badge-purple">
                                    داخل الكشف
                                </span>

                            </div>

                            <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-sm text-muted-foreground">
                                ${metaParts.join('')}
                            </div>

                        </div>

                    </div>


                    <div class="flex flex-wrap gap-2">

                        <form method="POST"
                            action="${escapeHtml(buildActionUrl(
                                finishUrlTemplate,
                                exam.id
                            ))}">

                            <input type="hidden"
                                name="_token"
                                value="${escapeHtml(
                                    csrfToken
                                )}">

                            <input type="hidden"
                                name="_method"
                                value="PATCH">

                            <button type="submit"
                                class="btn btn-default">

                                <i data-lucide="circle-check-big"
                                    class="h-4 w-4"></i>

                                إنهاء الكشف

                            </button>

                        </form>

                    </div>

                </div>

            </div>
        `;

    }


    function renderQueue(queuePatients) {

        const list =
            document.getElementById(
                'queue-list'
            );

        const empty =
            document.getElementById(
                'queue-empty'
            );

        if (!list) {
            return;
        }

        list.innerHTML =
            queuePatients
                .map(function(booking, index) {

                    return buildQueueCard(
                        booking,
                        index + 1,
                        index ===
                            queuePatients.length - 1
                    );

                })
                .join('');


        if (empty) {

            empty.classList.toggle(
                'hidden',
                queuePatients.length > 0
            );

        }

    }


    function renderCurrentExam(currentExam) {

        const list =
            document.getElementById(
                'current-exam-list'
            );

        const empty =
            document.getElementById(
                'current-exam-empty'
            );

        if (!list) {
            return;
        }

        list.innerHTML =
            currentExam
                .map(function(exam, index) {

                    return buildCurrentExamCard(
                        exam,
                        index ===
                            currentExam.length - 1
                    );

                })
                .join('');


        if (empty) {

            empty.classList.toggle(
                'hidden',
                currentExam.length > 0
            );

        }

    }


    function setStatValue(id, value) {

        const element =
            document.getElementById(id);

        if (element) {
            element.textContent = value;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | الطابور موجود في الصفحة؟
    | (الملف مستخدم في صفحات تانية زي سجل الحجوزات، فمفيش داعي لطلبات بلا فايدة)
    |--------------------------------------------------------------------------
    */

    function hasQueueUi() {

        return !!(
            document.getElementById('queue-list') ||
            document.getElementById('current-exam-list')
        );

    }


    let isRefreshingQueue = false;

    async function refreshQueueData() {

        if (
            !queueDataUrl ||
            !hasQueueUi() ||
            isRefreshingQueue
        ) {
            return;
        }

        isRefreshingQueue = true;

        try {

            const response =
                await fetch(
                    queueDataUrl,
                    {
                        credentials:
                            'same-origin',

                        headers: {
                            'Accept':
                                'application/json',

                            'X-Requested-With':
                                'XMLHttpRequest',
                        },
                    }
                );

            if (!response.ok) {
                return;
            }

            const data =
                await response.json();

            const queuePatients =
                Array.isArray(
                    data.queuePatients
                )
                    ? data.queuePatients
                    : [];

            const currentExam =
                Array.isArray(
                    data.currentExam
                )
                    ? data.currentExam
                    : [];


            renderQueue(queuePatients);

            renderCurrentExam(currentExam);


            const queueCount =
                Number(
                    data.queueCount ?? 0
                );


            setStatValue(
                'stat-queue-count',
                queueCount
            );

            setStatValue(
                'stat-exam-count',
                Number(
                    data.examCount ?? 0
                )
            );

            setStatValue(
                'stat-done-count',
                Number(
                    data.doneCount ?? 0
                )
            );

            setStatValue(
                'stat-total-count',
                Number(
                    data.total ?? 0
                )
            );


            const queueBadge =
                document.getElementById(
                    'queue-count-badge'
                );

            if (queueBadge) {

                queueBadge.textContent =
                    `${queueCount} ${
                        queueCount === 1
                            ? 'مريض'
                            : 'مرضى'
                    }`;

            }

            refreshIcons();

        } catch (error) {

            return;

        } finally {

            isRefreshingQueue = false;

        }

    }


    function openEditService(button) {

        const id =
            button.dataset.id;

        const service =
            button.dataset.service || '';

        const patientName =
            button.dataset.name || '';

        const form =
            document.getElementById(
                'edit-service-form'
            );

        const select =
            document.getElementById(
                'edit-service-select'
            );

        const patientLabel =
            document.getElementById(
                'edit-service-patient'
            );

        if (!form || !select) {
            return;
        }

        if (!serviceUrlTemplate) {
            return;
        }

        form.action =
            buildActionUrl(
                serviceUrlTemplate,
                id
            );

        select.value =
            service;

        if (patientLabel) {

            patientLabel.textContent =
                patientName
                    ? `تحديد الخدمة للمريض ${patientName}`
                    : `تحديد الخدمة للحجز رقم ${id}`;

        }

        openModal(
            'edit-service-modal'
        );

    }


    function openEditPayment(button) {

        const id =
            button.dataset.id;

        const name =
            button.dataset.name || '';

        const price =
            Number(
                button.dataset.price || 0
            );

        const paid =
            Number(
                button.dataset.paid || 0
            );

        const form =
            document.getElementById(
                'edit-payment-form'
            );

        if (!form || !id) {
            return;
        }

        form.action =
            `${bookingsBaseUrl}/${encodeURIComponent(id)}/payment`;

        const patientLabel =
            document.getElementById(
                'edit-payment-patient'
            );

        const priceInput =
            document.getElementById(
                'edit-payment-price'
            );

        const paidInput =
            document.getElementById(
                'edit-payment-paid'
            );

        if (patientLabel) {

            patientLabel.textContent =
                `تعديل الدفع للمريض ${name}`;

        }

        if (priceInput) {
            priceInput.value = price;
        }

        if (paidInput) {
            paidInput.value = paid;
        }

        updateEditPaymentPreview();

        openModal(
            'edit-payment-modal'
        );

    }


    function openCancelModal(button) {

        const id =
            button.dataset.cancelBooking;

        const name =
            button.dataset.cancelName || '';

        const form =
            document.getElementById(
                'cancel-booking-form'
            );

        if (!form || !id) {
            return;
        }

        form.action =
            `${bookingsBaseUrl}/${encodeURIComponent(id)}/cancel`;

        const text =
            document.getElementById(
                'cancel-booking-text'
            );

        if (text) {

            text.textContent =
                `سيتم إلغاء حجز ${name} .`;

        }

        openModal(
            'cancel-booking-modal'
        );

    }


    document.querySelectorAll(
        '[data-modal-open]'
    ).forEach(function(button) {

        button.addEventListener(
            'click',
            function() {

                const modalId =
                    this.getAttribute(
                        'data-modal-open'
                    );

                openModal(modalId);

            }
        );

    });


    document.addEventListener(
        'click',
        function(event) {

            const closeButton =
                event.target.closest(
                    '[data-modal-close]'
                );

            if (closeButton) {

                const modal =
                    closeButton.closest(
                        '.modal-overlay'
                    );

                if (modal) {
                    closeModal(modal.id);
                }

                return;
            }


            const dropdownTrigger =
                event.target.closest(
                    '[data-dropdown-trigger]'
                );

            if (dropdownTrigger) {

                const dropdown =
                    dropdownTrigger.closest(
                        '.dropdown'
                    );

                document.querySelectorAll(
                    '.dropdown.open'
                ).forEach(function(item) {

                    if (item !== dropdown) {
                        item.classList.remove(
                            'open'
                        );
                    }

                });

                if (dropdown) {
                    dropdown.classList.toggle(
                        'open'
                    );
                }

                return;
            }


            if (!event.target.closest('.dropdown')) {

                document.querySelectorAll(
                    '.dropdown.open'
                ).forEach(function(dropdown) {

                    dropdown.classList.remove(
                        'open'
                    );

                });

            }


            const editServiceButton =
                event.target.closest(
                    '[data-edit-service]'
                );

            if (editServiceButton) {

                document.querySelectorAll(
                    '.dropdown.open'
                ).forEach(function(dropdown) {

                    dropdown.classList.remove(
                        'open'
                    );

                });

                openEditService(
                    editServiceButton
                );

                return;
            }


            const editPaymentButton =
                event.target.closest(
                    '[data-edit-payment]'
                );

            if (editPaymentButton) {

                document.querySelectorAll(
                    '.dropdown.open'
                ).forEach(function(dropdown) {

                    dropdown.classList.remove(
                        'open'
                    );

                });

                openEditPayment(
                    editPaymentButton
                );

                return;
            }


            const cancelButton =
                event.target.closest(
                    '[data-cancel-booking]'
                );

            if (cancelButton) {

                document.querySelectorAll(
                    '.dropdown.open'
                ).forEach(function(dropdown) {

                    dropdown.classList.remove(
                        'open'
                    );

                });

                openCancelModal(
                    cancelButton
                );

                return;
            }


            const patientResultButton =
                event.target.closest(
                    '[data-patient-result]'
                );

            if (patientResultButton) {

                selectPatient(
                    patientResultButton.dataset.id,
                    patientResultButton.dataset.name,
                    patientResultButton.dataset.phone
                );

                return;

            }


            if (
                !event.target.closest(
                    '#patient-search-results'
                ) &&
                !event.target.closest(
                    '#patient-search'
                )
            ) {

                const resultsContainer =
                    document.getElementById(
                        'patient-search-results'
                    );

                if (resultsContainer) {

                    resultsContainer.classList.add(
                        'hidden'
                    );

                }

            }

        }
    );


    document.querySelectorAll(
        '.modal-overlay'
    ).forEach(function(modal) {

        modal.addEventListener(
            'click',
            function(event) {

                if (event.target === this) {
                    closeModal(this.id);
                }

            }
        );

    });


    document.addEventListener(
        'keydown',
        function(event) {

            if (event.key === 'Escape') {

                closeAllModals();

                document.querySelectorAll(
                    '.dropdown.open'
                ).forEach(function(dropdown) {

                    dropdown.classList.remove(
                        'open'
                    );

                });

            }

        }
    );


    document.getElementById(
        'mode-existing'
    )?.addEventListener(
        'click',
        function() {

            setPatientMode(
                'existing'
            );

        }
    );


    document.getElementById(
        'mode-new'
    )?.addEventListener(
        'click',
        function() {

            setPatientMode(
                'new'
            );

        }
    );


    document.getElementById(
        'patient-search'
    )?.addEventListener(
        'input',
        function() {

            searchPatients(
                this.value
            );

        }
    );


    document.getElementById(
        'patient-selected-clear'
    )?.addEventListener(
        'click',
        clearSelectedPatient
    );


    document.getElementById(
        'booking-price'
    )?.addEventListener(
        'input',
        updatePaymentPreview
    );


    document.getElementById(
        'booking-paid'
    )?.addEventListener(
        'input',
        updatePaymentPreview
    );


    document.getElementById(
        'edit-payment-price'
    )?.addEventListener(
        'input',
        updateEditPaymentPreview
    );


    document.getElementById(
        'edit-payment-paid'
    )?.addEventListener(
        'input',
        updateEditPaymentPreview
    );


    document.getElementById(
        'new-booking-form'
    )?.addEventListener(
        'submit',
        function() {

            const existingPatient =
                document.getElementById(
                    'patient-select'
                );

            const newPatientName =
                document.getElementById(
                    'new-patient-name'
                );

            const newPatientPhone =
                document.getElementById(
                    'new-patient-phone'
                );


            /*
            |--------------------------------------------------------------------------
            | الاشتراك غير Clinic System
            |--------------------------------------------------------------------------
            | لازم يبعت بيانات المريض الجديد دائمًا.
            */

            if (!isClinicSystem) {

                if (existingPatient) {
                    existingPatient.disabled = true;
                }

                if (newPatientName) {
                    newPatientName.disabled = false;
                }

                if (newPatientPhone) {
                    newPatientPhone.disabled = false;
                }

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Clinic System
            |--------------------------------------------------------------------------
            */

            if (patientMode === 'existing') {

                if (newPatientName) {
                    newPatientName.disabled = true;
                }

                if (newPatientPhone) {
                    newPatientPhone.disabled = true;
                }

                if (existingPatient) {
                    existingPatient.disabled = false;
                }

            } else {

                if (existingPatient) {
                    existingPatient.disabled = true;
                }

                if (newPatientName) {
                    newPatientName.disabled = false;
                }

                if (newPatientPhone) {
                    newPatientPhone.disabled = false;
                }

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | منع الإرسال المزدوج (في نطاق عناصر هذا الملف فقط)
    |--------------------------------------------------------------------------
    */

    const GUARDED_FORMS_SCOPE =
        '#queue-list, #current-exam-list, .modal-overlay, #history-results, #bookings-tbody, #bookings-mobile-list';

    document.addEventListener(
        'submit',
        function(event) {

            const form =
                event.target;

            if (!(form instanceof HTMLFormElement)) {
                return;
            }

            if (event.defaultPrevented) {
                return;
            }

            if (
                (form.getAttribute('method') || '')
                    .toLowerCase() !== 'post'
            ) {
                return;
            }

            if (!form.closest(GUARDED_FORMS_SCOPE)) {
                return;
            }

            if (form.dataset.submitting === '1') {

                event.preventDefault();

                return;

            }

            form.dataset.submitting = '1';

            form.querySelectorAll(
                'button[type="submit"]'
            ).forEach(function(button) {

                button.disabled = true;

            });

        }
    );


    window.addEventListener(
        'pageshow',
        function(event) {

            if (!event.persisted) {
                return;
            }

            document.querySelectorAll(
                'form[data-submitting="1"]'
            ).forEach(function(form) {

                delete form.dataset.submitting;

                form.querySelectorAll(
                    'button[type="submit"]'
                ).forEach(function(button) {

                    button.disabled = false;

                });

            });

        }
    );


    document.getElementById(
        'booking-history-btn'
    )?.addEventListener(
        'click',
        function() {

            showToast(
                'سجل الحجوزات سيتم ربطه بصفحة السجل لاحقًا',
                'warning'
            );

        }
    );


    setPatientMode(patientMode);

    updatePaymentPreview();

    updateEditPaymentPreview();

    refreshIcons();


    if (config.hasNewBookingErrors) {

        openModal(
            'new-booking-modal'
        );

    }


    if (config.hasPaymentErrors) {

        openModal(
            'edit-payment-modal'
        );

    }


    if (config.hasServiceErrors) {

        openModal(
            'edit-service-modal'
        );

    }


    let queueTimer = null;


    function startQueuePolling() {

        if (
            queueTimer ||
            !queueDataUrl ||
            !hasQueueUi()
        ) {
            return;
        }

        queueTimer =
            setInterval(
                refreshQueueData,
                60000
            );

    }


    function stopQueuePolling() {

        clearInterval(
            queueTimer
        );

        queueTimer = null;

    }


    document.addEventListener(
        'visibilitychange',
        function() {

            if (document.hidden) {

                stopQueuePolling();

            } else {

                refreshQueueData();

                startQueuePolling();

            }

        }
    );


    if (!document.hidden) {
        startQueuePolling();
    }

});

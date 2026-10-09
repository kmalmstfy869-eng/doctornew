(function () {

    const config = window.AssistantsPageConfig || {};

    /*
    |--------------------------------------------------------------------------
    | المودالات (open + active عشان يشتغلوا مع أي نسخة CSS)
    |--------------------------------------------------------------------------
    */

    function openModal(id) {
        const el = document.getElementById(id);

        if (!el) {
            return;
        }

        el.classList.add('open', 'active');

        document.body.classList.add('overflow-hidden');

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    function closeOverlay(overlay) {
        if (!overlay) {
            return;
        }

        overlay.classList.remove('open', 'active');

        if (!document.querySelector('.modal-overlay.open, .modal-overlay.active')) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | إظهار / إخفاء كلمة المرور
    |--------------------------------------------------------------------------
    */

    function togglePassword(button) {
        const input = document.getElementById(button.dataset.passwordToggle);

        if (!input) {
            return;
        }

        const show = input.type === 'password';

        input.type = show ? 'text' : 'password';

        button.setAttribute(
            'aria-label',
            show ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور'
        );

        button.innerHTML =
            `<i data-lucide="${show ? 'eye-off' : 'eye'}" class="h-4 w-4"></i>`;

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | إعادة فتح مودال الإضافة بعد Validation Error
    |--------------------------------------------------------------------------
    */

    if (config.reopenAdd) {
        openModal('add-assistant-modal');
    }

    /*
    |--------------------------------------------------------------------------
    | فورم التعديل — داخل الصفحة
    |--------------------------------------------------------------------------
    */

    const editPanel = document.getElementById('assistant-edit-panel');
    const editForm = document.getElementById('assistant-edit-form');
    const editSubtitle = document.getElementById('assistant-edit-subtitle');
    const editIdInput = document.getElementById('assistant-edit-id');
    const editNameInput = document.getElementById('assistant-edit-name');
    const editEmailInput = document.getElementById('assistant-edit-email');
    const editPhoneInput = document.getElementById('assistant-edit-phone');
    const editStatusSelect = document.getElementById('assistant-edit-status');

    function openEditPanel(button) {

        if (!editPanel || !editForm) {
            return;
        }

        const id = button.dataset.id;
        const name = button.dataset.name || '';
        const email = button.dataset.email || '';
        const phone = button.dataset.phone || '';
        const status = button.dataset.status || 'active';

        editForm.action = (config.updateUrlTemplate || '').replace(
            '__ASSISTANT_ID__',
            encodeURIComponent(id)
        );

        if (editSubtitle) {
            editSubtitle.textContent = name;
        }

        if (editIdInput) {
            editIdInput.value = id;
        }

        if (editNameInput) {
            editNameInput.value = name;
        }

        if (editEmailInput) {
            editEmailInput.value = email;
        }

        if (editPhoneInput) {
            editPhoneInput.value = phone;
        }

        if (editStatusSelect) {
            editStatusSelect.value = status;
        }

        editPanel.classList.remove('hidden');

        editPanel.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    function closeEditPanel() {

        if (!editPanel) {
            return;
        }

        editPanel.classList.add('hidden');
    }

    /*
    |--------------------------------------------------------------------------
    | إعادة فتح فورم التعديل بعد Validation Error
    |--------------------------------------------------------------------------
    */

    if (config.reopenEdit && editPanel) {

        editPanel.classList.remove('hidden');

        editPanel.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

    }

    /*
    |--------------------------------------------------------------------------
    | تبديل ظهور حقول كلمة المرور
    |--------------------------------------------------------------------------
    */

    const togglePasswordBtn = document.getElementById('assistant-toggle-password');
    const passwordFields = document.getElementById('assistant-password-fields');
    const toggleIcon = document.getElementById('assistant-toggle-password-icon');

    if (togglePasswordBtn && passwordFields) {

        togglePasswordBtn.addEventListener('click', function () {

            passwordFields.classList.toggle('hidden');

            if (toggleIcon) {
                toggleIcon.classList.toggle('is-open');
            }

        });

    }

    /*
    |--------------------------------------------------------------------------
    | فورم الحذف
    |--------------------------------------------------------------------------
    */

    const deleteForm = document.getElementById('delete-assistant-form');
    const deleteNameEl = document.getElementById('delete-assistant-name');

    /*
    |--------------------------------------------------------------------------
    | كل الضغطات — Event Delegation
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (event) {

        // زر العين
        const eyeButton = event.target.closest('[data-password-toggle]');

        if (eyeButton) {
            event.preventDefault();
            togglePassword(eyeButton);
            return;
        }

        // فتح مودال
        const openButton = event.target.closest('[data-modal-open]');

        if (openButton) {
            openModal(openButton.dataset.modalOpen);
            return;
        }

        // إغلاق مودال (زر X / إلغاء)
        const closeButton = event.target.closest('[data-modal-close]');

        if (closeButton) {
            closeOverlay(closeButton.closest('.modal-overlay'));
            return;
        }

        // الضغط على الخلفية خارج المودال
        if (event.target.classList && event.target.classList.contains('modal-overlay')) {
            closeOverlay(event.target);
            return;
        }

        // تعديل مساعد
        const editButton = event.target.closest('[data-edit-assistant]');

        if (editButton) {
            openEditPanel(editButton);
            return;
        }

        // إغلاق فورم التعديل
        if (event.target.closest('#assistant-edit-close, #assistant-edit-cancel')) {
            closeEditPanel();
            return;
        }

        // حذف مساعد
        const deleteButton = event.target.closest('[data-delete-assistant]');

        if (!deleteButton) {
            return;
        }

        event.preventDefault();

        const id = deleteButton.dataset.id;
        const name = deleteButton.dataset.name || 'هذا المساعد';

        if (!id) {
            return;
        }

        if (deleteNameEl) {
            deleteNameEl.textContent = name;
        }

        if (deleteForm) {
            deleteForm.action = (config.destroyUrlTemplate || '').replace(
                '__ASSISTANT_ID__',
                encodeURIComponent(id)
            );
        }

        openModal('delete-assistant-modal');

    });

    /*
    |--------------------------------------------------------------------------
    | Escape يقفل أي مودال مفتوح
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        document
            .querySelectorAll('.modal-overlay.open, .modal-overlay.active')
            .forEach(closeOverlay);

    });

})();

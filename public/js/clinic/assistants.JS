(function () {

    const config = window.AssistantsPageConfig || {};

    /*
    |--------------------------------------------------------------------------
    | المودالات
    |--------------------------------------------------------------------------
    */

    function openModal(id) {
        const el = document.getElementById(id);

        if (el) {
            el.classList.add('active');
        }
    }

    function closeModal(trigger) {
        const overlay = trigger.closest('.modal-overlay');

        if (overlay) {
            overlay.classList.remove('active');
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
    | فتح المودالات
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('[data-modal-open]').forEach(function (btn) {

        btn.addEventListener('click', function () {
            openModal(btn.dataset.modalOpen);
        });

    });

    /*
    |--------------------------------------------------------------------------
    | إغلاق المودالات
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('[data-modal-close]').forEach(function (btn) {

        btn.addEventListener('click', function () {
            closeModal(btn);
        });

    });

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

    document.querySelectorAll('[data-edit-assistant]').forEach(function (btn) {

        btn.addEventListener('click', function () {
            openEditPanel(btn);
        });

    });

    const editCloseBtn = document.getElementById('assistant-edit-close');
    const editCancelBtn = document.getElementById('assistant-edit-cancel');

    if (editCloseBtn) {
        editCloseBtn.addEventListener('click', closeEditPanel);
    }

    if (editCancelBtn) {
        editCancelBtn.addEventListener('click', closeEditPanel);
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

    document.querySelectorAll('[data-delete-assistant]').forEach(function (btn) {

        btn.addEventListener('click', function () {

            const id = btn.dataset.id;
            const name = btn.dataset.name || 'هذا المساعد';

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

    });

})();

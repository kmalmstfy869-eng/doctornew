document.addEventListener('DOMContentLoaded', function () {
    const modalId = window.PatientsPageConfig?.openModal;

    if (!modalId) {
        return;
    }

    document.getElementById(modalId)?.classList.add('open');
});
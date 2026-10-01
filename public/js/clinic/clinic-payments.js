/*
|--------------------------------------------------------------------------
| clinic-payments.js
| منطق مودال "عرض الملاحظة" في صفحة المدفوعات والإيرادات فقط.
| مودال تعديل الدفع بيستخدم booking-index.js (نفس اللي في سجل الحجوزات).
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    const noteModal = document.querySelector('[data-payment-note-modal]');
    const noteContent = document.querySelector('[data-payment-note-content]');
    const noteMeta = document.querySelector('[data-payment-note-meta]');
    const noteClose = document.querySelector('[data-payment-note-close]');
    const noteTitle = document.getElementById('payment-note-modal-title');

    if (!noteModal || !noteContent) {
        return;
    }

    function closeNoteModal() {
        noteModal.classList.remove('open');
        noteModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }

    function openNoteModal(button) {
        const note = button.dataset.note || '';
        const title = button.dataset.title || 'ملاحظة الحركة';

        if (noteTitle) {
            noteTitle.textContent = title;
        }

        // textContent فقط: الملاحظة بتتعرض كنص، بدون تنفيذ أي HTML
        noteContent.textContent = note.trim();

        if (noteMeta) {
            noteMeta.textContent = 'ملاحظة مسجلة ضمن هذه الحركة المالية.';
        }

        noteModal.classList.add('open');
        noteModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');

        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    document.addEventListener('click', function (event) {
        const openBtn = event.target.closest('[data-payment-note]');

        if (openBtn) {
            event.preventDefault();
            openNoteModal(openBtn);
            return;
        }

        if (event.target === noteModal) {
            closeNoteModal();
        }
    });

    noteClose?.addEventListener('click', closeNoteModal);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && noteModal.classList.contains('open')) {
            closeNoteModal();
        }
    });
});

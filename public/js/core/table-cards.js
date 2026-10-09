(function () {
    function apply() {
        document.querySelectorAll('.dashboard-content table').forEach((table) => {
            if (table.classList.contains('ap-table')) return; // بيتعامل لوحده
            const heads = [...table.querySelectorAll('thead th')].map((th) => th.textContent.trim());
            if (!heads.length) return;

            table.classList.add('table-cards');

            table.querySelectorAll('tbody tr').forEach((tr) => {
                let col = 0;
                [...tr.children].forEach((td) => {
                    const span = td.colSpan || 1;
                    if (!td.hasAttribute('data-label')) {
                        td.setAttribute('data-label', span > 1 ? '' : (heads[col] || ''));
                    }
                    col += span;
                });
            });
        });
    }

    document.addEventListener('DOMContentLoaded', apply);
    document.addEventListener('live-search:updated', apply);
})();

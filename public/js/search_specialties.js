document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('specialties-searchForm');
    const input = document.getElementById('specialties-searchInput');
    const results = document.getElementById('specialtiesResults');
    const count = document.getElementById('resultNumber');

    if (!input || !results) return;

    const baseUrl = results.dataset.url;
    let timer, controller;

    async function load(page = null) {
        const p = new URLSearchParams();
        if (input.value.trim()) p.set('q', input.value.trim());
        if (page) p.set('page', page);
        const qs = p.toString();
        const url = baseUrl + (qs ? '?' + qs : '');

        controller?.abort();
        controller = new AbortController();
        results.style.opacity = '.5';

        try {
            const res = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                cache: 'no-store',
                signal: controller.signal,
            });
            const data = await res.json();
            results.innerHTML = data.html;
            count.textContent = data.count;
            history.replaceState(null, '', url);
        } catch (e) {
            if (e.name !== 'AbortError') console.error(e);
        } finally {
            results.style.opacity = '1';
        }
    }

    input.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(() => load(), 300);
    });

    form.addEventListener('submit', e => {
        e.preventDefault();
        load();
    });

    results.addEventListener('click', e => {
        const a = e.target.closest('.pagination a, a[href*="page="]');
        if (!a) return;
        e.preventDefault();
        load(new URL(a.href).searchParams.get('page'));
        window.scrollTo({ top: results.offsetTop - 120, behavior: 'smooth' });
    });
});

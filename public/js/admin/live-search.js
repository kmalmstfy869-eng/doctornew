document.addEventListener('DOMContentLoaded', function () {
    const input = document.querySelector('[data-live-search]');
    const box = document.getElementById('live-results');
    if (!input || !box) return;

    let timer = null;
    let controller = null;

    function buildUrl(page) {
        const u = new URL(window.location.pathname, window.location.origin);
        const q = input.value.trim();
        if (q) u.searchParams.set('search', q);
        if (page) u.searchParams.set('page', page);
        return u.toString();
    }

    async function load(url) {
        if (controller) controller.abort();
        controller = new AbortController();
        box.style.opacity = '.5';
        box.style.pointerEvents = 'none';

        try {
            const res = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
                credentials: 'same-origin',
                signal: controller.signal,
            });
            if (!res.ok) throw new Error('bad status');

            const doc = new DOMParser().parseFromString(await res.text(), 'text/html');
            const fresh = doc.getElementById('live-results');
            if (!fresh) throw new Error('no results block');

            box.innerHTML = fresh.innerHTML;
            history.replaceState(null, '', url);
            document.dispatchEvent(new CustomEvent('live-search:updated'));
        } catch (err) {
            if (err.name === 'AbortError') return;
            window.location.href = url;
            return;
        } finally {
            box.style.opacity = '';
            box.style.pointerEvents = '';
        }
    }

    input.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(() => load(buildUrl()), 350);
    });

    // الترقيم من غير ريفرش
    box.addEventListener('click', (e) => {
        const a = e.target.closest('.doctor-pending-pagination a[href]');
        if (!a) return;
        const url = new URL(a.href, window.location.origin);
        if (url.origin !== window.location.origin) return;
        e.preventDefault();
        load(buildUrl(url.searchParams.get('page')));
    });
});

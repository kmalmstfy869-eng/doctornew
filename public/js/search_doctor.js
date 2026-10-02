document.addEventListener('DOMContentLoaded', () => {
    const search = document.getElementById('doctorSearch');
    const specialty = document.getElementById('specialtyFilter');
    const city = document.getElementById('cityFilter');
    const sort = document.getElementById('sortDoctors');
    const results = document.getElementById('doctorsResults');
    const count = document.getElementById('resultCount');

    if (!search || !results) return;

    const baseUrl = results.dataset.url;
    let timer, controller;

    function params(page) {
        const p = new URLSearchParams();
        if (search.value.trim()) p.set('q', search.value.trim());
        if (specialty.value && specialty.value !== 'all') p.set('specialty', specialty.value);
        if (city.value && city.value !== 'all') p.set('area', city.value);
        if (sort.value && sort.value !== 'default') p.set('sort', sort.value);
        if (page) p.set('page', page);
        return p;
    }

    async function load(page = null) {
        const qs = params(page).toString();
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

    search.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(() => load(), 300);
    });

    [specialty, city, sort].forEach(el => el.addEventListener('change', () => load()));

    document.getElementById('searchButton').addEventListener('click', () => load());

    document.getElementById('clearFilters').addEventListener('click', () => {
        search.value = '';
        specialty.value = 'all';
        city.value = 'all';
        sort.value = 'default';
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

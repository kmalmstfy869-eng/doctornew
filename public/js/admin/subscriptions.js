(() => {
    'use strict';

    /* ---------- helpers ---------- */
    const parse = (v, fb) => { try { return v ? JSON.parse(v) : fb; } catch (e) { return fb; } };
    const money = (n) => Number(n || 0).toLocaleString('en-US', { maximumFractionDigits: 2 });
    const round2 = (n) => Math.round((Number(n) || 0) * 100) / 100;
    const addDays = (d, n) => {
        if (!d) return '';
        const t = new Date(d + 'T00:00:00Z');
        if (isNaN(t)) return '';
        t.setUTCDate(t.getUTCDate() + Number(n || 0));
        return t.toISOString().slice(0, 10);
    };
    const findPlan = (plans, id) => plans.find(p => String(p.id) === String(id)) || null;
    const durLabel = (days) => {
        days = Number(days || 0);
        if (days <= 0) return '';
        if (days >= 360 && days <= 370) return 'سنة';
        const m = Math.round(days / 30);
        if (m >= 1 && Math.abs(days - m * 30) <= 2) {
            if (m === 1) return 'شهر';
            if (m === 2) return 'شهرين';
            return m <= 10 ? m + ' شهور' : m + ' شهر';
        }
        return days + ' يوم';
    };

    /* ---------- إضافة اشتراك ---------- */
    window.apSubAdd = () => ({
        show: false, busy: false,
        plans: [], planId: '', start: '', amount: '',
        doctor: null, q: '', results: [], searched: false, loading: false,
        ctrl: null, searchUrl: '',

        init() {
            const d = this.$el.dataset;
            this.plans = parse(d.plans, []);
            this.searchUrl = d.searchUrl || '';
            this.start = d.today || '';
            if (d.hasErrors === '1') {
                this.planId = d.oldPlan || '';
                this.start = d.oldStart || this.start;
                this.amount = d.oldAmount || '';
                if (d.oldDoctorId) this.doctor = { id: d.oldDoctorId, name: d.oldDoctorName || '' };
                this.show = true;
                if (!this.doctor) this.search();
            }
        },

        money,
        dur: durLabel,
        get plan() { return findPlan(this.plans, this.planId); },
        get discount() { return this.plan ? Math.max(this.plan.price - Number(this.amount || 0), 0) : 0; },
        get end() { return this.plan ? addDays(this.start, this.plan.duration) : ''; },

        open() { this.busy = false; this.show = true; if (!this.doctor) this.search(); },
        onPlan() { this.$nextTick(() => { this.amount = this.plan ? this.plan.price : ''; }); },
        pick(d) { this.doctor = d; this.results = []; this.q = ''; this.searched = false; },

        async search() {
            if (!this.searchUrl) return;
            if (this.ctrl) this.ctrl.abort();
            this.ctrl = new AbortController();
            this.loading = true;
            try {
                const res = await fetch(this.searchUrl + '?q=' + encodeURIComponent(this.q.trim()), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    credentials: 'same-origin', signal: this.ctrl.signal,
                });
                if (!res.ok) throw new Error('bad status');
                const list = await res.json();
                this.results = Array.isArray(list) ? list : [];
                this.searched = true;
                this.loading = false;
            } catch (e) {
                if (e.name === 'AbortError') return;
                this.results = []; this.searched = true; this.loading = false;
            }
        },
    });

    /* ---------- ترقية الباقة (العرض فقط، والحساب النهائي والتحقق على السيرفر) ---------- */
    window.apSubChange = () => ({
        show: false, busy: false,
        plans: [], planId: '', sub: null, today: '',

        init() {
            const d = this.$el.dataset;
            this.plans = parse(d.plans, []);
            this.today = d.today || '';
            if (d.hasErrors === '1') {
                const s = parse(d.reopen, null);
                if (s) this.open(s, { plan_id: d.oldPlan });
            }
        },

        money,
        dur: durLabel,
        /* الترقية حسب مستوى الباقة (tier) وليس السعر */
        isCurrent(p) {
            return !!this.sub && String(p.id) === String(this.sub.plan_id);
        },
        isUp(p) {
            return !!this.sub && !this.isCurrent(p)
                && Number(this.sub.plan_tier) >= 0
                && Number(p.tier) > Number(this.sub.plan_tier);
        },
        isLower(p) {
            return !!this.sub && !this.isCurrent(p) && !this.isUp(p);
        },
        lockReason(p) {
            if (!this.sub) return '';
            return Number(p.tier) === Number(this.sub.plan_tier)
                ? 'نفس مستوى باقتك الحالية'
                : 'أقل من مستوى باقتك الحالية';
        },
        get plan() {
            const p = findPlan(this.plans, this.planId);
            return p && this.isUp(p) ? p : null;
        },
        get creditUsed() {
            return this.plan && this.sub ? Math.min(round2(this.sub.credit), round2(this.plan.price)) : 0;
        },
        get due() {
            return this.plan ? round2(Math.max(round2(this.plan.price) - this.creditUsed, 0)) : 0;
        },
        get bonusDays() {
            if (!this.plan || !this.sub) return 0;
            const leftover = round2(round2(this.sub.credit) - this.creditUsed);
            const perDay = Number(this.plan.duration) > 0 ? round2(this.plan.price) / Number(this.plan.duration) : 0;
            return leftover > 0 && perDay > 0 ? Math.floor(leftover / perDay) : 0;
        },
        get end() {
            return this.plan ? addDays(this.today, Number(this.plan.duration) + this.bonusDays) : '';
        },

        open(s, old) {
            this.sub = s;
            this.busy = false;
            this.planId = '';
            const p = old && old.plan_id ? findPlan(this.plans, old.plan_id) : null;
            if (p && this.isUp(p)) this.planId = String(p.id);
            this.show = true;
        },
        onPlan() {},
    });

    /* ---------- تجديد ---------- */
    window.apSubRenew = () => ({
        show: false, busy: false,
        plans: [], planId: '', start: '', amount: '', sub: null, today: '',

        init() {
            const d = this.$el.dataset;
            this.plans = parse(d.plans, []);
            this.today = d.today || '';
            if (d.hasErrors === '1') {
                const s = parse(d.reopen, null);
                if (s) this.open(s, { plan_id: d.oldPlan, start_date: d.oldStart, amount: d.oldAmount });
            }
        },

        money,
        dur: durLabel,
        get plan() { return findPlan(this.plans, this.planId); },
        get discount() { return this.plan ? Math.max(this.plan.price - Number(this.amount || 0), 0) : 0; },
        get end() {
            if (!this.plan || !this.sub) return '';
            return addDays(this.sub.running ? this.sub.end : this.start, this.plan.duration);
        },

        open(s, old) {
            this.sub = s;
            this.busy = false;
            this.planId = (old && old.plan_id) || s.plan_id;
            this.start = (old && old.start_date) || this.today;
            const p = findPlan(this.plans, this.planId);
            this.amount = (old && old.amount) || (p ? p.price : '');
            this.show = true;
        },
        onPlan() {
            this.$nextTick(() => { this.amount = this.plan ? this.plan.price : ''; });
        },
    });

    /* ---------- بحث لايف + تبويبات + ترقيم من غير ريفرش ---------- */
    const boot = () => {
        const input = document.getElementById('sub-search');
        const box = document.getElementById('sub-results');
        if (!input || !box) return;

        let timer = null, controller = null;

        const load = async (url) => {
            if (controller) controller.abort();
            controller = new AbortController();
            box.style.opacity = '.5';
            box.style.pointerEvents = 'none';
            try {
                const res = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
                    credentials: 'same-origin', signal: controller.signal,
                });
                if (!res.ok) throw new Error('bad status');
                const doc = new DOMParser().parseFromString(await res.text(), 'text/html');
                const fresh = doc.getElementById('sub-results');
                if (!fresh) throw new Error('no results block');
                box.innerHTML = fresh.innerHTML;
                history.replaceState(null, '', url);
            } catch (e) {
                if (e.name === 'AbortError') return;
                window.location.href = url;
            } finally {
                box.style.opacity = '';
                box.style.pointerEvents = '';
            }
        };

        input.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                const u = new URL(window.location.href);
                const q = input.value.trim();
                q ? u.searchParams.set('search', q) : u.searchParams.delete('search');
                u.searchParams.delete('page');
                load(u.toString());
            }, 350);
        });

        box.addEventListener('click', (e) => {
            const a = e.target.closest('a[data-sub-nav], .ap-card__foot a[href]');
            if (!a) return;
            const u = new URL(a.href, window.location.origin);
            if (u.origin !== window.location.origin) return;
            e.preventDefault();
            load(u.toString());
        });
    };

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
    else boot();

    window.addEventListener('pageshow', (e) => { if (e.persisted) window.location.reload(); });
})();

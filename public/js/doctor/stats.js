(function () {
    'use strict';

    function init() {
        var el = document.getElementById('stChart');
        var d  = window.STATS_CHART;

        if (!el) return;
        if (typeof Chart === 'undefined') { console.error('stats.js: Chart.js غير محمّل'); return; }
        if (!d || !d.labels) { console.error('stats.js: بيانات الشارت ناقصة'); return; }

        var ctx   = el.getContext('2d');
        var small = window.matchMedia('(max-width:640px)').matches;

        var g = ctx.createLinearGradient(0, 0, 0, 340);
        g.addColorStop(0, 'rgba(79,70,229,.28)');
        g.addColorStop(1, 'rgba(79,70,229,0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: d.labels,
                datasets: [
                    {
                        label: 'المشاهدات', data: d.views,
                        borderColor: '#4f46e5', backgroundColor: g, fill: true,
                        tension: .4, borderWidth: 3, pointRadius: 0, pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#fff', pointHoverBorderWidth: 3
                    },
                    {
                        label: 'الزوار الفريدون', data: d.unique,
                        borderColor: '#0ea5e9', borderWidth: 2.5, tension: .4,
                        pointRadius: 0, pointHoverRadius: 5, borderDash: [6, 5]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 6, right: 4, left: 0 } },
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: { rtl: true, textDirection: 'rtl', padding: 12, cornerRadius: 10, boxPadding: 4 }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { autoSkip: true, maxTicksLimit: small ? 4 : 8, maxRotation: 0, font: { size: small ? 10 : 12 } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, maxTicksLimit: 5, font: { size: small ? 10 : 12 } },
                        grid: { color: 'rgba(148,163,184,.18)' }
                    }
                }
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

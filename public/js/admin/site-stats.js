document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('asChart');
    const dataEl = document.getElementById('asChartData');
    if (!canvas || !dataEl || typeof Chart === 'undefined') return;

    let d;
    try { d = JSON.parse(dataEl.textContent); } catch (e) { return; }

    const ctx = canvas.getContext('2d');

    function gradient(color) {
        const g = ctx.createLinearGradient(0, 0, 0, 320);
        g.addColorStop(0, color + '55');
        g.addColorStop(1, color + '00');
        return g;
    }

    const muted = '#94a3b8';
    const grid = 'rgba(127,127,127,.15)';

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: d.labels,
            datasets: [
                {
                    label: 'الزيارات',
                    data: d.views,
                    borderColor: '#4f46e5',
                    backgroundColor: gradient('#4f46e5'),
                    fill: true,
                    tension: .35,
                    borderWidth: 3,
                    pointRadius: d.labels.length > 40 ? 0 : 3,
                    pointHoverRadius: 5,
                },
                {
                    label: 'الزوار الفريدون',
                    data: d.unique,
                    borderColor: '#0ea5e9',
                    borderDash: [6, 5],
                    fill: false,
                    tension: .35,
                    borderWidth: 2.5,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: { rtl: true, textDirection: 'rtl', titleAlign: 'right', bodyAlign: 'right' },
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: muted, maxTicksLimit: 8, maxRotation: 0 } },
                y: { beginAtZero: true, grid: { color: grid }, ticks: { color: muted, precision: 0 } },
            },
        },
    });
});

<?= $this->extend('layouts/main') ?>
<?= $this->section('breadcrumb') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3 fade-in">
    <div>
        <p style="font-size:0.65rem; font-weight:700; color:var(--coral); text-transform:uppercase; letter-spacing:0.14em; margin-bottom:0.35rem;">Admin Console</p>
        <h1 style="font-size:1.6rem; font-weight:800; letter-spacing:-0.03em; margin:0;">Platform Overview</h1>
        <p style="font-size:0.85rem; color:var(--text-300); margin:0.25rem 0 0;">Live metrics across your academic system</p>
    </div>
    <button class="clean-btn-secondary" style="align-self:flex-start;">
        <i class="bi bi-download me-1"></i> Export Report
    </button>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4 fade-in">
    <div class="col-md-3">
        <div class="stat-card coral">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:0.68rem; font-weight:700; text-transform:uppercase; color:var(--text-400); letter-spacing:0.1em;">Total Users</span>
                <div class="stat-icon-box coral"><i class="bi bi-people-fill"></i></div>
            </div>
            <div style="font-size:2.1rem; font-weight:800; letter-spacing:-0.03em; line-height:1;"><?= number_format($totalUsers) ?></div>
            <div class="mt-2" style="font-size:0.72rem; color:#4ade80; font-weight:600;">
                <i class="bi bi-person-fill"></i> Total Identities
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card teal">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:0.68rem; font-weight:700; text-transform:uppercase; color:var(--text-400); letter-spacing:0.1em;">Active Students</span>
                <div class="stat-icon-box teal"><i class="bi bi-person-check-fill"></i></div>
            </div>
            <div style="font-size:2.1rem; font-weight:800; letter-spacing:-0.03em; line-height:1;"><?= number_format($studentCount) ?></div>
            <div class="mt-2" style="font-size:0.72rem; color:#4ade80; font-weight:600;">
                <i class="bi bi-mortarboard-fill"></i> Scholars Enrolled
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card amber">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:0.68rem; font-weight:700; text-transform:uppercase; color:var(--text-400); letter-spacing:0.1em;">New Registrations</span>
                <div class="stat-icon-box amber"><i class="bi bi-person-plus-fill"></i></div>
            </div>
            <div style="font-size:2.1rem; font-weight:800; letter-spacing:-0.03em; line-height:1;">156</div>
            <div class="mt-2" style="font-size:0.72rem; color:#fb7185; font-weight:600;">
                <i class="bi bi-arrow-down-right"></i> 2% this month
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:0.68rem; font-weight:700; text-transform:uppercase; color:var(--text-400); letter-spacing:0.1em;">System Uptime</span>
                <div class="stat-icon-box green"><i class="bi bi-activity"></i></div>
            </div>
            <div style="font-size:2.1rem; font-weight:800; letter-spacing:-0.03em; line-height:1;">99.9%</div>
            <div class="mt-2" style="font-size:0.72rem; color:var(--text-400); font-weight:500;">
                All services normal
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-4 fade-in">
    <div class="col-lg-8">
        <div class="clean-card h-100">
            <div class="clean-card-header d-flex justify-content-between align-items-center">
                <h6 style="font-size:0.875rem; font-weight:700; margin:0;">Platform Activity</h6>
                <span class="badge-coral" style="font-size:0.68rem;">Last 6 Months</span>
            </div>
            <div class="p-4"><div id="revenue-chart"></div></div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="clean-card h-100">
            <div class="clean-card-header">
                <h6 style="font-size:0.875rem; font-weight:700; margin:0;">Global Traffic</h6>
            </div>
            <div class="p-4">
                <div id="world-map" style="height:280px; border-radius:var(--radius-sm); overflow:hidden;"></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js" crossorigin="anonymous"></script>
<script>
new ApexCharts(document.querySelector('#revenue-chart'), {
    theme: { mode: 'dark' },
    series: [
        { name: 'Logins',        data: [850, 920, 1100, 1050, 1250, 1320] },
        { name: 'Registrations', data: [120, 150, 110, 130, 180, 156] }
    ],
    chart: { height: 290, type: 'area', toolbar: { show: false }, fontFamily: "'Sora', sans-serif", background: 'transparent' },
    legend: { position: 'top', horizontalAlign: 'right' },
    colors: ['#ff6240', '#00d4aa'],
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 2.5 },
    fill: { type: 'gradient', gradient: { shadeIntensity:1, opacityFrom:0.3, opacityTo:0.01, stops:[0,100] } },
    xaxis: {
        categories: ['Jan','Feb','Mar','Apr','May','Jun'],
        axisBorder: { show: false }, axisTicks: { show: false },
        labels: { style: { colors: '#4a4540', fontSize: '0.72rem' } }
    },
    yaxis: { labels: { style: { colors: '#4a4540', fontSize: '0.72rem' } } },
    grid: { borderColor: 'rgba(255,255,255,0.04)', strokeDashArray: 4 },
    tooltip: { theme: 'dark' }
}).render();

new jsVectorMap({
    selector: '#world-map',
    map: 'world',
    zoomOnScroll: false,
    regionStyle: {
        initial: { fill: 'rgba(255,255,255,0.06)', 'fill-opacity':1, stroke:'none' },
        hover:   { fill: '#ff6240', 'fill-opacity': 0.7 }
    }
});
</script>
<?= $this->endSection() ?>

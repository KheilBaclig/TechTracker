<?= $this->extend('layouts/main') ?>
<?= $this->section('breadcrumb') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3 fade-in">
    <div>
        <p style="font-size:0.65rem; font-weight:700; color:var(--teal); text-transform:uppercase; letter-spacing:0.14em; margin-bottom:0.35rem;">Faculty Portal</p>
        <h1 style="font-size:1.6rem; font-weight:800; letter-spacing:-0.03em; margin:0;">Academic Analytics</h1>
        <p style="font-size:0.85rem; color:var(--text-300); margin:0.25rem 0 0;">Overseeing student progression and engagement</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('students') ?>" class="clean-btn-primary">
            <i class="bi bi-people-fill me-1"></i> Manage Students
        </a>
    </div>
</div>

<!-- Teacher Metrics -->
<div class="row g-3 mb-4 fade-in">
    <div class="col-md-3">
        <div class="stat-card teal">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:0.68rem; font-weight:700; text-transform:uppercase; color:var(--text-400); letter-spacing:0.1em;">Active Scholars</span>
                <div class="stat-icon-box teal"><i class="bi bi-mortarboard-fill"></i></div>
            </div>
            <div style="font-size:2.1rem; font-weight:800; letter-spacing:-0.03em; line-height:1;"><?= number_format($studentCount) ?></div>
            <div class="mt-2" style="font-size:0.72rem; color:var(--teal); font-weight:600;">
                Students under supervision
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card coral">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:0.68rem; font-weight:700; text-transform:uppercase; color:var(--text-400); letter-spacing:0.1em;">Course Velocity</span>
                <div class="stat-icon-box coral"><i class="bi bi-graph-up"></i></div>
            </div>
            <div style="font-size:2.1rem; font-weight:800; letter-spacing:-0.03em; line-height:1;">92%</div>
            <div class="mt-2" style="font-size:0.72rem; color:#4ade80; font-weight:600;">
                <i class="bi bi-arrow-up-right"></i> Stable progression
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card amber">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:0.68rem; font-weight:700; text-transform:uppercase; color:var(--text-400); letter-spacing:0.1em;">Pending Review</span>
                <div class="stat-icon-box amber"><i class="bi bi-clock-history"></i></div>
            </div>
            <div style="font-size:2.1rem; font-weight:800; letter-spacing:-0.03em; line-height:1;">08</div>
            <div class="mt-2" style="font-size:0.72rem; color:var(--amber); font-weight:600;">
                Tasks awaiting evaluation
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span style="font-size:0.68rem; font-weight:700; text-transform:uppercase; color:var(--text-400); letter-spacing:0.1em;">Global Uptime</span>
                <div class="stat-icon-box green"><i class="bi bi-activity"></i></div>
            </div>
            <div style="font-size:2.1rem; font-weight:800; letter-spacing:-0.03em; line-height:1;">100%</div>
            <div class="mt-2" style="font-size:0.72rem; color:var(--text-400); font-weight:500;">
                Portal status normal
            </div>
        </div>
    </div>
</div>

<div class="row g-4 fade-in">
    <!-- Student Interaction Chart -->
    <div class="col-lg-8">
        <div class="clean-card h-100">
            <div class="clean-card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="stat-icon-box teal" style="width:28px; height:28px; font-size:0.8rem;"><i class="bi bi-activity"></i></div>
                    <h6 style="font-size:0.875rem; font-weight:700; margin:0;">Engagement Velocity</h6>
                </div>
                <span class="badge-teal" style="font-size:0.68rem; letter-spacing:0.05em;">Current Term</span>
            </div>
            <div class="p-4">
                <div id="engagement-chart"></div>
            </div>
        </div>
    </div>

    <!-- Recent Scholars -->
    <div class="col-lg-4">
        <div class="clean-card h-100">
            <div class="clean-card-header d-flex align-items-center gap-2">
                <div class="stat-icon-box coral" style="width:28px; height:28px; font-size:0.8rem;"><i class="bi bi-lightning-fill"></i></div>
                <h6 style="font-size:0.875rem; font-weight:700; margin:0;">Recent Onboarding</h6>
            </div>
            <div class="p-4 pb-2">
                <div class="d-flex flex-column gap-3">
                    <?php if (empty($recentStudents)): ?>
                        <div class="text-center py-4">
                            <i class="bi bi-inbox text-muted fs-3"></i>
                            <p class="text-muted small mt-2">No recent student activity</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($recentStudents as $rs): ?>
                        <div class="d-flex align-items-center gap-3">
                            <?php if (!empty($rs['profile_image'])): ?>
                                <img src="<?= base_url('uploads/profiles/' . $rs['profile_image']) ?>" 
                                     style="width:38px; height:38px; border-radius:10px; object-fit:cover; border:1px solid var(--border-2);">
                            <?php else: ?>
                                <div style="width:38px; height:38px; border-radius:10px; background:var(--bg-raised); border:1px solid var(--border-2); display:flex; align-items:center; justify-content:center; color:var(--teal);">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div style="font-size:0.85rem; font-weight:600; color:var(--text-100);"><?= esc($rs['fullname']) ?></div>
                                <div style="font-size:0.72rem; color:var(--text-400);">Joined the platform</div>
                            </div>
                            <div class="ms-auto" style="font-size:0.6rem; color:var(--text-400); font-family:monospace;">
                                <?= date('M d', strtotime($rs['created_at'])) ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <hr style="border-top: 1px solid var(--border-1); margin: 1.5rem 0;">
                <div class="text-center mb-2">
                    <a href="<?= base_url('students') ?>" style="font-size:0.75rem; color:var(--text-300); text-decoration:none; font-weight:600;">View Full Roster <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>
<script>
new ApexCharts(document.querySelector('#engagement-chart'), {
    theme: { mode: 'dark' },
    series: [
        { name: 'Submission Volume', data: [44, 55, 41, 67, 22, 43, 21] },
        { name: 'Quiz Participation', data: [13, 23, 20, 8, 13, 27, 33] }
    ],
    chart: { height: 290, type: 'area', toolbar: { show: false }, fontFamily: "'Sora', sans-serif", background: 'transparent' },
    legend: { position: 'top', horizontalAlign: 'right' },
    colors: ['#00d4aa', '#ff6240'],
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 3 },
    fill: { type: 'gradient', gradient: { shadeIntensity:1, opacityFrom:0.35, opacityTo:0.01, stops:[0,100] } },
    xaxis: {
        categories: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        axisBorder: { show: false }, axisTicks: { show: false },
        labels: { style: { colors: '#7a7368', fontSize: '0.72rem' } }
    },
    yaxis: { labels: { style: { colors: '#7a7368', fontSize: '0.72rem' } } },
    grid: { borderColor: 'rgba(255,255,255,0.03)', strokeDashArray: 4 },
    tooltip: { theme: 'dark' }
}).render();
</script>
<?= $this->endSection() ?>

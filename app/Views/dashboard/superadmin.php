<?php $page_title = 'Dashboard'; ?>
<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">Good <?= date('H')<12?'morning':(date('H')<17?'afternoon':'evening') ?>, <?= esc(explode(' ',$userName)[0]) ?> 👋</div>
    <div class="page-sub"><?= date('l, F j, Y') ?> — SuperAdmin View</div>
  </div>
  <div style="display:flex;gap:8px">
    <a href="<?= base_url('assets/new') ?>" class="btn btn-primary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Add Asset
    </a>
    <a href="<?= base_url('transactions/new') ?>" class="btn btn-secondary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>New Transaction
    </a>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card" style="--accent-line:#818CF8">
    <div class="stat-icon purple"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg></div>
    <div class="stat-label">Total Assets</div>
    <div class="stat-value"><?= number_format($totalAssets) ?></div>
    <div class="stat-sub"><?= $statusCounts['active']??0 ?> active</div>
  </div>
  <div class="stat-card" style="--accent-line:#34D399">
    <div class="stat-icon green"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
    <div class="stat-label">Team Members</div>
    <div class="stat-value"><?= number_format($totalUsers) ?></div>
    <div class="stat-sub">Active users</div>
  </div>
  <div class="stat-card" style="--accent-line:#FBBF24">
    <div class="stat-icon orange"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></div>
    <div class="stat-label">Maintenance</div>
    <div class="stat-value"><?= number_format($totalMaintenance) ?></div>
    <div class="stat-sub"><?= $statusCounts['under_maintenance']??0 ?> in progress</div>
  </div>
  <div class="stat-card" style="--accent-line:#F87171">
    <div class="stat-icon red"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
    <div class="stat-label">Low Stock Alerts</div>
    <div class="stat-value"><?= count($lowStockAssets) ?></div>
    <div class="stat-sub">Need attention</div>
  </div>
</div>

<!-- Charts Row -->
<div style="display:grid;grid-template-columns:1fr 320px;gap:16px;margin-bottom:18px">
  <div class="card">
    <div class="card-header"><span class="card-title">Asset Activity — Last 7 Days</span></div>
    <div class="card-body"><canvas id="activityChart" height="100"></canvas></div>
  </div>
  <div class="card">
    <div class="card-header"><span class="card-title">By Category</span></div>
    <div class="card-body"><canvas id="categoryChart" height="100"></canvas></div>
  </div>
</div>

<!-- Low Stock + Recent Users -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:18px">
  <div class="card">
    <div class="card-header">
      <span class="card-title">⚠ Low Stock Assets</span>
      <a href="<?= base_url('assets') ?>" class="btn btn-secondary btn-sm">View All</a>
    </div>
    <div class="card-body" style="padding-top:10px">
      <?php if(empty($lowStockAssets)): ?>
        <div class="empty-state" style="padding:24px 0"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg><p>All stock levels healthy</p></div>
      <?php else: ?>
        <?php foreach($lowStockAssets as $ls): ?>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:9px 0;border-bottom:1px solid var(--border)">
            <div><div style="font-size:.82rem;font-weight:500"><?= esc($ls['name']) ?></div><div style="font-size:.7rem;color:var(--text-3)"><?= esc($ls['asset_tag']) ?></div></div>
            <span class="badge badge-low"><?= $ls['quantity'] ?> left</span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <span class="card-title">Recent Users</span>
      <a href="<?= base_url('users') ?>" class="btn btn-secondary btn-sm">Manage</a>
    </div>
    <div class="card-body" style="padding-top:10px">
      <?php foreach($recentUsers as $u): ?>
        <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--border)">
          <div style="width:30px;height:30px;border-radius:50%;background:var(--accent-bg);display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;color:var(--accent);flex-shrink:0"><?= strtoupper(substr($u['name'],0,1)) ?></div>
          <div style="flex:1;min-width:0"><div style="font-size:.82rem;font-weight:500;truncate"><?= esc($u['name']) ?></div><div style="font-size:.7rem;color:var(--text-3)"><?= esc($u['email']) ?></div></div>
          <span class="badge badge-<?= $u['role'] ?>"><?= ucfirst($u['role']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- Recent Transactions -->
<div class="card" style="margin-bottom:18px">
  <div class="card-header"><span class="card-title">Recent Transactions</span><a href="<?= base_url('transactions') ?>" class="btn btn-secondary btn-sm">View All</a></div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Ref</th><th>Asset</th><th>Type</th><th>Qty</th><th>By</th><th>Date</th></tr></thead>
      <tbody>
        <?php if(empty($recentTx)): ?>
          <tr><td colspan="6"><div class="empty-state"><p>No transactions yet</p></div></td></tr>
        <?php else: ?>
          <?php foreach($recentTx as $tx): ?>
            <tr>
              <td><span style="font-family:monospace;font-size:.78rem;color:var(--accent)"><?= esc($tx['ref_code']) ?></span></td>
              <td style="font-size:.82rem;font-weight:500"><?= esc($tx['asset_name']??'—') ?></td>
              <td><span class="badge badge-<?= $tx['type'] ?>"><?= ucfirst($tx['type']) ?></span></td>
              <td style="font-weight:600"><?= $tx['quantity'] ?></td>
              <td style="color:var(--text-2);font-size:.8rem"><?= esc($tx['user_name']??'—') ?></td>
              <td style="color:var(--text-3);font-size:.78rem"><?= date('M d, Y',strtotime($tx['created_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Recent Maintenance -->
<div class="card">
  <div class="card-header"><span class="card-title">Recent Maintenance</span><a href="<?= base_url('maintenance') ?>" class="btn btn-secondary btn-sm">View All</a></div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Asset</th><th>Type</th><th>Technician</th><th>Status</th><th>Date</th></tr></thead>
      <tbody>
        <?php if(empty($recentMaint)): ?>
          <tr><td colspan="5"><div class="empty-state"><p>No maintenance logs</p></div></td></tr>
        <?php else: ?>
          <?php foreach($recentMaint as $m): ?>
            <tr>
              <td style="font-size:.82rem;font-weight:500"><?= esc($m['asset_name']??'—') ?></td>
              <td style="color:var(--text-2);font-size:.8rem;text-transform:capitalize"><?= esc($m['type']) ?></td>
              <td style="font-size:.8rem"><?= esc($m['technician']) ?></td>
              <td><span class="badge badge-<?= $m['status'] ?>"><?= ucfirst(str_replace('_',' ',$m['status'])) ?></span></td>
              <td style="color:var(--text-3);font-size:.78rem"><?= date('M d, Y',strtotime($m['created_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
const isDark=!document.body.classList.contains('light-mode');
const tc=isDark?'#52525B':'#94A3B8',gc=isDark?'rgba(255,255,255,.05)':'rgba(0,0,0,.06)';
Chart.defaults.color=tc;Chart.defaults.borderColor=gc;
new Chart(document.getElementById('activityChart'),{type:'bar',data:{labels:<?= json_encode(array_column($activityData,'date')) ?>,datasets:[{label:'Checkouts',data:<?= json_encode(array_column($activityData,'checkouts')) ?>,backgroundColor:'rgba(99,102,241,.7)',borderRadius:4},{label:'Check-ins',data:<?= json_encode(array_column($activityData,'checkins')) ?>,backgroundColor:'rgba(52,211,153,.5)',borderRadius:4}]},options:{responsive:true,plugins:{legend:{labels:{font:{size:11}}}},scales:{x:{grid:{display:false}},y:{grid:{color:gc},ticks:{stepSize:1}}}}});
new Chart(document.getElementById('categoryChart'),{type:'doughnut',data:{labels:<?= json_encode(array_column($categoryStats,'name')) ?>,datasets:[{data:<?= json_encode(array_column($categoryStats,'asset_count')) ?>,backgroundColor:['rgba(99,102,241,.8)','rgba(52,211,153,.8)','rgba(251,191,36,.8)','rgba(248,113,113,.8)','rgba(56,189,248,.8)','rgba(45,212,191,.8)'],borderWidth:0,hoverOffset:4}]},options:{responsive:true,cutout:'65%',plugins:{legend:{position:'bottom',labels:{font:{size:11},padding:12}}}}});
</script>
//
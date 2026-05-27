<?php $page_title = 'Dashboard'; ?>
<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">Good <?= date('H')<12?'morning':(date('H')<17?'afternoon':'evening') ?>, <?= esc(explode(' ',$userName)[0]) ?> 👋</div>
    <div class="page-sub"><?= date('l, F j, Y') ?> — Staff View</div>
  </div>
  <a href="<?= base_url('assets') ?>" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>Browse Assets
  </a>
</div>

<div class="stats-grid">
  <div class="stat-card" style="--accent-line:#818CF8">
    <div class="stat-icon purple"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg></div>
    <div class="stat-label">Total Assets</div>
    <div class="stat-value"><?= number_format($totalAssets) ?></div>
    <div class="stat-sub">In inventory</div>
  </div>
  <div class="stat-card" style="--accent-line:#34D399">
    <div class="stat-icon green"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
    <div class="stat-label">Active</div>
    <div class="stat-value"><?= $statusCounts['active']??0 ?></div>
    <div class="stat-sub">Available assets</div>
  </div>
  <div class="stat-card" style="--accent-line:#FBBF24">
    <div class="stat-icon orange"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></div>
    <div class="stat-label">Under Maintenance</div>
    <div class="stat-value"><?= $statusCounts['under_maintenance']??0 ?></div>
    <div class="stat-sub">Being serviced</div>
  </div>
  <div class="stat-card" style="--accent-line:#F87171">
    <div class="stat-icon red"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg></div>
    <div class="stat-label">Low Stock</div>
    <div class="stat-value"><?= count($lowStockAssets) ?></div>
    <div class="stat-sub">Need attention</div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:16px">
  <div class="card">
    <div class="card-header"><span class="card-title">Recent Transactions</span></div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Ref</th><th>Asset</th><th>Type</th><th>Qty</th><th>Date</th></tr></thead>
        <tbody>
          <?php if(empty($recentTx)): ?>
            <tr><td colspan="5"><div class="empty-state"><p>No transactions yet</p></div></td></tr>
          <?php else: ?>
            <?php foreach($recentTx as $tx): ?>
              <tr>
                <td><span style="font-family:monospace;font-size:.75rem;color:var(--accent)"><?= esc($tx['ref_code']) ?></span></td>
                <td style="font-size:.82rem;font-weight:500"><?= esc($tx['asset_name']??'—') ?></td>
                <td><span class="badge badge-<?= $tx['type'] ?>"><?= ucfirst($tx['type']) ?></span></td>
                <td style="font-weight:600"><?= $tx['quantity'] ?></td>
                <td style="color:var(--text-3);font-size:.78rem"><?= date('M d',strtotime($tx['created_at'])) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><span class="card-title">Assets by Category</span></div>
    <div class="card-body"><canvas id="categoryChart" height="160"></canvas></div>
  </div>
</div>
<script>
const isDark=!document.body.classList.contains('light-mode');
Chart.defaults.color=isDark?'#52525B':'#94A3B8';
new Chart(document.getElementById('categoryChart'),{type:'doughnut',data:{labels:<?= json_encode(array_column($categoryStats,'name')) ?>,datasets:[{data:<?= json_encode(array_column($categoryStats,'asset_count')) ?>,backgroundColor:['rgba(99,102,241,.8)','rgba(52,211,153,.8)','rgba(251,191,36,.8)','rgba(248,113,113,.8)','rgba(56,189,248,.8)'],borderWidth:0}]},options:{responsive:true,cutout:'60%',plugins:{legend:{position:'bottom',labels:{font:{size:10},padding:10}}}}});
</script>

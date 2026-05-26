<?php $page_title = 'Dashboard'; ?>

<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">Good <?= date('H') < 12 ? 'morning' : (date('H') < 17 ? 'afternoon' : 'evening') ?>, <?= esc(explode(' ', $userName)[0]) ?> 👋</div>
    <div class="page-sub"><?= date('l, F j, Y') ?></div>
  </div>
  <a href="<?= base_url('transactions/new') ?>" class="btn btn-primary">
    <i class="fa-solid fa-plus"></i> New Transaction
  </a>
</div>

<!-- Stats -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon cream"><i class="fa-solid fa-shirt"></i></div>
    <div class="stat-info">
      <div class="label">Products</div>
      <div class="value"><?= number_format($totalProducts) ?></div>
      <div class="sub">Active listings</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon sage"><i class="fa-solid fa-boxes-stacked"></i></div>
    <div class="stat-info">
      <div class="label">Total Stock</div>
      <div class="value"><?= number_format($totalStock) ?></div>
      <div class="sub">Units available</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon sky"><i class="fa-solid fa-receipt"></i></div>
    <div class="stat-info">
      <div class="label">Sales</div>
      <div class="value"><?= number_format($totalSales) ?></div>
      <div class="sub">Total transactions</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon gold"><i class="fa-solid fa-users"></i></div>
    <div class="stat-info">
      <div class="label">Team</div>
      <div class="value"><?= number_format($totalUsers) ?></div>
      <div class="sub">Active users</div>
    </div>
  </div>
</div>

<!-- Charts + Low Stock -->
<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;margin-bottom:28px">
  <div class="card">
    <div class="card-header">
      <span class="card-title">Sales — Last 7 Days</span>
    </div>
    <div class="card-body">
      <canvas id="salesChart" height="90"></canvas>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <span class="card-title">Low Stock Alert</span>
      <a href="<?= base_url('products') ?>" class="btn btn-secondary btn-sm">View All</a>
    </div>
    <div class="card-body" style="padding-top:12px">
      <?php if (empty($lowStock)): ?>
        <div class="empty-state" style="padding:30px 0"><div class="icon"><i class="fa-solid fa-circle-check" style="color:var(--sage)"></i></div><p>All stock levels healthy</p></div>
      <?php else: ?>
        <?php foreach ($lowStock as $ls): ?>
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--sand)">
            <div>
              <div style="font-size:.85rem;font-weight:500;color:var(--espresso)"><?= esc($ls['product_name']) ?></div>
              <div style="font-size:.72rem;color:var(--taupe)"><?= esc($ls['sku']) ?> · <?= esc($ls['size']) ?> / <?= esc($ls['color']) ?></div>
            </div>
            <span class="badge badge-low"><?= $ls['stock'] ?> left</span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Recent Transactions -->
<div class="card">
  <div class="card-header">
    <span class="card-title">Recent Transactions</span>
    <a href="<?= base_url('transactions') ?>" class="btn btn-secondary btn-sm">View All</a>
  </div>
  <div class="card-body" style="padding:0">
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Ref Code</th><th>Type</th><th>By</th><th>Total</th><th>Date</th><th></th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($recentTx)): ?>
            <tr><td colspan="6"><div class="empty-state"><p>No transactions yet</p></div></td></tr>
          <?php else: ?>
            <?php foreach ($recentTx as $tx): ?>
              <tr>
                <td><span style="font-family:monospace;font-size:.82rem;color:var(--warm)"><?= esc($tx['ref_code']) ?></span></td>
                <td><span class="badge badge-<?= $tx['type'] ?>"><?= ucfirst($tx['type']) ?></span></td>
                <td><?= esc($tx['user_name']) ?></td>
                <td style="font-weight:600"><?= currency($tx['total']) ?></td>
                <td style="color:var(--taupe);font-size:.8rem"><?= date('M d, Y', strtotime($tx['created_at'])) ?></td>
                <td><a href="<?= base_url('transactions/' . $tx['id']) ?>" class="btn btn-secondary btn-sm btn-icon"><i class="fa-solid fa-eye"></i></a></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode(array_column($salesData, 'date')) ?>,
    datasets: [{
      label: 'Sales ($)',
      data: <?= json_encode(array_column($salesData, 'total')) ?>,
      borderColor: '#3D2B1F',
      backgroundColor: 'rgba(61,43,31,.06)',
      borderWidth: 2,
      pointBackgroundColor: '#3D2B1F',
      pointRadius: 4,
      tension: .4,
      fill: true,
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
      x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#C4B5A5' } },
      y: { grid: { color: '#F0EBE3' }, ticks: { font: { size: 11 }, color: '#C4B5A5', callback: v => '₱' + v } }
    }
  }
});
</script>

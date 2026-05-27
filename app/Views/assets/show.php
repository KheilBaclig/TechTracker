<?php
$page_title = esc($asset['name']);
$isManager  = in_array(session()->get('user_role'), ['superadmin', 'manager']);

$details = [
    'Tag'           => $asset['asset_tag'],
    'Brand'         => $asset['brand']          ?? '—',
    'Model'         => $asset['model']          ?? '—',
    'Serial No.'    => $asset['serial_number']  ?? '—',
    'Location'      => $asset['location']       ?? '—',
    'Assigned To'   => $asset['assigned_to']    ?? '—',
    'Purchase Date' => $asset['purchase_date']  ? date('M d, Y', strtotime($asset['purchase_date']))  : '—',
    'Warranty'      => $asset['warranty_expiry'] ? date('M d, Y', strtotime($asset['warranty_expiry'])) : '—',
];
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title"><?= esc($asset['name']) ?></div>
        <div class="page-sub"><?= esc($asset['asset_tag']) ?> · <?= esc($asset['category_name'] ?? '—') ?></div>
    </div>

    <div class="btn-group">
        <?php if ($isManager): ?>
            <a href="<?= base_url('maintenance/new?asset_id=' . $asset['id']) ?>" class="btn btn-secondary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Log Maintenance
            </a>

            <a href="<?= base_url('assets/' . $asset['id'] . '/edit') ?>" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
        <?php endif; ?>

        <a href="<?= base_url('assets') ?>" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
            Back
        </a>
    </div>
</div>

<!-- Main Layout -->
<div class="show-layout">

    <!-- Left Column: Image + Details -->
    <div class="show-sidebar">

        <!-- Image Card -->
        <div class="card">
            <div class="asset-image-wrap">
                <?php if ($asset['image']): ?>
                    <img src="<?= base_url('uploads/assets/' . $asset['image']) ?>" alt="<?= esc($asset['name']) ?>">
                <?php else: ?>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                    </svg>
                <?php endif; ?>
            </div>

            <div class="card-body">
                <div class="asset-status-row">
                    <span class="badge badge-<?= $asset['status'] ?>">
                        <?= ucfirst(str_replace('_', ' ', $asset['status'])) ?>
                    </span>
                    <span class="asset-qty">Qty: <?= $asset['quantity'] ?></span>
                </div>

                <?php if ($asset['purchase_cost']): ?>
                    <div class="asset-cost">₱<?= number_format($asset['purchase_cost'], 2) ?></div>
                    <div class="asset-cost-label">Purchase cost</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Details Card -->
        <div class="card">
            <div class="card-body">
                <?php foreach ($details as $label => $value): ?>
                    <div class="detail-row">
                        <span class="detail-label"><?= $label ?></span>
                        <span class="detail-value"><?= esc($value) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <!-- Right Column: History Tables -->
    <div class="show-main">

        <!-- Maintenance History -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">Maintenance History</span>
                <?php if ($isManager): ?>
                    <a href="<?= base_url('maintenance/new?asset_id=' . $asset['id']) ?>" class="btn btn-secondary btn-sm">
                        + Add
                    </a>
                <?php endif; ?>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Technician</th>
                            <th>Status</th>
                            <th>Cost</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($maintenance)): ?>
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <p>No maintenance logs yet</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($maintenance as $m): ?>
                                <tr>
                                    <td class="capitalize"><?= esc($m['type']) ?></td>
                                    <td><?= esc($m['technician']) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $m['status'] ?>">
                                            <?= ucfirst(str_replace('_', ' ', $m['status'])) ?>
                                        </span>
                                    </td>
                                    <td>₱<?= number_format($m['cost'], 2) ?></td>
                                    <td class="text-muted"><?= date('M d, Y', strtotime($m['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">Transaction History</span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Type</th>
                            <th>Qty</th>
                            <th>By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <p>No transactions yet</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $tx): ?>
                                <tr>
                                    <td><span class="mono-tag"><?= esc($tx['ref_code']) ?></span></td>
                                    <td>
                                        <span class="badge badge-<?= $tx['type'] ?>">
                                            <?= ucfirst($tx['type']) ?>
                                        </span>
                                    </td>
                                    <td class="fw-600"><?= $tx['quantity'] ?></td>
                                    <td class="text-muted"><?= esc($tx['user_name'] ?? '—') ?></td>
                                    <td class="text-muted"><?= date('M d, Y', strtotime($tx['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

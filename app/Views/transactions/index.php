<?php
$page_title = 'Transactions';

$types = [
    'checkout' => 'Check-Out',
    'checkin'  => 'Check-In',
    'transfer' => 'Transfer',
];
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title">Transactions</div>
        <div class="page-sub">Asset check-in / check-out / transfer history</div>
    </div>

    <a href="<?= base_url('transactions/new') ?>" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        New Transaction
    </a>
</div>

<!-- Filters -->
<div class="card mb-16">
    <div class="card-body">
        <form method="GET" class="filter-bar">
            <select name="type" class="form-control filter-select">
                <option value="">All Types</option>
                <?php foreach ($types as $value => $label): ?>
                    <option value="<?= $value ?>" <?= ($type ?? '') === $value ? 'selected' : '' ?>>
                        <?= $label ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn btn-secondary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
                Filter
            </button>

            <?php if ($type): ?>
                <a href="<?= base_url('transactions') ?>" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Transactions Table -->
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Ref Code</th>
                    <th>Asset</th>
                    <th>Type</th>
                    <th>Qty</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Assigned To</th>
                    <th>By</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transactions)): ?>
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                <p>No transactions yet</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($transactions as $tx): ?>
                        <tr>
                            <td><span class="mono-tag"><?= esc($tx['ref_code']) ?></span></td>
                            <td class="asset-name"><?= esc($tx['asset_name'] ?? '—') ?></td>
                            <td>
                                <span class="badge badge-<?= $tx['type'] ?>">
                                    <?= ucfirst($tx['type']) ?>
                                </span>
                            </td>
                            <td class="fw-600"><?= $tx['quantity'] ?></td>
                            <td class="text-muted"><?= esc($tx['from_location'] ?? '—') ?></td>
                            <td class="text-muted"><?= esc($tx['to_location'] ?? '—') ?></td>
                            <td><?= esc($tx['assigned_to'] ?? '—') ?></td>
                            <td class="text-muted"><?= esc($tx['user_name'] ?? '—') ?></td>
                            <td class="text-muted"><?= date('M d, Y', strtotime($tx['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('transactions/' . $tx['id']) ?>"
                                   class="btn btn-secondary btn-sm btn-icon"
                                   title="View">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($pager): ?>
        <div class="pager-wrap">
            <?= $pager->links('default', 'custom_pager') ?>
        </div>
    <?php endif; ?>
</div>

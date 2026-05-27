<?php
$page_title = 'Transaction ' . $transaction['ref_code'];

$details = [
    'Reference'    => $transaction['ref_code'],
    'Quantity'     => $transaction['quantity'],
    'From Location'=> $transaction['from_location'] ?? '—',
    'To Location'  => $transaction['to_location']   ?? '—',
    'Assigned To'  => $transaction['assigned_to']   ?? '—',
    'Recorded By'  => $transaction['user_name']     ?? '—',
    'Date'         => date('M d, Y g:i A', strtotime($transaction['created_at'])),
];
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title">Transaction Detail</div>
        <div class="page-sub">
            <span class="mono-tag"><?= esc($transaction['ref_code']) ?></span>
        </div>
    </div>

    <a href="<?= base_url('transactions') ?>" class="btn btn-secondary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Back
    </a>
</div>

<!-- Detail Card -->
<div class="form-wrap">
    <div class="card">
        <div class="card-body">

            <!-- Asset + Type Header -->
            <div class="log-header">
                <div>
                    <div class="log-asset-name"><?= esc($transaction['asset_name'] ?? '—') ?></div>
                    <div class="log-asset-tag"><?= esc($transaction['asset_tag'] ?? '') ?></div>
                </div>
                <span class="badge badge-<?= $transaction['type'] ?>">
                    <?= ucfirst($transaction['type']) ?>
                </span>
            </div>

            <!-- Details Grid -->
            <div class="detail-grid">
                <?php foreach ($details as $label => $value): ?>
                    <div class="detail-block">
                        <div class="detail-block-label"><?= $label ?></div>
                        <div class="detail-block-value"><?= esc($value) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Notes -->
            <?php if ($transaction['notes']): ?>
                <div class="log-description-wrap">
                    <div class="detail-block-label">Notes</div>
                    <div class="log-description"><?= nl2br(esc($transaction['notes'])) ?></div>
                </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="form-actions">
                <a href="<?= base_url('assets/' . $transaction['asset_id']) ?>" class="btn btn-secondary">
                    View Asset
                </a>
            </div>

        </div>
    </div>
</div>

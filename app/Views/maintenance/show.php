<?php
$page_title = 'Maintenance Log #' . $log['id'];
$isManager  = in_array(session()->get('user_role'), ['superadmin', 'manager']);

$details = [
    'Type'        => ucfirst($log['type']),
    'Technician'  => $log['technician'],
    'Cost'        => '₱' . number_format($log['cost'], 2),
    'Logged By'   => $log['user_name']    ?? '—',
    'Scheduled'   => $log['scheduled_at'] ? date('M d, Y', strtotime($log['scheduled_at'])) : '—',
    'Completed'   => $log['completed_at'] ? date('M d, Y', strtotime($log['completed_at'])) : '—',
    'Created'     => date('M d, Y g:i A', strtotime($log['created_at'])),
];
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title">Maintenance Log</div>
        <div class="page-sub">
            <?= esc($log['asset_name'] ?? '—') ?> · <?= esc($log['asset_tag'] ?? '') ?>
        </div>
    </div>

    <div class="btn-group">
        <?php if ($isManager): ?>
            <a href="<?= base_url('maintenance/' . $log['id'] . '/edit') ?>" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
        <?php endif; ?>

        <a href="<?= base_url('maintenance') ?>" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
            Back
        </a>
    </div>
</div>

<!-- Detail Card -->
<div class="form-wrap">
    <div class="card">
        <div class="card-body">

            <!-- Asset + Status Header -->
            <div class="log-header">
                <div>
                    <div class="log-asset-name"><?= esc($log['asset_name'] ?? '—') ?></div>
                    <div class="log-asset-tag"><?= esc($log['asset_tag'] ?? '') ?></div>
                </div>
                <span class="badge badge-<?= $log['status'] ?>">
                    <?= ucfirst(str_replace('_', ' ', $log['status'])) ?>
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

            <!-- Description -->
            <div class="log-description-wrap">
                <div class="detail-block-label">Description</div>
                <div class="log-description"><?= nl2br(esc($log['description'])) ?></div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="<?= base_url('assets/' . $log['asset_id']) ?>" class="btn btn-secondary">
                    View Asset
                </a>

                <?php if ($isManager): ?>
                    <form action="<?= base_url('maintenance/' . $log['id'] . '/delete') ?>"
                          method="POST"
                          onsubmit="return confirm('Delete this log?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger">Delete Log</button>
                    </form>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

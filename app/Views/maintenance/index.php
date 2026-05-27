<?php
$page_title = 'Maintenance Logs';
$isManager  = in_array(session()->get('user_role'), ['superadmin', 'manager']);

$statuses = [
    'scheduled'   => 'Scheduled',
    'in_progress' => 'In Progress',
    'completed'   => 'Completed',
    'cancelled'   => 'Cancelled',
];

$types = [
    'preventive'  => 'Preventive',
    'corrective'  => 'Corrective',
    'inspection'  => 'Inspection',
    'upgrade'     => 'Upgrade',
];
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title">Maintenance Logs</div>
        <div class="page-sub"><?= number_format($total) ?> total records</div>
    </div>

    <?php if ($isManager): ?>
        <a href="<?= base_url('maintenance/new') ?>" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Log Maintenance
        </a>
    <?php endif; ?>
</div>

<!-- Filters -->
<div class="card mb-16">
    <div class="card-body">
        <form method="GET" class="filter-bar">
            <select name="status" class="form-control filter-select">
                <option value="">All Statuses</option>
                <?php foreach ($statuses as $value => $label): ?>
                    <option value="<?= $value ?>" <?= ($status ?? '') === $value ? 'selected' : '' ?>>
                        <?= $label ?>
                    </option>
                <?php endforeach; ?>
            </select>

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

            <?php if ($status || $type): ?>
                <a href="<?= base_url('maintenance') ?>" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Logs Table -->
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Asset</th>
                    <th>Type</th>
                    <th>Technician</th>
                    <th>Description</th>
                    <th>Cost</th>
                    <th>Status</th>
                    <th>Scheduled</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                                </svg>
                                <p>No maintenance logs found</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $m): ?>
                        <tr>
                            <td>
                                <div class="asset-name"><?= esc($m['asset_name'] ?? '—') ?></div>
                                <div class="asset-serial"><?= esc($m['asset_tag'] ?? '') ?></div>
                            </td>
                            <td class="capitalize text-muted"><?= esc($m['type']) ?></td>
                            <td><?= esc($m['technician']) ?></td>
                            <td class="text-muted"><?= character_limiter(esc($m['description']), 50) ?></td>
                            <td class="fw-500">₱<?= number_format($m['cost'], 2) ?></td>
                            <td>
                                <span class="badge badge-<?= $m['status'] ?>">
                                    <?= ucfirst(str_replace('_', ' ', $m['status'])) ?>
                                </span>
                            </td>
                            <td class="text-muted">
                                <?= $m['scheduled_at'] ? date('M d, Y', strtotime($m['scheduled_at'])) : '—' ?>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?= base_url('maintenance/' . $m['id']) ?>"
                                       class="btn btn-secondary btn-sm btn-icon"
                                       title="View">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>

                                    <?php if ($isManager): ?>
                                        <a href="<?= base_url('maintenance/' . $m['id'] . '/edit') ?>"
                                           class="btn btn-secondary btn-sm btn-icon"
                                           title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </a>

                                        <form action="<?= base_url('maintenance/' . $m['id'] . '/delete') ?>"
                                              method="POST"
                                              onsubmit="return confirm('Delete this log?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Delete">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                    <polyline points="3 6 5 6 21 6"/>
                                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                    <path d="M10 11v6"/>
                                                    <path d="M14 11v6"/>
                                                </svg>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
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

<?php
$isEdit     = (bool) $log;
$page_title = $isEdit ? 'Edit Maintenance Log' : 'New Maintenance Log';
$formAction = $isEdit ? base_url('maintenance/' . $log['id']) : base_url('maintenance');

$types = [
    'preventive'  => 'Preventive',
    'corrective'  => 'Corrective',
    'inspection'  => 'Inspection',
    'upgrade'     => 'Upgrade',
];

$statuses = [
    'scheduled'   => 'Scheduled',
    'in_progress' => 'In Progress',
    'completed'   => 'Completed',
    'cancelled'   => 'Cancelled',
];

$selectedAsset = old('asset_id', $log['asset_id'] ?? $preselect_asset ?? '');
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title"><?= $isEdit ? 'Edit Maintenance Log' : 'Log Maintenance' ?></div>
        <div class="page-sub"><?= $isEdit ? 'Update maintenance record' : 'Record a maintenance activity' ?></div>
    </div>

    <a href="<?= base_url('maintenance') ?>" class="btn btn-secondary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Back
    </a>
</div>

<!-- Form -->
<div class="form-wrap">
    <div class="card">
        <div class="card-body">
            <form action="<?= $formAction ?>" method="POST">
                <?= csrf_field() ?>

                <!-- Asset -->
                <div class="form-group">
                    <label class="form-label">Asset *</label>
                    <select name="asset_id" class="form-control" required <?= $isEdit ? 'disabled' : '' ?>>
                        <option value="">Select asset…</option>
                        <?php foreach ($assets as $a): ?>
                            <option value="<?= $a['id'] ?>" <?= $selectedAsset == $a['id'] ? 'selected' : '' ?>>
                                <?= esc($a['name']) ?> (<?= esc($a['asset_tag']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <?php if ($isEdit): ?>
                        <input type="hidden" name="asset_id" value="<?= $log['asset_id'] ?>">
                    <?php endif; ?>
                </div>

                <!-- Type & Status -->
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Maintenance Type *</label>
                        <select name="type" class="form-control" required>
                            <?php foreach ($types as $value => $label): ?>
                                <option value="<?= $value ?>"
                                    <?= old('type', $log['type'] ?? '') === $value ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-control" required>
                            <?php foreach ($statuses as $value => $label): ?>
                                <option value="<?= $value ?>"
                                    <?= old('status', $log['status'] ?? 'scheduled') === $value ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Technician -->
                <div class="form-group">
                    <label class="form-label">Technician *</label>
                    <input type="text"
                           name="technician"
                           class="form-control"
                           value="<?= old('technician', $log['technician'] ?? '') ?>"
                           placeholder="e.g. Juan dela Cruz"
                           required>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label class="form-label">Description *</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3"
                              placeholder="Describe the maintenance work…"
                              required><?= old('description', $log['description'] ?? '') ?></textarea>
                </div>

                <!-- Cost & Scheduled Date -->
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Cost (₱)</label>
                        <input type="number"
                               name="cost"
                               class="form-control"
                               step="0.01"
                               min="0"
                               value="<?= old('cost', $log['cost'] ?? 0) ?>"
                               placeholder="0.00">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Scheduled Date</label>
                        <input type="date"
                               name="scheduled_at"
                               class="form-control"
                               value="<?= old('scheduled_at', $log['scheduled_at'] ?? '') ?>">
                    </div>
                </div>

                <!-- Completed Date -->
                <div class="form-group">
                    <label class="form-label">Completed Date</label>
                    <input type="date"
                           name="completed_at"
                           class="form-control"
                           value="<?= old('completed_at', $log['completed_at'] ?? '') ?>">
                    <div class="form-hint">Fill this when status is set to Completed</div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <?= $isEdit ? 'Update Log' : 'Save Log' ?>
                    </button>
                    <a href="<?= base_url('maintenance') ?>" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
$page_title = 'New Transaction';

$types = [
    'checkout' => 'Check-Out',
    'checkin'  => 'Check-In',
    'transfer' => 'Transfer',
];
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title">New Transaction</div>
        <div class="page-sub">Record an asset check-in, check-out, or transfer</div>
    </div>

    <a href="<?= base_url('transactions') ?>" class="btn btn-secondary">
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
            <form action="<?= base_url('transactions') ?>" method="POST">
                <?= csrf_field() ?>

                <!-- Asset -->
                <div class="form-group">
                    <label class="form-label">Asset *</label>
                    <select name="asset_id" id="assetSelect" class="form-control" required>
                        <option value="">Select asset…</option>
                        <?php foreach ($assets as $a): ?>
                            <option value="<?= $a['id'] ?>"
                                    data-qty="<?= $a['quantity'] ?>"
                                    data-loc="<?= esc($a['location'] ?? '') ?>"
                                    <?= old('asset_id') == $a['id'] ? 'selected' : '' ?>>
                                <?= esc($a['name']) ?> (<?= esc($a['asset_tag']) ?>) — Qty: <?= $a['quantity'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Type & Quantity -->
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Transaction Type *</label>
                        <select name="type" class="form-control" required>
                            <?php foreach ($types as $value => $label): ?>
                                <option value="<?= $value ?>" <?= old('type') === $value ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Quantity *</label>
                        <input type="number"
                               name="quantity"
                               class="form-control"
                               value="<?= old('quantity', 1) ?>"
                               min="1"
                               required>
                    </div>
                </div>

                <!-- Locations -->
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">From Location</label>
                        <input type="text"
                               name="from_location"
                               id="fromLocation"
                               class="form-control"
                               value="<?= old('from_location') ?>"
                               placeholder="e.g. IT Room A">
                    </div>

                    <div class="form-group">
                        <label class="form-label">To Location</label>
                        <input type="text"
                               name="to_location"
                               class="form-control"
                               value="<?= old('to_location') ?>"
                               placeholder="e.g. Office 3B">
                    </div>
                </div>

                <!-- Assigned To -->
                <div class="form-group">
                    <label class="form-label">Assigned To</label>
                    <input type="text"
                           name="assigned_to"
                           class="form-control"
                           value="<?= old('assigned_to') ?>"
                           placeholder="e.g. Maria Santos">
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes"
                              class="form-control"
                              rows="2"
                              placeholder="Optional notes…"><?= old('notes') ?></textarea>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Record Transaction</button>
                    <a href="<?= base_url('transactions') ?>" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('assetSelect').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        document.getElementById('fromLocation').value = selected.dataset.loc || '';
    });
</script>

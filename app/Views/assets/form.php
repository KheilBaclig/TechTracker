<?php
$isEdit     = (bool) $asset;
$page_title = $isEdit ? 'Edit Asset' : 'New Asset';
$formAction = $isEdit ? base_url('assets/' . $asset['id']) : base_url('assets');

$statuses = [
    'active'            => 'Active',
    'under_maintenance' => 'Under Maintenance',
    'retired'           => 'Retired',
    'disposed'          => 'Disposed',
];
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title"><?= $isEdit ? 'Edit Asset' : 'New Asset' ?></div>
        <div class="page-sub"><?= $isEdit ? 'Update asset details' : 'Register a new hardware asset' ?></div>
    </div>

    <a href="<?= base_url('assets') ?>" class="btn btn-secondary">
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
            <form action="<?= $formAction ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Section: Basic Information -->
                <div class="form-section-title">Basic Information</div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Asset Name *</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="<?= old('name', $asset['name'] ?? '') ?>"
                               placeholder="e.g. Dell Latitude 5520"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Asset Tag *</label>
                        <input type="text"
                               name="asset_tag"
                               class="form-control"
                               value="<?= old('asset_tag', $asset['asset_tag'] ?? '') ?>"
                               placeholder="e.g. TT-2024-001"
                               required>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select category…</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"
                                    <?= old('category_id', $asset['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                    <?= esc($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-control" required>
                            <?php foreach ($statuses as $value => $label): ?>
                                <option value="<?= $value ?>"
                                    <?= old('status', $asset['status'] ?? 'active') === $value ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Brand</label>
                        <input type="text"
                               name="brand"
                               class="form-control"
                               value="<?= old('brand', $asset['brand'] ?? '') ?>"
                               placeholder="e.g. Dell">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Model</label>
                        <input type="text"
                               name="model"
                               class="form-control"
                               value="<?= old('model', $asset['model'] ?? '') ?>"
                               placeholder="e.g. Latitude 5520">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Serial Number</label>
                        <input type="text"
                               name="serial_number"
                               class="form-control"
                               value="<?= old('serial_number', $asset['serial_number'] ?? '') ?>"
                               placeholder="e.g. SN-ABC123">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Location</label>
                        <input type="text"
                               name="location"
                               class="form-control"
                               value="<?= old('location', $asset['location'] ?? '') ?>"
                               placeholder="e.g. IT Room A">
                    </div>
                </div>

                <!-- Section: Quantity & Purchase -->
                <div class="form-section-title">Quantity &amp; Purchase</div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Quantity *</label>
                        <input type="number"
                               name="quantity"
                               class="form-control"
                               value="<?= old('quantity', $asset['quantity'] ?? 1) ?>"
                               min="0"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Low Stock Threshold</label>
                        <input type="number"
                               name="low_stock_threshold"
                               class="form-control"
                               value="<?= old('low_stock_threshold', $asset['low_stock_threshold'] ?? 2) ?>"
                               min="0">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Purchase Date</label>
                        <input type="date"
                               name="purchase_date"
                               class="form-control"
                               value="<?= old('purchase_date', $asset['purchase_date'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Purchase Cost (₱)</label>
                        <input type="number"
                               name="purchase_cost"
                               class="form-control"
                               step="0.01"
                               min="0"
                               value="<?= old('purchase_cost', $asset['purchase_cost'] ?? '') ?>"
                               placeholder="0.00">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Warranty Expiry</label>
                        <input type="date"
                               name="warranty_expiry"
                               class="form-control"
                               value="<?= old('warranty_expiry', $asset['warranty_expiry'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Assigned To</label>
                        <input type="text"
                               name="assigned_to"
                               class="form-control"
                               value="<?= old('assigned_to', $asset['assigned_to'] ?? '') ?>"
                               placeholder="e.g. Juan dela Cruz">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description / Notes</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Additional notes…"><?= old('notes', $asset['notes'] ?? '') ?></textarea>
                </div>

                <!-- Section: Image -->
                <div class="form-group">
                    <label class="form-label">Asset Image</label>

                    <?php if (!empty($asset['image'])): ?>
                        <div class="current-image">
                            <img src="<?= base_url('uploads/assets/' . $asset['image']) ?>" alt="Current asset image">
                        </div>
                    <?php endif; ?>

                    <input type="file" name="image" class="form-control" accept="image/*">
                    <div class="form-hint">JPG, PNG, WebP — resized to 800×600px</div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <?= $isEdit ? 'Update Asset' : 'Create Asset' ?>
                    </button>
                    <a href="<?= base_url('assets') ?>" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

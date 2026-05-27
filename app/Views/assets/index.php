<?php $page_title = 'Assets'; ?>

<?php
$isManager = in_array(session()->get('user_role'), ['superadmin', 'manager']);
$statuses  = [
    'active'            => 'Active',
    'under_maintenance' => 'Under Maintenance',
    'retired'           => 'Retired',
    'disposed'          => 'Disposed',
];
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title">Assets</div>
        <div class="page-sub"><?= number_format($total) ?> assets in inventory</div>
    </div>

    <?php if ($isManager): ?>
        <a href="<?= base_url('assets/new') ?>" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add Asset
        </a>
    <?php endif; ?>
</div>

<!-- Filters -->
<div class="card mb-16">
    <div class="card-body">
        <form method="GET" class="filter-bar">
            <div class="search-bar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" placeholder="Search assets, tags, brands…" value="<?= esc($search ?? '') ?>">
            </div>

            <select name="category" class="form-control filter-select">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($category ?? '') == $cat['id'] ? 'selected' : '' ?>>
                        <?= esc($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="status" class="form-control filter-select">
                <option value="">All Statuses</option>
                <?php foreach ($statuses as $value => $label): ?>
                    <option value="<?= $value ?>" <?= ($status ?? '') === $value ? 'selected' : '' ?>>
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

            <?php if ($search || $category || $status): ?>
                <a href="<?= base_url('assets') ?>" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Assets Table -->
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Asset</th>
                    <th>Tag</th>
                    <th>Category</th>
                    <th>Brand / Model</th>
                    <th>Location</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($assets)): ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                                    <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                                </svg>
                                <p>No assets found</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($assets as $a): ?>
                        <?php $isLowStock = ($a['quantity'] ?? 0) <= $a['low_stock_threshold']; ?>
                        <tr>
                            <td>
                                <div class="asset-cell">
                                    <div class="asset-thumb">
                                        <?php if ($a['image']): ?>
                                            <img src="<?= base_url('uploads/assets/' . $a['image']) ?>" alt="">
                                        <?php else: ?>
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <rect x="2" y="7" width="20" height="14" rx="2"/>
                                                <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="asset-name"><?= esc($a['name']) ?></div>
                                        <?php if ($a['serial_number']): ?>
                                            <div class="asset-serial">S/N: <?= esc($a['serial_number']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td><span class="mono-tag"><?= esc($a['asset_tag']) ?></span></td>
                            <td class="text-muted"><?= esc($a['category_name'] ?? '—') ?></td>
                            <td><?= esc($a['brand'] ?? '—') ?><?= $a['model'] ? ' / ' . esc($a['model']) : '' ?></td>
                            <td class="text-muted"><?= esc($a['location'] ?? '—') ?></td>
                            <td>
                                <span class="<?= $isLowStock ? 'badge badge-low' : 'qty-value' ?>">
                                    <?= $a['quantity'] ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-<?= $a['status'] ?>">
                                    <?= ucfirst(str_replace('_', ' ', $a['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?= base_url('assets/' . $a['id']) ?>"
                                       class="btn btn-secondary btn-sm btn-icon"
                                       title="View">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>

                                    <?php if ($isManager): ?>
                                        <a href="<?= base_url('assets/' . $a['id'] . '/edit') ?>"
                                           class="btn btn-secondary btn-sm btn-icon"
                                           title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </a>

                                        <form action="<?= base_url('assets/' . $a['id'] . '/delete') ?>"
                                              method="POST"
                                              onsubmit="return confirm('Delete this asset?')">
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

// End of file: app/Views/assets/index.php
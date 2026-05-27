<?php
$page_title = 'Categories';
$isManager  = in_array(session()->get('user_role'), ['superadmin', 'manager']);
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title">Categories</div>
        <div class="page-sub">Organize assets by type</div>
    </div>

    <?php if ($isManager): ?>
        <a href="<?= base_url('categories/new') ?>" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add Category
        </a>
    <?php endif; ?>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Assets</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                                </svg>
                                <p>No categories yet</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $c): ?>
                        <tr>
                            <td>
                                <div class="cat-name-cell">
                                    <div class="cat-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                                        </svg>
                                    </div>
                                    <span class="asset-name"><?= esc($c['name']) ?></span>
                                </div>
                            </td>
                            <td class="text-muted"><?= esc($c['description'] ?? '—') ?></td>
                            <td class="fw-600"><?= $c['asset_count'] ?? 0 ?></td>
                            <td class="text-muted"><?= date('M d, Y', strtotime($c['created_at'])) ?></td>
                            <td>
                                <?php if ($isManager): ?>
                                    <div class="action-btns">
                                        <a href="<?= base_url('categories/' . $c['id'] . '/edit') ?>"
                                           class="btn btn-secondary btn-sm btn-icon"
                                           title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </a>

                                        <form action="<?= base_url('categories/' . $c['id'] . '/delete') ?>"
                                              method="POST"
                                              onsubmit="return confirm('Delete this category?')">
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
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

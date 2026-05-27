<?php
$isEdit     = (bool) $category;
$page_title = $isEdit ? 'Edit Category' : 'New Category';
$formAction = $isEdit ? base_url('categories/' . $category['id']) : base_url('categories');
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title"><?= $isEdit ? 'Edit Category' : 'New Category' ?></div>
        <div class="page-sub"><?= $isEdit ? 'Update category details' : 'Create a new asset category' ?></div>
    </div>

    <a href="<?= base_url('categories') ?>" class="btn btn-secondary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Back
    </a>
</div>

<!-- Form -->
<div class="form-wrap-sm">
    <div class="card">
        <div class="card-body">
            <form action="<?= $formAction ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label class="form-label">Category Name *</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="<?= old('name', $category['name'] ?? '') ?>"
                           placeholder="e.g. Laptops"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3"
                              placeholder="Brief description…"><?= old('description', $category['description'] ?? '') ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <?= $isEdit ? 'Update' : 'Create' ?> Category
                    </button>
                    <a href="<?= base_url('categories') ?>" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
$isEdit     = (bool) $user;
$page_title = $isEdit ? 'Edit User' : 'New User';
$formAction = $isEdit ? base_url('users/' . $user['id']) : base_url('users');

$roles = [
    'superadmin' => 'Super Admin',
    'manager'    => 'Manager',
    'staff'      => 'Staff',
];
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <div class="page-title"><?= $isEdit ? 'Edit User' : 'New User' ?></div>
        <div class="page-sub"><?= $isEdit ? 'Update user account' : 'Create a new team member account' ?></div>
    </div>

    <a href="<?= base_url('users') ?>" class="btn btn-secondary">
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
                    <label class="form-label">Full Name *</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="<?= old('name', $user['name'] ?? '') ?>"
                           placeholder="e.g. Juan dela Cruz"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="<?= old('email', $user['email'] ?? '') ?>"
                           placeholder="user@techtracker.com"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">Role *</label>
                    <select name="role" class="form-control" required>
                        <?php foreach ($roles as $value => $label): ?>
                            <option value="<?= $value ?>"
                                <?= old('role', $user['role'] ?? '') === $value ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Password
                        <?php if ($isEdit): ?>
                            <span class="form-label-hint">(leave blank to keep current)</span>
                        <?php else: ?>
                            *
                        <?php endif; ?>
                    </label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="••••••••"
                           minlength="6"
                           <?= !$isEdit ? 'required' : '' ?>>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <?= $isEdit ? 'Update User' : 'Create User' ?>
                    </button>
                    <a href="<?= base_url('users') ?>" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

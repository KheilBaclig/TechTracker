<?php $page_title = 'My Profile'; ?>
<div class="page-header">
  <div class="page-header-left">
    <div class="page-title">My Profile</div>
    <div class="page-sub">Manage your account settings</div>
  </div>
</div>

<div style="display:grid;grid-template-columns:280px 1fr;gap:20px;max-width:860px">
  <div class="card" style="align-self:start">
    <div class="card-body" style="text-align:center;padding:28px 20px">
      <div style="width:72px;height:72px;border-radius:50%;background:var(--accent-bg);border:2px solid var(--accent);display:flex;align-items:center;justify-content:center;font-size:1.6rem;font-weight:700;color:var(--accent);margin:0 auto 14px;overflow:hidden">
        <?php if(!empty($user['avatar'])): ?><img src="<?= base_url('uploads/avatars/'.$user['avatar']) ?>" style="width:100%;height:100%;object-fit:cover"><?php else: ?><?= strtoupper(substr($user['name'],0,1)) ?><?php endif; ?>
      </div>
      <div style="font-size:.95rem;font-weight:700;margin-bottom:4px"><?= esc($user['name']) ?></div>
      <div style="font-size:.78rem;color:var(--text-3);margin-bottom:12px"><?= esc($user['email']) ?></div>
      <span class="badge badge-<?= $user['role'] ?>"><?= ucfirst($user['role']) ?></span>
      <?php if($user['api_token']): ?>
        <div style="margin-top:16px;padding:10px;background:var(--surface-2);border-radius:8px;border:1px solid var(--border)">
          <div style="font-size:.63rem;color:var(--text-3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px">API Token</div>
          <div style="font-family:monospace;font-size:.7rem;color:var(--accent);word-break:break-all"><?= substr($user['api_token'],0,24) ?>…</div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><span class="card-title">Edit Profile</span></div>
    <div class="card-body">
      <form action="<?= base_url('profile') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="form-group">
          <label class="form-label">Full Name *</label>
          <input type="text" name="name" class="form-control" value="<?= esc($user['name']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" value="<?= esc($user['email']) ?>" disabled style="opacity:.5;cursor:not-allowed">
        </div>
        <div class="form-group">
          <label class="form-label">Profile Photo</label>
          <input type="file" name="avatar" class="form-control" accept="image/*">
          <div class="form-hint">JPG, PNG — max 2MB</div>
        </div>
        <div class="form-group">
          <label class="form-label">New Password <span style="color:var(--text-3);font-weight:400">(leave blank to keep current)</span></label>
          <input type="password" name="password" class="form-control" placeholder="••••••••" minlength="6">
        </div>
        <div style="display:flex;gap:10px;margin-top:6px">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

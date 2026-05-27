<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In — TechTracker</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
html{-webkit-font-smoothing:antialiased;}
body{font-family:'Inter',sans-serif;display:flex;height:100vh;background:#050506;color:#F4F4F5;}
.panel-left{flex:1;background:linear-gradient(135deg,#0F0F10 0%,#13131A 50%,#0A0A12 100%);position:relative;overflow:hidden;display:flex;flex-direction:column;padding:48px;}
.panel-left::before{content:'';position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=1400&auto=format&fit=crop') center/cover no-repeat;opacity:.08;}
.panel-left::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(99,102,241,.15) 0%,rgba(56,189,248,.08) 100%);}
.pl-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(99,102,241,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(99,102,241,.06) 1px,transparent 1px);background-size:40px 40px;z-index:1;}
.brand-logo{position:relative;z-index:10;display:flex;align-items:center;gap:12px;}
.brand-icon{width:36px;height:36px;background:rgba(99,102,241,.15);border:1px solid rgba(99,102,241,.3);border-radius:10px;display:flex;align-items:center;justify-content:center;}
.brand-icon svg{width:18px;height:18px;color:#818CF8;}
.brand-text{font-size:1.1rem;font-weight:700;letter-spacing:-.4px;color:#F4F4F5;}
.brand-sub{font-size:.65rem;color:#52525B;text-transform:uppercase;letter-spacing:1px;}
.pl-content{position:relative;z-index:10;color:#fff;margin-top:auto;max-width:420px;}
.pl-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;background:rgba(99,102,241,.15);border:1px solid rgba(99,102,241,.25);border-radius:20px;font-size:.7rem;color:#818CF8;font-weight:500;margin-bottom:20px;}
.pl-badge span{width:6px;height:6px;border-radius:50%;background:#818CF8;animation:pulse 2s infinite;}
@keyframes pulse{0%,100%{opacity:1;}50%{opacity:.4;}}
.pl-content h2{font-size:1.6rem;font-weight:700;margin-bottom:10px;letter-spacing:-.5px;line-height:1.25;}
.pl-content p{font-size:.83rem;font-weight:300;opacity:.65;line-height:1.65;}
.pl-stats{display:flex;gap:24px;margin-top:28px;}
.pl-stat .val{font-size:1.3rem;font-weight:700;color:#818CF8;}
.pl-stat .lbl{font-size:.68rem;color:#52525B;margin-top:2px;}
</style>
</head>
<body>
<div class="panel-left">
  <div class="pl-grid"></div>
  <div class="brand-logo">
    <div class="brand-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg></div>
    <div><div class="brand-text">TechTracker</div><div class="brand-sub">Asset Management</div></div>
  </div>
  <div class="pl-content">
    <div class="pl-badge"><span></span>Live System</div>
    <h2>Manage Your Tech Assets with Precision</h2>
    <p>A centralized platform for hardware inventory, maintenance tracking, and real-time asset availability — built for modern IT teams.</p>
    <div class="pl-stats">
      <div class="pl-stat"><div class="val">100%</div><div class="lbl">Uptime</div></div>
      <div class="pl-stat"><div class="val">RBAC</div><div class="lbl">Role-Based Access</div></div>
      <div class="pl-stat"><div class="val">REST</div><div class="lbl">API Ready</div></div>
    </div>
  </div>
</div>
<style>
.panel-right{width:100%;max-width:520px;display:flex;flex-direction:column;justify-content:center;padding:0 72px;background:#050506;position:relative;}
.form-header{margin-bottom:36px;}
.form-header h1{font-size:1.7rem;font-weight:700;letter-spacing:-.5px;margin-bottom:6px;color:#F4F4F5;}
.form-header p{font-size:.85rem;color:#52525B;}
.form-group{margin-bottom:18px;}
.form-label{display:block;font-size:.78rem;font-weight:500;margin-bottom:7px;color:#A1A1AA;}
.form-control{width:100%;padding:12px 14px;border-radius:9px;border:1px solid #27272A;font-size:.9rem;font-family:'Inter',sans-serif;transition:all .2s;background:#0F0F10;color:#F4F4F5;}
.form-control:focus{outline:none;border-color:#818CF8;box-shadow:0 0 0 3px rgba(99,102,241,.2);}
.form-control::placeholder{color:#3F3F46;}
.btn-submit{width:100%;padding:13px;border-radius:9px;border:none;background:#6366F1;color:#fff;font-size:.9rem;font-weight:600;cursor:pointer;transition:all .2s;font-family:'Inter',sans-serif;letter-spacing:-.1px;}
.btn-submit:hover{background:#818CF8;box-shadow:0 0 0 3px rgba(99,102,241,.25);}
.btn-submit:active{transform:scale(.99);}
.alert{padding:11px 14px;border-radius:8px;margin-bottom:18px;font-size:.82rem;font-weight:500;background:rgba(248,113,113,.1);color:#FCA5A5;border:1px solid rgba(248,113,113,.2);}
.demo-creds{margin-top:36px;padding-top:20px;border-top:1px solid #18181B;}
.dc-title{font-size:.65rem;font-weight:600;color:#3F3F46;text-transform:uppercase;letter-spacing:1px;margin-bottom:10px;}
.dc-row{display:flex;justify-content:space-between;align-items:center;font-size:.78rem;padding:7px 0;border-bottom:1px solid #0F0F10;}
.dc-row:last-child{border-bottom:none;}
.dc-role{font-weight:600;color:#A1A1AA;}
.dc-cred{font-family:monospace;color:#52525B;font-size:.75rem;}
.dc-badge{padding:2px 7px;border-radius:4px;font-size:.6rem;font-weight:600;text-transform:uppercase;}
.dc-badge.sa{background:rgba(129,140,248,.12);color:#818CF8;}
.dc-badge.mg{background:rgba(56,189,248,.12);color:#38BDF8;}
.dc-badge.st{background:rgba(255,255,255,.06);color:#71717A;}
@media(max-width:900px){.panel-left{display:none;}.panel-right{max-width:100%;padding:0 36px;}}
</style>

<div class="panel-right">
  <div class="form-header">
    <h1>Welcome back</h1>
    <p>Sign in to your TechTracker account</p>
  </div>
  <?php if(session()->getFlashdata('error')): ?>
    <div class="alert"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>
  <?php if(session()->getFlashdata('errors')): ?>
    <div class="alert"><?php foreach((array)session()->getFlashdata('errors') as $e) echo '<div>'.esc($e).'</div>'; ?></div>
  <?php endif; ?>
  <form action="<?= base_url('login') ?>" method="POST">
    <?= csrf_field() ?>
    <div class="form-group">
      <label class="form-label">Email Address</label>
      <input type="email" name="email" class="form-control" placeholder="you@techtracker.com" required autofocus>
    </div>
    <div class="form-group">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="••••••••" required>
    </div>
    <button type="submit" class="btn-submit">Sign In →</button>
  </form>
</div>
</body>
</html>

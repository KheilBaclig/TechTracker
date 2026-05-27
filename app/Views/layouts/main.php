<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>TechTracker — <?= $page_title ?? 'Dashboard' ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
:root {
  --sb-bg:#0A0A0B;--sb-border:rgba(255,255,255,.06);--sb-text:#71717A;--sb-text-hover:#FAFAFA;
  --sb-active-bg:rgba(99,102,241,.12);--sb-active-text:#818CF8;--sb-label:#3F3F46;--sb-w:224px;--sb-collapsed:60px;
  --bg:#050506;--surface:#0F0F10;--surface-2:#18181B;--border:rgba(255,255,255,.07);--border-2:rgba(255,255,255,.13);
  --text:#F4F4F5;--text-2:#A1A1AA;--text-3:#52525B;
  --accent:#818CF8;--accent-bg:rgba(99,102,241,.12);--accent-glow:rgba(99,102,241,.25);
  --success:#34D399;--success-bg:rgba(52,211,153,.1);
  --warning:#FBBF24;--warning-bg:rgba(251,191,36,.1);
  --danger:#F87171;--danger-bg:rgba(248,113,113,.1);
  --info:#38BDF8;--info-bg:rgba(56,189,248,.1);
  --radius:8px;--radius-lg:12px;--shadow:0 4px 24px rgba(0,0,0,.6);--ease:cubic-bezier(.16,1,.3,1);--t:all .2s var(--ease);
}
body.light-mode {
  --bg:#F1F5F9;--surface:#FFFFFF;--surface-2:#F8FAFC;--border:#E2E8F0;--border-2:#CBD5E1;
  --text:#0F172A;--text-2:#475569;--text-3:#94A3B8;--accent:#6366F1;--accent-bg:rgba(99,102,241,.08);
  --sb-bg:#FFFFFF;--sb-border:#E2E8F0;--sb-text:#64748B;--sb-text-hover:#0F172A;
  --sb-active-bg:rgba(99,102,241,.08);--sb-active-text:#6366F1;--sb-label:#94A3B8;
  color-scheme:light;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{font-size:14px;-webkit-font-smoothing:antialiased;color-scheme:dark;}
body{font-family:'Inter',-apple-system,sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh;line-height:1.5;}
svg{max-width:100%;height:auto;}
</style>
</head>
<body>
<?php // Sidebar & layout — continued in part 2 via append ?>
<style>
.sidebar{width:var(--sb-w);min-height:100vh;background:var(--sb-bg);display:flex;flex-direction:column;position:fixed;top:0;left:0;z-index:200;transition:width .3s var(--ease);border-right:1px solid var(--sb-border);}
.sidebar.collapsed{width:var(--sb-collapsed);}
.sb-brand{display:flex;align-items:center;gap:12px;padding:20px 16px;border-bottom:1px solid var(--sb-border);white-space:nowrap;}
.sb-logo-icon{width:28px;height:28px;flex-shrink:0;background:var(--accent-bg);border-radius:8px;display:flex;align-items:center;justify-content:center;}
.sb-logo-icon svg{width:16px;height:16px;color:var(--accent);}
.sb-title{font-size:.9rem;font-weight:700;letter-spacing:-.4px;color:var(--text);}
.sb-subtitle{font-size:.6rem;color:var(--text-3);letter-spacing:.5px;text-transform:uppercase;}
.sb-user{display:flex;align-items:center;gap:10px;padding:10px 12px;margin:8px 8px 0;border-radius:var(--radius);white-space:nowrap;transition:var(--t);}
.sb-user:hover{background:var(--sb-active-bg);}
.sb-avatar{width:28px;height:28px;border-radius:50%;background:var(--accent-bg);color:var(--accent);display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;flex-shrink:0;overflow:hidden;}
.sb-avatar img{width:100%;height:100%;object-fit:cover;border-radius:50%;}
.sb-user-info .sb-user-name{font-size:.78rem;font-weight:600;color:var(--text);}
.sb-user-info .sb-user-role{font-size:.65rem;color:var(--text-3);text-transform:capitalize;}
.sidebar.collapsed .sb-brand{justify-content:center;padding:20px 0;}
.sidebar.collapsed .sb-title,.sidebar.collapsed .sb-subtitle,.sidebar.collapsed .sb-user-info{display:none;}
.sidebar.collapsed .sb-user{justify-content:center;padding:10px 0;}
.sb-nav{flex:1;padding:12px 8px;overflow-y:auto;overflow-x:hidden;}
.sb-nav::-webkit-scrollbar{width:0;}
.sb-section-label{font-size:.58rem;font-weight:600;color:var(--sb-label);text-transform:uppercase;letter-spacing:1px;padding:12px 10px 4px;white-space:nowrap;transition:var(--t);}
.sidebar.collapsed .sb-section-label{opacity:0;padding:0;height:0;overflow:hidden;}
.sb-item a{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:6px;color:var(--sb-text);text-decoration:none;font-size:.8rem;font-weight:500;transition:var(--t);white-space:nowrap;position:relative;}
.sb-item a:hover{background:var(--sb-active-bg);color:var(--sb-text-hover);}
.sb-item a.active{background:var(--sb-active-bg);color:var(--sb-active-text);}
.sb-icon{width:18px;height:18px;flex-shrink:0;display:flex;align-items:center;justify-content:center;}
.sb-icon svg{width:15px;height:15px;stroke-width:2;}
.sidebar.collapsed .sb-item a{justify-content:center;padding:8px 0;}
.sidebar.collapsed .sb-label{display:none;}
.sidebar.collapsed .sb-item a::after{content:attr(data-tip);position:absolute;left:calc(100% + 10px);background:#1C1C1E;color:#fff;padding:5px 10px;border-radius:6px;font-size:.75rem;border:1px solid #333;opacity:0;pointer-events:none;transition:opacity .15s;white-space:nowrap;z-index:100;}
.sidebar.collapsed .sb-item a:hover::after{opacity:1;}
.sb-footer{padding:8px;border-top:1px solid var(--sb-border);}
.sb-footer a{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:6px;color:var(--sb-text);text-decoration:none;font-size:.8rem;font-weight:500;transition:var(--t);}
.sb-footer a:hover{background:var(--danger-bg);color:var(--danger);}
.sb-footer a svg{width:15px;height:15px;}
.sidebar.collapsed .sb-footer a{justify-content:center;padding:8px 0;}
.sidebar.collapsed .sb-footer .sb-label{display:none;}
.sb-toggle{position:fixed;top:18px;left:calc(var(--sb-w) - 12px);width:24px;height:24px;border-radius:50%;background:var(--surface-2);border:1px solid var(--border-2);display:flex;align-items:center;justify-content:center;cursor:pointer;z-index:300;color:var(--text-2);transition:left .3s var(--ease),background .2s;}
.sb-toggle:hover{background:var(--surface);color:var(--text);}
.sb-toggle svg{width:12px;height:12px;stroke-width:2.5;transition:transform .3s;}
body.sb-collapsed .sb-toggle{left:calc(var(--sb-collapsed) - 12px);}
body.sb-collapsed .sb-toggle svg{transform:rotate(180deg);}
</style>
<style>
.main-wrap{margin-left:var(--sb-w);flex:1;display:flex;flex-direction:column;transition:margin-left .3s var(--ease);min-width:0;}
body.sb-collapsed .main-wrap{margin-left:var(--sb-collapsed);}
.topbar{height:58px;padding:0 28px;background:rgba(5,5,6,.85);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;}
body.light-mode .topbar{background:rgba(255,255,255,.9);}
.topbar-title{font-size:.88rem;font-weight:600;letter-spacing:-.2px;color:var(--text-2);}
.topbar-right{display:flex;align-items:center;gap:6px;}
.theme-toggle{background:transparent;border:none;cursor:pointer;color:var(--text-2);display:flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;transition:var(--t);}
.theme-toggle:hover{color:var(--text);background:var(--surface-2);}
.theme-toggle svg{width:16px;height:16px;}
.topbar-user{display:flex;align-items:center;gap:8px;padding:4px 10px 4px 6px;background:var(--surface);border:1px solid var(--border);border-radius:20px;cursor:pointer;text-decoration:none;transition:var(--t);}
.topbar-user:hover{border-color:var(--border-2);}
.tu-av{width:22px;height:22px;border-radius:50%;background:var(--accent-bg);display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:var(--accent);overflow:hidden;}
.tu-av img{width:100%;height:100%;object-fit:cover;}
.tu-name{font-size:.75rem;color:var(--text);font-weight:500;}
.page-content{flex:1;padding:28px;max-width:100%;min-width:0;}
.alert{padding:11px 16px;border-radius:var(--radius);margin-bottom:20px;font-size:.8rem;font-weight:500;display:flex;align-items:center;gap:10px;border:1px solid transparent;}
.alert svg{width:15px;height:15px;flex-shrink:0;}
.alert-success{background:var(--success-bg);color:#6EE7B7;border-color:rgba(52,211,153,.2);}
.alert-error{background:var(--danger-bg);color:#FCA5A5;border-color:rgba(248,113,113,.2);}
.card{background:var(--surface);border-radius:var(--radius-lg);border:1px solid var(--border);}
.card-header{padding:16px 20px 0;display:flex;align-items:center;justify-content:space-between;}
.card-title{font-size:.83rem;font-weight:600;letter-spacing:-.1px;}
.card-body{padding:16px 20px;}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(175px,1fr));gap:14px;margin-bottom:22px;}
.stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);padding:18px;position:relative;overflow:hidden;}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:var(--accent-line,var(--accent));opacity:.6;}
.stat-icon{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;margin-bottom:14px;}
.stat-icon svg{width:16px;height:16px;stroke-width:2;}
.stat-icon.blue{background:rgba(56,189,248,.12);color:#38BDF8;}
.stat-icon.green{background:rgba(52,211,153,.12);color:#34D399;}
.stat-icon.orange{background:rgba(251,191,36,.12);color:#FBBF24;}
.stat-icon.red{background:rgba(248,113,113,.12);color:#F87171;}
.stat-icon.purple{background:rgba(129,140,248,.12);color:#818CF8;}
.stat-icon.teal{background:rgba(45,212,191,.12);color:#2DD4BF;}
.stat-label{font-size:.72rem;color:var(--text-2);font-weight:500;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;}
.stat-value{font-size:1.75rem;font-weight:700;color:var(--text);letter-spacing:-1px;line-height:1;}
.stat-sub{font-size:.7rem;color:var(--text-3);margin-top:5px;}
</style>
<style>
.table-wrap{overflow-x:auto;}
table{width:100%;border-collapse:collapse;font-size:.8rem;}
thead th{padding:11px 16px;text-align:left;font-size:.63rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;color:var(--text-3);border-bottom:1px solid var(--border);}
tbody tr{border-bottom:1px solid var(--border);transition:background .15s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:rgba(255,255,255,.02);}
body.light-mode tbody tr:hover{background:rgba(0,0,0,.02);}
tbody td{padding:13px 16px;vertical-align:middle;}
.badge{display:inline-flex;align-items:center;padding:2px 8px;border-radius:4px;font-size:.63rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;}
.badge-active{background:var(--success-bg);color:var(--success);}
.badge-inactive,.badge-retired,.badge-disposed{background:rgba(255,255,255,.05);color:var(--text-3);}
.badge-under_maintenance{background:var(--warning-bg);color:var(--warning);}
.badge-superadmin{background:var(--accent-bg);color:var(--accent);}
.badge-manager{background:var(--info-bg);color:var(--info);}
.badge-staff{background:rgba(255,255,255,.06);color:var(--text-2);}
.badge-checkout{background:var(--warning-bg);color:var(--warning);}
.badge-checkin{background:var(--success-bg);color:var(--success);}
.badge-transfer{background:var(--info-bg);color:var(--info);}
.badge-low{background:var(--danger-bg);color:var(--danger);}
.badge-scheduled{background:var(--info-bg);color:var(--info);}
.badge-in_progress{background:var(--warning-bg);color:var(--warning);}
.badge-completed{background:var(--success-bg);color:var(--success);}
.badge-cancelled{background:rgba(255,255,255,.05);color:var(--text-3);}
.btn{display:inline-flex;align-items:center;gap:7px;height:34px;padding:0 14px;border-radius:8px;font-size:.8rem;font-weight:500;border:none;cursor:pointer;transition:var(--t);font-family:'Inter',sans-serif;text-decoration:none;white-space:nowrap;}
.btn:active{transform:scale(.98);}
.btn svg{width:14px;height:14px;stroke-width:2;flex-shrink:0;}
.btn-primary{background:var(--accent);color:#fff;}
.btn-primary:hover{background:#6366F1;box-shadow:0 0 0 3px var(--accent-glow);}
.btn-secondary{background:var(--surface-2);color:var(--text);border:1px solid var(--border-2);}
.btn-secondary:hover{border-color:var(--text-3);}
.btn-danger{background:var(--danger-bg);color:var(--danger);}
.btn-danger:hover{background:rgba(248,113,113,.2);}
.btn-success{background:var(--success-bg);color:var(--success);}
.btn-sm{height:28px;padding:0 10px;font-size:.75rem;border-radius:6px;}
.btn-icon{width:34px;padding:0;justify-content:center;}
.btn-icon.btn-sm{width:28px;}
.form-group{margin-bottom:16px;}
.form-label{display:block;font-size:.78rem;font-weight:500;margin-bottom:6px;color:var(--text);}
.form-control{width:100%;padding:9px 13px;border-radius:8px;background:var(--surface-2);border:1px solid var(--border-2);color:var(--text);font-family:'Inter',sans-serif;font-size:.85rem;transition:var(--t);outline:none;}
.form-control:focus{border-color:var(--accent);box-shadow:0 0 0 2px var(--accent-glow);}
.form-control::placeholder{color:var(--text-3);}
.form-hint{font-size:.7rem;color:var(--text-3);margin-top:4px;}
.form-error{font-size:.7rem;color:var(--danger);margin-top:4px;}
.form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:14px;}
.page-header-left .page-title{font-size:1.35rem;font-weight:700;letter-spacing:-.5px;}
.page-header-left .page-sub{font-size:.78rem;color:var(--text-2);margin-top:3px;}
.search-bar{display:flex;align-items:center;gap:8px;padding:0 12px;height:34px;background:var(--surface-2);border:1px solid var(--border-2);border-radius:8px;}
.search-bar:focus-within{border-color:var(--accent);}
.search-bar input{border:none;background:transparent;color:var(--text);outline:none;font-size:.8rem;width:200px;font-family:'Inter',sans-serif;}
.search-bar svg{width:14px;height:14px;color:var(--text-3);flex-shrink:0;}
.empty-state{text-align:center;padding:44px 20px;color:var(--text-2);}
.empty-state svg{width:40px;height:40px;margin:0 auto 12px;stroke-width:1.5;color:var(--text-3);display:block;}
.empty-state p{font-size:.83rem;}
.asset-thumb{width:42px;height:42px;border-radius:8px;background:var(--surface-2);display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;border:1px solid var(--border);}
.asset-thumb img{width:100%;height:100%;object-fit:cover;}
.asset-thumb svg{width:20px;height:20px;color:var(--text-3);}
@media(max-width:768px){.stats-grid{grid-template-columns:1fr 1fr;}.sidebar{transform:translateX(-100%);}.main-wrap{margin-left:0!important;}.form-grid-2{grid-template-columns:1fr;}}

/* Utility */
.mb-16{margin-bottom:16px;}
.text-muted{color:var(--text-2);font-size:.8rem;}
.fw-600{font-weight:600;}
.capitalize{text-transform:capitalize;}
.mono-tag{font-family:monospace;font-size:.78rem;color:var(--accent);}
.btn-group{display:flex;gap:8px;}
.action-btns{display:flex;gap:4px;align-items:center;}
.pager-wrap{padding:12px 16px;border-top:1px solid var(--border);}

/* Filter bar */
.filter-bar{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.filter-select{width:170px;}

/* Asset cell */
.asset-cell{display:flex;align-items:center;gap:11px;}
.asset-name{font-weight:600;font-size:.83rem;}
.asset-serial{font-size:.7rem;color:var(--text-3);}
.qty-value{font-weight:600;}

/* Form */
.form-wrap{max-width:800px;}
.form-section-title{font-size:.7rem;font-weight:600;color:var(--text-3);text-transform:uppercase;letter-spacing:1px;margin:18px 0 14px;}
.form-section-title:first-child{margin-top:0;}
.form-actions{display:flex;gap:10px;margin-top:8px;}
.current-image img{width:72px;height:72px;object-fit:cover;border-radius:8px;border:1px solid var(--border);margin-bottom:10px;}

/* Asset show */
.show-layout{display:grid;grid-template-columns:260px 1fr;gap:18px;}
.show-sidebar{display:flex;flex-direction:column;gap:14px;}
.show-main{display:flex;flex-direction:column;gap:14px;}
.asset-image-wrap{aspect-ratio:1;background:var(--surface-2);border-radius:12px 12px 0 0;overflow:hidden;display:flex;align-items:center;justify-content:center;}
.asset-image-wrap img{width:100%;height:100%;object-fit:cover;}
.asset-image-wrap svg{width:56px;height:56px;color:var(--text-3);stroke-width:1.5;}
.asset-status-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;}
.asset-qty{font-size:.8rem;font-weight:700;color:var(--text);}
.asset-cost{font-size:1.3rem;font-weight:700;color:var(--accent);letter-spacing:-.5px;}
.asset-cost-label{font-size:.7rem;color:var(--text-3);}
.detail-row{display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--border);font-size:.78rem;}
.detail-row:last-child{border-bottom:none;}
.detail-label{color:var(--text-3);}
.detail-value{font-weight:500;text-align:right;max-width:140px;}
@media(max-width:768px){.show-layout{grid-template-columns:1fr;}.filter-select{width:100%;}}

/* Maintenance show */
.fw-500{font-weight:500;}
.log-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--border);}
.log-asset-name{font-size:1rem;font-weight:700;}
.log-asset-tag{font-size:.78rem;color:var(--text-3);margin-top:2px;}
.detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:0;}
.detail-block{padding:10px 0;border-bottom:1px solid var(--border);}
.detail-block-label{font-size:.68rem;color:var(--text-3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px;}
.detail-block-value{font-size:.85rem;font-weight:500;}
.log-description-wrap{margin-top:18px;}
.log-description{font-size:.85rem;line-height:1.65;color:var(--text-2);background:var(--surface-2);padding:14px;border-radius:8px;border:1px solid var(--border);margin-top:8px;}
@media(max-width:768px){.detail-grid{grid-template-columns:1fr;}}

/* Categories */
.cat-name-cell{display:flex;align-items:center;gap:10px;}
.cat-icon{width:32px;height:32px;border-radius:8px;background:var(--accent-bg);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.cat-icon svg{width:14px;height:14px;color:var(--accent);}

/* Users */
.user-cell{display:flex;align-items:center;gap:10px;}
.user-avatar{width:34px;height:34px;border-radius:50%;background:var(--accent-bg);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;color:var(--accent);flex-shrink:0;overflow:hidden;}
.user-avatar img{width:100%;height:100%;object-fit:cover;}
.api-token{font-family:monospace;font-size:.7rem;color:var(--text-3);}

/* Form sizes */
.form-wrap-sm{max-width:500px;}
.form-label-hint{font-size:.75rem;font-weight:400;color:var(--text-3);}
</style>

<aside class="sidebar" id="sidebar">
  <div class="sb-brand">
    <div class="sb-logo-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="3" width="7" height="7" rx="1.5"/><rect x="15" y="3" width="7" height="7" rx="1.5"/><rect x="2" y="14" width="7" height="7" rx="1.5"/><path d="M15 17.5h7M18.5 14v7"/></svg>
    </div>
    <div><div class="sb-title">TechTracker</div><div class="sb-subtitle">Asset Management</div></div>
  </div>
  <div class="sb-user">
    <div class="sb-avatar">
      <?php if(!empty($userAvatar)): ?><img src="<?= base_url('uploads/avatars/'.$userAvatar) ?>" alt=""><?php else: ?><?= strtoupper(substr($userName??'U',0,1)) ?><?php endif; ?>
    </div>
    <div class="sb-user-info">
      <div class="sb-user-name"><?= esc($userName??'') ?></div>
      <div class="sb-user-role"><?= esc($userRole??'') ?></div>
    </div>
  </div>
  <nav class="sb-nav">
    <div class="sb-section-label">Overview</div>
    <div class="sb-item"><a href="<?= base_url('dashboard') ?>" class="<?= uri_string()==='dashboard'?'active':'' ?>" data-tip="Dashboard"><span class="sb-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg></span><span class="sb-label">Dashboard</span></a></div>
    <div class="sb-section-label">Assets</div>
    <div class="sb-item"><a href="<?= base_url('assets') ?>" class="<?= str_starts_with(uri_string(),'assets')?'active':'' ?>" data-tip="Assets"><span class="sb-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg></span><span class="sb-label">Assets</span></a></div>
    <div class="sb-item"><a href="<?= base_url('categories') ?>" class="<?= str_starts_with(uri_string(),'categories')?'active':'' ?>" data-tip="Categories"><span class="sb-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg></span><span class="sb-label">Categories</span></a></div>
    <?php if(in_array($userRole??'',['superadmin','manager'])): ?>
    <div class="sb-section-label">Operations</div>
    <div class="sb-item"><a href="<?= base_url('maintenance') ?>" class="<?= str_starts_with(uri_string(),'maintenance')?'active':'' ?>" data-tip="Maintenance"><span class="sb-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></span><span class="sb-label">Maintenance</span></a></div>
    <div class="sb-item"><a href="<?= base_url('transactions') ?>" class="<?= str_starts_with(uri_string(),'transactions')?'active':'' ?>" data-tip="Transactions"><span class="sb-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></span><span class="sb-label">Transactions</span></a></div>
    <?php endif; ?>
    <?php if($userRole==='superadmin'): ?>
    <div class="sb-section-label">Admin</div>
    <div class="sb-item"><a href="<?= base_url('users') ?>" class="<?= str_starts_with(uri_string(),'users')?'active':'' ?>" data-tip="Users"><span class="sb-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span><span class="sb-label">Users</span></a></div>
    <?php endif; ?>
    <div class="sb-section-label">Account</div>
    <div class="sb-item"><a href="<?= base_url('profile') ?>" class="<?= uri_string()==='profile'?'active':'' ?>" data-tip="Profile"><span class="sb-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></span><span class="sb-label">Profile</span></a></div>
  </nav>
  <div class="sb-footer">
    <a href="<?= base_url('logout') ?>" data-tip="Sign Out"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg><span class="sb-label">Sign Out</span></a>
  </div>
</aside>
<button class="sb-toggle" id="sbToggle"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="15 18 9 12 15 6"/></svg></button>

<div class="main-wrap">
  <header class="topbar">
    <span class="topbar-title"><?= $page_title??'Dashboard' ?></span>
    <div class="topbar-right">
      <button id="themeToggleBtn" class="theme-toggle" title="Toggle Theme">
        <svg id="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        <svg id="icon-moon" style="display:none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      </button>
      <a href="<?= base_url('profile') ?>" class="topbar-user">
        <div class="tu-av"><?php if(!empty($userAvatar)): ?><img src="<?= base_url('uploads/avatars/'.$userAvatar) ?>" alt=""><?php else: ?><?= strtoupper(substr($userName??'U',0,1)) ?><?php endif; ?></div>
        <span class="tu-name"><?= esc($userName??'') ?></span>
      </a>
    </div>
  </header>
  <main class="page-content">
    <?php if(session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
      <div class="alert alert-error"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('errors')): ?>
      <div class="alert alert-error"><div><?php foreach((array)session()->getFlashdata('errors') as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?></div></div>
    <?php endif; ?>
    <?= view($content_view, $this->data??get_defined_vars()) ?>
  </main>
</div>
<script>
const sidebar=document.getElementById('sidebar'),toggle=document.getElementById('sbToggle'),CNAME='sb-collapsed';
if(localStorage.getItem('sbState')==='1'){document.body.classList.add(CNAME);sidebar.classList.add('collapsed');}
toggle.addEventListener('click',()=>{const c=document.body.classList.toggle(CNAME);sidebar.classList.toggle('collapsed',c);localStorage.setItem('sbState',c?'1':'0');});
const themeBtn=document.getElementById('themeToggleBtn'),iconSun=document.getElementById('icon-sun'),iconMoon=document.getElementById('icon-moon'),TK='tt-theme';
const setTheme=isLight=>{document.body.classList.toggle('light-mode',isLight);iconSun.style.display=isLight?'none':'block';iconMoon.style.display=isLight?'block':'none';localStorage.setItem(TK,isLight?'light':'dark');};
if(localStorage.getItem(TK)==='light')setTheme(true);
themeBtn.addEventListener('click',()=>setTheme(!document.body.classList.contains('light-mode')));
document.querySelectorAll('.alert').forEach(el=>{setTimeout(()=>{el.style.transition='opacity .3s';el.style.opacity='0';setTimeout(()=>el.remove(),300);},4500);});
</script>
</body>
</html>

//
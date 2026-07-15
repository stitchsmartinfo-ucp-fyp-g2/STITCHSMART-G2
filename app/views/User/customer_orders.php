<?php
$hide_header = true;
$hide_footer = true;
$hide_chatbot = true;
include('header.php');

$theme = $global_theme ?? 'theme-default';
$themeFile = ($theme === 'theme-luxury') ? 'theme-luxury-frontend.css' : 'theme-default-frontend.css';
?>
<!DOCTYPE html>
<html lang="en" class="<?= htmlspecialchars($theme); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StitchSmart - My Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/<?= htmlspecialchars($themeFile); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        try {
            var t = '<?= htmlspecialchars($theme); ?>';
            document.documentElement.classList.add(t);
        } catch(e) {}
    </script>

<style>
/* ============================================================
   CUSTOMER ORDERS – PREMIUM DESIGN (THEME-PROOF)
   All rules use !important to override global theme CSS
   ============================================================ */

/* ── DEFAULT (LIGHT) THEME ───────────────────────────────── */
.co-page {
    --co-bg:            #F8F4EE;
    --co-header-bg:     #FFFDFC;
    --co-border:        rgba(92,60,38,0.14);
    --co-card-bg:       #FFFFFF;
    --co-text-h:        #24150F;
    --co-text-body:     #5C4335;
    --co-text-muted:    #9C8575;
    --co-accent:        #ca9745;
    --co-accent-dark:   #ca9745;
    --co-accent-grad:   linear-gradient(135deg,#ca9745,#ca9745);
    --co-accent-soft:   rgba(205,154,72,0.12);
    --co-accent-softer: rgba(205,154,72,0.06);
    --co-divider:       rgba(92,60,38,0.10);
    --co-shadow-sm:     0 2px 12px rgba(36,21,15,0.08);
    --co-shadow-md:     0 10px 32px rgba(36,21,15,0.12);
    --co-shadow-lg:     0 20px 55px rgba(36,21,15,0.15);
    --co-pill-bg:       #F5F0E8;
    --co-footer-bg:     #FDFBF8;
    --co-breadcrumb:    #9C8575;
}

/* ── LUXURY (DARK) THEME ─────────────────────────────────── */
:root.theme-luxury .co-page {
    --co-bg:            #050505;
    --co-header-bg:     #0A0A0A;
    --co-border:        rgba(202, 151, 69,0.18);
    --co-card-bg:       #111111;
    --co-text-h:        #F4E9D3;
    --co-text-body:     rgba(244,233,211,0.85);
    --co-text-muted:    rgba(244,233,211,0.48);
    --co-accent:        #ca9745;
    --co-accent-dark:   #8A6421;
    --co-accent-grad:   linear-gradient(135deg,#ca9745,#8A6421);
    --co-accent-soft:   rgba(202, 151, 69,0.14);
    --co-accent-softer: rgba(202, 151, 69,0.06);
    --co-divider:       rgba(255,255,255,0.08);
    --co-shadow-sm:     0 2px 14px rgba(0,0,0,0.40);
    --co-shadow-md:     0 10px 34px rgba(0,0,0,0.55);
    --co-shadow-lg:     0 22px 58px rgba(0,0,0,0.65);
    --co-pill-bg:       rgba(255,255,255,0.05);
    --co-footer-bg:     #0D0D0D;
    --co-breadcrumb:    rgba(244,233,211,0.40);
}

/* ── BASE ────────────────────────────────────────────────── */
.co-page {
    background: var(--co-bg) !important;
    min-height: 100vh !important;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
    padding-bottom: 3rem !important;
}

/* ── PAGE HEADER ─────────────────────────────────────────── */
.co-page .co-page-header {
    background: var(--co-header-bg) !important;
    border-bottom: 1px solid var(--co-border) !important;
    padding: 20px 0 18px !important;
    margin-bottom: 24px !important;
}
.co-page .co-breadcrumb {
    display: flex !important;
    align-items: center !important;
    gap: 7px !important;
    font-size: 0.82rem !important;
    color: var(--co-breadcrumb) !important;
    margin-bottom: 10px !important;
}
.co-page .co-breadcrumb a {
    color: var(--co-breadcrumb) !important;
    text-decoration: none !important;
    transition: color 0.2s !important;
    font-size: 0.82rem !important;
}
.co-page .co-breadcrumb a:hover { color: var(--co-accent) !important; }
.co-page .co-breadcrumb span {
    color: var(--co-text-body) !important;
    font-size: 0.82rem !important;
}
.co-page .co-breadcrumb i.bi-chevron-right {
    font-size: 0.55rem !important;
    opacity: 0.6 !important;
    color: var(--co-breadcrumb) !important;
}

.co-page .co-header-row {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    flex-wrap: wrap !important;
    gap: 12px !important;
}
.co-page .co-header-title {
    font-family: 'Playfair Display', 'Outfit', serif !important;
    font-size: 1.85rem !important;
    font-weight: 900 !important;
    color: var(--co-text-h) !important;
    margin: 0 0 2px !important;
    line-height: 1.15 !important;
    letter-spacing: normal !important;
}
.co-page .co-header-sub {
    font-size: 0.88rem !important;
    color: var(--co-text-muted) !important;
    margin: 0 !important;
    font-weight: 400 !important;
}

/* ── BUTTONS ─────────────────────────────────────────────── */
.co-page .co-btn {
    display: inline-flex !important;
    align-items: center !important;
    gap: 7px !important;
    padding: 10px 22px !important;
    border-radius: 50px !important;
    font-size: 0.88rem !important;
    font-weight: 700 !important;
    text-decoration: none !important;
    border: 1px solid transparent !important;
    cursor: pointer !important;
    transition: transform 0.22s ease, box-shadow 0.22s ease !important;
    white-space: nowrap !important;
    line-height: 1 !important;
    text-transform: none !important;
    letter-spacing: normal !important;
}
.co-page .co-btn:hover { transform: translateY(-2px) !important; }
.co-page .co-btn i {
    font-size: 0.88rem !important;
}

.co-page .co-btn-primary {
    background: var(--co-accent-grad) !important;
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(202, 151, 69,0.30) !important;
}
.co-page .co-btn-primary:hover { box-shadow: 0 8px 24px rgba(202, 151, 69,0.48) !important; }
.co-page .co-btn-primary i { color: #fff !important; }

.co-page .co-btn-ghost {
    background: var(--co-accent-softer) !important;
    border-color: var(--co-border) !important;
    color: var(--co-text-body) !important;
}
.co-page .co-btn-ghost:hover {
    background: var(--co-accent-soft) !important;
    border-color: rgba(202, 151, 69,0.4) !important;
    color: var(--co-accent) !important;
}
.co-page .co-btn-ghost i { color: var(--co-text-muted) !important; }
.co-page .co-btn-ghost:hover i { color: var(--co-accent) !important; }

/* ── STATS ───────────────────────────────────────────────── */
.co-page .co-stats-row {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 14px !important;
    margin-bottom: 24px !important;
}
.co-page .co-stat-card {
    background: var(--co-card-bg) !important;
    border: 1px solid var(--co-border) !important;
    border-radius: 18px !important;
    padding: 20px 22px !important;
    display: flex !important;
    align-items: center !important;
    gap: 16px !important;
    box-shadow: var(--co-shadow-sm) !important;
    transition: box-shadow 0.25s, transform 0.25s !important;
    position: relative !important;
    overflow: hidden !important;
}
.co-page .co-stat-card::after {
    content: '' !important;
    position: absolute !important;
    top: 0 !important; left: 0 !important; right: 0 !important;
    height: 3px !important;
    background: var(--co-accent-grad) !important;
    opacity: 0 !important;
    transition: opacity 0.3s !important;
}
.co-page .co-stat-card:hover::after { opacity: 1 !important; }
.co-page .co-stat-card:hover {
    box-shadow: var(--co-shadow-md) !important;
    transform: translateY(-2px) !important;
}
.co-page .co-stat-icon {
    width: 48px !important; height: 48px !important;
    border-radius: 14px !important;
    background: var(--co-accent-soft) !important;
    display: grid !important; place-items: center !important;
    font-size: 1.3rem !important;
    color: var(--co-accent) !important;
    flex-shrink: 0 !important;
}
.co-page .co-stat-icon i {
    color: var(--co-accent) !important;
    font-size: 1.3rem !important;
}
.co-page .co-stat-label {
    font-size: 0.78rem !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.08em !important;
    color: var(--co-text-muted) !important;
    margin-bottom: 4px !important;
}
.co-page .co-stat-value {
    font-size: 1.6rem !important;
    font-weight: 800 !important;
    color: var(--co-text-h) !important;
    line-height: 1 !important;
    letter-spacing: normal !important;
}

/* ── SECTION HEADER ──────────────────────────────────────── */
.co-page .co-sec-header {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    margin-bottom: 16px !important;
    flex-wrap: wrap !important;
    gap: 10px !important;
}
.co-page .co-sec-title {
    font-size: 1.1rem !important;
    font-weight: 700 !important;
    color: var(--co-text-h) !important;
    margin: 0 !important;
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
    letter-spacing: normal !important;
}
.co-page .co-sec-title::before {
    content: '' !important;
    width: 4px !important; height: 20px !important;
    border-radius: 4px !important;
    background: var(--co-accent-grad) !important;
    flex-shrink: 0 !important;
    display: block !important;
}
.co-page .co-count-badge {
    font-size: 0.78rem !important;
    font-weight: 700 !important;
    color: var(--co-accent) !important;
    background: var(--co-accent-soft) !important;
    border: 1px solid rgba(202, 151, 69,0.25) !important;
    padding: 4px 13px !important;
    border-radius: 50px !important;
}

/* ============================================================
   ORDER CARD
   ============================================================ */
.co-page .co-order-card {
    background: var(--co-card-bg) !important;
    border: 1px solid var(--co-border) !important;
    border-radius: 22px !important;
    overflow: hidden !important;
    box-shadow: var(--co-shadow-sm) !important;
    transition: box-shadow 0.3s ease, transform 0.3s ease, border-color 0.3s ease !important;
    display: flex !important;
    flex-direction: column !important;
}
.co-page .co-order-card:hover {
    box-shadow: var(--co-shadow-lg) !important;
    transform: translateY(-5px) !important;
    border-color: rgba(202, 151, 69,0.45) !important;
}

/* Status stripe */
.co-page .co-stripe {
    height: 4px !important;
    flex-shrink: 0 !important;
}
.co-page .co-stripe.s-pending    { background: linear-gradient(90deg,#F59E0B,#D97706) !important; }
.co-page .co-stripe.s-delivered  { background: linear-gradient(90deg,#10B981,#059669) !important; }
.co-page .co-stripe.s-cancelled  { background: linear-gradient(90deg,#EF4444,#DC2626) !important; }
.co-page .co-stripe.s-processing { background: linear-gradient(90deg,#3B82F6,#2563EB) !important; }

/* Card body */
.co-page .co-card-body {
    padding: 20px 22px 16px !important;
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
}

/* Top row */
.co-page .co-card-top {
    display: flex !important;
    gap: 18px !important;
    align-items: flex-start !important;
    margin-bottom: 16px !important;
}

/* Product thumbnail */
.co-page .co-thumb {
    flex-shrink: 0 !important;
    width: 100px !important;
    height: 100px !important;
    border-radius: 16px !important;
    overflow: hidden !important;
    border: 2px solid var(--co-accent-soft) !important;
    background: var(--co-accent-softer) !important;
    display: grid !important;
    place-items: center !important;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08) !important;
    transition: border-color 0.3s, box-shadow 0.3s !important;
}
.co-page .co-order-card:hover .co-thumb {
    border-color: rgba(202, 151, 69,0.40) !important;
    box-shadow: 0 6px 20px rgba(202, 151, 69,0.20) !important;
}
.co-page .co-thumb img {
    width: 100% !important; height: 100% !important;
    object-fit: cover !important;
    display: block !important;
    transition: transform 0.4s ease !important;
}
.co-page .co-order-card:hover .co-thumb img {
    transform: scale(1.07) !important;
}
.co-page .co-thumb i {
    font-size: 2.2rem !important;
    color: var(--co-accent) !important;
    opacity: 0.5 !important;
}

/* Order info */
.co-page .co-order-main { flex: 1 !important; min-width: 0 !important; }

.co-page .co-order-id {
    font-size: 0.85rem !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.10em !important;
    color: var(--co-text-muted) !important;
    margin-bottom: 4px !important;
}
.co-page .co-order-id strong {
    color: var(--co-accent) !important;
    font-weight: 700 !important;
    font-size: 0.85rem !important;
}

.co-page .co-order-amount {
    font-size: 1.85rem !important;
    font-weight: 800 !important;
    color: var(--co-text-h) !important;
    letter-spacing: -0.02em !important;
    line-height: 1.1 !important;
    margin-bottom: 6px !important;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
}

.co-page .co-order-date {
    font-size: 0.88rem !important;
    color: var(--co-text-muted) !important;
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
}
.co-page .co-order-date i {
    font-size: 0.82rem !important;
    color: var(--co-text-muted) !important;
}

/* Status badge */
.co-page .co-status {
    flex-shrink: 0 !important;
    align-self: flex-start !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    padding: 6px 14px !important;
    border-radius: 50px !important;
    font-size: 0.78rem !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.07em !important;
    white-space: nowrap !important;
}
.co-page .co-status-dot {
    width: 7px !important; height: 7px !important;
    border-radius: 50% !important;
    background: currentColor !important;
    flex-shrink: 0 !important;
    box-shadow: 0 0 6px currentColor !important;
    display: inline-block !important;
}

/* Light badges */
.co-page .co-status-pending    { color:#92400E !important; background:#FEF3C7 !important; border:1px solid #FDE68A !important; }
.co-page .co-status-delivered  { color:#065F46 !important; background:#D1FAE5 !important; border:1px solid #A7F3D0 !important; }
.co-page .co-status-cancelled  { color:#991B1B !important; background:#FEE2E2 !important; border:1px solid #FECACA !important; }
.co-page .co-status-processing { color:#1E40AF !important; background:#DBEAFE !important; border:1px solid #BFDBFE !important; }

/* Dark badges */
:root.theme-luxury .co-page .co-status-pending    { color:#FCD34D !important; background:rgba(252,211,77,0.12) !important; border:1px solid rgba(252,211,77,0.28) !important; }
:root.theme-luxury .co-page .co-status-delivered  { color:#34D399 !important; background:rgba(52,211,153,0.12) !important; border:1px solid rgba(52,211,153,0.28) !important; }
:root.theme-luxury .co-page .co-status-cancelled  { color:#F87171 !important; background:rgba(248,113,113,0.12) !important; border:1px solid rgba(248,113,113,0.28) !important; }
:root.theme-luxury .co-page .co-status-processing { color:#60A5FA !important; background:rgba(96,165,250,0.12) !important; border:1px solid rgba(96,165,250,0.28) !important; }

/* ── SPACER to push footer down ─────────────────────────── */
.co-page .co-card-spacer { flex: 1 !important; }

/* ── INFO PILLS ──────────────────────────────────────────── */
.co-page .co-info-row {
    display: flex !important;
    gap: 10px !important;
    flex-wrap: wrap !important;
    margin-bottom: 14px !important;
}
.co-page .co-pill {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    background: var(--co-pill-bg) !important;
    border: 1px solid var(--co-border) !important;
    border-radius: 10px !important;
    padding: 8px 14px !important;
    font-size: 0.88rem !important;
    color: var(--co-text-body) !important;
    font-weight: 500 !important;
    transition: background 0.2s !important;
}
.co-page .co-pill:hover { background: var(--co-accent-soft) !important; }
.co-page .co-pill i {
    color: var(--co-accent) !important;
    font-size: 0.9rem !important;
}
.co-page .co-pill .co-pill-lbl {
    color: var(--co-text-muted) !important;
    font-weight: 400 !important;
    margin-right: 2px !important;
    font-size: 0.88rem !important;
}

/* ── TRACKING ────────────────────────────────────────────── */
.co-page .co-tracking {
    background: var(--co-accent-softer) !important;
    border: 1px solid rgba(202, 151, 69,0.18) !important;
    border-radius: 12px !important;
    padding: 10px 14px !important;
    margin-bottom: 14px !important;
    font-size: 0.88rem !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    color: var(--co-text-body) !important;
}
.co-page .co-tracking i {
    color: var(--co-accent) !important;
    font-size: 0.88rem !important;
}
.co-page .co-tracking span {
    color: var(--co-text-body) !important;
    font-size: 0.88rem !important;
}
.co-page .co-tracking .co-tracking-id {
    font-family: 'Courier New', monospace !important;
    font-weight: 700 !important;
    color: var(--co-accent) !important;
    letter-spacing: 0.04em !important;
    font-size: 0.88rem !important;
}

/* ── CARD FOOTER ─────────────────────────────────────────── */
.co-page .co-card-footer {
    border-top: 1px solid var(--co-divider) !important;
    padding: 14px 22px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 10px !important;
    flex-wrap: wrap !important;
    background: var(--co-footer-bg) !important;
    margin-top: auto !important;
}

/* ── EMPTY STATE ─────────────────────────────────────────── */
.co-page .co-empty {
    background: var(--co-card-bg) !important;
    border: 1px solid var(--co-border) !important;
    border-radius: 24px !important;
    padding: 60px 36px !important;
    text-align: center !important;
    max-width: 480px !important;
    margin: 24px auto !important;
    box-shadow: var(--co-shadow-sm) !important;
}
.co-page .co-empty-icon {
    font-size: 3.5rem !important;
    color: var(--co-accent) !important;
    opacity: 0.55 !important;
    display: block !important;
    margin-bottom: 18px !important;
}
.co-page .co-empty h3 {
    font-family: 'Playfair Display', 'Outfit', serif !important;
    font-size: 1.65rem !important;
    font-weight: 900 !important;
    color: var(--co-text-h) !important;
    margin-bottom: 10px !important;
    letter-spacing: normal !important;
}
.co-page .co-empty p {
    font-size: 1rem !important;
    color: var(--co-text-muted) !important;
    margin: 0 auto 24px !important;
    max-width: 340px !important;
    line-height: 1.6 !important;
    font-weight: 400 !important;
}

/* ── ANIMATIONS ──────────────────────────────────────────── */
@keyframes co-up {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}
.co-anim  { animation: co-up 0.5s cubic-bezier(.22,1,.36,1) both; }
.co-d1    { animation-delay:0.06s; }
.co-d2    { animation-delay:0.12s; }
.co-d3    { animation-delay:0.18s; }

/* ── RESPONSIVE ──────────────────────────────────────────── */
@media(max-width:767px){
    .co-page .co-stats-row { grid-template-columns:1fr 1fr !important; }
    .co-page .co-header-title { font-size:1.55rem !important; }
}
@media(max-width:575px){
    .co-page .co-stats-row { grid-template-columns:1fr !important; }
    .co-page .co-page-header { padding:16px 0 14px !important; }
    .co-page .co-card-footer { justify-content:stretch !important; }
    .co-page .co-card-footer .co-btn { flex:1 !important; justify-content:center !important; }
    .co-page .co-thumb { width:80px !important; height:80px !important; }
    .co-page .co-order-amount { font-size:1.5rem !important; }
    .co-page .co-card-top { gap:14px !important; }
}
</style>

<div class="co-page">

<!-- PAGE HEADER -->
<div class="co-page-header">
    <div class="container">
        <div class="co-breadcrumb">
            <a href="<?= url('home') ?>"><i class="bi bi-house-fill"></i> Home</a>
            <i class="bi bi-chevron-right"></i>
            <span>My Orders</span>
        </div>
        <div class="co-header-row">
            <div>
                <h1 class="co-header-title">Order History</h1>
                <p class="co-header-sub">Track and manage all your purchases</p>
            </div>
            <a href="<?= url('allproducts') ?>" class="co-btn co-btn-primary">
                <i class="bi bi-bag-heart-fill"></i> Continue Shopping
            </a>
        </div>
    </div>
</div>

<div class="container">

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show co-anim mt-3 border-0 rounded-3 p-3 shadow" role="alert" style="background: rgba(25, 135, 84, 0.15); border: 1px solid rgba(25, 135, 84, 0.3) !important; color: #51cf66;">
        <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(1);"></button>
    </div>
<?php unset($_SESSION['success']); endif; ?>

<?php if (empty($orders)): ?>

    <div class="co-empty co-anim">
        <i class="bi bi-bag-x co-empty-icon"></i>
        <h3>No orders yet</h3>
        <p>Your purchase history will appear here once you place your first order.</p>
        <a href="<?= url('home') ?>" class="co-btn co-btn-primary">
            <i class="bi bi-bag-fill"></i> Start Shopping
        </a>
    </div>

<?php else:
    $orderCount   = count($orders);
    $totalSpent   = array_sum(array_column($orders, 'total'));
    $pendingCount = count(array_filter($orders, fn($o) => stripos($o['status'] ?? '', 'pending') !== false));
?>

    <!-- Stats -->
    <div class="co-stats-row co-anim co-d1">
        <div class="co-stat-card">
            <div class="co-stat-icon"><i class="bi bi-box-seam-fill"></i></div>
            <div>
                <div class="co-stat-label">Total Orders</div>
                <div class="co-stat-value"><?= $orderCount ?></div>
            </div>
        </div>
        <div class="co-stat-card">
            <div class="co-stat-icon"><i class="bi bi-currency-rupee"></i></div>
            <div>
                <div class="co-stat-label">Total Spent</div>
                <div class="co-stat-value">Rs <?= number_format($totalSpent, 0) ?></div>
            </div>
        </div>
        <div class="co-stat-card">
            <div class="co-stat-icon"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="co-stat-label">Pending</div>
                <div class="co-stat-value"><?= $pendingCount ?></div>
            </div>
        </div>
    </div>

    <!-- Section header -->
    <div class="co-sec-header co-anim co-d2">
        <h2 class="co-sec-title">Purchase History</h2>
        <span class="co-count-badge"><?= $orderCount ?> order<?= $orderCount !== 1 ? 's' : '' ?></span>
    </div>

    <!-- Order cards -->
    <div class="row g-3 co-anim co-d3">
        <?php foreach ($orders as $order):
            $status = strtolower(trim($order['status'] ?? 'pending'));
            $statusClass = 'co-status-pending';
            $stripeClass = 's-pending';
            if      (strpos($status,'deliver')    !== false) { $statusClass='co-status-delivered';  $stripeClass='s-delivered'; }
            elseif  (strpos($status,'cancel')     !== false) { $statusClass='co-status-cancelled';  $stripeClass='s-cancelled'; }
            elseif  (strpos($status,'processing') !== false || strpos($status,'dispatch') !== false || strpos($status,'transit') !== false || strpos($status,'out') !== false) { $statusClass='co-status-processing'; $stripeClass='s-processing'; }

            $imageUrl = !empty($order['product_image_url'])
                ? BASE_URL . '/' . htmlspecialchars(trim(strtok($order['product_image_url'], ',')))
                : null;
        ?>
        <div class="col-lg-6 d-flex">
            <article class="co-order-card w-100">

                <div class="co-stripe <?= $stripeClass ?>"></div>

                <div class="co-card-body">
                    <div class="co-card-top">
                        <!-- Product Image -->
                        <div class="co-thumb">
                            <?php if ($imageUrl): ?>
                                <img src="<?= $imageUrl ?>"
                                     alt="<?= htmlspecialchars($order['product_name'] ?? 'Order item') ?>"
                                     loading="lazy"
                                     onerror="this.parentElement.innerHTML='<i class=\'bi bi-scissors\'></i>'">
                            <?php else: ?>
                                <i class="bi bi-scissors"></i>
                            <?php endif; ?>
                        </div>

                        <!-- Order Info -->
                        <div class="co-order-main">
                            <div class="co-order-id">Order <strong>#<?= htmlspecialchars($order['id']) ?></strong></div>
                            <div class="co-order-amount">Rs <?= number_format($order['total'], 2) ?></div>
                            <div class="co-order-date">
                                <i class="bi bi-calendar3"></i>
                                <?= htmlspecialchars($order['created_at'] ?? 'N/A') ?>
                            </div>
                        </div>

                        <!-- Status -->
                        <span class="co-status <?= $statusClass ?>">
                            <span class="co-status-dot"></span>
                            <?= htmlspecialchars(ucfirst($order['status'] ?? 'Pending')) ?>
                        </span>
                    </div>

                    <!-- Info pills -->
                    <div class="co-info-row">
                        <div class="co-pill">
                            <i class="bi bi-person-circle"></i>
                            <span class="co-pill-lbl">Customer:</span>
                            <?= htmlspecialchars($order['customer_name'] ?? 'N/A') ?>
                        </div>
                        <div class="co-pill">
                            <i class="bi bi-layers-half"></i>
                            <span class="co-pill-lbl">Items:</span>
                            <?= $order['item_count'] > 0
                                ? $order['item_count'] . ' item' . ($order['item_count'] > 1 ? 's' : '')
                                : 'N/A' ?>
                        </div>
                    </div>

                    <?php if (!empty($order['tracking_id'])): ?>
                    <div class="co-tracking">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Tracking:</span>
                        <span class="co-tracking-id"><?= htmlspecialchars($order['tracking_id']) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="co-card-spacer"></div>
                </div>

                <div class="co-card-footer">
                    <?php if (strtolower(trim($order['status'] ?? '')) === 'delivered'): ?>
                        <a href="<?= url('customer_order_review?id=' . $order['id']) ?>"
                           class="co-btn co-btn-primary">
                            <i class="bi bi-star-fill"></i> Rate &amp; Review
                        </a>
                    <?php endif; ?>
                    <a href="<?= url('customer_order_detail?id=' . $order['id']) ?>"
                       class="co-btn co-btn-ghost">
                        <i class="bi bi-eye"></i> View Details
                    </a>
                </div>

            </article>
        </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>

</div>
</div>
</body>
</html>

<!DOCTYPE html>
<?php
$newOrderCount = 0;
if (class_exists('Database')) {
    $db = new Database();
    $conn = $db->connect();
    $result = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status LIKE 'Pending%'");
    if ($result) {
        $newOrderCount = (int) $result->fetch_assoc()['c'];
    }
}
?>
<html>
<head>
    <title><?= $title ?? 'Admin' ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/base.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/<?= $theme ?>.css?v=<?= time() ?>">
</head>

<body>

<!-- Ultra-Professional Executive Top Navbar -->
<header class="admin-top-navbar" style="padding: 12px 35px; position: sticky; top: 0; z-index: 1050; backdrop-filter: blur(12px);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 w-100">
        
        <!-- Left: Brand Logo & Executive Badge -->
        <div class="d-flex align-items-center gap-3">
            <a href="<?= url('admin') ?>" class="text-decoration-none d-flex align-items-center gap-3">
                <div style="width: 44px; height: 44px; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(202, 151, 69, 0.35); border: 1px solid rgba(202, 151, 69, 0.6); background: linear-gradient(135deg, #2a1b12, #0a0503); flex-shrink: 0;">
                    <svg width="30" height="30" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="76" stroke="#ca9745" stroke-width="3" stroke-dasharray="8 6" fill="none" opacity="0.85"/>
                        <path d="M118 64C118 57.3726 112.627 52 106 52H92C80.9543 52 72 60.9543 72 72C72 83.0457 80.9543 92 92 92H108C119.046 92 128 100.954 128 112C128 123.046 119.046 132 108 132H94C87.3726 132 82 126.627 82 120" stroke="#ca9745" stroke-width="14" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M100 40V160" stroke="#FFFFFF" stroke-width="5" stroke-linecap="round" opacity="0.95"/>
                        <circle cx="100" cy="46" r="5" fill="#ca9745"/>
                    </svg>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <h3 class="mb-0 fw-bolder" style="font-size: 1.5rem; letter-spacing: 0.5px; color: #fff; line-height: 1;">Stitch<span style="color: #ca9745;">Smart</span></h3>
                        <span class="badge" style="background: linear-gradient(135deg, rgba(202, 151, 69, 0.25), rgba(202, 151, 69, 0.1)); color: #e8c547; border: 1px solid rgba(202, 151, 69, 0.5); font-size: 0.68rem; font-weight: 800; letter-spacing: 1.5px; padding: 4px 10px; border-radius: 30px;"><i class="bi bi-shield-lock-fill pe-1"></i> EXECUTIVE PORTAL</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Center: System Status Pill -->
        <div class="d-none d-lg-flex align-items-center gap-2 px-4 py-2 rounded-pill shadow-sm" style="<?= ($theme === 'theme-luxury') ? 'background: linear-gradient(135deg, #1f140e, #0a0503); border: 1px solid #e8c547; color: #e8c547; box-shadow: 0 0 15px rgba(232, 197, 71, 0.4), inset 0 0 10px rgba(232, 197, 71, 0.1) !important;' : 'background: linear-gradient(135deg, #ffffff, #fdf6ec); border: 1px solid #ca9745; color: #1a0f0a; box-shadow: 0 2px 8px rgba(202, 151, 69, 0.2) !important;' ?> font-size: 0.9rem; font-weight: 800; letter-spacing: 0.5px;">
            <span class="d-inline-block rounded-circle" style="width: 10px; height: 10px; background-color: #00ff88 !important; box-shadow: 0 0 12px #00ff88, 0 0 4px #00ff88;"></span>
            <span class="<?= ($theme === 'theme-luxury') ? 'text-uppercase' : '' ?>">System Active • Storefront Online</span>
        </div>

        <!-- Right: Grouped Tools (Theme Toggle + Notifications + Admin Avatar) -->
        <div class="d-flex gap-3 align-items-center flex-wrap">
            <!-- Theme Pill Selector -->
            <div class="d-flex gap-1 align-items-center p-1 rounded-pill" style="background: rgba(0,0,0,0.4); border: 1px solid rgba(202, 151, 69, 0.35); box-shadow: inset 0 2px 6px rgba(0,0,0,0.5);">
                <a href="<?= url('') ?>switch_theme&theme=theme-default" 
                   class="btn btn-sm rounded-pill px-3 py-1 d-flex align-items-center gap-1"
                   style="
                       font-weight: 700;
                       font-size: 0.82rem;
                       transition: all 0.3s ease;
                       border: 1px solid <?= ($theme === 'theme-default') ? '#ca9745' : 'transparent' ?>;
                       <?= ($theme === 'theme-default') ? 'background: #ffffff; color: #1a0f0a; box-shadow: 0 2px 10px rgba(255,255,255,0.3);' : 'background: transparent; color: #b0a090;' ?>
                   "
                   title="Switch to Default Theme"
                   >
                    <i class="bi bi-palette2"></i> Default
                </a>
                <a href="<?= url('') ?>switch_theme&theme=theme-luxury" 
                   class="btn btn-sm rounded-pill px-3 py-1 d-flex align-items-center gap-1"
                   style="
                       font-weight: 700;
                       font-size: 0.82rem;
                       transition: all 0.3s ease;
                       border: 1px solid <?= ($theme === 'theme-luxury') ? '#e8c547' : 'transparent' ?>;
                       <?= ($theme === 'theme-luxury') ? 'background: linear-gradient(135deg, #ca9745 0%, #8b5a2b 100%); color: #ffffff; box-shadow: 0 3px 12px rgba(202, 151, 69, 0.5);' : 'background: transparent; color: #ca9745;' ?>
                   "
                   title="Switch to Luxury Gold Theme"
                   >
                    <i class="bi bi-stars"></i> Luxury ✨
                </a>
            </div>

            <!-- Order Bell Notification -->
            <a href="<?= url('') ?>manage_orders" class="btn position-relative d-flex align-items-center justify-content-center rounded-circle" title="Pending Customer Orders" style="width: 42px; height: 42px; background: rgba(202, 151, 69, 0.15); border: 1px solid rgba(202, 151, 69, 0.5); color: #e8c547; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(202, 151, 69, 0.3)'; this.style.transform='scale(1.08)';" onmouseout="this.style.background='rgba(202, 151, 69, 0.15)'; this.style.transform='scale(1)';" >
                <i class="bi bi-bell-fill fs-5"></i>
                <?php if ($newOrderCount > 0): ?>
                    <span class="position-absolute badge rounded-pill bg-danger border border-2 border-dark" style="font-size: 0.62rem; font-weight: 800; padding: 2px 5px; box-shadow: 0 2px 8px rgba(220, 53, 69, 0.6); top: -4px; right: -4px; min-width: 18px; line-height: 1.4; z-index: 5;">
                        <?= $newOrderCount ?>
                    </span>
                <?php endif; ?>
            </a>

            <!-- Admin Profile Tag -->
            <div class="d-none d-sm-flex align-items-center gap-2 ms-2 ps-3 border-start" style="border-color: rgba(202, 151, 69, 0.25) !important;">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; font-size: 1rem; box-shadow: 0 2px 8px rgba(202, 151, 69, 0.4);">
                    <i class="bi bi-person-workspace"></i>
                </div>
                <div>
                    <div class="fw-bold" style="font-size: 0.85rem; line-height: 1.2; color: #1a0f0a;">Admin Desk</div>
                    <div style="font-size: 0.7rem; color: #ca9745; font-weight: 600;">Authorized Manager</div>
                </div>
            </div>
        </div>

    </div>
</header>

<main>
    <div class="row mt-5 mx-0 px-3">
        
        <?php include BASE_PATH . '/app/views/admin/sidebar.php'; ?>

        <div class="col-xl-9 col-sm-8">

            <!-- Global Notifications -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="ss-toast ss-toast--success" role="alert" aria-live="assertive">
                    <div class="ss-toast__icon">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <div class="ss-toast__body">
                        <div class="ss-toast__label">Success</div>
                        <div class="ss-toast__message"><?= htmlspecialchars($_SESSION['success']); ?></div>
                    </div>
                    <button class="ss-toast__close" aria-label="Close" onclick="this.closest('.ss-toast').classList.add('ss-toast--hiding'); setTimeout(()=>this.closest('.ss-toast').remove(),350);">&times;</button>
                    <div class="ss-toast__progress"></div>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['errors'])): ?>
                <div class="ss-toast ss-toast--error" role="alert" aria-live="assertive">
                    <div class="ss-toast__icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="ss-toast__body">
                        <div class="ss-toast__label">Errors</div>
                        <div class="ss-toast__message">
                            <ul class="mb-0 ps-3">
                                <?php foreach ($_SESSION['errors'] as $err): ?>
                                    <li><?= htmlspecialchars($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <button class="ss-toast__close" aria-label="Close" onclick="this.closest('.ss-toast').classList.add('ss-toast--hiding'); setTimeout(()=>this.closest('.ss-toast').remove(),350);">&times;</button>
                    <div class="ss-toast__progress ss-toast__progress--error"></div>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="ss-toast ss-toast--error" role="alert" aria-live="assertive">
                    <div class="ss-toast__icon">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <div class="ss-toast__body">
                        <div class="ss-toast__label">Error</div>
                        <div class="ss-toast__message"><?= htmlspecialchars($_SESSION['error']); ?></div>
                    </div>
                    <button class="ss-toast__close" aria-label="Close" onclick="this.closest('.ss-toast').classList.add('ss-toast--hiding'); setTimeout(()=>this.closest('.ss-toast').remove(),350);">&times;</button>
                    <div class="ss-toast__progress ss-toast__progress--error"></div>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php require_once BASE_PATH . "/app/views/" . $view; ?>

        </div>

    </div>
</main>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

<!-- Toast Container -->
<div id="ss-toast-container" aria-live="polite" aria-atomic="false"></div>

<style>
/* ═══════════════════════════════════════════
   STITCHSMART TOAST NOTIFICATION SYSTEM
   Bottom-right corner · Never overlaps content
═══════════════════════════════════════════ */
#ss-toast-container {
    position: fixed;
    bottom: 28px;
    right: 28px;
    z-index: 999999;
    display: flex;
    flex-direction: column;
    gap: 12px;
    pointer-events: none;
    max-width: 380px;
    width: calc(100vw - 40px);
}

.ss-toast {
    pointer-events: all;
    display: flex;
    align-items: center;
    gap: 14px;
    background: #ffffff;
    border-radius: 14px;
    padding: 16px 18px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid rgba(202, 151, 69, 0.18);
    position: relative;
    overflow: hidden;
    font-family: 'Plus Jakarta Sans', sans-serif;
    animation: ssToastSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    min-width: 280px;
}

.ss-toast--error {
    border-color: rgba(220, 53, 69, 0.18);
}

.ss-toast--hiding {
    animation: ssToastSlideDown 0.35s cubic-bezier(0.4, 0, 1, 1) forwards !important;
}

/* Icon circle */
.ss-toast__icon {
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(202, 151, 69, 0.10);
    border: 1px solid rgba(202, 151, 69, 0.22);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ca9745;
    font-size: 1.1rem;
}
.ss-toast--error .ss-toast__icon {
    background: rgba(220, 53, 69, 0.08);
    border-color: rgba(220, 53, 69, 0.18);
    color: #dc3545;
}

/* Body */
.ss-toast__body {
    flex: 1;
    min-width: 0;
}
.ss-toast__label {
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.9px;
    color: #ca9745;
    margin-bottom: 3px;
    line-height: 1;
}
.ss-toast--error .ss-toast__label {
    color: #dc3545;
}
.ss-toast__message {
    font-size: 0.88rem;
    font-weight: 600;
    color: #3b2b20;
    line-height: 1.4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ss-toast__message ul {
    white-space: normal;
}

/* Close button */
.ss-toast__close {
    flex-shrink: 0;
    background: none;
    border: none;
    cursor: pointer;
    color: #9b8c80;
    font-size: 1.25rem;
    line-height: 1;
    padding: 0 0 0 4px;
    transition: color 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
}
.ss-toast__close:hover {
    color: #3b2b20;
    background: rgba(0,0,0,0.05);
}

/* Progress bar (auto-dismiss timer) */
.ss-toast__progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    border-radius: 0 0 0 14px;
    background: linear-gradient(90deg, #ca9745, #ca9745);
    animation: ssToastProgress 5s linear forwards;
}
.ss-toast__progress--error {
    background: linear-gradient(90deg, #dc3545, #ff6b7a);
}

/* Animations */
@keyframes ssToastSlideUp {
    from {
        transform: translateY(24px) scale(0.96);
        opacity: 0;
    }
    to {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
}
@keyframes ssToastSlideDown {
    from {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
    to {
        transform: translateY(16px) scale(0.95);
        opacity: 0;
    }
}
@keyframes ssToastProgress {
    from { width: 100%; }
    to   { width: 0%; }
}

/* Mobile adjustment */
@media (max-width: 576px) {
    #ss-toast-container {
        bottom: 16px;
        right: 12px;
        left: 12px;
        width: auto;
    }
    .ss-toast {
        min-width: unset;
    }
}
</style>

<script>
(function() {
    function initToasts() {
        var container = document.getElementById('ss-toast-container');
        if (!container) return;
        document.querySelectorAll('.ss-toast').forEach(function(toast) {
            if (toast.parentElement !== container) {
                container.appendChild(toast);
            }
            var timer = setTimeout(function() {
                toast.classList.add('ss-toast--hiding');
                setTimeout(function() { toast.remove(); }, 350);
            }, 5000);
            toast.addEventListener('mouseenter', function() {
                toast.querySelectorAll('.ss-toast__progress').forEach(function(p) {
                    p.style.animationPlayState = 'paused';
                });
                clearTimeout(timer);
            });
            toast.addEventListener('mouseleave', function() {
                toast.querySelectorAll('.ss-toast__progress').forEach(function(p) {
                    p.style.animationPlayState = 'running';
                });
                timer = setTimeout(function() {
                    toast.classList.add('ss-toast--hiding');
                    setTimeout(function() { toast.remove(); }, 350);
                }, 2000);
            });
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initToasts);
    } else {
        initToasts();
    }
})();
</script>

</body>
</html>
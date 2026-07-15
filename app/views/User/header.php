<?php if (!empty($hide_header)) {
    return;
}
?>
<!-- design -->
<link rel="stylesheet" href="<?= BASE_URL ?>css/mega_menu.css">
<link rel="stylesheet" href="<?= BASE_URL ?>css/navbar-professional.css?v=<?= time() ?>">
<link rel="stylesheet" href="<?= BASE_URL ?>css/chatbot.css">

<?php
// Ensure theme CSS is loaded based on selected site theme. Controllers set $global_theme when available.
$theme = $global_theme ?? 'theme-default';
$themeFile = ($theme === 'theme-luxury') ? 'theme-luxury-frontend.css' : 'theme-default-frontend.css';

// Ensure $categories is defined to prevent mega menu warnings
if (!isset($categories) || !is_array($categories)) {
    $categories = [];
    global $conn;
    if (isset($conn) && is_object($conn)) {
        require_once BASE_PATH . '/app/models/ad_category.php';
        $catModel = new Category($conn);
        $categories = $catModel->getCategoriesTree();
    }
}
?>
<link rel="stylesheet" href="<?= BASE_URL ?>css/<?= htmlspecialchars($themeFile); ?>?v=<?= time() ?>">
<link rel="stylesheet" href="<?= BASE_URL ?>css/responsive-fixes.css?v=<?= time() ?>">

<script>
    // Apply theme class to document element/body so CSS selectors can target the active theme
    document.addEventListener('DOMContentLoaded', function(){
        try{
            var t = '<?= htmlspecialchars($theme); ?>';
            document.documentElement.classList.add(t);
            if(document.body) document.body.classList.add(t);
        }catch(e){}
    });
</script>

<!-- Import site fonts and apply theme-aware font rules -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* Global font families */
    html, body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
    h1,h2,h3,h4,h5,h6, .brand-name { font-family: 'Playfair Display', serif; }

    /* Brand logo colors per theme: Stitch (base text) + Smart (accent) */
    :root.theme-luxury .brand-name { color: #ffffff !important; }
    :root.theme-luxury .brand-name span { color: #ca9745 !important; }
    :root.theme-luxury .logo-icon { background: linear-gradient(135deg,#d3a15b,#a77b30); color: #1a0f0a !important; }

    :root.theme-default .brand-name { color: #3b2b20 !important; }
    :root.theme-default .brand-name span { color: #ca9745 !important; }
    :root.theme-default .logo-icon { background: linear-gradient(135deg,#f0dcc3,#d6b682); color: #3b2b20 !important; }

    /* Ensure navbar, footer and major UI use the chosen fonts */
    .main-navbar, .categories-bar, footer.footer, .site-footer, .announcement-bar { font-family: 'Plus Jakarta Sans', sans-serif; }
    .brand-name { font-weight: 700; letter-spacing: 0.02em; font-size: 1.6rem; }
    .brand-name span { font-weight: 700; }

    /* Small logo icon */
    .logo-icon { width:48px; height:48px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; font-weight:800; }

    /* Avoid local overrides by forcing inheritance in common blocks */
    header, nav, .site-footer, .main-navbar, .categories-bar, .newsletter-promo { -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale; }
</style>

<?php if (empty($hide_announcement)): ?>
<!-- Premium Top Announcement Bar -->
<div class="announcement-bar">
    <div class="container-fluid">
        <div class="announcement-content">
            <div class="announcement-left">
                <i class="bi bi-truck"></i>
                <span>Free Worldwide Shipping on Orders Over Rs. 5,000</span>
            </div>
            <div class="announcement-center">
                <span>✨ Premium Collection ✨</span>
            </div>
            <div class="announcement-right">
                <i class="bi bi-shield-check"></i>
                <span>100% Secure & Authentic</span>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['qty'];
    }
}
?>

<!-- Main Navbar -->
<nav class="main-navbar">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="brand-logo d-flex align-items-center gap-3 text-decoration-none" href="<?= url('home') ?>">
                <div style="width: 52px; height: 52px; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(202, 151, 69, 0.25); border: 1px solid rgba(202, 151, 69, 0.5); background: linear-gradient(135deg, #2a1b12, #0a0503); flex-shrink: 0;">
                    <svg width="40" height="40" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="76" stroke="#ca9745" stroke-width="3" stroke-dasharray="8 6" fill="none" opacity="0.85"/>
                        <path d="M118 64C118 57.3726 112.627 52 106 52H92C80.9543 52 72 60.9543 72 72C72 83.0457 80.9543 92 92 92H108C119.046 92 128 100.954 128 112C128 123.046 119.046 132 108 132H94C87.3726 132 82 126.627 82 120" stroke="#ca9745" stroke-width="14" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M100 40V160" stroke="#FFFFFF" stroke-width="5" stroke-linecap="round" opacity="0.95"/>
                        <circle cx="100" cy="46" r="5" fill="#ca9745"/>
                    </svg>
                </div>
                <div class="brand-info">
                    <div class="brand-name">Stitch<span>Smart</span></div>
                    <div class="brand-tagline">Premium Collection</div>
                </div>
            </a>
            <div class="navbar-right d-flex align-items-center gap-3">
                <form method="GET" action="<?= url('allproducts'); ?>" class="search-form d-flex align-items-center">
                    <div class="search-input-group">
                        <input 
                            type="text" 
                            id="searchInput"
                            name="search" 
                            class="search-input"
                            placeholder="Search products..."
                            autocomplete="off"
                        >
                        <button type="submit" class="search-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                <div id="globalSuggestions" class="search-suggestions"></div>
            </div>
        </div>
    </div>
</nav>

<!-- Categories Navbar (Separate Row) -->
<div class="categories-bar border-top border-bottom py-2">
    <div class="container">

        <div class="category-row d-flex flex-column flex-lg-row align-items-center justify-content-center gap-4">
            <button class="btn w-100 text-start d-lg-none mb-2 menu-toggle"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#categoryMenu">
                ☰ Menu
            </button>

            <div class="collapse d-lg-block w-100" id="categoryMenu">
                <div class="d-flex flex-nowrap align-items-center justify-content-between mt-2 mt-lg-0 w-100" style="padding: 10px 0; overflow-x: auto; white-space: nowrap; scrollbar-width: none;">
                    <style>.d-flex.flex-nowrap::-webkit-scrollbar { display: none; }</style>
                    <div class="d-flex align-items-center gap-2">
                        <a href="<?= url('allproducts'); ?>" class="btn btn-action btn-unified">
                            <i class="bi bi-grid me-2"></i> Shop All
                        </a>
                        <a href="<?= url('about-us'); ?>" class="btn btn-action btn-unified">
                            <i class="bi bi-info-circle me-2"></i> About Us
                        </a>
                        <a href="<?= url('sale'); ?>" class="btn btn-action btn-unified btn-sale-highlight">
                            <i class="bi bi-tag-fill me-2"></i> Sale
                        </a>
                        <a href="<?= url('design'); ?>" class="btn btn-action btn-unified">
                            <i class="bi bi-pencil-square me-2"></i> Design
                        </a>
                        <a href="<?= url('product_compare'); ?>" class="btn btn-action position-relative btn-unified">
                            <i class="bi bi-bar-chart-line me-2"></i> Compare
                        </a>
                        <?php if (!empty($_SESSION['customer_id'])): ?>
                            <a href="<?= url('customer_orders'); ?>" class="btn btn-action btn-unified" title="View Orders">
                                <i class="bi bi-box-seam me-2"></i> Orders
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <?php if (!empty($_SESSION['customer_id'])): ?>
                            <span class="btn btn-action btn-unified text-warning fw-bold px-3" style="cursor: default; background: rgba(202, 151, 69, 0.12); border-color: rgba(202, 151, 69, 0.35);">
                                <i class="bi bi-person-fill me-2"></i><?= htmlspecialchars($_SESSION['customer_name'] ?? 'Account'); ?>
                            </span>
                            <a href="<?= url('customer_logout'); ?>" class="btn btn-action btn-unified" title="Logout">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        <?php else: ?>
                            <a href="<?= url('customer_login'); ?>" class="btn btn-action btn-unified">
                                <i class="bi bi-lock me-2"></i> Login
                            </a>
                        <?php endif; ?>
                        <a href="<?= url('customer_wishlist'); ?>" class="btn btn-action position-relative btn-unified" title="Wishlist">
                            <i class="bi bi-heart me-2"></i> Wishlist
                        </a>
                        <a href="<?= url('cart'); ?>" class="btn btn-action cart-btn position-relative btn-unified" title="Shopping Cart">
                            <i class="bi bi-cart3 me-2"></i> Cart
                            <?php if ($cartCount > 0): ?>
                                <span class="cart-badge" style="position: relative !important; top: 0 !important; right: 0 !important; margin-left: 8px !important; transform: none !important; display: inline-flex !important; align-items: center; justify-content: center;"><?= $cartCount ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Collect notifications
$notifications = [];
if (isset($_SESSION['success'])) {
    $notifications[] = ['type' => 'success', 'title' => 'Success', 'message' => $_SESSION['success']];
    unset($_SESSION['success']);
}
if (isset($_SESSION['cart_success'])) {
    $notifications[] = ['type' => 'success', 'title' => 'Success', 'message' => $_SESSION['cart_success']];
    unset($_SESSION['cart_success']);
}
if (isset($_SESSION['cart_error'])) {
    $notifications[] = ['type' => 'error', 'title' => 'Error', 'message' => $_SESSION['cart_error']];
    unset($_SESSION['cart_error']);
}
if (isset($_SESSION['error'])) {
    $notifications[] = ['type' => 'error', 'title' => 'Error', 'message' => $_SESSION['error']];
    unset($_SESSION['error']);
}
if (isset($_SESSION['errors'])) {
    $msg = '<ul class="mb-0 ps-3">';
    foreach ($_SESSION['errors'] as $err) {
        $msg .= '<li>' . htmlspecialchars($err) . '</li>';
    }
    $msg .= '</ul>';
    $notifications[] = ['type' => 'error', 'title' => 'Errors', 'message' => $msg, 'isHtml' => true];
    unset($_SESSION['errors']);
}
?>

<?php if (!empty($notifications)): ?>
    <?php foreach ($notifications as $n): ?>
        <div class="ss-toast ss-toast--<?= $n['type'] ?>" role="alert" aria-live="assertive">
            <div class="ss-toast__icon">
                <i class="bi bi-<?= $n['type'] === 'success' ? 'check-lg' : 'exclamation-triangle' ?>"></i>
            </div>
            <div class="ss-toast__body">
                <div class="ss-toast__label"><?= htmlspecialchars($n['title']) ?></div>
                <div class="ss-toast__message">
                    <?= !empty($n['isHtml']) ? $n['message'] : htmlspecialchars($n['message']) ?>
                </div>
            </div>
            <button class="ss-toast__close" aria-label="Close" onclick="this.closest('.ss-toast').classList.add('ss-toast--hiding'); setTimeout(()=>this.closest('.ss-toast').remove(),350);">&times;</button>
            <div class="ss-toast__progress <?= $n['type'] === 'error' ? 'ss-toast__progress--error' : '' ?>"></div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

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
    white-space: normal;
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

<style>
    /* ── Shop Dropdown ── */
    .header-shop-dropdown {
        position: relative;
    }
    .header-shop-toggle .shop-caret {
        font-size: 0.65em;
        vertical-align: middle;
        margin-left: 2px;
        transition: transform 0.2s;
    }
    .header-shop-menu {
        display: none;
        position: absolute;
        top: calc(100% + 4px);
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        border: 1px solid rgba(202, 151, 69,0.2);
        border-radius: 12px;
        box-shadow: 0 12px 32px rgba(0,0,0,0.10);
        min-width: 150px;
        padding: 8px 0;
        list-style: none;
        margin: 0;
        z-index: 99999;
    }
    .header-shop-dropdown:hover .header-shop-menu {
        display: block;
    }
    .header-shop-dropdown:hover .shop-caret {
        transform: rotate(180deg);
    }
    .header-shop-menu li a {
        display: block;
        padding: 9px 20px;
        color: #1a0f0a;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: background 0.2s, color 0.2s;
        white-space: nowrap;
    }
    .header-shop-menu li a:hover {
        background: rgba(202, 151, 69,0.10);
        color: #ca9745;
    }

    #globalSuggestions {
        position: fixed !important;
        z-index: 999999 !important;
    }
    #globalSuggestions.active {
        display: block !important;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("searchInput");
    const box = document.getElementById("globalSuggestions");

    if (!input || !box) return;

    // Ensure suggestions are not trapped inside the navbar stacking context
    if (box.parentElement !== document.body) {
        document.body.appendChild(box);
    }

    let searchTimeout = null;
    function triggerLiveSearch() {
        let query = input.value.trim();

        if (query.length < 1) {
            box.innerHTML = "";
            box.classList.remove('active');
            return;
        }

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetch("<?= url('live_search?q='); ?>" + encodeURIComponent(query), { credentials: 'same-origin' })
            .then(res => res.json())
            .then(data => {
                let html = "";

                if (data.length > 0) {
                    data.forEach(item => {
                        let url = item.type === 'category'
                            ? '<?= url('allproducts?category_id='); ?>' + item.id
                            : '<?= url('product_show?id='); ?>' + item.id;
                        let label = item.type === 'category'
                            ? '<span class="category-badge">Category</span>'
                            : '';

                        let priceBadge = item.price ? `<div class="suggest-price text-muted small" style="font-size: 0.8rem; color: #ca9745 !important; font-weight: 600;">Rs. ${item.price}</div>` : '';
                        html += `
                            <a href="${url}" class="suggest-item" style="display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-bottom: 1px solid rgba(202, 151, 69,0.1); transition: background 0.2s; text-decoration: none; color: inherit; cursor: pointer;">
                                <img src="<?= BASE_URL ?>/${item.image}" width="42" height="42" alt="${item.name}" style="border-radius: 6px; object-fit: cover;">
                                <div class="suggest-info" style="flex: 1; min-width: 0;">
                                    <div class="suggest-name" style="font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${item.name}</div>
                                    ${label} ${priceBadge}
                                </div>
                            </a>
                        `;
                    });
                    box.innerHTML = html;
                    box.classList.add('active');
                    positionSuggestions();
                } else {
                    html = `<div class="suggest-empty">No products found</div>`;
                    box.innerHTML = html;
                    box.classList.add('active');
                    positionSuggestions();
                }

            })
            .catch(err => console.error('Search error:', err));
        }, 120);
    }

    input.addEventListener("input", triggerLiveSearch);
    input.addEventListener("keyup", triggerLiveSearch);
    input.addEventListener("click", function() {
        if (input.value.trim().length >= 1) {
            triggerLiveSearch();
        }
    });

    // Position suggestion box using fixed positioning so it overlays header buttons
    function positionSuggestions() {
        const rect = input.getBoundingClientRect();
        box.style.setProperty('position', 'fixed', 'important');
        box.style.setProperty('left', rect.left + 'px', 'important');
        box.style.setProperty('top', (rect.bottom + 8) + 'px', 'important');
        box.style.setProperty('width', rect.width + 'px', 'important');
        box.style.setProperty('right', 'auto', 'important');
        box.style.setProperty('z-index', '999999', 'important');
        box.style.setProperty('max-width', 'calc(100vw - 32px)', 'important');
    }

    // Hide suggestions on scroll/resize to avoid misplacement
    window.addEventListener('scroll', function() {
        box.classList.remove('active');
        box.innerHTML = '';
    });
    window.addEventListener('resize', function() {
        box.classList.remove('active');
        box.innerHTML = '';
    });

    // Show recent searches when input is focused and empty
    input.addEventListener('focus', function() {
        const query = this.value.trim();
        if (query.length === 0) {
            // fetch recent searches for logged-in users
            fetch("<?= url('user_search_history'); ?>", { credentials: 'same-origin' })
                .then(res => res.json())
                .then(data => {
                    if (!data.searches || data.searches.length === 0) return;
                    let html = '';
                    data.searches.forEach(s => {
                        html += `
                            <div class="suggest-item recent-search" data-query="${encodeURIComponent(s.query)}">
                                <div class="suggest-info">
                                    <div class="suggest-name">${s.query}</div>
                                    <div class="suggest-meta small text-muted">${s.created_at}</div>
                                </div>
                            </div>
                        `;
                    });
                    box.innerHTML = html;
                    box.classList.add('active');
                    positionSuggestions();
                }).catch(()=>{});
        }
    });

    // Click on a recent search -> perform search
    box.addEventListener('click', function(e) {
        const item = e.target.closest('.recent-search');
        if (!item) return;
        const q = decodeURIComponent(item.getAttribute('data-query') || '');
        if (!q) return;
        // set input and submit the search form
        input.value = q;
        const form = input.closest('form');
        if (form) form.submit();
    });

    // Close suggestions on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar-right') && !e.target.closest('#globalSuggestions')) {
            box.innerHTML = "";
            box.classList.remove('active');
        }
    });

    // Keep mega menu open while cursor moves inside dropdown
    const megaDropdown = document.querySelector('.nav-item.dropdown-mega');
    const megaMenu = megaDropdown?.querySelector('.dropdown-menu');
    let megaCloseTimer;
    let megaOpenTimer;

    if (megaDropdown && megaMenu) {
        const openMegaMenu = () => {
            clearTimeout(megaCloseTimer);
            megaDropdown.classList.add('show');
            megaMenu.classList.add('show');
        };

        const closeMegaMenu = () => {
            megaCloseTimer = setTimeout(() => {
                megaDropdown.classList.remove('show');
                megaMenu.classList.remove('show');
            }, 220);
        };

        megaDropdown.addEventListener('mouseenter', () => {
            clearTimeout(megaCloseTimer);
            megaOpenTimer = setTimeout(openMegaMenu, 80);
        });

        megaDropdown.addEventListener('mouseleave', () => {
            clearTimeout(megaOpenTimer);
            closeMegaMenu();
        });

        megaMenu.addEventListener('mouseenter', () => {
            clearTimeout(megaCloseTimer);
        });

        megaMenu.addEventListener('mouseleave', closeMegaMenu);
    }
});

function showMegaSub(id, link) {
    document.querySelectorAll('.sub-content-panel').forEach(panel => {
        panel.classList.toggle('d-none', panel.id !== id);
    });
    document.querySelectorAll('.mega-menu-main-panel .nav-link').forEach(item => {
        item.classList.toggle('active', item === link);
    });
}
</script>
<?php if (empty($hide_chatbot)): ?>
<!-- Professional Floating Chatbot Widget -->
<div id="chat-widget" style="position: fixed !important; bottom: 28px !important; right: 28px !important; z-index: 200000 !important;">
    <!-- Chat Toggle Button -->
    <button id="chat-toggle" aria-label="Open chat">
        <svg id="chat-icon-open" xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
            <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1H2z"/>
        </svg>
        <svg id="chat-icon-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" style="display:none;">
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>
        <span id="chat-unread" style="display:none;">1</span>
    </button>

    <!-- Chat Window -->
    <div id="chat-window">
        <!-- Header -->
        <div id="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5ZM3 8.062C3 6.76 4.235 5.765 5.53 5.886a26.58 26.58 0 0 0 4.94 0C11.765 5.765 13 6.76 13 8.062v1.157a.933.933 0 0 1-.765.935c-.845.147-2.34.346-4.235.346-1.895 0-3.39-.2-4.235-.346A.933.933 0 0 1 3 9.219V8.062Zm4.542-.827a.25.25 0 0 0-.217.068l-.92.9a24.767 24.767 0 0 1-1.871-.183.25.25 0 0 0-.068.495c.55.076 1.232.149 2.02.193a.25.25 0 0 0 .189-.071l.754-.736.847 1.71a.25.25 0 0 0 .404.062l.932-.97a25.286 25.286 0 0 0 1.922-.188.25.25 0 0 0-.068-.495c-.538.074-1.207.145-1.98.189a.25.25 0 0 0-.166.076l-.754.785-.842-1.7a.25.25 0 0 0-.182-.135Z"/>
                        <path d="M8.5 1.866a1 1 0 1 0-1 0V3h-2A4.5 4.5 0 0 0 1 7.5V8a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v1a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-1a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1v-.5A4.5 4.5 0 0 0 10.5 3h-2V1.866Z"/>
                    </svg>
                </div>
                <div>
                    <div class="chat-header-title"><?= APP_NAME ?> Assistant</div>
                    <div class="chat-header-status"><span class="status-dot"></span> Online</div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <button id="chat-minimize" aria-label="Minimize chat" class="me-2" style="background:none; border:none; color:inherit;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </button>
                <button id="chat-close" aria-label="Close chat" style="background:none; border:none; color:inherit;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </button>
            </div>
        </div>

        <div id="chat-messages">
            <div class="chat-welcome">
                <div class="chat-choice-grid">
                    <!-- WhatsApp Support Button -->
                    <a href="https://wa.link/twb6nv" target="_blank" class="chat-choice-card support">
                        <div class="choice-icon"><i class="bi bi-whatsapp"></i></div>
                        <div class="choice-label">Customer Care</div>
                    </a>
                    
                    <!-- AI Assistant Button -->
                    <button type="button" class="chat-choice-card ai" onclick="document.getElementById('chat-input').focus()">
                        <div class="choice-icon"><i class="bi bi-robot"></i></div>
                        <div class="choice-label">AI Assistant</div>
                    </button>
                </div>
                
                <p class="welcome-intro">How can we help you today? Explore our latest collections or talk to a real person instantly.</p>
                <div class="whatsapp-hint">No phone number save required for WhatsApp</div>
            </div>
            <div class="quick-actions">
                <?php foreach($categories as $cat): ?>
                <button class="quick-btn" data-msg="Show me your <?= htmlspecialchars($cat['c_name']) ?> collection">🏷️ <?= htmlspecialchars($cat['c_name']) ?></button>
                <?php endforeach; ?>
                <button class="quick-btn" data-msg="What are your cheapest products?">💰 Budget Picks</button>
                <button class="quick-btn" data-msg="What sizes do you have available?">📏 Size Guide</button>
                <button class="quick-btn" data-msg="What is your shipping and return policy?">📦 Shipping Info</button>
            </div>
        </div>

        <!-- Input Area -->
        <div id="chat-input-area">
            <form id="chat-form">
                <input type="text" id="chat-input" placeholder="Type your message..." autocomplete="off">
                <button type="submit" id="chat-send" aria-label="Send message">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.5.5 0 0 1-.928.086l-2.17-4.776-4.777-2.17a.5.5 0 0 1 .086-.929L14.854.146a.5.5 0 0 1 .54.11ZM6.636 10.07l1.33 2.924 3.558-8.896-4.888 5.972Zm6.182-8.776L4.422 5.856l2.924 1.33 5.472-5.892Z"/>
                    </svg>
                </button>
            </form>
            <div class="chat-powered">Powered by AI</div>
        </div>
    </div>
</div>
<?php endif; ?>

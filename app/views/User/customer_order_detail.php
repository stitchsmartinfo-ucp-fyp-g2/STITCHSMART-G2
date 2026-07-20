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
    <title>StitchSmart - Order Details</title>
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
   ORDER DETAIL – PREMIUM DESIGN (THEME-PROOF)
   Uses .co-page variables to support both Luxury and Default
   ============================================================ */

/* ── DEFAULT (LIGHT) THEME ───────────────────────────────── */
.co-page {
    --co-bg:            #F8F4EE;
    --co-card-bg:       #FFFFFF;
    --co-text-h:        #24150F;
    --co-text-body:     #5C4335;
    --co-text-muted:    #9C8575;
    --co-accent:        #ca9745;
    --co-accent-grad:   linear-gradient(135deg,#ca9745,#ca9745);
    --co-accent-soft:   rgba(205,154,72,0.12);
    --co-border:        rgba(92,60,38,0.14);
    --co-btn-text:      #fff;
    --co-shadow-sm:     0 2px 12px rgba(36,21,15,0.08);
    --co-shadow-md:     0 10px 32px rgba(36,21,15,0.12);
}

/* ── LUXURY (DARK) THEME ─────────────────────────────────── */
:root.theme-luxury .co-page {
    --co-bg:            #050505;
    --co-card-bg:       #111111;
    --co-text-h:        #F4E9D3;
    --co-text-body:     rgba(244,233,211,0.85);
    --co-text-muted:    rgba(244,233,211,0.48);
    --co-accent:        #ca9745;
    --co-accent-grad:   linear-gradient(135deg,#ca9745,#8A6421);
    --co-accent-soft:   rgba(202, 151, 69,0.18);
    --co-border:        rgba(202, 151, 69,0.18);
    --co-btn-text:      #fff;
    --co-shadow-sm:     0 2px 14px rgba(0,0,0,0.40);
    --co-shadow-md:     0 10px 34px rgba(0,0,0,0.55);
}

    .order-detail-page {
        min-height: 100vh;
        background: var(--co-bg) !important;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif !important;
        padding-bottom: 5rem;
    }
    .order-detail-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, rgba(202, 151, 69,0.05), transparent 40%);
        pointer-events: none;
    }
    .order-detail-hero {
        position: relative;
        overflow: hidden;
        background: var(--co-card-bg) !important;
        border-radius: 34px;
        padding: 46px 40px;
        margin-bottom: 34px;
        color: var(--co-text-h) !important;
        box-shadow: var(--co-shadow-md) !important;
        border: 1px solid var(--co-border) !important;
        animation: fadeInUp 0.7s ease forwards;
    }
    .order-detail-hero h1 {
        font-size: 2.8rem;
        letter-spacing: -0.04em;
        color: var(--co-text-h) !important;
        font-family: 'Playfair Display', serif !important;
        font-weight: 800;
        margin-bottom: 8px;
    }
    .order-detail-meta {
        color: var(--co-text-muted) !important;
        font-size: 1.05rem;
    }
    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 0.55rem 1.15rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        background: var(--co-accent-soft) !important;
        color: var(--co-accent) !important;
        border: 1px solid var(--co-accent) !important;
    }
    
    /* Stepper Styling */
    .co-stepper-container {
        position: relative;
        margin-top: 40px;
        padding: 20px 0 10px;
    }
    .co-stepper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 10;
    }
    .co-stepper-line {
        position: absolute;
        top: 42px;
        left: 5%;
        right: 5%;
        height: 4px;
        background: var(--co-border);
        z-index: 1;
    }
    .co-stepper-progress {
        position: absolute;
        top: 42px;
        left: 5%;
        height: 4px;
        background: var(--co-accent-grad);
        z-index: 2;
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .co-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 5;
        flex: 1;
    }
    .co-step-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--co-card-bg);
        border: 2px solid var(--co-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--co-text-muted);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--co-shadow-sm);
    }
    .co-step-label {
        margin-top: 12px;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--co-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        transition: all 0.3s ease;
    }

    /* Completed Step */
    .co-step.completed .co-step-icon {
        background: var(--co-accent-grad);
        border-color: var(--co-accent);
        color: #fff !important;
        box-shadow: 0 0 15px var(--co-accent-soft);
    }
    .co-step.completed .co-step-label {
        color: var(--co-text-h) !important;
    }

    /* Active Step */
    .co-step.active .co-step-icon {
        background: var(--co-card-bg);
        border-color: var(--co-accent);
        color: var(--co-accent) !important;
        box-shadow: 0 0 20px var(--co-accent-soft);
        transform: scale(1.15);
    }
    .co-step.active .co-step-label {
        color: var(--co-accent) !important;
        font-weight: 800;
    }

    /* Cancelled Stepper */
    .co-stepper.cancelled-stepper .co-step-icon {
        background: rgba(239, 68, 68, 0.1);
        border-color: #ef4444;
        color: #ef4444 !important;
        box-shadow: 0 0 15px rgba(239, 68, 68, 0.2);
    }
    .co-stepper.cancelled-stepper .co-step-label {
        color: #ef4444 !important;
    }
    
    .order-insights {
        margin-top: 26px;
    }
    .insight-card {
        background: var(--co-card-bg) !important;
        border: 1px solid var(--co-border) !important;
        border-radius: 28px;
        padding: 22px 24px;
        box-shadow: var(--co-shadow-sm) !important;
        color: var(--co-text-h) !important;
        text-align: center;
        transition: all 0.26s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .insight-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--co-shadow-md) !important;
        border-color: var(--co-accent) !important;
    }
    .insight-card span {
        display: block;
        color: var(--co-text-muted) !important;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 0.75rem;
        margin-bottom: 0.7rem;
        font-weight: 700;
    }
    .insight-card strong {
        font-size: 1.65rem;
        color: var(--co-text-h) !important;
        font-weight: 800;
    }
    
    .order-summary-card,
    .order-items-card {
        background: var(--co-card-bg) !important;
        border: 1px solid var(--co-border) !important;
        border-radius: 28px;
        box-shadow: var(--co-shadow-sm) !important;
        transition: all 0.28s ease;
    }
    .order-summary-card h5,
    .order-items-card h5 {
        color: var(--co-text-h) !important;
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        font-weight: 800;
        font-family: 'Playfair Display', serif !important;
        border-bottom: 1px solid var(--co-border);
        padding-bottom: 12px;
    }
    .order-summary-list {
        display: flex;
        flex-direction: column;
        gap: 0.95rem;
    }
    .detail-block {
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        padding: 1rem 1.15rem;
        border-radius: 20px;
        background: rgba(202, 151, 69,0.03) !important;
        border: 1px solid var(--co-border) !important;
        overflow: hidden;
        transition: all 0.22s ease;
    }
    .detail-block:hover {
        transform: translateY(-2px);
        border-color: var(--co-accent) !important;
        background: rgba(202, 151, 69,0.06) !important;
    }
    .detail-label {
        color: var(--co-text-muted) !important;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.16em;
        font-weight: 800;
    }
    .detail-value {
        color: var(--co-text-body) !important;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.4;
    }
    .detail-value.small-soft {
        font-size: 0.92rem;
    }
    .order-summary-card .label {
        color: var(--co-text-muted) !important;
        font-size: 0.95rem;
    }
    .order-summary-card .fw-semibold {
        color: var(--co-text-h) !important;
    }
    
    .order-items-card table thead th {
        border-bottom: 2px solid var(--co-border) !important;
        color: var(--co-text-muted) !important;
        font-weight: 800;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding-bottom: 12px;
    }
    .order-items-card table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }
    .order-items-card table tbody tr {
        background: rgba(202, 151, 69,0.02) !important;
        transition: all 0.2s ease;
    }
    .order-items-card table tbody tr:hover {
        background: rgba(202, 151, 69,0.06) !important;
        transform: translateY(-2px);
    }
    .order-items-card table tbody td {
        color: var(--co-text-body) !important;
        vertical-align: middle;
        padding: 1rem;
        border: none;
    }
    .order-items-card table tbody td:first-child {
        border-top-left-radius: 18px;
        border-bottom-left-radius: 18px;
    }
    .order-items-card table tbody td:last-child {
        border-top-right-radius: 18px;
        border-bottom-right-radius: 18px;
    }
    .order-items-card .product-cell {
        display: flex;
        align-items: center;
        gap: 0.95rem;
        text-align: left;
    }
    .order-items-card img {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 14px;
        border: 1px solid var(--co-border) !important;
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }
    .order-items-card table tbody tr:hover img {
        transform: scale(1.08);
    }
    .order-summary-row {
        border-top: 1px solid var(--co-border) !important;
        padding-top: 22px;
        margin-top: 24px;
    }
    .order-summary-row .label {
        color: var(--co-text-muted) !important;
    }
    .order-summary-row .amount {
        color: var(--co-text-h) !important;
        font-weight: 800;
    }
    .text-muted {
        color: var(--co-text-muted) !important;
    }
    .order-detail-hero .hero-top-row {
        align-items: center;
    }
    .btn-back-orders {
        background: var(--co-accent-grad);
        border: none;
        color: var(--co-btn-text) !important;
        padding: 0.85rem 1.8rem;
        border-radius: 999px;
        font-weight: 800;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(202, 151, 69,0.25);
    }
    .btn-back-orders:hover,
    .btn-back-orders:focus,
    .btn-back-orders:active {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(202, 151, 69,0.4) !important;
        color: var(--co-btn-text) !important;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<section class="py-5 order-detail-page co-page">
    <div class="container">
        <?php if (isset($_SESSION['review_success'])): ?>
            <div class="ss-toast ss-toast--success" role="alert" aria-live="assertive">
                <div class="ss-toast__icon">
                    <i class="bi bi-check-lg"></i>
                </div>
                <div class="ss-toast__body">
                    <div class="ss-toast__label">Success</div>
                    <div class="ss-toast__message"><?= htmlspecialchars($_SESSION['review_success']); ?></div>
                </div>
                <button class="ss-toast__close" aria-label="Close" onclick="this.closest('.ss-toast').classList.add('ss-toast--hiding'); setTimeout(()=>this.closest('.ss-toast').remove(),350);">&times;</button>
                <div class="ss-toast__progress"></div>
            </div>
            <?php unset($_SESSION['review_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['review_error'])): ?>
            <div class="ss-toast ss-toast--error" role="alert" aria-live="assertive">
                <div class="ss-toast__icon">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="ss-toast__body">
                    <div class="ss-toast__label">Notice</div>
                    <div class="ss-toast__message"><?= htmlspecialchars($_SESSION['review_error']); ?></div>
                </div>
                <button class="ss-toast__close" aria-label="Close" onclick="this.closest('.ss-toast').classList.add('ss-toast--hiding'); setTimeout(()=>this.closest('.ss-toast').remove(),350);">&times;</button>
                <div class="ss-toast__progress ss-toast__progress--error"></div>
            </div>
            <?php unset($_SESSION['review_error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['return_success'])): ?>
            <div class="ss-toast ss-toast--success" role="alert" aria-live="assertive">
                <div class="ss-toast__icon">
                    <i class="bi bi-check-lg"></i>
                </div>
                <div class="ss-toast__body">
                    <div class="ss-toast__label">Success</div>
                    <div class="ss-toast__message"><?= htmlspecialchars($_SESSION['return_success']); ?></div>
                </div>
                <button class="ss-toast__close" aria-label="Close" onclick="this.closest('.ss-toast').classList.add('ss-toast--hiding'); setTimeout(()=>this.closest('.ss-toast').remove(),350);">&times;</button>
                <div class="ss-toast__progress"></div>
            </div>
            <?php unset($_SESSION['return_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['return_error'])): ?>
            <div class="ss-toast ss-toast--error" role="alert" aria-live="assertive">
                <div class="ss-toast__icon">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="ss-toast__body">
                    <div class="ss-toast__label">Notice</div>
                    <div class="ss-toast__message"><?= htmlspecialchars($_SESSION['return_error']); ?></div>
                </div>
                <button class="ss-toast__close" aria-label="Close" onclick="this.closest('.ss-toast').classList.add('ss-toast--hiding'); setTimeout(()=>this.closest('.ss-toast').remove(),350);">&times;</button>
                <div class="ss-toast__progress ss-toast__progress--error"></div>
            </div>
            <?php unset($_SESSION['return_error']); ?>
        <?php endif; ?>
        
        <div class="order-detail-hero">
            <div class="row hero-top-row gy-3">
                <div class="col-lg-8 text-center text-lg-start">
                    <h1>Order #<?= htmlspecialchars($order['id']); ?></h1>
                    <p class="order-detail-meta mb-0">
                        Placed on <?= htmlspecialchars($order['created_at'] ?? 'N/A'); ?> • 
                        <span class="badge-status"><?= htmlspecialchars(ucfirst($order['status'])); ?></span>
                    </p>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <a href="<?= url('customer_orders') ?>" class="btn btn-back-orders">
                        <i class="bi bi-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>

            <!-- Interactive Stepper -->
            <?php 
            $status = strtolower(trim($order['status'] ?? 'pending'));
            $currentStep = 1; // Placed (Pending)
            if (strpos($status, 'processing') !== false) {
                $currentStep = 2;
            } elseif (strpos($status, 'dispatch') !== false) {
                $currentStep = 3;
            } elseif (strpos($status, 'transit') !== false) {
                $currentStep = 4;
            } elseif (strpos($status, 'out') !== false) {
                $currentStep = 5;
            } elseif (strpos($status, 'deliver') !== false) {
                $currentStep = 6;
            } elseif (strpos($status, 'cancel') !== false) {
                $currentStep = -1;
            }

            $progressWidth = 0;
            if ($currentStep == 2) $progressWidth = 20;
            elseif ($currentStep == 3) $progressWidth = 40;
            elseif ($currentStep == 4) $progressWidth = 60;
            elseif ($currentStep == 5) $progressWidth = 80;
            elseif ($currentStep == 6) $progressWidth = 100;
            ?>

            <div class="co-stepper-container">
                <?php if ($currentStep === -1): ?>
                    <div class="co-stepper cancelled-stepper justify-content-center">
                        <div class="co-step">
                            <div class="co-step-icon">
                                <i class="bi bi-x-lg"></i>
                            </div>
                            <div class="co-step-label">Order Cancelled</div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="co-stepper-line"></div>
                    <div class="co-stepper-progress" style="width: <?= $progressWidth ?>%;"></div>
                    <div class="co-stepper">
                        <div class="co-step <?= $currentStep >= 1 ? ($currentStep == 1 ? 'active' : 'completed') : '' ?>">
                            <div class="co-step-icon">
                                <?= $currentStep > 1 ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-bag-check"></i>' ?>
                            </div>
                            <div class="co-step-label">Placed</div>
                        </div>
                        <div class="co-step <?= $currentStep >= 2 ? ($currentStep == 2 ? 'active' : 'completed') : '' ?>">
                            <div class="co-step-icon">
                                <?= $currentStep > 2 ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-gear-fill"></i>' ?>
                            </div>
                            <div class="co-step-label">Processing</div>
                        </div>
                        <div class="co-step <?= $currentStep >= 3 ? ($currentStep == 3 ? 'active' : 'completed') : '' ?>">
                            <div class="co-step-icon">
                                <?= $currentStep > 3 ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-box-seam"></i>' ?>
                            </div>
                            <div class="co-step-label">Dispatched</div>
                        </div>
                        <div class="co-step <?= $currentStep >= 4 ? ($currentStep == 4 ? 'active' : 'completed') : '' ?>">
                            <div class="co-step-icon">
                                <?= $currentStep > 4 ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-truck"></i>' ?>
                            </div>
                            <div class="co-step-label">In Transit</div>
                        </div>
                        <div class="co-step <?= $currentStep >= 5 ? ($currentStep == 5 ? 'active' : 'completed') : '' ?>">
                            <div class="co-step-icon">
                                <?= $currentStep > 5 ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-geo-alt-fill"></i>' ?>
                            </div>
                            <div class="co-step-label">Out for Delivery</div>
                        </div>
                        <div class="co-step <?= $currentStep >= 6 ? ($currentStep == 6 ? 'active' : 'completed') : '' ?>">
                            <div class="co-step-icon">
                                <?= $currentStep > 6 ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-house-check-fill"></i>' ?>
                            </div>
                            <div class="co-step-label">Delivered</div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row order-insights mt-4 g-3">
                <div class="col-md-4">
                    <div class="insight-card">
                        <span>Items</span>
                        <strong><?= htmlspecialchars(count($items)); ?></strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="insight-card">
                        <span>Order Total</span>
                        <strong>Rs <?= number_format($order['total'], 2); ?></strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="insight-card">
                        <span>Payment Method</span>
                        <strong><?= htmlspecialchars(strtoupper($order['payment_method'] ?? 'COD')); ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="order-items-card p-4">
                    <h5>Order Items</h5>
                    <?php if (empty($items)): ?>
                        <p class="text-muted">This order has no saved items.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th style="min-width: 260px;">Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="product-cell">
                                                    <?php $productImage = strtok($item['product_image'] ?? '', ','); ?>
                                                    <?php if ($productImage): ?>
                                                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($productImage)); ?>" alt="<?= htmlspecialchars($item['product_name'] ?? 'Product'); ?>" class="rounded-3">
                                                    <?php endif; ?>
                                                    <div>
                                                        <div class="fw-semibold text-white"><?= htmlspecialchars($item['product_name'] ?? 'Product'); ?></div>
                                                        <div class="text-muted small">SKU: <?= htmlspecialchars($item['product_id'] ?? 'N/A'); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted">Rs <?= number_format($item['price'], 2); ?></td>
                                            <td class="text-muted"><?= htmlspecialchars($item['quantity']); ?></td>
                                            <td class="fw-semibold text-white">Rs <?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                                            <td>
                                                <?php if (strtolower(trim($order['status'])) === 'delivered'): ?>
                                                    <?php if (isset($itemReturns[$item['id']])): ?>
                                                        <span class="badge bg-secondary px-3 py-2 text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;"><i class="bi bi-info-circle"></i> <?= htmlspecialchars(ucfirst($itemReturns[$item['id']])); ?></span>
                                                    <?php else: ?>
                                                    <a href="<?= url('customer_return_request?order_id=' . $order['id'] . '&item_id=' . $item['id']) ?>" 
                                                           class="btn btn-sm btn-outline-warning rounded-pill px-3 py-1" 
                                                           style="font-size: 0.8rem; font-weight: 600;">
                                                            <i class="bi bi-box-arrow-down-left"></i> Return
                                                        </a>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-muted small">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-summary-card p-4">
                    <h5>Order Summary</h5>
                    <div class="order-summary-list">
                        <div class="detail-block">
                            <div class="detail-label">Customer</div>
                            <div class="detail-value"><?= htmlspecialchars($order['customer_name']); ?></div>
                        </div>
                        <div class="detail-block">
                            <div class="detail-label">Email</div>
                            <div class="detail-value small-soft"><?= htmlspecialchars($order['email']); ?></div>
                        </div>
                        <div class="detail-block">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value"><?= htmlspecialchars($order['phone']); ?></div>
                        </div>
                        <div class="detail-block">
                            <div class="detail-label">Shipping Address</div>
                            <div class="detail-value small-soft" style="white-space: pre-line;"><?= nl2br(htmlspecialchars($order['address'])); ?></div>
                        </div>
                        <?php if (!empty($order['tracking_id'])): ?>
                            <div class="detail-block">
                                <div class="detail-label">Tracking ID</div>
                                <div class="detail-value"><?= htmlspecialchars($order['tracking_id']); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="order-summary-row">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="label">Order Total</span>
                            <span class="amount">Rs <?= number_format($order['total'], 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="label">Payment Status</span>
                            <span class="amount"><?= htmlspecialchars($order['status']); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="label">Shipping</span>
                            <span class="amount">Express</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>

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
    // Move all .ss-toast elements into the dedicated container after DOM ready
    function initToasts() {
        var container = document.getElementById('ss-toast-container');
        if (!container) return;
        document.querySelectorAll('.ss-toast').forEach(function(toast) {
            if (toast.parentElement !== container) {
                container.appendChild(toast);
            }
            // Auto-dismiss after 5s
            var timer = setTimeout(function() {
                toast.classList.add('ss-toast--hiding');
                setTimeout(function() { toast.remove(); }, 350);
            }, 5000);
            // Pause timer on hover
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include('footer.php'); ?>
</body>
</html>

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
    <title>StitchSmart - Request Return</title>
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
   RETURN REQUEST PAGE – PREMIUM DESIGN (THEME-PROOF)
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
    --co-input-bg:      #F8F4EE;
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
    --co-input-bg:      #1A1A1A;
}

    body.co-page {
        min-height: 100vh;
        background: var(--co-bg) !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        color: var(--co-text-body);
        padding-bottom: 5rem;
    }
    
    .return-container {
        max-width: 800px;
        margin: 0 auto;
        padding-top: 4rem;
    }

    .return-card {
        background: var(--co-card-bg);
        border: 1px solid var(--co-border);
        border-radius: 34px;
        padding: 40px 50px;
        box-shadow: var(--co-shadow-md);
        position: relative;
        overflow: hidden;
    }
    
    .return-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: var(--co-accent-grad);
    }

    .return-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--co-text-h);
        margin-bottom: 10px;
    }

    .return-header p {
        color: var(--co-text-muted);
        font-size: 1.05rem;
    }

    .product-preview {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 24px;
        border-radius: 20px;
        background: var(--co-input-bg);
        border: 1px solid var(--co-border);
        margin-top: 30px;
        margin-bottom: 40px;
    }

    .product-preview img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 16px;
        border: 1px solid var(--co-border);
    }

    .product-details h4 {
        color: var(--co-text-h);
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 5px;
    }

    .product-details p {
        margin: 0;
        color: var(--co-text-muted);
        font-size: 0.95rem;
    }

    .form-label {
        color: var(--co-text-muted);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .form-control, .form-select {
        background: var(--co-input-bg) !important;
        border: 1px solid var(--co-border) !important;
        color: var(--co-text-h) !important;
        padding: 14px 20px;
        border-radius: 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--co-accent) !important;
        box-shadow: 0 0 0 4px var(--co-accent-soft) !important;
    }
    
    select option {
        background: var(--co-card-bg);
        color: var(--co-text-h);
    }

    .btn-submit {
        background: var(--co-accent-grad);
        color: var(--co-btn-text) !important;
        border: none;
        padding: 16px 36px;
        font-weight: 800;
        border-radius: 999px;
        letter-spacing: 1px;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px var(--co-accent-soft);
        width: 100%;
        margin-top: 20px;
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px var(--co-accent-soft);
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--co-text-muted);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 20px;
        transition: color 0.3s ease;
    }

    .btn-back:hover {
        color: var(--co-accent);
    }
    
    .co-radio-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    
    .co-radio-card {
        position: relative;
        cursor: pointer;
    }
    
    .co-radio-card input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    
    .co-radio-card .card-content {
        padding: 20px;
        border-radius: 16px;
        border: 2px solid var(--co-border);
        background: var(--co-input-bg);
        transition: all 0.3s ease;
        text-align: center;
    }
    
    .co-radio-card input:checked ~ .card-content {
        border-color: var(--co-accent);
        background: var(--co-accent-soft);
    }
    
    .co-radio-card .card-content i {
        font-size: 1.5rem;
        color: var(--co-text-muted);
        margin-bottom: 10px;
        display: block;
        transition: color 0.3s ease;
    }
    
    .co-radio-card input:checked ~ .card-content i {
        color: var(--co-accent);
    }
    
    .co-radio-card .card-content span {
        color: var(--co-text-h);
        font-weight: 700;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .co-radio-group {
            grid-template-columns: 1fr;
        }
        .return-card {
            padding: 30px 20px;
        }
    }
</style>
</head>
<body class="co-page">

<div class="container return-container">
    <a href="<?= url('customer_order_detail?id=' . $orderId) ?>" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to Order Details
    </a>

    <div class="return-card">
        <div class="return-header">
            <h1>Request a Return</h1>
            <p>We're sorry it didn't work out. Please fill out the form below to process your return or report a damaged item.</p>
        </div>

        <div class="product-preview">
            <?php $productImage = strtok($item['product_image'] ?? '', ','); ?>
            <?php if ($productImage): ?>
                <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($productImage)); ?>" alt="<?= htmlspecialchars($item['product_name']); ?>">
            <?php else: ?>
                <div style="width:80px;height:80px;background:var(--co-border);border-radius:16px;"></div>
            <?php endif; ?>
            <div class="product-details">
                <h4><?= htmlspecialchars($item['product_name']); ?></h4>
                <p>Order #<?= htmlspecialchars($orderId); ?> • Max Quantity Available: <?= htmlspecialchars($item['quantity']); ?></p>
            </div>
        </div>

        <form action="<?= url('submit_return_request') ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <input type="hidden" name="order_id" value="<?= $orderId; ?>">
            <input type="hidden" name="item_id" value="<?= $itemId; ?>">

            <div class="mb-4">
                <label class="form-label">Return Type</label>
                <div class="co-radio-group">
                    <label class="co-radio-card">
                        <input type="radio" name="reason" value="Standard Return" required>
                        <div class="card-content">
                            <i class="bi bi-arrow-return-left"></i>
                            <span>Standard Return</span>
                        </div>
                    </label>
                    <label class="co-radio-card">
                        <input type="radio" name="reason" value="Damaged / Defective">
                        <div class="card-content">
                            <i class="bi bi-exclamation-triangle"></i>
                            <span>Damaged / Defective</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Quantity to Return</label>
                    <input type="number" name="quantity" class="form-control" min="1" max="<?= $item['quantity'] ?>" value="1" required>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <label class="form-label">Specific Issue</label>
                    <select name="details_reason" class="form-select">
                        <option value="" disabled selected>Select an option (Optional)</option>
                        <option value="Wrong Size / Fit">Wrong Size / Fit</option>
                        <option value="Color is Different">Color is Different</option>
                        <option value="Not as Expected">Not as Expected</option>
                        <option value="Item was Damaged">Item was Damaged in Transit</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Additional Comments / Damage Note</label>
                <textarea name="details" class="form-control" rows="4" placeholder="Please provide any extra details that will help us process your request faster..."></textarea>
            </div>

            <button type="submit" class="btn-submit">
                Submit Return Request <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include('footer.php'); ?>
</body>
</html>

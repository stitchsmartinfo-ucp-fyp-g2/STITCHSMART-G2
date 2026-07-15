<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= APP_NAME ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= BASE_URL ?>css/navbar.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>css/footer.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/colors.css">
  <link href="<?= BASE_URL ?>css/single-product.css" rel="stylesheet">
  <link href="<?= BASE_URL ?>css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Empty Cart Premium Styling */
    .empty-cart-wrapper {
      position: relative;
      width: 100%;
      min-height: 480px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px 0;
      z-index: 5;
    }

    .glow-orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(90px);
      z-index: 1;
      opacity: 0.35;
      pointer-events: none;
      transition: all 0.5s ease;
    }
    
    .orb-1 {
      width: 180px;
      height: 180px;
      background: rgba(202, 151, 69, 0.28);
      top: 10%;
      left: 15%;
    }
    
    .orb-2 {
      width: 240px;
      height: 240px;
      background: rgba(202, 151, 69, 0.18);
      bottom: 5%;
      right: 15%;
    }
    
    :root.theme-default .orb-1 {
      background: rgba(200, 154, 90, 0.16);
    }
    
    :root.theme-default .orb-2 {
      background: rgba(92, 67, 53, 0.1);
    }

    .empty-cart-container {
      position: relative;
      max-width: 600px;
      width: 100%;
      margin: 0 auto;
      padding: 60px 40px;
      border-radius: 28px;
      background: rgba(17, 17, 17, 0.45);
      border: 1px solid rgba(202, 151, 69, 0.18);
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35), inset 0 1px 1px rgba(255, 255, 255, 0.05);
      transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      z-index: 2;
      overflow: hidden;
    }
    
    /* Tailor stitched outline detail */
    .empty-cart-container::before {
      content: '';
      position: absolute;
      top: 15px;
      left: 15px;
      right: 15px;
      bottom: 15px;
      border: 1px dashed rgba(202, 151, 69, 0.25);
      border-radius: 20px;
      pointer-events: none;
      transition: border-color 0.3s ease;
    }
    
    :root.theme-default .empty-cart-container,
    :root.theme-luxury .empty-cart-container {
      background: rgba(255, 255, 255, 0.9) !important;
      border-color: rgba(205, 154, 72, 0.22) !important;
      box-shadow: 0 30px 60px rgba(92, 67, 53, 0.06), inset 0 1px 1px rgba(255, 255, 255, 0.8) !important;
    }

    :root.theme-default .empty-cart-container::before,
    :root.theme-luxury .empty-cart-container::before {
      border-color: rgba(205, 154, 72, 0.25) !important;
    }

    .empty-cart-container:hover {
      transform: translateY(-5px);
      border-color: rgba(202, 151, 69, 0.35);
      box-shadow: 0 40px 80px rgba(202, 151, 69, 0.12), 0 30px 65px rgba(0, 0, 0, 0.4);
    }

    :root.theme-default .empty-cart-container:hover {
      border-color: rgba(92, 67, 53, 0.3);
      box-shadow: 0 40px 80px rgba(92, 67, 53, 0.12);
    }

    .empty-cart-container:hover::before {
      border-color: rgba(202, 151, 69, 0.45);
    }
    
    :root.theme-default .empty-cart-container:hover::before {
      border-color: rgba(92, 67, 53, 0.45);
    }

    .empty-cart-icon-wrapper {
      display: inline-block;
      position: relative;
    }

    /* Ambient Pulsing Glow Circle */
    @keyframes pulseGlow {
      0% { box-shadow: 0 0 0 0 rgba(202, 151, 69, 0.45); }
      70% { box-shadow: 0 0 0 16px rgba(202, 151, 69, 0); }
      100% { box-shadow: 0 0 0 0 rgba(202, 151, 69, 0); }
    }
    
    @keyframes pulseGlowDefault {
      0% { box-shadow: 0 0 0 0 rgba(92, 67, 53, 0.25); }
      70% { box-shadow: 0 0 0 16px rgba(92, 67, 53, 0); }
      100% { box-shadow: 0 0 0 0 rgba(92, 67, 53, 0); }
    }

    .icon-circle {
      width: 105px;
      height: 105px;
      border-radius: 50%;
      background: linear-gradient(135deg, rgba(202, 151, 69, 0.15) 0%, rgba(202, 151, 69, 0.25) 100%);
      border: 1px solid rgba(202, 151, 69, 0.35);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      animation: pulseGlow 3s infinite;
    }
    
    :root.theme-default .icon-circle {
      background: linear-gradient(135deg, rgba(200, 154, 90, 0.12) 0%, rgba(200, 154, 90, 0.22) 100%);
      border-color: rgba(92, 67, 53, 0.28);
      animation: pulseGlowDefault 3s infinite;
    }

    .icon-circle i {
      font-size: 3.2rem;
      color: var(--accent-bronze, #ca9745);
      transition: transform 0.3s ease;
    }

    .empty-cart-container:hover .icon-circle {
      transform: scale(1.08) rotate(-6deg);
    }

    .empty-cart-title {
      font-family: 'Playfair Display', serif;
      font-size: 2.3rem;
      font-weight: 700;
      color: var(--accent-bronze, #ca9745);
      letter-spacing: 0.5px;
    }
    
    :root.theme-default .empty-cart-title,
    :root.theme-luxury .empty-cart-title {
      color: #3d241c !important;
    }

    .empty-cart-text {
      font-size: 1.08rem;
      color: var(--text-muted, rgba(255, 255, 255, 0.6));
      line-height: 1.7;
      font-weight: 400;
    }
    
    :root.theme-default .empty-cart-text,
    :root.theme-luxury .empty-cart-text {
      color: #5c4335 !important;
    }

    .btn-shop-now {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #ca9745 0%, #ca9745 100%);
      color: #1a0f0a !important;
      border: none;
      border-radius: 30px;
      padding: 15px 36px;
      font-size: 1rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      box-shadow: 0 8px 20px rgba(202, 151, 69, 0.25), 0 10px 20px rgba(0, 0, 0, 0.2);
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      position: relative;
      overflow: hidden;
      text-decoration: none;
    }
    
    :root.theme-default .btn-shop-now {
      background: linear-gradient(135deg, #ca9745 0%, #a88048 100%);
      color: #ffffff !important;
      box-shadow: 0 8px 20px rgba(92, 67, 53, 0.2), 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .btn-shop-now:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 25px rgba(202, 151, 69, 0.45), 0 15px 30px rgba(0, 0, 0, 0.25);
      color: #1a0f0a !important;
      text-decoration: none;
    }
    
    :root.theme-default .btn-shop-now:hover {
      color: #ffffff !important;
      box-shadow: 0 12px 25px rgba(92, 67, 53, 0.35), 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .btn-shop-now:active {
      transform: translateY(1px);
    }

    .btn-shop-now::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 60%;
      height: 100%;
      background: linear-gradient(
        to right,
        rgba(255, 255, 255, 0) 0%,
        rgba(255, 255, 255, 0.4) 50%,
        rgba(255, 255, 255, 0) 100%
      );
      transform: skewX(-25deg);
      pointer-events: none;
    }

    .btn-shop-now:hover::after {
      animation: btnShine 0.85s ease-in-out forwards;
    }
  </style>
</head>
<body class="theme-aware-body">
<?php include('header.php'); ?>
<main>
<div class="container py-5" >
    <h2 class="mb-4 text-center" style="font-family: 'Playfair Display', serif; font-weight: 700; letter-spacing: 1px;">Your Cart</h2>

    <?php if(empty($_SESSION['cart'])): ?>
        <div class="empty-cart-wrapper">
            <div class="glow-orb orb-1"></div>
            <div class="glow-orb orb-2"></div>
            
            <div class="empty-cart-container text-center py-5">
                <div class="empty-cart-icon-wrapper mb-4">
                    <div class="icon-circle">
                        <i class="bi bi-bag-x"></i>
                    </div>
                </div>
                <h3 class="empty-cart-title mb-3">Your Cart is Empty</h3>
                <p class="empty-cart-text mb-4">Looks like you haven't added anything to your cart yet.<br>Explore our premium collections and discover timeless, bespoke styles tailored just for you.</p>
                <a href="<?= url('allproducts') ?>" class="btn btn-shop-now">
                    Start Shopping <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    <?php else: ?>

        <?php $total = 0; ?>

        <div class="table-responsive cart-table-wrap">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($_SESSION['cart'] as $id => $item): 
                        $itemTotal = $item['price'] * $item['qty'];
                        $total += $itemTotal;
                    ?>
                    <tr>
                        <td>
                            <strong class="cart-item-title"><?= htmlspecialchars($item['name']); ?></strong>
                            <div class="cart-item-meta">
                                <?php if(!empty($item['size'])): ?>
                                    <span class="badge" style="background-color: rgba(202, 151, 69, 0.12); color: var(--accent-bronze, #ca9745); border: 1px solid rgba(202, 151, 69, 0.2);">Size: <?= htmlspecialchars($item['size']); ?></span>
                                <?php endif; ?>
                                <?php if(!empty($item['fabric'])): ?>
                                    <span class="badge" style="background-color: rgba(92, 60, 38, 0.08); color: var(--text-muted, #5c3c26); border: 1px solid rgba(92, 60, 38, 0.15);">Fabric: <?= htmlspecialchars($item['fabric']); ?></span>
                                <?php endif; ?>
                            </div>
                        </td>

                    <td>
                       <img src="<?= BASE_URL ?>/<?= htmlspecialchars($item['image']) ?>" width="80px"/>
                             
                    </td>

                    <td>
                        <?php if (isset($item['discount_percent']) && (int)$item['discount_percent'] > 0 && isset($item['old_price'])): ?>
                            <div style="font-size:0.85rem; text-decoration:line-through; color:#aaa;">Rs. <?= number_format($item['old_price']); ?></div>
                            <span class="badge bg-danger mb-1" style="font-size:0.75rem;">-<?= (int)$item['discount_percent'] ?>%</span>
                        <?php endif; ?>
                        <div class="fw-bold" style="color:var(--accent-bronze, #ca9745);">Rs. <?= number_format($item['price']); ?></div>
                    </td>

                    <td>
                        <div class="qty-control">
                            <a href="<?= url('cart_update?id=' . $id . '&action=minus') ?>" class="qty-btn"><i class="bi bi-dash"></i></a>
                            <span class="qty-val"><?= $item['qty']; ?></span>
                            <a href="<?= url('cart_update?id=' . $id . '&action=add') ?>" class="qty-btn"><i class="bi bi-plus"></i></a>
                        </div>
                    </td>

                    <td>Rs. <?= number_format($itemTotal); ?></td>

                    <td>
                        <a href="<?= url('cart_remove?id=' . $id) ?>" 
                           class="btn btn-danger btn-sm">
                            Remove
                        </a>
                    </td>
                </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Grand Total -->
        <div class="cart-summary text-end mt-3">
            <h4>Total: Rs. <?= number_format($total); ?></h4>
        </div>

        <!-- Actions -->
        <style>
            .custom-cart-btn {
                background-color: #ca9745 !important;
                color: #ffffff !important;
                font-weight: 700;
                padding: 10px 25px;
                border: none;
                border-radius: 6px;
                opacity: 1 !important;
                transition: transform 0.2s ease !important;
                display: inline-block;
                margin-right: 10px;
                text-decoration: none !important;
            }
            .custom-cart-btn:hover {
                background-color: #b3823b !important;
                color: #ffffff !important;
                opacity: 1 !important;
                transform: translateY(-2px) !important;
                text-decoration: none !important;
            }
        </style>
        <div class="cart-actions mt-4">
            <a href="<?= url('allproducts') ?>" class="custom-cart-btn">
                Continue Shopping
            </a>

            <a href="<?= url('checkout') ?>" class="custom-cart-btn" style="background-color: #ca9745 !important;">
                Checkout
            </a>
        </div>

    <?php endif; ?>
</div>
                </main>
<?php include('footer.php'); ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

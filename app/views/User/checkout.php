<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout - <?= htmlspecialchars($webname ?? 'Stitch Smart') ?></title>

<!-- Fonts & Frameworks -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link href="<?= BASE_URL ?>/css/navbar.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/footer.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/style.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">

<style>
:root {
  --lux-gold: #ca9745;
  --lux-gold-light: #f0cf88;
  --lux-dark: #FAF6F0;
  --lux-darker: #F8F4EE;
  --lux-gray: #EAD7BF;
  --lux-text: #3D241C;
  --lux-muted: #5C4335;
  --transition-smooth: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background-color: var(--lux-darker) !important;
  background: 
      radial-gradient(circle at top, rgba(205, 154, 72, 0.06), transparent 40%),
      linear-gradient(180deg, #F8F4EE 0%, #FAF6F0 100%) !important;
  color: var(--lux-text) !important;
  overflow-x: hidden;
}

/* Page Header */
.checkout-header-section {
  position: relative;
  background: linear-gradient(180deg, rgba(248,244,238,0.9) 0%, rgba(250,246,240,1) 100%) !important;
  padding: 60px 0 30px;
  text-align: center;
  border-bottom: 1px solid rgba(205, 154, 72, 0.15);
}

.checkout-header-section h1 {
  font-family: 'Playfair Display', serif;
  font-weight: 800;
  font-size: 2.8rem;
  color: #3D241C !important;
  letter-spacing: -0.5px;
  margin-bottom: 10px;
}

.checkout-header-section p {
  color: var(--lux-muted) !important;
  font-size: 1rem;
}

/* Progress bar indicators */
.checkout-steps {
  display: flex;
  justify-content: center;
  gap: 30px;
  margin: 25px 0 10px;
}

.step-item {
  display: flex;
  align-items: center;
  gap: 8px;
  color: var(--lux-muted);
  font-size: 0.9rem;
  font-weight: 500;
}

.step-item.active {
  color: var(--lux-gold);
  font-weight: 700;
}

.step-item i {
  font-size: 1.1rem;
}

/* Form Container Styles */
.premium-card {
  background: #ffffff !important;
  border: 1px solid rgba(205, 154, 72, 0.22) !important;
  border-radius: 24px;
  padding: 35px;
  box-shadow: 0 16px 44px rgba(92, 67, 53, 0.04) !important;
  position: relative;
  overflow: hidden;
}

.premium-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(90deg, var(--lux-gold) 0%, var(--lux-gold-light) 100%);
}

.premium-card h3 {
  font-family: 'Playfair Display', serif;
  font-weight: 800;
  color: #3D241C !important;
  margin-bottom: 25px;
  font-size: 1.6rem;
  display: flex;
  align-items: center;
  gap: 10px;
}

/* Inputs styling */
.form-group-custom {
  position: relative;
  margin-bottom: 24px;
}

.form-group-custom label {
  color: #5C4335 !important;
  font-weight: 700;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 8px;
  display: block;
}

.form-control-custom {
  background: #ffffff !important;
  border: 1.5px solid #E6DCD2 !important;
  color: #3D241C !important;
  border-radius: 14px !important;
  padding: 14px 16px !important;
  font-size: 0.95rem !important;
  transition: var(--transition-smooth) !important;
}

.form-control-custom option {
  background-color: #ffffff !important;
  color: #3D241C !important;
}

.form-control-custom:focus {
  background: #ffffff !important;
  border-color: var(--lux-gold) !important;
  box-shadow: 0 0 0 4px rgba(205, 154, 72, 0.15) !important;
}

/* Voucher box */
.voucher-wrapper {
  background: #FAF6F0 !important;
  border: 1.5px dashed rgba(205, 154, 72, 0.3) !important;
  border-radius: 16px;
  padding: 20px;
  margin-bottom: 25px;
}

/* Payment selection styling */
.payment-option-card {
  background: #ffffff !important;
  border: 1px solid rgba(205, 154, 72, 0.16) !important;
  border-radius: 16px;
  padding: 18px 20px;
  margin-bottom: 12px;
  cursor: pointer;
  transition: var(--transition-smooth);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.payment-option-card:hover {
  background: #FAF6F0 !important;
  border-color: rgba(205, 154, 72, 0.3) !important;
}

.payment-option-card.selected {
  background: #FFFDF9 !important;
  border-color: var(--lux-gold) !important;
  box-shadow: 0 6px 20px rgba(205, 154, 72, 0.12) !important;
}

.payment-option-info {
  display: flex;
  align-items: center;
  gap: 15px;
}

.payment-option-info i {
  font-size: 1.4rem;
  color: var(--lux-gold);
}

.payment-title {
  font-weight: 700;
  font-size: 0.95rem;
  color: #3D241C !important;
  margin-bottom: 2px;
}

.payment-desc {
  font-size: 0.82rem;
  color: #5C4335 !important;
  opacity: 0.85;
}

/* Custom Radio button */
.payment-radio {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  border: 2px solid rgba(205, 154, 72, 0.35);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: var(--transition-smooth);
}

.payment-option-card.selected .payment-radio {
  border-color: var(--lux-gold);
  background: var(--lux-gold);
}

.payment-radio::after {
  content: '';
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #ffffff !important;
  opacity: 0;
  transition: var(--transition-smooth);
}

.payment-option-card.selected .payment-radio::after {
  opacity: 1;
}

/* Right Column Order summary sticky card */
.sticky-summary-card {
  position: sticky;
  top: 100px;
}

.order-summary-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 0;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.order-summary-item:last-child {
  border-bottom: none;
}

.summary-product-name {
  font-weight: 500;
  font-size: 0.95rem;
  color: #3D241C !important;
}

.summary-product-qty {
  font-size: 0.8rem;
  color: var(--lux-gold);
  background: rgba(202, 151, 69, 0.1);
  padding: 2px 8px;
  border-radius: 6px;
  margin-left: 8px;
}

.summary-product-price {
  font-weight: 600;
  color: #3D241C !important;
  font-size: 0.95rem;
}

.summary-divider {
  border-top: 1px solid rgba(202, 151, 69, 0.2);
  margin: 20px 0;
}

/* Submit and PayPal buttons */
.checkout-primary-btn {
  background: linear-gradient(135deg, var(--lux-gold) 0%, #ca9745 100%) !important;
  color: #ffffff !important;
  font-weight: 700 !important;
  padding: 16px !important;
  border-radius: 14px !important;
  border: none !important;
  font-size: 1rem !important;
  letter-spacing: 0.5px !important;
  transition: var(--transition-smooth) !important;
}

.checkout-primary-btn:hover {
  transform: translateY(-2px) !important;
  box-shadow: 0 12px 25px rgba(202, 151, 69, 0.3) !important;
  color: #ffffff !important;
}

#paypal-button-container {
  margin-top: 20px;
  min-height: 45px;
}

/* Alert styles */
.custom-alert {
  background: rgba(202, 151, 69, 0.1);
  border: 1px solid rgba(202, 151, 69, 0.3);
  color: #3D241C;
  border-radius: 14px;
  padding: 16px;
}

/* Animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(25px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-down {
  animation: fadeInDown 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.animate-fade-in-up {
  animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  opacity: 0;
}

.delay-1 {
  animation-delay: 0.1s;
}

.delay-2 {
  animation-delay: 0.2s;
}

/* Interactive elements hover animation enhancement */
.premium-card {
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
}

.premium-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 20px 40px rgba(92, 67, 53, 0.08) !important;
}

.payment-option-card {
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
}

.payment-option-card:hover {
  transform: translateY(-2px);
  border-color: var(--lux-gold) !important;
  background: #FFFDF9 !important;
}

.payment-option-card.selected {
  transform: scale(1.01);
}

.checkout-signin-toggle {
  transition: all 0.3s ease !important;
}

.checkout-signin-toggle:hover {
  transform: translateY(-1px);
}
</style>
</head>
<body>

<?php include('header.php'); ?>

<!-- Page Title Header -->
<div class="checkout-header-section animate-fade-in-down">
  <div class="container">
    <h1>Complete Your Order</h1>
    <p>Step into the ultimate tailoring experience.</p>
  </div>
</div>

<div class="container py-5">
  <div class="row g-5">
    
    <!-- LEFT SIDE: Billing Details & Payments -->
    <div class="col-lg-7 animate-fade-in-up delay-1">
      <div class="premium-card">
        <h3><i class="bi bi-person-lines-fill"></i> Billing Details</h3>

        <?php if(isset($_SESSION['checkout_error'])): ?>
            <div class="alert custom-alert mb-4">
                <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                <?= htmlspecialchars($_SESSION['checkout_error']); unset($_SESSION['checkout_error']); ?>
            </div>
        <?php endif; ?>

        <form id="checkoutForm" method="POST" action="<?= url('') ?>place_order">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
          <!-- Transaction ID input populated dynamically when PayPal transaction finishes -->
          <input type="hidden" id="paypal_transaction_id" name="paypal_transaction_id" value="">

          <div class="form-group-custom">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control form-control-custom" value="<?= htmlspecialchars($_SESSION['customer_name'] ?? ''); ?>" required>
          </div>

          <div class="form-group-custom">
            <label>Phone Number</label>
            <input type="text" name="phone" class="form-control form-control-custom" value="<?= htmlspecialchars($_SESSION['customer_phone'] ?? ''); ?>" required>
          </div>

          <div class="form-group-custom">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control form-control-custom" value="<?= htmlspecialchars($_SESSION['customer_email'] ?? ''); ?>" required>
          </div>

          <div class="form-group-custom">
            <label>Delivery Address</label>
            <textarea name="address" class="form-control form-control-custom" rows="3" required></textarea>
          </div>

          <div class="form-group-custom">
            <label>Country</label>
            <select name="country" class="form-control form-control-custom form-select" required>
              <option value="Pakistan" selected>Pakistan</option>
              <option value="United States">United States</option>
              <option value="United Kingdom">United Kingdom</option>
              <option value="Canada">Canada</option>
              <option value="United Arab Emirates">United Arab Emirates</option>
            </select>
          </div>

          <!-- Promo Voucher Box -->
          <div class="voucher-wrapper">
            <label class="form-label text-warning fw-semibold mb-2" style="font-size:0.85rem; text-transform:uppercase; letter-spacing:0.5px;">Promo Code / Gift Voucher</label>
            <div class="d-flex gap-2">
              <input type="text" id="voucher_code" name="voucher_code" class="form-control form-control-custom" placeholder="Enter code (e.g. STITCH20)" style="border-radius: 12px;">
              <button type="button" id="applyVoucherBtn" class="btn btn-outline-warning px-4 fw-bold" style="border-radius: 12px; white-space: nowrap;">Apply</button>
            </div>
            <div id="voucherMessage" class="form-text mt-2" style="display:none; font-weight: 500;"></div>
          </div>

          <!-- Payment Options Redesigned -->
          <h4 class="mt-5 mb-4" style="font-family: 'Playfair Display', serif; color: var(--lux-gold); font-weight: 700; font-size:1.4rem;">
            Select Payment Method
          </h4>

          <input type="hidden" name="payment_method" id="selected_payment_method" value="cod">

          <!-- COD Option -->
          <div class="payment-option-card selected" data-value="cod">
            <div class="payment-option-info">
              <i class="bi bi-cash-coin"></i>
              <div>
                <div class="payment-title">Cash on Delivery (COD)</div>
                <div class="payment-desc">Pay directly in cash when your order reaches your doorstep.</div>
              </div>
            </div>
            <div class="payment-radio"></div>
          </div>

          <!-- JazzCash Option -->
          <div class="payment-option-card" data-value="jazzcash">
            <div class="payment-option-info">
              <img src="https://upload.wikimedia.org/wikipedia/en/b/b0/JazzCash_logo.svg" alt="JazzCash" style="height:28px; width:auto; object-fit:contain;" onerror="this.outerHTML='<i class=\'bi bi-phone-fill\' style=\'color:#E30613; font-size:1.4rem;\'></i>'">
              <div>
                <div class="payment-title">JazzCash Mobile Payment</div>
                <div class="payment-desc">Pay instantly via your JazzCash mobile account — secure &amp; Pakistan-local.</div>
              </div>
            </div>
            <div class="payment-radio"></div>
          </div>

          <!-- Action buttons block -->
          <div class="mt-5">
            <!-- Normal checkout button -->
            <button type="submit" id="submitOrderBtn" class="btn btn-dark w-100 checkout-primary-btn">
              <i class="bi bi-bag-check-fill me-2"></i> Place Order (COD)
            </button>

            <!-- JazzCash Pay Button (shown when JazzCash selected) -->
            <button type="button" id="jazzcashPayBtn" class="btn w-100 checkout-primary-btn mt-3" style="display:none;">
              <i class="bi bi-phone-fill me-2"></i> Pay with JazzCash
            </button>

            <!-- Hidden field for jazzcash transaction ref -->
            <input type="hidden" id="jazzcash_transaction_id" name="jazzcash_transaction_id" value="">
          </div>

        </form>
      </div>
    </div>

    <!-- RIGHT SIDE: Order Summary & Auth panels -->
    <div class="col-lg-5 animate-fade-in-up delay-2">
      <div class="sticky-summary-card">
        
        <!-- Welcome back panel -->
        <?php if(empty($_SESSION['customer_id'])): ?>
        <div class="card p-4 mb-4 checkout-surface checkout-account-card" style="background: #ffffff !important; border: 1px solid rgba(205, 154, 72, 0.22) !important; border-radius:16px; box-shadow: 0 16px 44px rgba(92, 67, 53, 0.04) !important;">
            <div class="checkout-account-header">
                <h5 class="mb-0 checkout-account-copy" style="color:#3D241C !important; font-weight:700;">Complete Order Faster</h5>
                <button class="btn btn-sm btn-outline-warning checkout-signin-toggle mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#loginCollapse" aria-expanded="false">
                    Sign In / Sign Up
                </button>
            </div>
            
            <div class="collapse mt-4" id="loginCollapse">
                <ul class="nav nav-pills nav-justified mb-3 auth-nav" id="authTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="signin-tab" data-bs-toggle="tab" data-bs-target="#signin" type="button" role="tab">Sign In</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup" type="button" role="tab">Sign Up</button>
                    </li>
                </ul>

                <div class="tab-content" id="authTabsContent">
                    <!-- Login Form -->
                    <div class="tab-pane fade show active" id="signin" role="tabpanel">
                        <form method="POST" action="<?= url('') ?>customer_login">
                            <input type="hidden" name="redirect" value="checkout">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                            <div class="mb-2">
                                <input type="email" name="email" class="form-control form-control-custom" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control form-control-custom" placeholder="Password" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-warning px-4 py-2" style="border-radius:10px; font-weight:600;">Login</button>
                                <a href="<?= url('') ?>customer_forgot_password" class="checkout-link text-warning">Forgot?</a>
                            </div>
                        </form>
                    </div>

                    <!-- Register Form -->
                    <div class="tab-pane fade" id="signup" role="tabpanel">
                        <form method="POST" action="<?= url('') ?>customer_register">
                            <input type="hidden" name="redirect" value="checkout">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                            <div class="mb-2">
                                <input type="text" name="name" class="form-control form-control-custom" placeholder="Full Name" required>
                            </div>
                            <div class="mb-2">
                                <input type="text" name="phone" class="form-control form-control-custom" placeholder="Phone Number">
                            </div>
                            <div class="mb-2">
                                <input type="email" name="email" class="form-control form-control-custom" placeholder="Email Address" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control form-control-custom" placeholder="Password" required>
                            </div>
                            <button class="btn btn-warning w-100 py-2" style="border-radius:10px; font-weight:600;">Create Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="card p-4 mb-4 checkout-surface" style="background: #ffffff !important; border: 1px solid rgba(205, 154, 72, 0.22) !important; border-radius:16px; box-shadow: 0 16px 44px rgba(92, 67, 53, 0.04) !important;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                  <h6 class="mb-0 text-muted">LOGGED IN AS</h6>
                  <strong class="text-dark" style="font-size:1.1rem; color:#3D241C !important;"><?= htmlspecialchars($_SESSION['customer_name']); ?></strong>
                </div>
                <a href="<?= url('') ?>customer_logout&redirect=checkout" class="btn btn-sm btn-outline-danger" style="border-radius:8px;">Sign Out</a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Order Items Summary List -->
        <div class="premium-card">
          <h4 class="mb-3" style="font-family: 'Playfair Display', serif; color: var(--lux-gold); font-weight: 700; font-size:1.4rem;">
            Order Review <i class="bi bi-cart3"></i>
          </h4>
          
          <div class="mb-4">
            <?php foreach($cart as $item): ?>
              <div class="order-summary-item">
                <div>
                  <span class="summary-product-name"><?= htmlspecialchars($item['name']); ?></span>
                  <span class="summary-product-qty">× <?= (int)$item['qty']; ?></span>
                  <?php if (isset($item['discount_percent']) && (int)$item['discount_percent'] > 0): ?>
                      <span class="badge bg-danger ms-1" style="font-size:0.7rem;">-<?= (int)$item['discount_percent'] ?>%</span>
                  <?php endif; ?>
                </div>
                <span class="summary-product-price">Rs. <?= number_format($item['price'] * $item['qty']); ?></span>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="summary-divider"></div>

          <div class="order-summary-item text-muted" id="discountRow" style="display:none;">
            <span>Voucher Savings</span>
            <strong class="text-success" id="discountAmountText">Rs. 0</strong>
          </div>

          <div class="order-summary-item pt-2">
            <span style="font-size:1.1rem; font-weight:700; color:#3D241C !important;">Grand Total</span>
            <strong id="grandTotalText" style="font-size:1.3rem; color: var(--lux-gold); font-weight: 800;">Rs. <?= number_format($total); ?></strong>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<?php include('footer.php'); ?>
<!-- JazzCash Modal (Luxury Gold Theme) -->
<div id="jazzcashModal" style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(30,15,5,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;">
  <div id="jcCard" style="background:#fff;border-radius:28px;max-width:430px;width:94%;box-shadow:0 40px 100px rgba(92,67,53,0.30);overflow:hidden;animation:jcSlideUp 0.45s cubic-bezier(0.16,1,0.3,1);">

    <!-- HEADER (always visible) -->
    <div style="background:linear-gradient(135deg,#ca9745 0%,#8b5a2b 100%);padding:22px 26px 18px;display:flex;align-items:center;justify-content:space-between;">
      <div style="display:flex;align-items:center;gap:13px;">
        <div style="background:rgba(255,255,255,0.18);border-radius:50%;width:46px;height:46px;display:flex;align-items:center;justify-content:center;">
          <i class="bi bi-phone-fill" style="color:#fff;font-size:1.35rem;"></i>
        </div>
        <div>
          <div style="color:#fff;font-weight:800;font-size:1.1rem;font-family:'Playfair Display',serif;">JazzCash</div>
          <div id="jcSubtitle" style="color:rgba(255,255,255,0.78);font-size:0.76rem;">Pakistan Mobile Wallet &mdash; Demo</div>
        </div>
      </div>
      <button onclick="closeJazzCash()" style="background:rgba(255,255,255,0.15);border:none;color:#fff;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:1.1rem;display:flex;align-items:center;justify-content:center;">&times;</button>
    </div>

    <!-- ── SCREEN 0: REGISTER ──────────────────────────────────────── -->
    <div id="jcScreenRegister" style="display:none;padding:28px;">
      <div style="text-align:center;margin-bottom:20px;">
        <div style="font-size:0.72rem;color:#ca9745;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;">Create Account</div>
        <div style="font-size:0.88rem;color:#5C4335;margin-top:4px;">Register your JazzCash mobile wallet</div>
      </div>
      <div style="margin-bottom:15px;">
        <label style="font-size:0.72rem;font-weight:700;color:#5C4335;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:7px;">Mobile Number</label>
        <div style="position:relative;">
          <span style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#ca9745;font-weight:700;font-size:0.88rem;">&#127477;&#127472; +92</span>
          <input id="regMobile" type="tel" maxlength="10" placeholder="3XXXXXXXXX" style="width:100%;border:1.5px solid #E6DCD2;border-radius:13px;padding:13px 13px 13px 74px;font-size:0.93rem;outline:none;color:#3D241C;background:#FFFDF9;box-sizing:border-box;" onfocus="this.style.borderColor='#ca9745';this.style.boxShadow='0 0 0 3px rgba(205,154,72,0.12)'" onblur="this.style.borderColor='#E6DCD2';this.style.boxShadow='none'">
        </div>
      </div>
      <div style="margin-bottom:15px;">
        <label style="font-size:0.72rem;font-weight:700;color:#5C4335;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:7px;">MPIN (4&ndash;6 digits)</label>
        <div style="position:relative;">
          <input id="regMpin" type="password" maxlength="6" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;" style="width:100%;border:1.5px solid #E6DCD2;border-radius:13px;padding:13px 40px 13px 16px;font-size:1.2rem;letter-spacing:7px;outline:none;color:#3D241C;background:#FFFDF9;box-sizing:border-box;" onfocus="this.style.borderColor='#ca9745';this.style.boxShadow='0 0 0 3px rgba(205,154,72,0.12)'" onblur="this.style.borderColor='#E6DCD2';this.style.boxShadow='none'">
          <i class="bi bi-eye-slash" onclick="toggleMpin('regMpin', this)" style="position:absolute;right:16px;top:50%;transform:translateY(-50%);cursor:pointer;color:#888;font-size:1.1rem;"></i>
        </div>
      </div>
      <div style="margin-bottom:22px;">
        <label style="font-size:0.72rem;font-weight:700;color:#5C4335;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:7px;">Confirm MPIN</label>
        <div style="position:relative;">
          <input id="regMpinConfirm" type="password" maxlength="6" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;" style="width:100%;border:1.5px solid #E6DCD2;border-radius:13px;padding:13px 40px 13px 16px;font-size:1.2rem;letter-spacing:7px;outline:none;color:#3D241C;background:#FFFDF9;box-sizing:border-box;" onfocus="this.style.borderColor='#ca9745';this.style.boxShadow='0 0 0 3px rgba(205,154,72,0.12)'" onblur="this.style.borderColor='#E6DCD2';this.style.boxShadow='none'">
          <i class="bi bi-eye-slash" onclick="toggleMpin('regMpinConfirm', this)" style="position:absolute;right:16px;top:50%;transform:translateY(-50%);cursor:pointer;color:#888;font-size:1.1rem;"></i>
        </div>
      </div>
      <div id="regError" style="display:none;color:#a3000d;font-size:0.82rem;margin-bottom:12px;padding:10px 14px;background:rgba(163,0,13,0.06);border-radius:10px;border:1px solid rgba(163,0,13,0.15);"></div>
      <button onclick="jcDoRegister()" style="width:100%;background:linear-gradient(135deg,#ca9745,#8b5a2b);color:#fff;border:none;border-radius:13px;padding:14px;font-weight:700;font-size:0.97rem;cursor:pointer;" onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
        <i class="bi bi-person-plus-fill me-2"></i>Create JazzCash Account
      </button>
      <div style="text-align:center;margin-top:14px;">
        <span style="font-size:0.82rem;color:#5C4335;">Already have an account?</span>
        <button onclick="jcShowLogin()" style="background:none;border:none;color:#ca9745;font-weight:700;font-size:0.82rem;cursor:pointer;text-decoration:underline;padding:0 4px;">Login</button>
      </div>
    </div>

    <!-- ── SCREEN 1: LOGIN ─────────────────────────────────────────── -->
    <div id="jcScreenLogin" style="display:none;padding:28px;">
      <div style="text-align:center;margin-bottom:20px;">
        <div style="font-size:0.72rem;color:#ca9745;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;">Secure Payment</div>
        <div id="jcLoginAmountDisplay" style="font-size:1.85rem;font-weight:800;color:#3D241C;margin-top:5px;font-family:'Playfair Display',serif;">Rs. 0</div>
        <div style="font-size:0.8rem;color:#5C4335;">Stitch Smart Order</div>
      </div>
      <div style="margin-bottom:16px;">
        <label style="font-size:0.72rem;font-weight:700;color:#5C4335;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:7px;">JazzCash Mobile Number</label>
        <div style="position:relative;">
          <span style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#ca9745;font-weight:700;font-size:0.88rem;">&#127477;&#127472; +92</span>
          <input id="loginMobile" type="tel" maxlength="10" placeholder="3XXXXXXXXX" style="width:100%;border:1.5px solid #E6DCD2;border-radius:13px;padding:13px 13px 13px 74px;font-size:0.93rem;outline:none;color:#3D241C;background:#FFFDF9;box-sizing:border-box;" onfocus="this.style.borderColor='#ca9745';this.style.boxShadow='0 0 0 3px rgba(205,154,72,0.12)'" onblur="this.style.borderColor='#E6DCD2';this.style.boxShadow='none'">
        </div>
      </div>
      <div style="margin-bottom:22px;">
        <label style="font-size:0.72rem;font-weight:700;color:#5C4335;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:7px;">MPIN</label>
        <div style="position:relative;">
          <input id="loginMpin" type="password" maxlength="6" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;" style="width:100%;border:1.5px solid #E6DCD2;border-radius:13px;padding:13px 40px 13px 16px;font-size:1.2rem;letter-spacing:7px;outline:none;color:#3D241C;background:#FFFDF9;box-sizing:border-box;" onfocus="this.style.borderColor='#ca9745';this.style.boxShadow='0 0 0 3px rgba(205,154,72,0.12)'" onblur="this.style.borderColor='#E6DCD2';this.style.boxShadow='none'">
          <i class="bi bi-eye-slash" onclick="toggleMpin('loginMpin', this)" style="position:absolute;right:16px;top:50%;transform:translateY(-50%);cursor:pointer;color:#888;font-size:1.1rem;"></i>
        </div>
      </div>
      <div id="loginError" style="display:none;color:#a3000d;font-size:0.82rem;margin-bottom:12px;padding:10px 14px;background:rgba(163,0,13,0.06);border-radius:10px;border:1px solid rgba(163,0,13,0.15);"></div>
      <button onclick="jcDoLogin()" style="width:100%;background:linear-gradient(135deg,#ca9745,#8b5a2b);color:#fff;border:none;border-radius:13px;padding:14px;font-weight:700;font-size:0.97rem;cursor:pointer;" onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
        <i class="bi bi-shield-lock-fill me-2"></i>Login &amp; Send OTP
      </button>
      <div style="text-align:center;margin-top:14px;">
        <span style="font-size:0.82rem;color:#5C4335;">No account?</span>
        <button onclick="jcShowRegister()" style="background:none;border:none;color:#ca9745;font-weight:700;font-size:0.82rem;cursor:pointer;text-decoration:underline;padding:0 4px;">Register</button>
      </div>
    </div>

    <!-- ── SCREEN 2: OTP ───────────────────────────────────────────── -->
    <div id="jcScreenOtp" style="display:none;padding:28px;text-align:center;">
      <div style="width:62px;height:62px;background:linear-gradient(135deg,#ca9745,#8b5a2b);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
        <i class="bi bi-chat-dots-fill" style="color:#fff;font-size:1.4rem;"></i>
      </div>
      <div style="font-weight:800;font-size:1.12rem;color:#3D241C;margin-bottom:5px;font-family:'Playfair Display',serif;">OTP Verification</div>
      <div style="font-size:0.83rem;color:#5C4335;margin-bottom:14px;">Enter the 6-digit OTP sent to<br><strong id="jcOtpMobileDisplay" style="color:#ca9745;"></strong></div>

      <!-- Simulated phone SMS bubble (Hidden for production demo as requested) -->
      <div id="jcSmsBubble" style="display:none; background:#f0f0f0;border-radius:16px;padding:12px 16px;margin-bottom:18px;text-align:left;position:relative;max-width:300px;margin-left:auto;margin-right:auto;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
        <div style="font-size:0.65rem;color:#888;font-weight:600;margin-bottom:5px;display:flex;align-items:center;gap:5px;">
          <i class="bi bi-phone" style="color:#ca9745;"></i> JazzCash SMS &mdash; just now
        </div>
        <div style="font-size:0.82rem;color:#222;">Your JazzCash OTP is: <strong id="jcSmsOtp" style="color:#ca9745;font-size:1rem;letter-spacing:2px;">——</strong><br><span style="color:#888;font-size:0.72rem;">Valid for 5 minutes. Do not share.</span></div>
      </div>

      <!-- OTP Input boxes -->
      <div style="display:flex;gap:7px;justify-content:center;margin-bottom:18px;">
        <input class="otp-box" type="password" maxlength="1" style="width:44px;height:52px;border:1.5px solid #E6DCD2;border-radius:11px;text-align:center;font-size:1.4rem;font-weight:700;outline:none;color:#3D241C;background:#FFFDF9;" oninput="otpMove(this,0)" onfocus="this.style.borderColor='#ca9745';this.style.boxShadow='0 0 0 3px rgba(205,154,72,0.15)'" onblur="this.style.borderColor='#E6DCD2';this.style.boxShadow='none'">
        <input class="otp-box" type="password" maxlength="1" style="width:44px;height:52px;border:1.5px solid #E6DCD2;border-radius:11px;text-align:center;font-size:1.4rem;font-weight:700;outline:none;color:#3D241C;background:#FFFDF9;" oninput="otpMove(this,1)" onfocus="this.style.borderColor='#ca9745';this.style.boxShadow='0 0 0 3px rgba(205,154,72,0.15)'" onblur="this.style.borderColor='#E6DCD2';this.style.boxShadow='none'">
        <input class="otp-box" type="password" maxlength="1" style="width:44px;height:52px;border:1.5px solid #E6DCD2;border-radius:11px;text-align:center;font-size:1.4rem;font-weight:700;outline:none;color:#3D241C;background:#FFFDF9;" oninput="otpMove(this,2)" onfocus="this.style.borderColor='#ca9745';this.style.boxShadow='0 0 0 3px rgba(205,154,72,0.15)'" onblur="this.style.borderColor='#E6DCD2';this.style.boxShadow='none'">
        <input class="otp-box" type="password" maxlength="1" style="width:44px;height:52px;border:1.5px solid #E6DCD2;border-radius:11px;text-align:center;font-size:1.4rem;font-weight:700;outline:none;color:#3D241C;background:#FFFDF9;" oninput="otpMove(this,3)" onfocus="this.style.borderColor='#ca9745';this.style.boxShadow='0 0 0 3px rgba(205,154,72,0.15)'" onblur="this.style.borderColor='#E6DCD2';this.style.boxShadow='none'">
        <input class="otp-box" type="password" maxlength="1" style="width:44px;height:52px;border:1.5px solid #E6DCD2;border-radius:11px;text-align:center;font-size:1.4rem;font-weight:700;outline:none;color:#3D241C;background:#FFFDF9;" oninput="otpMove(this,4)" onfocus="this.style.borderColor='#ca9745';this.style.boxShadow='0 0 0 3px rgba(205,154,72,0.15)'" onblur="this.style.borderColor='#E6DCD2';this.style.boxShadow='none'">
        <input class="otp-box" type="password" maxlength="1" style="width:44px;height:52px;border:1.5px solid #E6DCD2;border-radius:11px;text-align:center;font-size:1.4rem;font-weight:700;outline:none;color:#3D241C;background:#FFFDF9;" oninput="otpMove(this,5)" onfocus="this.style.borderColor='#ca9745';this.style.boxShadow='0 0 0 3px rgba(205,154,72,0.15)'" onblur="this.style.borderColor='#E6DCD2';this.style.boxShadow='none'">
      </div>

      <div id="otpError" style="display:none;color:#a3000d;font-size:0.82rem;margin-bottom:12px;padding:10px 14px;background:rgba(163,0,13,0.06);border-radius:10px;border:1px solid rgba(163,0,13,0.15);"></div>

      <button onclick="jcDoVerifyOtp()" style="width:100%;background:linear-gradient(135deg,#ca9745,#8b5a2b);color:#fff;border:none;border-radius:13px;padding:14px;font-weight:700;font-size:0.97rem;cursor:pointer;" onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
        <i class="bi bi-check-circle-fill me-2"></i>Verify &amp; Pay
      </button>
      <button onclick="jcShowLogin()" style="width:100%;background:none;border:none;color:#8b5a2b;margin-top:10px;cursor:pointer;font-size:0.82rem;padding:8px;opacity:0.75;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.75'">&larr; Back to Login</button>
    </div>

    <!-- ── SCREEN 3: SUCCESS ───────────────────────────────────────── -->
    <div id="jcScreenSuccess" style="display:none;padding:40px 28px;text-align:center;">
      <div style="width:76px;height:76px;background:linear-gradient(135deg,#3abf7e,#1a8f56);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;animation:jcPop 0.55s cubic-bezier(0.16,1,0.3,1);">
        <i class="bi bi-check-lg" style="color:#fff;font-size:2.2rem;"></i>
      </div>
      <div style="font-weight:800;font-size:1.3rem;color:#3D241C;margin-bottom:6px;font-family:'Playfair Display',serif;">Payment Verified!</div>
      <div id="jcSuccessTxn" style="font-size:0.82rem;color:#ca9745;font-weight:600;margin-bottom:6px;"></div>
      <div style="font-size:0.82rem;color:#5C4335;margin-bottom:24px;">Placing your order&hellip;</div>
      <div style="height:5px;background:#EAD7BF;border-radius:3px;overflow:hidden;">
        <div style="height:100%;background:linear-gradient(90deg,#ca9745,#8b5a2b);border-radius:3px;animation:jcLoadBar 1.8s linear forwards;width:0;"></div>
      </div>
    </div>

  </div><!-- /jcCard -->
</div><!-- /jazzcashModal -->

<style>
@keyframes jcSlideUp {
  from { opacity:0; transform:translateY(35px) scale(0.95); }
  to   { opacity:1; transform:translateY(0) scale(1); }
}
@keyframes jcPop {
  0%   { transform:scale(0) rotate(-10deg); }
  70%  { transform:scale(1.1) rotate(2deg); }
  100% { transform:scale(1) rotate(0); }
}
@keyframes jcLoadBar {
  from { width:0; }
  to   { width:100%; }
}
</style>

<script>
  const BASE = '<?= BASE_URL ?>';

  const voucherRules = {
    'STITCH10': 10,
    'LUCKY15': 15,
    'STITCH20': 20,
    'WELCOME10': 10
  };

  let currentTotalPKR = <?= json_encode($total); ?>;

  const voucherInput = document.getElementById('voucher_code');
  const discountRow = document.getElementById('discountRow');
  const discountAmountText = document.getElementById('discountAmountText');
  const grandTotalText = document.getElementById('grandTotalText');
  const voucherMessage = document.getElementById('voucherMessage');
  const applyButton = document.getElementById('applyVoucherBtn');

  function calculateGrandTotal(code) {
    const upperCode = code.trim().toUpperCase();
    if (!upperCode) {
      discountRow.style.display = 'none';
      voucherMessage.style.display = 'none';
      grandTotalText.textContent = 'Rs. ' + currentTotalPKR.toLocaleString();
      return currentTotalPKR;
    }
    const percent = voucherRules[upperCode];
    if (!percent) {
      voucherMessage.textContent = 'Voucher code invalid.';
      voucherMessage.className = 'form-text text-danger mt-1';
      voucherMessage.style.display = 'block';
      discountRow.style.display = 'none';
      grandTotalText.textContent = 'Rs. ' + currentTotalPKR.toLocaleString();
      return currentTotalPKR;
    }
    const discount = Math.round((currentTotalPKR * percent) / 100);
    discountAmountText.textContent = '- Rs. ' + discount.toLocaleString();
    const finalTotal = currentTotalPKR - discount;
    grandTotalText.textContent = 'Rs. ' + finalTotal.toLocaleString();
    voucherMessage.textContent = 'Promo code applied: ' + percent + '% off!';
    voucherMessage.className = 'form-text text-success mt-1';
    voucherMessage.style.display = 'block';
    discountRow.style.display = 'flex';
    return finalTotal;
  }

  applyButton?.addEventListener('click', function () { calculateGrandTotal(voucherInput.value); });
  voucherInput?.addEventListener('input', function () { if (!voucherInput.value.trim()) calculateGrandTotal(''); });

  // Payment card selection
  const paymentCards = document.querySelectorAll('.payment-option-card');
  const selectedPaymentInput = document.getElementById('selected_payment_method');
  const submitButton = document.getElementById('submitOrderBtn');
  const jazzcashPayBtn = document.getElementById('jazzcashPayBtn');

  paymentCards.forEach(card => {
    card.addEventListener('click', function() {
      paymentCards.forEach(c => c.classList.remove('selected'));
      this.classList.add('selected');
      const val = this.getAttribute('data-value');
      selectedPaymentInput.value = val;

      if (val === 'jazzcash') {
        submitButton.style.display = 'none';
        jazzcashPayBtn.style.display = 'block';
      } else {
        submitButton.style.display = 'block';
        jazzcashPayBtn.style.display = 'none';
        if (val === 'cod') {
          submitButton.innerHTML = '<i class="bi bi-bag-check-fill me-2"></i> Place Order (COD)';
        }
      }
    });
  });

  // JazzCash Checkout Validation
  function validateCheckoutForm() {
    const name    = document.querySelector('input[name="name"]')?.value.trim();
    const phone   = document.querySelector('input[name="phone"]')?.value.trim();
    const email   = document.querySelector('input[name="email"]')?.value.trim();
    const address = document.querySelector('textarea[name="address"]')?.value.trim();

    if (!name)    { alert('Please enter your Full Name.');       return false; }
    if (!phone)   { alert('Please enter your Phone Number.');    return false; }
    if (!email)   { alert('Please enter your Email Address.');   return false; }
    if (!address) { alert('Please enter your Delivery Address.'); return false; }
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) { alert('Please enter a valid email address.'); return false; }
    return true;
  }

  // JazzCash Modal App State
  function showScreen(id) {
    ['jcScreenRegister','jcScreenLogin','jcScreenOtp','jcScreenSuccess'].forEach(s => {
      document.getElementById(s).style.display = 'none';
    });
    document.getElementById(id).style.display = 'block';
  }

  function jcShowError(id, msg) {
    const el = document.getElementById(id);
    el.textContent = msg;
    el.style.display = 'block';
  }

  function openJazzCash() {
    if (!validateCheckoutForm()) return;
    const finalAmt = calculateGrandTotal(voucherInput ? voucherInput.value : '');
    document.getElementById('jcLoginAmountDisplay').textContent = 'Rs. ' + finalAmt.toLocaleString();
    document.getElementById('jazzcashModal').style.display = 'flex';
    jcShowLogin(); // Default to login screen
  }

  function closeJazzCash() {
    document.getElementById('jazzcashModal').style.display = 'none';
  }

  function jcShowLogin() {
    showScreen('jcScreenLogin');
    document.getElementById('loginError').style.display = 'none';
    document.getElementById('jcSubtitle').textContent = 'Login to your JazzCash wallet';
  }

  function jcShowRegister() {
    showScreen('jcScreenRegister');
    document.getElementById('regError').style.display = 'none';
    document.getElementById('jcSubtitle').textContent = 'Create your JazzCash account';
  }

  // 1. REGISTER AJAX
  async function jcDoRegister() {
    const mobile  = document.getElementById('regMobile').value.trim();
    const mpin    = document.getElementById('regMpin').value.trim();
    const confirm = document.getElementById('regMpinConfirm').value.trim();
    document.getElementById('regError').style.display = 'none';

    const fd = new FormData();
    fd.append('mobile', mobile);
    fd.append('mpin', mpin);
    fd.append('confirm_mpin', confirm);

    try {
      const res = await fetch(BASE + 'jazzcash_register', { method:'POST', body:fd });
      const data = await res.json();
      if (!data.success) {
        jcShowError('regError', data.message);
        if (data.already_registered) setTimeout(() => jcShowLogin(), 1800);
        return;
      }
      document.getElementById('regError').style.cssText = 'display:block;color:#1a8f56;background:rgba(58,191,126,0.08);border-color:rgba(58,191,126,0.3);';
      document.getElementById('regError').textContent = '✓ ' + data.message;
      setTimeout(() => jcShowLogin(), 1500);
    } catch(e) {
      jcShowError('regError', 'Network error. Please try again.');
    }
  }

  // 2. LOGIN AJAX
  async function jcDoLogin() {
    const mobile = document.getElementById('loginMobile').value.trim();
    const mpin   = document.getElementById('loginMpin').value.trim();
    const email  = document.querySelector('input[name="email"]')?.value.trim();
    document.getElementById('loginError').style.display = 'none';

    const fd = new FormData();
    fd.append('mobile', mobile);
    fd.append('mpin', mpin);
    if (email) fd.append('email', email);

    try {
      const res = await fetch(BASE + 'jazzcash_login', { method:'POST', body:fd });
      const data = await res.json();
      if (!data.success) {
        jcShowError('loginError', data.message);
        if (data.not_registered) setTimeout(() => jcShowRegister(), 1800);
        return;
      }
      // Success - show OTP screen
      document.getElementById('jcOtpMobileDisplay').textContent = data.mobile;
      document.getElementById('jcSubtitle').textContent = 'OTP sent to your email (' + email + ')';
      
      // Hidden from UI, logged to console for FYP Demo purposes
      console.log('📱 JAZZCASH DEMO SMS/EMAIL RECEIVED 📱');
      console.log('OTP: ' + data.otp);
      
      const boxes = document.querySelectorAll('.otp-box');
      boxes.forEach((b, i) => { b.value = ''; }); // Do not pre-fill anymore, user must type
      showScreen('jcScreenOtp');
      document.getElementById('otpError').style.display = 'none';
      setTimeout(() => { boxes[0]?.focus(); }, 100);
    } catch(e) {
      jcShowError('loginError', 'Network error. Please try again.');
    }
  }

  // 3. OTP VERIFY AJAX
  async function jcDoVerifyOtp() {
    const boxes = document.querySelectorAll('.otp-box');
    document.getElementById('otpError').style.display = 'none';

    const fd = new FormData();
    boxes.forEach((b, i) => fd.append('otp_' + i, b.value));

    try {
      const res = await fetch(BASE + 'jazzcash_verify_otp', { method:'POST', body:fd });
      const data = await res.json();
      if (!data.success) {
        if (data.expired) setTimeout(() => jcShowLogin(), 1800);
        jcShowError('otpError', data.message);
        return;
      }
      // Success
      showScreen('jcScreenSuccess');
      document.getElementById('jcSubtitle').textContent = 'Payment Successful';
      document.getElementById('jcSuccessTxn').textContent = 'Ref: ' + data.txn_ref;
      document.getElementById('jazzcash_transaction_id').value = data.txn_ref;

      setTimeout(() => {
        document.getElementById('checkoutForm').submit();
      }, 2000);
    } catch(e) {
      jcShowError('otpError', 'Network error. Please try again.');
    }
  }

  function otpMove(el, idx) {
    if (el.value.length === 1) {
      const boxes = document.querySelectorAll('.otp-box');
      if (idx < 5) boxes[idx + 1].focus();
      else el.blur();
    }
  }

  function toggleMpin(inputId, iconEl) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
      input.type = 'text';
      iconEl.classList.remove('bi-eye-slash');
      iconEl.classList.add('bi-eye');
      iconEl.style.color = '#ca9745';
    } else {
      input.type = 'password';
      iconEl.classList.remove('bi-eye');
      iconEl.classList.add('bi-eye-slash');
      iconEl.style.color = '#888';
    }
  }

  document.getElementById('jazzcashPayBtn')?.addEventListener('click', openJazzCash);
  document.getElementById('jazzcashModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeJazzCash();
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

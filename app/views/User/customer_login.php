<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Login - <?= isset($webname) ? htmlspecialchars($webname) : 'StitchSmart' ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/navbar.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/footer.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/style.css" rel="stylesheet">
<link href="<?= BASE_URL ?>/css/<?= $global_theme ?? 'theme-luxury' ?>-frontend.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ═══════════════════════════════════════════
   PAGE WRAPPER
═══════════════════════════════════════════ */
body { font-family: 'Plus Jakarta Sans', sans-serif; }

.auth-page-bg {
  min-height: 100vh;
  background: linear-gradient(135deg, #fdf6ec 0%, #f5e6cc 40%, #ede0cc 100%);
  padding: 50px 0 60px;
  position: relative;
  overflow: hidden;
}

/* ── Falling Petals Animation ── */
@keyframes petalDrift {
  0%   { transform: translateY(-60px) translateX(0px)  rotate(0deg);   opacity: 0; }
  8%   { opacity: 0.9; }
  85%  { opacity: 0.7; }
  100% { transform: translateY(108vh) translateX(var(--dx, 40px)) rotate(var(--rot, 380deg)); opacity: 0; }
}
.falling-petal {
  position: fixed;
  pointer-events: none;
  z-index: 0;
  border-radius: 50% 5% 50% 5%;
  animation: petalDrift linear infinite;
  will-change: transform, opacity;
}
/* Luxury theme: cream/ivory petals */
:root.theme-luxury .falling-petal {
  background: linear-gradient(135deg,
    rgba(205,154,72,0.6),
    rgba(230,185,110,0.35)
  );
  box-shadow: inset 0 0 6px rgba(255,230,150,0.4);
}
/* Default: warm amber petals */
.falling-petal {
  background: linear-gradient(135deg,
    rgba(205,154,72,0.65),
    rgba(180,115,35,0.4)
  );
  box-shadow: inset 0 0 6px rgba(255,220,130,0.35);
}

/* ═══════════════════════════════════════════
   MAIN CARD
═══════════════════════════════════════════ */
.auth-card {
  border-radius: 28px;
  overflow: hidden;
  border: 1px solid rgba(205,154,72,0.2);
  box-shadow:
    0 30px 80px rgba(92,67,53,0.14),
    0 8px 32px rgba(92,67,53,0.08),
    inset 0 1px 0 rgba(255,255,255,0.9);
  background: #ffffff;
  animation: cardRise 0.7s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes cardRise {
  from { opacity:0; transform: translateY(40px) scale(0.97); }
  to   { opacity:1; transform: translateY(0) scale(1); }
}

/* ═══════════════════════════════════════════
   IMAGE PANEL (LEFT)
═══════════════════════════════════════════ */
.auth-image-col {
  position: relative;
  min-height: 600px;
  background: url('<?= BASE_URL ?>/pictures/banners/MAIN.png') no-repeat center center;
  background-size: cover;
  transition: transform 0.85s cubic-bezier(0.4,0,0.2,1);
  z-index: 10;
}

.auth-image-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    170deg,
    rgba(20,10,5,0.15) 0%,
    rgba(20,10,5,0.25) 35%,
    rgba(20,10,5,0.78) 100%
  );
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 44px 40px;
}

.auth-brand-badge {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  background: rgba(205,154,72,0.22);
  border: 1px solid rgba(205,154,72,0.55);
  color: #f0c97a;
  font-size: 0.7rem;
  font-weight: 800;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  padding: 6px 16px;
  border-radius: 50px;
  margin-bottom: 18px;
  width: fit-content;
  backdrop-filter: blur(4px);
}

.auth-brand-title {
  font-family: 'Playfair Display', serif;
  font-size: 3rem;
  font-weight: 900;
  background: linear-gradient(135deg, #ca9745 0%, #f0c97a 50%, #ca9745 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  line-height: 1.1;
  margin-bottom: 14px;
  filter: drop-shadow(0 2px 8px rgba(0,0,0,0.35));
}
.auth-brand-title span {
  background: linear-gradient(135deg, #f0c97a 0%, #ca9745 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.auth-brand-desc {
  font-size: 1.05rem;
  font-weight: 600;
  color: #ca9745 !important;
  -webkit-text-fill-color: #ca9745 !important;
  line-height: 1.75;
  max-width: 340px;
  margin-bottom: 28px;
  text-shadow: 0 2px 12px rgba(0,0,0,0.6);
}

.auth-trust-badges {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}
.auth-trust-pill {
  display: flex;
  align-items: center;
  gap: 6px;
  background: rgba(255,255,255,0.1);
  border: 1px solid rgba(255,255,255,0.2);
  backdrop-filter: blur(8px);
  color: rgba(255,255,255,0.9);
  font-size: 0.75rem;
  font-weight: 600;
  padding: 5px 13px;
  border-radius: 50px;
}
.auth-trust-pill i { color: #ca9745; font-size: 0.8rem; }

/* shimmer line removed */

/* ═══════════════════════════════════════════
   FORM PANEL (RIGHT)
═══════════════════════════════════════════ */
.auth-form-col {
  background: #ffffff;
  padding: 48px 44px;
  display: flex;
  align-items: center;
  transition: transform 0.85s cubic-bezier(0.4,0,0.2,1);
  z-index: 5;
}

.auth-form-inner { width: 100%; }

/* Header */
.auth-form-header {
  margin-bottom: 30px;
}
.auth-welcome-text {
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
  font-weight: 800;
  color: #1a0f0a;
  margin-bottom: 4px;
  line-height: 1.2;
}
.auth-welcome-sub {
  font-size: 0.88rem;
  color: #8a6c55;
  font-weight: 500;
}
.auth-welcome-sub span {
  color: #ca9745;
  font-weight: 700;
}
.auth-portal-tag {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 0.7rem;
  font-weight: 800;
  letter-spacing: 1.8px;
  color: #ca9745;
  text-transform: uppercase;
  background: linear-gradient(135deg, rgba(205,154,72,0.12), rgba(205,154,72,0.06));
  border: 1px solid rgba(205,154,72,0.3);
  padding: 5px 13px;
  border-radius: 50px;
  margin-bottom: 10px;
}

/* Tab Nav */
.auth-tabs {
  display: flex;
  background: rgba(205,154,72,0.1);
  border: 1.5px solid rgba(205,154,72,0.3);
  border-radius: 14px;
  padding: 4px;
  margin-bottom: 28px;
  gap: 4px;
}
.auth-tab-btn {
  flex: 1;
  padding: 10px 0;
  border: none;
  background: transparent;
  border-radius: 10px;
  font-weight: 700;
  font-size: 0.85rem;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  color: #ca9745;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
  position: relative;
  overflow: hidden;
}
.auth-tab-btn::before {
  content: '';
  position: absolute;
  top: 0; left: -100%;
  width: 60%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
  transform: skewX(-20deg);
  transition: left 0.5s ease;
}
.auth-tab-btn.active::before { left: 160%; }
.auth-tab-btn.active {
  background: linear-gradient(135deg, #ca9745 0%, #ca9745 100%);
  color: #ffffff;
  box-shadow: 0 4px 18px rgba(205,154,72,0.4), inset 0 1px 0 rgba(255,255,255,0.25);
  transform: scale(1.02);
}
.auth-tab-btn:not(.active):hover {
  background: rgba(205,154,72,0.1);
  color: #8b5a2b;
}

/* ── Luxury Theme Overrides ── */

/* Page background → luxury dark */
:root.theme-luxury .auth-page-bg {
  background: linear-gradient(160deg,
    #060402 0%,
    #0f0a05 40%,
    #1a0f07 100%
  ) !important;
}

/* Overall card → dark luxury */
:root.theme-luxury .auth-card {
  background: #0a0a0a;
  box-shadow:
    0 30px 80px rgba(0,0,0,0.7),
    0 8px 32px rgba(0,0,0,0.5),
    inset 0 1px 0 rgba(205,154,72,0.15);
  border: 1px solid rgba(205,154,72,0.22);
}

/* Form panel → dark */
:root.theme-luxury .auth-form-col {
  background: #0a0a0a !important;
}

/* Welcome text */
:root.theme-luxury .auth-welcome-text {
  color: #f4e9d3 !important;
  -webkit-text-fill-color: #f4e9d3 !important;
}
:root.theme-luxury .auth-welcome-sub {
  color: rgba(244,233,211,0.72) !important;
}
:root.theme-luxury .auth-welcome-sub span {
  color: #f2c96d !important;
  -webkit-text-fill-color: #f2c96d !important;
}

/* Portal tag */
:root.theme-luxury .auth-portal-tag {
  background: rgba(205,154,72,0.12);
  border-color: rgba(205,154,72,0.35);
  color: #f2c96d !important;
}

/* Tab bar & buttons */
:root.theme-luxury .auth-tabs {
  background: #111111;
  border-color: rgba(205,154,72,0.28);
}
:root.theme-luxury .auth-tab-btn {
  color: rgba(205,154,72,0.75) !important;
}
:root.theme-luxury .auth-tab-btn.active {
  background: linear-gradient(135deg, #ca9745 0%, #ca9745 100%) !important;
  color: #ffffff !important;
}
:root.theme-luxury .auth-tab-btn:not(.active):hover {
  background: rgba(205,154,72,0.1) !important;
  color: #f2c96d !important;
}

/* Inputs */
:root.theme-luxury .auth-input {
  background: #111111 !important;
  border-color: rgba(205,154,72,0.3) !important;
  color: #f4e9d3 !important;
}
:root.theme-luxury .auth-input::placeholder {
  color: rgba(255,255,255,0.35) !important;
}
:root.theme-luxury .auth-input:focus {
  border-color: #ca9745 !important;
  box-shadow: 0 0 0 4px rgba(205,154,72,0.16) !important;
  background: #161616 !important;
}
:root.theme-luxury .auth-input-icon {
  color: #ca9745 !important;
}
:root.theme-luxury .auth-input:-webkit-autofill,
:root.theme-luxury .auth-input:-webkit-autofill:focus {
  -webkit-text-fill-color: #f4e9d3 !important;
  -webkit-box-shadow: 0 0 0px 1000px #111111 inset !important;
}

/* Labels */
:root.theme-luxury .auth-field label {
  color: rgba(205,154,72,0.85) !important;
  -webkit-text-fill-color: rgba(205,154,72,0.85) !important;
}
:root.theme-luxury .auth-field:focus-within label {
  color: #f2c96d !important;
  -webkit-text-fill-color: #f2c96d !important;
}

/* Check row */
:root.theme-luxury .auth-check-label {
  color: rgba(244,233,211,0.75) !important;
}
:root.theme-luxury .auth-forgot {
  color: #f2c96d !important;
}

/* Submit button */
:root.theme-luxury .auth-submit-btn {
  background: linear-gradient(135deg, #ca9745 0%, #ca9745 100%) !important;
  color: #ffffff !important;
  box-shadow: 0 6px 22px rgba(205,154,72,0.38) !important;
}
:root.theme-luxury .auth-submit-btn:hover {
  background: linear-gradient(135deg, #ca9745 0%, #ca9745 100%) !important;
  box-shadow: 0 10px 30px rgba(205,154,72,0.5) !important;
}

/* Divider & link */
:root.theme-luxury .auth-divider {
  color: rgba(244,233,211,0.5) !important;
}
:root.theme-luxury .auth-divider::before,
:root.theme-luxury .auth-divider::after {
  background: rgba(205,154,72,0.2) !important;
}

/* Alerts */
:root.theme-luxury .auth-alert-danger {
  background: rgba(185,28,28,0.2) !important;
  border-color: rgba(185,28,28,0.4) !important;
  color: #fca5a5 !important;
}
:root.theme-luxury .auth-alert-success {
  background: rgba(21,128,61,0.2) !important;
  border-color: rgba(21,128,61,0.4) !important;
  color: #86efac !important;
}

/* Description text — override global p/span from theme */
:root.theme-luxury .auth-brand-desc {
  color: #ca9745 !important;
  -webkit-text-fill-color: #ca9745 !important;
}

/* Flower dots golden centre stays visible */
:root.theme-luxury .fc-dot {
  box-shadow: 0 0 12px rgba(255,215,0,0.9) !important;
}

/* Petals slightly brighter in dark bg */
:root.theme-luxury .falling-petal {
  background: linear-gradient(135deg, rgba(205,154,72,0.75), rgba(240,180,60,0.45)) !important;
}


/* Floating label inputs */
.auth-field {
  position: relative;
  margin-bottom: 18px;
}
.auth-field label {
  display: block;
  font-size: 0.78rem;
  font-weight: 700;
  color: #7a5c3e;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  margin-bottom: 6px;
  transition: color 0.2s;
}
.auth-field:focus-within label { color: #ca9745; }

.auth-input-wrap {
  position: relative;
  display: flex;
  align-items: center;
}
.auth-input-icon {
  position: absolute;
  left: 15px;
  color: #b08a5a;
  font-size: 1rem;
  pointer-events: none;
  transition: color 0.2s;
  z-index: 2;
}
.auth-field:focus-within .auth-input-icon { color: #ca9745; }

.auth-input {
  width: 100%;
  padding: 12px 44px 12px 42px;
  border: 1.5px solid #e8ddd0;
  border-radius: 12px;
  background: #fdfaf7;
  color: #1a0f0a;
  font-size: 0.93rem;
  font-weight: 500;
  font-family: 'Plus Jakarta Sans', sans-serif;
  transition: all 0.25s cubic-bezier(0.16,1,0.3,1);
  outline: none;
  -webkit-appearance: none;
}
.auth-input::placeholder { color: #c4ad96; font-weight: 400; }
.auth-input:focus {
  border-color: #ca9745;
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(205,154,72,0.12), 0 2px 8px rgba(205,154,72,0.08);
}
.auth-input:-webkit-autofill,
.auth-input:-webkit-autofill:focus {
  -webkit-text-fill-color: #1a0f0a !important;
  -webkit-box-shadow: 0 0 0px 1000px #ffffff inset !important;
}
/* No left icon variant */
.auth-input.no-icon { padding-left: 15px; }

.auth-eye-btn {
  position: absolute;
  right: 14px;
  background: none;
  border: none;
  color: #b08a5a;
  cursor: pointer;
  font-size: 1rem;
  padding: 0;
  z-index: 2;
  transition: color 0.2s;
  line-height: 1;
}
.auth-eye-btn:hover { color: #ca9745; }

/* Checkbox */
.auth-check-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
.auth-check-label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 0.83rem;
  font-weight: 500;
  color: #6b5040;
  cursor: pointer;
  user-select: none;
}
.auth-check-box {
  width: 17px; height: 17px;
  border: 1.5px solid rgba(205,154,72,0.5);
  border-radius: 5px;
  cursor: pointer;
  accent-color: #ca9745;
}
.auth-forgot {
  font-size: 0.83rem;
  font-weight: 700;
  color: #ca9745;
  text-decoration: none;
  transition: color 0.2s;
}
.auth-forgot:hover { color: #ca9745; text-decoration: underline; }

/* Submit button */
.auth-submit-btn {
  width: 100%;
  padding: 14px;
  border: none;
  border-radius: 13px;
  background: linear-gradient(135deg, #ca9745 0%, #ca9745 100%);
  color: #ffffff;
  font-size: 1rem;
  font-weight: 700;
  letter-spacing: 0.5px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
  box-shadow: 0 6px 20px rgba(205,154,72,0.35);
  position: relative;
  overflow: hidden;
}
.auth-submit-btn::before {
  content: '';
  position: absolute;
  top: 0; left: -100%;
  width: 60%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
  transform: skewX(-20deg);
  transition: left 0.5s ease;
}
.auth-submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(205,154,72,0.5);
}
.auth-submit-btn:hover::before { left: 160%; }
.auth-submit-btn:active { transform: translateY(0); }

/* Divider */
.auth-divider {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 18px 0 0;
  color: #c4ad96;
  font-size: 0.78rem;
  font-weight: 500;
}
.auth-divider::before, .auth-divider::after {
  content: '';
  flex: 1;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(205,154,72,0.25), transparent);
}

/* Grid row for signup */
.auth-grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
}

/* Alert boxes */
.auth-alert {
  padding: 12px 16px;
  border-radius: 12px;
  font-size: 0.85rem;
  font-weight: 600;
  margin-bottom: 18px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.auth-alert-success {
  background: linear-gradient(135deg, #d4f4e2, #c8f0da);
  border: 1px solid rgba(40,167,69,0.25);
  color: #155724;
}
.auth-alert-danger {
  background: linear-gradient(135deg, #fde8e8, #fbd5d5);
  border: 1px solid rgba(220,53,69,0.25);
  color: #721c24;
}

/* Sliding panel */
@media (min-width: 992px) {
  .auth-image-col {
    order: 1;
    border-radius: 0 28px 28px 0;
  }
  .auth-form-col { order: 0; }

  .auth-card.panel-signup .auth-image-col {
    transform: translateX(-100%);
    border-radius: 28px 0 0 28px;
  }
  .auth-card.panel-signup .auth-form-col {
    transform: translateX(100%);
  }
}

/* Tab content */
.auth-tab-content { position: relative; }
.auth-tab-pane {
  display: none;
  animation: tabFadeIn 0.4s ease both;
}
.auth-tab-pane.active { display: block; }
@keyframes tabFadeIn {
  from { opacity:0; transform: translateY(10px); }
  to   { opacity:1; transform: translateY(0); }
}

/* Decorative gold dot accent */
.gold-dot {
  display: inline-block;
  width: 6px; height: 6px;
  background: #ca9745;
  border-radius: 50%;
  margin-right: 2px;
  vertical-align: middle;
}
</style>
</head>
<body>
<?php include('header.php'); ?>

<?php
$activeTab = 'signin';
if (isset($_SESSION['register_error'])) { $activeTab = 'signup'; }
?>

<div class="auth-page-bg">

  <!-- Falling petals container (JS-driven) -->
  <div id="petalCanvas" style="position:fixed;inset:0;pointer-events:none;z-index:0;overflow:hidden;"></div>


  <div class="container" style="position:relative;z-index:1;">
    <div class="auth-card <?= $activeTab === 'signup' ? 'panel-signup' : '' ?>">
      <div class="row g-0" style="align-items:stretch;">

        <!-- ═══ FORM COLUMN ═══ -->
        <div class="col-lg-6 auth-form-col">
          <div class="auth-form-inner">

            <!-- Header -->
            <div class="auth-form-header">
              <div class="auth-portal-tag">
                <i class="bi bi-gem"></i> Stitch Smart Portal
              </div>
              <h2 class="auth-welcome-text">
                <?= $activeTab === 'signup' ? 'Create Account' : 'Welcome Back' ?>
              </h2>
              <p class="auth-welcome-sub" id="authSubtitle">
                <?= $activeTab === 'signup'
                  ? 'Join <span>Stitch Smart</span> — your luxury fashion journey begins here.'
                  : 'Sign in to your <span>Stitch Smart</span> account to continue.' ?>
              </p>
            </div>

            <!-- Tab Switcher -->
            <div class="auth-tabs" role="tablist">
              <button class="auth-tab-btn <?= $activeTab === 'signin' ? 'active' : '' ?>"
                      id="signinTabBtn" data-tab="signin" type="button">
                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
              </button>
              <button class="auth-tab-btn <?= $activeTab === 'signup' ? 'active' : '' ?>"
                      id="signupTabBtn" data-tab="signup" type="button">
                <i class="bi bi-person-plus me-1"></i> Sign Up
              </button>
            </div>

            <!-- Tab Content -->
            <div class="auth-tab-content">

              <!-- ── SIGN IN ── -->
              <div class="auth-tab-pane <?= $activeTab === 'signin' ? 'active' : '' ?>" id="pane-signin">


                <?php if(isset($_SESSION['login_error'])): ?>
                  <div class="auth-alert auth-alert-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <?= htmlspecialchars($_SESSION['login_error']); unset($_SESSION['login_error']); ?>
                  </div>
                <?php endif; ?>

                <form method="POST" action="<?= url('') ?>customer_login">
                  <input type="hidden" name="redirect" value="home">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">

                  <div class="auth-field">
                    <label>Email Address</label>
                    <div class="auth-input-wrap">
                      <i class="bi bi-envelope auth-input-icon"></i>
                      <input type="email" name="email" class="auth-input" placeholder="name@example.com" required autocomplete="email">
                    </div>
                  </div>

                  <div class="auth-field">
                    <label>Password</label>
                    <div class="auth-input-wrap">
                      <i class="bi bi-lock auth-input-icon"></i>
                      <input type="password" name="password" id="loginPassword" class="auth-input" placeholder="••••••••" required autocomplete="current-password">
                      <button type="button" class="auth-eye-btn" data-target="loginPassword">
                        <i class="bi bi-eye"></i>
                      </button>
                    </div>
                  </div>

                  <div class="auth-check-row">
                    <label class="auth-check-label">
                      <input type="checkbox" name="remember" class="auth-check-box">
                      Remember Me
                    </label>
                    <a href="<?= url('') ?>customer_forgot_password" class="auth-forgot">
                      Forgot Password?
                    </a>
                  </div>

                  <button type="submit" class="auth-submit-btn">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In to My Account
                  </button>

                  <div class="auth-divider">or new here?
                    <a href="#" class="auth-forgot" id="goSignup" style="color:#ca9745;">Create Account →</a>
                  </div>
                </form>
              </div>

              <!-- ── SIGN UP ── -->
              <div class="auth-tab-pane <?= $activeTab === 'signup' ? 'active' : '' ?>" id="pane-signup">

                <?php if(isset($_SESSION['register_error'])): ?>
                  <div class="auth-alert auth-alert-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <?= htmlspecialchars($_SESSION['register_error']); unset($_SESSION['register_error']); ?>
                  </div>
                <?php endif; ?>

                <form method="POST" action="<?= url('') ?>customer_register" onsubmit="return validateRegisterForm()">
                  <input type="hidden" name="redirect" value="home">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">

                  <!-- Row 1: Name + Phone -->
                  <div class="auth-grid-2">
                    <div class="auth-field" style="margin-bottom:14px;">
                      <label>Full Name</label>
                      <div class="auth-input-wrap">
                        <i class="bi bi-person auth-input-icon"></i>
                        <input type="text" name="name" class="auth-input" placeholder="John Doe" required autocomplete="name">
                      </div>
                    </div>
                    <div class="auth-field" style="margin-bottom:14px;">
                      <label>Phone</label>
                      <div class="auth-input-wrap">
                        <i class="bi bi-telephone auth-input-icon"></i>
                        <input type="text" name="phone" class="auth-input" placeholder="+92 300 0000000" autocomplete="tel">
                      </div>
                    </div>
                  </div>

                  <!-- Email -->
                  <div class="auth-field" style="margin-bottom:14px;">
                    <label>Email Address</label>
                    <div class="auth-input-wrap">
                      <i class="bi bi-envelope auth-input-icon"></i>
                      <input type="email" name="email" class="auth-input" placeholder="name@example.com" required autocomplete="email">
                    </div>
                  </div>

                  <!-- Row 2: Password + Confirm -->
                  <div class="auth-grid-2">
                    <div class="auth-field" style="margin-bottom:14px;">
                      <label>Password</label>
                      <div class="auth-input-wrap">
                        <i class="bi bi-lock auth-input-icon"></i>
                        <input type="password" name="password" id="registerPassword" class="auth-input" placeholder="••••••••" required minlength="6" autocomplete="new-password">
                        <button type="button" class="auth-eye-btn" data-target="registerPassword">
                          <i class="bi bi-eye"></i>
                        </button>
                      </div>
                    </div>
                    <div class="auth-field" style="margin-bottom:14px;">
                      <label>Confirm</label>
                      <div class="auth-input-wrap">
                        <i class="bi bi-lock-fill auth-input-icon"></i>
                        <input type="password" name="confirm_password" id="registerConfirmPassword" class="auth-input" placeholder="••••••••" required autocomplete="new-password">
                        <button type="button" class="auth-eye-btn" data-target="registerConfirmPassword">
                          <i class="bi bi-eye"></i>
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="text-danger mb-3 d-none" id="match-error" style="font-size:0.82rem; font-weight:600; display:flex; align-items:center; gap:6px;">
                    <i class="bi bi-x-circle-fill"></i> Passwords do not match.
                  </div>

                  <button type="submit" class="auth-submit-btn">
                    <i class="bi bi-person-plus me-2"></i>Create My Account
                  </button>

                  <div class="auth-divider">already a member?
                    <a href="#" class="auth-forgot" id="goSignin" style="color:#ca9745;">Sign In →</a>
                  </div>
                </form>
              </div>

            </div><!-- /tab-content -->
          </div>
        </div>

        <!-- ═══ IMAGE COLUMN ═══ -->
        <div class="col-lg-6 d-none d-lg-flex auth-image-col">
          <div class="auth-image-overlay">
            <div class="auth-brand-badge">
              <i class="bi bi-stars"></i> Premium Collection
            </div>
            <h2 class="auth-brand-title">
              Stitch<br><span>Smart</span>
            </h2>
            <p class="auth-brand-desc">
              Elevate your style with curated luxury, bespoke stitching, and timeless designs tailored exclusively for you.
            </p>
            <div class="auth-trust-badges">
              <div class="auth-trust-pill"><i class="bi bi-shield-check"></i> Secure Checkout</div>
              <div class="auth-trust-pill"><i class="bi bi-award"></i> Premium Quality</div>
              <div class="auth-trust-pill"><i class="bi bi-truck"></i> Fast Delivery</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function() {
  const card      = document.querySelector('.auth-card');
  const signinBtn = document.getElementById('signinTabBtn');
  const signupBtn = document.getElementById('signupTabBtn');
  const paneSignin = document.getElementById('pane-signin');
  const paneSignup = document.getElementById('pane-signup');
  const subtitle  = document.getElementById('authSubtitle');
  const titleEl   = document.querySelector('.auth-welcome-text');
  const goSignup  = document.getElementById('goSignup');
  const goSignin  = document.getElementById('goSignin');

  function switchTo(tab) {
    if (tab === 'signup') {
      signinBtn.classList.remove('active');
      signupBtn.classList.add('active');
      paneSignin.classList.remove('active');
      paneSignup.classList.add('active');
      card.classList.add('panel-signup');
      if (titleEl) titleEl.textContent = 'Create Account';
      if (subtitle) subtitle.innerHTML = 'Join <span style="color:#ca9745;font-weight:700;">Stitch Smart</span> — your luxury fashion journey begins here.';
    } else {
      signupBtn.classList.remove('active');
      signinBtn.classList.add('active');
      paneSignup.classList.remove('active');
      paneSignin.classList.add('active');
      card.classList.remove('panel-signup');
      if (titleEl) titleEl.textContent = 'Welcome Back';
      if (subtitle) subtitle.innerHTML = 'Sign in to your <span style="color:#ca9745;font-weight:700;">Stitch Smart</span> account to continue.';
    }
  }

  signinBtn.addEventListener('click', () => switchTo('signin'));
  signupBtn.addEventListener('click', () => switchTo('signup'));
  goSignup?.addEventListener('click', (e) => { e.preventDefault(); switchTo('signup'); });
  goSignin?.addEventListener('click', (e) => { e.preventDefault(); switchTo('signin'); });

  // Eye toggle
  document.querySelectorAll('.auth-eye-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const id = this.getAttribute('data-target');
      const input = document.getElementById(id);
      const icon  = this.querySelector('i');
      if (!input) return;
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
      }
    });
  });
})();

// Password match validation
function validateRegisterForm() {
  const pw  = document.getElementById('registerPassword').value;
  const cpw = document.getElementById('registerConfirmPassword').value;
  const err = document.getElementById('match-error');
  if (pw !== cpw) {
    err.classList.remove('d-none');
    err.style.display = 'flex';
    return false;
  }
  err.classList.add('d-none');
  return true;
}

// ── Falling Petals ──
(function() {
  const canvas = document.getElementById('petalCanvas');
  if (!canvas) return;

  const PETAL_COUNT = 18;
  const active = [];

  function rand(min, max) { return Math.random() * (max - min) + min; }

  function spawnPetal() {
    const el   = document.createElement('div');
    const w    = rand(10, 26);
    const h    = w * rand(1.4, 1.9);
    const dur  = rand(7, 14);
    const dx   = rand(-70, 70);
    const rot  = rand(200, 500);
    const left = rand(0, 100);
    const delay = rand(0, 4);
    const opacity = rand(0.55, 0.9);

    el.className = 'falling-petal';
    el.style.cssText = `
      width:${w}px;
      height:${h}px;
      left:${left}%;
      top:-${h + 10}px;
      opacity:0;
      --dx:${dx}px;
      --rot:${rot}deg;
      animation-name: petalDrift;
      animation-duration: ${dur}s;
      animation-delay: ${delay}s;
      animation-timing-function: linear;
      animation-fill-mode: forwards;
      transform: rotate(${rand(0,360)}deg);
    `;

    canvas.appendChild(el);
    const total = (dur + delay + 0.5) * 1000;
    setTimeout(() => { el.remove(); spawnPetal(); }, total);
  }

  // Stagger initial petals
  for (let i = 0; i < PETAL_COUNT; i++) {
    setTimeout(spawnPetal, i * 450);
  }
})();

// ── Floating Flower Clusters ──
(function() {
  const style = document.createElement('style');
  style.textContent = `
    .fc { position:fixed; pointer-events:none; z-index:0; }
    .fc-wrap { position:relative; animation: fcFloat ease-in-out infinite; }
    .fp {
      position:absolute;
      border-radius: 50% 50% 0 50%;
      background: linear-gradient(135deg, rgba(205,154,72,0.82), rgba(180,120,35,0.6));
      transform-origin: bottom center;
    }
    .fp:nth-child(1){ transform:rotate(0deg)   translateY(-42%) scaleY(1.1); }
    .fp:nth-child(2){ transform:rotate(90deg)  translateY(-42%) scaleY(1.1); }
    .fp:nth-child(3){ transform:rotate(180deg) translateY(-42%) scaleY(1.1); }
    .fp:nth-child(4){ transform:rotate(270deg) translateY(-42%) scaleY(1.1); }
    .fc-dot {
      position:absolute; border-radius:50%;
      background: radial-gradient(circle, #FFD700, #ca9745);
      top:50%; left:50%; transform:translate(-50%,-50%);
      box-shadow: 0 0 8px rgba(255,215,0,0.7);
    }
    @keyframes fcFloat {
      0%,100% { transform:translateY(0)   rotate(0deg)  scale(1);    opacity:0.22; }
      33%     { transform:translateY(-16px) rotate(12deg) scale(1.08); opacity:0.28; }
      66%     { transform:translateY(7px)  rotate(-8deg) scale(0.94); opacity:0.18; }
    }
  `;
  document.head.appendChild(style);

  const positions = [
    { top:'5%',  left:'1%',   size:58, dur:6   },
    { top:'15%', left:'91%',  size:42, dur:8   },
    { top:'45%', left:'94%',  size:36, dur:5.5 },
    { top:'72%', left:'0.5%', size:50, dur:7   },
    { top:'80%', left:'92%',  size:38, dur:9   },
    { top:'55%', left:'1%',   size:32, dur:10  },
    { top:'2%',  left:'48%',  size:28, dur:7.5 },
    { top:'87%', left:'44%',  size:26, dur:6.5 },
  ];

  positions.forEach(({ top, left, size, dur }, i) => {
    const fc   = document.createElement('div');
    fc.className = 'fc';
    fc.style.cssText = `top:${top};left:${left};width:${size}px;height:${size}px;`;

    const wrap = document.createElement('div');
    wrap.className = 'fc-wrap';
    wrap.style.cssText = `width:${size}px;height:${size}px;animation-duration:${dur}s;animation-delay:${i*0.6}s;`;

    const pw = size * 0.38, ph = size * 0.62;
    for (let p = 0; p < 4; p++) {
      const petal = document.createElement('div');
      petal.className = 'fp';
      petal.style.cssText = `width:${pw}px;height:${ph}px;top:${(size-ph)/2}px;left:${(size-pw)/2}px;`;
      wrap.appendChild(petal);
    }
    const dot = document.createElement('div');
    dot.className = 'fc-dot';
    dot.style.cssText = `width:${size*0.22}px;height:${size*0.22}px;`;
    wrap.appendChild(dot);

    fc.appendChild(wrap);
    document.body.appendChild(fc);
  });
})();
</script>
</body>
</html>

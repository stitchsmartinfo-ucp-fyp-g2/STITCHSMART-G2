<?php
$hide_header = true;
$hide_footer = true;
$hide_chatbot = true;
include(__DIR__ . '/header.php');

$theme = $global_theme ?? 'theme-default';
$themeFile = ($theme === 'theme-luxury') ? 'theme-luxury-frontend.css' : 'theme-default-frontend.css';

// The aesthetic colors for the business card design based on user's image
$cardAccent = '#1c1c1c'; // Dark text on yellow
$cardDark = '#CF9A42';   // Mustard/Golden yellow from new image
$cardLight = '#ffffff';  // White side
$textDark = '#111111';
$textLight = '#ffffff';

if ($theme === 'theme-luxury') {
    $cardDark = '#D4AF37'; // Gold
}
?>
<!DOCTYPE html>
<html lang="en" class="<?= htmlspecialchars($theme); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StitchSmart - Digital Warranty Cards</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/<?= htmlspecialchars($themeFile); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        try { document.documentElement.classList.add('<?= htmlspecialchars($theme); ?>'); } catch(e) {}
    </script>

<style>
/* ============================================================
   3D FLIP BUSINESS CARD DESIGN
   ============================================================ */
body {
    background: #fdfcf9 !important; /* Clean, premium off-white */
    font-family: 'Montserrat', sans-serif !important;
    overflow-x: hidden;
}

.w-page {
    min-height: 100vh;
}

/* ============================================================
   SPLIT-SCREEN HERO SECTION (MATCHING USER IMAGE)
   ============================================================ */
.hero-warranty {
    position: relative;
    background-color: <?= $cardDark ?>; /* Yellow left side */
    padding: 80px 0;
    overflow: hidden;
    min-height: 600px;
    display: flex;
    align-items: center;
}
.hero-curve {
    position: absolute;
    right: -5%;
    top: -10%;
    height: 120%;
    width: 65%;
    background-color: <?= $cardLight ?>; /* White right side */
    border-top-left-radius: 100% 50%;
    border-bottom-left-radius: 100% 50%;
    box-shadow: -15px 0 40px rgba(0,0,0,0.05);
    z-index: 1;
}
.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem;
    font-weight: 800;
    color: <?= $cardAccent ?>;
    margin-bottom: 20px;
    line-height: 1.1;
}
.hero-subtitle {
    font-size: 1.5rem;
    font-weight: 600;
    color: <?= $cardAccent ?>;
    margin-bottom: 15px;
}
.hero-text {
    color: rgba(0,0,0,0.7);
    font-size: 0.9rem;
    max-width: 400px;
    line-height: 1.6;
    margin-bottom: 40px;
}
.hero-icons {
    display: flex;
    gap: 15px;
}
.hero-icon-box {
    width: 60px;
    height: 60px;
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: <?= $cardAccent ?>;
    transition: all 0.3s;
    background: transparent;
}
.hero-icon-box:hover {
    background: <?= $cardAccent ?>;
    color: <?= $cardDark ?>;
    transform: translateY(-5px);
}
.hero-back-btn {
    position: absolute;
    top: 30px;
    left: 30px;
    z-index: 10;
    color: <?= $cardAccent ?>;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid rgba(0,0,0,0.1);
    padding: 8px 20px;
    border-radius: 50px;
    transition: all 0.3s;
}
.hero-back-btn:hover {
    background: <?= $cardAccent ?>;
    color: <?= $cardDark ?>;
}

/* FLIP CONTAINER */
.card-container {
    perspective: 1500px;
    margin: 20px auto 40px auto;
    width: 100%;
    max-width: 500px;
    height: 280px;
    cursor: pointer;
}

.card-flip-inner {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: center;
    transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    transform-style: preserve-3d;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    border-radius: 12px;
}

/* Hover effect triggers flip */
.card-container:hover .card-flip-inner {
    transform: rotateY(180deg);
}

/* FRONT & BACK BASE */
.card-front, .card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
}

/* FRONT DESIGN (Matches Image Front) */
.card-front {
    background-color: <?= $cardLight ?>;
}
.cf-left {
    width: 35%;
    background-color: <?= $cardDark ?>;
    position: relative;
}
/* The green ribbons/chevrons on the front */
.cf-chevron-outer {
    position: absolute;
    right: -25px;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 100px;
    background-color: <?= $cardAccent ?>;
    clip-path: polygon(0 0, 100% 50%, 0 100%, 25% 50%);
}
.cf-chevron-inner {
    position: absolute;
    right: -45px;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 140px;
    background-color: #e0e0e0;
    clip-path: polygon(0 0, 100% 50%, 0 100%, 25% 50%);
    z-index: -1;
}
:root.theme-luxury .cf-chevron-inner { background-color: #333; }

.cf-right {
    width: 65%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
}
.cf-logo-circle {
    width: 60px;
    height: 60px;
    background-color: <?= $cardAccent ?>;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 10px;
}
.cf-title {
    font-weight: 800;
    font-size: 1.2rem;
    color: <?= $textDark ?>;
    letter-spacing: 1px;
    margin: 0;
}
.cf-subtitle {
    font-size: 0.65rem;
    letter-spacing: 2px;
    color: #888;
    text-transform: uppercase;
}

/* BACK DESIGN (Matches Image Back) */
.card-back {
    background-color: <?= $cardDark ?>;
    transform: rotateY(180deg);
}
.cb-left {
    width: 55%;
    background-color: <?= $cardLight ?>;
    padding: 25px 20px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    text-align: left;
    position: relative;
    z-index: 2;
}
.cb-right {
    width: 45%;
    background-color: <?= $cardDark ?>;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
/* The green ribbons on the back right */
.cb-chevron {
    position: absolute;
    left: -25px;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 120px;
    background-color: <?= $cardAccent ?>;
    clip-path: polygon(100% 0, 0 50%, 100% 100%, 75% 50%);
}
.cb-name {
    font-weight: 800;
    font-size: 1.1rem;
    color: <?= $textDark ?>;
    text-transform: uppercase;
    margin: 0;
    line-height: 1.1;
}
.cb-name span { color: <?= $cardAccent ?>; }
.cb-title {
    font-size: 0.6rem;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 2px solid <?= $cardAccent ?>;
    padding-bottom: 8px;
    margin-bottom: 15px;
    display: inline-block;
}
.cb-info-row {
    display: flex;
    align-items: flex-start;
    margin-bottom: 10px;
}
.cb-icon {
    background-color: <?= $cardAccent ?>;
    color: #fff;
    width: 18px;
    height: 18px;
    border-radius: 3px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.55rem;
    margin-right: 10px;
    margin-top: 2px;
}
.cb-text {
    font-size: 0.65rem;
    color: <?= $textDark ?>;
    line-height: 1.3;
}

/* Action Buttons */
.claim-btn-container {
    text-align: center;
    margin-top: 15px;
}
.btn-claim {
    background-color: <?= $cardAccent ?>;
    color: #fff !important;
    border: none;
    padding: 10px 30px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 50px;
    font-size: 0.85rem;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.btn-claim:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Modals */
.modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

/* 3D Claim Card Animation */
.claim-card-3d {
    transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.5s ease;
    transform-style: preserve-3d;
}
.claim-card-3d:hover {
    transform: translateY(-10px) rotateX(5deg) rotateY(-2deg);
    box-shadow: 0 25px 40px rgba(0,0,0,0.15) !important;
}
</style>
</head>
<body>
<div class="w-page">
    
    <a href="<?= url('customer_orders') ?>" class="hero-back-btn">
        <i class="bi bi-arrow-left"></i> Back to Orders
    </a>

    <!-- THE SPLIT HERO SECTION -->
    <div class="hero-warranty">
        <div class="hero-curve"></div>
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <h1 class="hero-title">1 Year<br>Warranty</h1>
                    <div class="hero-subtitle">Welcome to our site</div>
                    <p class="hero-text">
                        Experience peace of mind with our premium digital warranty system. We stand by the quality of our craftsmanship, offering comprehensive coverage for your bespoke garments.
                    </p>
                </div>
                
                <!-- Right Side Card (Shows the latest warranty, or placeholder) -->
                <div class="col-lg-7 text-center">
                    <?php if (!empty($warranties)): $w = $warranties[0]; ?>
                        <!-- THE 3D FLIP CARD -->
                        <div class="card-container" style="margin: 0 auto;">
                            <div class="card-flip-inner">
                                
                                <!-- CARD FRONT -->
                                <div class="card-front">
                                    <div class="cf-left">
                                        <div class="cf-chevron-inner"></div>
                                        <div class="cf-chevron-outer"></div>
                                    </div>
                                    <div class="cf-right">
                                        <div class="cf-logo-circle">S</div>
                                        <h3 class="cf-title">STITCH SMART</h3>
                                        <div class="cf-subtitle">Premium Custom Tailoring</div>
                                        
                                        <div class="mt-4 px-3 py-2" style="background: rgba(0,0,0,0.03); border-radius: 8px;">
                                            <div style="font-family: monospace; font-size: 1.1rem; letter-spacing: 2px; font-weight: 800; color: <?= $cardAccent ?>">
                                                <?= htmlspecialchars($w['code']) ?>
                                            </div>
                                            <div style="font-size: 0.6rem; color: #888; text-transform: uppercase;">Reference Code</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- CARD BACK -->
                                <div class="card-back">
                                    <div class="cb-left">
                                        <?php 
                                            // Split name into first and last for styling
                                            $nameParts = explode(' ', htmlspecialchars($_SESSION['customer_name'] ?? 'Guest User'), 2);
                                            $firstName = $nameParts[0] ?? '';
                                            $lastName = $nameParts[1] ?? '';
                                        ?>
                                        <h4 class="cb-name"><?= $firstName ?> <span><?= $lastName ?></span></h4>
                                        <div class="cb-title">Valued Customer</div>
                                        
                                        <div class="cb-info-row">
                                            <div class="cb-icon"><i class="bi bi-hash"></i></div>
                                            <div class="cb-text">
                                                <strong>Order #<?= htmlspecialchars($w['order_id']) ?></strong><br>
                                                <?= htmlspecialchars($w['invoice_no'] ?? '') ?>
                                            </div>
                                        </div>
                                        
                                        <div class="cb-info-row">
                                            <div class="cb-icon"><i class="bi bi-calendar-check"></i></div>
                                            <div class="cb-text">
                                                <strong>Valid Until</strong><br>
                                                <?= date('M d, Y', strtotime($w['expires_at'])) ?>
                                            </div>
                                        </div>
                                        
                                        <div class="cb-info-row mt-2 pt-2" style="border-top: 1px dotted #ccc;">
                                            <div class="cb-icon" style="background: #333;"><i class="bi bi-shield-check"></i></div>
                                            <div class="cb-text text-muted" style="font-size: 0.6rem; max-height: 40px; overflow: hidden; text-overflow: ellipsis;">
                                                <?= htmlspecialchars($w['terms']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cb-right">
                                        <div class="cb-chevron"></div>
                                        <div class="text-center" style="z-index: 2; padding-left: 20px;">
                                            <div class="cf-logo-circle" style="width: 45px; height: 45px; font-size: 18px; margin: 0 auto 5px auto;">S</div>
                                            <div style="color: <?= $textLight ?>; font-size: 0.7rem; font-weight: 700;">WARRANTY<br>CARD</div>
                                            <?php 
                                                $statusColor = (strtolower($w['status']) === 'active') ? '#4ade80' : '#f87171';
                                            ?>
                                            <div class="mt-3" style="color: <?= $statusColor ?>; font-size: 0.7rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase;">
                                                <?= htmlspecialchars($w['status']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <?php 
                            $hasPendingClaim = false;
                            if(!empty($claims)) {
                                foreach($claims as $c) {
                                    if(isset($c['warranty_id']) && $c['warranty_id'] == $w['id'] && $c['status'] == 'Pending') {
                                        $hasPendingClaim = true;
                                        break;
                                    }
                                }
                            }
                        ?>
                        <?php if (strtolower($w['status']) === 'active'): ?>
                            <div class="claim-btn-container">
                                <?php if ($hasPendingClaim): ?>
                                    <button class="btn py-2 px-4 fw-bold shadow-sm" style="background: #e9ecef; color: #6c757d; border-radius: 50px; cursor: not-allowed;" disabled>
                                        <i class="bi bi-hourglass-split me-2"></i> Claim Pending Review
                                    </button>
                                <?php else: ?>
                                    <button class="btn-claim" data-bs-toggle="modal" data-bs-target="#claimModal<?= $w['id'] ?>">
                                        Claim Warranty
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-shield-x display-1 mb-3 text-muted opacity-25"></i>
                            <h3 class="fw-bold text-muted">No Warranty Cards</h3>
                            <p class="text-muted">You do not have any active warranty cards at the moment.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTAINER FOR MODALS & HISTORY -->
    <div class="container pb-5" id="claim-section">
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success d-flex align-items-center mb-4 shadow-sm rounded-4 mt-5" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border: none; color: #155724; font-weight: 600;">
                <i class="bi bi-check-circle-fill fs-3 me-3" style="color: #28a745;"></i>
                <div>
                    <strong class="d-block mb-1" style="font-size: 1.1rem;">Success!</strong>
                    <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger d-flex align-items-center mb-4 shadow-sm rounded-4 mt-5" style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border: none; color: #721c24; font-weight: 600;">
                <i class="bi bi-exclamation-triangle-fill fs-3 me-3" style="color: #dc3545;"></i>
                <div>
                    <strong class="d-block mb-1" style="font-size: 1.1rem;">Error</strong>
                    <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($warranties)): ?>
            <?php foreach ($warranties as $index => $w): ?>
                <!-- Claim Modal (Render for all warranties) -->
                        <div class="modal fade" id="claimModal<?= $w['id'] ?>" tabindex="-1">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content overflow-hidden border-0" style="box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                              <div class="modal-header" style="background: <?= $cardAccent ?>; color: <?= $cardDark ?>; border-bottom: none;">
                                <h5 class="modal-title fw-bold" style="letter-spacing: 1px;"><i class="bi bi-tools me-2"></i> CLAIM WARRANTY</h5>
                                <button type="button" class="btn-close" style="filter: invert(1) sepia(1) saturate(5) hue-rotate(5deg);" data-bs-dismiss="modal"></button>
                              </div>
                              <form action="<?= url('submit_warranty_claim') ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateFileSize(this)">
                                  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                  <div class="modal-body p-4" style="background: #fff; color: #333;">
                                      <input type="hidden" name="warranty_id" value="<?= $w['id'] ?>">
                                      <div class="mb-4">
                                          <label class="form-label fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #555;">Describe the Issue</label>
                                          <textarea name="description" class="form-control" rows="4" required placeholder="E.g. stitching opened on the left sleeve..." style="background: #fdfdfd; border: 1px solid #e0e0e0; color: #222; border-radius: 8px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02); resize: none;"></textarea>
                                      </div>
                                      <div class="mb-3">
                                          <label class="form-label fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px; color: #555;">Upload Image (Optional)</label>
                                          <div class="input-group">
                                              <input type="file" name="claim_image" class="form-control" accept="image/*" style="background: #fdfdfd; border: 1px solid #e0e0e0; color: #222; border-radius: 8px;">
                                          </div>
                                          <small class="text-danger d-none file-error mt-2 fw-bold"><i class="bi bi-exclamation-circle me-1"></i> File size must be under 2MB.</small>
                                      </div>
                                  </div>
                                  <div class="modal-footer" style="background: #f9f9f9; border-top: 1px solid #eaeaea;">
                                      <button type="submit" class="btn w-100 fw-bold py-3 shadow-sm claim-submit-btn" style="border-radius: 50px; background: <?= $cardAccent ?>; color: <?= $cardDark ?>; font-size: 1rem; letter-spacing: 1px; transition: all 0.3s;"><i class="bi bi-send-check me-2"></i> Submit Request</button>
                                  </div>
                              </form>
                            </div>
                          </div>
                        </div>

            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($claims)): ?>
            <div class="mt-5 pt-4">
                <div class="card border-0 mx-auto" style="max-width: 900px; border-radius: 12px; background: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden;">
                    
                    <!-- Header -->
                    <div class="d-flex align-items-center p-4" style="background: #fff; border-bottom: 1px solid #f0f0f0;">
                        <div style="width: 50px; height: 50px; background: #4caf50; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-right: 20px;">
                            <i class="bi bi-folder2-open"></i>
                        </div>
                        <div>
                            <h3 class="mb-0" style="font-family: 'Playfair Display', serif; font-weight: 800; color: #2e5a31; font-size: 1.6rem;">Claim Summary</h3>
                            <p class="mb-0 text-success" style="font-size: 0.9rem; font-weight: 600;">Record of your submitted warranty claims</p>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="p-4" style="background: #fdfdfd;">
                        <div style="border: 1px solid #e0dcd3; border-radius: 8px; overflow: hidden;">
                            <div class="p-2 px-3 text-white fw-bold text-uppercase" style="background: #a67c52; font-size: 0.85rem; letter-spacing: 1px;">
                                Claim Summary
                            </div>
                            <table class="table table-borderless mb-0 align-middle" style="background: #fff;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #f0f0f0;">
                                        <th class="text-center text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px; width: 20%;">Date</th>
                                        <th class="text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px; width: 35%;">Activity / Issue</th>
                                        <th class="text-center text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px; width: 25%;">Warranty Ref</th>
                                        <th class="text-center text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px; width: 20%;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $rowCount = 0;
                                    foreach ($claims as $c): 
                                        $rowCount++;
                                        $rowBg = ($rowCount % 2 == 0) ? '#fff8e7' : '#ffffff'; // Alternating light yellow
                                    ?>
                                        <tr style="background-color: <?= $rowBg ?>; border-bottom: 1px solid #f5f5f5;">
                                            <td class="text-center" style="font-size: 0.9rem; color: #555; padding: 15px 10px;">
                                                <?= date('m/d/Y', strtotime($c['created_at'])) ?>
                                            </td>
                                            <td style="font-size: 0.9rem; color: #333; padding: 15px 10px;">
                                                <div class="fw-bold mb-1">Claim Initiated (ID: #<?= $c['id'] ?>)</div>
                                                <div class="text-muted" style="font-size: 0.85rem; line-height: 1.4;">
                                                    <?= htmlspecialchars($c['issue_description'] ?? 'No description provided.') ?>
                                                </div>
                                                <?php if(!empty($c['admin_notes'])): ?>
                                                    <div class="mt-2 p-2 rounded" style="background: rgba(166, 124, 82, 0.1); border-left: 2px solid #a67c52; font-size: 0.8rem; color: #555;">
                                                        <strong>Reply:</strong> <?= htmlspecialchars($c['admin_notes']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center" style="padding: 15px 10px;">
                                                <span style="font-family: monospace; font-size: 0.85rem; font-weight: 700; color: #a67c52; background: rgba(166, 124, 82, 0.1); padding: 4px 10px; border-radius: 4px;">
                                                    <?= htmlspecialchars($c['code']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center" style="padding: 15px 10px;">
                                                <?php 
                                                    $bg = 'bg-warning text-dark';
                                                    if($c['status']=='Approved') $bg='bg-success text-white';
                                                    if($c['status']=='Rejected') $bg='bg-danger text-white';
                                                    if($c['status']=='Resolved') $bg='bg-primary text-white';
                                                ?>
                                                <span class="badge <?= $bg ?> px-3 py-2" style="font-size: 0.75rem; letter-spacing: 0.5px; border-radius: 50px !important;">
                                                    <?= strtoupper($c['status']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Prevent form submission if file is > 2MB to avoid PHP post_max_size clearing $_POST and CSRF fail
function validateFileSize(form) {
    const fileInput = form.querySelector('input[type="file"]');
    const errorMsg = form.querySelector('.file-error');
    if (fileInput.files.length > 0) {
        const fileSize = fileInput.files[0].size / 1024 / 1024; // MB
        if (fileSize > 2) {
            errorMsg.classList.remove('d-none');
            return false;
        }
    }
    errorMsg.classList.add('d-none');
    return true;
}
</script>
</body>
</html>

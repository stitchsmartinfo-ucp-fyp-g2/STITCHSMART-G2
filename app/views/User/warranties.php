<?php
$hide_header = true;
$hide_footer = true;
$hide_chatbot = true;
include(__DIR__ . '/header.php');

$theme = $global_theme ?? 'theme-default';
$themeFile = ($theme === 'theme-luxury') ? 'theme-luxury-frontend.css' : 'theme-default-frontend.css';

// The aesthetic colors for the business card design based on user's image
$cardAccent = '#1a8a2d'; // Green from image
$cardDark = '#111111';   // Dark side
$cardLight = '#ffffff';  // Light side
$textDark = '#222222';
$textLight = '#f8f8f8';

if ($theme === 'theme-luxury') {
    // For luxury theme, maybe use gold instead of green
    $cardAccent = '#ca9745'; 
    $cardLight = '#1c1c1c';
    $textDark = '#e5e5e5';
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
    background: var(--co-bg, #f4f4f4) !important;
    font-family: 'Montserrat', sans-serif !important;
}

.w-header {
    background: var(--co-header-bg, #fff);
    border-bottom: 1px solid var(--co-border, #eaeaea);
    padding: 30px 0;
    margin-bottom: 40px;
}
.w-header-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--co-text-h, #111);
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
.modal-header {
    background-color: <?= $cardDark ?>;
    color: <?= $textLight ?>;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    border-bottom: 3px solid <?= $cardAccent ?>;
}
</style>
</head>
<body>
<div class="w-page">
    
    <div class="w-header">
        <div class="container">
            <a href="<?= url('customer_orders') ?>" class="text-decoration-none text-muted mb-2 d-inline-block" style="font-size:0.9rem;">
                <i class="bi bi-arrow-left"></i> Back to Orders
            </a>
            <h1 class="w-header-title">My Digital Warranty Cards</h1>
            <p class="text-muted">Hover over a card to view your coverage details.</p>
        </div>
    </div>

    <div class="container">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success d-flex align-items-center mb-4 border-0 shadow-sm rounded-3">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div><?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger d-flex align-items-center mb-4 border-0 shadow-sm rounded-3">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                <div><?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
            </div>
        <?php endif; ?>

        <?php if (empty($warranties)): ?>
            <div class="text-center py-5">
                <i class="bi bi-shield-x display-1 mb-3 text-muted opacity-50"></i>
                <h3 class="fw-bold">No Warranty Cards Found</h3>
                <p class="text-muted">You do not have any active warranty cards at the moment.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($warranties as $index => $w): ?>
                    <div class="col-lg-6 mb-5">
                        <!-- THE 3D FLIP CARD -->
                        <div class="card-container">
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

                        <?php if (strtolower($w['status']) === 'active'): ?>
                            <div class="claim-btn-container">
                                <button class="btn-claim" data-bs-toggle="modal" data-bs-target="#claimModal<?= $w['id'] ?>">
                                    Claim Warranty
                                </button>
                            </div>
                        <?php endif; ?>

                        <!-- Claim Modal -->
                        <div class="modal fade" id="claimModal<?= $w['id'] ?>" tabindex="-1">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title fw-bold"><i class="bi bi-tools me-2"></i> Claim Warranty</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                              </div>
                              <form action="<?= url('submit_warranty_claim') ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateFileSize(this)">
                                  <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                  <div class="modal-body p-4">
                                      <input type="hidden" name="warranty_id" value="<?= $w['id'] ?>">
                                      <div class="mb-3">
                                          <label class="form-label fw-bold">Describe the Issue</label>
                                          <textarea name="description" class="form-control bg-light border-0" rows="3" required placeholder="E.g. stitching opened on the left sleeve..."></textarea>
                                      </div>
                                      <div class="mb-3">
                                          <label class="form-label fw-bold">Upload Image (Optional)</label>
                                          <input type="file" name="claim_image" class="form-control bg-light border-0" accept="image/*">
                                          <small class="text-danger d-none file-error">File size must be under 2MB.</small>
                                      </div>
                                  </div>
                                  <div class="modal-footer bg-light border-0" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                                      <button type="submit" class="btn btn-dark w-100 fw-bold py-2" style="border-radius: 50px;">Submit Request</button>
                                  </div>
                              </form>
                            </div>
                          </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($claims)): ?>
            <div class="mt-5">
                <h3 class="w-header-title mb-4">My Claims History</h3>
                <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead style="background: var(--co-header-bg);">
                                <tr>
                                    <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Claim ID</th>
                                    <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Warranty Code</th>
                                    <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Status</th>
                                    <th class="py-3 px-4 text-uppercase text-muted" style="font-size: 0.8rem; font-weight: 700;">Admin Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($claims as $c): ?>
                                    <tr>
                                        <td class="px-4 py-3 fw-bold">#<?= $c['id'] ?></td>
                                        <td class="px-4 py-3"><span class="badge bg-light text-dark border font-monospace"><?= htmlspecialchars($c['code']) ?></span></td>
                                        <td class="px-4 py-3">
                                            <?php 
                                                $bg = 'bg-warning text-dark';
                                                if($c['status']=='Approved') $bg='bg-success text-white';
                                                if($c['status']=='Rejected') $bg='bg-danger text-white';
                                            ?>
                                            <span class="badge rounded-pill <?= $bg ?> px-3 py-2"><?= $c['status'] ?></span>
                                        </td>
                                        <td class="px-4 py-3 text-muted text-sm">
                                            <?= empty($c['admin_notes']) ? '<em>Pending Review</em>' : htmlspecialchars($c['admin_notes']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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

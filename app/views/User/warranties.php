<?php
// Ensure global theme variables are ready
if (!isset($global_theme)) {
    if (isset($_COOKIE['site_theme'])) {
        $global_theme = $_COOKIE['site_theme'];
    } elseif (isset($_SESSION['user_theme'])) {
        $global_theme = $_SESSION['user_theme'];
    } else {
        $global_theme = 'theme-default';
    }
}
$theme = $global_theme;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Warranties | <?= APP_NAME ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="<?= BASE_URL ?>css/navbar.css">
<link rel="stylesheet" href="<?= BASE_URL ?>css/colors.css">
<link rel="stylesheet" href="<?= BASE_URL ?>css/footer.css">
<link href="<?= BASE_URL ?>/css/style.css" rel="stylesheet">
<link href="<?= BASE_URL ?>css/<?= htmlspecialchars($theme) ?>-frontend.css" rel="stylesheet">

<style>
/* ---- Keyframes ---- */
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-22px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes glowPulse {
    0%   { text-shadow: 0 0 10px rgba(202, 151, 69,0.3); }
    100% { text-shadow: 0 0 28px rgba(202, 151, 69,0.85), 0 0 50px rgba(202, 151, 69,0.3); }
}
.warranty-hero {
    background: linear-gradient(135deg, rgba(26,15,10,0.85) 0%, rgba(45,26,18,0.85) 100%),
                url('https://images.unsplash.com/photo-1593030761757-71fae45fa0e5?auto=format&fit=crop&q=80&w=1200') center/cover no-repeat;
    color: #fff;
    min-height: 220px;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    border-bottom: 2px solid var(--accent-bronze, #ca9745);
}
.warranty-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: radial-gradient(circle, rgba(202, 151, 69,0.2) 0%, transparent 60%);
    animation: glowPulse 4s infinite alternate;
    pointer-events: none;
}
.warranty-hero h1 {
    font-family: 'Playfair Display', serif !important;
    font-size: 3rem !important;
    font-weight: 900 !important;
    color: #fff !important;
    margin-bottom: 4px !important;
    animation: fadeInDown 0.8s ease 0.1s both !important;
}
.page-bg {
    background: <?= ($theme === 'theme-luxury')
        ? 'linear-gradient(to bottom, #111, #1a1a1a)'
        : 'linear-gradient(to bottom, #faf8f5, #f0ebe3)'
    ?> !important;
    min-height: 100vh;
}
</style>
</head>
<body>
<?php include('header.php'); ?>

<section class="warranty-hero">
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1>MY WARRANTIES</h1>
        <p style="color: rgba(255,255,255,0.8); font-size: 1.1rem;">Manage your active warranty coverage and claims</p>
    </div>
</section>

<div class="page-bg pb-5">
    <div class="container pt-5">
        
        <div class="mb-4">
            <a href="<?= url('customer_orders') ?>" class="btn btn-outline-light"><i class="bi bi-arrow-left me-2"></i> Back to Orders</a>
        </div>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success d-flex align-items-center mb-4 shadow-sm rounded-4 border-0">
                <i class="bi bi-check-circle-fill fs-3 me-3"></i>
                <div>
                    <strong class="d-block mb-1">Success!</strong>
                    <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger d-flex align-items-center mb-4 shadow-sm rounded-4 border-0">
                <i class="bi bi-exclamation-triangle-fill fs-3 me-3"></i>
                <div>
                    <strong class="d-block mb-1">Error</strong>
                    <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (empty($warranties)): ?>
            <div class="text-center py-5 card shadow-soft p-5 border-0">
                <i class="bi bi-shield-x display-1 mb-3 text-muted opacity-25"></i>
                <h3 class="fw-bold text-muted">No Warranty Cards</h3>
                <p class="text-muted">You do not have any active warranty cards at the moment.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($warranties as $index => $w): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-soft" style="border: 1px solid var(--border-color, rgba(202, 151, 69, 0.3)); border-radius: 12px; overflow: hidden; background: var(--bg-card, #fff);">
                            <div class="card-header" style="background: var(--accent-bronze, #ca9745); border-bottom: none;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-dark fw-bold"><i class="bi bi-shield-check me-2"></i> Warranty Card</h5>
                                    <?php 
                                        $statusClass = (strtolower($w['status']) === 'active') ? 'bg-success' : 'bg-danger';
                                    ?>
                                    <span class="badge <?= $statusClass ?> text-uppercase"><?= htmlspecialchars($w['status']) ?></span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-3" style="color: var(--text-primary); font-family: 'Playfair Display', serif;">Order #<?= htmlspecialchars($w['order_id']) ?></h4>
                                <div class="mb-3">
                                    <p class="mb-1 text-muted small text-uppercase fw-bold">Reference Code</p>
                                    <p class="mb-0 fw-bold" style="font-family: monospace; font-size: 1.1rem; color: var(--accent-bronze, #ca9745);"><?= htmlspecialchars($w['code']) ?></p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1 text-muted small text-uppercase fw-bold">Valid Until</p>
                                    <p class="mb-0 fw-bold" style="color: var(--text-main);"><?= date('M d, Y', strtotime($w['expires_at'])) ?></p>
                                </div>
                                <div class="mt-4 pt-3 border-top" style="border-color: var(--border-color, #eee) !important;">
                                    <p class="mb-0 small text-muted"><i class="bi bi-info-circle me-1"></i> <?= htmlspecialchars($w['terms']) ?></p>
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
                                <div class="card-footer bg-transparent border-0 pb-4 px-4">
                                    <?php if ($hasPendingClaim): ?>
                                        <button class="btn btn-secondary w-100 fw-bold py-2" disabled>
                                            <i class="bi bi-hourglass-split me-2"></i> Claim Pending Review
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-primary w-100 fw-bold py-2" data-bs-toggle="modal" data-bs-target="#claimModal<?= $w['id'] ?>">
                                            Claim Warranty
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Claim Modal -->
                    <div class="modal fade" id="claimModal<?= $w['id'] ?>" tabindex="-1">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="background: var(--bg-card, #fff); border: 1px solid var(--border-color, #ddd);">
                          <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold" style="color: var(--text-primary);"><i class="bi bi-tools me-2"></i> CLAIM WARRANTY</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <form action="<?= url('submit_warranty_claim') ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateFileSize(this)">
                              <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                              <div class="modal-body p-4">
                                  <input type="hidden" name="warranty_id" value="<?= $w['id'] ?>">
                                  <div class="mb-4">
                                      <label class="form-label fw-bold text-uppercase small" style="color: var(--text-secondary);">Describe the Issue</label>
                                      <textarea name="description" class="form-control" rows="4" required placeholder="E.g. stitching opened on the left sleeve..." style="resize: none; background: rgba(0,0,0,0.02); color: var(--text-main); border: 1px solid var(--border-color, #ddd);"></textarea>
                                  </div>
                                  <div class="mb-3">
                                      <label class="form-label fw-bold text-uppercase small" style="color: var(--text-secondary);">Upload Image (Optional)</label>
                                      <input type="file" name="claim_image" class="form-control" accept="image/*" style="background: rgba(0,0,0,0.02); color: var(--text-main); border: 1px solid var(--border-color, #ddd);">
                                      <small class="text-danger d-none file-error mt-2 fw-bold"><i class="bi bi-exclamation-circle me-1"></i> File size must be under 2MB.</small>
                                  </div>
                              </div>
                              <div class="modal-footer border-0 pt-0">
                                  <button type="submit" class="btn btn-primary w-100 fw-bold py-2"><i class="bi bi-send-check me-2"></i> Submit Request</button>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($claims)): ?>
            <div class="mt-5 pt-4">
                <div class="card border-0 shadow-soft" style="border-radius: 12px; background: var(--bg-card, #fff);">
                    <div class="card-header border-0 py-4" style="background: rgba(202, 151, 69, 0.1);">
                        <h3 class="mb-0 fw-bold" style="color: var(--text-primary);"><i class="bi bi-folder2-open me-2" style="color: var(--accent-bronze, #ca9745);"></i> Claim Summary</h3>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover align-middle mb-0" style="background: transparent;">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 text-uppercase small text-muted border-bottom" style="border-color: var(--border-color, #eee) !important;">Date</th>
                                    <th class="py-3 px-4 text-uppercase small text-muted border-bottom" style="border-color: var(--border-color, #eee) !important;">Activity / Issue</th>
                                    <th class="py-3 px-4 text-center text-uppercase small text-muted border-bottom" style="border-color: var(--border-color, #eee) !important;">Warranty Ref</th>
                                    <th class="py-3 px-4 text-center text-uppercase small text-muted border-bottom" style="border-color: var(--border-color, #eee) !important;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($claims as $c): ?>
                                    <tr>
                                        <td class="px-4 text-nowrap" style="color: var(--text-secondary); border-color: var(--border-color, #eee);"><?= date('m/d/Y', strtotime($c['created_at'])) ?></td>
                                        <td class="px-4" style="border-color: var(--border-color, #eee);">
                                            <div class="fw-bold" style="color: var(--text-main);">Claim Initiated (ID: #<?= $c['id'] ?>)</div>
                                            <div class="small mt-1" style="color: var(--text-secondary);"><?= htmlspecialchars($c['issue_description'] ?? 'No description provided.') ?></div>
                                            <?php if(!empty($c['admin_notes'])): ?>
                                                <div class="alert mt-2 py-2 px-3 mb-0 small border-start border-4" style="background: rgba(202, 151, 69, 0.1); color: var(--text-main); border-left-color: var(--accent-bronze, #ca9745) !important;">
                                                    <strong>Reply:</strong> <?= htmlspecialchars($c['admin_notes']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 text-center" style="border-color: var(--border-color, #eee);">
                                            <span class="badge py-2 px-3 fs-6" style="background: rgba(202, 151, 69, 0.15); color: var(--accent-bronze, #ca9745); font-family: monospace; border: 1px solid rgba(202, 151, 69, 0.3);"><?= htmlspecialchars($c['code']) ?></span>
                                        </td>
                                        <td class="px-4 text-center" style="border-color: var(--border-color, #eee);">
                                            <?php 
                                                $bg = 'bg-warning text-dark';
                                                if($c['status']=='Approved') $bg='bg-success text-white';
                                                if($c['status']=='Rejected') $bg='bg-danger text-white';
                                                if($c['status']=='Resolved') $bg='bg-primary text-white';
                                            ?>
                                            <span class="badge <?= $bg ?> px-3 py-2 rounded-pill"><?= strtoupper($c['status']) ?></span>
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

<?php include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function validateFileSize(form) {
    const fileInput = form.querySelector('input[type="file"]');
    const errorMsg = form.querySelector('.file-error');
    if (fileInput.files.length > 0) {
        const fileSize = fileInput.files[0].size / 1024 / 1024;
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

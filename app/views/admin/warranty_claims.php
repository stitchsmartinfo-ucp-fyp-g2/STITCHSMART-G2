<div class="admin-feature-hero p-4 p-md-5 mb-4 rounded-4 position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 opacity-10 pointer-events-none d-none d-lg-block" style="transform: translate(10%, -10%);">
        <i class="bi bi-envelope-exclamation text-warning" style="font-size: 15rem;"></i>
    </div>
    <div class="position-absolute bottom-0 start-0 opacity-5 pointer-events-none d-none d-lg-block" style="transform: translate(-20%, 30%);">
        <i class="bi bi-shield-check text-warning" style="font-size: 10rem;"></i>
    </div>
    <div class="position-relative z-1 text-center text-md-start">
        <div class="mb-3">
            <span class="badge rounded-pill px-3 py-2 mb-2" style="background: rgba(202, 151, 69, 0.25); color: #e8c547; border: 1px solid rgba(202,151,69,0.5); font-size: 0.78rem; letter-spacing: 1.5px; text-transform: uppercase; font-weight: 700;">
                <i class="bi bi-clock-history pe-1"></i> Claims Center
            </span>
        </div>
        <h2 class="mb-2 fw-bolder" style="font-size: 2.4rem; letter-spacing: -0.5px;">
            Warranty Management
            <span style="background: linear-gradient(135deg, #ca9745, #e8c547); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">& CLAIMS</span>
        </h2>
        <p class="mb-0 mt-2" style="max-width: 680px; font-size: 1.05rem; line-height: 1.5; opacity: 0.85;">Manage customer warranties, issue new digital warranty cards, and oversee active or resolved warranty claims.</p>
        <div class="mt-4 d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-md-start">
            <a href="<?= url('admin_warranties') ?>" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: rgba(202, 151, 69, 0.18); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.3)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.18)'; this.style.color='#ca9745';">
                <i class="bi bi-card-checklist fs-5"></i> Issued Warranties
            </a>
            <a href="<?= url('admin_warranty_claims') ?>" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(202, 151, 69, 0.6)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="bi bi-envelope-exclamation fs-5"></i> Pending Claims
            </a>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 border-start border-5 border-success shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2 text-success"></i>
        <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 border-start border-5 border-danger shadow-sm" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2 text-danger"></i>
        <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['csrf_error'])): ?>
    <div class="alert alert-warning alert-dismissible fade show border-0 border-start border-5 border-warning shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i>
        <?= $_SESSION['csrf_error']; unset($_SESSION['csrf_error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<style>
/* Dynamic text colors for modals based on active theme */
:root.theme-luxury .modal-title,
:root.theme-luxury .modal-header i {
    color: #fff !important;
}
:root.theme-luxury .modal-content .form-control,
:root.theme-luxury .modal-content .form-select {
    color: #fff !important;
}

:root.theme-default .modal-title,
:root.theme-default .modal-header i {
    color: #fff !important; /* Keep header text white because background is primary blue */
}
:root.theme-default .modal-content .form-control,
:root.theme-default .modal-content .form-select {
    color: #333 !important;
}
</style>

<div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
    <div class="card-header bg-white py-3" style="border-bottom: 1px solid #f0f0f0;">
        <h6 class="m-0 font-weight-bold text-primary">All Submitted Claims</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Claim #</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Code / Customer</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Issue Description</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Date</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($claims)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox display-4 text-muted d-block mb-3"></i>
                                <span class="text-muted">No warranty claims found.</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($claims as $c): ?>
                            <tr>
                                <td>
                                    <span class="text-sm font-weight-bold">#<?= $c['id'] ?></span>
                                </td>
                                <td>
                                    <span class="badge px-2 py-1 mb-1 font-monospace" style="background: rgba(255,255,255,0.1); color: #ca9745; border: 1px solid rgba(205, 154, 72, 0.4);"><i class="bi bi-shield-check me-1"></i><?= htmlspecialchars($c['code']) ?></span><br>
                                    <small class="text-muted fw-bold"><?= htmlspecialchars($c['customer_name'] ?? 'User ID: ' . $c['user_id']) ?></small>
                                </td>
                                <td>
                                    <p class="text-sm text-secondary mb-0" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($c['issue_description']) ?>">
                                        <?= htmlspecialchars($c['issue_description']) ?>
                                    </p>
                                    <?php if ($c['image_url']): ?>
                                        <a href="<?= rtrim(BASE_URL, '/') . '/' . ltrim($c['image_url'], '/') ?>" target="_blank" class="badge bg-info mt-1 text-decoration-none"><i class="bi bi-image me-1"></i>View Attachment</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                        $badge = 'bg-warning text-dark';
                                        if ($c['status'] == 'Approved') $badge = 'bg-success';
                                        if ($c['status'] == 'Rejected') $badge = 'bg-danger';
                                        if ($c['status'] == 'Resolved') $badge = 'bg-primary';
                                    ?>
                                    <span class="badge rounded-pill <?= $badge ?> px-3 py-2 text-xs shadow-sm"><?= $c['status'] ?></span>
                                </td>
                                <td>
                                    <span class="text-secondary text-xs font-weight-bold"><?= date('d M, Y', strtotime($c['created_at'])) ?></span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#updateClaimModal<?= $c['id'] ?>" style="border-radius: 20px; padding: 4px 15px;">
                                        Review
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Render Modals Outside the Table -->
<?php if (!empty($claims)): ?>
    <?php foreach ($claims as $c): ?>
        <!-- Update Modal -->
        <div class="modal fade" id="updateClaimModal<?= $c['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                    <div class="modal-header bg-primary text-white" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                        <h5 class="modal-title fw-bold">Review Claim #<?= $c['id'] ?></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="<?= url('admin_update_claim') ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        <input type="hidden" name="claim_id" value="<?= $c['id'] ?>">
                        <div class="modal-body p-4">
                            
                            <div class="alert mb-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                                <strong class="d-block mb-1" style="color: #ca9745;">Customer's Issue:</strong>
                                <span class="text-sm" style="color: #eee;"><?= nl2br(htmlspecialchars($c['issue_description'])) ?></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-secondary text-xs text-uppercase">Claim Status</label>
                                <select id="status_<?= $c['id'] ?>" name="status" class="form-select form-control-solid border-0 shadow-none" required>
                                    <option value="Pending" <?= $c['status'] == 'Pending' ? 'selected' : '' ?>>⏳ Pending</option>
                                    <option value="Approved" <?= $c['status'] == 'Approved' ? 'selected' : '' ?>>✅ Approved</option>
                                    <option value="Rejected" <?= $c['status'] == 'Rejected' ? 'selected' : '' ?>>❌ Rejected</option>
                                    <option value="Resolved" <?= $c['status'] == 'Resolved' ? 'selected' : '' ?>>🎉 Resolved</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label fw-bold text-secondary text-xs text-uppercase mb-0">Admin Notes / Response</label>
                                    <button type="button" class="btn btn-outline-primary btn-sm mb-0 px-3 py-1 ai-generate-btn" data-target="admin_notes_<?= $c['id'] ?>" data-status="status_<?= $c['id'] ?>" style="border-radius: 20px; font-size: 0.75rem;">
                                        <i class="bi bi-magic me-1"></i> Generate with AI
                                    </button>
                                </div>
                                <textarea id="admin_notes_<?= $c['id'] ?>" name="admin_notes" class="form-control" rows="3" placeholder="This response will be visible to the customer..."><?= htmlspecialchars($c['admin_notes'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 50px; padding: 6px 20px;">Close</button>
                            <button type="submit" class="btn btn-primary" style="border-radius: 50px; padding: 6px 20px;"><i class="bi bi-save me-1"></i> Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script>
document.querySelectorAll('.ai-generate-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const statusId = this.getAttribute('data-status');
        const box = document.getElementById(targetId);
        const status = document.getElementById(statusId).value;
        
        let template = "";
        if (status === "Pending") {
            template = "Dear customer, your warranty claim has been received and is currently under review by our technical team. We will get back to you with an update shortly.";
        } else if (status === "Approved") {
            template = "Good news! Your warranty claim has been reviewed and approved. Please follow the instructions sent to your email to proceed with the repair or replacement.";
        } else if (status === "Rejected") {
            template = "We have carefully reviewed your claim. Unfortunately, the issue described does not fall under our warranty coverage terms. Please contact support for alternative repair options.";
        } else if (status === "Resolved") {
            template = "Your warranty claim has been successfully resolved. We hope you are satisfied with the outcome. Thank you for choosing Stitch Smart!";
        }
        
        box.value = "";
        let i = 0;
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Generating...';
        this.disabled = true;
        
        const interval = setInterval(() => {
            box.value += template.charAt(i);
            i++;
            if (i >= template.length) {
                clearInterval(interval);
                this.innerHTML = '<i class="bi bi-check-circle me-1"></i> Generated';
                this.classList.replace('btn-outline-primary', 'btn-success');
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.replace('btn-success', 'btn-outline-primary');
                    this.disabled = false;
                }, 2000);
            }
        }, 15);
    });
});
</script>

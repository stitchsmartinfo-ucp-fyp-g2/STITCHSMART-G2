<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-2 text-gray-800 fw-bold" style="font-family: 'Playfair Display', serif;">Warranty Management</h1>
        <ul class="nav nav-pills border-0">
            <li class="nav-item">
                <a class="nav-link rounded-pill px-4 text-muted" href="<?= url('admin_warranties') ?>">Issued Warranties</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active rounded-pill px-4 shadow-sm" href="<?= url('admin_warranty_claims') ?>">Pending Claims</a>
            </li>
        </ul>
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
                                    <span class="badge bg-light text-dark border px-2 py-1 mb-1 font-monospace"><i class="bi bi-shield-check me-1"></i><?= htmlspecialchars($c['code']) ?></span><br>
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
                            
                            <div class="alert alert-light border mb-4">
                                <strong class="d-block mb-1 text-dark">Customer's Issue:</strong>
                                <span class="text-muted text-sm"><?= nl2br(htmlspecialchars($c['issue_description'])) ?></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-secondary text-xs text-uppercase">Claim Status</label>
                                <select name="status" class="form-select form-control-solid bg-light border-0 shadow-none">
                                    <option value="Pending" <?= $c['status'] == 'Pending' ? 'selected' : '' ?>>⏳ Pending</option>
                                    <option value="Approved" <?= $c['status'] == 'Approved' ? 'selected' : '' ?>>✅ Approved</option>
                                    <option value="Rejected" <?= $c['status'] == 'Rejected' ? 'selected' : '' ?>>❌ Rejected</option>
                                    <option value="Resolved" <?= $c['status'] == 'Resolved' ? 'selected' : '' ?>>🎉 Resolved</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-secondary text-xs text-uppercase">Admin Notes / Response</label>
                                <textarea name="admin_notes" class="form-control bg-light" rows="3" placeholder="This response will be visible to the customer..."><?= htmlspecialchars($c['admin_notes'] ?? '') ?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-light" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 50px; padding: 6px 20px;">Close</button>
                            <button type="submit" class="btn btn-primary" style="border-radius: 50px; padding: 6px 20px;"><i class="bi bi-save me-1"></i> Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

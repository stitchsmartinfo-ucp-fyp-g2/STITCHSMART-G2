<!-- Luxury Executive Header Card -->
<div class="admin-header-card p-4 p-md-5 mb-4 rounded-4 position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 p-5 opacity-10 pointer-events-none d-none d-lg-block" style="transform: translate(15%, -15%);">
        <i class="bi bi-arrow-return-left text-warning" style="font-size: 15rem;"></i>
    </div>
    <div class="position-relative z-1 text-center text-md-start">
        <div>
            <h2 class="mb-2 fw-bolder" style="font-size: 2.4rem; letter-spacing: -0.5px;">Return Requests Pipeline</h2>
            <p class="mb-0 mt-2" style="max-width: 680px; font-size: 1.05rem; line-height: 1.5;">Manage client return requests, perform rigorous inspection of bespoke garments, authorize inventory restocking for pristine items, or log damaged articles into the quarantined trash archive.</p>
        </div>
        <div class="mt-4 d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-md-start">
            <a href="<?= url('manage_orders') ?>" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(202, 151, 69, 0.6)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="bi bi-clipboard-check-fill fs-5"></i> Manage Orders
            </a>
            <a href="<?= url('return_trash') ?>" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: rgba(220, 53, 69, 0.25); color: #ff6b6b; border: 1px solid rgba(220, 53, 69, 0.6); font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(220, 53, 69, 0.4)'; this.style.color='#fff';" onmouseout="this.style.background='rgba(220, 53, 69, 0.25)'; this.style.color='#ff6b6b';">
                <i class="bi bi-trash3-fill fs-5"></i> Quarantined Trash Archive
            </a>
            <a href="<?= url('sales_report') ?>" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: rgba(202, 151, 69, 0.18); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;">
                <i class="bi bi-graph-up fs-5"></i> Financial Sales Report
            </a>
        </div>
    </div>
</div>

<div class="container-fluid mb-5">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success rounded-4 border-0 p-3 shadow-sm mb-4 d-flex align-items-center gap-2" style="background: rgba(25, 135, 84, 0.18); color: #51cf66; border: 1px solid rgba(25,135,84,0.4) !important;">
            <i class="bi bi-check-circle-fill fs-4"></i>
            <div><strong>Success:</strong> <?= htmlspecialchars($_SESSION['success']) ?></div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger rounded-4 border-0 p-3 shadow-sm mb-4 d-flex align-items-center gap-2" style="background: rgba(220, 53, 69, 0.18); color: #ff8787; border: 1px solid rgba(220,53,69,0.4) !important;">
            <i class="bi bi-exclamation-triangle-fill fs-4"></i>
            <div><strong>Error:</strong> <?= htmlspecialchars($_SESSION['error']) ?></div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php
    $pendingCount = 0; $restockedCount = 0; $trashedCount = 0;
    if (!empty($returns)) {
        foreach ($returns as $r) {
            if ($r['status'] === 'pending') $pendingCount++;
            elseif ($r['status'] === 'restocked') $restockedCount++;
            elseif ($r['status'] === 'trashed') $trashedCount++;
        }
    }
    ?>

    <!-- Summary Stat Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="p-4 rounded-4 shadow-sm border h-100 d-flex justify-content-between align-items-center" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border-color: rgba(202, 151, 69, 0.4) !important;">
                <div>
                    <span class="text-uppercase small fw-bolder" style="color: #1a0f0a; letter-spacing: 1px;">Pending Inspection</span>
                    <h2 class="display-5 fw-bolder mb-0 mt-1" style="color: #ca9745; filter: drop-shadow(0 2px 4px rgba(202,151,69,0.2));"><?= (int)$pendingCount ?></h2>
                    <div class="small fw-semibold mt-2" style="color: #4a3b2c;">Awaiting QC decision</div>
                </div>
                <div class="p-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="background: rgba(202, 151, 69, 0.15); width: 60px; height: 60px;">
                    <i class="bi bi-hourglass-split fs-3" style="color: #ca9745;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded-4 shadow-sm border h-100 d-flex justify-content-between align-items-center" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border-color: rgba(25, 135, 84, 0.3) !important;">
                <div>
                    <span class="text-uppercase small fw-bolder" style="color: #1a0f0a; letter-spacing: 1px;">Restocked to Showroom</span>
                    <h2 class="display-5 fw-bolder mb-0 mt-1" style="color: #198754; filter: drop-shadow(0 2px 4px rgba(25,135,84,0.2));"><?= (int)$restockedCount ?></h2>
                    <div class="small fw-semibold mt-2" style="color: #4a3b2c;">Pristine condition items returned to inventory</div>
                </div>
                <div class="p-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="background: rgba(25, 135, 84, 0.15); width: 60px; height: 60px;">
                    <i class="bi bi-box-seam-fill fs-3" style="color: #198754;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded-4 shadow-sm border h-100 d-flex justify-content-between align-items-center" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border-color: rgba(220, 53, 69, 0.3) !important;">
                <div>
                    <span class="text-uppercase small fw-bolder" style="color: #1a0f0a; letter-spacing: 1px;">Quarantined Trashed Items</span>
                    <h2 class="display-5 fw-bolder mb-0 mt-1" style="color: #dc3545; filter: drop-shadow(0 2px 4px rgba(220,53,69,0.2));"><?= (int)$trashedCount ?></h2>
                    <div class="small fw-semibold mt-2" style="color: #4a3b2c;">Logged in damaged inspection archive</div>
                </div>
                <div class="p-3 rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="background: rgba(220, 53, 69, 0.15); width: 60px; height: 60px;">
                    <i class="bi bi-trash3-fill fs-3" style="color: #dc3545;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Returns Table Card -->
    <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
        <div class="card-header py-4 px-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h4 class="mb-0 fw-bold d-flex align-items-center gap-2">
                <i class="bi bi-list-check text-warning"></i> Return Inspection Ledger
            </h4>
            <span class="badge rounded-pill px-3 py-2" style="background: rgba(202, 151, 69, 0.2); color: #ca9745;">QC Protocol Active</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: rgba(0,0,0,0.15);">
                    <tr>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3">Order Details</th>
                        <th class="py-3">Customer Name</th>
                        <th class="py-3">Garment Product</th>
                        <th class="py-3 text-center">Qty</th>
                        <th class="py-3">Return Status</th>
                        <th class="py-3">Damage / Inspection Note</th>
                        <th class="py-3">Logged Date</th>
                        <th class="py-3 text-end px-4">QC Authorization</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($returns)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-check2-all fs-1 d-block mb-2 text-success"></i>
                                No return requests logged. All customer deliveries are satisfied!
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($returns as $return): ?>
                            <tr>
                                <td class="px-4 fw-bold text-muted">#<?= (int)$return['id'] ?></td>
                                <td>
                                    <span class="badge bg-dark border px-3 py-2 rounded-pill fs-6">Order #<?= (int)$return['order_id'] ?></span>
                                    <div class="small text-muted mt-1">(<?= htmlspecialchars($return['order_status'] ?? 'Completed') ?>)</div>
                                </td>
                                <td class="fw-bold fs-6"><?= htmlspecialchars($return['customer_name'] ?? 'Guest Client') ?></td>
                                <td>
                                    <div class="fw-bold" style="color: #ca9745;"><?= htmlspecialchars($return['product_name'] ?? 'Unknown Garment') ?></div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill px-3 py-1"><?= (int)$return['quantity'] ?></span>
                                </td>
                                <td>
                                    <?php if ($return['status'] === 'pending'): ?>
                                        <span class="badge rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1" style="background: rgba(255, 193, 7, 0.25); color: #ffc107; border: 1px solid rgba(255,193,7,0.5);">
                                            <i class="bi bi-clock-history"></i> Pending QC
                                        </span>
                                    <?php elseif ($return['status'] === 'restocked'): ?>
                                        <span class="badge rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1" style="background: rgba(25, 135, 84, 0.25); color: #51cf66; border: 1px solid rgba(25,135,84,0.5);">
                                            <i class="bi bi-check-circle-fill"></i> Restocked
                                        </span>
                                    <?php elseif ($return['status'] === 'trashed'): ?>
                                        <span class="badge rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1" style="background: rgba(220, 53, 69, 0.25); color: #ff8787; border: 1px solid rgba(220,53,69,0.5);">
                                            <i class="bi bi-trash-fill"></i> Quarantined
                                        </span>
                                    <?php elseif ($return['status'] === 'rejected'): ?>
                                        <span class="badge rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 bg-secondary text-white">
                                            <i class="bi bi-x-circle-fill"></i> Rejected
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-info"><?= htmlspecialchars($return['status']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td style="max-width: 250px;">
                                    <?php if(!empty($return['damage_note'])): ?>
                                        <div class="p-2 rounded-3 small" style="background: rgba(0,0,0,0.15); font-style: italic;">
                                            "<?= nl2br(htmlspecialchars($return['damage_note'])) ?>"
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">— No notes provided —</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-muted"><?= htmlspecialchars($return['created_at']) ?></td>
                                <td class="text-end px-4">
                                    <?php if ($return['status'] === 'pending'): ?>
                                        <div class="d-flex justify-content-end gap-2 flex-wrap">
                                            <a href="<?= url('update_return_status?id=' . $return['id'] . '&action=restock') ?>" class="btn btn-sm px-3 py-2 rounded-pill shadow-sm d-inline-flex align-items-center gap-1" style="background: linear-gradient(135deg, #198754, #20c997); color: #fff; font-weight: 700; border: none;" onclick="return confirm('Authorize restocking of this pristine item back into live showroom inventory?');" title="Approve & Restock">
                                                <i class="bi bi-box-arrow-in-down"></i> Restock
                                            </a>
                                            <a href="<?= url('update_return_status?id=' . $return['id'] . '&action=trash') ?>" class="btn btn-sm px-3 py-2 rounded-pill shadow-sm d-inline-flex align-items-center gap-1" style="background: rgba(255, 193, 7, 0.25); color: #ffc107; font-weight: 700; border: 1px solid rgba(255,193,7,0.6);" onclick="return confirm('Log this item into the quarantined trash archive due to fabric/garment damage?');" title="Quarantine & Trash">
                                                <i class="bi bi-trash"></i> Trash
                                            </a>
                                            <a href="<?= url('update_return_status?id=' . $return['id'] . '&action=reject') ?>" class="btn btn-sm px-3 py-2 rounded-pill shadow-sm d-inline-flex align-items-center gap-1" style="background: rgba(220, 53, 69, 0.25); color: #ff8787; font-weight: 700; border: 1px solid rgba(220,53,69,0.6);" onclick="return confirm('REJECT this return request and notify the client?');" title="Reject Request">
                                                <i class="bi bi-x-lg"></i> Reject
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill text-muted"><i class="bi bi-lock-fill"></i> Processed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

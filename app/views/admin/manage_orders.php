

<!-- Luxury Executive Hero Card -->
<div class="admin-feature-hero p-4 p-md-5 mb-4 rounded-4 position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 opacity-10 pointer-events-none d-none d-lg-block" style="transform: translate(10%, -10%);">
        <i class="bi bi-cart-check-fill text-warning" style="font-size: 15rem;"></i>
    </div>
    <div class="position-absolute bottom-0 start-0 opacity-5 pointer-events-none d-none d-lg-block" style="transform: translate(-20%, 30%);">
        <i class="bi bi-truck text-warning" style="font-size: 10rem;"></i>
    </div>
    <div class="position-relative z-1 text-center text-md-start">
        <div class="mb-3">
            <span class="badge rounded-pill px-3 py-2 mb-2" style="background: rgba(202, 151, 69, 0.25); color: #e8c547; border: 1px solid rgba(202,151,69,0.5); font-size: 0.78rem; letter-spacing: 1.5px; text-transform: uppercase; font-weight: 700;">
                <i class="bi bi-lightning-charge-fill pe-1"></i> Live Order Management
            </span>
        </div>
        <h2 class="mb-2 fw-bolder" style="font-size: 2.4rem; letter-spacing: -0.5px;">
            Customer Orders
            <span style="background: linear-gradient(135deg, #ca9745, #e8c547); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">&amp; FULFILLMENT</span>
        </h2>
        <p class="mb-0 mt-2" style="max-width: 680px; font-size: 1.05rem; line-height: 1.5; opacity: 0.85;">Review incoming orders, process shipments, track delivery progress, and manage fulfillment status across all customer purchases in real time.</p>
        <div class="mt-4 d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-md-start">
            <a href="<?= url('admin_products') ?>" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(202, 151, 69, 0.6)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="bi bi-box-seam-fill fs-5"></i> Products Catalog
            </a>
            <a href="<?= url('dashbaord') ?>" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: rgba(202, 151, 69, 0.18); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.3)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.18)'; this.style.color='#ca9745';">
                <i class="bi bi-speedometer2 fs-5"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Orders Table Card -->
<div class="row mt-2">
    <div class="col-12">
        <div class="card p-4 rounded-4 shadow-sm">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                <div>
                    <h4 class="mb-1 fw-bold"><i class="bi bi-receipt-cutoff text-warning pe-2"></i>All Customer Orders</h4>
                    <p class="mb-0 text-muted small">Track and manage every order from placement through delivery and completion.</p>
                </div>
                <span class="badge rounded-pill px-3 py-2" style="background: rgba(202, 151, 69, 0.15); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-size: 0.85rem; font-weight: 700;">
                    Total Orders: <?= count($orders) ?>
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover text-center align-middle mb-0">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(202, 151, 69, 0.4); font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; color: #ca9745;">
                            <th class="py-3">Order ID</th>
                            <th class="py-3">Customer</th>
                            <th class="py-3">Phone</th>
                            <th class="py-3">Total</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach($orders as $index => $order): ?>
                    <?php
                        $currentStatus = trim($order['status'] ?? 'Pending');
                        $isDelivered = strcasecmp($currentStatus, 'Delivered') === 0;
                        $isCancelled = strcasecmp($currentStatus, 'Cancelled') === 0;

                        $statusStyle = match(true) {
                            strcasecmp($currentStatus, 'Pending') === 0        => ['bg' => 'rgba(255,193,7,0.15)',  'color' => '#ffc107',  'icon' => 'bi-clock-history'],
                            strcasecmp($currentStatus, 'Processing') === 0     => ['bg' => 'rgba(13,110,253,0.15)', 'color' => '#4d91ff',  'icon' => 'bi-gear-fill'],
                            strcasecmp($currentStatus, 'Dispatched') === 0     => ['bg' => 'rgba(111,66,193,0.15)','color' => '#9b59b6',  'icon' => 'bi-send-fill'],
                            strcasecmp($currentStatus, 'In Transit') === 0     => ['bg' => 'rgba(13,202,240,0.15)','color' => '#0dcaf0',  'icon' => 'bi-truck'],
                            strcasecmp($currentStatus, 'Out for Delivery') === 0 => ['bg' => 'rgba(255,128,0,0.15)', 'color' => '#ff8c00', 'icon' => 'bi-scooter'],
                            strcasecmp($currentStatus, 'Delivered') === 0      => ['bg' => 'rgba(25,135,84,0.15)', 'color' => '#198754',  'icon' => 'bi-check-circle-fill'],
                            strcasecmp($currentStatus, 'Cancelled') === 0      => ['bg' => 'rgba(220,53,69,0.15)', 'color' => '#dc3545',  'icon' => 'bi-x-circle-fill'],
                            default                                             => ['bg' => 'rgba(150,150,150,0.15)', 'color' => '#888',   'icon' => 'bi-question-circle'],
                        };
                    ?>
                        <tr style="border-bottom: 1px solid rgba(202,151,69,0.1); animation: adminFadeInDown <?= 0.3 + ($index * 0.05) ?>s ease both;">
                            <td class="fw-bold py-3" style="color: #ca9745;">#<?= htmlspecialchars($order['id']) ?></td>
                            <td class="fw-bold py-3"><?= htmlspecialchars($order['customer_name']) ?></td>
                            <td class="py-3">
                                <span class="px-3 py-1 rounded-pill" style="background: rgba(150,150,150,0.1); border: 1px solid rgba(150,150,150,0.25); font-family: monospace; font-size: 0.88rem;">
                                    <?= htmlspecialchars($order['phone']) ?>
                                </span>
                            </td>
                            <td class="fw-bold py-3" style="color: #ca9745; font-size: 1.05rem;">
                                Rs. <?= number_format($order['total']) ?>
                            </td>
                            <td class="py-3">
                                <span class="badge px-3 py-2 rounded-pill" style="background: <?= $statusStyle['bg'] ?>; color: <?= $statusStyle['color'] ?>; border: 1px solid <?= $statusStyle['color'] ?>40; font-weight: 700; letter-spacing: 0.5px;">
                                    <i class="bi <?= $statusStyle['icon'] ?> pe-1"></i><?= htmlspecialchars($currentStatus) ?>
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="d-flex flex-column align-items-center gap-2">

                                <?php if(!$isDelivered && !$isCancelled): ?>

                                    <?php if($currentStatus === 'Pending'): ?>
                                        <a href="<?= url('mark_processing?id=' . $order['id']) ?>" class="btn btn-sm rounded-pill px-3 fw-bold" style="background: rgba(255,193,7,0.15); color: #ffc107; border: 1px solid rgba(255,193,7,0.4); white-space: nowrap;">
                                            <i class="bi bi-gear pe-1"></i>Mark Processing
                                        </a>

                                    <?php elseif($currentStatus === 'Processing'): ?>
                                        <?php if(empty($order['tracking_id'])): ?>
                                            <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold toggle-dispatch" data-order-id="<?= $order['id'] ?>" style="background: rgba(13,110,253,0.15); color: #4d91ff; border: 1px solid rgba(13,110,253,0.4); white-space: nowrap;">
                                                <i class="bi bi-send pe-1"></i>Dispatch
                                            </button>
                                        <?php endif; ?>

                                    <?php elseif($currentStatus === 'Dispatched'): ?>
                                        <a href="<?= url('mark_in_transit?id=' . $order['id']) ?>" class="btn btn-sm rounded-pill px-3 fw-bold" style="background: rgba(13,202,240,0.15); color: #0dcaf0; border: 1px solid rgba(13,202,240,0.4); white-space: nowrap;">
                                            <i class="bi bi-truck pe-1"></i>Mark In Transit
                                        </a>

                                    <?php elseif($currentStatus === 'In Transit'): ?>
                                        <a href="<?= url('mark_out_for_delivery?id=' . $order['id']) ?>" class="btn btn-sm rounded-pill px-3 fw-bold" style="background: rgba(255,128,0,0.15); color: #ff8c00; border: 1px solid rgba(255,128,0,0.4); white-space: nowrap;">
                                            <i class="bi bi-scooter pe-1"></i>Out for Delivery
                                        </a>

                                    <?php elseif($currentStatus === 'Out for Delivery'): ?>
                                        <a href="<?= url('mark_delivered?id=' . $order['id']) ?>" class="btn btn-sm rounded-pill px-3 fw-bold" style="background: rgba(25,135,84,0.15); color: #198754; border: 1px solid rgba(25,135,84,0.4); white-space: nowrap;">
                                            <i class="bi bi-check-circle pe-1"></i>Mark Delivered
                                        </a>

                                    <?php else: ?>
                                        <a href="<?= url('mark_processing?id=' . $order['id']) ?>" class="btn btn-sm rounded-pill px-3 fw-bold" style="background: rgba(255,193,7,0.15); color: #ffc107; border: 1px solid rgba(255,193,7,0.4); white-space: nowrap;">
                                            <i class="bi bi-arrow-clockwise pe-1"></i>Reset
                                        </a>
                                    <?php endif; ?>

                                    <?php if($currentStatus === 'Processing' || !empty($order['tracking_id'])): ?>
                                        <?php if(!empty($order['tracking_id'])): ?>
                                            <span class="badge rounded-pill px-3" style="background: rgba(13,202,240,0.15); color: #0dcaf0; border: 1px solid rgba(13,202,240,0.4); font-size: 0.78rem;">
                                                <i class="bi bi-tag pe-1"></i><?= htmlspecialchars($order['tracking_id']) ?>
                                            </span>
                                            <button type="button" class="btn btn-sm rounded-pill px-3 fw-bold toggle-dispatch" data-order-id="<?= $order['id'] ?>" style="background: rgba(13,110,253,0.1); color: #4d91ff; border: 1px solid rgba(13,110,253,0.3); white-space: nowrap; font-size: 0.82rem;">
                                                <i class="bi bi-pencil pe-1"></i>Update Tracking
                                            </button>
                                        <?php endif; ?>
                                        <div class="dispatch-form d-none w-100" id="dispatch-form-<?= $order['id'] ?>">
                                            <form action="<?= url('save_tracking') ?>" method="post" class="d-flex flex-column gap-2">
                                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                                                <input type="text" name="tracking_id" class="form-control form-control-sm rounded-pill px-3" placeholder="Enter tracking ID" value="<?= htmlspecialchars($order['tracking_id'] ?? '') ?>" required style="border: 1px solid rgba(202,151,69,0.4); font-size: 0.85rem;">
                                                <button type="submit" class="btn btn-sm rounded-pill fw-bold w-100" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none;">
                                                    <i class="bi bi-check-lg pe-1"></i>Save &amp; Dispatch
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>

                                    <a href="<?= url('mark_cancelled?id=' . $order['id']) ?>" class="btn btn-sm rounded-pill px-3 fw-bold" style="background: rgba(220,53,69,0.12); color: #dc3545; border: 1px solid rgba(220,53,69,0.3); white-space: nowrap;" onclick="return confirm('Cancel this order? This cannot be undone.')">
                                        <i class="bi bi-x-circle pe-1"></i>Cancel Order
                                    </a>

                                <?php endif; ?>

                                <?php if($isDelivered || $isCancelled): ?>
                                    <span class="text-muted small"><i class="bi bi-check2-all pe-1"></i>Processed</span>
                                    <a href="<?= url('delete_order?id=' . $order['id']) ?>" class="btn btn-sm rounded-pill px-3 fw-bold" style="background: rgba(220,53,69,0.1); color: #dc3545; border: 1px solid rgba(220,53,69,0.3); white-space: nowrap;" onclick="return confirm('Permanently delete this order from records?')">
                                        <i class="bi bi-trash3 pe-1"></i>Delete Record
                                    </a>
                                <?php endif; ?>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if(empty($orders)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <p style="font-size: 3.5rem; margin-bottom: 15px; filter: drop-shadow(0 4px 10px rgba(202,151,69,0.4));">📦</p>
                                    <h5 class="fw-bold">No Orders Yet</h5>
                                    <p class="text-muted mb-0" style="max-width: 450px; margin: 0 auto;">Customer orders will appear here once purchases are made on your storefront.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-dispatch').forEach(function(button) {
            button.addEventListener('click', function() {
                var orderId = this.getAttribute('data-order-id');
                var form = document.getElementById('dispatch-form-' + orderId);
                if (form) {
                    form.classList.toggle('d-none');
                }
            });
        });
    });
</script>

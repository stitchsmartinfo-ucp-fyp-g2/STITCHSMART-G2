<!-- Luxury Executive Hero Card -->
<div class="admin-feature-hero p-4 p-md-5 mb-4 rounded-4 position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 opacity-10 pointer-events-none d-none d-lg-block" style="transform: translate(10%, -10%);">
        <i class="bi bi-box-seam-fill text-warning" style="font-size: 15rem;"></i>
    </div>
    <div class="position-absolute bottom-0 start-0 opacity-5 pointer-events-none d-none d-lg-block" style="transform: translate(-20%, 30%);">
        <i class="bi bi-grid-fill text-warning" style="font-size: 10rem;"></i>
    </div>
    <div class="position-relative z-1 text-center text-md-start">
        <div class="mb-3">
            <span class="badge rounded-pill px-3 py-2 mb-2" style="background: rgba(202, 151, 69, 0.25); color: #e8c547; border: 1px solid rgba(202,151,69,0.5); font-size: 0.78rem; letter-spacing: 1.5px; text-transform: uppercase; font-weight: 700;">
                <i class="bi bi-lightning-charge-fill pe-1"></i> Live Inventory
            </span>
        </div>
        <h2 class="mb-2 fw-bolder" style="font-size: 2.4rem; letter-spacing: -0.5px;">
            Products Inventory
            <span style="background: linear-gradient(135deg, #ca9745, #e8c547); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">& CATALOG</span>
        </h2>
        <p class="mb-0 mt-2" style="max-width: 680px; font-size: 1.05rem; line-height: 1.5; opacity: 0.85;">Manage your catalog, add new luxury tailoring items, adjust pricing, and oversee stock levels across all categories.</p>
        <div class="mt-4 d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-md-start">
            <a href="<?= url('') ?>add_product" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(202, 151, 69, 0.6)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="bi bi-plus-circle-fill fs-5"></i> + Add New Product
            </a>
            <a href="<?= url('') ?>admin_feature_products" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: rgba(202, 151, 69, 0.18); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.3)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.18)'; this.style.color='#ca9745';">
                <i class="bi bi-star-fill fs-5"></i> Featured Products
            </a>
            <a href="<?= url('') ?>admin_sale_products" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: rgba(202, 151, 69, 0.18); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.3)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.18)'; this.style.color='#ca9745';">
                <i class="bi bi-tag-fill fs-5"></i> Sale Products
            </a>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert border-0 rounded-3 mb-4" role="alert" style="background: rgba(205, 154, 72, 0.15); color: #ca9745; border-left: 4px solid #ca9745 !important;">
        <?= htmlspecialchars($_SESSION['flash']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<div class="row mt-2">
    <div class="col-12">
        <div class="card p-4 rounded-4 shadow-sm">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                <div>
                    <h4 class="mb-1 fw-bold"><i class="bi bi-grid-3x3-gap-fill text-warning pe-2"></i>All Products</h4>
                    <p class="mb-0 text-muted small">Browse, edit, or remove garments from your full product catalog.</p>
                </div>
                <span class="badge rounded-pill px-3 py-2" style="background: rgba(202, 151, 69, 0.15); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-size: 0.85rem; font-weight: 700;">
                    Total Products: <?= count($products) ?>
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover text-center align-middle mb-0">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(202, 151, 69, 0.4); font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; color: #ca9745;">
                            <th class="py-3">PID</th>
                            <th class="py-3">Image</th>
                            <th class="py-3" style="white-space: nowrap;">Article No.</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">QTY</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $index => $prod): ?>
                            <tr style="border-bottom: 1px solid rgba(202,151,69,0.1); animation: adminFadeInDown <?= 0.3 + ($index * 0.04) ?>s ease both;">
                                <td class="fw-bold py-3" style="color: #ca9745;">#<?= htmlspecialchars($prod['id']) ?></td>
                                <td class="py-3">
                                    <?php $productImage = strtok($prod['image_url'], ','); ?>
                                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($productImage)) ?>" alt="Product" class="rounded-3 shadow-sm" style="width: 70px; height: 70px; object-fit: cover; border: 2px solid rgba(202, 151, 69, 0.5);">
                                </td>
                                <td class="fw-bold py-3">
                                    <span class="px-3 py-1 rounded-pill" style="background: rgba(150,150,150,0.1); border: 1px solid rgba(150,150,150,0.25); font-family: monospace; font-size: 0.88rem;">
                                        <?= htmlspecialchars($prod['article_number']) ?>
                                    </span>
                                </td>
                                <td class="fw-bold py-3"><?= htmlspecialchars($prod['name']) ?></td>
                                <td class="py-3">
                                    <span class="badge rounded-pill px-3 py-2" style="<?= $prod['quantity'] > 10 ? 'background: rgba(25,135,84,0.15); color: #198754; border: 1px solid rgba(25,135,84,0.4);' : ($prod['quantity'] > 0 ? 'background: rgba(255,193,7,0.15); color: #ffc107; border: 1px solid rgba(255,193,7,0.4);' : 'background: rgba(220,53,69,0.15); color: #dc3545; border: 1px solid rgba(220,53,69,0.4);') ?> font-weight: 700;">
                                        <?= htmlspecialchars($prod['quantity']) ?>
                                    </span>
                                </td>
                                <td class="py-3">
                                    <?php 
                                    $isFeatured = (int) ($prod['featured'] ?? 0) === 1;
                                    $isOnSale = (int) ($prod['sale_discount_percent'] ?? 0) > 0;
                                    ?>
                                    <?php if ($isFeatured): ?>
                                        <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; font-weight: 800; letter-spacing: 0.5px;">🌟 Featured</span>
                                    <?php elseif ($isOnSale): ?>
                                        <span class="badge rounded-pill px-3 py-2" style="background: rgba(220,53,69,0.15); color: #dc3545; border: 1px solid rgba(220,53,69,0.4); font-weight: 700;">🏷️ On Sale</span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill px-3 py-2" style="background: rgba(150,150,150,0.12); color: #888; border: 1px solid rgba(150,150,150,0.25); font-weight: 600;">Standard</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="<?= url('edit_product?id=' . $prod['id']) ?>" 
                                           class="btn btn-sm rounded-pill px-3 fw-bold" style="background: rgba(202, 151, 69, 0.2); color: #9c6d23; border: 1px solid rgba(202, 151, 69, 0.6); transition: all 0.2s ease;" onmouseover="this.style.background='rgba(202, 151, 69, 0.35)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.2)'; this.style.color='#9c6d23';">
                                           <i class="bi bi-pencil-fill pe-1"></i>Edit
                                        </a>
                                        <a href="<?= url('delete_product?id=' . $prod['id']) ?>" 
                                           class="btn btn-sm rounded-pill px-3 fw-bold" style="background: rgba(220,53,69,0.12); color: #dc3545; border: 1px solid rgba(220,53,69,0.3); transition: all 0.2s ease;" onmouseover="this.style.background='rgba(220,53,69,0.25)';" onmouseout="this.style.background='rgba(220,53,69,0.12)';"
                                           onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                                           <i class="bi bi-trash3-fill pe-1"></i>Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if(empty($products)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <p style="font-size: 3.5rem; margin-bottom: 15px; filter: drop-shadow(0 4px 10px rgba(202,151,69,0.4));">📦</p>
                                        <h5 class="fw-bold">No Products Found</h5>
                                        <p class="text-muted mb-4" style="max-width: 450px; margin: 0 auto;">Start building your catalog by adding your first product.</p>
                                        <a href="<?= url('') ?>add_product" class="btn px-4 py-2 rounded-pill fw-bold" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; text-decoration: none;">
                                            <i class="bi bi-plus-circle-fill pe-1"></i>Add First Product
                                        </a>
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

<style>
.luxury-table tbody tr:hover {
    background: rgba(202, 151, 69, 0.08) !important;
}

.action-btn {
    transition: all 0.3s ease;
    border-width: 2px;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.feature-btn {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 5px 12px;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.featured-active {
    background: rgba(205, 154, 72, 0.15);
    color: #ca9745;
    border-color: rgba(205, 154, 72, 0.5);
}

.featured-active:hover {
    background: rgba(205, 154, 72, 0.25);
    color: #ffd700;
}

.featured-inactive {
    background: rgba(255, 255, 255, 0.05);
    color: #888;
    border-color: rgba(255, 255, 255, 0.1);
}

.featured-inactive:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #ccc;
}
</style>

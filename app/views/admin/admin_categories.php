<!-- Luxury Executive Header Card -->
<div class="admin-header-card p-4 p-md-5 mb-4 rounded-4 position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 p-5 opacity-10 pointer-events-none d-none d-lg-block" style="transform: translate(15%, -15%);">
        <i class="bi bi-tags-fill text-warning" style="font-size: 15rem;"></i>
    </div>
    <div class="position-relative z-1 text-center text-md-start">
        <div>
            <h2 class="mb-2 fw-bolder" style="font-size: 2.4rem; letter-spacing: -0.5px;">Categories & Collections</h2>
            <p class="mb-0 mt-2" style="max-width: 680px; font-size: 1.05rem; line-height: 1.5;">Organize and hierarchy your tailoring products into distinct parent and sub-categories for effortless navigation across the store.</p>
        </div>
        <div class="mt-4 d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-md-start">
            <a href="<?= url('') ?>add_category" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(202, 151, 69, 0.6)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="bi bi-plus-circle-fill fs-5"></i> + Add New Category
            </a>
            <a href="<?= url('') ?>admin_products" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: rgba(202, 151, 69, 0.18); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.3)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.18)'; this.style.color='#ca9745';">
                <i class="bi bi-box-seam-fill fs-5"></i> Products Inventory
            </a>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="luxury-list" id="categoryList">
            <?php foreach($categories as $index => $cat): ?>
                <div class="mb-4 border-0 main-category-item">
                    <div class="position-relative" id="heading-<?= $cat['c_id'] ?>">
                        <!-- Clean Light Caramel Executive Category Card -->
                        <div class="card p-3 p-md-4 mb-3 rounded-4 main-category-button-static" 
                             style="box-shadow: 0 8px 24px rgba(202,151,69,0.08); transition: all 0.3s ease;">
                            
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 w-100">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="<?= BASE_URL ?>/<?= !empty($cat['c_image']) ? htmlspecialchars($cat['c_image']) : 'pictures/home/cat1.webp' ?>" 
                                         class="rounded-3 shadow-sm" 
                                         style="width: 68px; height: 68px; object-fit: cover; border: 2px solid #ca9745; flex-shrink: 0; background: transparent;">

                                    <div>
                                        <span class="badge rounded-pill mb-1 px-3 py-1 font-monospace" style="background: rgba(202, 151, 69, 0.18); color: #ca9745; font-weight: 700; font-size: 0.75rem;">CID #<?= $cat['c_id'] ?></span>
                                        <h3 class="mb-0 fw-bolder text-uppercase" style="letter-spacing: 1px; font-size: 1.45rem;">
                                            <?= htmlspecialchars($cat['c_name']) ?>
                                        </h3>
                                        <small style="color: #ca9745; font-weight: 600;"><i class="bi bi-folder2-open pe-1"></i><?= count($cat['subs'] ?? []) ?> Subcategories Listed</small>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 align-items-center" style="flex-shrink: 0;">
                                    <a href="<?= url('edit_category?id=' . $cat['c_id']) ?>"
                                       class="btn rounded-pill px-4 py-2 fw-bolder d-flex align-items-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547) !important; color: #1a0f0a !important; border: none; font-size: 0.92rem; text-decoration: none;">
                                        <i class="bi bi-pencil-fill"></i> Edit Category
                                    </a>
                                    <a href="<?= url('delete_category?id=' . $cat['c_id']) ?>"
                                       class="btn rounded-pill px-3 py-2 fw-bold d-flex align-items-center gap-1" style="background: rgba(220, 53, 69, 0.12) !important; color: #dc3545 !important; border: 1px solid rgba(220, 53, 69, 0.3); font-size: 0.88rem; text-decoration: none;"
                                       onclick="return confirm('Delete this main category? All subcategories under it will also be removed.')">
                                        <i class="bi bi-trash-fill"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($cat['subs'])): ?>
                        <div class="mt-3 ms-md-5 ps-md-3" style="border-left: 3px solid #ca9745;">
                            <div class="card border-0 rounded-4 shadow-sm overflow-hidden" style="border: 1px solid rgba(202, 151, 69, 0.3) !important;">
                                <div class="card-header py-3 px-4 border-bottom d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, rgba(202, 151, 69, 0.15), rgba(202, 151, 69, 0.05)); border-color: rgba(202, 151, 69, 0.2) !important;">
                                    <span class="fw-bold small text-uppercase" style="letter-spacing: 0.8px;"><i class="bi bi-diagram-2-fill pe-2 text-warning"></i>Subcategories under <?= htmlspecialchars($cat['c_name']) ?></span>
                                    <span class="badge rounded-pill" style="background: #1a0f0a; color: #e8c547;"><?= count($cat['subs']) ?> Items</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead style="background: rgba(0,0,0,0.04);">
                                            <tr>
                                                <th class="ps-4 py-3 text-muted small fw-bold text-uppercase" style="width: 100px;">Sub ID</th>
                                                <th class="py-3 text-muted small fw-bold text-uppercase">Subcategory Name</th>
                                                <th class="py-3 text-muted small fw-bold text-uppercase text-end pe-4">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($cat['subs'] as $sub): ?>
                                                <tr>
                                                    <td class="ps-4"><span class="badge bg-secondary rounded-pill font-monospace">#<?= $sub['c_id'] ?></span></td>
                                                    <td>
                                                        <span class="fw-bold fs-6">
                                                            <?= htmlspecialchars($sub['c_name']) ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <a href="<?= url('edit_category?id=' . $sub['c_id']) ?>"
                                                           class="btn btn-sm rounded-pill px-3 py-1 me-1 fw-bold shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-size: 0.82rem; text-decoration: none;">
                                                            ✏️ Edit Subcategory
                                                        </a>
                                                        <a href="<?= url('delete_category?id=' . $sub['c_id']) ?>"
                                                           class="btn btn-sm rounded-pill px-3 py-1 fw-bold" style="background: rgba(220, 53, 69, 0.12); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.3); font-size: 0.82rem; text-decoration: none;"
                                                           onclick="return confirm('Delete this subcategory?')">
                                                            🗑️ Delete
                                                        </a>
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
            <?php endforeach; ?>

            <?php if(empty($categories)): ?>
            <div class="card p-5 text-center rounded-4 border-0 shadow-sm mx-auto" style="max-width: 600px;">
                <p style="font-size: 3.5rem; margin-bottom: 0.5rem;">🏷️</p>
                <h4 class="fw-bold mb-2">No Categories Found</h4>
                <p class="text-muted mb-4">Click below to establish your first product catalog category.</p>
                <a href="<?= url('') ?>add_category" class="btn px-4 py-3 rounded-pill shadow-sm mx-auto fw-bold" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; max-width: 250px;">
                    + Add New Category
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.main-category-button-static:hover {
    border-color: rgba(205, 154, 72, 0.7) !important;
    box-shadow: 0 6px 20px rgba(205, 154, 72, 0.15) !important;
    transform: translateY(-2px);
}

.main-category-item {
    transition: transform 0.2s ease;
}

.accordion-button::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffd700'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
    background-size: 1.5rem !important;
    width: 1.5rem !important;
    height: 1.5rem !important;
    transition: transform 0.3s ease-in-out;
}

.accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffd700'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
    transform: rotate(-180deg);
}

.accordion-button:not(.collapsed) {
    background: rgba(202, 151, 69, 0.15) !important;
    box-shadow: inset 0 -1px 0 rgba(202, 151, 69, 0.2);
    color: var(--accent-bronze) !important;
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(202, 151, 69, 0.1);
}

.main-category-row:hover {
    background: rgba(202, 151, 69, 0.1) !important;
}

/* Subcategory Card Styling */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    border-color: rgba(205, 154, 72, 0.5) !important;
    box-shadow: 0 12px 25px rgba(205, 154, 72, 0.2) !important;
    background: rgba(255,255,255,0.06) !important;
}

.card:hover .card-title {
    color: #ca9745 !important;
}

.accordion-item {
    transition: transform 0.2s ease;
}

.accordion-item:hover {
    transform: translateX(5px);
}
</style>

<!-- Styles handled globally by theme-luxury.css / theme-default.css -->
<div class="container-fluid py-4">
    <div class="card p-4 p-md-5 mx-auto rounded-4 shadow-lg border-0" style="max-width: 1050px; background: linear-gradient(145deg, #ffffff, #fcfbf9); border: 1px solid rgba(202, 151, 69, 0.2) !important;">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-3">
            <div>
                <h3 class="fw-bolder mb-0" style="color: #1a0f0a; font-size: 1.85rem;">Edit Catalog Item</h3>
            </div>
            <a href="<?= url('') ?>admin_products" class="btn px-4 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2" style="background: rgba(202, 151, 69, 0.12); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.4); font-weight: 700; font-size: 0.9rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.25)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.12)'; this.style.color='#ca9745';">
                <i class="bi bi-arrow-left pe-1"></i> Back to Products Inventory
            </a>
        </div>

            <form action="<?= url('') ?>update_product" method="post" enctype="multipart/form-data">
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">


                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="pname" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Article Number</label>
                        <input type="text" name="art" class="form-control" value="<?= htmlspecialchars($product['article_number']) ?>">
                    </div>

                    <div class="col-6">
                        <label class="form-label">Description</label>
                        <textarea name="pdesc" class="form-control" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Details</label>
                        <textarea name="details" class="form-control" rows="3"><?= htmlspecialchars($product['details']) ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Product Images</label>
                        <input type="file" name="bimage[]" class="form-control" accept="image/*" multiple>

                        <?php if(!empty($product['image_url'])): ?>
                            <div class="mt-2">
                                <small class="text-muted d-block mb-1">Current Images</small>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach(array_filter(array_map('trim', explode(',', $product['image_url']))) as $imgPath): ?>
                                        <?php if(!empty($imgPath) && file_exists(BASE_PATH . '/public/' . $imgPath)): ?>
                                            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($imgPath) ?>" 
                                                 class="img-thumbnail rounded" 
                                                 style="max-width:120px;">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="col-12 pt-3 border-top mt-4">
                    <p class="fw-bold mb-0" style="font-size: 0.78rem; letter-spacing: 1.5px; color: #ca9745; text-transform: uppercase;"><i class="bi bi-box-seam pe-1"></i> Inventory &amp; Pricing</p>
                </div>
                <?php
                $size_str = $product['size'] ?? '';
                $qty_xs = 0; $qty_s = 0; $qty_l = 0; $qty_xl = 0;
                if (preg_match_all('/(XS|S|L|XL):\s*(\d+)/i', $size_str, $matches, PREG_SET_ORDER)) {
                    foreach ($matches as $match) {
                        $key = strtoupper($match[1]);
                        $val = (int)$match[2];
                        if ($key === 'XS') $qty_xs = $val;
                        elseif ($key === 'S') $qty_s = $val;
                        elseif ($key === 'L') $qty_l = $val;
                        elseif ($key === 'XL') $qty_xl = $val;
                    }
                }
                ?>
                <div class="row g-3">
                    <!-- Size Boxes / Quantities -->
                    <div class="col-md-2">
                        <label class="form-label">Size XS</label>
                        <input name="qty_xs" class="form-control qty-input" type="number" min="0" value="<?= $qty_xs ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Size S</label>
                        <input name="qty_s" class="form-control qty-input" type="number" min="0" value="<?= $qty_s ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Size L</label>
                        <input name="qty_l" class="form-control qty-input" type="number" min="0" value="<?= $qty_l ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Size XL</label>
                        <input name="qty_xl" class="form-control qty-input" type="number" min="0" value="<?= $qty_xl ?>">
                    </div>

                    <!-- Total Quantity (Auto-calculated) -->
                    <div class="col-md-2">
                        <label class="form-label">Total Quantity</label>
                        <input id="totalQty" class="form-control bg-light" type="text" readonly value="<?= htmlspecialchars($product['quantity']) ?>">
                    </div>

                    <!-- Price -->
                    <div class="col-md-2">
                        <label class="form-label">Price (Rs)</label>
                        <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($product['price']) ?>" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Category</label>
                        <select name="parent_id" class="form-select">
                            <option value="">-- Select Category --</option>

                            <?php foreach($top_categories as $top_cat): ?>
                                <?php $selected = ($top_cat['c_id'] == $product['parent_cat']) ? "selected" : ""; ?>
                                <option value="<?= $top_cat['c_id'] ?>" <?= $selected ?>>
                                    <?= htmlspecialchars($top_cat['c_name']) ?> (Main)
                                </option>

                                <?php if (!empty($top_cat['subs'])): ?>
                                    <?php foreach($top_cat['subs'] as $sub): ?>
                                        <?php $selected = ($sub['c_id'] == $product['parent_cat']) ? "selected" : ""; ?>
                                        <option value="<?= $sub['c_id'] ?>" <?= $selected ?>>
                                            &nbsp;&nbsp;↳ <?= htmlspecialchars($sub['c_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <!-- SEO -->
                <div class="col-12 mt-2 pt-3 border-top">
                    <p class="fw-bold mb-0" style="font-size: 0.78rem; letter-spacing: 1.5px; color: #ca9745; text-transform: uppercase;"><i class="bi bi-search pe-1"></i> SEO Settings <span class="text-muted fw-normal" style="font-size:0.75rem; letter-spacing:0; text-transform:none;">(Optional)</span></p>
                </div>
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($product['meta_title']) ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" value="<?= htmlspecialchars($product['meta_keywords']) ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_desc" class="form-control" rows="3"><?= htmlspecialchars($product['meta_description']) ?></textarea>
                    </div>

                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-3 border-top">
                    <a href="<?= url('') ?>admin_products" class="btn px-4 py-3 rounded-pill border" style="font-weight: 600;">Cancel</a>
                    <button type="submit" class="btn px-5 py-3 rounded-pill shadow-lg d-flex align-items-center gap-2" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 1.02rem; animation: adminPulseGlow 2.5s ease infinite; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 28px rgba(202, 151, 69, 0.7)';" onmouseout="this.style.transform='translateY(0)';">
                        <i class="bi bi-check-circle-fill fs-5"></i> Update Product Item
                    </button>
                </div>

            </form>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const qtyInputs = document.querySelectorAll('.qty-input');
    const totalQtyField = document.getElementById('totalQty');

    function calculateTotal() {
        let total = 0;
        qtyInputs.forEach(input => {
            total += parseInt(input.value) || 0;
        });
        if (totalQtyField) {
            totalQtyField.value = total;
        }
    }

    qtyInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
        input.addEventListener('change', calculateTotal);
    });

    calculateTotal();
});
</script>
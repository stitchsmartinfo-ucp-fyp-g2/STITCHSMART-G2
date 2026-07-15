<!-- Keyframes for Admin Featured Products (Matching Sale Page Animations) -->
<style>
@keyframes adminFadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes adminShimmer {
    0%   { background-position: 0% center; }
    100% { background-position: 200% center; }
}
@keyframes adminPulseGlow {
    0%,100% { box-shadow: 0 0 0 0 rgba(202, 151, 69, 0.5); }
    50%     { box-shadow: 0 0 0 10px rgba(202, 151, 69, 0); }
}
@keyframes adminSlideBar {
    from { width: 0; opacity: 0; }
    to   { width: 80px; opacity: 1; }
}
.admin-feature-hero {
    background: linear-gradient(135deg, rgba(26, 15, 10, 0.88) 0%, rgba(14, 8, 5, 0.94) 100%),
                url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&q=80&w=1400') center/cover no-repeat;
    border: 1px solid rgba(202, 151, 69, 0.45);
    box-shadow: 0 15px 35px rgba(0,0,0,0.45);
    animation: adminFadeInDown 0.7s cubic-bezier(.16,1,.3,1) both;
}
.admin-feature-hero h2 span {
    display: block;
    background: linear-gradient(to right, #ca9745, #f9ebb3, #ca9745);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: adminShimmer 4s linear infinite;
}
</style>

<!-- Luxury Executive Hero Card with Photo & Animation -->
<div class="admin-feature-hero p-4 p-md-5 mb-4 rounded-4 position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 p-5 opacity-10 pointer-events-none d-none d-lg-block" style="transform: translate(10%, -10%);">
        <i class="bi bi-star-fill text-warning" style="font-size: 15rem;"></i>
    </div>
    <div class="position-relative z-1 text-center text-md-start">
        <h2 class="mb-2 fw-bolder" style="font-size: 2.4rem; letter-spacing: -0.5px;">
            Featured Products
            <span>SHOWCASE PORTAL</span>
        </h2>
        <p class="mb-0 mt-2" style="max-width: 680px; font-size: 1.05rem; line-height: 1.5;">Curate and manage your signature tailoring creations. Featured items automatically shine across both the homepage and the standalone showcase collection with dynamic gold animations.</p>
        <div class="mt-4 d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-md-start">
            <button type="button" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addFeatureModal" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 0.96rem; animation: adminPulseGlow 2.5s ease infinite; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(202, 151, 69, 0.6)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="bi bi-plus-circle-fill fs-5"></i> + Add Featured Product
            </button>
            <a href="<?= url('') ?>admin_products" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: rgba(202, 151, 69, 0.18); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.3)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.18)'; this.style.color='#ca9745';">
                <i class="bi bi-box-seam-fill fs-5"></i> All Catalog Products
            </a>
        </div>
    </div>
</div>

<?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-warning border-0 rounded-3 mb-4" role="alert">
        <?= htmlspecialchars($_SESSION['flash']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<div class="row mt-2">
    <div class="col-12">
        <div class="card p-4 rounded-4 shadow-sm">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                <div>
                    <h4 class="mb-1 fw-bold"><i class="bi bi-stars text-warning pe-2"></i>Currently Featured Creations</h4>
                    <p class="mb-0 text-muted small">These select garments receive prime placement with shimmering gold highlights on the public showcase.</p>
                </div>
                <span class="badge rounded-pill px-3 py-2" style="background: rgba(202, 151, 69, 0.15); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-size: 0.85rem; font-weight: 700;">Total Featured: <?= count($products) ?></span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover text-center align-middle mb-0">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(202, 151, 69, 0.4); font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; color: #ca9745;">
                            <th class="py-3">PID</th>
                            <th class="py-3">Creation Preview</th>
                            <th class="py-3" style="white-space: nowrap;">Article No.</th>
                            <th class="py-3">Garment Name</th>
                            <th class="py-3">Showcase Status</th>
                            <th class="py-3">Management Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $index => $prod): ?>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.06); animation: adminFadeInDown <?= 0.3 + ($index * 0.1) ?>s ease both;">
                                <td class="fw-bold" style="color: #ca9745;">#<?= htmlspecialchars($prod['id']) ?></td>
                                <td class="py-3">
                                    <?php $productImage = strtok($prod['image_url'], ','); ?>
                                    <div class="position-relative d-inline-block">
                                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($productImage)) ?>" alt="Product" class="rounded-3 shadow" style="width: 75px; height: 75px; object-fit: cover; border: 2px solid rgba(202, 151, 69, 0.6); box-shadow: 0 4px 15px rgba(202,151,69,0.3);">
                                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-light rounded-circle shadow" title="Featured Item"></span>
                                    </div>
                                </td>
                                <td class="fw-bold">
                                    <span class="px-3 py-1 rounded-pill" style="background: rgba(150,150,150,0.1); border: 1px solid rgba(150,150,150,0.25); font-family: monospace;">
                                        <?= htmlspecialchars($prod['article_number']) ?>
                                    </span>
                                </td>
                                <td class="fw-bold fs-6">
                                    <?= htmlspecialchars($prod['name']) ?>
                                </td>
                                <td>
                                    <span class="badge px-3 py-2 rounded-pill shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; font-weight: 800; letter-spacing: 0.5px; box-shadow: 0 3px 12px rgba(202, 151, 69, 0.4);">
                                        🌟 PRIME SHOWCASE
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= url('feature_product?id=' . $prod['id']) ?>" 
                                       class="btn btn-sm px-4 py-2 rounded-pill fw-bold" style="background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.5); color: #ff6b6b; transition: all 0.3s ease;" onmouseover="this.style.background='#dc3545'; this.style.color='#fff'; this.style.transform='scale(1.05)';" onmouseout="this.style.background='rgba(220, 53, 69, 0.15)'; this.style.color='#ff6b6b'; this.style.transform='scale(1)';" title="Remove from Featured Showcase">
                                       <i class="bi bi-x-circle-fill pe-1"></i> Remove Feature
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($products)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <p style="font-size: 3.5rem; margin-bottom: 15px; filter: drop-shadow(0 4px 10px rgba(202,151,69,0.5));">✨</p>
                                        <h5 class="text-white fw-bold">No Featured Products Currently Highlighted</h5>
                                        <p class="text-muted mb-4" style="max-width: 450px; margin: 0 auto;">Select premier creations from your collection to give them prime luxury visibility across the storefront.</p>
                                        <button type="button" class="btn px-4 py-2 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#addFeatureModal" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; box-shadow: 0 4px 15px rgba(202, 151, 69, 0.4);">
                                            <i class="bi bi-plus-circle-fill pe-1"></i> Select Products Now
                                        </button>
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

<!-- Modal for Adding Feature Products -->
<div class="modal fade" id="addFeatureModal" tabindex="-1" aria-labelledby="addFeatureModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-4 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e110a, #0d0603); border: 1px solid rgba(202, 151, 69, 0.5); color: #fff;">
      <div class="modal-header px-4 py-3 border-bottom" style="border-color: rgba(202, 151, 69, 0.3) !important; background: rgba(0,0,0,0.3);">
        <h5 class="modal-title fw-bold text-warning" id="addFeatureModalLabel"><i class="bi bi-stars pe-2"></i>Select Creations to Feature</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
          <div class="table-responsive">
              <table class="table table-hover text-center align-middle mb-0" style="color: #f4e9d3;">
                  <thead>
                      <tr style="border-bottom: 1px solid rgba(202, 151, 69, 0.3); font-size: 0.82rem; color: #ca9745; text-transform: uppercase;">
                          <th class="ps-4 py-3">Creation Preview</th>
                          <th class="py-3">Article No.</th>
                          <th class="py-3">Garment Name</th>
                          <th class="py-3 pe-4 text-end">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach($available_products as $avail): ?>
                          <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                              <td class="ps-4 py-3">
                                  <?php $avImage = strtok($avail['image_url'], ','); ?>
                                  <img src="<?= BASE_URL ?>/<?= htmlspecialchars(trim($avImage)) ?>" alt="Product" class="rounded-3 shadow" style="width: 55px; height: 55px; object-fit: cover; border: 1px solid rgba(202, 151, 69, 0.5);">
                              </td>
                              <td class="py-3 fw-bold font-monospace text-light"><?= htmlspecialchars($avail['article_number']) ?></td>
                              <td class="py-3 fw-bold text-white"><?= htmlspecialchars($avail['name']) ?></td>
                              <td class="py-3 text-end pe-4">
                                  <a href="<?= url('feature_product?id=' . $avail['id']) ?>" class="btn btn-sm rounded-pill px-4 py-2 fw-bold" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; box-shadow: 0 2px 8px rgba(202, 151, 69, 0.4); text-decoration: none;">⭐ Add to Showcase</a>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                      <?php if(empty($available_products)): ?>
                          <tr>
                              <td colspan="4" class="text-center py-5 text-muted">
                                  <i class="bi bi-check-circle-fill text-success fs-3 d-block mb-2"></i>
                                  All eligible products are already featured on the showcase!
                              </td>
                          </tr>
                      <?php endif; ?>
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</div>

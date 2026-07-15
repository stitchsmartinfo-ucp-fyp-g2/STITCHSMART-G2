<div class="container-fluid py-4">
    <div class="card p-4 p-md-5 mx-auto rounded-4 shadow-lg border-0" style="max-width: 820px; background: linear-gradient(145deg, #ffffff, #fcfbf9); border: 1px solid rgba(202, 151, 69, 0.2) !important;">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-3">
            <div>
                <h3 class="fw-bolder mb-0" style="color: #1a0f0a; font-size: 1.85rem;">Edit Promotional Banner</h3>
            </div>
            <a href="<?= url('') ?>homepage" class="btn px-4 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2" style="background: rgba(202, 151, 69, 0.12); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.4); font-weight: 700; font-size: 0.9rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.25)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.12)'; this.style.color='#ca9745';">
                <i class="bi bi-arrow-left pe-1"></i> Back to Store Homepage
            </a>
        </div>
    <form action="<?php echo url('edit_banner?id=' . (int)$banner['id']); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <?php if (!empty($banner['image_url'])): ?>
            <div class="mb-4 text-center p-3 rounded-3 border" style="background: rgba(0,0,0,0.05);">
                <label class="form-label fw-bold d-block mb-2 text-muted">Current Banner Image Artwork:</label>
                <img src="<?php echo BASE_URL . $banner['image_url']; ?>" alt="Current Banner" class="img-fluid rounded shadow-sm" style="max-height: 220px; object-fit: cover;">
            </div>
        <?php endif; ?>

        <div class="mb-4">
            <label for="text" class="form-label fw-bold">Banner Title / Headline <span class="text-danger">*</span></label>
            <input type="text" id="text" name="text" class="form-control px-3 py-2" value="<?php echo htmlspecialchars($banner['text'] ?? ''); ?>" required>
        </div>
        
        <div class="mb-4">
            <label for="alt" class="form-label fw-bold">Subtitle / Promotional Description <span class="text-danger">*</span></label>
            <textarea id="alt" name="alt" class="form-control px-3 py-2" rows="3" required><?php echo htmlspecialchars($banner['alt'] ?? ''); ?></textarea>
        </div>

        <div class="mb-4">
            <label for="image" class="form-label fw-bold">Replace Banner Image File <small class="text-muted fw-normal">(Optional — leave blank to retain current image)</small></label>
            <input type="file" id="image" name="bimage" class="form-control px-3 py-2">
        </div>

        <div class="d-flex justify-content-end gap-3 mt-5 pt-3 border-top">
            <a href="<?= url('') ?>homepage" class="btn px-4 py-2 rounded-pill border" style="font-weight: 600;">Cancel</a>
            <button type="submit" name="updatebanner" class="btn px-5 py-2 rounded-pill shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; font-weight: 800;">Save Banner Updates</button>
        </div>
    </form>
    </div>
</div>
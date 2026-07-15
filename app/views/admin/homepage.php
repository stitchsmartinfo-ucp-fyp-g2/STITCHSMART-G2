<!-- Luxury Executive Header Card -->
<div class="admin-header-card p-4 p-md-5 mb-4 rounded-4 position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 p-5 opacity-5 pointer-events-none d-none d-lg-block" style="transform: translate(20%, -20%);">
        <i class="bi bi-layout-text-window-reverse text-warning" style="font-size: 12rem;"></i>
    </div>
    <div class="position-relative z-1 text-center text-md-start">
        <div>
            <h2 class="mb-2 fw-bolder" style="font-size: 2.4rem; letter-spacing: -0.5px;">Store Homepage Management</h2>
            <p class="mb-0 mt-2" style="max-width: 680px; font-size: 1.05rem; line-height: 1.5;">Customize live storefront promotional banners, manage social media links, optimize global SEO meta properties, and control what your customers see first.</p>
        </div>
        <div class="mt-4 d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-md-start">
            <a href="<?= url('') ?>banner_add" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(202, 151, 69, 0.6)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="bi bi-plus-circle-fill fs-5"></i> + Add New Banner
            </a>
            <a href="<?= url('') ?>admin_feature_products" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: rgba(202, 151, 69, 0.18); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.3)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.18)'; this.style.color='#ca9745';">
                <i class="bi bi-star-fill fs-5"></i> Featured Showcase
            </a>
            <a href="<?= url('') ?>admin_sale_products" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: rgba(202, 151, 69, 0.18); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.3)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.18)'; this.style.color='#ca9745';">
                <i class="bi bi-tag-fill fs-5"></i> Sale Portal
            </a>
        </div>
    </div>
</div>

<!-- Social Links Card -->
<div class="card p-4 rounded-4 shadow-sm mb-5">
    <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
        <i class="bi bi-share-fill text-warning"></i> Social Media & Connect Settings
    </h5>
    <form action="<?php echo url('') ?>admin_save_settings" method="POST" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-sm-3">
                <div class="p-3 rounded-3 border">
                    <label for="facebook" class="form-label fw-bold mb-1"><i class="bi bi-facebook text-primary pe-1"></i> Facebook</label>
                    <input type="text" id="facebook" name="facebook" class="form-control border-0 border-bottom bg-transparent" value="<?php echo htmlspecialchars($facebook ?? '') ?>" placeholder="https://facebook.com/...">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="p-3 rounded-3 border">
                    <label for="instagram" class="form-label fw-bold mb-1"><i class="bi bi-instagram text-danger pe-1"></i> Instagram</label>
                    <input type="text" id="instagram" name="instagram" class="form-control border-0 border-bottom bg-transparent" value="<?php echo htmlspecialchars($instagram ?? '') ?>" placeholder="https://instagram.com/...">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="p-3 rounded-3 border">
                    <label for="pinterest" class="form-label fw-bold mb-1"><i class="bi bi-pinterest text-danger pe-1"></i> Pinterest</label>
                    <input type="text" id="pinterest" name="pinterest" class="form-control border-0 border-bottom bg-transparent" value="<?php echo htmlspecialchars($pinterest ?? '') ?>" placeholder="https://pinterest.com/...">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="p-3 rounded-3 border">
                    <label for="linkdin" class="form-label fw-bold mb-1"><i class="bi bi-linkedin text-info pe-1"></i> LinkedIn</label>
                    <input type="text" id="linkdin" name="linkdin" class="form-control border-0 border-bottom bg-transparent" value="<?php echo htmlspecialchars($linkdin ?? '') ?>" placeholder="https://linkedin.com/...">
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
            <button type="submit" class="btn px-5 py-2 rounded-pill shadow-sm" name="save_social_info" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; font-weight: 800; border: none;">Save Social Links</button>
        </div>
    </form>
</div>
           
<!-- Banners Management Card -->
<div class="card p-4 rounded-4 shadow-sm mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1">Promotional Banners</h4>
            <p class="mb-0 text-muted">Banners display on the storefront showcase hero carousel.</p>
        </div>
        <a href="<?php echo url('') ?>banner_add" class="btn px-4 py-2 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; font-weight: 800; text-decoration: none;">
            <i class="bi bi-plus-circle-fill"></i> + Add New Banner
        </a>
    </div>
    
    <div class="table-responsive rounded-3">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">
                    <th class="py-3 px-4">Banner #</th>
                    <th class="py-3">Banner Image</th>
                    <th class="py-3">Banner Title / Caption</th>
                    <th class="py-3 text-end px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php if (!empty($banners)): ?>
                    <?php foreach($banners as $row): ?>
                        <tr>
                            <td class="px-4 fw-bold"><?php echo $id; ?></td>
                            <td>
                                <div class="p-2 rounded border shadow-sm d-inline-block">
                                    <img src="<?php echo BASE_URL . $row['image_url']; ?>" width="120px" class="rounded" style="object-fit: cover; max-height: 60px;">
                                </div>
                            </td>
                            <td class="fw-semibold fs-6"><?php echo htmlspecialchars($row['text']); ?></td>
                            <td class="text-end px-4">
                                <div class="btn-group">
                                    <a href="<?php echo url('edit_banner?id=' . $row['id']) ?>" 
                                       class="btn btn-sm px-3 rounded-pill me-2 d-inline-flex align-items-center gap-1">
                                       <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="<?php echo url('delete_banner?id=' . $row['id']) ?>" 
                                       class="btn btn-sm btn-danger px-3 rounded-pill d-inline-flex align-items-center gap-1" 
                                       onclick="return confirm('Remove this banner from storefront carousel?')">
                                       <i class="bi bi-trash"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php $id++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No promotional banners currently active. Click "+ Add New Banner" above to create your first showcase slide.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- SEO Settings Section Card -->
<div class="card p-4 rounded-4 shadow-sm mb-5">
    <form action="<?php echo url('') ?>admin_save_settings" method="POST" id="metaForm">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Global Storefront SEO Settings</h4>
                <p class="mb-0 text-muted" style="font-size: 0.9rem;">Optimize search rankings and social graph previews for StitchSmart.</p>
            </div>
            <button type="button" onclick="generateMetaAI(this)" class="btn px-4 py-2 rounded-pill shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; font-weight: 800; font-size: 0.9rem; border: none;">
                ✨ Generate SEO with AI
            </button>
        </div>
        <div id="ai-error-container"></div>
        
        <div class="row g-3">
            <div class="col-md-6">
                <label for="meta-title" class="form-label fw-bold">Meta Title</label>
                <input type="text" name="meta_title" id="meta-title" class="form-control" value="<?= htmlspecialchars($meta_title ?? '') ?>" placeholder="StitchSmart - Executive Luxury Tailoring & Fashion" />
            </div>
            <div class="col-md-6">
                <label for="meta-keywords" class="form-label fw-bold">Meta Keywords</label>
                <input type="text" name="meta_keywords" id="meta-keywords" class="form-control" value="<?= htmlspecialchars($meta_keywords ?? '') ?>" placeholder="luxury fashion, bespoke tailoring, online garments" />
            </div>
            <div class="col-12">
                <label for="meta-description" class="form-label fw-bold">Meta Description</label>
                <textarea class="form-control" name="meta_description" id="meta-description" rows="3" placeholder="Discover the finest collection of luxury tailoring, handcrafted apparel, and bespoke executive wear at StitchSmart."><?= htmlspecialchars($meta_description ?? '') ?></textarea>
            </div>
        </div>
    
        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
            <button type="submit" class="btn px-5 py-2 rounded-pill shadow-sm" id="mbut" name="save_meta_info" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; font-weight: 800; border: none;">Update SEO Settings</button>
        </div>
    </form>
</div>

<script>
async function generateMetaAI(btn) {
    const originalText = btn.innerHTML;
    
    try {
        btn.disabled = true;
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Generating...`;

        const apiKey = "<?= GOOGLE_API_KEY ?>";
        const url = `https://generativelanguage.googleapis.com/v1/models/<?= GEMINI_MODEL ?>:generateContent?key=${apiKey}`;

        const body = {
            contents: [{
                parts: [{
                    text: `Return ONLY valid JSON for SEO meta settings for a high-end fashion & tailoring brand named "Stitch Smart".
                    Format: {"title": "", "description": "", "keywords": ""}
                    Make it professional and optimized.`
                }]
            }]
        };

        const res = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(body)
        });

        const data = await res.json();
        if (data.error) throw new Error(data.error.message);

        let text = data.candidates[0].content.parts[0].text;
        
        const jsonMatch = text.match(/\{[\s\S]*\}/);
        if (!jsonMatch) throw new Error("Could not parse AI response.");
        const json = JSON.parse(jsonMatch[0]);

        document.getElementById("meta-title").value = json.title || "";
        document.getElementById("meta-description").value = json.description || "";
        document.getElementById("meta-keywords").value = json.keywords || "";

    } catch (err) {
        console.error("AI Error:", err);
        const errorContainer = document.getElementById("ai-error-container");
        if (errorContainer) {
            errorContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show mt-3 border-0 rounded-3 p-3 shadow" role="alert">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>AI Generation failed:</strong> ${err.message}
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger px-3 py-1 rounded-pill" data-bs-dismiss="alert" aria-label="Close">OK</button>
                    </div>
                </div>
            `;
        } else {
            alert("AI Generation failed: " + err.message);
        }
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
}
</script>

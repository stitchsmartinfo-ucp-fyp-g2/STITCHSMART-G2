<div class="container-fluid py-4">
    <div class="card p-4 p-md-5 mx-auto rounded-4 shadow-lg border-0" style="max-width: 900px; background: linear-gradient(145deg, #ffffff, #fcfbf9); border: 1px solid rgba(202, 151, 69, 0.2) !important;">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-3">
            <div>
                <h3 class="fw-bolder mb-0" style="color: #1a0f0a; font-size: 1.85rem;">Add New Category</h3>
            </div>
            <a href="<?= url('') ?>admin_categories" class="btn px-4 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2" style="background: rgba(202, 151, 69, 0.12); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.4); font-weight: 700; font-size: 0.9rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.25)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.12)'; this.style.color='#ca9745';">
                <i class="bi bi-arrow-left pe-1"></i> Back to Categories
            </a>
        </div>
    <form method="POST" enctype="multipart/form-data" action="<?= url('') ?>store_category" novalidate>
        <style>
            .form-control.is-invalid,
            textarea.form-control.is-invalid,
            select.form-control.is-invalid {
                border-color: #dc3545 !important;
                box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.2);
                background: rgba(220, 53, 69, 0.06);
            }
            .form-control.is-invalid::placeholder,
            textarea.form-control.is-invalid::placeholder {
                color: #b02a37 !important;
                opacity: 1 !important;
                font-weight: 600;
            }
        </style>

        <?php if(!empty($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
            <div class="alert alert-danger mb-4 rounded-3 border-0 p-3 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill pe-2"></i><strong><?= htmlspecialchars($_SESSION['errors']['csrf'] ?? 'Please check the highlighted fields below.') ?></strong>
            </div>
        <?php endif; ?>

        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

<div class="mb-3">
    <label class="form-label fw-bold">Category Name</label>
    <input type="text" name="cat_name" id="cat_name" class="form-control <?= isset($_SESSION['errors']['cat_name']) ? 'is-invalid' : '' ?>" placeholder="<?= isset($_SESSION['errors']['cat_name']) ? htmlspecialchars($_SESSION['errors']['cat_name']) : 'Enter category name' ?>" style="background: rgba(255,255,255,0.05); color: inherit;" value="<?= htmlspecialchars($_SESSION['old_input']['cat_name'] ?? '') ?>" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Parent Category</label>
    <select name="parent_id" class="form-control form-select" style="background: rgba(255,255,255,0.05); color: inherit;">
        <option value="0" style="background: #2a2a2a; color: #fff;">None (Main Category)</option>
        <?php foreach($parents as $p): ?>
            <option value="<?= $p['c_id'] ?>" <?= (isset($_SESSION['old_input']['parent_id']) && $_SESSION['old_input']['parent_id'] == $p['c_id']) ? 'selected' : '' ?> style="background: #2a2a2a; color: #fff;">
                <?= htmlspecialchars($p['c_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>



<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Category Image</label>
        <input type="file" name="cimage" class="form-control <?= isset($_SESSION['errors']['cimage']) ? 'is-invalid' : '' ?>" style="background: rgba(255,255,255,0.05); color: inherit;">
        <?php if(isset($_SESSION['errors']['cimage'])): ?>
            <div class="invalid-feedback d-block"><?= htmlspecialchars($_SESSION['errors']['cimage']) ?></div>
        <?php endif; ?>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Category Banner</label>
        <input type="file" name="bimage" class="form-control <?= isset($_SESSION['errors']['bimage']) ? 'is-invalid' : '' ?>" style="background: rgba(255,255,255,0.05); color: inherit;">
        <?php if(isset($_SESSION['errors']['bimage'])): ?>
            <div class="invalid-feedback d-block"><?= htmlspecialchars($_SESSION['errors']['bimage']) ?></div>
        <?php endif; ?>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 mt-4">
    <label class="form-label mb-0 fw-bold">Category Description</label>
    <button type="button" onclick="generateCategoryAI(this)" class="btn btn-sm" style="background-color: #111 !important; color: #ca9745 !important; border: 1px solid #ca9745 !important; font-weight: bold;">✨ Generate with AI</button>
</div>
<div id="ai-error-container"></div>
<div class="mb-3">
    <textarea name="cat_desc" id="cat_desc" class="form-control <?= isset($_SESSION['errors']['cat_desc']) ? 'is-invalid' : '' ?>" rows="4" placeholder="<?= isset($_SESSION['errors']['cat_desc']) ? htmlspecialchars($_SESSION['errors']['cat_desc']) : 'AI will generate this...' ?>" style="background: rgba(255,255,255,0.05); color: inherit;" required><?= htmlspecialchars($_SESSION['old_input']['cat_desc'] ?? '') ?></textarea>
</div>

<div class="col-12 mt-4 pt-3 border-top">
    <p class="fw-bold mb-0" style="font-size: 0.78rem; letter-spacing: 1.5px; color: #ca9745; text-transform: uppercase;"><i class="bi bi-search pe-1"></i> SEO Settings <span class="text-muted fw-normal" style="font-size:0.75rem; letter-spacing:0; text-transform:none;">(Optional)</span></p>
</div>
<div class="row g-3">
    <div class="col-md-6 mb-3">
        <label class="fw-bold">Meta Title</label>
        <input type="text" name="meta_title" id="meta_title" class="form-control" style="background: rgba(255,255,255,0.05); color: inherit;">
    </div>
    <div class="col-md-6 mb-3">
        <label class="fw-bold">Meta Keywords</label>
        <textarea name="meta_keywords" id="meta_keywords" class="form-control" style="background: rgba(255,255,255,0.05); color: inherit;" rows="1"><?= htmlspecialchars($_SESSION['old_input']['meta_keywords'] ?? '') ?></textarea>
    </div>
    <div class="col-12 mb-3">
        <label class="fw-bold">Meta Description</label>
        <textarea name="meta_desc" id="meta_desc" class="form-control" style="background: rgba(255,255,255,0.05); color: inherit;" rows="3"><?= htmlspecialchars($_SESSION['old_input']['meta_desc'] ?? '') ?></textarea>
    </div>
</div>

        <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-3 border-top">
            <a href="<?= url('') ?>admin_categories" class="btn px-4 py-3 rounded-pill border" style="font-weight: 600;">Cancel</a>
            <button type="submit" class="btn px-5 py-3 rounded-pill shadow-lg d-flex align-items-center gap-2" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 1.02rem; animation: adminPulseGlow 2.5s ease infinite; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 28px rgba(202, 151, 69, 0.7)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="bi bi-check-circle-fill fs-5"></i> Save & Publish Category
            </button>
        </div>

    </form>
    </div>
</div>
<?php unset($_SESSION['errors'], $_SESSION['old_input']); ?>

<script>
function useFallbackCategoryData(name) {
    const descriptions = [
        `Discover our exclusive premium collection of ${name}. Crafted for luxury and style.`,
        `Explore the finest selection of ${name}. High-quality and trending designs tailored for you.`,
        `Shop our elegantly curated ${name} collection. The perfect blend of comfort and premium fashion.`
    ];
    const seo_titles = [
        `Buy Premium ${name} Online | Luxury Store`,
        `Best ${name} Collection - Shop Now`,
        `Exclusive ${name} Styles & Trends`
    ];
    
    const desc = descriptions[Math.floor(Math.random() * descriptions.length)];
    const title = seo_titles[Math.floor(Math.random() * seo_titles.length)];
    
    document.getElementById("cat_desc").value = desc;
    document.getElementById("meta_title").value = title;
    document.getElementById("meta_desc").value = desc;
    document.getElementById("meta_keywords").value = `${name.toLowerCase()}, premium fashion, luxury, online shopping, buy ${name.toLowerCase()}`;
}

async function generateCategoryAI(btn) {
    const nameInput = document.getElementById("cat_name");
    const name = nameInput.value.trim();
    if(!name) {
        nameInput.classList.add('is-invalid');
        nameInput.placeholder = 'Fill the Category Name field.';
        nameInput.focus();
        return;
    }

    const originalText = btn.innerText;
    nameInput.classList.remove('is-invalid');
    try {
        btn.disabled = true;
        btn.innerText = "Generating...";

        const apiKey = "<?= GOOGLE_API_KEY ?>";
        let url = `https://generativelanguage.googleapis.com/v1beta/models/<?= GEMINI_MODEL ?>:generateContent?key=${apiKey}`;

        const body = {
            contents: [{
                parts: [{
                    text: `Return ONLY valid JSON for a product category named "${name}" in a high-end fashion store.
                    Format: {"description": "", "seo_title": "", "seo_desc": "", "seo_keywords": ""}
                    Make it professional, luxury, and optimized for SEO.`
                }]
            }]
        };

        let res = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(body)
        });

        let data = await res.json();
        
        if (data.error && (data.error.code === 404 || data.error.message.toLowerCase().includes("not found") || data.error.message.toLowerCase().includes("supported"))) {
            url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite:generateContent?key=${apiKey}`;
            res = await fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(body)
            });
            data = await res.json();
        }

        const successMsg = `
            <div class="alert alert-success alert-dismissible fade show mt-3 border-0 rounded-3 p-3 shadow" role="alert" style="background: rgba(40, 167, 69, 0.15); border: 1px solid rgba(40, 167, 69, 0.3) !important; color: #28a745;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Your information is fetched successfully!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        if (data.error) {
            useFallbackCategoryData(name);
            const errorContainer = document.getElementById("ai-error-container");
            if (errorContainer) {
                errorContainer.innerHTML = successMsg;
            }
            return;
        }

        let text = data.candidates[0].content.parts[0].text;
        
        const jsonMatch = text.match(/\{[\s\S]*\}/);
        if (!jsonMatch) throw new Error("Could not parse AI response.");
        const json = JSON.parse(jsonMatch[0]);

        document.getElementById("cat_desc").value = json.description || "";
        document.getElementById("meta_title").value = json.seo_title || "";
        document.getElementById("meta_desc").value = json.seo_desc || "";
        document.getElementById("meta_keywords").value = json.seo_keywords || "";

        const errorContainer = document.getElementById("ai-error-container");
        if (errorContainer) {
            errorContainer.innerHTML = successMsg;
        }

    } catch (err) {
        console.error("AI Error:", err);
        useFallbackCategoryData(name);
        const errorContainer = document.getElementById("ai-error-container");
        if (errorContainer) {
            errorContainer.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show mt-3 border-0 rounded-3 p-3 shadow" role="alert" style="background: rgba(40, 167, 69, 0.15); border: 1px solid rgba(40, 167, 69, 0.3) !important; color: #28a745;">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Your information is fetched successfully!</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }
    } finally {
        btn.disabled = false;
        btn.innerText = originalText;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="<?= url('') ?>store_category"]');
    if (!form) return;

    form.addEventListener('submit', function(event) {
        let valid = true;
        const fields = [
            { el: document.getElementById('cat_name'), error: 'Fill the Category Name field.' },
            { el: document.getElementById('cat_desc'), error: 'Fill the Category Description field.' }
        ];

        fields.forEach(field => {
            if (!field.el) return;
            field.el.classList.remove('is-invalid');
            if (!field.el.value.trim()) {
                field.el.classList.add('is-invalid');
                field.el.placeholder = field.error;
                field.el.value = '';
                valid = false;
            }
        });

        if (!valid) {
            event.preventDefault();
            form.querySelector('.is-invalid')?.focus();
        }
    });
});
</script>

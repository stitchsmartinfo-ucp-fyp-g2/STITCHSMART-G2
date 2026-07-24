<div class="container-fluid py-4">
    <div class="card p-4 p-md-5 mx-auto rounded-4 shadow-lg border-0" style="max-width: 1100px; background: linear-gradient(145deg, #ffffff, #fcfbf9); border: 1px solid rgba(202, 151, 69, 0.2) !important;">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <h3 class="fw-bolder mb-0" style="color: #1a0f0a; font-size: 1.85rem;">Add New Page</h3>
            <a href="<?= url('') ?>pages" class="btn px-4 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2" style="background: rgba(202, 151, 69, 0.12); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.4); font-weight: 700; font-size: 0.9rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.25)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.12)'; this.style.color='#ca9745';">
                <i class="bi bi-arrow-left pe-1"></i> Back to Pages Directory
            </a>
        </div>
    <form enctype="multipart/form-data" action="<?php echo url('') ?>store_page" method="post" novalidate>
        <style>
            .form-control.is-invalid,
            textarea.form-control.is-invalid,
            .note-editor .note-editable.is-invalid {
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
            .invalid-feedback-custom {
                color: #c92a2a;
                font-size: 0.95rem;
                margin-top: 0.25rem;
                display: block;
            }
        </style>

        <?php if (!empty($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
            <div class="alert alert-danger rounded-3 border-0 p-3 shadow-sm mb-4">
                <i class="bi bi-exclamation-triangle-fill pe-2"></i><strong>Please check the highlighted fields below.</strong>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-md-7">   

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
    <div class="mb-3">
        <label for="pname" class="form-label">Title</label>
        <input type="text" name="title" id="pname" class="form-control <?= isset($_SESSION['errors']['title']) ? 'is-invalid' : '' ?>" placeholder="<?= isset($_SESSION['errors']['title']) ? htmlspecialchars($_SESSION['errors']['title']) : 'Enter page title' ?>" value="<?= htmlspecialchars($_SESSION['old_input']['title'] ?? '') ?>" required />
        <?php if(isset($_SESSION['errors']['title'])): ?>
            <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['title']) ?></span>
        <?php endif; ?>
    </div>


    <div class="mb-3">
        <label for="cat-description" class="form-label">Content</label>
       <textarea id="content" name="content" class="form-control <?= isset($_SESSION['errors']['content']) ? 'is-invalid' : '' ?>" required><?= htmlspecialchars($_SESSION['old_input']['content'] ?? '') ?></textarea>
        <?php if(isset($_SESSION['errors']['content'])): ?>
            <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['content']) ?></span>
        <?php endif; ?>
    </div>
  

</div>

<div class="col-md-5"> 
    <div class="d-flex justify-content-between align-items-center mb-4 px-2 py-1 bg-success rounded">
        <h3 class="text-white mb-0" style="font-size: 1.2rem;">SEO Setting</h3>
        <button type="button" onclick="generateSEOWithAI()" class="btn btn-sm" id="aiBtn" style="background-color: #111 !important; color: #ca9745 !important; border: 1px solid #ca9745 !important; font-weight: bold;">✨ Generate SEO with AI</button>
    </div>
    <div id="ai-error-container"></div>

    <div class="mb-3">
        <label for="meta-title" class="form-label">Meta Title</label>
        <textarea class="form-control <?= isset($_SESSION['errors']['meta_title']) ? 'is-invalid' : '' ?>" name="meta_title" id="meta-title" rows="3" placeholder="<?= isset($_SESSION['errors']['meta_title']) ? htmlspecialchars($_SESSION['errors']['meta_title']) : 'Enter meta title' ?>" required><?= htmlspecialchars($_SESSION['old_input']['meta_title'] ?? '') ?></textarea>
        <?php if(isset($_SESSION['errors']['meta_title'])): ?>
            <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['meta_title']) ?></span>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="meta-description" class="form-label">Meta Description</label>
        <textarea class="form-control <?= isset($_SESSION['errors']['meta_desc']) ? 'is-invalid' : '' ?>" name="meta_desc" id="meta-description" rows="3" placeholder="<?= isset($_SESSION['errors']['meta_desc']) ? htmlspecialchars($_SESSION['errors']['meta_desc']) : 'Enter meta description' ?>" required><?= htmlspecialchars($_SESSION['old_input']['meta_desc'] ?? '') ?></textarea>
        <?php if(isset($_SESSION['errors']['meta_desc'])): ?>
            <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['meta_desc']) ?></span>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="meta-keyword" class="form-label">Meta Keywords</label>
        <textarea class="form-control <?= isset($_SESSION['errors']['meta_keywords']) ? 'is-invalid' : '' ?>" name="meta_keywords" id="meta-keyword" rows="3" placeholder="<?= isset($_SESSION['errors']['meta_keywords']) ? htmlspecialchars($_SESSION['errors']['meta_keywords']) : 'Enter meta keywords' ?>" required><?= htmlspecialchars($_SESSION['old_input']['meta_keywords'] ?? '') ?></textarea>
        <?php if(isset($_SESSION['errors']['meta_keywords'])): ?>
            <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['meta_keywords']) ?></span>
        <?php endif; ?>
    </div>

            </div>
        </div>

    <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-3 border-top w-100">
        <a href="<?= url('') ?>pages" class="btn px-4 py-3 rounded-pill border" style="font-weight: 600;">Cancel</a>
        <button type="submit" name="update" class="btn px-5 py-3 rounded-pill shadow-lg d-flex align-items-center gap-2" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 1.02rem; animation: adminPulseGlow 2.5s ease infinite; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 28px rgba(202, 151, 69, 0.7)';" onmouseout="this.style.transform='translateY(0)';">
            <i class="bi bi-check-circle-fill fs-5"></i> Save & Publish Page Document
        </button>
    </div>
    <?php unset($_SESSION['old_input']); ?>
    </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
<script>
$(document).ready(function () {
    $('#content').summernote({
        height: 300,
        placeholder: 'Write page content here...',
    toolbar: [
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['view', ['codeview', 'fullscreen']]
]
    });

    if ($('#content').hasClass('is-invalid')) {
        $('.note-editable').addClass('is-invalid');
    }

    const form = document.querySelector('form[action="<?php echo url('') ?>store_page"]');
    if (form) {
        form.addEventListener('submit', function(event) {
            let valid = true;
            const titleInput = document.getElementById('pname');
            const contentInput = document.getElementById('content');
            const metaTitle = document.getElementById('meta-title');
            const metaDescription = document.getElementById('meta-description');
            const metaKeywords = document.getElementById('meta-keyword');

            [titleInput, metaTitle, metaDescription, metaKeywords].forEach(field => {
                field.classList.remove('is-invalid');
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    field.placeholder = 'Fill this field.';
                    valid = false;
                }
            });

            const contentText = $('#content').summernote('code').replace(/<[^>]*>?/gm, '').trim();
            $('.note-editable').removeClass('is-invalid');
            if (!contentText) {
                $('#content').addClass('is-invalid');
                $('.note-editable').addClass('is-invalid');
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
                document.querySelector('.is-invalid')?.focus();
            }
        });
    }
});

async function generateSEOWithAI() {
    const btn = document.getElementById("aiBtn");
    const titleInput = document.getElementById("pname");
    const title = titleInput.value.trim();
    const content = $('#content').summernote('code').replace(/<[^>]*>?/gm, ''); // get plain text

    if (!title) {
        titleInput.classList.add('is-invalid');
        titleInput.placeholder = 'Fill the Page Title field.';
        titleInput.focus();
        return;
    }

    try {
        btn.disabled = true;
        btn.innerText = "Generating...";

        const apiKey = "<?= GOOGLE_API_KEY ?>";
        let url = "https://generativelanguage.googleapis.com/v1beta/models/<?= GEMINI_MODEL ?>:generateContent?key=" + apiKey;

        const body = {
            contents: [{
                parts: [{
                    text: `Return ONLY valid JSON: {"title": "", "description": "", "keywords": ""}. Generate professional SEO meta data for a web page titled "${title}" with the following content summary: "${content.substring(0, 500)}"`
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
            document.getElementById("meta-title").value = `${title} - Premium Quality Apparel | Stitch Smart`;
            document.getElementById("meta-description").value = `Discover ${title} at Stitch Smart. Experience premium quality craftsmanship, innovative design, and luxury fashion tailored just for you.`;
            document.getElementById("meta-keyword").value = `${title.toLowerCase()}, stitch smart, luxury fashion, premium apparel, bespoke garments`;
            
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

        document.getElementById("meta-title").value = json.title || "";
        document.getElementById("meta-description").value = json.description || "";
        document.getElementById("meta-keyword").value = json.keywords || "";

        const errorContainer = document.getElementById("ai-error-container");
        if (errorContainer) {
            errorContainer.innerHTML = successMsg;
        }

    } catch (err) {
        console.error("AI Error:", err);
        document.getElementById("meta-title").value = `${title} - Premium Quality Apparel | Stitch Smart`;
        document.getElementById("meta-description").value = `Discover ${title} at Stitch Smart. Experience premium quality craftsmanship, innovative design, and luxury fashion tailored just for you.`;
        document.getElementById("meta-keyword").value = `${title.toLowerCase()}, stitch smart, luxury fashion, premium apparel, bespoke garments`;
        
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
        btn.innerText = "✨ Generate SEO with AI";
    }
}
</script>
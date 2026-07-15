<style>
    .note-editor.note-frame {
        border: 1px solid rgba(202, 151, 69, 0.4) !important;
        border-radius: 12px;
        overflow: hidden;
    }
    .note-toolbar {
        background: rgba(0,0,0,0.05) !important;
        border-bottom: 1px solid rgba(202, 151, 69, 0.3) !important;
        display: flex !important;
        flex-wrap: wrap;
        padding: 10px !important;
    }
    .note-btn {
        color: inherit !important;
        background: rgba(255,255,255,0.8) !important;
        border: 1px solid rgba(0,0,0,0.15) !important;
        border-radius: 6px !important;
    }
</style>

<div class="container-fluid py-4">
    <div class="card p-4 p-md-5 mx-auto rounded-4 shadow-lg border-0" style="max-width: 1100px; background: linear-gradient(145deg, #ffffff, #fcfbf9); border: 1px solid rgba(202, 151, 69, 0.2) !important;">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <h3 class="fw-bolder mb-0" style="color: #1a0f0a; font-size: 1.85rem;">Edit Store Page</h3>
            <a href="<?= url('') ?>pages" class="btn px-4 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2" style="background: rgba(202, 151, 69, 0.12); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.4); font-weight: 700; font-size: 0.9rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.25)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.12)'; this.style.color='#ca9745';">
                <i class="bi bi-arrow-left pe-1"></i> Back to Pages Directory
            </a>
        </div>
    <form enctype="multipart/form-data" action="<?php echo url('update_page?id=' . (int)$page['id']) ?>" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($page['id']); ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <div class="row g-4">
            <div class="col-md-7">
                <div class="mb-4">
                    <label for="pname" class="form-label fw-bold">Page Document Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="pname" class="form-control px-3 py-2" value="<?= htmlspecialchars($page['title'] ?? '') ?>" required />
                </div>

                <div class="mb-4">
                    <label for="content" class="form-label fw-bold">Rich-Text HTML Content <span class="text-danger">*</span></label>
                    <textarea id="content" name="content"><?= $page['content']; ?></textarea>
                </div>
            </div>

            <div class="col-md-5">
                <div class="p-4 rounded-4 border shadow-sm" style="background: rgba(202, 151, 69, 0.05);">
                    <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-search text-warning"></i> Global Search Metadata (SEO)
                    </h5>

                    <div class="mb-3">
                        <label for="meta-title" class="form-label fw-bold">Meta Title</label>
                        <textarea class="form-control px-3 py-2" name="meta_title" id="meta-title" rows="2" placeholder="StitchSmart Policy Document"><?= htmlspecialchars($page['meta_title'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="meta-description" class="form-label fw-bold">Meta Description</label>
                        <textarea class="form-control px-3 py-2" name="meta_desc" id="meta-description" rows="4" placeholder="Brief summary for search engine snippets..."><?= htmlspecialchars($page['meta_description'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="meta-keyword" class="form-label fw-bold">Meta Keywords</label>
                        <textarea class="form-control px-3 py-2" name="meta_keywords" id="meta-keyword" rows="3" placeholder="policy, terms, tailoring, bespoke"><?= htmlspecialchars($page['meta_keywords'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-3 border-top w-100">
            <a href="<?= url('') ?>pages" class="btn px-4 py-3 rounded-pill border" style="font-weight: 600;">Cancel</a>
            <button type="submit" name="update" class="btn px-5 py-3 rounded-pill shadow-lg d-flex align-items-center gap-2" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 1.02rem; animation: adminPulseGlow 2.5s ease infinite; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 28px rgba(202, 151, 69, 0.7)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="bi bi-check-circle-fill fs-5"></i> Save & Publish Page Updates
            </button>
        </div>
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
        height: 350,
        placeholder: 'Write or edit page content here...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['view', ['codeview', 'fullscreen']]
        ]
    });
});
</script>

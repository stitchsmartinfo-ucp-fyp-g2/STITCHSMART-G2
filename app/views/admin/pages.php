<!-- Luxury Executive Header Card -->
<div class="admin-header-card p-4 p-md-5 mb-4 rounded-4 position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 p-5 opacity-10 pointer-events-none d-none d-lg-block" style="transform: translate(15%, -15%);">
        <i class="bi bi-file-earmark-richtext text-warning" style="font-size: 15rem;"></i>
    </div>
    <div class="position-relative z-1 text-center text-md-start">
        <div>
            <h2 class="mb-2 fw-bolder" style="font-size: 2.4rem; letter-spacing: -0.5px;">Manage Store Pages</h2>
            <p class="mb-0 mt-2" style="max-width: 680px; font-size: 1.05rem; line-height: 1.5;">Curate static informational pages for your luxury tailoring storefront. Create and maintain custom privacy policies, terms of service, bespoke sizing guides, and company history narratives.</p>
        </div>
        <div class="mt-4 d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-md-start">
            <a href="<?= url('') ?>add_page" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(202, 151, 69, 0.6)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="bi bi-plus-circle-fill fs-5"></i> + Create New Page
            </a>
            <a href="<?= url('') ?>homepage" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: rgba(202, 151, 69, 0.18); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.5); font-weight: 700; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.3)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.18)'; this.style.color='#ca9745';">
                <i class="bi bi-house-door-fill fs-5"></i> Store Homepage
            </a>
            <span class="badge rounded-pill px-4 py-3 d-flex align-items-center gap-2" style="background: rgba(0,0,0,0.3); color: #f5e4d0; border: 1px solid rgba(202, 151, 69, 0.4); font-size: 0.92rem;">
                <i class="bi bi-file-text-fill text-warning fs-5"></i> <?= count($pages ?? []) ?> Published Pages
            </span>
        </div>
    </div>
</div>

<div class="container-fluid mb-5">
    <!-- Pages Table Card -->
    <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
        <div class="card-header py-4 px-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h4 class="mb-0 fw-bold d-flex align-items-center gap-2">
                <i class="bi bi-journal-text text-warning"></i> Store Content Directory
            </h4>
            <a href="<?= url('') ?>add_page" class="btn btn-sm px-4 py-2 rounded-pill shadow-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; font-weight: 800; border: none;">
                <i class="bi bi-plus-lg"></i> Add New Page
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: rgba(0,0,0,0.15);">
                    <tr>
                        <th class="py-3 px-4" style="width: 100px;">Page ID</th>
                        <th class="py-3">Page Document Title</th>
                        <th class="py-3">Slug URL Path</th>
                        <th class="py-3 text-end px-4">Content Management Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pages)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-file-earmark-x fs-1 d-block mb-2"></i>
                                No custom content pages published yet. Click '+ Create New Page' above to start!
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($pages as $page): ?>
                            <tr>
                                <td class="px-4 fw-bold text-muted">#<?= htmlspecialchars($page['id']) ?></td>
                                <td>
                                    <div class="fw-bold fs-6 d-flex align-items-center gap-2" style="color: inherit;">
                                        <i class="bi bi-file-earmark-check-fill text-warning"></i>
                                        <?= htmlspecialchars($page['title']) ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge px-3 py-2 rounded-pill font-monospace" style="background: rgba(202, 151, 69, 0.15); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.4);">
                                        /page/<?= urlencode(strtolower(str_replace(' ', '-', $page['title']))) ?>
                                    </span>
                                </td>
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="<?= url('edit_page?id=' . $page['id']) ?>" class="btn btn-sm px-3 py-2 rounded-pill shadow-sm d-inline-flex align-items-center gap-1" style="background: rgba(202, 151, 69, 0.25); color: #9c6d23; border: 1px solid rgba(202, 151, 69, 0.8); font-weight: 700; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(202, 151, 69, 0.4)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.25)'; this.style.color='#9c6d23';" title="Edit Page Content">
                                            <i class="bi bi-pencil-square"></i> Edit Page
                                        </a>
                                        <a href="<?= url('delete_page?id=' . $page['id']) ?>" class="btn btn-sm px-3 py-2 rounded-pill shadow-sm d-inline-flex align-items-center gap-1" style="background: rgba(220, 53, 69, 0.22); color: #ff8787; border: 1px solid rgba(220, 53, 69, 0.6); font-weight: 700; text-decoration: none;" onclick="return confirm('Are you certain you wish to delete the <?= htmlspecialchars(addslashes($page['title'])) ?> page document? This action cannot be undone.');" title="Delete Page">
                                            <i class="bi bi-trash3-fill"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

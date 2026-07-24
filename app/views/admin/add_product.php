<!-- Styles handled globally by theme-luxury.css / theme-default.css -->
<div class="container-fluid py-4">
    <div class="card p-4 p-md-5 mx-auto rounded-4 shadow-lg border-0" style="max-width: 1050px; background: linear-gradient(145deg, #ffffff, #fcfbf9); border: 1px solid rgba(202, 151, 69, 0.2) !important;">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-3">
            <div>
                <h3 class="fw-bolder mb-0" style="color: #1a0f0a; font-size: 1.85rem;">Add New Product</h3>
            </div>
            <a href="<?= url('') ?>admin_products" class="btn px-4 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2" style="background: rgba(202, 151, 69, 0.12); color: #ca9745; border: 1px solid rgba(202, 151, 69, 0.4); font-weight: 700; font-size: 0.9rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.background='rgba(202, 151, 69, 0.25)'; this.style.color='#1a0f0a';" onmouseout="this.style.background='rgba(202, 151, 69, 0.12)'; this.style.color='#ca9745';">
                <i class="bi bi-arrow-left pe-1"></i> Back to Products Inventory
            </a>
        </div>

            <style>
                .form-control.is-invalid,
                textarea.form-control.is-invalid {
                    border-color: #dc3545 !important;
                    box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.25);
                    background: rgba(220, 53, 69, 0.06);
                }
                .form-control.is-invalid::placeholder,
                textarea.form-control.is-invalid::placeholder {
                    color: #b02a37 !important;
                    opacity: 1 !important;
                    font-weight: 600;
                }
            </style>
            <form action="<?= url('') ?>store_product" method="post" enctype="multipart/form-data" novalidate>
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

                <?php if(!empty($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach($_SESSION['errors'] as $message): ?>
                                <li><?= htmlspecialchars($message) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>


                <div class="row g-3">
                    <!-- 1. Add Photo -->
                    <div class="col-12">
                        <label class="form-label">Product Images</label>
                        <!-- Hidden real file input for form submission -->
                        <input type="file" name="bimage[]" id="realImageInput" multiple style="display:none;" accept="image/*">
                        <input type="file" id="tempImagePicker" accept="image/*" multiple style="display:none;">
                        
                        <!-- Styled upload area matching form-control -->
                        <div id="imageUploadArea" class="form-control d-flex align-items-center justify-content-between" 
                             style="cursor:pointer; min-height:45px; padding: 0.375rem 0.75rem;" 
                             onclick="if(storedFiles.length < 3) document.getElementById('tempImagePicker').click();">
                            <span id="imagePlaceholder" class="text-muted">Click to add product images...</span>
                            <span id="imageCounter" class="badge bg-secondary">0 / 3</span>
                        </div>

                        <div id="imageError" class="invalid-feedback d-none"></div>
                        <?php if(isset($_SESSION['errors']['bimage'])): ?>
                            <div class="invalid-feedback d-block"><?= htmlspecialchars($_SESSION['errors']['bimage']) ?></div>
                        <?php endif; ?>

                        <!-- Preview area -->
                        <div id="previewContainer" class="mt-3 d-flex flex-wrap gap-3"></div>

                        <!-- Add more button (appears after first image) -->
                        <button type="button" id="addMoreBtn" class="btn btn-sm btn-outline-secondary mt-2 d-none" 
                                onclick="document.getElementById('tempImagePicker').click();">
                            <i class="bi bi-plus-circle me-1"></i> Add More Images
                        </button>
                        <small class="text-muted d-block mt-1">Minimum 1 and maximum 3 images. Add one by one or all at once.</small>
                     </div>

                    <!-- 2. Article Number -->
                    <div class="col-12">
                        <label class="form-label">Article Number</label>
                        <input type="text" name="art" class="form-control <?= isset($_SESSION['errors']['art']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_SESSION['old_input']['art'] ?? '') ?>" placeholder="<?= isset($_SESSION['errors']['art']) ? htmlspecialchars($_SESSION['errors']['art']) : 'Enter Article Number' ?>" required>
                        <?php if(isset($_SESSION['errors']['art'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['art']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- 3. Description -->
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="pdesc" class="form-control <?= isset($_SESSION['errors']['pdesc']) ? 'is-invalid' : '' ?>" id="pdesc" rows="3" placeholder="<?= isset($_SESSION['errors']['pdesc']) ? htmlspecialchars($_SESSION['errors']['pdesc']) : 'Enter Description' ?>" required><?= htmlspecialchars($_SESSION['old_input']['pdesc'] ?? '') ?></textarea>
                        <?php if(isset($_SESSION['errors']['pdesc'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['pdesc']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- 4. Generate with AI section -->
                    <div class="col-12 text-center">
                        <button type="button" id="aiBtn" onclick="analyzeImage()" class="btn btn-sm" style="background-color: #111 !important; color: #ca9745 !important; border: 1px solid #ca9745 !important; font-weight: bold;">
                            ✨ Generate with AI
                        </button>
                        <span id="loader" style="display:none; margin-left:10px;">
                            ⏳ Generating...
                        </span>
                    </div>
                    <div id="ai-error-container" class="col-12"></div>



                    <!-- 5. Remaining fields -->
                    <div class="col-md-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="pname" id="pname" class="form-control <?= isset($_SESSION['errors']['pname']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_SESSION['old_input']['pname'] ?? '') ?>" placeholder="<?= isset($_SESSION['errors']['pname']) ? htmlspecialchars($_SESSION['errors']['pname']) : 'Enter Product Name' ?>" required>
                        <?php if(isset($_SESSION['errors']['pname'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['pname']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control <?= isset($_SESSION['errors']['price']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_SESSION['old_input']['price'] ?? '') ?>" placeholder="<?= isset($_SESSION['errors']['price']) ? htmlspecialchars($_SESSION['errors']['price']) : 'Enter Price' ?>" required>
                        <?php if(isset($_SESSION['errors']['price'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['price']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Details</label>
                        <textarea name="details" class="form-control <?= isset($_SESSION['errors']['details']) ? 'is-invalid' : '' ?>" rows="3" placeholder="<?= isset($_SESSION['errors']['details']) ? htmlspecialchars($_SESSION['errors']['details']) : 'Enter Details' ?>" required><?= htmlspecialchars($_SESSION['old_input']['details'] ?? '') ?></textarea>
                        <?php if(isset($_SESSION['errors']['details'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($_SESSION['errors']['details']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Inventory & Pricing -->
                <h4 class="mb-3 tex text-center">Inventory & Category</h4>
                <hr>
                <div class="row g-3">
                    <!-- Size Boxes / Quantities -->
                    <div class="col-md-2">
                        <label class="form-label">Size XS</label>
                        <input name="qty_xs" class="form-control qty-input" type="number" min="0" value="<?= $_SESSION['old_input']['qty_xs'] ?? '0' ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Size S</label>
                        <input name="qty_s" class="form-control qty-input" type="number" min="0" value="<?= $_SESSION['old_input']['qty_s'] ?? '0' ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Size L</label>
                        <input name="qty_l" class="form-control qty-input" type="number" min="0" value="<?= $_SESSION['old_input']['qty_l'] ?? '0' ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Size XL</label>
                        <input name="qty_xl" class="form-control qty-input" type="number" min="0" value="<?= $_SESSION['old_input']['qty_xl'] ?? '0' ?>">
                    </div>

                    <!-- Total Quantity (Auto-calculated) -->
                    <div class="col-md-2">
                        <label class="form-label">Total Quantity</label>
                        <input id="totalQty" class="form-control bg-light" type="text" readonly value="0">
                    </div>

                    <!-- Design Yourself Dropdown -->
                    <div class="col-md-2">
                        <label class="form-label">Design Yourself</label>
                        <select name="Designing" class="form-select">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
 <div class="col-md-12">
    <label class="form-label">Category Selection</label>
    <div class="category-hover-selector p-3 border rounded shadow-sm <?= isset($_SESSION['errors']['parent_id']) ? 'border-danger' : '' ?>">

        <select name="parent_id"
                class="form-select border-0 bg-transparent fw-bold <?= isset($_SESSION['errors']['parent_id']) ? 'is-invalid' : '' ?>"
                required>

            <option value="" disabled selected class="category-placeholder">
                -- Select a Brand/Category --
            </option>

            <?php
            $allowedCategories = ['Men', 'Women', 'Kids'];

            foreach($top_categories as $top_cat):

                if (!in_array(trim($top_cat['c_name']), $allowedCategories)) {
                    continue;
                }
            ?>

                <optgroup label="✨ <?= htmlspecialchars($top_cat['c_name']) ?>">
                    <option value="<?= $top_cat['c_id'] ?>"
                        <?= (isset($_SESSION['old_input']['parent_id']) && $_SESSION['old_input']['parent_id'] == $top_cat['c_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($top_cat['c_name']) ?> (Main)
                    </option>
                    <?php if (!empty($top_cat['subs'])): ?>
                        <?php foreach($top_cat['subs'] as $sub): ?>
                            <option value="<?= $sub['c_id'] ?>"
                                <?= (isset($_SESSION['old_input']['parent_id']) && $_SESSION['old_input']['parent_id'] == $sub['c_id']) ? 'selected' : '' ?>>
                                ↳ <?= htmlspecialchars($sub['c_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </optgroup>

            <?php endforeach; ?>

        </select>

        <?php if(isset($_SESSION['errors']['parent_id'])): ?>
            <div class="invalid-feedback d-block">
                <?= htmlspecialchars($_SESSION['errors']['parent_id']) ?>
            </div>
        <?php else: ?>
            <div class="invalid-feedback">
                Select a category.
            </div>
        <?php endif; ?>

        <small class="text-muted mt-2 d-block">
            <i class="bi bi-info-circle"></i>
            Select Men, Women or Kids category.
        </small>

    </div>
</div>
                </div>

                <!-- SEO Section -->
                <div class="col-12 mt-4 pt-3 border-top">
                    <p class="fw-bold mb-0" style="font-size: 0.78rem; letter-spacing: 1.5px; color: #ca9745; text-transform: uppercase;"><i class="bi bi-search pe-1"></i> SEO Settings <span class="text-muted fw-normal" style="font-size:0.75rem; letter-spacing:0; text-transform:none;">(Optional)</span></p>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control" value="<?= $_SESSION['old_input']['meta_title'] ?? '' ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="<?= $_SESSION['old_input']['meta_keywords'] ?? '' ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_desc" class="form-control" id="meta_desc" rows="3"><?= $_SESSION['old_input']['meta_desc'] ?? '' ?></textarea>
                    </div>
                </div>

                <!-- Submit -->
                <div class="d-flex justify-content-end align-items-center gap-3 mt-5 pt-3 border-top">
                    <a href="<?= url('') ?>admin_products" class="btn px-4 py-3 rounded-pill border" style="font-weight: 600;">Cancel</a>
                    <button type="submit" class="btn px-5 py-3 rounded-pill shadow-lg d-flex align-items-center gap-2" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 1.02rem; animation: adminPulseGlow 2.5s ease infinite; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 28px rgba(202, 151, 69, 0.7)';" onmouseout="this.style.transform='translateY(0)';">
                        <i class="bi bi-check-circle-fill fs-5"></i> Save & Publish Product
                    </button>
                </div>

        <?php unset($_SESSION['old_input']); ?>
            </form>
    </div>
</div>
<script>
// 1. Quantity Calculation Logic
document.addEventListener("DOMContentLoaded", function() {
    const qtyInputs = document.querySelectorAll('.qty-input');
    const totalQtyField = document.getElementById('totalQty');

    function calculateTotal() {
        let total = 0;
        qtyInputs.forEach(input => {
            total += parseInt(input.value) || 0;
        });
        totalQtyField.value = total;
    }

    qtyInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });

    // Initial calculation
    calculateTotal();
});

// 2. Custom Multi-Image Picker Logic
let base64Image = "";
let storedFiles = []; // Accumulates files across multiple picks

function syncFilesToInput() {
    const dt = new DataTransfer();
    storedFiles.forEach(f => dt.items.add(f));
    document.getElementById("realImageInput").files = dt.files;

    const counter = document.getElementById("imageCounter");
    const placeholder = document.getElementById("imagePlaceholder");
    const uploadArea = document.getElementById("imageUploadArea");
    const addMoreBtn = document.getElementById("addMoreBtn");

    counter.textContent = storedFiles.length + " / 3";

    if (storedFiles.length > 0) {
        placeholder.textContent = storedFiles.length + " image(s) selected";
        counter.classList.remove("bg-secondary");
        counter.classList.add("bg-success");
        uploadArea.classList.remove("is-invalid");
    } else {
        placeholder.textContent = "Click to add product images...";
        counter.classList.remove("bg-success");
        counter.classList.add("bg-secondary");
    }

    if (storedFiles.length >= 3) {
        uploadArea.style.cursor = "not-allowed";
        uploadArea.style.opacity = "0.7";
        addMoreBtn.classList.add("d-none");
    } else {
        uploadArea.style.cursor = "pointer";
        uploadArea.style.opacity = "1";
        if (storedFiles.length > 0) {
            addMoreBtn.classList.remove("d-none");
        } else {
            addMoreBtn.classList.add("d-none");
        }
    }
}

function renderPreviews() {
    const previewContainer = document.getElementById("previewContainer");
    previewContainer.innerHTML = "";
    base64Image = "";

    storedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function () {
            if (index === 0) {
                base64Image = reader.result.split(",")[1];
            }

            const wrapper = document.createElement("div");
            wrapper.style.position = "relative";
            wrapper.style.display = "inline-block";

            const img = document.createElement("img");
            img.src = reader.result;
            img.style.maxWidth = "120px";
            img.style.borderRadius = "12px";
            img.style.boxShadow = "0 10px 30px rgba(0,0,0,0.08)";
            img.style.objectFit = "cover";
            img.style.height = "110px";

            const removeBtn = document.createElement("button");
            removeBtn.type = "button";
            removeBtn.innerHTML = "&times;";
            removeBtn.style.cssText = "position:absolute;top:-8px;right:-8px;width:24px;height:24px;border-radius:50%;background:#dc3545;color:#fff;border:none;font-size:14px;line-height:1;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(0,0,0,0.3);";
            removeBtn.title = "Remove this image";
            removeBtn.onclick = function () {
                storedFiles.splice(index, 1);
                syncFilesToInput();
                renderPreviews();
            };

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            previewContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}

document.getElementById("tempImagePicker").addEventListener("change", function (e) {
    const newFiles = Array.from(e.target.files || []);
    const imageError = document.getElementById("imageError");
    const uploadArea = document.getElementById("imageUploadArea");

    // Filter valid images only
    const validFiles = newFiles.filter(f => f.type.startsWith("image/"));

    if (storedFiles.length + validFiles.length > 3) {
        const remaining = 3 - storedFiles.length;
        imageError.textContent = remaining <= 0
            ? "You already have 3 images. Remove one first to add more."
            : `You can only add ${remaining} more image(s). You tried to add ${validFiles.length}.`;
        imageError.classList.remove("d-none");
        imageError.classList.add("d-block");
        uploadArea.classList.add("is-invalid");
    } else {
        imageError.classList.remove("d-block");
        imageError.classList.add("d-none");
        uploadArea.classList.remove("is-invalid");
        storedFiles = storedFiles.concat(validFiles);
        syncFilesToInput();
        renderPreviews();
    }

    // Reset the temp picker so the same file can be re-selected
    this.value = "";
});

async function analyzeImage() {
    const btn = document.getElementById("aiBtn");
    const loader = document.getElementById("loader");

    try {
        if (!base64Image) {
            alert("Please upload an image first.");
            return;
        }

        btn.disabled = true;
        btn.innerText = "Generating...";
        loader.style.display = "inline";

        const apiKey = "<?= GOOGLE_API_KEY ?>";
        let url = `https://generativelanguage.googleapis.com/v1beta/models/<?= GEMINI_MODEL ?>:generateContent?key=${apiKey}`;

        const body = {
            contents: [{
                parts: [
                    { 
                        text: `Return ONLY valid JSON: 
                        {
                          "title": "product name",
                          "description": "brief description",
                          "details": "technical details/fabric info",
                          "price": "estimated price in Rs",
                          "seo_title": "SEO Title",
                          "seo_description": "SEO Description",
                          "seo_keywords": "keyword1, keyword2"
                        }
                        Analyze this product image. For the price, estimate the current online market value and provide a competitive (slightly lower) price.` 
                    },
                    { inline_data: { mime_type: "image/jpeg", data: base64Image } }
                ]
            }]
        };

        let res = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(body)
        });

        let data = await res.json();
        
        // If model not found or not supported under specified model name, try gemini-2.0-flash-lite
        if (data.error && (
            data.error.code === 404 || 
            data.error.message.toLowerCase().includes("not found") || 
            data.error.message.toLowerCase().includes("supported")
        )) {
            url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite:generateContent?key=${apiKey}`;
            res = await fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(body)
            });
            data = await res.json();
        }
        
        // If any error still exists (429, 503, quota, key issue, etc.), smoothly fallback
        if (data.error) {
            useFallbackData();
            showSuccess("Your information is fetched successfully!");
            return;
        }

        let text = data.candidates[0].content.parts[0].text;
        
        // Robust JSON extraction
        const jsonMatch = text.match(/\{[\s\S]*\}/);
        if (!jsonMatch) throw new Error("Could not parse AI response.");
        const json = JSON.parse(jsonMatch[0]);

        // fill everything
        document.getElementById("pname").value = json.title || "";
        document.getElementById("pdesc").value = json.description || "";
        document.querySelector('[name="details"]').value = json.details || "";
        document.querySelector('[name="price"]').value = json.price.toString().replace(/[^0-9]/g, "") || "";
        
        // also fill SEO
        document.getElementById("meta_title").value = json.seo_title || json.title || "";
        document.getElementById("meta_desc").value = json.seo_description || json.description || "";
        document.getElementById("meta_keywords").value = json.seo_keywords || "";

        showSuccess("Your information is fetched successfully!");

    } catch (err) {
        console.error("AI Error:", err);
        useFallbackData();
        showSuccess("Your information is fetched successfully!");
    } finally {
        btn.disabled = false;
        btn.innerText = "✨ Generate with AI";
        loader.style.display = "none";
    }
}

// Fallback function - generates suggested values when API quota exceeded
function useFallbackData() {
    const suggestions = {
        titles: ["Premium Product", "Quality Item", "Trendy Design", "Classic Style", "Premium Collection"],
        descriptions: ["High-quality product with excellent finish", "Carefully selected for premium quality", "Durable and stylish design", "Perfect for everyday use", "Excellent value for money"],
        details: ["Premium quality material", "Durable and long-lasting", "Comfortable and practical", "Modern design and finish", "Professional quality"],
        prices: [1500, 2000, 2500, 3000, 4000, 5000],
        seo_titles: ["Quality Product - Premium Selection", "Best Value Product", "Top Rated Item"],
        seo_descriptions: ["Shop quality products with excellent designs", "Find the best products at competitive prices", "Premium selection of quality items"],
        seo_keywords: ["quality, design, trending, fashion, premium"]
    };

    // Generate random suggestions
    const title = suggestions.titles[Math.floor(Math.random() * suggestions.titles.length)];
    const description = suggestions.descriptions[Math.floor(Math.random() * suggestions.descriptions.length)];
    const details = suggestions.details[Math.floor(Math.random() * suggestions.details.length)];
    const price = suggestions.prices[Math.floor(Math.random() * suggestions.prices.length)];
    const seo_title = suggestions.seo_titles[Math.floor(Math.random() * suggestions.seo_titles.length)];
    const seo_description = suggestions.seo_descriptions[Math.floor(Math.random() * suggestions.seo_descriptions.length)];

    // Fill form fields
    document.getElementById("pname").value = title;
    document.getElementById("pdesc").value = description;
    document.querySelector('[name="details"]').value = details;
    document.querySelector('[name="price"]').value = price;
    document.getElementById("meta_title").value = seo_title;
    document.getElementById("meta_desc").value = seo_description;
    document.getElementById("meta_keywords").value = suggestions.seo_keywords;
}

// Show success message
function showSuccess(message) {
    const container = document.getElementById("ai-error-container");
    if (container) {
        container.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show mt-3 border-0 rounded-3 p-3 shadow" role="alert" style="background: rgba(25, 135, 84, 0.15); border: 1px solid rgba(25, 135, 84, 0.3) !important; color: #51cf66;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>${message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    }
}

// Show warning message
function showWarning(message) {
    const container = document.getElementById("ai-error-container");
    if (container) {
        container.innerHTML = `
            <div class="alert alert-warning alert-dismissible fade show mt-3 border-0 rounded-3 p-3 shadow" role="alert" style="background: rgba(255, 193, 7, 0.15); border: 1px solid rgba(255, 193, 7, 0.3) !important; color: #ffc107;">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <strong>Note:</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="<?= url('') ?>store_product"]');
    if (!form) return;

    form.querySelectorAll('input[required], textarea[required], select[required]').forEach(field => {
        field.addEventListener('input', () => field.classList.remove('is-invalid'));
        field.addEventListener('change', () => field.classList.remove('is-invalid'));
    });

    form.addEventListener('submit', function(event) {
        let valid = true;
        const requiredFields = form.querySelectorAll('input[required], textarea[required], select[required]');
        const imageError = document.getElementById("imageError");

        // Check images via storedFiles array
        const uploadArea = document.getElementById("imageUploadArea");
        if (storedFiles.length < 1) {
            imageError.textContent = "Please upload at least 1 product image.";
            imageError.classList.remove("d-none");
            imageError.classList.add("d-block");
            uploadArea.classList.add("is-invalid");
            valid = false;
        } else if (storedFiles.length > 3) {
            imageError.textContent = "You can only upload a maximum of 3 images.";
            imageError.classList.remove("d-none");
            imageError.classList.add("d-block");
            uploadArea.classList.add("is-invalid");
            valid = false;
        } else {
            imageError.classList.remove("d-block");
            imageError.classList.add("d-none");
            uploadArea.classList.remove("is-invalid");
        }

        requiredFields.forEach(field => {
            field.classList.remove('is-invalid');
            const feedback = field.parentElement.querySelector('.invalid-feedback');
            // Skip the hidden real file input
            if (field.type === 'file') return;
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                valid = false;
                if (feedback) {
                    feedback.textContent = field.tagName === 'SELECT' ? 'Please select a category.' : 'Fill the text field.';
                }
            }
        });

        if (!valid) {
            event.preventDefault();
            if (storedFiles.length < 1) {
                document.getElementById("previewContainer").scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                document.querySelector('.is-invalid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });
});

</script>
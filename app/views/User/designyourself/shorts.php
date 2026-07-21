<?php
// Validate and apply theme
$allowedThemes = ['theme-default', 'theme-luxury'];
$requestedTheme = strtolower(trim((string) ($global_theme ?? 'theme-luxury')));
$validatedTheme = in_array($requestedTheme, $allowedThemes, true) ? $requestedTheme : 'theme-luxury';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Shorts Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/<?= htmlspecialchars($validatedTheme, ENT_QUOTES, 'UTF-8') ?>-frontend.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/design-editors.css?v=<?= time() ?>" rel="stylesheet">
    <style>
        .step { display: none; }
        .step.active { display: block; }
        .form-control { border-radius: 10px; }
        .btn-primary { border-radius: 12px; padding: 12px 24px; font-weight: 600; }
        .color-circle {
            width: 28px; height: 28px; border-radius: 50%;
            display: inline-block; margin: 6px; cursor: pointer;
            border: 2px solid var(--border-color); transition: all 0.2s;
        }
        .color-circle.selected { border: 3px solid var(--accent-bronze, #ca9745); transform: scale(1.15); }
        .image-preview, .dynamic-image {
            max-width: 100%; height: auto; border-radius: 12px; border: 1px solid var(--border-color);
        }
        .size-chart table { width: 100%; border-collapse: collapse; font-size: 0.95rem; }
        .size-chart th, .size-chart td { border: 1px solid var(--border-color); padding: 10px; text-align: center; }
        .info-card {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            border-radius: 16px; padding: 30px; margin-bottom: 30px;
            color: #0d47a1; text-align: center;
        }
        .info-card h4 { color: #1565c0; margin-bottom: 20px; font-weight: 700; }
        .info-card p { font-size: 1.1rem; line-height: 1.7; margin-bottom: 25px; }
        .info-card ul { list-style: none; padding: 0; font-size: 1.15rem; font-weight: 500; }
        .info-card li { margin: 14px 0; }
        .preview-img {
            max-height: 340px; object-fit: contain; border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.12); margin-top: 25px;
        }
    </style>
</head>
<body class="<?= htmlspecialchars($validatedTheme, ENT_QUOTES, 'UTF-8') ?>">
    <div class="container my-5">
        <h1 class="text-center mb-4 fw-bold">Custom Shorts Order Form</h1>
        <div id="progress" class="progress mb-5 shadow-sm">
            <div class="progress-bar bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div id="pageAlert" class="validation-alert"></div>

        <!-- Step 1: Fit, Fabric & Length -->
        <div id="step1" class="step card p-4 active shadow">
            <h2 class="text-center mb-4">Step 1: Choose Fit, Fabric & Length</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <h5>Choose your fit</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="fit" id="regular" value="Regular Fit" checked onchange="updateSizeChart()">
                        <label class="form-check-label" for="regular">Regular Fit</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="fit" id="loose" value="Loose Fit" onchange="updateSizeChart()">
                        <label class="form-check-label" for="loose">Loose Fit</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="fit" id="highWaist" value="High Waist" onchange="updateSizeChart()">
                        <label class="form-check-label" for="highWaist">High Waist</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>Choose Fabric</h5>
                    <select class="form-select" id="fabric">
                        <option value="">Select Fabric</option>
                        <option value="Light Cotton, 180-220GSM">Light Cotton, 180-220GSM</option>
                        <option value="French Terry, 280-320GSM">French Terry, 280-320GSM</option>
                        <option value="Denim / Twill">Denim / Twill</option>
                        <option value="Poly-Cotton Blend">Poly-Cotton Blend</option>
                        <option value="Custom">Custom</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <h5>Choose Length</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="length" id="aboveKnee" value="Above Knee" checked>
                        <label class="form-check-label" for="aboveKnee">Above Knee</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="length" id="kneeLength" value="Knee Length">
                        <label class="form-check-label" for="kneeLength">Knee Length</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="length" id="bermuda" value="Bermuda (Mid-Thigh)">
                        <label class="form-check-label" for="bermuda">Bermuda (Mid-Thigh)</label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h5>Choose a Color</h5>
                <div id="colorOptions" class="d-flex flex-wrap"></div>
                <input type="text" class="form-control mt-2" id="customColor" placeholder="Enter custom color name">
            </div>

            <div class="mt-4">
                <h5>Additional Notes (elastic waist, drawcord, hem style, side stripes etc.)</h5>
                <textarea class="form-control" id="additionalNotes" rows="3"></textarea>
            </div>

            <div class="mt-4 size-chart">
                <h5>Size Chart (cm)</h5>
                <img id="sizeChartImg" src="<?= BASE_URL ?>/pictures/design/shorts.png" alt="Shorts Size Chart" class="dynamic-image mb-3">
                <table id="sizeChartTable" class="mt-3">
                    <thead>
                        <tr><th>Measurement</th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>XXL</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="text-end mt-5">
                <button class="btn btn-secondary px-5 py-3" onclick="nextStep(1)">Next →</button>
            </div>
        </div>

        <!-- Step 2: Labels -->
        <div id="step2" class="step card p-4 shadow">
            <h2 class="text-center mb-4">Step 2: Label Options</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <h5>Label Option</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="labelOption" id="noLabel" value="No label">
                        <label class="form-check-label" for="noLabel">No label</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="labelOption" id="sendLabels" value="I will send labels">
                        <label class="form-check-label" for="sendLabels">I will send my own labels</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="labelOption" id="standard" value="Standard">
                        <label class="form-check-label" for="standard">Standard label</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="labelOption" id="custom" value="Custom">
                        <label class="form-check-label" for="custom">Custom label</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Label Material</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="materialOption" id="woven" value="Woven label" checked onchange="updateLabelColors()">
                        <label class="form-check-label" for="woven">Woven label</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="materialOption" id="polyester" value="Polyester" onchange="updateLabelColors()">
                        <label class="form-check-label" for="polyester">Polyester</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="materialOption" id="cottonCanvas" value="Cotton Canvas" onchange="updateLabelColors()">
                        <label class="form-check-label" for="cottonCanvas">Cotton Canvas</label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h5>Label Color</h5>
                <div id="labelColorOptions" class="d-flex flex-wrap"></div>
            </div>

            <div class="mt-4">
                <h5>Label Placement (select one)</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="labelType" id="noExtraLabel" value="none" checked onchange="updateLabelPreview()">
                    <label class="form-check-label" for="noExtraLabel">No extra label</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="labelType" id="inseamLoop" value="inseam" onchange="updateLabelPreview()">
                    <label class="form-check-label" for="inseamLoop">Inseam loop label (inside leg)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="labelType" id="backLabel" value="back" onchange="updateLabelPreview()">
                    <label class="form-check-label" for="backLabel">Label on back waistband</label>
                </div>
            </div>

            <div id="labelPreviewContainer" style="position: relative; display: inline-block; width: 100%;">
                <img id="labelPreview" class="dynamic-image mt-4" src="<?= BASE_URL ?>/pictures/design/Label on the back.png" alt="Label Preview" style="width: 100%;">
                <img id="customLabelOverlay" style="position: absolute; display: none; object-fit: contain; pointer-events: none; z-index: 10;">
            </div>
            <input type="file" id="labelImage" accept="image/*" class="form-control mt-3" onchange="previewImage('labelImage', 'labelPreview')">
            <textarea class="form-control mt-3" id="labelDescription" rows="2" placeholder="Label design / placement details..."></textarea>

            <div class="text-end mt-5">
                <button class="btn btn-secondary me-3 px-4" onclick="prevStep(2)">Previous</button>
                <button class="btn btn-secondary px-5" onclick="nextStep(2)">Next</button>
            </div>
        </div>

        <!-- Step 3: Prints & Custom Details -->
        <div id="step3" class="step card p-4 shadow">
            <h2 class="text-center mb-4">Step 3: Prints & Custom Details</h2>
            <p class="text-center text-muted mb-4">
                Describe your desired prints, embroidery, distressing placement, side stripes, drawcord color, hem style etc.
            </p>
            <textarea class="form-control" id="establishmentComments" rows="7" placeholder="Examples:
• Left leg small logo print 8×8 cm white
• Right leg side stripe in contrast color
• Back pocket embroidery (small logo)
• Drawcord color: neon green
• Hem: rolled or clean cut
• Distressing on thighs..."></textarea>

            <div class="text-end mt-5">
                <button class="btn btn-secondary me-3 px-4" onclick="prevStep(3)">Previous</button>
                <button class="btn btn-secondary px-5" onclick="nextStep(3)">Next</button>
            </div>
        </div>

        <!-- Step 4: Customize Finishing -->
        <div id="step4" class="step card p-4 shadow">
            <h2 class="text-center mb-4">Step 4: Customize Finishing</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <h5>Sunfade</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sunfadeOption" id="noneSunfade" value="None" checked onchange="updateSunfadeImage()">
                        <label class="form-check-label" for="noneSunfade">None</label>
                    </div>
                    <div id="sunfadeOptions">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sunfadeOption" id="waistSunfade" value="Waist Sunfade" onchange="updateSunfadeImage()">
                            <label class="form-check-label" for="waistSunfade">Waist Sunfade</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sunfadeOption" id="waistBottomSunfade" value="Waist & Bottom Sunfade" onchange="updateSunfadeImage()">
                            <label class="form-check-label" for="waistBottomSunfade">Waist & Bottom Sunfade</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sunfadeOption" id="circular" value="Circular Sunfade" onchange="updateSunfadeImage()">
                            <label class="form-check-label" for="circular">Circular Sunfade</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sunfadeOption" id="allover" value="All-over Sunfade" onchange="updateSunfadeImage()">
                            <label class="form-check-label" for="allover">All-over Sunfade</label>
                        </div>
                    </div>
                    <img id="sunfadeImage" class="dynamic-image mt-3" src="<?= BASE_URL ?>/pictures/design/empty_shorts.png" alt="Sunfade Preview">
                </div>
                <div class="col-md-4">
                    <h5>Stitching</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="stitchingOption" id="noneStitching" value="None" checked onchange="updateStitchingImage()">
                        <label class="form-check-label" for="noneStitching">None</label>
                    </div>
                    <div id="stitchingOptions">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stitchingOption" id="standardStitching" value="Standard Stitching" onchange="updateStitchingImage()">
                            <label class="form-check-label" for="standardStitching">Standard Stitching</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stitchingOption" id="insideOut" value="Inside-Out Stitching" onchange="updateStitchingImage()">
                            <label class="form-check-label" for="insideOut">Inside-Out Stitching</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stitchingOption" id="rawEdge" value="Raw Edge Stitching" onchange="updateStitchingImage()">
                            <label class="form-check-label" for="rawEdge">Raw Edge Stitching</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stitchingOption" id="flatlock" value="Flatlock Stitching" onchange="updateStitchingImage()">
                            <label class="form-check-label" for="flatlock">Flatlock Stitching</label>
                        </div>
                    </div>
                    <input type="text" class="form-control mt-2" id="stitchingColor" placeholder="Stitching Color (e.g. white, black)">
                    <img id="stitchingImage" class="dynamic-image mt-3" src="<?= BASE_URL ?>/pictures/design/empty_shorts.png" alt="Stitching Preview">
                </div>
                <div class="col-md-4">
                    <h5>Distressing</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="distressingOption" id="noneDistressing" value="None" checked onchange="updateDistressingImage()">
                        <label class="form-check-label" for="noneDistressing">None</label>
                    </div>
                    <div id="distressingOptions">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="distressingOption" id="heavy" value="Heavy Distressing" onchange="updateDistressingImage()">
                            <label class="form-check-label" for="heavy">Heavy Distressing</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="distressingOption" id="light" value="Light Distressing" onchange="updateDistressingImage()">
                            <label class="form-check-label" for="light">Light Distressing</label>
                        </div>
                    </div>
                    <img id="distressingImage" class="dynamic-image mt-3" src="<?= BASE_URL ?>/pictures/design/empty_shorts.png" alt="Distressing Preview">
                </div>
            </div>

            <div class="text-end mt-5">
                <button class="btn btn-secondary me-4 px-5 py-3" onclick="prevStep(4)">Previous</button>
                <button class="btn btn-secondary px-5 py-3" onclick="nextStep(4)">Next →</button>
            </div>
        </div>

        <!-- Step 5: About Shorts -->
        <div id="step5" class="step card p-5 shadow">
            <h2 class="text-center mb-5 fw-bold text-primary">About Your Custom Shorts</h2>

            <div class="info-card">
                
                <p>
                    We believe in creating shorts that are not just comfortable but also stylish and durable.<br>
                    Our shorts are made from premium-quality fabrics that ensure breathability and long-lasting wear.<br>
                    With customizable options like prints, distressing, labels, fit and length — you can create a unique pair that perfectly reflects your style.
                </p>

                <ul class="mt-4">
                    <li>✅ Premium Quality Fabrics</li>
                    <li>✅ Customizable Designs</li>
                    <li>✅ Perfect Fit Guaranteed</li>
                    <li>✅ Eco-Friendly Production</li>
                    <li>✅ Fast & Reliable Delivery</li>
                </ul>

                <img src="<?= BASE_URL ?>/pictures/design/shorts.png" alt="Premium Shorts" class="preview-img">
            </div>

            <p class="text-center text-muted mt-4 fs-5">
                All customization requests (prints, distressing, pockets, drawcord color, hem style, side stripes etc.)<br>
                <strong>please write in Step 3 comments box</strong> — we will make it exactly as you want!
            </p>

            <div class="text-end mt-5">
                <button class="btn btn-secondary me-4 px-5 py-3" onclick="prevStep(5)">Previous</button>
                <button class="btn btn-secondary px-5 py-3" onclick="nextStep(5)">Next →</button>
            </div>
        </div>

        <!-- Step 6: Quantity & Sample -->
        <div id="step6" class="step card p-4 shadow">
            <h2 class="text-center mb-4">Step 6: Quantity & Sample</h2>
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Do you want a sample first?</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sample" id="sampleYes" value="Yes" onchange="document.getElementById('quantitySection').style.display='none'">
                        <label class="form-check-label" for="sampleYes">Yes (recommended for first order)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sample" id="sampleNo" value="No" checked onchange="document.getElementById('quantitySection').style.display='block'">
                        <label class="form-check-label" for="sampleNo">No, direct bulk order</label>
                    </div>
                </div>

                <div class="col-md-6" id="quantitySection">
                    <h5 class="mb-3">Enter Quantities</h5>
                    <div class="row g-3 quantity-row">
                        <div class="col-6 col-sm-4"><label>XS</label><input type="number" min="0" class="form-control" id="qtyXS"></div>
                        <div class="col-6 col-sm-4"><label>S</label><input type="number" min="0" class="form-control" id="qtyS"></div>
                        <div class="col-6 col-sm-4"><label>M</label><input type="number" min="0" class="form-control" id="qtyM"></div>
                        <div class="col-6 col-sm-4"><label>L</label><input type="number" min="0" class="form-control" id="qtyL"></div>
                        <div class="col-6 col-sm-4"><label>XL</label><input type="number" min="0" class="form-control" id="qtyXL"></div>
                        <div class="col-6 col-sm-4"><label>XXL</label><input type="number" min="0" class="form-control" id="qtyXXL"></div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-5">
                <button class="btn btn-secondary me-4 px-5 py-3" onclick="prevStep(6)">Previous</button>
                <button class="btn btn-secondary px-5 py-3" onclick="nextStep(6)">Next →</button>
            </div>
        </div>

        <!-- Step 7: Contact -->
        <div id="step7" class="step card p-4 shadow">
            <h2 class="text-center mb-4">Step 7: Contact & Submit</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Your Name</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Email Address</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Mobile Number</label>
                    <input type="tel" class="form-control" id="mobile">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">WhatsApp Number</label>
                    <input type="tel" class="form-control" id="whatsapp">
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Your Message / Special Requests</label>
                    <textarea class="form-control" id="message" rows="4" required placeholder="Any final notes, urgent delivery, reference images, etc..."></textarea>
                </div>
            </div>

            <div class="text-end mt-5">
                <button class="btn btn-secondary me-4 px-5 py-3" onclick="prevStep(7)">Previous</button>
                <button type="button" class="btn btn-secondary px-5 py-3" onclick="sendInquiry()">Send Inquiry →</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const totalSteps = 7;
        let currentStep = 1;
        const orderData = {};

        const colors = ['#000000','#FFFFFF','#FF0000','#00FF00','#0000FF','#FFFF00','#FF00FF','#00FFFF','#808080','#A52A2A','#D2691E','#FF4500','#FFD700','#4B0082','#8B4513','#C0C0C0','#D2B48C','#90EE90','#9370DB','#FF69B4'];

        function renderColors(containerId, selectedColorKey, filteredColors = colors) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';
            filteredColors.forEach(color => {
                const div = document.createElement('div');
                div.className = 'color-circle';
                div.style.backgroundColor = color;
                div.onclick = () => {
                    container.querySelectorAll('.color-circle').forEach(el => el.classList.remove('selected'));
                    div.classList.add('selected');
                    orderData[selectedColorKey] = color;
                    if(selectedColorKey === 'color' || !selectedColorKey) applyColorToPreviews(color);
                };
                container.appendChild(div);
            });
        }

        document.getElementById('customColor').addEventListener('input', function(e) {
            orderData.customColor = e.target.value;
            applyColorToPreviews(e.target.value);
        });

        function applyColorToPreviews(color) {
            document.documentElement.style.setProperty('--hoodie-color', color);
            const imagesToColor = document.querySelectorAll('.dynamic-image, .preview-img');
            imagesToColor.forEach(img => {
                if (img.id === 'labelPreview' || img.id === 'designPreview') return;
                
                if(!img.parentElement.classList.contains('color-wrapper')){
                    const wrapper = document.createElement('div');
                    wrapper.className = 'color-wrapper';
                    wrapper.style.display = 'inline-block';
                    wrapper.style.position = 'relative';
                    wrapper.style.borderRadius = '8px';
                    wrapper.style.overflow = 'hidden';

                    const colorLayer = document.createElement('div');
                    colorLayer.className = 'color-layer';
                    colorLayer.style.position = 'absolute';
                    colorLayer.style.top = '0';
                    colorLayer.style.left = '0';
                    colorLayer.style.width = '100%';
                    colorLayer.style.height = '100%';
                    colorLayer.style.backgroundColor = 'var(--hoodie-color)';
                    colorLayer.style.mixBlendMode = 'multiply';
                    colorLayer.style.pointerEvents = 'none';
                    colorLayer.style.maskImage = `url("${img.src}")`;
                    colorLayer.style.maskSize = '100% 100%';
                    colorLayer.style.maskRepeat = 'no-repeat';
                    colorLayer.style.maskPosition = 'center';
                    colorLayer.style.webkitMaskImage = `url("${img.src}")`;
                    colorLayer.style.webkitMaskSize = '100% 100%';
                    colorLayer.style.webkitMaskRepeat = 'no-repeat';
                    colorLayer.style.webkitMaskPosition = 'center';

                    img.parentNode.insertBefore(wrapper, img);
                    wrapper.appendChild(img);
                    wrapper.appendChild(colorLayer);
                } else {
                    const colorLayer = img.parentElement.querySelector('.color-layer');
                    if (colorLayer) {
                        colorLayer.style.backgroundColor = 'var(--hoodie-color)';
                        colorLayer.style.maskImage = `url("${img.src}")`;
                        colorLayer.style.webkitMaskImage = `url("${img.src}")`;
                    }
                }
            });
        }

        function updateSizeChart() {
            const fit = document.querySelector('input[name="fit"]:checked')?.value || 'Regular Fit';
            const chart = [
                { label: 'Waist', values: ['30','32','34','36','38','40'] },
                { label: 'Hip', values: ['38','40','42','44','46','48'] },
                { label: 'Length', values: ['45','47','49','51','53','55'] },
                { label: 'Inseam', values: ['18','20','22','24','26','28'] }
            ];
            const imgSrc = '<?= BASE_URL ?>/pictures/design/shorts.png';
            document.getElementById('sizeChartImg').src = imgSrc;

            const tbody = document.querySelector('#sizeChartTable tbody');
            tbody.innerHTML = '';
            chart.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `<td>${row.label}</td>${row.values.map(v => `<td>${v}</td>`).join('')}`;
                tbody.appendChild(tr);
            });
        }

        function updateLabelColors() {
            const material = document.querySelector('input[name="materialOption"]:checked')?.value;
            let filtered = colors;
            if (material === 'Polyester') filtered = ['#000000', '#FFFFFF', '#C0C0C0'];
            else if (material === 'Cotton Canvas') filtered = ['#FFD700', '#DAA520', '#8B4513'];
            renderColors('labelColorOptions', 'labelColor', filtered);
        }

        function updateLabelPreview() {
            const selected = document.querySelector('input[name="labelType"]:checked')?.value || 'none';
            let src = '<?= BASE_URL ?>/pictures/design/Label on the back.png';
            if (selected === 'none') {
                src = '<?= BASE_URL ?>/pictures/design/shorts.png';
            } else if (selected === 'inseam') {
                src = '<?= BASE_URL ?>/pictures/design/Inseam loop label p1.png';
            } else if (selected === 'back') {
                src = '<?= BASE_URL ?>/pictures/design/Label on the back p1.png';
            }
            document.getElementById('labelPreview').src = src;
            if (typeof updateLabelOverlayPosition === 'function') updateLabelOverlayPosition();
        }

        function updateLabelOverlayPosition() {
            const overlay = document.getElementById('customLabelOverlay');
            if (!overlay || overlay.style.display === 'none') return;
            const labelType = document.querySelector('input[name="labelType"]:checked')?.value || 'none';
            if (labelType === 'inseam') {
                overlay.style.top = '70%';
                overlay.style.left = '65%';
                overlay.style.width = '15%';
                overlay.style.height = '15%';
            } else if (labelType === 'back') {
                overlay.style.top = '15%';
                overlay.style.left = '42%';
                overlay.style.width = '16%';
                overlay.style.height = '16%';
            } else {
                overlay.style.display = 'none';
            }
        }

        function previewImage(inputId, previewId) {
            const file = document.getElementById(inputId).files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewId === 'labelPreview') {
                        const overlay = document.getElementById('customLabelOverlay');
                        if(overlay) {
                            overlay.src = e.target.result;
                            overlay.style.display = 'block';
                            updateLabelOverlayPosition();
                        }
                    } else {
                        document.getElementById(previewId).src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            } else {
                if(previewId === 'labelPreview') {
                    const overlay = document.getElementById('customLabelOverlay');
                    if(overlay) overlay.style.display = 'none';
                    updateLabelPreview();
                } else {
                    document.getElementById(previewId).src = '<?= BASE_URL ?>/pictures/design/shorts.png';
                }
            }
        }

        function validateStep(step) {
            clearValidationMessage();
            let isValid = true;
            let scrolled = false;

            const checkField = (condition, msg, target) => {
                if (!condition) {
                    showValidationMessage(msg, target, !scrolled);
                    scrolled = true;
                    isValid = false;
                }
            };

            if (step === 1) {
                checkField(document.querySelector('input[name="fit"]:checked'), 'Please select a Fit option.', document.querySelector('input[name="fit"]')?.closest('div'));
                checkField(document.getElementById('fabric').value, 'Please select a Fabric.', document.getElementById('fabric'));
                checkField(document.querySelector('input[name="length"]:checked'), 'Please select a Length.', document.querySelector('input[name="length"]')?.closest('div'));
                checkField(orderData.color, 'Please select a Color.', document.getElementById('colorOptions'));
            } else if (step === 6) {
                const sampleVal = document.querySelector('input[name="sample"]:checked')?.value;
                if (sampleVal === 'No') {
                    const qs = ['qtyXXS','qtyXS','qtyS','qtyM','qtyL','qtyXL','qtyXXL','qtyXXXL','qtyXXXXL'];
                    let total = 0;
                    qs.forEach(id => { 
                        const el = document.getElementById(id);
                        if (el) total += parseInt(el.value || 0); 
                    });
                    checkField(total > 0, 'Please enter at least one quantity for your bulk order, or select "Yes" for a sample.', document.getElementById('quantitySection'));
                }
            } else if (step === 7) {
                const nameEl = document.getElementById('name');
                const emailEl = document.getElementById('email');
                const msgEl = document.getElementById('message');
                checkField(nameEl.value.trim(), 'Please enter your Name.', nameEl);
                checkField(emailEl.value.trim(), 'Please enter your Email.', emailEl);
                checkField(msgEl.value.trim(), 'Please enter your Message.', msgEl);
            }
            return isValid;
        }

        function nextStep(step) {
            if (!validateStep(step)) return;
            collectData(step);
            currentStep++;
            showStep(currentStep);
        }

        function prevStep(step) {
            currentStep--;
            showStep(currentStep);
        }

        function showStep(step) {
            document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
            document.getElementById(`step${step}`).classList.add('active');
            document.querySelector('.progress-bar').style.width = `${(step / totalSteps) * 100}%`;
        }

        function collectData(step) {
            if (step === 1) {
                orderData.fit = document.querySelector('input[name="fit"]:checked')?.value;
                orderData.fabric = document.getElementById('fabric').value;
                orderData.length = document.querySelector('input[name="length"]:checked')?.value;
                orderData.color = orderData.color || document.getElementById('customColor').value;
                orderData.additionalNotes = document.getElementById('additionalNotes').value;
            } else if (step === 2) {
                orderData.labelOption = document.querySelector('input[name="labelOption"]:checked')?.value;
                orderData.materialOption = document.querySelector('input[name="materialOption"]:checked')?.value;
                orderData.labelType = document.querySelector('input[name="labelType"]:checked')?.value;
                orderData.labelDescription = document.getElementById('labelDescription').value;
            } else if (step === 3) {
                orderData.establishmentComments = document.getElementById('establishmentComments').value;
            } else if (step === 4) {
                orderData.sunfadeOption = document.querySelector('input[name="sunfadeOption"]:checked')?.value || '';
                orderData.stitchingOption = document.querySelector('input[name="stitchingOption"]:checked')?.value || '';
                const stitchingColorInput = document.getElementById('stitchingColor');
                if (stitchingColorInput) { orderData.stitchingColor = stitchingColorInput.value; }
                orderData.distressingOption = document.querySelector('input[name="distressingOption"]:checked')?.value || '';
            } else if (step === 6) {
                orderData.sample = document.querySelector('input[name="sample"]:checked').value;
                orderData.quantities = {};
                ['XS','S','M','L','XL','XXL'].forEach(size => {
                    orderData.quantities[size] = document.getElementById(`qty${size}`).value || 0;
                });
            }
        }

        function showValidationMessage(message, scrollTarget, shouldScroll = true) {
            const alertEl = document.getElementById('pageAlert');
            
            const target = scrollTarget || alertEl;
            if (target) {
                if (shouldScroll) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                if (scrollTarget) {
                    scrollTarget.style.outline = '2px solid #e74c3c';
                    scrollTarget.style.borderColor = '#e74c3c';
                    setTimeout(() => { scrollTarget.style.outline = ''; scrollTarget.style.borderColor = ''; }, 3500);
                    
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'field-error text-danger mt-1 small fw-bold';
                    errorMsg.innerHTML = `<i class="bi bi-exclamation-circle me-1"></i> ${message}`;
                    
                    if (scrollTarget.nextSibling) {
                        scrollTarget.parentNode.insertBefore(errorMsg, scrollTarget.nextSibling);
                    } else {
                        scrollTarget.parentNode.appendChild(errorMsg);
                    }
                } else if (alertEl) {
                    alertEl.textContent = message;
                    alertEl.classList.add('show');
                    alertEl.style.display = 'block';
                }
            }
        }

        function clearValidationMessage() {
            const alertEl = document.getElementById('pageAlert');
            if (alertEl) {
                alertEl.textContent = '';
                alertEl.classList.remove('show');
                alertEl.style.display = 'none';
            }
            document.querySelectorAll('.field-error').forEach(el => el.remove());
        }

        function sendInquiry() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const mobile = document.getElementById('mobile').value.trim() || 'N/A';
            const whatsapp = document.getElementById('whatsapp').value.trim() || 'N/A';
            const message = document.getElementById('message').value.trim();

            if (!name || !email || !message) {
                showValidationMessage('Please fill in Name, Email and Message.');
                return;
            }

            let emailBody = `New Shorts Custom Order from ${name}
----------------------------------------
Contact: ${email} | Mobile: ${mobile} | WhatsApp: ${whatsapp}
Message: ${message}

Order Summary:
Fit: ${orderData.fit || 'N/A'}
Fabric: ${orderData.fabric || 'N/A'}
Length: ${orderData.length || 'N/A'}
Color: ${orderData.color || 'N/A'}
Notes: ${orderData.additionalNotes || 'None'}

Labels: ${orderData.labelOption || 'N/A'} (${orderData.materialOption || ''}) - Placement: ${orderData.labelType || 'none'} - ${orderData.labelDescription || ''}

Prints & Requests: ${orderData.establishmentComments || 'None'}

Finishing:
- Sunfade: ${orderData.sunfadeOption !== 'None' && orderData.sunfadeOption ? orderData.sunfadeOption : 'No'}
- Stitching: ${orderData.stitchingOption !== 'None' && orderData.stitchingOption ? orderData.stitchingOption + ' (' + (orderData.stitchingColor || 'default') + ')' : 'No'}
- Distressing: ${orderData.distressingOption !== 'None' && orderData.distressingOption ? orderData.distressingOption : 'No'}

Quantities (Sample first? ${orderData.sample}):
${Object.entries(orderData.quantities || {}).map(([k,v]) => `  ${k}: ${v}`).join('\n')}

Sent from Shorts Custom Form
`;

            // Instead of opening Outlook/mailto, send directly via backend
            const submitBtn = document.querySelector('button[onclick="sendInquiry()"]');
            const originalText = submitBtn ? submitBtn.textContent : 'Send Inquiry';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Sending Inquiry...';
            }
            
            const formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('mobile', mobile);
            formData.append('whatsapp', whatsapp);
            formData.append('message', message);
            formData.append('body', emailBody);
            formData.append('subject', `New Shorts Order - ${name}`);

            const labelImage = document.getElementById('labelImage');
            if (labelImage && labelImage.files[0]) {
                formData.append('labelImage', labelImage.files[0]);
            }

            fetch('<?= url('') ?>send_design_inquiry', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Inquiry sent successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while sending the inquiry.');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });
        }

        const sunfadeImages = {
            'Waist Sunfade': '<?= BASE_URL ?>/pictures/design/Waist Sunfade (S).png',
            'Waist & Bottom Sunfade': '<?= BASE_URL ?>/pictures/design/Waist & Bottom Sunfade (S).png',
            'Circular Sunfade': '<?= BASE_URL ?>/pictures/design/Circular Sunfade (S).png',
            'All-over Sunfade': '<?= BASE_URL ?>/pictures/design/All-over Sunfade (S).png'
        };
        const stitchingImages = {
            'Standard Stitching': '<?= BASE_URL ?>/pictures/design/Standard Stitching (S).png',
            'Inside-Out Stitching': '<?= BASE_URL ?>/pictures/design/Inside-Out Stitching (S).png',
            'Raw Edge Stitching': '<?= BASE_URL ?>/pictures/design/Raw Edge Stitching (S).png',
            'Flatlock Stitching': '<?= BASE_URL ?>/pictures/design/Flatlock Stitching (S).png'
        };
        const distressingImages = {
            'Heavy Distressing': '<?= BASE_URL ?>/pictures/design/Heavy Distressing (S).png',
            'Light Distressing': '<?= BASE_URL ?>/pictures/design/Light Distressing (S).png'
        };

        function updateSunfadeImage() { updateImage('sunfade'); }
        function updateStitchingImage() { updateImage('stitching'); }
        function updateDistressingImage() { updateImage('distressing'); }

        function updateImage(type) {
            const option = document.querySelector(`input[name="${type}Option"]:checked`)?.value;
            let images = {};
            if (type === 'sunfade') images = sunfadeImages;
            if (type === 'stitching') images = stitchingImages;
            if (type === 'distressing') images = distressingImages;
            const src = images[option] || '<?= BASE_URL ?>/pictures/design/empty_shorts.png';
            const img = document.getElementById(`${type}Image`);
            if (img) {
                img.src = src;
                if (img.parentElement.classList.contains('color-wrapper')) {
                    const colorLayer = img.parentElement.querySelector('.color-layer');
                    if (colorLayer) {
                        colorLayer.style.maskImage = `url("${src}")`;
                        colorLayer.style.webkitMaskImage = `url("${src}")`;
                    }
                }
            }
        }

        // Initialize
        renderColors('colorOptions', 'color');
        renderColors('labelColorOptions', 'labelColor', colors);
        updateSizeChart();
        updateLabelPreview();
        // Clear specific inline errors on change
        document.addEventListener('change', function(e) {
            const target = e.target;
            target.style.outline = '';
            target.style.borderColor = '';
            
            let elementsToCheck = [target, target.closest('div')];
            
            if (target.type === 'radio' && target.name) {
                const firstRadio = document.querySelector(`input[name="${target.name}"]`);
                if (firstRadio) elementsToCheck.push(firstRadio.closest('div'));
            }
            
            elementsToCheck.forEach(el => {
                if (el) {
                    el.style.outline = '';
                    el.style.borderColor = '';
                    if (el.nextSibling && el.nextSibling.className && String(el.nextSibling.className).includes('field-error')) {
                        el.nextSibling.remove();
                    }
                }
            });
        });
    </script>
</body>
</html>
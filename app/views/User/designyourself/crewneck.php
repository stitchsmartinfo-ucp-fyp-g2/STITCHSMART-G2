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
    <title>Custom Crewneck Sweatshirt Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/<?= htmlspecialchars($validatedTheme, ENT_QUOTES, 'UTF-8') ?>-frontend.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/design-editors.css?v=<?= time() ?>" rel="stylesheet">
    <style>
        .step { display: none; }
        .step.active { display: block; }
        .form-control { border-radius: 8px; }
        .btn-primary { border-radius: 12px; padding: 10px 20px; }
        .color-circle {
            width: 24px; height: 24px; border-radius: 50%; display: inline-block;
            margin: 5px; cursor: pointer; border: 1px solid var(--border-color);
        }
        .color-circle.selected { border: 2px solid var(--accent-bronze, #ca9745); }
        .image-preview, .dynamic-image {
            max-width: 100%; height: auto; margin-top: 10px;
            border: 1px solid var(--border-color); border-radius: 8px;
        }
        .size-chart table { width: 100%; border-collapse: collapse; }
        .size-chart th, .size-chart td {
            border: 1px solid var(--border-color); padding: 8px; text-align: center;
        }
    </style>
</head>
<body class="<?= htmlspecialchars($validatedTheme, ENT_QUOTES, 'UTF-8') ?>">
    <div class="container my-5">
        <h1 class="text-center mb-4">Custom Crewneck Sweatshirt Order Form</h1>
        <div id="progress" class="progress mb-4">
            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div id="pageAlert" class="validation-alert"></div>

        <!-- Step 1 -->
        <div id="step1" class="step card p-4 active">
            <h2>Step 1: Choose Fit, Fabric & Color</h2>
            <div class="row">
                <div class="col-md-4">
                    <h5>Choose your fit</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="fit" id="regularFit" value="Regular fit" checked onchange="updateSizeChart()">
                        <label class="form-check-label" for="regularFit">Regular fit</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="fit" id="boxyFit" value="Boxy fit" onchange="updateSizeChart()">
                        <label class="form-check-label" for="boxyFit">Boxy fit</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>Choose Fabric</h5>
                    <select class="form-select" id="fabric">
                        <option value="">Select Fabric</option>
                        <option value="Fleece, 330GSM, 100% organic cotton">Fleece, 330GSM, 100% organic cotton</option>
                        <option value="Fleece, 400GSM, 100% cotton">Fleece, 400GSM, 100% cotton</option>
                        <option value="Fleece, 400GSM, 100% organic cotton">Fleece, 400GSM, 100% organic cotton</option>
                        <option value="French Terry, 350-400GSM, 100% cotton">French Terry, 350-400GSM, 100% cotton</option>
                        <option value="Waffle Knit, 350GSM, 100% cotton">Waffle Knit, 350GSM, 100% cotton</option>
                        <option value="Custom">Custom</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <h5>Garment Dye Options</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="dye" id="fadeOut" value="Garment Dye [ fade-out ]">
                        <label class="form-check-label" for="fadeOut">Garment Dye [ fade-out ]</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="dye" id="reactive" value="Garment Dye [ reactive ]">
                        <label class="form-check-label" for="reactive">Garment Dye [ reactive ]</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="dye" id="fabricDye" value="Fabric Dye">
                        <label class="form-check-label" for="fabricDye">Fabric Dye</label>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <h5>Choose a Color</h5>
                <div id="colorOptions"></div>
                <input type="text" class="form-control mt-2" id="customColor" placeholder="Enter custom color">
            </div>
            <div class="mt-3">
                <h5>Additional Notes</h5>
                <textarea class="form-control" id="additionalNotes" rows="3"></textarea>
            </div>
            <div class="mt-3 size-chart">
                <h5>Size Chart (cm)</h5>
                <img src="<?= BASE_URL ?>/pictures/design/crew_measures.png" alt="Crewneck Size Chart" class="dynamic-image mb-3">
                <table id="sizeChartTable">
                    <thead>
                        <tr><th>Measurement</th><th>XS</th><th>S</th><th>M</th><th>L</th><th>XL</th><th>2XL</th><th>3XL</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="text-end mt-4">
                <button class="btn btn-secondary" onclick="nextStep(1)">Next</button>
            </div>
        </div>

        <!-- Step 2: Labels -->
        <div id="step2" class="step card p-4">
            <h2>Step 2: Label Options</h2>
            <div class="row">
                <div class="col-md-6">
                    <h5>Select a label option</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="labelOption" id="noLabel" value="No label">
                        <label class="form-check-label" for="noLabel">No label</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="labelOption" id="sendLabels" value="I will send labels">
                        <label class="form-check-label" for="sendLabels">I will send labels</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="labelOption" id="standard" value="Standard">
                        <label class="form-check-label" for="standard">Standard</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="labelOption" id="custom" value="Custom">
                        <label class="form-check-label" for="custom">Custom</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Choose the material</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="materialOption" id="woven" value="Woven label" onchange="updateLabelColors()">
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

            <div class="mt-3">
                <h5>Select a color</h5>
                <div id="labelColorOptions"></div>
            </div>

            <div class="mt-4">
                <h5>Label Type (Select one)</h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="labelType" id="noExtraLabel" value="none" checked onchange="updateLabelPreview()">
                    <label class="form-check-label" for="noExtraLabel">No extra label</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="labelType" id="inseamLoop" value="inseam" onchange="updateLabelPreview()">
                    <label class="form-check-label" for="inseamLoop">Inseam loop label</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="labelType" id="backLabel" value="back" onchange="updateLabelPreview()">
                    <label class="form-check-label" for="backLabel">Label on the back</label>
                </div>
            </div>

            <div id="labelPreviewContainer" style="position: relative; display: inline-block; width: 100%;">
                <img id="labelPreview" class="dynamic-image mt-3" src="<?= BASE_URL ?>/pictures/design/Label on the back.png" alt="Label Preview" style="width: 100%;">
                <img id="customLabelOverlay" style="position: absolute; display: none; object-fit: contain; pointer-events: none; z-index: 10;">
            </div>
            <input type="file" id="labelImage" accept="image/*" class="mt-2" onchange="previewImage('labelImage', 'labelPreview')">
            <textarea class="form-control mt-2" id="labelDescription" placeholder="Describe label design, placement, or upload custom..." rows="2"></textarea>

            <div class="text-end mt-4">
                <button class="btn btn-secondary me-2" onclick="prevStep(2)">Previous</button>
                <button class="btn btn-secondary" onclick="nextStep(2)">Next</button>
            </div>
        </div>

        <!-- Step 3: Prints (sirf comments, no download/upload) -->
        <div id="step3" class="step card p-4">
            <h2>Step 3: Add Customizations Like Prints</h2>
            <p>Please describe your print design, placement, colors, size, and any other details in the box below.</p>

            <div class="mt-4">
                <h5>Your Print/Design Details & Comments</h5>
                <textarea class="form-control" id="establishmentComments" rows="6" placeholder="Example: Front chest print - 12cm x 12cm - white puff print, back full print - all-over distressed graphic, sleeve small logo..."></textarea>
            </div>

            <div class="text-end mt-4">
                <button class="btn btn-secondary me-2" onclick="prevStep(3)">Previous</button>
                <button class="btn btn-secondary" onclick="nextStep(3)">Next</button>
            </div>
        </div>

        <!-- Step 4: Finishing -->
        <div id="step4" class="step card p-4">
            <h2>Step 4: Customize Finishing</h2>
            <div class="row">
                <div class="col-md-4">
                    <h5>Sunfade</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sunfadeOption" id="noneSunfade" value="None" checked onchange="updateSunfadeImage()">
                        <label class="form-check-label" for="noneSunfade">None</label>
                    </div>
                    <div id="sunfadeOptions">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sunfadeOption" id="shoulderSunfade" value="Shoulder Sunfade" onchange="updateSunfadeImage()">
                            <label class="form-check-label" for="shoulderSunfade">Shoulder Sunfade</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sunfadeOption" id="shoulderBottom" value="Shoulder & Bottom Sunfade" onchange="updateSunfadeImage()">
                            <label class="form-check-label" for="shoulderBottom">Shoulder & Bottom Sunfade</label>
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
                    <img id="sunfadeImage" class="dynamic-image mt-3" src="<?= BASE_URL ?>/pictures/design/empty_crewneck.png" alt="Sunfade Preview">
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
                    <img id="stitchingImage" class="dynamic-image mt-3" src="<?= BASE_URL ?>/pictures/design/empty_crewneck.png" alt="Stitching Preview">
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
                    <img id="distressingImage" class="dynamic-image mt-3" src="<?= BASE_URL ?>/pictures/design/empty_crewneck.png" alt="Distressing Preview">
                </div>
            </div>

            <div class="text-end mt-4">
                <button class="btn btn-secondary me-2" onclick="prevStep(4)">Previous</button>
                <button class="btn btn-secondary" onclick="nextStep(4)">Next</button>
            </div>
        </div>

        <!-- Step 5 -->
        <div id="step5" class="step card p-4">
            <h2>Step 5: Quantity & Sample</h2>
            <div class="row">
                <div class="col-md-6">
                    <h5>Do you want a sample first?</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sample" id="sampleYes" value="Yes" onchange="document.getElementById('quantitySection').style.display='none'">
                        <label class="form-check-label" for="sampleYes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sample" id="sampleNo" value="No" checked onchange="document.getElementById('quantitySection').style.display='block'">
                        <label class="form-check-label" for="sampleNo">No</label>
                    </div>
                </div>
                <div class="col-md-6" id="quantitySection">
                    <h5>Enter Quantities for Sizes</h5>
                    <div class="row quantity-row">
                        <div class="col-6"><label>XXS</label><input type="number" class="form-control" id="qtyXXS" min="0"></div>
                        <div class="col-6"><label>XS</label><input type="number" class="form-control" id="qtyXS" min="0"></div>
                        <div class="col-6"><label>S</label><input type="number" class="form-control" id="qtyS" min="0"></div>
                        <div class="col-6"><label>M</label><input type="number" class="form-control" id="qtyM" min="0"></div>
                        <div class="col-6"><label>L</label><input type="number" class="form-control" id="qtyL" min="0"></div>
                        <div class="col-6"><label>XL</label><input type="number" class="form-control" id="qtyXL" min="0"></div>
                        <div class="col-6"><label>XXL</label><input type="number" class="form-control" id="qtyXXL" min="0"></div>
                        <div class="col-6"><label>XXXL</label><input type="number" class="form-control" id="qtyXXXL" min="0"></div>
                        <div class="col-6"><label>XXXXL</label><input type="number" class="form-control" id="qtyXXXXL" min="0"></div>
                    </div>
                </div>
            </div>
            <div class="text-end mt-4">
                <button class="btn btn-secondary me-2" onclick="prevStep(5)">Previous</button>
                <button class="btn btn-secondary" onclick="nextStep(5)">Next</button>
            </div>
        </div>

        <!-- Step 6 -->
        <div id="step6" class="step card p-4">
            <h2>Step 6: Contact Us</h2>
            <form id="contactForm">
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">Your Mobile Number</label>
                    <input type="tel" class="form-control" id="mobile">
                </div>
                <div class="mb-3">
                    <label for="whatsapp" class="form-label">Your WhatsApp Number</label>
                    <input type="tel" class="form-control" id="whatsapp">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea class="form-control" id="message" rows="4" required></textarea>
                </div>
                <div class="text-end">
                    <button class="btn btn-secondary me-2" onclick="prevStep(6)">Previous</button>
                    <button type="button" class="btn btn-secondary" onclick="sendInquiry()">Send Inquiry</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const totalSteps = 6;
        let currentStep = 1;
        const orderData = {};

        const colors = [
            '#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#800080', '#FFA500',
            '#00FFFF', '#FFC0CB', '#008080', '#4B0082', '#FFD700',
            '#A52A2A', '#808080', '#ADD8E6', '#90EE90', '#9370DB', '#FF4500',
            '#000000', '#FFFFFF', '#8B4513', '#F5F5DC', '#C0C0C0', '#D2B48C'
        ];

        const allColors = colors;
        const polyesterColors = ['#000000', '#FFFFFF', '#C0C0C0'];
        const cottonCanvasColors = ['#FFD700', '#DAA520', '#8B4513'];

        const sizeCharts = {
            'Regular fit': [
                { label: 'Body Length', values: ['63', '65', '67', '69', '71', '74', '77'] },
                { label: 'Chest Width', values: ['60', '62', '64', '66', '68', '70', '72'] },
                { label: 'Bottom Width', values: ['58', '60', '62', '64', '66', '68', '70'] },
                { label: 'Sleeve Length', values: ['57', '58', '59', '60', '61', '62', '63'] }
            ],
            'Boxy fit': [
                { label: 'Body Length', values: ['60', '62', '64', '66', '69', '72', '75'] },
                { label: 'Chest Width', values: ['63', '64', '65', '66', '67', '69', '71'] },
                { label: 'Bottom Width', values: ['57', '58', '59', '60', '61', '63', '65'] },
                { label: 'Sleeve Length', values: ['52', '53', '54', '55', '56', '57', '58'] }
            ]
        };

        const sunfadeImages = {
            'Shoulder Sunfade': '<?= BASE_URL ?>/pictures/design/Shoulder Sunfade (C).png',
            'Shoulder & Bottom Sunfade': '<?= BASE_URL ?>/pictures/design/Shoulder & Bottom Sunfade (C).png',
            'Circular Sunfade': '<?= BASE_URL ?>/pictures/design/Circular Sunfade (C).png',
            'All-over Sunfade': '<?= BASE_URL ?>/pictures/design/All-over Sunfade (C).png'
        };

        const stitchingImages = {
            'Standard Stitching': '<?= BASE_URL ?>/pictures/design/Standard Stitching (C).png',
            'Inside-Out Stitching': '<?= BASE_URL ?>/pictures/design/Inside-Out Stitching (C).png',
            'Raw Edge Stitching': '<?= BASE_URL ?>/pictures/design/raw edge stitching.png',
            'Flatlock Stitching': '<?= BASE_URL ?>/pictures/design/Flatlock Stitching (C).png'
        };

        const distressingImages = {
            'Heavy Distressing': '<?= BASE_URL ?>/pictures/design/Heavy Distressing (C).png',
            'Light Distressing': '<?= BASE_URL ?>/pictures/design/light Distressing (C).png'
        };

        function renderColors(containerId, selectedColorKey, filteredColors = colors) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';
            filteredColors.forEach(color => {
                const div = document.createElement('div');
                div.className = 'color-circle';
                div.style.backgroundColor = color;
                div.onclick = () => selectColor(div, color, selectedColorKey);
                container.appendChild(div);
            });
        }

        function selectColor(element, color, key) {
            element.parentElement.querySelectorAll('.color-circle').forEach(el => el.classList.remove('selected'));
            element.classList.add('selected');
            orderData[key] = color;
            if (key === 'color' || !key) applyColorToPreviews(color);
        }
        
        document.getElementById('customColor').addEventListener('input', function(e) {
            orderData.customColor = e.target.value;
            applyColorToPreviews(e.target.value);
        });

        function applyColorToPreviews(color) {
            document.documentElement.style.setProperty('--hoodie-color', color);
            const imagesToColor = document.querySelectorAll('.dynamic-image');
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
            const fit = document.querySelector('input[name="fit"]:checked')?.value || 'Regular fit';
            const chart = sizeCharts[fit] || sizeCharts['Regular fit'];
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
            let filtered = allColors;
            if (material === 'Polyester') filtered = polyesterColors;
            else if (material === 'Cotton Canvas') filtered = cottonCanvasColors;
            renderColors('labelColorOptions', 'labelColor', filtered);
        }

        function updateLabelPreview() {
            const selected = document.querySelector('input[name="labelType"]:checked')?.value || 'none';
            let src = '<?= BASE_URL ?>/pictures/design/Label on the back.png';
            if (selected === 'none') {
                src = '<?= BASE_URL ?>/pictures/design/empty_crewneck.png';
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
                overlay.style.width = '10%';
                overlay.style.height = '10%';
            } else if (labelType === 'back') {
                overlay.style.top = '55%';
                overlay.style.left = '45%';
                overlay.style.width = '10%';
                overlay.style.height = '6%';
                overlay.style.objectFit = 'cover';
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
                    document.getElementById(previewId).src = '<?= BASE_URL ?>/pictures/design/empty_crewneck.png';
                }
            }
        }

        function toggleOptions(type) {
            // Function no longer used with unified radio UI, but kept empty for safety
        }

        function updateSunfadeImage() { updateImage('sunfade'); }
        function updateStitchingImage() { updateImage('stitching'); }
        function updateDistressingImage() { updateImage('distressing'); }

        function updateImage(type) {
            const option = document.querySelector(`input[name="${type}Option"]:checked`)?.value;
            let images = {};
            if (type === 'sunfade') images = sunfadeImages;
            if (type === 'stitching') images = stitchingImages;
            if (type === 'distressing') images = distressingImages;
            const src = images[option] || '<?= BASE_URL ?>/pictures/design/empty_crewneck.png';
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
            const progress = (step / totalSteps) * 100;
            document.querySelector('.progress-bar').style.width = `${progress}%`;
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
                checkField(document.querySelector('input[name="dye"]:checked'), 'Please select a Dye option.', document.querySelector('input[name="dye"]')?.closest('div'));
                checkField(orderData.color, 'Please select a Color.', document.getElementById('colorOptions'));
            } else if (step === 5) {
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
            } else if (step === 6) {
                const nameEl = document.getElementById('name');
                const emailEl = document.getElementById('email');
                const msgEl = document.getElementById('message');
                checkField(nameEl.value.trim(), 'Please enter your Name.', nameEl);
                checkField(emailEl.value.trim(), 'Please enter your Email.', emailEl);
                checkField(msgEl.value.trim(), 'Please enter your Message.', msgEl);
            }
            return isValid;
        }

        function collectData(step) {
            if (step === 1) {
                orderData.fit = document.querySelector('input[name="fit"]:checked').value;
                orderData.fabric = document.getElementById('fabric').value;
                orderData.dye = document.querySelector('input[name="dye"]:checked')?.value || '';
                orderData.customColor = document.getElementById('customColor').value;
                orderData.additionalNotes = document.getElementById('additionalNotes').value;
            } else if (step === 2) {
                orderData.labelOption = document.querySelector('input[name="labelOption"]:checked')?.value;
                orderData.materialOption = document.querySelector('input[name="materialOption"]:checked')?.value;
                orderData.labelDescription = document.getElementById('labelDescription').value;
                orderData.labelType = document.querySelector('input[name="labelType"]:checked')?.value || 'none';
            } else if (step === 3) {
                orderData.establishmentComments = document.getElementById('establishmentComments').value;
            } else if (step === 4) {
                orderData.sunfadeOption = document.querySelector('input[name="sunfadeOption"]:checked')?.value || '';
                orderData.stitchingOption = document.querySelector('input[name="stitchingOption"]:checked')?.value || '';
                orderData.stitchingColor = document.getElementById('stitchingColor').value;
                orderData.distressingOption = document.querySelector('input[name="distressingOption"]:checked')?.value || '';
            } else if (step === 5) {
                orderData.sample = document.querySelector('input[name="sample"]:checked').value;
                orderData.quantities = {
                    XXS: document.getElementById('qtyXXS').value || 0,
                    XS: document.getElementById('qtyXS').value || 0,
                    S: document.getElementById('qtyS').value || 0,
                    M: document.getElementById('qtyM').value || 0,
                    L: document.getElementById('qtyL').value || 0,
                    XL: document.getElementById('qtyXL').value || 0,
                    XXL: document.getElementById('qtyXXL').value || 0,
                    XXXL: document.getElementById('qtyXXXL').value || 0,
                    XXXXL: document.getElementById('qtyXXXXL').value || 0
                };
            }
        }

        function sendInquiry() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const mobile = document.getElementById('mobile').value || 'N/A';
            const whatsapp = document.getElementById('whatsapp').value || 'N/A';
            const message = document.getElementById('message').value;

            if (!name || !email || !message) {
                showValidationMessage('Please fill in name, email, and message.');
                return;
            }

            let emailBody = `
New Crewneck Inquiry from ${name}
--------------------------
Contact: Email ${email} | Mobile ${mobile} | WhatsApp ${whatsapp}
Message: ${message}

Order Details
--------------------------
Fit: ${orderData.fit}
Fabric: ${orderData.fabric}
Dye: ${orderData.dye}
Color: ${orderData.color || orderData.customColor || 'N/A'}
Notes: ${orderData.additionalNotes}

Labels: ${orderData.labelOption || 'N/A'} - ${orderData.materialOption || ''} (${orderData.labelColor || 'N/A'}) - Type: ${orderData.labelType || 'none'} - ${orderData.labelDescription || ''}

Prints/Comments: ${orderData.establishmentComments || 'None'}

Finishing:
- Sunfade: ${orderData.sunfadeOption !== 'None' && orderData.sunfadeOption ? orderData.sunfadeOption : 'No'}
- Stitching: ${orderData.stitchingOption !== 'None' && orderData.stitchingOption ? orderData.stitchingOption + ' (' + (orderData.stitchingColor || 'default') + ')' : 'No'}
- Distressing: ${orderData.distressingOption !== 'None' && orderData.distressingOption ? orderData.distressingOption : 'No'}

Quantities (Sample: ${orderData.sample}):
${Object.entries(orderData.quantities || {}).map(([k, v]) => `${k}: ${v}`).join(', ')}

Sent via Crewneck Custom Form
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
            formData.append('subject', `New Crewneck Inquiry from ${name}`);

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

        // Initialize
        renderColors('colorOptions', 'color');
        renderColors('labelColorOptions', 'labelColor');
        updateSizeChart();
        toggleOptions('sunfade');
        toggleOptions('stitching');
        toggleOptions('distressing');
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
</body>
</html>
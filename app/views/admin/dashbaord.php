
<!-- Luxury Executive Header Card -->
<div class="admin-header-card p-4 p-md-5 mb-4 rounded-4 position-relative overflow-hidden">
    <div class="position-absolute top-0 end-0 p-5 opacity-10 pointer-events-none d-none d-lg-block" style="transform: translate(15%, -15%);">
        <i class="bi bi-shield-check text-warning" style="font-size: 15rem;"></i>
    </div>
    <div class="position-relative z-1 text-center text-md-start">
        <div>
            <h2 class="mb-2 fw-bolder" style="font-size: 2.4rem; letter-spacing: -0.5px;">StitchSmart Dashboard</h2>
            <p class="mb-0 mt-2" style="max-width: 680px; font-size: 1.05rem; line-height: 1.5;">Welcome to your central administration console. Oversee live order pipelines, monitor inventory health, adjust dynamic SEO settings, and manage catalog workflows.</p>
        </div>
        <div class="mt-4 d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-md-start">
            <a href="<?= url('') ?>admin_products" class="btn px-4 py-3 rounded-pill d-flex align-items-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #ca9745, #e8c547); color: #1a0f0a; border: none; font-weight: 800; font-size: 0.96rem; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(202, 151, 69, 0.6)';" onmouseout="this.style.transform='translateY(0)';">
                <i class="bi bi-box-seam-fill fs-5"></i> Products Catalog
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

<!-- Website & Social Settings Form -->
<form action="<?php echo url('') ?>admin_save_settings" method="POST" enctype="multipart/form-data">
    <!-- Website Contact Info -->
    <div class="row">
        <div class="col-md-4">
            <div class="box db rounded mt-2 p-3">
                <label for="webname" class="form-label">Website Name</label>
                <input type="text" id="webname" name="webname" class="form-control d-block border-0 border-bottom bg-transparent" value="<?php echo $webname ?? '' ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="box db rounded mt-2 p-3">
                <label for="webmail" class="form-label">Website Email</label>
                <input type="email" id="webmail" name="webmail" class="form-control border-0 border-bottom bg-transparent" value="<?php echo $webmail ?? '' ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="box db rounded mt-2 p-3">
                <label for="webcontact" class="form-label">Website Contact</label>
                <input type="text" id="webcontact" name="webcontact" class="form-control border-0 border-bottom bg-transparent" value="<?php echo $webcontact ?? '' ?>">
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <button type="submit" id="dbutton" class="btn me-2 px-5" name="save_contact_info">Save Contact Settings</button>
    </div>
</form>

<!-- SEO Settings Section -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4">
            <form class="card-body p-4" action="<?php echo url('') ?>admin_save_settings" method="POST">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">SEO Settings</h5>
                    <button type="button" id="aiBtn" onclick="generateSEOAI(this)" class="btn btn-sm" style="background: var(--accent-bronze); color: #000; font-weight: 700; border-radius: 50px; padding: 5px 15px;">✨ Generate with AI</button>
                </div>
                <div id="ai-error-container"></div>
                
                <div class="mb-3">
                    <label for="meta-title" class="form-label">SEO Title</label>
                    <input type="text" name="meta_title" id="meta-title" class="form-control" value="<?=$meta_title?>" />
                </div>
            
                <div class="mb-3">
                    <label for="meta-description" class="form-label">SEO Description</label>
                    <textarea class="form-control" name="meta_description" id="meta-description" rows="3"><?=$meta_description?></textarea>
                </div>
            
                <div class="mb-3">
                    <label for="meta-keywords" class="form-label">SEO Keywords</label>
                    <input type="text" name="meta_keywords" id="meta-keywords" class="form-control" value="<?=$meta_keywords?>" />
                </div>
            
                <div class="text-end">
                    <button type="submit" class="btn" id="mbut" name="save_meta_info">Update SEO</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Dashboard Counts (Sales Boxes) -->
<div class="mt-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="box dbox text-center p-4 rounded shadow-sm">
                <h5 class="mb-2">Total Products</h5>
                <h3 class="fw-bold mb-0"><?php echo $counts['products'] ?? 0 ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box dbox b text-center p-4 rounded shadow-sm">
                <h5 class="mb-2">Total Categories</h5>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <h3 class="fw-bold mb-0"><?php echo $counts['categories'] ?? 0 ?> <span class="fs-6 fw-normal opacity-75">Main</span></h3>
                    <span class="fs-5 opacity-50">|</span>
                    <h3 class="fw-bold mb-0"><?php echo $counts['subcategories'] ?? 0 ?> <span class="fs-6 fw-normal opacity-75">Sub</span></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box dbox text-center p-4 rounded shadow-sm">
                <h5 class="mb-2">Total Orders</h5>
                <h3 class="fw-bold mb-0"><?php echo $counts['orders'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Stock Status Pie Chart -->
<div class="row mt-5 mb-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-4 fw-bold">Stock Status Overview</h5>
                <div style="height: 320px;">
                    <canvas id="stockPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-4 fw-bold">Low Stock Summary</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-3">
                        Healthy Stock
                        <span class="badge bg-success rounded-pill"><?php echo $counts['healthy_stock'] ?? 0 ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-3">
                        Low Stock (≤ 10 units)
                        <span class="badge bg-warning rounded-pill"><?php echo $counts['low_stock'] ?? 0 ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        Out of Stock
                        <span class="badge bg-danger rounded-pill"><?php echo $counts['out_of_stock'] ?? 0 ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Low-Stock Product List -->
<div class="row mb-5">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <h5 class="card-title mb-4 fw-bold">Low Stock Products</h5>
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lowStockProducts) || !empty($outOfStockProducts)): ?>
                                <?php foreach ($lowStockProducts as $index => $product): ?>
                                    <tr>
                                        <td><?php echo $index + 1 ?></td>
                                        <td><?php echo htmlspecialchars($product['article_number'] ?: '—') ?></td>
                                        <td><?php echo htmlspecialchars($product['name']) ?></td>
                                        <td><?php echo htmlspecialchars($product['quantity']) ?></td>
                                        <td>
                                            <a href="<?= url('edit_product?id=' . (int)$product['id']) ?>" class="text-decoration-none">
                                                <span class="badge bg-warning">Low Stock</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php foreach ($outOfStockProducts as $index => $product): ?>
                                    <tr>
                                        <td><?php echo count($lowStockProducts) + $index + 1 ?></td>
                                        <td><?php echo htmlspecialchars($product['article_number'] ?: '—') ?></td>
                                        <td><?php echo htmlspecialchars($product['name']) ?></td>
                                        <td><?php echo htmlspecialchars($product['quantity']) ?></td>
                                        <td>
                                            <a href="<?= url('edit_product?id=' . (int)$product['id']) ?>" class="text-decoration-none">
                                                <span class="badge bg-danger">Out of Stock</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No products are low or out of stock.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graph Section -->
<div class="row mt-5 mb-5">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-4 fw-bold">Incoming Orders (Last 7 Days)</h5>
                <div style="height: 350px;">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    let ordersChartInstance = null;

    const initOrdersChart = () => {
        if (ordersChartInstance) return;
        ordersChartInstance = new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: [<?php foreach($graphData as $g) echo "'".date('M d', strtotime($g['date']))."',"; ?>],
                datasets: [{
                    label: 'Orders',
                    data: [<?php foreach($graphData as $g) echo $g['count'].","; ?>],
                    backgroundColor: 'rgba(202, 151, 69, 0.85)',
                    borderColor: '#ca9745',
                    borderWidth: 1,
                    borderRadius: 6,
                    hoverBackgroundColor: '#e0ac5a'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    y: {
                        duration: 1500,
                        easing: 'easeOutBounce' // A nice bouncy end
                    },
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default') {
                            delay = context.dataIndex * 300; // 300ms delay per bar from left to right
                        }
                        return delay;
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1a1a1a',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 8,
                        padding: 12
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { 
                            stepSize: 1,
                            color: 'rgba(150, 150, 150, 0.8)'
                        },
                        grid: { color: 'rgba(200, 200, 200, 0.1)', borderDash: [5, 5] }
                    },
                    x: {
                        ticks: { color: 'rgba(150, 150, 150, 0.8)' },
                        grid: { display: false }
                    }
                }
            }
        });
    };

    // Stock Pie Chart
    const stockCanvas = document.getElementById('stockPieChart');
    let stockChartInstance = null;

    const initStockChart = () => {
        if (!stockCanvas || stockChartInstance) return;
        stockChartInstance = new Chart(stockCanvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Healthy Stock', 'Low Stock', 'Out of Stock'],
                datasets: [{
                    data: [
                        <?php echo $counts['healthy_stock'] ?? 0 ?>,
                        <?php echo $counts['low_stock'] ?? 0 ?>,
                        <?php echo $counts['out_of_stock'] ?? 0 ?>
                    ],
                    backgroundColor: ['#059669', '#D97706', '#DC2626'],
                    hoverBackgroundColor: ['#047857', '#B45309', '#B91C1C'],
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 1500,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#4A5568',
                            font: {
                                family: "'Inter', sans-serif",
                                size: 13,
                                weight: '600'
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1A202C',
                        titleColor: '#F7FAFC',
                        bodyColor: '#F7FAFC',
                        cornerRadius: 8,
                        padding: 12,
                        bodyFont: {
                            family: "'Inter', sans-serif",
                            size: 14
                        }
                    }
                }
            }
        });
    };

    // Intersection Observer for Scroll Animation
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5 // Trigger when 50% visible
    };

    const chartObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.id === 'ordersChart') {
                    if (!ordersChartInstance) {
                        initOrdersChart();
                    } else {
                        // Replay animation every time it comes into view
                        ordersChartInstance.reset();
                        ordersChartInstance.update();
                    }
                } else if (entry.target.id === 'stockPieChart') {
                    if (!stockChartInstance) {
                        initStockChart();
                    } else {
                        // Replay animation
                        stockChartInstance.reset();
                        stockChartInstance.update();
                    }
                }
            }
        });
    }, observerOptions);

    chartObserver.observe(document.getElementById('ordersChart'));
    if (stockCanvas) {
        chartObserver.observe(stockCanvas);
    }
});

async function generateSEOAI(btn) {
    const originalText = btn.innerText;
    
    try {
        btn.disabled = true;
        btn.innerText = "Generating...";

        const apiKey = "<?= GOOGLE_API_KEY ?>";
        const url = `https://generativelanguage.googleapis.com/v1/models/<?= GEMINI_MODEL ?>:generateContent?key=${apiKey}`;

        const body = {
            contents: [{
                parts: [{
                    text: `Return ONLY a valid JSON object for SEO settings for a premium fashion brand named "Stitch Smart".
                    Strict Format: {"title": "...", "description": "...", "keywords": "..."}
                    No conversation, no markdown blocks, just the JSON.`
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
        
        // Robust JSON extraction using Regex
        const jsonMatch = text.match(/\{[\s\S]*\}/);
        if (!jsonMatch) throw new Error("Invalid AI response format.");
        
        const json = JSON.parse(jsonMatch[0]);

        document.getElementById("meta-title").value = json.title || "";
        document.getElementById("meta-description").value = json.description || "";
        document.getElementById("meta-keywords").value = json.keywords || "";

    } catch (err) {
        console.error("AI Error:", err);
        const errorContainer = document.getElementById("ai-error-container");
        if (errorContainer) {
            errorContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show mt-3 border-0 rounded-3 p-3 shadow" role="alert" style="background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.3) !important; color: #ea868f;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>AI Generation failed:</strong> ${err.message}
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger px-3 py-1 rounded-pill" data-bs-dismiss="alert" aria-label="Close" style="font-weight: 600; border-color: rgba(220,53,69,0.5);">OK</button>
                    </div>
                </div>
            `;
        } else {
            alert("AI Generation failed: " + err.message);
        }
    } finally {
        btn.disabled = false;
        btn.innerText = originalText;
    }
}
</script>

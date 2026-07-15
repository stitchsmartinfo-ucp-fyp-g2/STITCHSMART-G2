<style>
/* ── PRODUCT ADVICE HERO ── */
.advice-hero {
    position: relative;
    min-height: 380px;
    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 60px 20px;
    border-bottom: 1px solid rgba(202, 151, 69, 0.2);
}
.advice-hero-content {
    max-width: 650px;
}
.advice-hero h1 {
    font-family: 'Playfair Display', serif !important;
    font-size: clamp(2.5rem, 5vw, 3.8rem);
    font-weight: 900;
    color: #1a0f0a !important;
    margin-bottom: 20px;
    line-height: 1.1;
}
.advice-hero h1 span {
    color: #ca9745 !important;
}
.advice-hero p {
    color: #4a4a4a !important;
    font-size: 1.1rem;
    line-height: 1.7;
    margin-bottom: 0;
}
.advice-hero-divider {
    width: 80px;
    height: 3px;
    background: #ca9745;
    margin: 25px auto;
    border-radius: 2px;
}

/* ── ADVICE CARDS ── */
.advice-section {
    padding: 40px 0 80px;
    background-color: var(--page-bg, #000);
}
.advice-card {
    background: var(--bg-card, #0a0a0a);
    border: 1px solid rgba(202, 151, 69, 0.15);
    border-radius: 16px;
    padding: 40px 30px;
    height: 100%;
    transition: all 0.4s ease;
    text-align: center;
}
.advice-card:hover {
    transform: translateY(-10px);
    border-color: #ca9745;
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}
.advice-icon-wrapper {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: rgba(202, 151, 69, 0.1);
    color: #ca9745;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 25px;
    border: 1px solid rgba(202, 151, 69, 0.25);
    transition: all 0.3s ease;
}
.advice-card:hover .advice-icon-wrapper {
    background: #ca9745;
    color: #fff;
}
.advice-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    color: #ca9745;
    margin-bottom: 15px;
    font-weight: 700;
}
.advice-card p {
    color: var(--page-text, #f4e9d3);
    opacity: 0.8;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 20px;
}
.advice-link {
    display: inline-block;
    color: #ca9745;
    font-weight: 600;
    text-decoration: none;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
    transition: color 0.3s ease;
}
.advice-link i {
    margin-left: 5px;
    transition: transform 0.3s ease;
}
.advice-card:hover .advice-link {
    color: #e8c97a;
}
.advice-card:hover .advice-link i {
    transform: translateX(5px);
}

/* ── CTA SECTION ── */
.advice-cta {
    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);
    padding: 70px 0;
    text-align: center;
    border-top: 1px solid rgba(202, 151, 69, 0.25);
}
.advice-cta h2 {
    font-family: 'Playfair Display', serif !important;
    color: #1a0f0a !important;
    font-size: 2.2rem;
    margin-bottom: 20px;
}
.advice-cta p {
    color: #4a4a4a !important;
    max-width: 600px;
    margin: 0 auto 30px;
    font-size: 1.05rem;
}
.btn-gold {
    background: #ca9745;
    color: #fff;
    padding: 14px 35px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: none;
    display: inline-block;
}
.btn-gold:hover {
    background: #e8c97a;
    color: #1a0f0a;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(202, 151, 69, 0.3);
}
</style>

<div class="advice-page-wrap">
    <!-- Hero Section -->
    <section class="advice-hero">
        <div class="advice-hero-content">
            <h1 class="animate-fade-up">Expert <span>Product Advice</span></h1>
            <div class="advice-hero-divider animate-fade-up"></div>
            <p class="animate-fade-up">Make informed choices with our comprehensive guides. From finding the perfect fit to caring for premium fabrics, we're here to help you elevate your wardrobe.</p>
        </div>
    </section>

    <!-- Advice Cards Section -->
    <section class="advice-section">
        <div class="container">
            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="advice-card">
                        <div class="advice-icon-wrapper">
                            <i class="bi bi-rulers"></i>
                        </div>
                        <h3>Sizing & Fit Guide</h3>
                        <div style="text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;">
                            <p class="mb-2"><strong>Shirts:</strong> Measure around the fullest part of your chest and base of your neck. For sleeves, measure from the center back of your neck to your wrist.</p>
                            <p class="mb-2"><strong>Trousers:</strong> Measure around your natural waistline and from your inner thigh down to the ankle for the perfect inseam.</p>
                            <p class="mb-0"><em>Tip:</em> Always keep the measuring tape comfortably loose, never too tight.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Card 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="advice-card">
                        <div class="advice-icon-wrapper">
                            <i class="bi bi-droplet"></i>
                        </div>
                        <h3>Fabric Care</h3>
                        <div style="text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;">
                            <p class="mb-2"><strong>Cotton:</strong> Machine wash cold with similar colors. Tumble dry low or hang to prevent shrinking.</p>
                            <p class="mb-2"><strong>Silk & Wool:</strong> Dry clean only to maintain the delicate fibers and shape of the garment.</p>
                            <p class="mb-0"><strong>Linen:</strong> Wash in lukewarm water. Iron while the fabric is slightly damp for best results.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="advice-card">
                        <div class="advice-icon-wrapper">
                            <i class="bi bi-star"></i>
                        </div>
                        <h3>Styling Tips</h3>
                        <div style="text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;">
                            <p class="mb-2"><strong>Smart Casual:</strong> Pair a tailored blazer with dark denim and a crisp white shirt for an effortlessly sharp look.</p>
                            <p class="mb-2"><strong>Color Blocking:</strong> Stick to the rule of three — never mix more than three dominant colors in a single outfit.</p>
                            <p class="mb-0"><strong>Accessories:</strong> Match your belt with your shoes (especially leathers) for a cohesive and polished appearance.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="advice-card">
                        <div class="advice-icon-wrapper">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3>Material Guide</h3>
                        <div style="text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;">
                            <p class="mb-2"><strong>Egyptian Cotton:</strong> Highly breathable and soft, perfect for everyday luxury dress shirts.</p>
                            <p class="mb-2"><strong>Merino Wool:</strong> Temperature-regulating and wrinkle-resistant, ideal for suits and fine knitwear.</p>
                            <p class="mb-0"><strong>Linen:</strong> Lightweight and highly absorbent, the ultimate choice for summer elegance.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="advice-card">
                        <div class="advice-icon-wrapper">
                            <i class="bi bi-palette"></i>
                        </div>
                        <h3>Color Matching</h3>
                        <div style="text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;">
                            <p class="mb-2"><strong>Monochromatic:</strong> Wearing different shades of the same color creates a slimming, sophisticated profile.</p>
                            <p class="mb-2"><strong>Neutrals:</strong> Navy, grey, black, and white are foundational. Pair them with one accent color to stand out.</p>
                            <p class="mb-0"><strong>Skin Tones:</strong> Warmer skin tones look great in earthy colors, while cooler tones shine in blues and greys.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="advice-card">
                        <div class="advice-icon-wrapper">
                            <i class="bi bi-scissors"></i>
                        </div>
                        <h3>Custom Tailoring</h3>
                        <div style="text-align: left; color: var(--page-text, #f4e9d3); opacity: 0.85; font-size: 0.95rem; line-height: 1.6;">
                            <p class="mb-2"><strong>Alterations:</strong> Even off-the-rack garments look custom-made when tailored. Prioritize adjusting sleeve length and waist.</p>
                            <p class="mb-0"><strong>Custom Orders:</strong> When ordering bespoke, communicate your typical fit issues (e.g., broad shoulders) so our master tailors can adjust the pattern accordingly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="advice-cta">
        <div class="container">
            <h2>Need Personalized Assistance?</h2>
            <p>Our style experts and tailors are always available to help you make the right choice.</p>
            <a href="<?= url('contact') ?>" class="btn-gold">Contact Support</a>
        </div>
    </section>
</div>

<script>
    // Simple fade-up animation for hero
    document.addEventListener("DOMContentLoaded", function() {
        const heroElements = document.querySelectorAll('.animate-fade-up');
        heroElements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = `opacity 0.8s ease ${index * 0.15}s, transform 0.8s ease ${index * 0.15}s`;
            
            setTimeout(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, 50);
        });
    });
</script>

<style>
/* ── SHIPPING HERO ── */
.shipping-hero {
    position: relative;
    min-height: 380px;
    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 60px 20px;
    border-bottom: 1px solid rgba(202, 151, 69, 0.25);
}
.shipping-hero-content {
    max-width: 650px;
}
.shipping-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.5rem, 5vw, 3.8rem);
    font-weight: 900;
    color: #1a0f0a;
    margin-bottom: 20px;
    line-height: 1.1;
}
.shipping-hero h1 span {
    color: #ca9745;
}
.shipping-hero p {
    color: #4a4a4a;
    font-size: 1.1rem;
    line-height: 1.7;
    margin-bottom: 0;
}
.shipping-hero-divider {
    width: 80px;
    height: 3px;
    background: #ca9745;
    margin: 25px auto;
    border-radius: 2px;
}

/* ── SHIPPING INFO SECTION ── */
.shipping-section {
    padding: 40px 0 80px;
    background-color: var(--page-bg, #000);
}
.shipping-card {
    background: var(--bg-card, #0a0a0a);
    border: 1px solid rgba(202, 151, 69, 0.15);
    border-radius: 16px;
    padding: 40px 30px;
    height: 100%;
    transition: all 0.4s ease;
    text-align: left;
}
.shipping-card:hover {
    transform: translateY(-5px);
    border-color: #ca9745;
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}
.shipping-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: rgba(202, 151, 69, 0.1);
    color: #ca9745;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    margin-bottom: 25px;
    border: 1px solid rgba(202, 151, 69, 0.25);
}
.shipping-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    color: #ca9745;
    margin-bottom: 15px;
    font-weight: 700;
}
.shipping-card p {
    color: var(--page-text, #f4e9d3);
    opacity: 0.85;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 15px;
}
.shipping-badge {
    display: inline-block;
    padding: 6px 12px;
    background: rgba(202, 151, 69, 0.1);
    color: #ca9745;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 15px;
    border: 1px solid rgba(202, 151, 69, 0.2);
}

/* ── TRACKING CTA ── */
.shipping-cta {
    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);
    padding: 70px 0;
    text-align: center;
    border-top: 1px solid rgba(202, 151, 69, 0.25);
}
.shipping-cta h2 {
    font-family: 'Playfair Display', serif;
    color: #1a0f0a;
    font-size: 2.2rem;
    margin-bottom: 20px;
}
.shipping-cta p {
    color: #4a4a4a;
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

<div class="shipping-page-wrap">
    <!-- Hero Section -->
    <section class="shipping-hero">
        <div class="shipping-hero-content">
            <h1 class="animate-fade-up">Shipping & <span>Delivery</span></h1>
            <div class="shipping-hero-divider animate-fade-up"></div>
            <p class="animate-fade-up">Fast, reliable, and premium delivery services to ensure your tailored garments arrive in perfect condition, exactly when you expect them.</p>
        </div>
    </section>

    <!-- Shipping Cards Section -->
    <section class="shipping-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                
                <!-- Standard Shipping -->
                <div class="col-md-6 col-lg-4">
                    <div class="shipping-card animate-fade-up">
                        <div class="shipping-icon-wrapper">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="shipping-badge">Free Over Rs. 5,000</div>
                        <h3>Standard Delivery</h3>
                        <p>Enjoy our reliable standard shipping for everyday orders. Deliveries typically arrive within 3-5 business days once your garments are dispatched from our tailoring house.</p>
                        <p><strong>Cost:</strong> Free for orders over Rs. 5,000, otherwise standard flat rates apply.</p>
                    </div>
                </div>

                <!-- Express Delivery -->
                <div class="col-md-6 col-lg-4">
                    <div class="shipping-card animate-fade-up" style="transition-delay: 0.1s;">
                        <div class="shipping-icon-wrapper">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <div class="shipping-badge">Next Day Options</div>
                        <h3>Express Shipping</h3>
                        <p>Need it sooner? Select our Express Shipping option at checkout for priority processing and expedited delivery within 1-2 business days.</p>
                        <p>Perfect for last-minute events and urgent tailoring requests.</p>
                    </div>
                </div>

                <!-- Custom Orders Processing -->
                <div class="col-md-6 col-lg-4">
                    <div class="shipping-card animate-fade-up" style="transition-delay: 0.2s;">
                        <div class="shipping-icon-wrapper">
                            <i class="bi bi-scissors"></i>
                        </div>
                        <div class="shipping-badge">Bespoke Timeline</div>
                        <h3>Custom Orders Processing</h3>
                        <p>Due to the meticulous nature of custom tailoring, bespoke orders require a crafting period of 10-14 days before they are shipped.</p>
                        <p>You will receive status updates as your garment moves from cutting to final stitching.</p>
                    </div>
                </div>

                <!-- International Shipping -->
                <div class="col-md-6 col-lg-4">
                    <div class="shipping-card animate-fade-up">
                        <div class="shipping-icon-wrapper">
                            <i class="bi bi-globe"></i>
                        </div>
                        <h3>International Shipping</h3>
                        <p>We proudly ship our premium garments worldwide. International delivery times vary depending on the destination and local customs processing (typically 7-14 days).</p>
                        <p><strong>Note:</strong> Customers are responsible for any import duties or taxes.</p>
                    </div>
                </div>

                <!-- Package Tracking -->
                <div class="col-md-6 col-lg-4">
                    <div class="shipping-card animate-fade-up" style="transition-delay: 0.1s;">
                        <div class="shipping-icon-wrapper">
                            <i class="bi bi-pin-map"></i>
                        </div>
                        <h3>Order Tracking</h3>
                        <p>Once your order is dispatched, you will receive a tracking link via SMS. You can monitor your package's journey from our workshop directly to your doorstep.</p>
                        <p>All premium shipments are fully insured for your peace of mind.</p>
                    </div>
                </div>
                
                <!-- Returns & Issues -->
                <div class="col-md-6 col-lg-4">
                    <div class="shipping-card animate-fade-up" style="transition-delay: 0.2s;">
                        <div class="shipping-icon-wrapper">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </div>
                        <h3>Delivery Issues</h3>
                        <p>In the rare event that your package is delayed, damaged, or lost in transit, our support team will resolve the issue immediately.</p>
                        <p>Simply reach out via our contact page, and we will initiate a replacement or investigation.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="shipping-cta">
        <div class="container">
            <h2>Track Your Order or Need Help?</h2>
            <p>If you have any questions regarding an existing shipment, please contact our dispatch team through the support portal.</p>
            <a href="<?= url('contact') ?>" class="btn-gold">Contact Support</a>
        </div>
    </section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const elements = document.querySelectorAll('.animate-fade-up');
        elements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = `opacity 0.8s ease, transform 0.8s ease`;
            
            setTimeout(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, 50 + (index * 50)); 
        });
    });
</script>

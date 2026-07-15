<style>
/* ── HOW TO ORDER HERO ── */
.order-hero {
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
.order-hero-content {
    max-width: 650px;
}
.order-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.5rem, 5vw, 3.8rem);
    font-weight: 900;
    color: #1a0f0a;
    margin-bottom: 20px;
    line-height: 1.1;
}
.order-hero h1 span {
    color: #ca9745;
}
.order-hero p {
    color: #4a4a4a;
    font-size: 1.1rem;
    line-height: 1.7;
    margin-bottom: 0;
}
.order-divider {
    width: 80px;
    height: 3px;
    background: #ca9745;
    margin: 25px auto;
    border-radius: 2px;
}

/* ── STEPS SECTION ── */
.steps-section {
    padding: 40px 0 80px;
    background-color: var(--page-bg, #000);
}
.step-container {
    max-width: 900px;
    margin: 0 auto;
}
.step-card {
    background: var(--bg-card, #0a0a0a);
    border: 1px solid rgba(202, 151, 69, 0.15);
    border-radius: 16px;
    padding: 40px 50px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 40px;
    transition: all 0.4s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
.step-card:hover {
    transform: translateX(10px);
    border-color: #ca9745;
}
.step-number {
    flex-shrink: 0;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ca9745, #e8c97a);
    color: #1a0f0a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 900;
    font-family: 'Playfair Display', serif;
    border: 4px solid var(--bg-card, #0a0a0a);
    outline: 2px solid #ca9745;
}
.step-content {
    flex-grow: 1;
}
.step-content h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    color: #ca9745;
    margin-bottom: 15px;
    font-weight: 700;
}
.step-content p {
    color: var(--page-text, #f4e9d3);
    opacity: 0.85;
    font-size: 1.05rem;
    line-height: 1.7;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .step-card {
        flex-direction: column;
        text-align: center;
        padding: 40px 30px;
        gap: 20px;
    }
    .step-card:hover {
        transform: translateY(-10px);
    }
}

/* ── CTA SECTION ── */
.order-cta {
    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);
    padding: 70px 0;
    text-align: center;
    border-top: 1px solid rgba(202, 151, 69, 0.25);
}
.order-cta h2 {
    font-family: 'Playfair Display', serif;
    color: #1a0f0a;
    font-size: 2.2rem;
    margin-bottom: 20px;
}
.order-cta p {
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

<div class="order-page-wrap">
    <!-- Hero Section -->
    <section class="order-hero">
        <div class="order-hero-content">
            <h1 class="animate-fade-up">How to <span>Order</span></h1>
            <div class="order-divider animate-fade-up"></div>
            <p class="animate-fade-up">Experiencing premium tailoring has never been easier. Follow our simple four-step process to get your bespoke garments crafted to perfection.</p>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="steps-section">
        <div class="container">
            <div class="step-container">
                
                <!-- Step 1 -->
                <div class="step-card animate-fade-up">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Select Your Style</h3>
                        <p>Browse through our exclusive collections. Whether you're looking for a sharp business suit, an elegant evening dress, or custom casual wear, choose the design that speaks to you.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step-card animate-fade-up" style="transition-delay: 0.1s;">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Provide Measurements</h3>
                        <p>For custom items, simply follow our easy-to-use measurement guide online. Enter your exact specifications, or choose standard sizing if you prefer an off-the-rack fit.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step-card animate-fade-up" style="transition-delay: 0.2s;">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Secure Checkout</h3>
                        <p>Review your order details and proceed to our encrypted checkout. We offer a 50% upfront deposit option for large custom orders and accept all major secure payment methods.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="step-card animate-fade-up" style="transition-delay: 0.3s;">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Crafting & Delivery</h3>
                        <p>Our master tailors immediately begin crafting your piece. You will receive updates along the way. Once perfected, your garment is securely shipped straight to your door.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="order-cta">
        <div class="container">
            <h2>Ready to Elevate Your Wardrobe?</h2>
            <p>Start browsing our latest premium collections and experience the true art of bespoke tailoring today.</p>
            <a href="<?= url('allproducts') ?>" class="btn-gold">Shop Now</a>
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
            }, 50 + (index * 100)); 
        });
    });
</script>

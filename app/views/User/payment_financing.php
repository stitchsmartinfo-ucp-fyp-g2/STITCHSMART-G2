<style>
/* ── PAYMENT & FINANCING HERO ── */
.finance-hero {
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
.finance-hero-content {
    max-width: 650px;
}
.finance-hero h1 {
    font-family: 'Playfair Display', serif !important;
    font-size: clamp(2.5rem, 5vw, 3.8rem);
    font-weight: 900;
    color: #1a0f0a !important;
    margin-bottom: 20px;
    line-height: 1.1;
}
.finance-hero h1 span {
    color: #ca9745 !important;
}
.finance-hero p {
    color: #4a4a4a !important;
    font-size: 1.1rem;
    line-height: 1.7;
    margin-bottom: 0;
}
.finance-hero-divider {
    width: 80px;
    height: 3px;
    background: #ca9745;
    margin: 25px auto;
    border-radius: 2px;
}

/* ── SECURE PAYMENT SECTION ── */
.payment-section {
    padding: 40px 0 80px;
    background-color: var(--page-bg, #000);
}
.payment-card {
    background: var(--bg-card, #0a0a0a);
    border: 1px solid rgba(202, 151, 69, 0.15);
    border-radius: 16px;
    padding: 40px 30px;
    height: 100%;
    transition: all 0.4s ease;
    text-align: left;
}
.payment-card:hover {
    transform: translateY(-5px);
    border-color: #ca9745;
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}
.payment-icon-wrapper {
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
.payment-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    color: #ca9745;
    margin-bottom: 15px;
    font-weight: 700;
}
.payment-card p {
    color: var(--page-text, #f4e9d3);
    opacity: 0.85;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 10px;
}
.payment-card ul li {
    color: #f9db7e !important;
    opacity: 1 !important;
}
.payment-logos {
    display: flex;
    gap: 15px;
    margin-top: 20px;
    font-size: 1.5rem;
    color: #a0a0a0;
}

/* ── FINANCING CTA ── */
.finance-cta {
    background: linear-gradient(135deg, #fffcf7 0%, #fdf5e6 45%, #f9ebd0 100%);
    padding: 70px 0;
    text-align: center;
    border-top: 1px solid rgba(202, 151, 69, 0.25);
}
.finance-cta h2 {
    font-family: 'Playfair Display', serif !important;
    color: #1a0f0a !important;
    font-size: 2.2rem;
    margin-bottom: 20px;
}
.finance-cta p {
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

<div class="finance-page-wrap">
    <!-- Hero Section -->
    <section class="finance-hero">
        <div class="finance-hero-content">
            <h1 class="animate-fade-up">Payment & <span>Financing</span></h1>
            <div class="finance-hero-divider animate-fade-up"></div>
            <p class="animate-fade-up">Experience seamless, secure, and flexible payment options tailored for your convenience. Shop our premium collections with complete peace of mind.</p>
        </div>
    </section>

    <!-- Payment Cards Section -->
    <section class="payment-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                
                <!-- Secure Checkout -->
                <div class="col-md-6 col-lg-4">
                    <div class="payment-card">
                        <div class="payment-icon-wrapper">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h3>100% Secure Checkout</h3>
                        <p>Your security is our top priority. All transactions are encrypted using state-of-the-art SSL technology to protect your personal and payment information.</p>
                        <p>We do not store your credit card details on our servers, ensuring an industry-leading standard of data protection.</p>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="col-md-6 col-lg-4">
                    <div class="payment-card">
                        <div class="payment-icon-wrapper">
                            <i class="bi bi-credit-card-2-front"></i>
                        </div>
                        <h3>Accepted Payment Methods</h3>
                        <p>We accept all major global credit and debit cards for instant, hassle-free checkout.</p>

                    </div>
                </div>

                <!-- Financing / Buy Now Pay Later -->
                <div class="col-md-6 col-lg-4">
                    <div class="payment-card">
                        <div class="payment-icon-wrapper">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <h3>Flexible Financing</h3>
                        <p>Luxury should be accessible. Take advantage of our "Buy Now, Pay Later" options to split your purchase into manageable installments.</p>
                        <p><strong>Pay in 4:</strong> Split your total into 4 interest-free payments billed every two weeks.</p>
                    </div>
                </div>

                <!-- Custom Orders -->
                <div class="col-md-6 col-lg-4">
                    <div class="payment-card">
                        <div class="payment-icon-wrapper">
                            <i class="bi bi-scissors"></i>
                        </div>
                        <h3>Custom Tailoring Deposits</h3>
                        <p>For bespoke and custom tailoring orders, we require a 50% upfront deposit to begin crafting your garment.</p>
                        <p>The remaining 50% balance is charged only when your garment is ready to be shipped. We will notify you via email with a final invoice link.</p>
                    </div>
                </div>
                
                <!-- Refunds -->
                <div class="col-md-6 col-lg-4">
                    <div class="payment-card">
                        <div class="payment-icon-wrapper">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </div>
                        <h3>Refunds & Processing</h3>
                        <p>If a refund is issued according to our return policy, the funds will be automatically credited back to your original payment method.</p>
                        <p>Please allow 3-5 business days for the amount to reflect in your account, depending on your bank's processing times.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="finance-cta">
        <div class="container">
            <h2>Have Payment Questions?</h2>
            <p>If you're having trouble with checkout or want to discuss financing for a bulk custom order, our billing team is here to assist you.</p>
            <a href="<?= url('contact') ?>" class="btn-gold">Contact Support</a>
        </div>
    </section>
</div>

<script>
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

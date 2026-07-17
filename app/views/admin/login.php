<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StitchSmart | Admin Portal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@100;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>css/admin/base.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/admin/<?= $theme ?>.css">

    <style>
        :root {
            --luxury-grad: linear-gradient(135deg, #1a0f0a 0%, #3d241c 100%);
            --default-grad: linear-gradient(135deg, #3d241c 0%, #ca9745 100%);
            --accent-bronze: #ca9745;
            --accent-brown: #3d241c;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f4f7f6;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1100px;
            display: flex;
            background: #fff;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 30px 100px rgba(0,0,0,0.15);
        }

        /* Left Panel (Form) */
        .login-left {
            flex: 1;
            padding: 60px;
            color: #fff;
            position: relative;
            background: <?= ($theme === 'theme-luxury') ? 'var(--luxury-grad)' : 'var(--default-grad)' ?>;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
            opacity: 0.1;
        }

        .brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 900;
            margin-bottom: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 2;
            letter-spacing: -0.5px;
        }

        .brand-logo .stitch { color: #ffffff; } /* In the dark panel, we use white for 'Stitch' to ensure contrast */
        .brand-logo .smart { color: var(--accent-bronze); }

        .admin-badge {
            font-size: 0.7rem;
            padding: 6px 15px;
            background: rgba(255,255,255,0.2);
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
        }

        .login-content {
            position: relative;
            z-index: 2;
        }

        .login-content h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 3.5rem;
            margin-bottom: 10px;
            letter-spacing: -1px;
            color: #fff;
        }

        .login-content p {
            color: rgba(255,255,255,0.7);
            margin-bottom: 40px;
            font-size: 1.1rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: rgba(255,255,255,0.9);
            display: block;
        }

        .form-control {
            background: rgba(255,255,255,0.1) !important;
            border: 1px solid rgba(255,255,255,0.2) !important;
            padding: 15px 20px !important;
            border-radius: 15px !important;
            color: #fff !important;
            font-size: 1rem;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.4);
        }

        .form-control:focus {
            background: rgba(255,255,255,0.15) !important;
            border-color: #fff !important;
            box-shadow: none !important;
            caret-color: #fff;
        }

        /* Fix browser autocomplete white background overriding dark input */
        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #2a1810 inset !important;
            -webkit-text-fill-color: #fff !important;
            caret-color: #fff !important;
            border: 1px solid rgba(255,255,255,0.2) !important;
            border-radius: 15px !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .extra-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            margin-bottom: 35px;
        }

        .extra-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--accent-bronze);
            color: #1a0f0a;
            border: none;
            border-radius: 15px;
            font-weight: 800;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            background: #ca9745;
        }

        /* Right Panel (Illustration) */
        .login-right {
            flex: 0.8;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        .illustration-container {
            text-align: center;
            max-width: 80%;
            z-index: 2;
        }

        .decor-circle {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: <?= ($theme === 'theme-luxury') ? 'rgba(61, 36, 28, 0.05)' : 'rgba(202, 151, 69, 0.05)' ?>;
            z-index: 1;
        }

        .decor-1 { top: -100px; right: -100px; }
        .decor-2 { bottom: -50px; left: -50px; }

        @media (max-width: 992px) {
            .login-right { display: none; }
            .login-left { border-radius: 30px; }
        }

        .footer-text {
            position: absolute;
            bottom: 30px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.4);
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <!-- Left Section (Form) -->
        <div class="login-left">
            <div class="brand-logo">
                <div><span class="stitch">Stitch</span><span class="smart">Smart</span></div>
                <div class="admin-badge">Super Admin</div>
            </div>

            <div class="login-content">
                <h1>LOGIN</h1>
                <p>Welcome Back! Access your admin dashboard securely.</p>

                <?php if(isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger p-3 text-center" style="font-size: 0.95rem; background: rgba(239, 68, 68, 0.15); border: 2px solid #ef4444; color: #fecaca; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
                        <i class="bi bi-exclamation-circle me-2"></i><?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($_SESSION['login_success'])): ?>
                    <div class="alert alert-success p-2 text-center" style="font-size: 0.9rem; background: rgba(74, 222, 128, 0.1); border: 1px solid rgba(74, 222, 128, 0.2); color: #4ade80; border-radius: 12px; margin-bottom: 20px;"><?= $_SESSION['login_success']; unset($_SESSION['login_success']); ?></div>
                <?php endif; ?>

                <form action="<?php echo url('') ?>admin_login" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="admin@stitchsmart.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <div class="extra-links">
                        <div>
                            <input type="checkbox" id="remember" class="form-check-input me-1">
                            <label for="remember">Remember Me</label>
                        </div>
                        <a href="<?php echo url('') ?>admin_forgot_password">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="bi bi-shield-lock-fill"></i> Login
                    </button>
                </form>
            </div>

            <div class="footer-text">
                © 2026 Stitch-Smart Admin Panel | Security Verified
            </div>
        </div>

        <!-- Right Section (Illustration) -->
        <div class="login-right">
            <div class="decor-circle decor-1"></div>
            <div class="decor-circle decor-2"></div>
            
            <div class="illustration-container">
                <!-- Professional Fashion Tech Illustration -->
                <div class="mb-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/9334/9334346.png" width="350" alt="ERP Design" class="img-fluid" style="filter: drop-shadow(0 10px 20px rgba(0,0,0,0.1));">
                </div>
                
                <div class="brand-logo justify-content-center mb-2" style="font-size: 2.8rem; font-family: 'Playfair Display', serif;">
                    <span style="color: var(--accent-brown);">Stitch</span><span style="color: var(--accent-bronze);">Smart</span>
                </div>
                <h5 class="fw-bold mb-3" style="color: #ca9745 !important; opacity: 1 !important; font-weight: 900 !important; letter-spacing: 1px;">PREMIUM ERP SYSTEM</h5>
                <p class="text-muted" style="font-size: 0.95rem; line-height: 1.6;">Managed with precision. <br>Designed with passion.</p>
                
                <div class="mt-4 opacity-50">
                    <i class="bi bi-gem fs-2 mx-2"></i>
                    <i class="bi bi-stars fs-2 mx-2"></i>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
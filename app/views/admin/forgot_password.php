<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StitchSmart | Password Recovery</title>
    
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
            color: #fff;
        }

        .recovery-card {
            width: 100%;
            max-width: 500px;
            background: <?= ($theme === 'theme-luxury') ? 'var(--luxury-grad)' : 'var(--default-grad)' ?>;
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 30px 100px rgba(0,0,0,0.15);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .recovery-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
            opacity: 0.1;
            pointer-events: none;
        }

        .brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 900;
            margin-bottom: 30px;
        }

        .brand-logo .stitch { color: #ffffff; }
        .brand-logo .smart { color: var(--accent-bronze); }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--accent-bronze);
        }

        p {
            color: rgba(255,255,255,0.7);
            margin-bottom: 35px;
            font-size: 1rem;
            line-height: 1.6;
        }

        .form-control {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            padding: 15px 20px !important;
            border-radius: 15px !important;
            color: #fff !important;
            margin-bottom: 25px;
        }

        .btn-recover {
            width: 100%;
            padding: 16px;
            background: var(--accent-bronze);
            color: #1a0f0a;
            border: none;
            border-radius: 15px;
            font-weight: 800;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-recover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(205, 154, 72, 0.3);
            background: #ca9745;
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: var(--accent-bronze);
        }

        .success-msg {
            background: rgba(74, 222, 128, 0.1);
            border: 1px solid rgba(74, 222, 128, 0.2);
            color: #4ade80;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: none;
        }
    </style>
</head>
<body>

    <div class="recovery-card">
        <div class="brand-logo">
            <span class="stitch">Stitch</span><span class="smart">Smart</span>
        </div>

        <h2>Password Recovery</h2>

        <?php if(isset($_SESSION['forgot_error'])): ?>
            <div class="alert alert-danger p-2 text-center" style="font-size: 0.9rem; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; border-radius: 8px; margin-bottom: 20px;"><?= $_SESSION['forgot_error']; unset($_SESSION['forgot_error']); ?></div>
        <?php endif; ?>
        <?php if(isset($_SESSION['forgot_success'])): ?>
            <div class="alert alert-success p-2 text-center" style="font-size: 0.9rem; background: rgba(74, 222, 128, 0.1); border: 1px solid rgba(74, 222, 128, 0.2); color: #4ade80; border-radius: 8px; margin-bottom: 20px;"><?= $_SESSION['forgot_success']; unset($_SESSION['forgot_success']); ?></div>
        <?php endif; ?>

        <?php 
        $step = $_SESSION['reset_step_admin'] ?? 'request'; 
        ?>

        <?php if ($step === 'request'): ?>
            <p>Enter your registered administrator email address and we'll send you a One-Time Password (OTP) to recover your account.</p>
            <form method="POST" action="<?= url('') ?>admin_forgot_password">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                <input type="email" name="email" class="form-control" placeholder="admin@stitchsmart.com" required autocomplete="off">
                <button type="submit" class="btn-recover">
                    Send OTP Code
                </button>
            </form>
            <a href="<?= url('') ?>admin_login" class="back-link">
                <i class="bi bi-arrow-left me-1"></i> Back to Login
            </a>

        <?php elseif ($step === 'verify_otp'): ?>
            <p>A 6-digit OTP has been sent to your administrator Gmail. Please enter it below to verify.</p>
            <form method="POST" action="<?= url('') ?>admin_forgot_password">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                <input type="text" name="otp" class="form-control text-center text-white" placeholder="••••••" required maxlength="6" style="font-size: 1.5rem; letter-spacing: 5px; font-weight: bold; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px;">
                <button type="submit" class="btn-recover">
                    Verify OTP
                </button>
            </form>
            <a href="<?= url('admin_forgot_password?action=cancel') ?>" class="back-link" style="color: #ccc;">
                Cancel & Start Over
            </a>

        <?php elseif ($step === 'reset_password'): ?>
            <p>Your identity has been verified. Please enter your new administrator password below.</p>
            <form method="POST" action="<?= url('') ?>admin_forgot_password">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                <input type="password" name="password" class="form-control" placeholder="New Password" required minlength="4" style="margin-bottom: 15px;">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required minlength="4" style="margin-bottom: 20px;">
                <button type="submit" class="btn-recover">
                    Reset Password
                </button>
            </form>
            <a href="<?= url('admin_forgot_password?action=cancel') ?>" class="back-link" style="color: #ccc;">
                Cancel & Start Over
            </a>
        <?php endif; ?>
    </div>

</body>
</html>

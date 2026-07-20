<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StitchSmart | Password Recovery</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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
            background: var(--luxury-grad);
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 30px 100px rgba(0,0,0,0.15);
            border: 1px solid rgba(255,255,255,0.1);
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
        .brand-logo .smart  { color: var(--accent-bronze); }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--accent-bronze);
        }

        p {
            color: rgba(255,255,255,0.7);
            margin-bottom: 30px;
            font-size: 1rem;
            line-height: 1.6;
        }

        .form-control {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            padding: 15px 20px !important;
            border-radius: 15px !important;
            color: #fff !important;
            margin-bottom: 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.08) !important;
            box-shadow: 0 0 0 3px rgba(205,154,72,0.25) !important;
            border-color: rgba(205,154,72,0.5) !important;
            color: #fff !important;
            outline: none;
        }
        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover, 
        .form-control:-webkit-autofill:focus, 
        .form-control:-webkit-autofill:active {
            transition: background-color 5000s ease-in-out 0s !important;
            -webkit-text-fill-color: #fff !important;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.3); }

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
            cursor: pointer;
        }
        .btn-recover:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(205,154,72,0.3);
            background: #ca9745;
        }
        .btn-recover:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            transform: none;
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        .back-link:hover { color: var(--accent-bronze); }

        .alert-err {
            background: rgba(239, 68, 68, 0.15);
            border-left: 4px solid #ef4444;
            color: #ef4444;
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        .alert-err::before {
            content: '\F3E0'; /* bi-exclamation-triangle-fill */
            font-family: 'bootstrap-icons';
            margin-right: 12px;
            font-size: 1.2rem;
        }
        .alert-ok {
            background: rgba(74, 222, 128, 0.15);
            border-left: 4px solid #4ade80;
            color: #4ade80;
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        .alert-ok::before {
            content: '\F26B'; /* bi-check-circle-fill */
            font-family: 'bootstrap-icons';
            margin-right: 12px;
            font-size: 1.2rem;
        }

        /* ── Timer ring ── */
        .timer-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 22px;
        }
        .ring-container {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 90px; height: 90px;
        }
        .ring-svg { transform: rotate(-90deg); }
        .ring-bg   { fill: none; stroke: rgba(255,255,255,0.08); stroke-width: 6; }
        .ring-fill {
            fill: none;
            stroke: var(--accent-bronze);
            stroke-width: 6;
            stroke-linecap: round;
            stroke-dasharray: 220;
            stroke-dashoffset: 0;
            transition: stroke-dashoffset 1s linear, stroke .4s;
        }
        .ring-num {
            position: absolute;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--accent-bronze);
            transition: color .4s;
        }
        .ring-label {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.35);
            margin-top: 6px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .otp-input {
            font-size: 1.8rem !important;
            letter-spacing: 10px !important;
            font-weight: 800 !important;
            text-align: center;
        }

        .recovery-card.theme-luxury {
            background: linear-gradient(135deg, #1a0f0a 0%, #3d241c 100%);
            border: 1px solid rgba(202, 151, 69, 0.2);
            color: #f4e9d3;
        }
        
        .recovery-card.theme-default {
            background: #ffffff;
            border: 1px solid rgba(92, 60, 38, 0.15);
            color: #1a1a1a;
            box-shadow: 0 15px 40px rgba(0,0,0,0.05);
        }
        
        body.theme-default {
            background: #fdfcf9;
            color: #1a1a1a;
        }
        
        body.theme-luxury {
            background: #000000;
            color: #ffffff;
        }

        .recovery-card.theme-default .brand-logo .stitch { color: #1a1a1a; }
        .recovery-card.theme-default p { color: #5c4335; }
        .recovery-card.theme-default .form-control {
            background: #f4f7f6 !important;
            border: 1px solid rgba(92, 60, 38, 0.2) !important;
            color: #1a1a1a !important;
        }
        .recovery-card.theme-default .form-control::placeholder { color: #7a6253; }
        .recovery-card.theme-default .back-link { color: #5c4335; }
        .recovery-card.theme-default .back-link:hover { color: #ca9745; }
        .recovery-card.theme-default .ring-label { color: #7a6253; }
    </style>
</head>
<body class="<?= $global_theme ?? 'theme-luxury' ?>">

<?php $step = $_SESSION['reset_step_customer'] ?? 'request'; ?>

<div class="recovery-card <?= $global_theme ?? 'theme-luxury' ?>">

    <div class="brand-logo">
        <span class="stitch">Stitch</span><span class="smart">Smart</span>
    </div>

    <h2>Password Recovery</h2>

    <?php if(isset($_SESSION['forgot_error'])): ?>
        <div class="alert-err"><?= $_SESSION['forgot_error']; unset($_SESSION['forgot_error']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['forgot_success'])): ?>
        <div class="alert-ok"><?= $_SESSION['forgot_success']; unset($_SESSION['forgot_success']); ?></div>
    <?php endif; ?>


    <?php if ($step === 'request'): ?>
    <!-- ── PAGE 1: EMAIL ── -->
        <p>Please enter your registered email address, and we will send you a verification code to recover your account.</p>
        <form method="POST" action="<?= url('') ?>customer_forgot_password_process">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <input type="email" name="email" class="form-control"
                   placeholder="your@email.com" required autocomplete="off">
            <button type="submit" class="btn-recover">Send Verification Code</button>
        </form>
        <a href="<?= url('') ?>customer_login" class="back-link">
            <i class="bi bi-arrow-left me-1"></i> Back to Login
        </a>


    <?php elseif ($step === 'verify_otp'): ?>
    <!-- ── PAGE 2: TIMER + OTP ── -->
        <p>A 6-digit verification code has been sent to <strong style="color:var(--accent-bronze)"><?= htmlspecialchars($_SESSION['reset_email_customer'] ?? '') ?></strong>. Please enter it below before the timer expires.</p>

        <!-- SVG Ring Timer -->
        <div class="timer-wrap">
            <div class="ring-container">
                <svg class="ring-svg" width="90" height="90" viewBox="0 0 90 90">
                    <circle class="ring-bg"   cx="45" cy="45" r="35"/>
                    <circle class="ring-fill" cx="45" cy="45" r="35" id="ring-fill"/>
                </svg>
                <span class="ring-num" id="ring-num">60</span>
            </div>
            <div class="ring-label">Seconds Remaining</div>
        </div>

        <form method="POST" action="<?= url('') ?>customer_forgot_password_process" id="otp-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <input type="text" name="otp" id="otp-input"
                   class="form-control otp-input"
                   placeholder="••••••"
                   required maxlength="6"
                   autocomplete="one-time-code">
            <button type="submit" id="verify-btn" class="btn-recover">Verify Code</button>
        </form>
        <a href="<?= url('customer_forgot_password_process?action=cancel') ?>" class="back-link">
            Cancel &amp; Start Over
        </a>

        <script>
        (function(){
            var TOTAL   = 60;
            var sec     = TOTAL;
            var CIRC    = 2 * Math.PI * 35;
            var numEl   = document.getElementById('ring-num');
            var fillEl  = document.getElementById('ring-fill');
            var btn     = document.getElementById('verify-btn');
            var inp     = document.getElementById('otp-input');
            var cancel  = "<?= url('customer_forgot_password_process?action=cancel') ?>";

            fillEl.style.strokeDasharray  = CIRC;
            fillEl.style.strokeDashoffset = 0;

            var iv = setInterval(function(){
                sec--;
                numEl.textContent = sec;
                fillEl.style.strokeDashoffset = CIRC * (1 - sec / TOTAL);

                if(sec <= 10){
                    fillEl.style.stroke = '#ef4444';
                    numEl.style.color   = '#ef4444';
                }
                if(sec <= 0){
                    clearInterval(iv);
                    inp.disabled = true;
                    btn.disabled = true;
                    btn.textContent = 'Code Expired';
                    setTimeout(function(){ window.location.href = cancel; }, 1200);
                }
            }, 1000);
        })();
        </script>


    <?php elseif ($step === 'reset_password'): ?>
    <!-- ── PAGE 3: NEW PASSWORD ── -->
        <form method="POST" action="<?= url('') ?>customer_forgot_password_process">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
            <input type="password" name="password"         class="form-control" placeholder="New Password"     required minlength="4">
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required minlength="4" style="margin-bottom:25px;">
            <button type="submit" class="btn-recover">Reset Password</button>
        </form>
        <a href="<?= url('customer_forgot_password_process?action=cancel') ?>" class="back-link">
            Cancel &amp; Start Over
        </a>

    <?php endif; ?>

</div>
</body>
</html>

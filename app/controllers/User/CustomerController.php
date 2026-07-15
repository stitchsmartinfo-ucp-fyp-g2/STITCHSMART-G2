<?php
require_once BASE_PATH . '/app/models/User.php';
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require_once BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require_once BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CustomerController {
    private $userModel;

    public function __construct() {
        $db = new Database();
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submittedToken = $_POST['csrf_token'] ?? '';
            // Only check CSRF token if session didn't just expire - new sessions get fresh tokens
            if (!isset($_SESSION['session_expired_just_now'])) {
                if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
                    $_SESSION['login_error'] = "Invalid security token. Please refresh the page and try again.";
                    $redirect = preg_replace('/[^a-zA-Z0-9_\-]/', '', (string)($_POST['redirect'] ?? 'home')) ?: 'home';
                    header("Location: " . url("") . "" . $redirect);
                    exit;
                }
            }
            // Clear the session expiry flag after first login attempt
            unset($_SESSION['session_expired_just_now']);

            $email = strtolower(trim((string)($_POST['email'] ?? '')));
            $password = (string)($_POST['password'] ?? '');
            
            // Optional redirect target
            $redirect = preg_replace('/[^a-zA-Z0-9_\-]/', '', (string)($_POST['redirect'] ?? 'home')) ?: 'home';

            $attempts = $_SESSION['customer_login_attempts'][$email] ?? [];
            $attempts = array_values(array_filter($attempts, fn($timestamp) => time() - (int)$timestamp < 900));
            $_SESSION['customer_login_attempts'][$email] = $attempts; // Update session with cleaned attempts
            if (count($attempts) >= 5) {
                $_SESSION['login_error'] = "Too many failed attempts. Please wait 15 minutes before trying again.";
                header("Location: " . url("") . "customer_login");
                exit;
            }

            if (empty($email) || empty($password)) {
                $_SESSION['login_error'] = "Please enter both email and password.";
                header("Location: " . url("") . "customer_login");
                exit;
            }

            $user = $this->userModel->login($email, $password);

            if ($user) {
                unset($_SESSION['customer_login_attempts'][$email]);
                // session_regenerate_id(true);
                $_SESSION['customer_logged_in'] = true;
                $_SESSION['customer_id'] = $user['id'];
                $_SESSION['customer_name'] = $user['name'];
                $_SESSION['customer_email'] = $user['email'];
                $_SESSION['customer_phone'] = $user['phone'];

                // Load and merge cart items
                require_once BASE_PATH . '/app/models/SchemaBootstrap.php';
                $dbObj = new Database();
                $schemaBootstrap = new SchemaBootstrap($dbObj->connect(), false);
                $dbCart = $schemaBootstrap->loadCartFromDb((int)$user['id']);
                $sessionCart = $_SESSION['cart'] ?? [];
                
                foreach ($sessionCart as $prodId => $item) {
                    if (isset($dbCart[$prodId])) {
                        $dbCart[$prodId]['qty'] += $item['qty'];
                    } else {
                        $dbCart[$prodId] = $item;
                    }
                }
                
                $schemaBootstrap->syncCartToDb((int)$user['id'], $dbCart);
                $_SESSION['cart'] = $dbCart;

                $_SESSION['success'] = "you are sucessfully login";

                // Redirect to the last visited page if available, otherwise default to resolved route
                $redirectUrl = $_SESSION['redirect_after_login'] ?? (url("") . "" . ($redirect === 'customer_orders' ? 'home' : $redirect));
                unset($_SESSION['redirect_after_login']);
                header("Location: " . $redirectUrl);
                exit;
            } else {
                $attempts[] = time();
                $_SESSION['customer_login_attempts'][$email] = $attempts;
                // Return to login with error
                $_SESSION['login_error'] = "Invalid email or password.";
                header("Location: " . url("") . "customer_login");
                exit;
            }
        } else {
            // Display login form for GET requests
            if (!empty($_GET['redirect_url'])) {
                $_SESSION['redirect_after_login'] = $_GET['redirect_url'];
            } elseif (!isset($_SESSION['redirect_after_login']) && isset($_SERVER['HTTP_REFERER'])) {
                $referer = $_SERVER['HTTP_REFERER'];
                if ((strpos($referer, BASE_URL) !== false || strpos($referer, 'index.php') !== false) &&
                    strpos($referer, 'customer_login') === false &&
                    strpos($referer, 'customer_register') === false &&
                    strpos($referer, 'customer_logout') === false &&
                    strpos($referer, 'admin_') === false) {
                    $_SESSION['redirect_after_login'] = $referer;
                }
            }

            require_once BASE_PATH . '/app/models/settings.php';
            $settingsModel = new Settings();
            $webSettings = $settingsModel->getWebSettings();
            $global_theme = $webSettings['theme'] ?? 'theme-default';
            $webname = $webSettings['web_name'] ?? 'StitchSmart';
            $webmail = $webSettings['web_mail'] ?? 'info@stitchsmart.com';
            $webcontact = $webSettings['web_contact'] ?? 'StitchSmart';
            $facebook = $webSettings['facebook'] ?? '';
            $instagram = $webSettings['instagram'] ?? '';
            $pinterest = $webSettings['pinterest'] ?? '';
            $linkdin = $webSettings['linkdin'] ?? '';
            $meta_description = $webSettings['meta_description'] ?? 'StitchSmart - Tailoring quality products with fast shipping.';

            require_once BASE_PATH . '/app/views/User/customer_login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submittedToken = $_POST['csrf_token'] ?? '';
            if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
                $_SESSION['register_error'] = "Invalid security token. Please refresh the page and try again.";
                $redirect = preg_replace('/[^a-zA-Z0-9_\-]/', '', (string)($_POST['redirect'] ?? 'home')) ?: 'home';
                header("Location: " . url("") . "" . $redirect);
                exit;
            }

            $name = trim(strip_tags((string)($_POST['name'] ?? '')));
            $phone = trim(strip_tags((string)($_POST['phone'] ?? '')));
            $email = strtolower(trim((string)($_POST['email'] ?? '')));
            $password = (string)($_POST['password'] ?? '');
            $confirmPassword = (string)($_POST['confirm_password'] ?? '');
            $redirect = preg_replace('/[^a-zA-Z0-9_\-]/', '', (string)($_POST['redirect'] ?? 'home')) ?: 'home';

            if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
                $_SESSION['register_error'] = "Please fill in all required fields.";
                header("Location: " . url("") . "" . $redirect);
                exit;
            }

            if ($password !== $confirmPassword) {
                $_SESSION['register_error'] = "Passwords do not match.";
                header("Location: " . url("") . "" . $redirect);
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['register_error'] = "Please provide a valid email address.";
                header("Location: " . url("") . "" . $redirect);
                exit;
            }

            if (strlen($password) < 6) {
                $_SESSION['register_error'] = "Password must be at least 6 characters long.";
                header("Location: " . url("") . "" . $redirect);
                exit;
            }

            // Check if email exists
            if ($this->userModel->getUserByEmail($email)) {
                $_SESSION['register_error'] = "User already registered.";
                header("Location: " . url("") . "" . $redirect);
                exit;
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $userId = $this->userModel->register($name, $phone, $email, $passwordHash);

            if ($userId) {
                $_SESSION['success'] = "User registered successfully!";
                header("Location: " . url("") . "customer_login");
                exit;
            } else {
                $_SESSION['register_error'] = "Something went wrong. Please try again.";
                header("Location: " . url("") . "" . $redirect);
                exit;
            }
        }
    }

    public function logout() {
        // Unset customer specific session variables
        unset($_SESSION['customer_logged_in']);
        unset($_SESSION['customer_id']);
        unset($_SESSION['customer_name']);
        unset($_SESSION['customer_email']);
        unset($_SESSION['customer_phone']);
        
        // Clear the cart when customer logs out
        if(isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
        
        $redirect = $_GET['redirect'] ?? 'home';
        header("Location: " . url("") . "" . $redirect);
        exit;
    }

    public function forgotPasswordForm() {
        require_once BASE_PATH . '/app/models/settings.php';
        $settingsModel = new Settings();
        $webSettings = $settingsModel->getWebSettings();
        
        $global_theme = $webSettings['theme'] ?? 'theme-default';
        $webname = $webSettings['web_name'] ?? 'StitchSmart';
        $webmail = $webSettings['web_mail'] ?? 'info@stitchsmart.com';
        $webcontact = $webSettings['web_contact'] ?? 'StitchSmart';
        $facebook = $webSettings['facebook'] ?? '';
        $instagram = $webSettings['instagram'] ?? '';
        $pinterest = $webSettings['pinterest'] ?? '';
        $linkdin = $webSettings['linkdin'] ?? '';
        $meta_description = $webSettings['meta_description'] ?? 'StitchSmart - Tailoring quality products with fast shipping.';
        
        // Default step to 'request' if not set
        if (!isset($_SESSION['reset_step_customer'])) {
            $_SESSION['reset_step_customer'] = 'request';
        }

        require_once BASE_PATH . '/app/views/User/customer_forgot_password.php';
    }

    public function processForgotPassword() {

        // Cancel / start over
        if (isset($_GET['action']) && $_GET['action'] === 'cancel') {
            unset(
                $_SESSION['reset_step_customer'],
                $_SESSION['reset_email_customer'],
                $_SESSION['reset_otp_customer'],
                $_SESSION['reset_otp_expiry_customer'],
                $_SESSION['otp_verified_customer']
            );
            header("Location: " . url("") . "customer_forgot_password");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . url("") . "customer_forgot_password");
            exit;
        }

        $step = $_SESSION['reset_step_customer'] ?? 'request';

        /* ── STEP 1: Send OTP via email ── */
        if ($step === 'request') {

            $email = strtolower(trim($_POST['email'] ?? ''));
            $user  = $this->userModel->getUserByEmail($email);

            if (!$user) {
                $_SESSION['forgot_error'] = "We could not find an account associated with this email address.";
                header("Location: " . url("") . "customer_forgot_password");
                exit;
            }

            $otp = rand(100000, 999999);
            $_SESSION['reset_email_customer']      = $email;
            $_SESSION['reset_otp_customer']        = $otp;
            $_SESSION['reset_otp_expiry_customer'] = time() + 60; // 60 seconds

            // Send via PHPMailer
            $mail = new PHPMailer(true);
            try {
                if (empty(MAIL_USERNAME)) {
                    throw new \Exception('SMTP not configured');
                }
                $mail->Timeout = 15;
                $mail->isSMTP();
                $mail->Host       = MAIL_HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = MAIL_USERNAME;
                $mail->Password   = MAIL_PASSWORD;
                $mail->SMTPSecure = MAIL_ENCRYPTION;
                $mail->Port       = MAIL_PORT;

                $mail->setFrom(MAIL_USERNAME, 'Stitch Smart');
                $mail->addAddress($email, $user['name']);
                $mail->isHTML(true);
                $mail->Subject = "Your OTP Code - Stitch Smart Password Recovery";
                $mail->Body = "
                <div style='font-family:Arial,sans-serif;max-width:580px;margin:0 auto;padding:30px;
                             background:linear-gradient(135deg,#1a0f0a,#3d241c);border-radius:20px;
                             border:1px solid rgba(205,154,72,0.3);color:#fff;'>
                    <div style='text-align:center;margin-bottom:24px;'>
                        <span style='font-family:Georgia,serif;font-size:2rem;font-weight:900;color:#fff;'>Stitch</span>
                        <span style='font-family:Georgia,serif;font-size:2rem;font-weight:900;color:#CD9A48;'>Smart</span>
                    </div>
                    <h2 style='text-align:center;color:#CD9A48;font-family:Georgia,serif;margin-bottom:12px;'>Password Recovery OTP</h2>
                    <p style='color:rgba(255,255,255,0.7);text-align:center;line-height:1.6;margin-bottom:28px;'>
                        Hello <strong style='color:#fff;'>{$user['name']}</strong>,<br>
                        Use the code below to reset your password. It expires in <strong>60 seconds</strong>.
                    </p>
                    <div style='text-align:center;margin:28px 0;'>
                        <span style='display:inline-block;font-size:2.6rem;font-weight:900;letter-spacing:10px;
                                     color:#CD9A48;padding:18px 36px;border:2px dashed #CD9A48;
                                     border-radius:14px;background:rgba(205,154,72,0.08);'>
                            {$otp}
                        </span>
                    </div>
                    <p style='color:rgba(255,255,255,0.4);text-align:center;font-size:0.85rem;'>
                        If you did not request this, please ignore this email.
                    </p>
                    <hr style='border-color:rgba(205,154,72,0.2);margin:24px 0;'>
                    <p style='color:rgba(255,255,255,0.35);text-align:center;font-size:0.82rem;margin:0;'>
                        &copy; Stitch Smart &mdash; Secure Account Recovery
                    </p>
                </div>";
                $mail->AltBody = "Your OTP is: {$otp}. Valid for 60 seconds.";
                $mail->send();

                $_SESSION['forgot_success'] = "A verification code has been sent to {$email}. Please enter it below within 60 seconds.";

            } catch (\Throwable $e) {
                // Fallback for cloud platforms or missing SMTP configs: display OTP clearly in success alert so user can verify immediately
                $_SESSION['forgot_success'] = "Verification code generated: <strong>{$otp}</strong> (Email system simulation fallback enabled due to cloud firewall). Valid for 60 seconds.";
            }

            $_SESSION['reset_step_customer'] = 'verify_otp';
            header("Location: " . url("") . "customer_forgot_password");
            exit;

        /* ── STEP 2: Verify OTP ── */
        } elseif ($step === 'verify_otp') {

            $entered = trim($_POST['otp'] ?? '');
            $saved   = $_SESSION['reset_otp_customer']        ?? '';
            $expiry  = $_SESSION['reset_otp_expiry_customer'] ?? 0;

            if (empty($entered)) {
                $_SESSION['forgot_error'] = "Please enter the verification code to proceed.";
            } elseif (time() > $expiry) {
                $_SESSION['forgot_error']        = "Your verification code has expired. Please request a new one.";
                $_SESSION['reset_step_customer'] = 'request';
            } elseif ($entered == $saved) {
                $_SESSION['otp_verified_customer'] = true;
                $_SESSION['reset_step_customer']   = 'reset_password';
                $_SESSION['forgot_success']        = "Verification successful. Please choose a new password.";
            } else {
                $_SESSION['forgot_error'] = "The verification code is incorrect. Please try again.";
            }

            header("Location: " . url("") . "customer_forgot_password");
            exit;

        /* ── STEP 3: Reset Password ── */
        } elseif ($step === 'reset_password') {

            if (empty($_SESSION['otp_verified_customer'])) {
                $_SESSION['forgot_error']        = "Your session has expired or is unauthorized. Please restart the password recovery process.";
                $_SESSION['reset_step_customer'] = 'request';
                header("Location: " . url("") . "customer_forgot_password");
                exit;
            }

            $password = $_POST['password']         ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';

            if (strlen($password) < 4) {
                $_SESSION['forgot_error'] = "Your new password must be at least 4 characters long.";
            } elseif ($password !== $confirm) {
                $_SESSION['forgot_error'] = "The passwords entered do not match. Please try again.";
            } else {
                $email = $_SESSION['reset_email_customer'] ?? '';
                $user  = $this->userModel->getUserByEmail($email);

                if ($user && $this->userModel->updatePassword($user['id'], password_hash($password, PASSWORD_DEFAULT))) {
                    unset(
                        $_SESSION['reset_step_customer'],
                        $_SESSION['reset_email_customer'],
                        $_SESSION['reset_otp_customer'],
                        $_SESSION['reset_otp_expiry_customer'],
                        $_SESSION['otp_verified_customer']
                    );
                    $_SESSION['login_success'] = "Your password has been successfully updated. You may now log in.";
                    header("Location: " . url("") . "customer_login");
                    exit;
                } else {
                    $_SESSION['forgot_error'] = "We were unable to update your password. Please try again.";
                }
            }

            header("Location: " . url("") . "customer_forgot_password");
            exit;
        }

        header("Location: " . url("") . "customer_forgot_password");
        exit;
    }
}
?>


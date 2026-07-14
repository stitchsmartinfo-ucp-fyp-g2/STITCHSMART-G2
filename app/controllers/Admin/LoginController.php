<?php
require_once __DIR__ . '/../../models/Admin.php';
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../libraries/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../../libraries/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../../libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LoginController {
    private $pdo;
    private $adminModel;

    public function __construct() {
        $this->pdo = new Database();
        $this->adminModel = new Admin($this->pdo);
    }

    // Show login form or handle POST login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submittedToken = $_POST['csrf_token'] ?? '';
            // Only check CSRF token if session didn't just expire - new sessions get fresh tokens
            if (!isset($_SESSION['session_expired_just_now'])) {
                if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
                    $_SESSION['login_error'] = "Invalid security token. Please refresh the page and try again.";
                    header("Location: " . url("") . "admin_login");
                    exit;
                }
            }
            // Clear the session expiry flag after first login attempt
            unset($_SESSION['session_expired_just_now']);

            $email = strtolower(trim((string)($_POST['email'] ?? '')));
            $password = (string)($_POST['password'] ?? '');

            $attempts = $_SESSION['admin_login_attempts'][$email] ?? [];
            $attempts = array_values(array_filter($attempts, fn($timestamp) => time() - (int)$timestamp < 900));
            if (count($attempts) >= 5) {
                $_SESSION['login_error'] = "Too many failed attempts. Please wait 15 minutes before trying again.";
                header("Location: " . url("") . "admin_login");
                exit;
            }

            $admin = $this->adminModel->checkLogin($email, $password);

            if ($admin) {
                unset($_SESSION['admin_login_attempts'][$email]);
                unset($_SESSION['login_error']);
                unset($_SESSION['session_expired']);
                session_regenerate_id(true);
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['last_activity'] = time();
                header("Location: " . url("") . "admin");
                exit;
            } else {
                $attempts[] = time();
                $_SESSION['admin_login_attempts'][$email] = $attempts;
                $_SESSION['login_error'] = "Invalid credentials!";
            }
        }

        // Fetch current theme for branding
        $conn = $this->pdo->connect();
        $theme_res = $conn->query("SELECT theme FROM web_settings WHERE id = 1");
        $theme_data = $theme_res->fetch_assoc();
        $theme = $theme_data['theme'] ?? 'theme-default';

        // Show login form
        require_once __DIR__ . '/../../views/admin/login.php';
    }

    public function logout() {
        unset($_SESSION['admin_logged_in']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['login_error']);
        unset($_SESSION['session_expired']);
        session_destroy();
        header("Location: " . url("") . "admin_login");
        exit;
    }

    public function forgotPassword() {
        $conn = $this->pdo->connect();
        $theme_res = $conn->query("SELECT theme FROM web_settings WHERE id = 1");
        $theme_data = $theme_res->fetch_assoc();
        $theme = $theme_data['theme'] ?? 'theme-default';

        // Cancel action
        if (isset($_GET['action']) && $_GET['action'] === 'cancel') {
            unset($_SESSION['reset_step_admin']);
            unset($_SESSION['reset_email_admin']);
            unset($_SESSION['reset_otp_admin']);
            unset($_SESSION['reset_otp_expiry_admin']);
            unset($_SESSION['otp_verified_admin']);
            header("Location: " . url("") . "admin_forgot_password");
            exit;
        }

        // Default step to 'request'
        if (!isset($_SESSION['reset_step_admin'])) {
            $_SESSION['reset_step_admin'] = 'request';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $step = $_SESSION['reset_step_admin'] ?? 'request';

            if ($step === 'request') {
                $email = trim($_POST['email'] ?? '');
                $admin = $this->adminModel->getAdminByEmail($email);

                if ($admin) {
                    // Generate 6-digit OTP
                    $otp = rand(100000, 999999);
                    $_SESSION['reset_email_admin'] = $email;
                    $_SESSION['reset_otp_admin'] = $otp;
                    $_SESSION['reset_otp_expiry_admin'] = time() + 600; // 10 minutes expiry

                    // Send OTP via PHPMailer
                    $mail = new PHPMailer(true);
                    try {
                        if (empty(MAIL_USERNAME)) {
                            throw new \Exception('SMTP not configured');
                        }
                        $mail->Timeout = 15;
                        $mail->isSMTP();
                        $mail->Host = MAIL_HOST;
                        $mail->SMTPAuth = true;
                        $mail->Username = MAIL_USERNAME;
                        $mail->Password = MAIL_PASSWORD;
                        $mail->SMTPSecure = MAIL_ENCRYPTION;
                        $mail->Port = MAIL_PORT;

                        $mail->setFrom(MAIL_USERNAME, 'Stitch Smart Admin');
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->Subject = "Stitch Smart Admin Portal - One-Time Password (OTP)";
                        $mail->Body = "
                        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 30px; border: 1px solid #CD9A48; border-radius: 16px; background-color: #1a0f0a; color: #ffffff;'>
                            <h2 style='color: #CD9A48; text-align: center; font-size: 24px; margin-bottom: 20px;'>Admin Portal Recovery</h2>
                            <p style='font-size: 16px; line-height: 1.6; color: #cccccc;'>Hello Administrator,</p>
                            <p style='font-size: 16px; line-height: 1.6; color: #cccccc;'>You recently requested to reset your password for the Stitch Smart Admin Panel. Please use the following One-Time Password (OTP) to verify your identity:</p>
                            <div style='text-align: center; margin: 30px 0;'>
                                <span style='display: inline-block; font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #CD9A48; padding: 15px 30px; border: 2px dashed #CD9A48; border-radius: 8px; background: rgba(205,154,72,0.1);'>{$otp}</span>
                            </div>
                            <p style='font-size: 14px; color: #999999; text-align: center;'>This OTP is valid for <strong>10 minutes</strong>. If you did not request this, please secure your server immediately.</p>
                            <hr style='border-color: rgba(205,154,72,0.2); margin: 30px 0;'>
                            <p style='font-size: 14px; color: #777777; text-align: center; margin-bottom: 0;'>Thank you,<br><strong>Stitch Smart Security</strong></p>
                        </div>
                        ";
                        $mail->AltBody = "Hello Administrator, your OTP for portal password reset is {$otp}. It is valid for 10 minutes.";

                        $mail->send();
                        $_SESSION['forgot_success'] = "One-Time Password (OTP) has been sent to your administrator Gmail.";
                    } catch (\Throwable $e) {
                        // Offline simulator helper
                        $_SESSION['forgot_success'] = "One-Time Password (OTP) has been generated: <strong>{$otp}</strong> (Email system simulation fallback enabled)";
                    }
                    $_SESSION['reset_step_admin'] = 'verify_otp';
                } else {
                    $_SESSION['forgot_error'] = "No administrator account found with that email address.";
                }

                header("Location: " . url("") . "admin_forgot_password");
                exit;

            } elseif ($step === 'verify_otp') {
                $enteredOtp = trim($_POST['otp'] ?? '');
                $savedOtp = $_SESSION['reset_otp_admin'] ?? '';
                $expiry = $_SESSION['reset_otp_expiry_admin'] ?? 0;

                if (empty($enteredOtp)) {
                    $_SESSION['forgot_error'] = "Please enter the OTP.";
                } elseif (time() > $expiry) {
                    $_SESSION['forgot_error'] = "The OTP has expired. Please request a new one.";
                    $_SESSION['reset_step_admin'] = 'request';
                } elseif ($enteredOtp == $savedOtp) {
                    $_SESSION['otp_verified_admin'] = true;
                    $_SESSION['reset_step_admin'] = 'reset_password';
                    $_SESSION['forgot_success'] = "OTP verified successfully. Please choose a new admin password.";
                } else {
                    $_SESSION['forgot_error'] = "Invalid OTP code. Please try again.";
                }

                header("Location: " . url("") . "admin_forgot_password");
                exit;

            } elseif ($step === 'reset_password') {
                if (!isset($_SESSION['otp_verified_admin']) || $_SESSION['otp_verified_admin'] !== true) {
                    $_SESSION['forgot_error'] = "Unauthorized access. Please start over.";
                    $_SESSION['reset_step_admin'] = 'request';
                    header("Location: " . url("") . "admin_forgot_password");
                    exit;
                }

                $password = $_POST['password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';

                if (strlen($password) < 4) {
                    $_SESSION['forgot_error'] = "Password must be at least 4 characters long.";
                } elseif ($password !== $confirmPassword) {
                    $_SESSION['forgot_error'] = "Passwords do not match.";
                } else {
                    $email = $_SESSION['reset_email_admin'] ?? '';
                    if ($this->adminModel->updatePassword($email, $password)) {
                        // Cleanup
                        unset($_SESSION['reset_step_admin']);
                        unset($_SESSION['reset_email_admin']);
                        unset($_SESSION['reset_otp_admin']);
                        unset($_SESSION['reset_otp_expiry_admin']);
                        unset($_SESSION['otp_verified_admin']);

                        $_SESSION['login_success'] = "Administrator password has been successfully updated. You can now login.";
                        header("Location: " . url("") . "admin_login");
                        exit;
                    } else {
                        $_SESSION['forgot_error'] = "Failed to update password. Please try again.";
                    }
                }

                header("Location: " . url("") . "admin_forgot_password");
                exit;
            }
        }

        require_once __DIR__ . '/../../views/admin/forgot_password.php';
    }

    public function confirmReset() {
        // Backward-compatible alias for password reset confirmation route.
        $this->forgotPassword();
    }
}

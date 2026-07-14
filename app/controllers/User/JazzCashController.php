<?php

require_once __DIR__ . '/../../../config/database.php';

class JazzCashController
{
    private mysqli $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    private function jsonResponse(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // ─── REGISTER ────────────────────────────────────────────────────────────
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request.']);
        }

        $mobile = trim($_POST['mobile'] ?? '');
        $mpin   = trim($_POST['mpin'] ?? '');
        $confirm = trim($_POST['confirm_mpin'] ?? '');

        // Validation
        if (!preg_match('/^3\d{9}$/', $mobile)) {
            $this->jsonResponse(['success' => false, 'message' => 'Mobile number must be 10 digits starting with 3 (e.g. 3001234567).']);
        }

        if (strlen($mpin) < 4 || strlen($mpin) > 6 || !ctype_digit($mpin)) {
            $this->jsonResponse(['success' => false, 'message' => 'MPIN must be 4–6 digits.']);
        }

        if ($mpin !== $confirm) {
            $this->jsonResponse(['success' => false, 'message' => 'MPIN and Confirm MPIN do not match.']);
        }

        // Check if already registered
        $stmt = $this->conn->prepare("SELECT id FROM jazzcash_accounts WHERE mobile = ?");
        $stmt->bind_param('s', $mobile);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            $this->jsonResponse(['success' => false, 'message' => 'This mobile number is already registered. Please login.', 'already_registered' => true]);
        }
        $stmt->close();

        // Insert
        $hashed = password_hash($mpin, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO jazzcash_accounts (mobile, mpin) VALUES (?, ?)");
        $stmt->bind_param('ss', $mobile, $hashed);

        if ($stmt->execute()) {
            $stmt->close();
            $this->jsonResponse(['success' => true, 'message' => 'Account created! You can now login.']);
        } else {
            $stmt->close();
            $this->jsonResponse(['success' => false, 'message' => 'Registration failed. Please try again.']);
        }
    }

    // ─── LOGIN + GENERATE OTP ─────────────────────────────────────────────────
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request.']);
        }

        $mobile = trim($_POST['mobile'] ?? '');
        $mpin   = trim($_POST['mpin'] ?? '');
        $email  = trim($_POST['email'] ?? '');

        if (!preg_match('/^3\d{9}$/', $mobile)) {
            $this->jsonResponse(['success' => false, 'message' => 'Enter a valid mobile number.']);
        }

        if (empty($mpin)) {
            $this->jsonResponse(['success' => false, 'message' => 'Please enter your MPIN.']);
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->jsonResponse(['success' => false, 'message' => 'Valid email from checkout is required to receive OTP.']);
        }

        // Fetch account
        $stmt = $this->conn->prepare("SELECT id, mpin FROM jazzcash_accounts WHERE mobile = ?");
        $stmt->bind_param('s', $mobile);
        $stmt->execute();
        $result = $stmt->get_result();
        $account = $result->fetch_assoc();
        $stmt->close();

        if (!$account) {
            $this->jsonResponse(['success' => false, 'message' => 'No account found for this number. Please register first.', 'not_registered' => true]);
        }

        if (!password_verify($mpin, $account['mpin'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Incorrect MPIN. Please try again.']);
        }

        // Generate 6-digit OTP and store in session
        $otp = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        $_SESSION['jc_otp']       = $otp;
        $_SESSION['jc_otp_mobile'] = $mobile;
        $_SESSION['jc_otp_time']  = time();
        $_SESSION['jc_logged_in'] = true;

        // Send OTP via Email using PHPMailer
        require_once BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
        require_once BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
        require_once BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';
        
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->Timeout = 15;
            $mail->isSMTP();
            $mail->Host     = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port     = MAIL_PORT;

            $mail->setFrom(MAIL_USERNAME, 'StitchSmart');
            $mail->addAddress($email);

            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = "StitchSmart - Payment Verification Code";

            $year = date('Y');
            $mail->Body = "<!DOCTYPE html>
<html>
<head><meta charset='UTF-8'></head>
<body style='margin:0;padding:0;background:#f5f5f5;font-family:Arial,sans-serif;'>
<table width='100%' cellpadding='0' cellspacing='0'>
<tr><td style='padding:30px 0;' align='center'>
<table width='560' cellpadding='0' cellspacing='0' style='background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e0d5ca;'>
  <tr>
    <td style='background:#1a0f0a;padding:28px 40px;text-align:center;border-bottom:3px solid #c19a4e;'>
      <h1 style='margin:0;color:#ffffff;font-size:22px;letter-spacing:3px;font-family:Arial,sans-serif;'>STITCH<span style='color:#c19a4e;'>SMART</span></h1>
    </td>
  </tr>
  <tr>
    <td style='padding:40px;text-align:center;'>
      <p style='margin:0 0 5px 0;color:#999;font-size:12px;letter-spacing:1px;'>JAZZCASH PAYMENT</p>
      <h2 style='margin:0 0 20px 0;color:#1a1a1a;font-size:20px;font-family:Arial,sans-serif;'>Verification Code</h2>
      <p style='margin:0 0 28px 0;color:#5c4335;font-size:15px;line-height:1.6;'>
        Use this code to complete your JazzCash payment.
      </p>
      <table cellpadding='0' cellspacing='0' align='center'>
        <tr>
          <td style='background:#fcf8f2;border:2px solid #c19a4e;border-radius:10px;padding:20px 45px;text-align:center;'>
            <p style='margin:0 0 6px 0;font-size:11px;color:#7a6253;letter-spacing:1px;text-transform:uppercase;'>Your Code</p>
            <span style='font-size:40px;font-weight:bold;color:#c19a4e;letter-spacing:10px;font-family:Arial,sans-serif;'>{$otp}</span>
          </td>
        </tr>
      </table>
      <p style='margin:24px 0 0 0;color:#aaa;font-size:13px;'>Valid for <strong style='color:#5c4335;'>5 minutes</strong>.</p>
    </td>
  </tr>
  <tr>
    <td style='background:#1a0f0a;padding:18px 40px;text-align:center;'>
      <p style='margin:0;color:#666;font-size:11px;'>&copy; {$year} Stitch Smart. All rights reserved.</p>
    </td>
  </tr>
</table>
</td></tr>
</table>
</body>
</html>";

            $mail->AltBody = "Your StitchSmart JazzCash code is: {$otp}. Valid for 5 minutes.";

            $mail->send();
            
            // Log success to email_logs
            $stmt = $this->conn->prepare("INSERT INTO email_logs (recipient_email, subject, template_name, status, sent_at) VALUES (?, ?, ?, 'sent', NOW())");
            $subj = "StitchSmart - Payment Verification Code";
            $tpl = "jazzcash_otp";
            $stmt->bind_param('sss', $email, $subj, $tpl);
            $stmt->execute();

        } catch (\Exception $e) {
            $err = $e->getMessage();
            
            // Log failure to email_logs
            $stmt = $this->conn->prepare("INSERT INTO email_logs (recipient_email, subject, template_name, status, error_message) VALUES (?, ?, ?, 'failed', ?)");
            $subj = "StitchSmart - Payment Verification Code";
            $tpl = "jazzcash_otp";
            $stmt->bind_param('ssss', $email, $subj, $tpl, $err);
            $stmt->execute();

            error_log('JazzCash OTP Email Error: ' . $err);
            $this->jsonResponse(['success' => false, 'message' => 'Failed to send OTP email: ' . $err]);
        }

        $this->jsonResponse([
            'success' => true,
            'otp'     => $otp,      // Returned to frontend for demo logging
            'mobile'  => '+92 ' . $mobile,
            'message' => 'OTP sent to your email!'
        ]);
    }

    // ─── VERIFY OTP ───────────────────────────────────────────────────────────
    public function verifyOtp(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request.']);
        }

        $submitted = trim(implode('', array_map(fn($k) => $_POST['otp_' . $k] ?? '', range(0, 5))));

        if (!isset($_SESSION['jc_otp'], $_SESSION['jc_otp_time'])) {
            $this->jsonResponse(['success' => false, 'message' => 'OTP session expired. Please login again.']);
        }

        // OTP expires after 5 minutes
        if ((time() - (int)$_SESSION['jc_otp_time']) > 300) {
            unset($_SESSION['jc_otp'], $_SESSION['jc_otp_time']);
            $this->jsonResponse(['success' => false, 'message' => 'OTP expired (5 minutes). Please login again.', 'expired' => true]);
        }

        if ($submitted !== $_SESSION['jc_otp']) {
            $this->jsonResponse(['success' => false, 'message' => 'Incorrect OTP. Please check and try again.']);
        }

        // OTP correct — clear session OTP
        $txnRef = 'JC' . strtoupper(substr(md5(uniqid('', true)), 0, 10));
        unset($_SESSION['jc_otp'], $_SESSION['jc_otp_time']);
        $_SESSION['jc_txn_ref'] = $txnRef;

        $this->jsonResponse(['success' => true, 'txn_ref' => $txnRef]);
    }
}

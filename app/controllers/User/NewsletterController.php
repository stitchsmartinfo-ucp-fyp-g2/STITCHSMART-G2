<?php

require_once BASE_PATH . '/app/models/NewsletterSubscriber.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class NewsletterController {

    public function subscribe() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = trim($_POST['email'] ?? '');
        $redirect = trim($_POST['redirect'] ?? url('') . 'home');
        $redirect = filter_var($redirect, FILTER_SANITIZE_URL) ?: url('') . 'home';

        $subscriber = new NewsletterSubscriber();

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['newsletter_status'] = [
                'type' => 'danger',
                'message' => 'Please enter a valid email address to subscribe.'
            ];
            header('Location: ' . $redirect);
            exit;
        }

        if ($subscriber->exists($email)) {
            $_SESSION['newsletter_status'] = [
                'type' => 'warning',
                'message' => 'You are already subscribed. Thank you!'
            ];
            header('Location: ' . $redirect);
            exit;
        }

        if (!$subscriber->add($email)) {
            $_SESSION['newsletter_status'] = [
                'type' => 'danger',
                'message' => 'Could not save your subscription right now. Please try again later.'
            ];
            header('Location: ' . $redirect);
            exit;
        }

        $this->sendSubscriberConfirmationEmail($email);
        $this->sendAdminNotificationEmail($email);

        $_SESSION['newsletter_status'] = [
            'type' => 'success',
            'message' => 'Welcome to the list! We will email new arrivals and offers soon.'
        ];

        header('Location: ' . $redirect);
        exit;
    }

    private function sendSubscriberConfirmationEmail(string $email): void {
        try {
            $mail = new PHPMailer(true);
        $mail->Timeout = 15;
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_ENCRYPTION;
            $mail->Port = MAIL_PORT;

            $mail->setFrom(MAIL_USERNAME, APP_NAME);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Subscription Confirmed — ' . APP_NAME;
            $mail->Body = "
                <div style='font-family:Arial,sans-serif;padding:20px;color:#111;'>
                    <h2>Subscription Confirmed ✅</h2>
                    <p>Thanks for joining the StitchSmart newsletter.</p>
                    <p>We'll send you updates when new products arrive, new product lists launch, and when exclusive discounts are available.</p>
                    <p><strong>Stay tuned.</strong></p>
                    <hr>
                    <p style='font-size:0.95rem;color:#555;'>If you did not sign up for this newsletter, please ignore this email.</p>
                </div>
            ";
            $mail->AltBody = 'Thanks for joining the StitchSmart newsletter. We will email you when new products arrive and exclusive offers are available.';
            $mail->send();
        } catch (Exception $e) {
            error_log('Newsletter subscriber mail error: ' . $mail->ErrorInfo);
        }
    }

    private function sendAdminNotificationEmail(string $email): void {
        try {
            $mail = new PHPMailer(true);
        $mail->Timeout = 15;
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_ENCRYPTION;
            $mail->Port = MAIL_PORT;

            $mail->setFrom(MAIL_USERNAME, APP_NAME . ' Notifications');
            $mail->addAddress(MAIL_USERNAME);
            $mail->isHTML(true);
            $mail->Subject = 'New Newsletter Subscriber';
            $mail->Body = "
                <div style='font-family:Arial,sans-serif;padding:20px;color:#111;'>
                    <h2>New subscriber added</h2>
                    <p>The following email just subscribed to the newsletter:</p>
                    <ul>
                        <li><strong>Email:</strong> {$email}</li>
                    </ul>
                    <p>Subscribers will now receive new product announcements.</p>
                </div>
            ";
            $mail->AltBody = 'New subscriber added: ' . $email;
            $mail->send();
        } catch (Exception $e) {
            error_log('Newsletter admin mail error: ' . $mail->ErrorInfo);
        }
    }
}

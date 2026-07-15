<?php

require BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController
{
    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name = trim(strip_tags((string)($_POST['name'] ?? '')));
            $email = trim((string)($_POST['email'] ?? ''));
            $phone = trim(strip_tags((string)($_POST['phone'] ?? '')));
            $message = trim(strip_tags((string)($_POST['message'] ?? '')));

            if (empty($name) || empty($email) || empty($message)) {
                $_SESSION['error'] = "All fields are required.";
                header("Location: " . url("") . "contact");
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Please provide a valid email address.";
                header("Location: " . url("") . "contact");
                exit;
            }

            $mail = new PHPMailer(true);
        $mail->Timeout = 15;

            try {

                // SMTP SETTINGS
                $mail->isSMTP();
                $mail->Host       = MAIL_HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = MAIL_USERNAME;
                $mail->Password   = MAIL_PASSWORD;
                $mail->SMTPSecure = MAIL_ENCRYPTION;
                $mail->Port       = MAIL_PORT;

                // FROM
                $mail->setFrom(MAIL_USERNAME, 'Website Contact');

                // TO
                $mail->addAddress(MAIL_USERNAME);

                // REPLY TO USER
                $mail->addReplyTo($email, $name);

                // EMAIL CONTENT
                $mail->isHTML(true);
                $mail->Subject = 'New Contact Form Message';

                $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
                $safeEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
                $safePhone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
                $safePhoneDisplay = !empty($safePhone) ? $safePhone : 'Not Provided';
                $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

                $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background-color: #f7f4f0; padding: 30px; border-radius: 10px; border: 1px solid #e8e0d5;'>
                    <div style='text-align: center; margin-bottom: 25px;'>
                        <h2 style='color: #1a0f0a; margin: 0; font-family: Georgia, serif;'>StitchSmart</h2>
                        <div style='height: 3px; width: 50px; background: #c19a4e; margin: 15px auto;'></div>
                    </div>
                    <div style='background: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);'>
                        <h3 style='color: #c19a4e; margin-top: 0; border-bottom: 1px solid #f0ece1; padding-bottom: 10px;'>New Contact Form Inquiry</h3>
                        
                        <p style='color: #4a4a4a; font-size: 15px; line-height: 1.6;'>
                            <strong style='color: #1a0f0a;'>Name:</strong> {$safeName}
                        </p>
                        
                        <p style='color: #4a4a4a; font-size: 15px; line-height: 1.6;'>
                            <strong style='color: #1a0f0a;'>Email:</strong> 
                            <a href='mailto:{$safeEmail}' style='color: #c19a4e; text-decoration: none;'>{$safeEmail}</a>
                        </p>
                        
                        <p style='color: #4a4a4a; font-size: 15px; line-height: 1.6;'>
                            <strong style='color: #1a0f0a;'>Phone:</strong> {$safePhoneDisplay}
                        </p>
                        
                        <div style='margin-top: 25px;'>
                            <strong style='color: #1a0f0a; display: block; margin-bottom: 8px; font-size: 15px;'>Message:</strong>
                            <div style='background: #fdfaf6; border-left: 4px solid #c19a4e; padding: 15px; color: #5a5a5a; font-size: 14px; line-height: 1.6; border-radius: 0 4px 4px 0;'>
                                {$safeMessage}
                            </div>
                        </div>
                    </div>
                    <div style='text-align: center; margin-top: 25px; color: #8a8a8a; font-size: 12px;'>
                        This message was automatically generated from the StitchSmart website.
                    </div>
                </div>
                ";

                $mail->send();

                $_SESSION['success'] = "Message sent successfully!";

                header("Location: " . url("") . "contact");
                exit;

            } catch (Exception $e) {

                $_SESSION['error'] = "Mailer Error: " . $mail->ErrorInfo;

                header("Location: " . url("") . "contact");
                exit;
            }
        }
    }
}

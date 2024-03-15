<?php

    require_once __DIR__.'/mail/vendor/autoload.php';
    require_once __DIR__.'/mail/config.php';

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // Server settings
        $mail->setLanguage(CONTACTFORM_LANGUAGE);
        $mail->SMTPDebug = CONTACTFORM_PHPMAILER_DEBUG_LEVEL;
        $mail->isSMTP();
        $mail->Host = CONTACTFORM_SMTP_HOSTNAME;
        $mail->SMTPAuth = true;
        $mail->Username = CONTACTFORM_SMTP_USERNAME;
        $mail->Password = CONTACTFORM_SMTP_PASSWORD;
        $mail->SMTPSecure = CONTACTFORM_SMTP_ENCRYPTION;
        $mail->Port = CONTACTFORM_SMTP_PORT;
        $mail->CharSet = CONTACTFORM_MAIL_CHARSET;
        $mail->Encoding = CONTACTFORM_MAIL_ENCODING;

        // Recipients
        $mail->setFrom(CONTACTFORM_FROM_ADDRESS, CONTACTFORM_FROM_NAME);
        $mail->addAddress($email, $user);
        $mail->addReplyTo($email, $user);

        // Content
        $mail->Subject = "Your verification code";
        $mail->Body    = <<<EOT
    Hi {$user}
    Email: {$email}

    -------------------------------
    Your verification code is: $code
    EOT;

        $mail->send();
        echo '<script>alert("Message has been sent")</script>'; // Message has been sent';
    } 
    catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>"; // Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>
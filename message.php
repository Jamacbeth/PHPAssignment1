<?php
require './PHPMailer/PHPMailerAutoload.php';

function send_mail($to_address, $to_name, $from_address, $from_name,
    $subject, $body, $is_body_html = false)
{
    // Validate email addresses
    if (!valid_email($to_address)) {            
        throw new Exception('This To address is invalid: ' . htmlspecialchars($to_address));
    }

    if (!valid_email($from_address)) {
        throw new Exception('This From address is invalid: ' . htmlspecialchars($from_address));
    }

    $mail = new PHPMailer();

    // SMTP configuration (Gmail example)
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->SMTPAuth = true;

    // IMPORTANT: Replace these with your Gmail + App Password
    $mail->Username = 'YOUR_USERNAME@gmail.com';
    $mail->Password = 'YOUR_APP_PASSWORD';

    // Set From, To, Subject, Body
    $mail->setFrom($from_address, $from_name);
    $mail->addAddress($to_address, $to_name);

    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = strip_tags($body);

    if ($is_body_html) {
        $mail->isHTML(true);
    }

    // Send email
    if (!$mail->send()) {
        throw new Exception('Error sending email: ' . htmlspecialchars($mail->ErrorInfo));
    }
}

function valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
?>

<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    function sendMail($to_email, $subject, $content) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => TRUE,
                'verify_peer_name' => TRUE,
                'allow_self_signed' => FALSE
            )
        );

        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;

        $mail->Host       = "mail.lynkrtech.com";
        $mail->Username   = "bugshack@lynkrtech.com";
        $mail->Password   = 'z=9*{Pg7QS';

        $mail->IsHTML(1);
        $mail->AddAddress($to_email);
        $mail->SetFrom("bugshack@lynkrtech.com", "Bugs");
        $mail->AddReplyTo("bugshack@lynkrtech.com", "Bugs");
        $mail->Subject = $subject;
        $mail->MsgHTML($content);

        if(!$mail->Send()) {
            unset($mail);
            return FALSE;
        } else {
            unset($mail);
            return TRUE;
        }
    }
?>
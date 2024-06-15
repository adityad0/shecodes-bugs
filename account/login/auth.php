<?php
    session_start();
    $back_by = "../../";


    // Email check
    if(isset($_POST["email"])) {
        $email = $_POST["email"];
        $_SESSION["login_email"] = $email;
    } else {
        header('Location: ../login/?no-email');
        exit;
    }

    require_once $back_by . 'programs/dbcontroller.php';
    require_once $back_by . 'programs/sendMail.php';

    require_once "../../programs/otp.php";
    $otp = generateOTP();
    $_SESSION["otp"] = $otp;

    $subject = "Login OTP";
    $body = "
    Hello,<br><br>
    Your otp is $otp.<br><br>
    ";
    // if(sendMail($email, $subject, $body)) {
            $_SESSION["email"] = $email;
            header('Location: verify_otp.php');
            exit;
    // } else {
    //     //
    // }
    
?>
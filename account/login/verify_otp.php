<?php
    session_start();
    $back_by = "../../";
    if( isset($_POST['otp']) ){
        if( $_POST['otp'] == $_SESSION['otp'] ){
            // OTP is correct, redirect to dashboard
            $_SESSION["user_details"] = [
                "email" => $_SESSION["login_email"]
            ];
            header('Location: ../../account/dashboard/');
            exit;
        } else {
            // OTP is incorrect
            header('Location: ../login/enter_otp.php?otp-incorrect');
            exit;
        }
    } else {
        header('Location: ../login/enter_otp.php?no-otp');
        exit;
    }
?>
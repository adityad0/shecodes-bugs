<?php
    session_start();
    if(isset($_SESSION["user_details"])) {
        header('Location: ../dashboard/');
        exit;
    }
    if(!isset($_SESSION["loginAttempts"])) {
        $_SESSION["loginAttempts"] = 0;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $back_by = "../../";
            $document_title = "Login";
            require_once $back_by . 'header.php';
        ?>
        <link href="../authstyle.css" rel="stylesheet" />
    </head>
    <body>
        <?php include $back_by . 'mainnav.php'; ?>
        <br><br><br><br><br>
        <div class="authcard-back">
            <div class="authcard-div-center">
                <div class="authcard-content">
                    <h3>Enter OTP</h3>
                    <hr>
                    <form action="../login/verify_otp.php" method="POST">
                        <?php
                            if(isset($_GET["otp-incorrect"])) {
                                echo '<div class="alert alert-danger">Invalid OTP.</div>';
                            }
                            echo $_SESSION['otp'];
                        ?>
                        <div class="mb-3">
                            <input class="form-control full-wide" type="number" name="otp" id="login_email" placeholder="Enter your otp" value="" required>
                        </div>
                        <button type="submit" class="btn btn-outline-primary full-wide">Verify with OTP&nbsp;&nbsp;></button>
                        <hr>
                        <a href="mailto:test@test.com" class="link-no-decoration">
                            <button type="button" class="help-buttons">Help</button>
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <br><br><br>
        <?php require_once $back_by . 'footer.php'; ?>
    </body>
</html>
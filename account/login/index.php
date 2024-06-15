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
                    <h3>Login</h3>
                    <hr>
                    <form action="../login/auth.php" method="POST">
                        <?php
                            if(isset($_GET["account-created"])) {
                                echo '<div class="alert alert-success">Account created! Check your email for a verification link before you login to your account.</div>';
                            }
                            if(isset($_GET["account-no-exist"])) {
                                echo '<div class="alert alert-danger">Account not found!</div>';
                            }
                            if(isset($_GET["logout-success"])) {
                                echo '<div class="alert alert-success">Logout successful.</div>';
                            }
                            if(isset($_GET["invalid-session"])) {
                                echo '<div class="alert alert-warning">Invalid session. Please login continue.</div>';
                            }
                            if(isset($_GET["account-exists"])) {
                                echo '<div class="alert alert-warning">An account is already registered with this email.</div>';
                            }
                            if(isset($_GET["no-creds-found"])) {
                                echo '<div class="alert alert-warning">Sorry, we could not find an account with the given email and password. Please try again.</div>';
                            }
                            if(isset($_GET["password-updated"])) {
                                echo '<div class="alert alert-success">Your password was updated. Please login with your new password.</div>';
                            }
                            if(isset($_GET["too-many-tfa-tries"])) {
                                echo '<div class="alert alert-danger">You have tried to authenticate too many times. Please try again.</div>';
                            }
                            if(isset($_GET["tfa-validation-error"])) {
                                echo '<div class="alert alert-danger">There was an unknown error validating your Two-Factor Authentication Code. Please try again. If the problem persists, please contact us.</div>';
                            }
                            if(isset($_GET["no-captcha"])) {
                                echo '<div class="alert alert-danger">Please verify with captcha below to login.</div>';
                            }
                            if(isset($_GET["captcha-fail"])) {
                                echo '<div class="alert alert-danger">Sorry, captcha verification failed. Please try again.</div>';
                            }
                            if(isset($_GET["too-many-requests"])) {
                                echo '<div class="alert alert-danger">You have tried to login too many times and have been blocked. Please wait at least 24 hours before trying to login again.</div>';
                            }
                            if(isset($_GET["email-not-verified"])) {
                                echo "<div class='alert alert-warning'>
                                    Your email address is not verified. Please verify your email address by clicking on the link in the email sent to your email address to login.
                                    Check the box below and login again if you want us to send you another verification email.
                                    </div>";
                            }
                        ?>
                        <div class="mb-3">
                            <input class="form-control full-wide" type="email" name="email" id="login_email" placeholder="Enter your email" value="" required>
                        </div>
                        <button type="submit" class="btn btn-outline-primary full-wide">Verify with OTP&nbsp;&nbsp;></button>
                        <hr>
                        <a href="mailto:test@example.com" class="link-no-decoration">
                            Help
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <br><br><br>
        <?php require_once $back_by . 'footer.php'; ?>
    </body>
</html>
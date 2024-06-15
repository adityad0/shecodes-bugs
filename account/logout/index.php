<?php
    session_start();
    if(isset($_SESSION["user_details"])) {
        unset($_SESSION["user_details"]);
    }
    session_destroy();
    header('Location: ../login/?logout-success');
    exit;
?>
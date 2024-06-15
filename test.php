<?php
    require_once 'programs/sendMail.php';
    $to = "nikshithakpadma@gmail.com";
    $subject = "Test Email";
    $body = "Hello, World!";
    sendMail($to, $subject, $body);
?>
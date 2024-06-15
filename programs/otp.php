<?php

function generateOTP() {
    // Define the character set for the OTP
    $characters = '0123456789';
    
    // Get the length of the character set
    $length = strlen($characters);
    
    // Initialize an empty string to store the OTP
    $otp = '';
    
    // Generate a random OTP with 6 digits
    for ($i = 0; $i < 6; $i++) {
        // Choose a random character from the character set
        $otp .= $characters[rand(0, $length - 1)];
    }
    
    // Return the generated OTP
    return $otp;
}


?>

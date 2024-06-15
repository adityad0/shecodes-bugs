<?php
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

// Start the session
session_start();

// Set your Razorpay API key and secret
$api_key = 'rzp_test_XHhsxqp3QutpNV';
$api_secret = 'bAdGLohVGrNeXREqeQc6hhz2';
$api = new Api($api_key, $api_secret);

// Retrieve the Razorpay payment details from the URL
$razorpay_payment_id = $_GET['payment_id'];
$razorpay_order_id = $_GET['order_id'];
$razorpay_signature = $_GET['signature'];

// Retrieve the stored order ID and amount from the session
$stored_order_id = $_SESSION['razorpay_order_id'];
if(isset($_SESSION['amount'])) {
    $amount = $_SESSION['amount'];
    unset($_SESSION['amount']);
} else {
    $amount = 0;
}

try {
    // Verify the payment signature
    $attributes = [
        'razorpay_order_id' => $razorpay_order_id,
        'razorpay_payment_id' => $razorpay_payment_id,
        'razorpay_signature' => $razorpay_signature
    ];

    $api->utility->verifyPaymentSignature($attributes);

    // Check if the stored order ID matches the order ID from the URL
    if($stored_order_id === $razorpay_order_id) {
        echo "Payment was successful";
        // Do the transaction here!
    } else {
        echo "Payment verification failed: Order ID mismatch";
        header('Location: index.php?error=Payment verification failed. Reason: Order ID mismatch. Contact support for further help.');
        exit;
    }
} catch(\Exception $e) {
    echo "Payment failed: " . $e->getMessage();
    header('Location: index.php?error=Payment verification failed. Reason: Order ID mismatch. Contact support for further help.');
    exit;
}
?>
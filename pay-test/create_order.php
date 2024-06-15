<?php
    require 'razorpay-php/Razorpay.php';
    use Razorpay\Api\Api;

    $api = new Api('rzp_test_XHhsxqp3QutpNV', 'bAdGLohVGrNeXREqeQc6hhz2');

    $orderData = [
        'receipt'         => "3456",
        'amount'          => 50000, // 50000 paise = 500 INR
        'currency'        => 'INR',
        'payment_capture' => 1 // auto capture
    ];

    $razorpayOrder = $api->order->create($orderData);

    $razorpayOrderId = $razorpayOrder['id'];

    echo $razorpayOrderId;

?>
<?php
session_start();
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$api_key = 'rzp_live_9VUFESYzpApXU5';
$api_secret = 'hE6DNhmZG13lLJy8KFd5TZwO';
$api_key = 'rzp_test_XHhsxqp3QutpNV';
$api_secret = 'bAdGLohVGrNeXREqeQc6hhz2';
$api = new Api($api_key, $api_secret);

$amount = $_POST['amount'];
$_SESSION["amount"] = $amount;

$orderData = [
    'receipt'         => strval(rand()),
    'amount'          => $amount * 100,
    'currency'        => 'INR',
    'payment_capture' => 1
];

$razorpayOrder = $api->order->create($orderData);
$order_id = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $order_id;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Checkout</title>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    </head>
    <body>
        <script>
            var options = {
                "key": "<?php echo $api_key; ?>",
                "amount": "<?php echo $amount * 100; ?>",
                "currency": "INR",
                "name": "Lynkr Technologies",
                "description": "Purchase tokes on LynkrTech.com",
                "image": "https://lynkrtech.com/assets/images/lynkr_logo_image_square.png",
                "order_id": "<?php echo $order_id; ?>",
                "handler": function (response) {
                    window.location.href = "verify_payment.php?payment_id=" + response.razorpay_payment_id + "&order_id=" + response.razorpay_order_id + "&signature=" + response.razorpay_signature;
                },
                "prefill": {
                    "name": "Your Name",
                    "email": "your-email@example.com",
                    "contact": "9999999999"
                },
                "theme": {
                    "color": "#000000"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        </script>
    </body>
</html>

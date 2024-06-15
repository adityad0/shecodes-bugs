<?php
    session_start();
    $back_by = "../";

    require 'razorpay-php/Razorpay.php';
    use Razorpay\Api\Api;
?>
<!DOCTYPE html>
<html style="scroll-behavior: smooth;">
    <head>
        <?php
            $document_title = "Make payment";
            require_once $back_by . 'header.php';
        ?>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    </head>
    <body style="overflow-x: hidden;">
        <?php require_once '../mainnav.php'; ?>
        <div class="container">
            <?php
                // Get document information here
                if(isset($_POST['doc_id'])) {
                    $doc_id = strip_tags(htmlspecialchars(trim($_POST['doc_id'])));
                    $_SESSION["doc_id"] = $doc_id;
                } else {
                    if(isset($_SESSION['doc_id'])) {
                        $doc_id = strip_tags(htmlspecialchars(trim($_SESSION['doc_id'])));
                    } else {
                        echo "Missing: doc_id 1";
                        header('Location: ../index.php?error=Missing doc_id');
                        exit;
                    }
                    echo "Missing: doc_id 2";
                    header('Location: ../index.php?error=Missing doc_id');
                    exit;
                }

                if(isset($_POST['page_count'])) {
                    $page_count = strip_tags(htmlspecialchars(trim($_POST['page_count'])));
                    $_SESSION["page_count"] = $page_count;
                } else {
                    if(isset($_SESSION['page_count'])) {
                        $page_count = strip_tags(htmlspecialchars(trim($_SESSION['page_count'])));
                    } else {
                        echo "Missing: page_count";
                        header('Location: ../index.php?error=Missing page_count');
                        exit;
                    }
                    echo "Missing: page_count";
                    header('Location: ../index.php?error=Missing page_count');
                    exit;
                }

                // Calculate order amount here
                $amt = $page_count * 1;
                echo "Number of pages: " . $page_count . "<br>";
                echo "Price per page: &#8377;1<br>";
                echo "Total Amount: &#8377;" . $amt . "<br>";

                $keyId = "";
                $keySecret = "";

                $api = new Api($keyId, $keySecret);

                $amount = $amt;
                $_SESSION["amount"] = $amount;

                $orderData = [
                    'receipt'         => strval(rand()),
                    'amount'          => $amt * 100,
                    'currency'        => 'INR',
                    'payment_capture' => 1
                ];

                $razorpayOrder = $api->order->create($orderData);
                $order_id = $razorpayOrder['id'];

                $_SESSION['razorpay_order_id'] = $order_id;
                ?>
                <script>
                    var options = {
                        "key": "<?php echo $keyId; ?>",
                        "amount": "<?php echo $amount * 100; ?>",
                        "currency": "INR",
                        "name": "Bugs SheCodes Hackathon",
                        "description": "Purchase tokes on LynkrTech.com",
                        "image": "https://lynkrtech.com/assets/images/lynkr_logo_image_square.png",
                        "order_id": "<?php echo $order_id; ?>",
                        "handler": function (response) {
                            window.location.href = "verify_payment.php?payment_id=" + response.razorpay_payment_id + "&order_id=" + response.razorpay_order_id + "&signature=" + response.razorpay_signature;
                        },
                        "prefill": {
                            "name": "Your Name",
                            "email": "test@example.com",
                            "contact": "9999999999"
                        },
                        "theme": {
                            "color": "#000000"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                </script>
        </div>
        <br><br><br><br><br><br>
        <?php
            $footer_path = '<a href="https://lynkrtech.com/" class="uLine">Home</a>';
            require_once '../footer.php';
        ?>
    </body>
</html>

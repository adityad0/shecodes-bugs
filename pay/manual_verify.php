<?php
    // Set your key ID and key secret
    $keyId = '';
    $keySecret = '';

    header('Content-Type: application/json');

    if(isset($_GET["qr_id"])) {
        $qr_id = htmlspecialchars(strip_tags(trim($_GET["qr_id"])));
    } else {
        $message = [
            "success" => false,
            "status_code" => "http_error",
            "http_response_code" => $http_response_code
        ];
        echo json_encode($message);
        exit;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/payments/qr_codes/" . $qr_id . "/payments");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode("$keyId:$keySecret")
    ));
    $response = curl_exec($ch);
    $http_response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($http_response_code == 200) {
        if($response === false) {
            echo json_encode(["success" => false, "error" => "cURL error: " . curl_error($ch)]);
        } else {
            $response = json_decode($response, true);
            if($response["count"] > 0) {
                if($response["items"][0]["status"] == "captured") {
                    $message = [
                        "success" => true,
                        "message" => "Payment successful and captured successfully.",
                        "response" => $response
                    ];
                    echo json_encode($message);
                    header('Location: ../print/');
                    exit;
                } else {
                    $message = [
                        "success" => false,
                        "message" => "QR exists but payment is not captured.",
                        "response" => $response
                    ];
                    echo json_encode($message);
                }
            } else {
                $message = [
                    "success" => false,
                    "message" => "No payment received. Please try again.",
                    "http_response_code" => $http_response_code
                ];
                echo json_encode($message);
                exit;
            }
        }
    } else {
        $message = [
            "success" => false,
            "message" => "HTTP code 200 not received from server.",
            "http_response_code" => $http_response_code
        ];
        echo json_encode($message);
        exit;
    }
?>

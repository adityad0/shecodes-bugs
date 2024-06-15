<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Razorpay Checkout</title>
</head>
<body>
    <form action="process_payment.php" method="POST">
        <label for="amount">Enter Amount:</label>
        <input type="text" id="amount" name="amount" required>
        <button type="submit">Pay</button>
    </form>
</body>
</html>
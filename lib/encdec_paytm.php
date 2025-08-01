<?php
require('vendor/autoload.php'); // Ensure Composer is installed

use Razorpay\Api\Api;

// Set Razorpay API Key
$api_key = 'rzp_test_UwsmOP5kEmXOc4';
$api_secret = 'vxlXqnCpVxxo0pGLR5leSWlc';
$api = new Api($api_key, $api_secret);

// Payment Details
$orderData = [
    'receipt'         => uniqid(),
    'amount'          => 50000, // Amount in paisa (₹500)
    'currency'        => 'INR',
    'payment_capture' => 1 // Auto capture
];

$order = $api->order->create($orderData);
$order_id = $order['id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <button id="pay-btn">Pay Now</button>
    <script>
        var options = {
			"key": "<?php echo $api_key; ?>",
            "amount": "50000",
            "currency": "INR",
            "name": "Cinema Booking",
            "description": "Ticket Payment",
            "order_id": "<?php echo $order_id; ?>",
            "handler": function (response){
                alert('Payment Successful! Payment ID: ' + response.razorpay_payment_id);
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        var rzp = new Razorpay(options);
        document.getElementById('pay-btn').onclick = function(e){
            rzp.open();
            e.preventDefault();
        }
    </script>
</body>
</html>
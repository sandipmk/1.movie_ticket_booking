<?php
include "connection.php";
session_start();



// variables
$fname = isset($_POST['fName']) ? $_POST['fName'] : '';
$lname = isset($_POST['lName']) ? $_POST['lName'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$mobile = isset($_POST['pNumber']) ? $_POST['pNumber'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$time = isset($_POST['hour']) ? $_POST['hour'] : '';
$movieid = isset($_POST['movie_id']) ? $_POST['movie_id'] : '';

// Razorpay Integration
require 'vendor/autoload.php'; 
use Razorpay\Api\Api;

// Razorpay API Keys
$keyId = 'rzp_test_UwsmOP5kEmXOc4';
$keySecret = 'vxlXqnCpVxxo0pGLR5leSWlc';

$api = new Api($keyId, $keySecret);



// 🛠 Fetching Theatre Value (Check if it exists in POST)
$theatre = isset($_POST['theatre']) ? trim($_POST['theatre']) : '';


//  Fix Ticket Pricing Logic
$ta = 0;
if ($theatre === "main-hall") {
    $ta = 200;
} elseif ($theatre === "vip-hall") {
    $ta = 500;
} elseif ($theatre === "private-hall") {
    $ta = 900;
}

// Debugging Ticket Price


//  Check if Ticket Price is 0
if ($ta == 0) {
    die(" Error: Ticket price cannot be zero. Please select a valid theatre.");
}

// Store Ticket Price in Session
$_SESSION["ta"] = $ta;


// Continue with Payment Processing...
?>
<?php


// Generate Unique Order ID

// Use ORDER_ID from POST if available (from verify.php), else generate new (fallback)
$order = isset($_POST['ORDER_ID']) ? $_POST['ORDER_ID'] : ("ORDER_" . uniqid(mt_rand(), true));

// Insert Booking Details in Database only if ORDERID does not already exist
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $checkQry = "SELECT ORDERID FROM bookingtable WHERE ORDERID = '" . mysqli_real_escape_string($con, $order) . "'";
    $checkResult = mysqli_query($con, $checkQry);
    if (mysqli_num_rows($checkResult) == 0) {
        $qry = "INSERT INTO bookingtable (movieID, bookingTheatre, bookingType, bookingDate, bookingTime, bookingFName, bookingLName, bookingPNumber, bookingEmail, amount, ORDERID) 
        VALUES ('$movieid', '$theatre', '$type', '$date', '$time', '$fname', '$lname', '$mobile', '$email', 'Not Paid', '$order')";
        $result = mysqli_query($con, $qry);
        if (!$result) {
            die("Database Error: " . mysqli_error($con));
        }
    }
}

// Create Razorpay Order
$orderData = [
    'receipt' => $order,
    'amount' => $ta * 100, 
    'currency' => 'INR',
    'payment_capture' => 1 
];

$razorpayOrder = $api->order->create($orderData);
$order_id = $razorpayOrder['id'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gujarat Cinema - Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <center>
        <h1>Proceed for Payment</h1>
        <button id="pay-btn">Pay Now</button>
    </center>

    <script>
        var options = {
            "key": "<?= $keyId ?>",
            "amount": "<?= $ta * 100 ?>",
            "currency": "INR",
            "name": "Gujarat Cinema",
            "description": "Movie Ticket Payment",
            "order_id": "<?= $order_id ?>",
            "handler": function (response) {
               // Redirect to payment_success.php after successful payment
               window.location.href = 'payment_success.php?payment_id=' + response.razorpay_payment_id + '&ORDERID=<?= $order ?>';
            },

            "prefill": {
                "name": "<?= $fname . ' ' . $lname ?>",
                "email": "<?= $email ?>",
                "contact": "<?= $mobile ?>",
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        var rzp1 = new Razorpay(options);
        document.getElementById('pay-btn').onclick = function (e) {
            rzp1.open();
            e.preventDefault();
        }
    </script>
</body>
</html>
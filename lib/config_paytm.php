<?php
/*
- Razorpay Integration Configuration
- Replace 'your_razorpay_key_id' and 'your_razorpay_secret' with actual credentials from Razorpay Dashboard.
- This configuration will work for both TEST and LIVE environments based on API credentials.
*/

require 'vendor/autoload.php'; // Include Razorpay SDK

use Razorpay\Api\Api;

// Replace these with your Razorpay API Key and Secret
define('RAZORPAY_KEY_ID', 'rzp_test_UwsmOP5kEmXOc4');
define('RAZORPAY_KEY_SECRET', 'vxlXqnCpVxxo0pGLR5leSWlc');

// Initialize Razorpay API
$api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);

// Razorpay Payment URLs
$RAZORPAY_ORDER_URL = 'https://api.razorpay.com/v1/orders';
$RAZORPAY_PAYMENT_URL = 'https://api.razorpay.com/v1/payments';

define('RAZORPAY_ORDER_URL', $RAZORPAY_ORDER_URL);
define('RAZORPAY_PAYMENT_URL', $RAZORPAY_PAYMENT_URL);
?>
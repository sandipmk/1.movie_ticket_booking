<?php
include "connection.php";

$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : '';
$orderid = isset($_GET['ORDERID']) ? $_GET['ORDERID'] : '';

if (!$payment_id || !$orderid) {
    echo "<script>alert('Invalid payment or order ID.');window.location.href='index.php';</script>";
    exit;
}

// Update bookingtable: set amount to 'Paid' (or actual amount if you want)
// You can also store the payment_id if you want
$qry = "UPDATE bookingtable SET amount = 'Paid' WHERE ORDERID = '" . mysqli_real_escape_string($con, $orderid) . "'";
$result = mysqli_query($con, $qry);

if (!$result) {
    echo "<script>alert('Database update failed.');window.location.href='index.php';</script>";
    exit;
}

// Redirect to receipt
header("Location: reciept.php?payment_id=$payment_id&ORDERID=$orderid");
exit;
?>

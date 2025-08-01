<?php
include "config.php";

if (isset($_POST['submit'])) {
    $fname = $_POST['fName'];
    $lname = $_POST['lName'];
    $email = $_POST['email'];
    $mobile = $_POST['pNumber'];
    $theatre = $_POST['theatre'];
    $type = $_POST['type'];
    $date = $_POST['date'];
    $time = $_POST['hour'];
    $movieid = $_POST['movie_id'];
    $amount = $_POST['cash'];
    $order = "CASH_" . uniqid();

    $qry = "INSERT INTO `bookingtable`(`movieID`, `bookingTheatre`, `bookingType`, `bookingDate`, `bookingTime`, `bookingFName`, `bookingLName`, `bookingPNumber`, `bookingEmail`,`amount`, `ORDERID`) VALUES  
        ('$movieid', '$theatre', '$type', '$date', '$time', '$fname', '$lname', '$mobile','$email', '$amount' ,'$order')";

    $rs = mysqli_query($con, $qry);

    if ($rs) {
        // Redirect to receipt page for ticket generation
        header("Location: ../reciept.php?ORDERID=$order&admin=1");
        exit;
    }
} else {
    echo "error" . mysqli_error($con);
}

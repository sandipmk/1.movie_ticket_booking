<?php 
    $id = $_GET['id'];
    include "config.php";

    // Delete related records first
    $sql1 = "DELETE FROM bookingtable WHERE movieID = $id";
    $con->query($sql1);

    // Now delete the movie
    $sql2 = "DELETE FROM movietable WHERE movieID = $id"; 

    if ($con->query($sql2) === TRUE) {
        header('Location: addmovie.php');
        exit;
    } else {
        echo "Error deleting record: " . $con->error;
    }
?>

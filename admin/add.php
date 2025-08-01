<?php
include "config.php";

// Check user login or not
if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
}

// logout
if (isset($_POST['but_logout'])) {
    session_destroy();
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add entry</title>
    <link rel="icon" type="image/png" href="../img/logo.png">
    <link rel="stylesheet" href="../style/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <?php
    $link = mysqli_connect("localhost", "root", "", "cinema_db");
    $sql = "SELECT * FROM bookingTable";
    $bookingsNo = mysqli_num_rows(mysqli_query($link, $sql));
    $messagesNo = mysqli_num_rows(mysqli_query($link, "SELECT * FROM feedbackTable"));
    $moviesNo = mysqli_num_rows(mysqli_query($link, "SELECT * FROM movieTable"));
    ?>

    <?php include('header.php'); ?>
    
    <div class="admin-container">

        <?php include('sidebar.php'); ?>
        <div class="admin-section admin-section2">
            <div class="admin-section-column">


                <div class="admin-section-panel admin-section-panel2">
                    <div class="admin-panel-section-header">
                        <h2>ADD ENTRY</h2>
                        <i class="fas fa-film" style="background-color: #4547cf"></i>
                    </div>
                    <div class="booking-form-container">
                        <form action="spot.php" method="POST">


                            <select name="theatre" required>
                                <option value="" disabled selected>THEATRE</option>
                                <option value="main-hall">Main Hall</option>
                                <option value="vip-hall">VIP Hall</option>
                                <option value="private-hall">Private Hall</option>
                            </select>

                            <select name="type" required>
                                <option value="" disabled selected>TYPE</option>
                                <option value="3d">3D</option>
                                <option value="2d">2D</option>
                            </select>

                            <select name="date" required>
                                <option value="" disabled selected>DATE</option>
                                <?php
                                date_default_timezone_set('Asia/Kolkata');
                                for ($i = 0; $i < 5; $i++) {
                                    $date = strtotime("+{$i} day");
                                    $val = date('Y-m-d', $date);
                                    $label = date('M d, Y', $date);
                                    echo "<option value='$val'" . ($i==0?' selected':'') . ">$label</option>";
                                }
                                ?>
                            </select>

                            <select name="hour" required>
                                <option value="" disabled selected>TIME</option>
                                <option value="09-00">09:00 AM</option>
                                <option value="12-00">01:00 PM</option>
                                <option value="15-00">06:00 PM</option>
                                <option value="18-00">11:00 PM</option>
                            </select>

                            <input placeholder="First Name" type="text" name="fName" required>

                            <input placeholder="Last Name" type="text" name="lName">

                            <input placeholder="Phone Number" type="text" name="pNumber" required>
                            <input placeholder="email" type="email" name="email" required>
                            <select name="movie_id" id="movie_id" required>
                                <option value="" disabled selected>Select Movie</option>
                                <?php
                                $movies = mysqli_query($con, "SELECT movieID, movieTitle, mainhall, viphall, privatehall FROM movietable");
                                $moviePrices = [];
                                while ($m = mysqli_fetch_assoc($movies)) {
                                    $moviePrices[$m['movieID']] = [
                                        'mainhall' => $m['mainhall'],
                                        'viphall' => $m['viphall'],
                                        'privatehall' => $m['privatehall']
                                    ];
                                    echo "<option value='{$m['movieID']}' data-mainhall='{$m['mainhall']}' data-viphall='{$m['viphall']}' data-privatehall='{$m['privatehall']}'>{$m['movieTitle']}</option>";
                                }
                                ?>
                            </select>
                            
                            <input placeholder="Amount" type="text" name="cash" id="amount" required readonly>

                            <button type="submit" value="submit" name="submit" class="form-btn">ADD ENTRY</button>
                            
                        </form>
                        <script>
                        // Auto price fill based on theatre and movie
                        const theatreSelect = document.querySelector('select[name="theatre"]');
                        const movieSelect = document.getElementById('movie_id');
                        const amountInput = document.getElementById('amount');
                        function updateAmount() {
                            const movieOption = movieSelect.options[movieSelect.selectedIndex];
                            const theatre = theatreSelect.value;
                            if (!movieOption || !theatre) { amountInput.value = ''; return; }
                            let price = '';
                            if (theatre === 'main-hall') price = movieOption.getAttribute('data-mainhall');
                            else if (theatre === 'vip-hall') price = movieOption.getAttribute('data-viphall');
                            else if (theatre === 'private-hall') price = movieOption.getAttribute('data-privatehall');
                            amountInput.value = price;
                        }
                        theatreSelect.addEventListener('change', updateAmount);
                        movieSelect.addEventListener('change', updateAmount);
                        </script>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="../scripts/jquery-3.3.1.min.js "></script>
    <script src="../scripts/owl.carousel.min.js "></script>
    <script src="../scripts/script.js "></script>
</body>

</html>
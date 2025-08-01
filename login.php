<?php 
session_start();
include('connection.php');

if (isset($_SESSION['name'])) {
    header('location:index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username and password are required.";
        header("Location: login.php");
        exit();
    }

    // Prepare statement to prevent SQL injection
    $qry = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($con, $qry);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['name'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            header('location:index.php');
            exit();
        } else {
            $_SESSION['error'] = "Invalid Password.";
        }
    } else {
        $_SESSION['error'] = "Invalid Username.";
    }

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="en_US">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
    <link href="style/animate.css" type='text/css' rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/login.css">
</head>
<body>
    <div class="loginbox">
        <img src="img/profile.png" class="profile" />
        <h2>Login Here</h2>
        <?php 
        if (isset($_SESSION['error'])) {
            echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>
        <form action="login.php" method="post" class="animated flipInY">
            <p>Username</p>
            <input type="text" name="username" placeholder="Enter Username" required>
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password" required><br>
            <input type="submit" name="submit" value="Login"><br>
            <a href="signup.php">Create new account?</a>
        </form>
    </div>
</body>
</html>

<?php
    session_start();
?>
<div class="navbar-brand">
    <a href="index.php">
        <h1 class="navbar-heading">Gujarat Cinema</h1>
    </a>
</div>

<div class="navbar-container">
    <nav class="navbar">
        <ul class="navbar-menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="schedule.php">Schedule</a></li>
            <!-- <li><a href="TxnStatus.php" target="_blank">Status</a></li> -->
            <li><a href="contact-us.php">Contact</a></li>
            
            <?php if(isset($_SESSION['name']))
                {?>
            <li><a id="Admin1" href="userlogout.php">Logout</a></li>
            <?php }else{?>
            <li><a id="Admin1" href="login.php">Login</a></li>
            <?php }?>
 
        </ul>
    </nav>
</div>

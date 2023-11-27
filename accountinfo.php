<?php
// link to connection.php to access the database
include_once("connection.php");

// starts session and ensures that user is logged in as customer, if not, they are sent to login
session_start(); 
$_SESSION['backURL']='accountinfo.php';
if (!isset($_SESSION['Email'])) {
  $_SESSION['Message'] = "Please login to use this service";
  header('Location: login.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Details</title>
    <!-- links to stylesheets and google fonts -->
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto Slab">

</head>
<body>
    <!-- top navbar -->
    <div class="navbar_top">
        <div class="container-fluid">
            <!-- logo and link to homepage -->
            <a class="logo" type="button" href="/bookshop/homepage.php">Bella's<br>Books</a>

            <!-- search bar including dropdown box and search button -->
            <?php
                include_once ("searchbar.php");
            ?>  

            <!-- buttons at end of navbar -->
            <span>
                <div class="float-end">
                    <div  class="btn-group" role="group">
                        <a type="button" href="/bookshop/basket.php" class="btn btn-primary">Basket</a>
                        <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>
                    </div> 
                </div> 
            </span>
        </div>
    </div>

    <!-- body of website -->
    <div class="main">
        <div class="text-center">
            <h3> Edit Details </h3>
            <p style="color:red;">
                <?php
                    if (isset($_SESSION['Message'])){
                        echo($_SESSION['Message']);
                        unset($_SESSION['Message']);
                    } 
                ?>
            </p>
            <form action="accountinfoprocess.php" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-sm text-end" style="line-height: 1.8em">
                            Email:<br>
                            First Name:<br>
                            Surname:<br>
                            Phone:<br>
                            <br>
                            Address Line 1:<br>
                            Postcode:<br>
                            <br>
                            Card Number:<br>
                            Card Name:<br>
                            Card Expiry:<br>
                            Card CVC:<br>
                            <br>
                            Current Password:<br>
                            New Password:<br>
                        </div>

                        <div class="col-sm text-start">
                            <input type="email" name="email" placeholder="Email" required><br>
                            <input type="text" name="forename" placeholder="First Name" required><br>
                            <input type="text" name="surname" placeholder="Surname" required><br>
                            <input type="tel" name="phone" placeholder="Phone" required><br>
                            <br>
                            <input type="text" name="address" placeholder="Address Line 1" required><br>
                            <input type="text" name="postcode" placeholder="Postcode" required><br>
                            <br>
                            <input type="text" name="cardno" placeholder="Card Number" required><br>
                            <input type="text" name="cardname" placeholder="Card Name" required><br>
                            <input type="text" name="cardexpiry" placeholder="Card Expiry Date" required><br>
                            <input type="password" name="cardcvc" placeholder="Card CVC" required><br>
                            <br>
                            <input type="password" name="currentpass" placeholder="Current Password" required><br>
                            <input type="password" name="newpass" placeholder="New Password" required><br>
                            <br>
                            <input type="submit" value="Save Changes">
                        </div>
                    </div>
                <div>
            </form>      
        </div>
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>
</body>
</html>
<?php
// link to connection.php to access the database
include_once("connection.php");

// starts session and ensures that user is logged in as admin, if not, they are sent to login
session_start(); 
$_SESSION['backURL']='admin_account.php';
if ($_SESSION['UserType'] != 1) {
    $_SESSION['Message'] = "Please login to use this service";
    header('Location: login.php');
  }
if (!isset($_SESSION['Email'])) {
  $_SESSION['Message'] = "Please login to use this service";
  header('Location: login.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Create Admin Account</title>
    <!-- links to stylesheets and google fonts -->
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto Slab">
    
</head>
<body>
    <!-- top navbar -->
    <div class="white_box_top"></div>
    <div class="navbar_top">
        <div class="container-fluid">
            <!-- logo and link to homepage -->
            <a class="logo" type="button" href="homepage.php">Bella's<br>Books</a>

            <!-- search bar including dropdown box and search button -->
            <?php
                include_once ("searchbar.php");
            ?>  

            <!-- buttons at end of navbar -->
            <span>
                <div class="float-end">
                    <div  class="btn-group" role="group">
                        <a type="button" href="admin_account.php" class="btn btn-primary">My Account</a>
                        <a type="button" href="basket.php" class="btn btn-primary">Basket</a>
                        <a type="button" href="logout.php" class="btn btn-primary">Logout</a>
                    </div> 
                </div> 
            </span>
        </div>
    </div>

    <!-- body of website -->
    <div class="main">
    <div class="text-center">
        <h3> Add Admin </h3>
        <p style="color:red;">
            <?php
                if (isset($_SESSION['Message'])){
                    echo($_SESSION['Message']);
                    unset($_SESSION['Message']);
                } 
            ?>
        </p>
        <form action="adminprocess.php" method = "post">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="forename" placeholder="First Name" required><br>
            <input type="text" name="surname" placeholder="Surname" required><br>
            <input type="password" name="passwd" placeholder="Password" required><br>
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
            <input type="submit" value="Add">
        </form>      
    </div>
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>
   
</body>
</html>
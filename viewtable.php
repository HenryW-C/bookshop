<?php
// link to connection.php to access the database
include_once("connection.php");

// starts session and ensures that user is logged in, if not, they are sent to login
session_start(); 
$_SESSION['backURL']=$_SERVER['REQUEST_URI'];
if (!isset($_SESSION['Email'])) {
  $_SESSION['Message'] = "Please login to use this service";
  header('Location: login.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Vew Table</title>
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
                        <!-- php switch statement to show select buttons dependant on user type -->
                        <?php
                            switch ($_SESSION['UserType']) { 
                            case(1): ?>
                            <a type="button" href="/bookshop/admin_account.php" class="btn btn-primary">My Account</a>
                            <a type="button" href="/bookshop/basket.php" class="btn btn-primary">Basket</a>
                            <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>
                            <?php break; ?>

                            <?php case(0): ?>
                            <a type="button" href="/bookshop/customer_account.php" class="btn btn-primary">My Account</a>
                            <a type="button" href="/bookshop/basket.php" class="btn btn-primary">Basket</a>
                            <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>
                            <?php break;
                            } ?>
                    </div> 
                </div> 
            </span>
        </div>
    </div>

    <!-- body of website -->
    <div class="main">
        <?php
        array_map("htmlspecialchars", $_GET);
        $tableName = $_GET['tableName'];

        // fetches the table data
        $stmt = $conn->prepare("SELECT * FROM $tableName");
        $stmt->execute();

        // Fetch all rows and display them
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<pre>';
            print_r($row);
            echo '</pre>';
        }
        ?>
    </div>

    <!-- bottom navbar -->
    <div class="white_box_bottom"><div>
    <div class="navbar_bottom">
        <a> </a>
    </div>
   
</body>
</html>
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
    <title>Manage Account</title>
    <!-- links to stylesheets and google fonts -->
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto Slab">

</head>
<body>
    <!-- top navbar -->
    <div class="white_box_top"></div>
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
        <div class="container-fluid mt-5"> 
            <div class="row d-flex justify-content-between">
                <div class="col-md-8">
                    <a type="button" href="/bookshop/accountinfo.php" class="btn btn-primary top-btn">Account Information</a>
                </div>
                <div class="col-md-4">
                    <a type="button" href="/bookshop/newadmin.php" class="btn btn-primary top-btn">New Admin</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?php
                        include_once ("messages.php");
                    ?>
                </div>
                <div class="col-md-4">
                    <?php
                        include_once ("orders.php");
                    ?>
                </div>
                <div class="col-md-4">
                    <div class="custom-column">
                        <h3>Databases</h3>
                        <?php
                            // fetch all tables
                            $stmt = $conn->prepare("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='bookshop' ");
                            $stmt->execute();
                            $tableData = $stmt->fetch(PDO::FETCH_ASSOC);
                            do {
                                // row to fill the width of the page
                                echo ('<a class="link" href="viewtable.php?tableName=' . $tableData["TABLE_NAME"] . '" class="card-title">'); // link to table page
                                    echo('<div  class="custom-row messageBtn" style="cursor: pointer;">');
                                        // display table name
                                        echo('<h4>'.$tableData["TABLE_NAME"].'</h4>');
                                    echo('</div>');
                                echo ('</a>');
                            } while ($tableData = $stmt->fetch(PDO::FETCH_ASSOC));
                        ?>
                    </div>
                    <a type="button" href="/bookshop/categories.php" class="btn btn-primary btn-list messageBtn">Manage Categories</a>
                </div>
            </div>
        </div>
    </div> 

    <!-- bottom navbar -->
    <div class="white_box_bottom"><div>
    <div class="navbar_bottom">
        <a> </a>
    </div>
</body>
</html>
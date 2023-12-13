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
    <title>Manage Categories</title>
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
        <div class="container-fluid mt-5">
            <div class="row">
                <div class="col-md-12">
                    <!-- 'custom-column' to fill page as backing box -->
                    <div class="custom-column">
                        <?php
                            // fetch all categories
                            $stmt = $conn->prepare("SELECT * FROM tblCategories ORDER BY categoryID ASC");
                            $stmt->execute();
                            $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);
                            // sets variable to determine if there are categories
                            if ($categoryData) {
                                $categoryData = 1;
                            }
                            else {
                                $categoryData = 0;
                            }
                            if ($categoryData == 1) {
                                // if there are categories, they are displayed
                                echo ('<h2>Categories:</h2>');
                                do {
                                    // row to fill the width of the page
                                    echo('<div class="custom-row">');
                                        echo ('<div class="left-content">');
                                           echo($categoryData["category"]);
                                        echo ('</div>');
                                        echo ('<div class="title">');
                                           if ($categoryData["category"] == 1){
                                            echo ('Subject');
                                           }
                                           else{
                                            echo ('Level');
                                           }
                                        echo ('</div>');
                                        echo ('<div class="remove">');
                                            echo ('<a class="link" href="removecategory.php?categoryID=' . $categoryData["categoryID"] .'">X</a>');
                                        echo ('</div>');
                                    echo('</div>');
                                } while ($categoryData = $stmt->fetch(PDO::FETCH_ASSOC));
                            } else {
                                // message to be shown if there are no categories
                                echo('<br>There are no categories');
                            }
                        ?>
                    </div>
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
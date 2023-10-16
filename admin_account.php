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
    <div class="navbar_top">
        <div class="container-fluid">
            <!-- logo and link to homepage -->
            <a class="logo" type="button" href="/bookshop/homepage.php">Bella's<br>Books</a>

            <!-- search bar including dropdown box and search button -->
            <div class="search-bar">
                <form class="d-flex" id="searchForm" action="items.php" method="GET">
                    <div class="dropdown">
                        <!-- dropdown box code -->
                        <select class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" name="selectedCategory">
                            <!-- default 'categories' label -->
                            <option value="">Categories</option>
                            <option value=""> All</option>
                            <optgroup label="Levels">
                                <!-- php code to take levels from table and display as dropdown options -->
                                <?php
                                session_start(); 
                                include_once ("connection.php");
                                $stmt = $conn->prepare('SELECT category FROM tblCategories WHERE categoryType = 0');
                                $stmt->execute();
                                $results = $stmt->fetchAll();

                                foreach ($results as $row): ?>
                                    <option value="<?=$row["category"]?>"><?=$row["category"]?></option>
                                <?php endforeach ?>
                            </optgroup>

                            <optgroup label="Subjects">
                                <!-- php code to take levels from table and display as dropdown options -->
                                <?php
                                include_once ("connection.php");
                                $stmt = $conn->prepare('SELECT category FROM tblCategories WHERE categoryType = 1');
                                $stmt->execute();
                                $results = $stmt->fetchAll();

                                foreach ($results as $row): ?>
                                    <option value="<?=$row["category"]?>"><?=$row["category"]?></option>
                                <?php endforeach ?>
                            </optgroup>
                        </select>
                    </div>
                    <input class="form-control me-2" type="search" placeholder="Search" name="searchQuery">
                    <button class="btn btn-outline-success go-button" type="submit">Go</button>
                </form>
            </div>


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
            <div class="row">
                <div class="col-md-4">
                    <div class="custom-column">
                        <h3>Delivery Details</h3>
                        <p>[Delivery Details]</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="custom-column">
                        <h3>Past Orders</h3>
                        <?php
                            // fetch all orders that the user has made
                            $stmt = $conn->prepare("SELECT * FROM tblOrders WHERE userID = :userID");
                            $stmt->bindParam(':userID', $_SESSION['UserID'], PDO::PARAM_INT);
                            $stmt->execute();
                            $orderData = $stmt->fetch(PDO::FETCH_ASSOC);
                            // sets variable to determine if there are orders
                            if ($orderData) {
                                $orderFull = 1;
                            }
                            else {
                                $orderFull = 0;
                            }
                            if ($orderFull == 1) {
                                // if there are orders, they are displayed
                                do {
                                    // row to fill the width of the page
                                    echo ('<a class="link" href="order.php?orderID=' .$orderData["orderID"]. '" class="card-title">'); // link to order page
                                        echo('<div class="custom-row">');
                                            echo ('<div class="title">');
                                                echo('<h4>Order #'.$orderData["orderID"].'</h4>');
                                            echo ('</div>');
                                            echo ('<div class="price">');
                                                $price = number_format($orderData['totalPrice'], 2, '.', ',');
                                                echo('<h4>£'.$price.'</h4>');
                                            echo ('</div>');
                                        echo('</div>');
                                    echo ('</a>');
                                } while ($orderData = $stmt->fetch(PDO::FETCH_ASSOC));
                            } else {
                                // message to be shown if there are no orders
                                echo('<br>There are no past orders');
                            }
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="custom-column">
                        <h3>Databases</h3>
                        <p>[Databases]</p>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>
   
</body>
</html>
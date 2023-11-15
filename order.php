<?php
// link to connection.php to access the database
include_once("connection.php");

// starts session and ensures that user is logged in, if not, they are sent to login
session_start(); 
$URL = $_SERVER['REQUEST_URI'];
$_SESSION['backURL'] = $URL;
if (!isset($_SESSION['Email'])) {
  $_SESSION['Message'] = "Please login to use this service";
  header('Location: login.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Order Details</title>
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
                        <?php break; }?>
                    </div> 
                </div> 
            </span>
        </div>
    </div>

    <!-- body of website -->
    <div class="basket">
        <div class="main">
            <div class="container-fluid mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <!-- 'custom-column' to fill page as backing box -->
                        <div class="custom-column">
                            <?php
                                $_SESSION['totalPrice']=0; //initialise total price variable
                                array_map("htmlspecialchars", $_GET);
                                // retrieve the orderID from the query parameter
                                if (isset($_GET['orderID']) && !empty($_GET['orderID'])) {
                                    $orderID = $_GET['orderID'];
                                    
                                    // fetch order data from tblBooks using the orderID
                                    $stmt = $conn->prepare("SELECT * FROM tblBooks WHERE orderID = :orderID");
                                    $stmt->bindParam(':orderID', $orderID, PDO::PARAM_INT);
                                    
                                    try {
                                        $stmt->execute();
                                        $orderData = $stmt->fetch(PDO::FETCH_ASSOC);
                                        
                                        // display book details
                                        if ($orderData) {
                                            do {
                                                // row to fill the width of the page
                                                echo('<div class="custom-row">');
                                                    echo ('<div class="left-content">'); // image on left of page
                                                        echo ('<a class="link" href="item.php?bookID=' . $orderData["bookID"] . '" class="card-title">'); // link to book page
                                                            if($orderData['image']) { // if there is an image
                                                                echo ('<img class="image" src="images/' . $orderData['image'] . '" alt="' . $orderData['name'] . '">');
                                                            } else { // no image
                                                                echo ('<div class="noimage">');
                                                                    echo ('<div class="centered">No Image</div>');
                                                                    echo ('<img class="image" src="images/default.png" alt="No Image">');
                                                                echo ('</div>');
                                                            }
                                                    echo ('</div>');
                                                    echo ('<div class="title">');
                                                        echo('<h4>'.$orderData["name"].'<h4>');
                                                        echo ('</a>');
                                                    echo ('</div>');
                                                    echo ('<div class="price">');
                                                        $price = number_format($orderData["price"], 2, '.', ',');
                                                        echo('<h4>£'.$price.'</h4>');
                                                        $_SESSION['totalPrice'] = $_SESSION['totalPrice']+$orderData["price"];
                                                    echo ('</div>');
                                                echo('</div>');
                                            } while ($orderData = $stmt->fetch(PDO::FETCH_ASSOC));
                                            
                                        } else {
                                            echo ('Order not found');
                                        }
                                    } catch (PDOException $e) {
                                        echo ("Error: " . $e->getMessage());
                                    }
                                } else {
                                    echo ('Invalid orderID');
                                }
                            ?>
                        </div> 
                    </div>
                </div>
                <div class="row" >
                    <div class="col-md-12">
                        <div class="container mt-4 d-flex justify-content-end">
                            <div class="pill-bar">
                                <span class="price">Total: £<?php
                                $price = number_format($_SESSION['totalPrice'], 2, '.', ',');
                                echo($price) ?></span>
                            </div>
                        </div>
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
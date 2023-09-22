<?php
// link to connection.php to access the database
include_once("connection.php");

// starts session and ensures that user is logged in, if not, they are sent to login
session_start(); 
$_SESSION['backURL']='basket.php';
if (!isset($_SESSION['Email'])) {
  $_SESSION['Message'] = "Please login to use this service";
  header('Location: login.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Basket</title>
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
            <a class="logo" type="button" href="/bookshop/homepage.php">Bella's<br>Books </a>

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
                        <!-- php switch statement to show select buttons dependant on user type -->
                        <?php
                        switch ($_SESSION['UserType']??'') { 
                        case(1): ?>
                        <a type="button" href="/bookshop/admin_account.php" class="btn btn-primary">My Account</a>
                        <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>
                        <?php break; ?>

                        <?php case(0): ?>
                        <a type="button" href="/bookshop/customer_account.php" class="btn btn-primary">My Account</a>
                        <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>
                        <?php } ?>
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
                            $_SESSION['totalPrice']=0; //initialise total price variable
                            // fetch all books that are in the basket
                            $stmt = $conn->prepare("SELECT * FROM tblBooks WHERE buyerID = :userID AND orderID IS NULL ORDER BY name ASC");
                            $stmt->bindParam(':userID', $_SESSION['UserID'], PDO::PARAM_INT);
                            $stmt->execute();
                            $basketData = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($basketData) {
                                // if there are books, they are displayed
                                echo ('<h2>Basket:</h2>');
                                do {
                                    // row to fill the width of the page
                                    echo('<div class="custom-row">');
                                        echo ('<div class="left-content">'); // image on left of page
                                            echo ('<a class="link" href="item.php?bookID=' . $basketData["bookID"] . '" class="card-title">'); // link to book page
                                                if($basketData['image']) { // if there is an image
                                                    echo ('<img class="image" src="images/' . $basketData['image'] . '" alt="' . $basketData['name'] . '">');
                                                } else { // no image
                                                    echo ('<div class="noimage">');
                                                        echo ('<div class="centered">No Image</div>');
                                                        echo ('<img class="image" src="images/default.png" alt="No Image">');
                                                    echo ('</div>');
                                                }
                                        echo ('</div>');
                                        echo ('<div class="title">');
                                            echo('<h4>'.$basketData["name"].'<h4>');
                                            echo ('</a>');
                                        echo ('</div>');
                                        echo ('<div class="price">');
                                            echo('<h4>£'.$basketData["price"].'<h4>');
                                            $_SESSION['totalPrice'] = $_SESSION['totalPrice']+$basketData["price"];
                                        echo ('</div>');
                                        echo ('<div class="remove">');
                                            echo ('<a class="link" href="removefrombasket.php?bookID=' . $basketData["bookID"] .'">X</a>');
                                        echo ('</div>');
                                    echo('</div>');
                                } while ($basketData = $stmt->fetch(PDO::FETCH_ASSOC));
                            } else {
                                // message to be shown if there are no books
                                echo('<br>There is nothing in the basket');
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
                            <a type="button" href="checkout.php" class="btn btn-primary">Checkout</a>
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
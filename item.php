<?php
include_once("connection.php");

// starts session and ensures that user is logged in, if not, they are sent to login
session_start(); 
if (!isset($_SESSION['Email'])) {
  $_SESSION['Message'] = "Please login to use this service";
  header('Location: login.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Book</title>
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
    <div class="item">
        <?php
            include_once("connection.php");
            if (!isset($_SESSION['Email'])) {
            $_SESSION['Message'] = "Please login to use this service";
            header('Location: login.php');
            }
            
            array_map("htmlspecialchars", $_GET);
            // retrieve the bookID from the query parameter
            if (isset($_GET['bookID']) && !empty($_GET['bookID'])) {
                $bookID = $_GET['bookID'];
                
                // fetch book data from tblBooks using the bookID
                $stmt = $conn->prepare("SELECT * FROM tblBooks WHERE bookID = :bookID");
                $stmt->bindParam(':bookID', $bookID, PDO::PARAM_INT);
                
                try {
                    $stmt->execute();
                    $bookData = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // display book details
                    if ($bookData) {
                        echo ('<div class="container fluid mt-5">');
                            echo ('<div class="row">');
                                echo ('<div class="col-md-4">');
                                    echo ('<div class="custom-column">');
                                        echo ('<h3>' . $bookData['name'] . '</h3>');
                                        if($bookData['author']) {
                                            echo ('<p>By ' . $bookData['author'] . '</p>');
                                        }
                                        if($bookData['image']) {
                                            echo ('<img class="image" src="images/' . $bookData['image'] . '" alt="' . $bookData['name'] . '"><br><br>');
                                        } else {
                                            echo ('<div class="noimage">');
                                                echo ('<div class="centered">No Image</div>');
                                                echo ('<img class="image" src="images/default.png" alt="No Image"><br><br>');
                                            echo ('</div>');
                                        }
                                    echo ('</div>');
                                echo ('</div>');
                                echo ('<div class="col-md-4">');
                                    echo ('<div class="custom-column">');
                                        if($bookData['subject']) {
                                            echo ('<h5>Subject: <b>' . $bookData['subject'] . '</b></h5></p>');
                                        }
                                        if($bookData['level']) {
                                            echo ('<h5>Level: <b>' . $bookData['level'] . '</b></h5></p>');
                                        }
                                        echo ('<p>Description: ' . $bookData['description'] . '</p>');

                                        echo ('<div class="bottom";">');
                                            $price = number_format($bookData['price'], 2, '.', ',');
                                            echo ('<h4>Price: £' . $price . '</h4><br>');
                                            if($_SESSION['backURL'] == 'basket.php'){
                                                echo ('<a type="button" href="basket.php" class="btn btn-primary">Return to Basket</a>');
                                            }
                                            else{
                                                echo ('<a type="button" href="addtobasket.php?bookID=' . $bookData["bookID"] . '" class="btn btn-primary">Add to Basket</a>');
                                            }
                                        echo ('</div>');
                                        
                                    echo ('</div>');
                                echo ('</div>');
                                echo ('<div class="col-md-4">');
                                    echo ('<div class="custom-column">');
                                        echo ('<h3>Basket:</h3>');
                                        $stmt = $conn->prepare("SELECT * FROM tblBooks WHERE buyerID = :userID AND orderID IS NULL ORDER BY name ASC");
                                        $stmt->bindParam(':userID', $_SESSION['UserID'], PDO::PARAM_INT);
                                        $stmt->execute();
                                        $basketData = $stmt->fetch(PDO::FETCH_ASSOC);

                                        if ($basketData) {
                                            do {
                                                echo ('<div class="custom-row">');
                                                    echo('<br>' . $basketData["name"]);
                                                echo ('</div>');
                                            } while ($basketData = $stmt->fetch(PDO::FETCH_ASSOC));
                                        } else {
                                            echo('<br>There is nothing in the basket');
                                        }
                                    echo ('</div>');
                                echo ('</div>');
                            echo ('</div>');
                        echo ('</div>');
                    } else {
                        echo ('Book not found');
                    }
                } catch (PDOException $e) {
                    echo ("Error: " . $e->getMessage());
                }
            } else {
                echo ('Invalid bookID');
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
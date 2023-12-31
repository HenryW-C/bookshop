<?php
// link to connection.php to access the database
include_once("connection.php");

// starts session and ensures that user is logged in as admin, if not, they are sent to login
session_start(); 
$_SESSION['backURL']='categories.php';
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
                        <a type="button" href="/bookshop/admin_account.php" class="btn btn-primary">My Account</a>
                        <a type="button" href="/bookshop/basket.php" class="btn btn-primary">Basket</a>
                        <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>
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
                                // fetch all categories
                                $stmt = $conn->prepare("SELECT * FROM tblCategories ORDER BY categoryType, Category");
                                $stmt->execute();
                                $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);
                                // sets variable to determine if there are categories
                                if ($categoryData) {
                                    $categoryFull = 1;
                                }
                                else {
                                    $categoryFull = 0;
                                }
                                if ($categoryFull == 1) {
                                    // if there are categories, they are displayed
                                    echo ('<h2>Categories:</h2>');
                                    do {
                                        // row to fill the width of the page
                                        echo('<div class="custom-row" style="height:10vh">');
                                            echo ('<div class="left-content">'); // image on left of page
                                                echo ('<h3>'.$categoryData['category'].'</h3>');
                                            echo ('</div>');
                                            echo ('<div class="category-type">');
                                                if ($categoryData['categoryType'] == 1) {
                                                    echo ('<h3>Subject</h3>');
                                                }
                                                else {
                                                    echo ('<h3>Level</h3>');
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
                <p></p>
                <div class="custom-column" style="min-height:15vh;">
                    <h3>Add Category</h3>
                    <form action="addcategory.php" method="post">
                        <div class="custom-row" style="height:10vh">
                            <div class="left-content">
                                <input type="text" name="category" placeholder="Category" required>
                            </div>
                            <div class="category-type" >
                                <select name="categoryType" required>
                                    <option value="" disabled selected hidden>Category Type</option>
                                    <option value="1">Subject</option>
                                    <option value="0">Level</option>
                                </select>
                            </div>
                            <input class="btn btn-primary" type="submit" value="Add">
                        </div>
                    </form>
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
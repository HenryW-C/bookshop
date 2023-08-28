<?php
// link to connection.php to access the database
include_once("connection.php");

// starts session and ensures that user is logged in as admin, if not, they are sent to homepage
session_start(); 
if ($_SESSION['UserType'] != 1) {
  header('Location: homepage.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Account</title>
    <!-- links to stylesheets and google fonts -->
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
            <a class="logo" type="button" href="/bookshop/homepage.php">Bella's<br>Books </a>

            <!-- search bar including dropdown box and search button -->
            <div class="search-bar">
                <form class="d-flex" id="searchForm">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                            <span id="selectedOption">Categories</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" data-value="Option 1">Option 1</a>
                            <a class="dropdown-item" href="#" data-value="Option 2">Option 2</a>
                            <a class="dropdown-item" href="#" data-value="Option 3">Option 3</a>
                        </div>
                    </div>
                    <input type="hidden" id="selectedValue" name="selectedValue">
                    <input class="form-control me-2" type="search" placeholder="Search">
                    <button class="btn btn-outline-success go-button" type="submit">Go</button>
                </form>
            </div>

            <!-- button at end of navbar -->
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
                        <p>[Past Orders]</p>
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
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
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto Slab">
    
</head>
<body>
    
    <!-- top navbar -->
    <div class="navbar_top">
        <div class="container-fluid">
            <a class="logo" class="button" href="/bookshop/homepage.php">Bella's<br>Books </a>
                <span>
                <div class="float-end">
                    <div  class="btn-group" role="group" aria-label="Basic example">
                        <a type="button" href="/bookshop/basket.php" class="btn btn-primary">Basket</a>
                        <a type="button" href="/bookshop/account.php" class="btn btn-primary">My Account</a>
                        <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>
                    </div> 
                </div> 
                </span>
        </div>
    </div>

    <!-- body of website -->
    <div class="main">
      <a type="button" href="/bookshop/createadmin.php" class="btn btn-primary">Create Admin</a>
      <a type="button" href="/bookshop/managecategories.php" class="btn btn-primary">Manage Categories</a>
      <a type="button" href="/bookshop/managedatabases.php" class="btn btn-primary">Manage Databases</a>
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>
   
</body>
</html>
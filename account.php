<?php
// starts session and ensures that user is logged in, if not, they are sent to homepage
session_start(); 

if (!isset($_SESSION['UserType'])) {
  header('Location: homepage.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Home</title>
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
                        <!-- php switch statement to show select buttons dependant on user type -->
                        <?php 
                        switch ($_SESSION['UserType']??'') { 
                        case(1): ?>
                        <a type="button" href="/bookshop/admintools.php" class="btn btn-primary">Admin Tools</a>
                        <a type="button" href="/bookshop/basket.php" class="btn btn-primary">Basket</a>
                        <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>
                        <?php break; ?>

                        <?php case(0): ?>
                        <a type="button" href="/bookshop/basket.php" class="btn btn-primary">Basket</a>
                        <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>
                        <?php break; ?>
                        <?php } ?>
                    </div> 
                </div> 
                </span>
        </div>
    </div>

    <!-- body of website -->
    <div class="main">
        <p>Body</p>
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>
   
</body>
</html>
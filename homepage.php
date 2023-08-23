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
                        <!-- php if statement to show select buttons dependant on logged in -->
                        <?php session_start(); if(isset($_SESSION['Email'])): ?>
                        <a type="button" href="/bookshop/basket.php" class="btn btn-primary">Basket</a>
                        <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>

                        <?php else: ?>
                        <a type="button" href="/bookshop/login.php" class="btn btn-primary">Sign In</a>
                        <a type="button" href="/bookshop/signup.php" class="btn btn-primary">Sign Up</a>

                        <?php endif ?>
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
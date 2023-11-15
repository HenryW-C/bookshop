<!DOCTYPE html>
<html>
<head>
    
    <title>Home</title>
    <!-- links to stylesheets and google fonts -->
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto Slab">
    
</head>
<body>
    <!-- top navbar -->
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
                        if(isset($_SESSION['UserType'])){
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

                        <?php } else{ ?>
                        <a type="button" href="/bookshop/login.php" class="btn btn-primary">Sign In</a>
                        <a type="button" href="/bookshop/signup.php" class="btn btn-primary">Sign Up</a>
                        <?php } ?>
                    </div> 
                </div> 
            </span>
        </div>
    </div>



    <!-- body of website -->
    <div class="main">
        <h1>Welcome to Bella's Books</h1>
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>

</body>
</html>
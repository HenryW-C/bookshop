<!DOCTYPE html>
<html>
<head>
    
    <title>Template</title>
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
                        <a type="button" class="btn btn-primary">Basket</a>
                        <a type="button" class="btn btn-primary">My Account</a>
                        <a type="button" href="/bookshop/login.php" class="btn btn-primary">Sign In</a>
                    </div> 
                </div> 
                </span>
        </div>
    </div>

    <!-- body of website -->
    <div class="main">
        <form action="signupprocess.php" method = "post">
            Email:<input type="email" name="email"><br>
            First Name:<input type="text" name="forename"><br>
            Surname:<input type="text" name="surname"><br>
            Password:<input type="password" name="passwd"><br>
            Phone:<input type="tel" name="phone"><br>
            Address Line 1:<input type="text" name="address"><br>
            Postcode:<input type="text" name="postcode"><br>
            Card Number:<input type="password" name="cardno"><br>
            Card Name:<input type="text" name="cardname"><br>
            Card Expiry Date:<input type="text" name="cardexpiry"><br>
            Card Security Code:<input type="password" name="cardcvc"><br>
            <input type="submit" value="Sign up">
        </form>      
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>
   
</body>
</html>
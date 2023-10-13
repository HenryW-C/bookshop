<!DOCTYPE html>
<html>
<head>
    
    <title>Create Account</title>
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
            <a class="logo" class="button" href="/bookshop/homepage.php">Bella's<br>Books</a>
        </div>
    </div>

    <!-- body of website -->
    <div class="main">
    <div class="text-center">
        <h3> Sign Up </h3>
        <p style="color:red;">
            <?php
                session_start(); 
                if (isset($_SESSION['Message'])){
                    echo($_SESSION['Message']);
                    unset($_SESSION['Message']);
                } 
            ?>
        </p>
        <form action="signupprocess.php" method = "post">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="forename" placeholder="First Name" required><br>
            <input type="text" name="surname" placeholder="Surname" required><br>
            <input type="password" name="passwd" placeholder="Password" required><br>
            <input type="tel" name="phone" placeholder="Phone" required><br>
            <br>
            <input type="text" name="address" placeholder="Address Line 1" required><br>
            <input type="text" name="postcode" placeholder="Postcode" required><br>
            <br>
            <input type="text" name="cardno" placeholder="Card Number" required><br>
            <input type="text" name="cardname" placeholder="Card Name" required><br>
            <input type="text" name="cardexpiry" placeholder="Card Expiry Date" required><br>
            <input type="password" name="cardcvc" placeholder="Card CVC" required><br>
            <br>
            <input type="submit" value="Sign up">
        </form>      
    </div>
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>
   
</body>
</html>
<?php
// link to connection.php to access the database
include_once("connection.php");

// starts session and ensures that user is logged in as customer, if not, they are sent to login
session_start(); 
$_SESSION['backURL']='accountinfo.php';
if (!isset($_SESSION['Email'])) {
  $_SESSION['Message'] = "Please login to use this service";
  header('Location: login.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Details</title>
    <!-- links to stylesheets and google fonts -->
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
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
            <a class="logo" type="button" href="homepage.php">Bella's<br>Books</a>

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
                            switch ($_SESSION['UserType']) { 
                            case(1): ?>
                            <a type="button" href="admin_account.php" class="btn btn-primary">My Account</a>
                            <a type="button" href="basket.php" class="btn btn-primary">Basket</a>
                            <a type="button" href="logout.php" class="btn btn-primary">Logout</a>
                            <?php break; ?>

                            <?php case(0): ?>
                            <a type="button" href="customer_account.php" class="btn btn-primary">My Account</a>
                            <a type="button" href="basket.php" class="btn btn-primary">Basket</a>
                            <a type="button" href="logout.php" class="btn btn-primary">Logout</a>
                            <?php break;
                            } ?>
                    </div> 
                </div> 
            </span>
        </div>
    </div>

    <!-- body of website -->
    <div class="main">
        <div class="text-center">
            <h1> Edit Details </h1>
            <p style="color:red;">
                <?php
                    // displays error message
                    if (isset($_SESSION['Message'])){
                        echo($_SESSION['Message']);
                        unset($_SESSION['Message']);
                    } 

                    // fetches user details to pre-fill form
                    $stmt = $conn->prepare("SELECT * FROM tblUsers WHERE userID=:userID");
                    $stmt->bindParam(':userID', $_SESSION['UserID']);
                    $stmt->execute();
                    $results = $stmt->fetchAll();
                    
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
                        $email = $row['email'];
                        $forename = $row['forename'];
                        $surname = $row['surname'];
                        $phone = $row['telephone'];
                        $addressLine = $row['addressLine'];
                        $postcode = $row['postcode'];
                        $cardName = $row['cardName'];
                        $cardExpiry = $row['cardExpiry'];
                    }
                ?>
            </p>
            <!-- displays user details in rows with information filled -->
            <form action="accountinfoprocess.php" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-sm text-end" style="line-height: 1.85em">
                            Email:<br>
                            First Name:<br>
                            Surname:<br>
                            Phone:<br>
                        </div>
                        <div class="col-sm text-start">
                            <input type="email" name="email" value="<?php echo($email) ?>" required><br>
                            <input type="text" name="forename" value="<?php echo($forename) ?>" required><br>
                            <input type="text" name="surname" value="<?php echo($surname) ?>" required><br>
                            <input type="tel" name="phone" value="<?php echo($phone) ?>" required><br>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm text-end" style="line-height: 1.85em">
                            Address Line 1:<br>
                            Postcode:<br>
                        </div>
                        <div class="col-sm text-start">
                            <input type="text" name="address" value="<?php echo($addressLine) ?>" required><br>
                            <input type="text" name="postcode" value="<?php echo($postcode) ?>" required><br>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm text-end" style="line-height: 1.85em">
                            Card Name:<br>
                            Card Expiry:<br>
                        </div>
                        <div class="col-sm text-start">
                            <input type="text" name="cardname" value="<?php echo($cardName) ?>" required><br>
                            <input type="text" name="cardexpiry" value="<?php echo($cardExpiry) ?>" required><br>
                        </div>
                    </div>
                    <br>
                    <h3>Secure Details</h3>
                    <p>[Optional]</p>
                    <div class="row">
                        <div class="col-sm text-end" style="line-height: 1.85em">
                            Current Password:<br>
                            New Password:<br>
                        </div>
                        <div class="col-sm text-start">
                            <input type="password" name="currentpass" placeholder="Current Password"><br>
                            <input type="password" name="newpass" placeholder="New Password"><br>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm text-end" style="line-height: 1.85em">
                            Card Number:<br>
                            Card CVC:<br>
                        </div>
                        <div class="col-sm text-start">
                            <input type="password" name="cardno" placeholder="New Card Number"><br>
                            <input type="password" name="cardCVC" placeholder="New Card CVC"><br>
                        </div>
                    </div>
                    <br>
                    <input type="submit" value="Save Changes">
            </form>    
        </div>  
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>
</body>
</html>
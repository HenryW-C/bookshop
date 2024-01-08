<?php
session_start(); 
$_SESSION['backURL']=$_SERVER['REQUEST_URI'];
?>
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
                        if(isset($_SESSION['UserType'])){
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

                        <?php } else{ ?>
                        <a type="button" href="login.php" class="btn btn-primary">Sign In</a>
                        <a type="button" href="signup.php" class="btn btn-primary">Sign Up</a>
                        <?php } ?>
                    </div> 
                </div> 
            </span>
        </div>
    </div>



    <!-- body of website -->
    <div class="featured">
        <div class="main">
            <h1>Welcome to Bella's Books</h1>
            <div class="container-fluid mt-5"> 
                <div class="row">
                    <h3>Featured Books</h3>
                    <div class="col-md-12">
                        <div style="height:32vh;" class="custom-column">
                            <div class="row">
                                <?php
                                    // select the 6 most expensive books
                                    $stmt = $conn->prepare("SELECT * FROM tblBooks WHERE buyerID IS NULL ORDER BY price DESC LIMIT 6");
                                    $stmt->execute();

                                    // fetch all results and display them
                                    $bookData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($bookData as $row) {
                                            echo ('<div class="col-md-2 image-container">');
                                            echo ('<a href="item.php?bookID=' . $row["bookID"] . '">');
                                            // if there is an image, it is displayed. otherwise, blank image and text is displayed
                                            if($row['image']) {
                                                echo ('<img class="image" src="images/' . $row['image'] . '" alt="' . $row['name'] . '"><br><br>');
                                            } else {
                                                echo ('<div class="noimage">');
                                                    echo ('<div class="centered">'.$row['name'].'</div>');
                                                    echo ('<img class="image" src="images/default.png"><br><br>');
                                                echo ('</div>');
                                            }
                                            echo('</a>');
                                            echo ('</div>');
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <p></p>
                    <h3>Latest Listings</h3>
                    <div class="col-md-12">
                        <div style="height:32vh;" class="custom-column">
                            <div class="row">
                                <?php
                                    // select the 6 newest books
                                    $stmt = $conn->prepare("SELECT * FROM tblBooks WHERE buyerID IS NULL ORDER BY bookID DESC LIMIT 6");
                                    $stmt->execute();

                                    // fetch all results and display them
                                    $bookData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($bookData as $row) {
                                        echo ('<div class="col-md-2 image-container">');
                                        echo ('<a href="item.php?bookID=' . $row["bookID"] . '">');
                                        // if there is an image, it is displayed. otherwise, blank image and text is displayed
                                        if($row['image']) {
                                            echo ('<img class="image" src="images/' . $row['image'] . '" alt="' . $row['name'] . '"><br><br>');
                                        } else {
                                            echo ('<div class="noimage">');
                                                echo ('<div class="centered">'.$row['name'].'</div>');
                                                echo ('<img class="image" src="images/default.png"><br><br>');
                                            echo ('</div>');
                                        }
                                        echo('</a>');
                                        echo ('</div>');
                                    }
                                ?>
                            </div>
                        </div>
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
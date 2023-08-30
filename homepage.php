<!DOCTYPE html>
<html>
<head>
    
    <title>Home</title>
    <!-- links to stylesheets and google fonts -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
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
                        <!-- dropdown box code -->
                        <select class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                            <!-- default 'categories' label -->
                            <option value="" disabled selected>Categories</option>
                            <option value=""> All</option>
                            <optgroup label="Levels">
                                <!-- php code to take levels from table and display as dropdown options -->
                                <?php
                                session_start(); 
                                include_once ("connection.php");
                                $stmt = $conn->prepare('SELECT category FROM tblCategories WHERE categoryType = 0');
                                $stmt->execute();
                                $results = $stmt->fetchAll();

                                foreach ($results as $row): ?>
                                    <option value="<?=$row["category"]?>"><?=$row["category"]?></option>
                                <?php endforeach ?>
                            </optgroup>

                            <optgroup label="Subjects">
                                <!-- php code to take levels from table and display as dropdown options -->
                                <?php
                                include_once ("connection.php");
                                $stmt = $conn->prepare('SELECT category FROM tblCategories WHERE categoryType = 1');
                                $stmt->execute();
                                $results = $stmt->fetchAll();

                                foreach ($results as $row): ?>
                                    <option value="<?=$row["category"]?>"><?=$row["category"]?></option>
                                <?php endforeach ?>
                            </optgroup>
                        </select>
                    </div>
                    <input type="hidden" id="selectedValue" name="selectedValue">
                    <input class="form-control me-2" type="search" placeholder="Search">
                    <button class="btn btn-outline-success go-button" type="submit">Go</button>
                </form>
            </div>

            <!-- buttons at end of navbar -->
            <span>
                <div class="float-end">
                    <div  class="btn-group" role="group">
                        <!-- php switch statement to show select buttons dependant on user type -->
                        <?php
                        switch ($_SESSION['UserType']??'') { 
                        case(1): ?>
                        <a type="button" href="/bookshop/admin_account.php" class="btn btn-primary">My Account</a>
                        <a type="button" href="/bookshop/basket.php" class="btn btn-primary">Basket</a>
                        <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>
                        <?php break; ?>

                        <?php case(0): ?>
                        <a type="button" href="/bookshop/customer_account.php" class="btn btn-primary">My Account</a>
                        <a type="button" href="/bookshop/basket.php" class="btn btn-primary">Basket</a>
                        <a type="button" href="/bookshop/logout.php" class="btn btn-primary">Logout</a>
                        <?php break; ?>

                        <?php default: ?>
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
        <p>Body</p>
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>
   

    <!-- script to show selected category in dropdown -->
    <script>
        $(document).ready(function() {
            $('.dropdown-item').on('click', function() {
                var selectedValue = $(this).data('value');
                $('#selectedOption').text(selectedValue);
                $('#selectedValue').val(selectedValue);
            });
        });
    </script>



</body>
</html>
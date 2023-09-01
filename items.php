<?php
include_once("connection.php");

// starts session and ensures that user is logged in, if not, they are sent to login
session_start(); 
$_SESSION['backURL']=$_SERVER['REQUEST_URI'];
if (!isset($_SESSION['Email'])) {
  $_SESSION['Message'] = "Please login to use this service";
  header('Location: login.php');
  }

array_map("htmlspecialchars", $_GET);

$searchQuery=' ';
$selectedCategory=' ';
// takes search inputs and sets them as variables
if (isset($_GET['selectedCategory']) && isset($_GET['searchQuery'])) {
  $selectedCategory = $_GET['selectedCategory'];
  $searchQuery = $_GET['searchQuery'];
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Books</title>
    <!-- links to stylesheets and google fonts -->
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto Slab">
    
</head>
<body>
    
  <!-- top navbar -->
  <div class="white_box_top"></div>
  <div class="navbar_top">
      <div class="container-fluid">

          <!-- logo and link to homepage -->
          <a class="logo" type="button" href="/bookshop/homepage.php">Bella's<br>Books </a>

          <!-- search bar including dropdown box and search button -->
          <div class="search-bar">
              <form class="d-flex" id="searchForm" action="items.php" method="GET">
                  <div class="dropdown">
                      <!-- dropdown box code -->
                      <select class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" name="selectedCategory">
                          <!-- default 'categories' label -->
                          <option value="">Categories</option>
                          <option value=""> All</option>
                          <optgroup label="Levels">
                              <!-- php code to take levels from table and display as dropdown options -->
                              <?php
                              include_once ("connection.php");
                              $stmt = $conn->prepare('SELECT category FROM tblCategories WHERE categoryType = 0');
                              $stmt->execute();
                              $results = $stmt->fetchAll();

                              foreach ($results as $row): ?>
                                  <option value="<?=$row["category"]?>"><?=$row["category"]?></option>
                              <?php endforeach ?>
                          </optgroup>

                          <optgroup label="Subjects">
                              <!-- php code to take subjects from table and display as dropdown options -->
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
                  <input class="form-control me-2" type="search" placeholder="Search" name="searchQuery">
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
        <div class="books">
            <?php
            // base query
            $query = "SELECT * FROM tblBooks WHERE tblBooks.sold = 0";

            // initialize the message
            $message = '';

            // check if selectedCategory is not blank
            if (!empty($selectedCategory)) {
                $query .= " AND (tblBooks.level = :selectedCategory OR tblBooks.subject = :selectedCategory)";
                $message = 'You have searched ' . $searchQuery . ' in Category: ' . $selectedCategory . '<br><br>';
            } else {
                $message = 'You have searched ' . $searchQuery . ' in all categories <br><br>';
            }

            // check if searchQuery is not blank
            if (!empty($searchQuery)) {
                $query .= " AND tblBooks.name LIKE CONCAT('%', :searchQuery, '%')";
            }

            // prepare and execute the dynamic query
            $query .= " ORDER BY name ASC";
            $stmt = $conn->prepare($query);

            if (!empty($selectedCategory)) {
                $stmt->bindParam(':selectedCategory', $selectedCategory, PDO::PARAM_STR);
            }

            if (!empty($searchQuery)) {
                $stmt->bindParam(':searchQuery', $searchQuery, PDO::PARAM_STR);
            }

            $stmt->execute();
            $count=0;

            // print the message
            echo $message;

            // displaying each matching item in a 4-wide grid
            echo '<div class="row row-cols-1 row-cols-md-4 g-3">';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo ('<div class="col">');
                        echo ('<div class="card h-100">');
                            echo ('<div class="card-body">');
                                // link to individual book page
                                echo ('<a class=link href="item.php?bookID=' . $row["bookID"] . '" class="card-title">');
                                    echo '<div class="image-container">';
                                        // if there is an image, it is displayed. otherwise, black image and text is displayed
                                        if($row['image']) {
                                            echo ('<img class="image" src="images/' . $row['image'] . '" alt="' . $row['name'] . '"><br><br>');
                                        } else {
                                            echo ('<div class="noimage">');
                                                echo ('<div class="centered">No Image</div>');
                                                echo ('<img class="image" src="images/default.png" alt="No Image"><br><br>');
                                            echo ('</div>');
                                        }
                                    echo ('</div>');
                                    echo ('<h5 class=name>' . $row['name'] . '</h5>');
                                echo ('</a>');
                                echo ('<p class="card-text text-truncate">' . '£' . $row['price'] . '</p>');
                                // link to add to basket page
                                echo ('<a type="button" href="addtobasket.php?bookID=' . $row["bookID"] . '" class="btn btn-sm">Add to Basket</a>');
                            echo ('</div>');
                        echo ('</div>');
                    echo ('</div>');
                }
            echo '</div>';
            ?>
        </div>
    </div>

  <!-- bottom navbar -->
  <div class="white_box_bottom"><div>
  <div class="navbar_bottom">
      <a> </a>
  </div>

</body>
</html>
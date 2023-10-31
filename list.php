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
    
    <title>List Book</title>
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
          <a class="logo" type="button" href="/bookshop/homepage.php">Bella's<br>Books</a>

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
                      <?php break; }?>
                  </div> 
              </div> 
          </span>
      </div>
  </div>

    <!-- body of website -->
    <div class="main">
    </div>

  <!-- bottom navbar -->
  <div class="white_box_bottom"><div>
  <div class="navbar_bottom">
      <a> </a>
  </div>

</body>
</html>
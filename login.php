<!DOCTYPE html>
<html>
<head>
    
    <title>Login</title>
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
                        <a type="button" href="/bookshop/signup.php" class="btn btn-primary">Sign Up</a>
                    </div> 
                </div> 
                </span>
        </div>
    </div>

    <!-- body of website -->
    <div class="main">
      <form action="loginprocess.php" method= "POST">
         User email:<input type="text" name="Email"><br>
         Password:<input type="password" name="Pword"><br>
         <input type="submit" value="Login">
      </form>
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>
   
</body>
</html>
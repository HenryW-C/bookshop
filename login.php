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
        </div>
    </div>

    <!-- body of website -->
    
    <div class="main">
            <form action="loginprocess.php" method= "POST">
                <div class="text-center">
                        <h3> Login </h3>
                            <p style="color:red;">
                                <?php
                                session_start(); 
                                if (isset($_SESSION['Message'])){
                                    echo($_SESSION['Message']);
                                    unset($_SESSION['Message']);
                                } 
                                ?>
                            </p>
                        <input type="text" name="Email" placeholder="Email" required><br><br>
                        <input type="password" name="Pword" placeholder="Password" required><br><br>
                        <input type="submit" value="Login">
                </div>
            </form>
    </div> 

    <!-- bottom navbar -->
    <div class="navbar_bottom">
        <a> </a>
    </div>
   
</body>
</html>
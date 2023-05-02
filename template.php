<?php
session_start(); 
if (!isset($_SESSION['name']))
{   
    $_SESSION['backURL'] = $_SERVER['REQUEST_URI'];
    header("Location:login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Template</title>
    
</head>
<body>
       

   
</body>
</html>

<?php
include_once('connection.php');
?>
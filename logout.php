<?php
//ends the session and sends the user to homepage
session_start();
if(isset($_SESSION['Email']))
{
    unset($_SESSION['Email']);
}
header("Location: homepage.php");
?>
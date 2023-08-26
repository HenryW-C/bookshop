<?php
//ends the session and sends the user to homepage
session_start();

session_destroy();

header("Location: homepage.php");
?>
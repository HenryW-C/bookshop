<?php
// starts session and ensures that user is logged in, if not, they are sent to login
session_start(); 

if (!isset($_SESSION['Email'])) {
    $_SESSION['backURL'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php');
  }
?>
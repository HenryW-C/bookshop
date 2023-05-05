<?php
// starts session and ensures that user is logged in, if not, they are sent to homepage
session_start(); 

if (isset($_SESSION['user'])) {
    // logged in
  } else {
    // not logged in
  }
?>
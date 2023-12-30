<?php
include_once("connection.php");
session_start(); 
array_map("htmlspecialchars", $_GET);

// removes the category from the database
$stmt = $conn->prepare("DELETE FROM tblCategories WHERE categoryID = :categoryID");
$stmt->bindParam(':categoryID', $_GET['categoryID'], PDO::PARAM_INT);
$stmt->execute();

// sends the user to the category page
header('Location: categories.php');
?>
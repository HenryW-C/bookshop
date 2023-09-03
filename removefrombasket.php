<?php
include_once("connection.php");
session_start(); 
array_map("htmlspecialchars", $_GET);

// changes the book's buyerID to null, and sets it as not sold
$stmt = $conn->prepare("UPDATE tblBooks SET buyerID = null, sold=0 WHERE bookID = :bookID");
$stmt->bindParam(':bookID', $_GET['bookID'], PDO::PARAM_INT);
$stmt->execute();

// sends the user to the basket page
header('Location: basket.php');
?>
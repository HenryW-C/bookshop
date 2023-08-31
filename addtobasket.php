<?php
include_once("connection.php");
session_start(); 
array_map("htmlspecialchars", $_GET);

// changes the book's buyerID to the logged in user's ID, and sets it as sold
$stmt = $conn->prepare("UPDATE tblBooks SET buyerID = :userID, sold=1 WHERE bookID = :bookID");
$stmt->bindParam(':bookID', $_GET['bookID'], PDO::PARAM_INT);
$stmt->bindParam(':userID', $_SESSION['UserID'], PDO::PARAM_INT);
$stmt->execute();

// sends the user to the items page with their previous search
if (isset($_SESSION['backURL'])){
    header('Location: ' . $_SESSION['backURL']);
}  
else {
    header('Location: homepage.php');
}
?>
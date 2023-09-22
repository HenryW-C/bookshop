<?php
include_once("connection.php");
session_start(); 

$date = date("Y-m-d h:m:s");

$stmt = $conn->prepare("INSERT INTO 
    TblOrders (orderID,totalPrice,orderDate,userID)
    VALUES (null,:price,:date,:userID)");

    $stmt->bindParam(':price', $_SESSION['totalPrice']);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':userID', $_SESSION["UserID"]);
    $stmt->execute();

$stmt = $conn->prepare("");

    $stmt->bindParam(':price', $_SESSION['totalPrice']);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':userID', $_SESSION["UserID"]);
    $stmt->execute();

$_SESSION['totalPrice']=0;

// sends the user to the homepage
header('Location: homepage.php');
?>
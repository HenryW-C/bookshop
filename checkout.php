<?php
include_once("connection.php");
session_start(); 

// sets a date varaible
date_default_timezone_set('UTC');
$date = date("Y-m-d H:i:s");

// creates an entry in the order table
$stmt = $conn->prepare("INSERT INTO 
    TblOrders (orderID,totalPrice,orderDate,userID)
    VALUES (null,:price,:date,:userID)");

    $stmt->bindParam(':price', $_SESSION['totalPrice']);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':userID', $_SESSION["UserID"]);
    $stmt->execute();

// fetches the orderID that was just created
$lastInsertID = $conn->lastInsertId();

// updates the book table to reflect latest order
$stmt = $conn->prepare("UPDATE tblBooks SET orderID=:orderID WHERE buyerID=:buyerID AND orderID IS NULL");

    $stmt->bindParam(':orderID', $lastInsertID);
    $stmt->bindParam(':buyerID', $_SESSION["UserID"]);
    $stmt->execute();

// resets total price variable
$_SESSION['totalPrice']=0;

// sends the user to the homepage
header('Location: homepage.php');
?>
<?php
include_once("connection.php");
session_start(); 

// sets a date varaible
date_default_timezone_set('Europe/London');
$date = date("Y-m-d H:i:s");

// fetches the address of the seller
$stmt = $conn->prepare("SELECT forename, addressLine, postcode FROM tblUsers WHERE userID=:buyerID");
$stmt->bindParam(':buyerID', $_SESSION["UserID"]);
$stmt->execute();

// saves the results
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$addressLine = $row['addressLine'];
$postcode = $row['postcode'];
$name = $row['forename'];

// creates an entry in the order table
$stmt = $conn->prepare("INSERT INTO 
    tblOrders (orderID,totalPrice,orderDate,userID)
    VALUES (null,:price,:date,:userID)");

    $stmt->bindParam(':price', $_SESSION['totalPrice']);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':userID', $_SESSION["UserID"]);
    $stmt->execute();

// fetches the orderID that was just created
$lastInsertID = $conn->lastInsertId();

// fetches the userIDs of all the sellers of the books in the order
$stmt = $conn->prepare("SELECT sellerID,name FROM tblBooks WHERE buyerID=:buyerID AND orderID IS NULL");
    $stmt->bindParam(':buyerID', $_SESSION["UserID"]);
    $stmt->execute();

// iterates through the results and creates an entry in the message table for each seller
while ($row2 = $stmt->fetch(PDO::FETCH_ASSOC))
{
    // creates an entry in the message table
    $stmt3 = $conn->prepare("INSERT INTO 
    tblMessages (messageID,senderUserID,recieveUserID,sendDate,content)
    VALUES (null,:buyerID,:sellerID,:sendDate,:content)");

        $stmt3->bindParam(':buyerID', $_SESSION["UserID"]);
        $stmt3->bindParam(':sellerID', $row2['sellerID']);
        $stmt3->bindParam(':sendDate', $date);
        $stmt3->bindValue(':content', "<h3>Congratulations!</h3>Your book '".$row2['name']."' has been bought. You are now required to send this book to ".$name.", User #".$row2['sellerID'].". Please send this book within 3 days. You may also message the buyer to make alternate arrangements.<br><br>Address Line 1: ".$addressLine."<br>Postcode: ".$postcode);
        $stmt3->execute();
}

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
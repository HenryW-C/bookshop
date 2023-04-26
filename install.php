<?php
// links to connection.php to access the database
include_once("connection.php");

// create user table
$stmt = $conn->prepare("DROP TABLE IF EXISTS TblUsers;
CREATE TABLE TblUsers
(userID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userType TINYINT(1) NOT NULL,
userEmail VARCHAR(40) NOT NULL,
userPassword VARCHAR(30) NOT NULL,
userForename VARCHAR(20) NOT NULL,
userSurname VARCHAR(20) NOT NULL,
userTelephone INT(11),
userAddressLine VARCHAR(20),
userPostcode VARCHAR(7))");
$stmt->execute();

// create books table
$stmt = $conn->prepare("DROP TABLE IF EXISTS TblBooks;
CREATE TABLE TblBooks
(bookID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
bookName VARCHAR(100) NOT NULL,
bookAuthor VARCHAR(100),
bookSubject VARCHAR(20),
bookLevel VARCHAR(20),
bookDescription VARCHAR(1000) NOT NULL,
bookImage INT(100),
bookPrice FLOAT(4,2) NOT NULL,
bookSold TINYINT(1) NOT NULL,
userID INT(6) NOT NULL)");
$stmt->execute();

// create orders table
$stmt = $conn->prepare("DROP TABLE IF EXISTS TblOrders;
CREATE TABLE TblOrders
(orderID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
orderContents VARCHAR(255) NOT NULL,
orderPrice FLOAT(4,2) NOT NULL,
userAddressLine VARCHAR(20) NOT NULL,
userPostcode VARCHAR(7) NOT NULL,
cardNo VARCHAR(16) NOT NULL,
cardName VARCHAR(127) NOT NULL,
cardExpiry VARCHAR(5) NOT NULL,
cardCVC VARCHAR(3) NOT NULL,
orderDate DATE NOT NULL,
userID INT(6))");
$stmt->execute();

// create basket table
$stmt = $conn->prepare("DROP TABLE IF EXISTS TblBasket;
CREATE TABLE tblBasket
(userID INT(6),
basketContents VARCHAR(255) NOT NULL,
basketPrice FLOAT(4,2))");
$stmt->execute();

// create messages table
$stmt = $conn->prepare("DROP TABLE IF EXISTS TblMessages;
CREATE TABLE TblMessages
(messageID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
senderUserID INT(6) NOT NULL,
recieveUserID INT(6) NOT NULL,
sendDate DATETIME NOT NULL,
content VARCHAR(1023) NOT NULL)");
$stmt->execute();

// insert test customer
$sql = "INSERT INTO TblUsers (userType, userEmail, userPassword, userForename, userSurname, userTelephone, userAddressLine,userPostcode)
  VALUES ('1', 'jill,wones@aol.com', 'pass', 'Jill', 'Wones', '07957159532', 'Laundimer House', 'PE84AP')";
  // use exec() because no results are returned
  $conn->exec($sql);

$conn=null;
?>
<?php
// links to connection.php to access the database
include_once("connection.php");

// create user table
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblUsers;
CREATE TABLE tblUsers
(userID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userType TINYINT(1) NOT NULL,
userEmail VARCHAR(40) NOT NULL,
userPassword VARCHAR(30) NOT NULL,
userForename VARCHAR(20) NOT NULL,
userSurname VARCHAR(20) NOT NULL,
userTelephone VARCHAR(11),
userAddressLine VARCHAR(20),
userPostcode VARCHAR(7))");
$stmt->execute();

// create books table
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblBooks;
CREATE TABLE tblBooks
(bookID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
bookName VARCHAR(100) NOT NULL,
bookAuthor VARCHAR(100),
bookSubject VARCHAR(20),
bookLevel VARCHAR(20),
bookDescription VARCHAR(1000) NOT NULL,
bookImage VARCHAR(100),
bookPrice FLOAT(4,2) NOT NULL,
bookSold TINYINT(1) NOT NULL,
userID INT(6) NOT NULL)");
$stmt->execute();

// create orders table
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblOrders;
CREATE TABLE tblOrders
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
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblBasket;
CREATE TABLE tblBasket
(userID INT(6),
basketContents VARCHAR(255) NOT NULL,
basketPrice FLOAT(4,2))");
$stmt->execute();

// create messages table
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblMessages;
CREATE TABLE tblMessages
(messageID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
senderUserID INT(6) NOT NULL,
recieveUserID INT(6) NOT NULL,
sendDate DATETIME NOT NULL,
content VARCHAR(1023) NOT NULL)");
$stmt->execute();

// create 2D array of users
$users = [
  ['1', 'jill,wones@aol.com', 'pass', 'Jill', 'Wones', '07957159532', 'Laundimer House', 'PE84AP'],
  ['0', 'roris.byabov@yahoo.com', 'pass', 'Roris', 'Byabov', '07957159532', 'Laundimer House', 'PE84AP'],
  ];

// inputs array into table by executing row-by-row
$stmt = $conn->prepare("INSERT INTO tblUsers (userType, userEmail, userPassword, userForename, userSurname, userTelephone, userAddressLine,userPostcode) VALUES (?,?,?,?,?,?,?,?)");
try {
    $conn->beginTransaction();
    foreach ($users as $row)
    {
        $stmt->execute($row);
    }
    $conn->commit();
}catch (Exception $e){
    $conn->rollback();
    throw $e;
}

// create 2D array of books
$books = [
  ['000001', 'OCR Computer Science Algorithms', 'Craig and Dave', 'Computer Science', 'A-Level', 'Contains all of the required algorithms to pass your exams', '000001.png', '6.40', '0', '000001'],
  ];

// inputs array into table by executing row-by-row
$stmt = $conn->prepare("INSERT INTO tblBooks (bookId, bookName, bookAuthor, bookSubject, bookLevel, bookDescription, bookImage, bookPrice, bookSold, userID) VALUES (?,?,?,?,?,?,?,?,?,?)");
try {
    $conn->beginTransaction();
    foreach ($books as $row)
    {
        $stmt->execute($row);
    }
    $conn->commit();
}catch (Exception $e){
    $conn->rollback();
    throw $e;
}


$conn=null;
?>
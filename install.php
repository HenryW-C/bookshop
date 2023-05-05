<?php
// links to connection.php to access the database
include_once("connection.php");

// create user table
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblUsers;
CREATE TABLE tblUsers
(userID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userType TINYINT(1) NOT NULL,
userEmail VARCHAR(40) NOT NULL,
userPassword VARCHAR(300) NOT NULL,
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
  ['1', 'jill.wones@aol.com', password_hash("pass", PASSWORD_DEFAULT), 'Jill', 'Wones', '07957159532', 'Laundimer House', 'PE84AP'],
  ['0', 'roris.byabov@yahoo.com', password_hash("pass", PASSWORD_DEFAULT), 'Roris', 'Byabov', '07957159532', 'Laundimer House', 'PE84AP'],
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
  ['000002', 'A Promised Land', 'Barack Obama', 'Politics', null, 'Memoir', '000002.png', '7.30', '0', '000001'],
  ['000003', 'CGP IGCSE Maths', 'CGP', 'Maths', 'GCSE', 'Edexcel IGCSE Maths, 2018', '000003.png', '8.20', '1', '000002'],
  ['000004', 'CIE Physics (A Level)', 'David Sang, Graham Jones, Gurinder Chadha & Richard Woodside', 'Physics', 'A-Level', 'cie a level physics textbook. little wear. third edition', '000004.png', '11.12', '0', '000002'],
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

// insert test order
$stmt = $conn->prepare("INSERT INTO tblOrders (orderID, userID, orderContents, orderPrice, userAddressLine, userPostcode, cardNo, cardName, cardExpiry, cardCVC, orderDate) 
    VALUES ('000001','000001','000001,000002','13.70','Laundimer House','PE84AP','5105105105105100','MR HENRY WOOD-COLLINS','07/25','218','2023-03-14')");
$stmt->execute();

// insert test messages
$stmt = $conn->prepare("INSERT INTO tblMessages (messageID, senderUserID, recieveUserID, sendDate, content) 
    VALUES ('000001','000001','000002','2023-03-04 10:52:31','Hello, I was wondering if this book, number 632456, contains the original audio CD? Many thanks, Chantelle.')");
$stmt->execute();

// insert test basket
$stmt = $conn->prepare("INSERT INTO tblBasket (userID, basketContents, basketPrice) 
    VALUES ('000001','000002,000003','15.50')");
$stmt->execute();

$conn=null;
?>
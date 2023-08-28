<?php
// links to connection.php to access the database
include_once("connection.php");

// create user table
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblUsers;
CREATE TABLE tblUsers
(userID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userType BOOL NOT NULL,
email VARCHAR(40) NOT NULL,
password VARCHAR(300) NOT NULL,
forename VARCHAR(20) NOT NULL,
surname VARCHAR(30) NOT NULL,
telephone VARCHAR(11),
addressLine VARCHAR(20),
postcode VARCHAR(7),
cardNo CHAR(16),
cardName VARCHAR(100),
cardExpiry CHAR(5),
cardCVC CHAR(3))");
$stmt->execute();

// create books table
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblBooks;
CREATE TABLE tblBooks
(bookID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
author VARCHAR(100),
subject VARCHAR(20),
level VARCHAR(20),
description VARCHAR(1000) NOT NULL,
image VARCHAR(100),
price FLOAT(4,2) NOT NULL,
sold BOOL NOT NULL,
sellerID INT(6) NOT NULL,
buyerID INT(6),
orderID INT(6))");
$stmt->execute();

// create orders table
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblOrders;
CREATE TABLE tblOrders
(orderID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
totalPrice FLOAT(5,2) NOT NULL,
orderDate DATETIME NOT NULL,
userID INT(6) NOT NULL)");
$stmt->execute();

// create messages table
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblMessages;
CREATE TABLE tblMessages
(messageID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
senderUserID INT(6) NOT NULL,
recieveUserID INT(6) NOT NULL,
sendDate DATETIME NOT NULL,
content VARCHAR(1000) NOT NULL)");
$stmt->execute();

// create categories table
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblCategories;
CREATE TABLE tblCategories
(category VARCHAR(100) PRIMARY KEY,
categoryType BOOL NOT NULL)");
$stmt->execute();

// create 2D array of users
$users = [
  ['0', 'jill.wones@aol.com', password_hash("pass", PASSWORD_DEFAULT), 'Jill', 'Wones', '07957159532', 'Laundimer House', 'PE84AP', '5105105105105100', 'MR JILL WONES', '07/25', '218'],
  ['1', 'roris.byabov@yahoo.com', password_hash("pass", PASSWORD_DEFAULT), 'Roris', 'Byabov', null, null, null, null, null, null, null],
  ];

// inputs array into table by executing row-by-row
$stmt = $conn->prepare("INSERT INTO tblUsers (userType, email, password, forename, surname, telephone, addressLine, postcode, cardNo, cardName, cardExpiry, cardCVC) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
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
  ['000001', 'OCR Computer Science Algorithms', 'Craig and Dave', 'Computer Science', 'A-Level', 'Contains all of the required algorithms to pass your exams', '000001.png', '6.40', '0', '000001', null, null],
  ['000002', 'A Promised Land', 'Barack Obama', 'Politics', null, 'Memoir', '000002.png', '7.30', '0', '000001', null, null],
  ['000003', 'CGP IGCSE Maths', 'CGP', 'Maths', 'GCSE', 'Edexcel IGCSE Maths, 2018', '000003.png', '8.20', '1', '000002', '000001', '000001'],
  ['000004', 'CIE Physics (A Level)', 'David Sang, Graham Jones, Gurinder Chadha & Richard Woodside', 'Physics', 'A-Level', 'cie a level physics textbook. little wear. third edition', '000004.png', '11.12', '0', '000002', null, null],
  ];

// inputs array into table by executing row-by-row
$stmt = $conn->prepare("INSERT INTO tblBooks (bookID, name, author, subject, level, description, image, price, sold, sellerID, buyerID, orderID) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
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

// create 2D array of categories
$categories = [
    ['Physics', 1],
    ['Maths', 1],
    ['Computer Science', 1],
    ['GCSE', 0],
    ['A-Level', 0],
    ];
  
  // inputs array into table by executing row-by-row
  $stmt = $conn->prepare("INSERT INTO tblCategories (category, categoryType) VALUES (?,?)");
  try {
      $conn->beginTransaction();
      foreach ($categories as $row)
      {
          $stmt->execute($row);
      }
      $conn->commit();
  }catch (Exception $e){
      $conn->rollback();
      throw $e;
  }

// insert test order
$stmt = $conn->prepare("INSERT INTO tblOrders (orderID, totalPrice, orderDate, userID) 
    VALUES ('000001','13.70','2023-03-14 10:52:31','000001')");
$stmt->execute();

// insert test messages
$stmt = $conn->prepare("INSERT INTO tblMessages (messageID, senderUserID, recieveUserID, sendDate, content) 
    VALUES ('000001','000001','000002','2023-03-04 10:52:31','Hello, I was wondering if this book, number 632456, contains the original audio CD? Many thanks, Chantelle.')");
$stmt->execute();

$conn=null;
?>
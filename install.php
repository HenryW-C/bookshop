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
telephone VARCHAR(15),
addressLine VARCHAR(20),
postcode VARCHAR(7),
cardNo VARCHAR(300),
cardName VARCHAR(100),
cardExpiry CHAR(5),
cardCVC VARCHAR(300))");
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
price FLOAT(8,2) NOT NULL,
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
(categoryID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
category VARCHAR(100),
categoryType BOOL NOT NULL)");
$stmt->execute();

// create 2D array of users
$users = [
  ['0', 'jill.wones@aol.com', password_hash("pass", PASSWORD_DEFAULT), 'Jill', 'Wones', '07957159532', 'Laundimer House', 'PE84AP', password_hash("5105105105105100", PASSWORD_DEFAULT), 'MR JILL WONES', '07/25', password_hash("218", PASSWORD_DEFAULT)],
  ['1', 'roris.byabov@yahoo.com', password_hash("pass", PASSWORD_DEFAULT), 'Roris', 'Byabov', '01234567890', 'Home', 'SW1A1AA', password_hash("1234123412341234", PASSWORD_DEFAULT), 'RORIS BYABOV', '08/24', password_hash("123", PASSWORD_DEFAULT)],
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
  ['1', 'OCR Computer Science Algorithms', 'Craig and Dave', 'Computer Science', 'A-Level', 'Contains all of the required algorithms to pass your exams', '1.png', '6.40', '0', '000001', null, null],
  ['2', 'A Promised Land', 'Barack Obama', 'Politics', null, 'Memoir', '2.png', '7.30', '0', '000001', null, null],
  ['3', 'CGP IGCSE Maths', 'CGP', 'Maths', 'GCSE', 'Edexcel IGCSE Maths, 2018', '3.png', '8.20', '1', '000002', '000001', '000001'],
  ['4', 'Quantum Physics For Dummies', 'J. Robert Oppenheimer',  'Physics',  null,  'very little damage, except missing one chapter (ripped out)', '4.png', '11.12', '0', '000002', null, null],
  ['5', 'Maths: The Study Book', 'Richard Parsons',  'Maths',  'KS3',  'Exciting and fun read for the kids!', '5.png', '7.39', '0', '000002', null, null],
  ['6', 'On Anarchism', 'Noam Chomsky',  'Politics',  'Bachelors',  'Very good: A book that doesnt look new and has been read but is in excellent condition. No obvious damage to the cover, with the dust jacket (if applicable) included for hard covers. No missing or damaged pages, no creases or tears and no underlining/highlighting of text or writing in the margins. ', '6.png', '5.40', '0', '000002', null, null],
  ['7', 'Angels In America: Script', 'Tony Kushner',  'Drama',  null,  'Very good book.', '7.png', '13.42', '0', '000002', null, null],
  ['8', 'Mountains and Rivers and Things', 'Aunt Arctica',  'Geography',  'GCSE',  'good condition', '8.png', '10.00', '0', '000001', null, null],
  ['9', 'Introduction to Sociology', 'Andrew F. Parker',  'Sociology',  'A-Level',  'sociology', '9.png', '1.32', '0', '000002', null, null],
  ['10', 'Access 95, A User Guide', 'B. Gates',  'Computer Science',  null,  'Very helpful, recommend!', '10.png', '17.42', '0', '000001', null, null],
  ['11', 'College Physics 76A', null,  'Physics',  'Bachelors',  'boring', null, '9.22', '0', '000002', null, null],
  ['12', 'The Riemann Hypothesis: A Million Dollar Problem', 'by Roland van der Veen',  'Maths',  null,  'medium quality', '12.png', '7.21', '0', '000002', null, null],
  ['13', 'Vindication of the Rights of Woman', 'Mary Woolstonecraft',  'Politics',  null,  'published:1988', '13.png', '15.32', '0', '000001', null, null],
  ['14', 'Arcadia', 'Tom Stoppard',  'Drama',  null,  'poor quality, water damage', '14.png', '4.45', '0', '000002', null, null],
  ['15', 'KS3 Human Geography', null,  'Geography',  'KS3',  'excellent quality', '15.png', '9.10', '0', '000001', null, null],
  ['16', 'The Cambridge Handbook of Social Theory', 'Peter Kivisto',  'Sociology',  'Bachelors',  'good quality', '16.png', '10.11', '0', '000001', null, null],
  ['17', 'Computers: What are they and what do they do?', 'J. Evaristo',  'Computer Science',  'KS3',  'unused', null, '12.45', '0', '000002', null, null],
  ['18', 'CIE Physics (A Level)', 'David Sang, Graham Jones, Gurinder Chadha & Richard Woodside', 'Physics', 'A-Level', 'cie a level physics textbook. little wear. third edition', '18.png', '11.12', '0', '000001', null, null],
  ['19', 'Leviathan', 'Thomas Hobbes',  'Philosophy',  'A-Level',  'poor condition, slight water damage, still readable', '19.png', '12.12', '0', '000001', null, null],
  ['20', 'A Philosophical Enquiry into the Origin of Our Ideas of the Sublime and Beautiful', 'Edmund Burke',  'Philosophy',  null,  'signed first edition', '20.png', '6.50', '0', '000002', null, null],
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
    ['Politics', 1],
    ['Drama', 1],
    ['Geography', 1],
    ['Sociology', 1],
    ['Computer Science', 1],
    ['Philosophy', 1],
    ['GCSE', 0],
    ['KS3', 0],
    ['Bachelors', 0],
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
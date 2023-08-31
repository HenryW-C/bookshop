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
  ['000004', 'Quantum Physics For Dummies', 'J. Robert Oppenheimer',  'Physics',  null,  'very little damage, except missing one chapter (ripped out)', '000004.png', '11.12', '0', '000002', null, null],
  ['000005', 'Maths: The Study Book', 'Richard Parsons',  'Maths',  'KS3',  'Exciting and fun read for the kids!', '000005.png', '7.39', '0', '000002', null, null],
  ['000006', 'On Anarchism', 'Noam Chomsky',  'Politics',  'Bachelors',  'Very good: A book that doesnt look new and has been read but is in excellent condition. No obvious damage to the cover, with the dust jacket (if applicable) included for hard covers. No missing or damaged pages, no creases or tears and no underlining/highlighting of text or writing in the margins. ', '000006.png', '5.40', '0', '000002', null, null],
  ['000007', 'Angels In America: Script', 'Tony Kushner',  'Drama',  null,  'Very good book.', '000007.png', '13.42', '0', '000002', null, null],
  ['000008', 'Mountains and Rivers and Things', 'Aunt Arctica',  'Geography',  'GCSE',  'good condition', '000008.png', '10.00', '0', '000001', null, null],
  ['000009', 'Introduction to Sociology', 'Andrew F. Parker',  'Sociology',  'A-Level',  'sociology', '000009.png', '1.32', '0', '000002', null, null],
  ['000010', 'Access 95, A User Guide', 'B. Gates',  'Computer Science',  null,  'Very helpful, recommend!', '000010.png', '17.42', '0', '000001', null, null],
  ['000011', 'College Physics 76A', null,  'Physics',  'Bachelors',  'boring', null, '9.22', '0', '000002', null, null],
  ['000012', 'The Riemann Hypothesis: A Million Dollar Problem', 'by Roland van der Veen',  'Maths',  null,  'medium quality', '000012.png', '7.21', '0', '000002', null, null],
  ['000013', 'Vindication of the Rights of Woman', 'Mary Woolstonecraft',  'Politics',  null,  'published:1988', '000013.png', '15.32', '0', '000001', null, null],
  ['000014', 'Arcadia', 'Tom Stoppard',  'Drama',  null,  'poor quality, water damage', '000014.png', '4.45', '0', '000002', null, null],
  ['000015', 'KS3 Human Geography', null,  'Geography',  'KS3',  'excellent quality', '000015.png', '9.10', '0', '000001', null, null],
  ['000016', 'The Cambridge Handbook of Social Theory', 'Peter Kivisto',  'Sociology',  'Bachelors',  'good quality', null, '10.11', '0', '000001', null, null],
  ['000017', 'Computers: What are they and what do they do?', 'J. Evaristo',  'Computer Science',  'KS3',  'unused', '000017.png', '12.45', '0', '000002', null, null],
  ['000018', 'CIE Physics (A Level)', 'David Sang, Graham Jones, Gurinder Chadha & Richard Woodside', 'Physics', 'A-Level', 'cie a level physics textbook. little wear. third edition', '000018.png', '11.12', '0', '000001', null, null],
  ['000019', 'Leviathan', 'Thomas Hobbes',  'Philosophy',  'A-Level',  'poor condition, slight water damage, still readable', '000019.png', '12.12', '0', '000001', null, null],
  ['000020', 'A Philosophical Enquiry into the Origin of Our Ideas of the Sublime and Beautiful', 'Edmund Burke',  'Philosophy',  null,  'signed first edition', '000020.png', '6.50', '0', '000002', null, null],
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
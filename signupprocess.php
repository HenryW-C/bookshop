<?php
header('Location: signup.php');
array_map("htmlspecialchars", $_POST);
include_once("connection.php");

$stmt = $conn->prepare("INSERT INTO 
TblUsers (userID,userType,userEmail,userPassword,userForename,userSurname,userTelephone,userAddressLine,userPostcode)
VALUES (null,1,:email,:password,:forename,:surname,:phone,:address,:postcode)");

$hashed_password = password_hash($_POST["passwd"], PASSWORD_DEFAULT);
$stmt->bindParam(':email', $_POST["email"]);
$stmt->bindParam(':password', $hashed_password);
$stmt->bindParam(':forename', $_POST["forename"]);
$stmt->bindParam(':surname', $_POST["surname"]);
$stmt->bindParam(':phone', $_POST["phone"]);
$stmt->bindParam(':address', $_POST["address"]);
$stmt->bindParam(':postcode', $_POST["postcode"]);
$stmt->execute();
$conn=null;
?>
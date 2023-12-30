<?php
include_once("connection.php");
session_start(); 
array_map("htmlspecialchars", $_POST);

// adds the category to the database
$stmt = $conn->prepare("INSERT INTO tblCategories (category, categoryType) VALUES (:category, :categoryType)");
$stmt->bindParam(':category', $_POST['category'], PDO::PARAM_STR);
$stmt->bindParam(':categoryType', $_POST['categoryType'], PDO::PARAM_INT);
$stmt->execute();

// sends the user to the category page
header('Location: categories.php');
?>
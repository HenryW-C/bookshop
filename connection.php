<?php
// setting login variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookshop";

// attempt to connect to the database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // return a success message
    echo "Connected Successfully";
    }
catch(PDOException $e)
    {
    // return an error message if neccesary
    echo "Connection failed: " . $e->getMessage();
    }
?>
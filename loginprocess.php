<?php
session_start(); 
include_once ("connection.php");

// sanitise  $_POST array
array_map("htmlspecialchars", $_POST);

$stmt = $conn->prepare("SELECT * FROM tblusers WHERE userEmail =:email ;" );
$stmt->bindParam(':email', $_POST['Email']);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    { 
        $hashed = $row['Pword'];
        $attempt = $_POST['passwd'];

        if(password_verify($attempt,$hashed)){
            $_SESSION['name']=$row["userEmail"];

            if (!isset($_SESSION['backURL'])){
                $backURL= "/bookshop/homepage.php";

            }else{
                $backURL=$_SESSION['backURL'];
            }
            unset($_SESSION['backURL']);
            echo("ok");
            // header('Location: ' . $backURL);

        }else{
            echo("password wrong");
            // header('Location: login.php');
        }    
    }
echo("no user");
// header('Location: login.php');
?>
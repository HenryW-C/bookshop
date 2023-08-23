<?php 
session_start(); 
include_once ("connection.php");

// sanitise  $_POST array
array_map("htmlspecialchars", $_POST);

// selects all columns from the user's row
$stmt = $conn->prepare("SELECT * FROM tblusers WHERE email =:email ;" );
$stmt->bindParam(':email', $_POST['Email']);
$stmt->execute();

// initiates a while loop that iterates through the rows of the results from executing the prepared statement
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    { 
        $hashed = $row['password']; 
        $attempt = $_POST['Pword'];

        // if password is correct, sets session and redirects, otherwise returns to login
        if(password_verify($attempt,$hashed)){
            if (!isset($_SESSION['backURL'])){
                $backURL= "/bookshop/homepage.php";

            }else{
                $backURL=$_SESSION['backURL'];
            }
            unset($_SESSION['backURL']);
            $_SESSION['Email']=$row["email"];
            header('Location: ' . $backURL);

        }else{
            header('Location: login.php');
        }    
    }
?>
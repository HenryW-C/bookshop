<?php 
session_start(); 
include_once ("connection.php");

// sanitise  $_POST array
array_map("htmlspecialchars", $_POST);

// selects all columns from the user's row
$stmt = $conn->prepare("SELECT * FROM tblusers WHERE email =:email ;" );
$stmt->bindParam(':email', $_POST['Email']);
$stmt->execute();
$results = $stmt->fetchAll();

// checks if there are any results from the executed statement
if($results){
    $stmt->execute();
    // iterates through the rows of the results from the statement
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        $hashed = $row['password']; 
        $attempt = $_POST['Pword'];
            // if password is correct, user is sent to homepage or the page they were on
            if(password_verify($attempt,$hashed)){
                if (!isset($_SESSION['backURL'])){
                    $backURL= "/bookshop/homepage.php";
                }else{
                    $backURL=$_SESSION['backURL'];
                }
                unset($_SESSION['backURL']);
                // session variables are set
                $_SESSION['Email']=$row["email"];
                $_SESSION['UserType']=$row["userType"];
                header('Location: ' . $backURL);
            }else{
                $_SESSION['Message']="Incorrect password, please try again";
                header('Location: login.php');
            }   
    }
}

else{
// if the email does not exist, the user is notified
    $_SESSION['Message']="User does not exist, please try again";
        header('Location: login.php');
}
?>  
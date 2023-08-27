<?php
// start session to send error message back
session_start();

array_map("htmlspecialchars", $_POST);
include_once("connection.php");

$email=$_POST["email"];
$stmt = $conn->prepare("SELECT email FROM tblusers WHERE email = :email;");
$stmt->bindparam('email',$email);
$stmt->execute();

// if the email entered is already in the database
if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    // the user is redirected with an error message
    $_SESSION['Message']="This email is already redistered. Please user another email";
    header('Location: signup.php');
}

// if the email is not already registered, the user is added to the database
else{
    $stmt = $conn->prepare("INSERT INTO 
    TblUsers (userID,userType,email,password,forename,surname,telephone,addressLine,postcode,cardNo,cardName,cardExpiry,cardCVC)
    VALUES (null,0,:email,:password,:forename,:surname,:phone,:address,:postcode,:cardno,:cardname,:cardexpiry,:cardcvc)");

    $hashed_password = password_hash($_POST["passwd"], PASSWORD_DEFAULT);

    $stmt->bindParam(':email', $_POST["email"]);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':forename', $_POST["forename"]);
    $stmt->bindParam(':surname', $_POST["surname"]);
    $stmt->bindParam(':phone', $_POST["phone"]);
    $stmt->bindParam(':address', $_POST["address"]);
    $stmt->bindParam(':postcode', $_POST["postcode"]);
    $stmt->bindParam(':cardno', $_POST["cardno"]);
    $stmt->bindParam(':cardname', $_POST["cardname"]);
    $stmt->bindParam(':cardexpiry', $_POST["cardexpiry"]);
    $stmt->bindParam(':cardcvc', $_POST["cardcvc"]);
    $stmt->execute();
    $conn=null;
    header('Location: signup.php');
}
?>
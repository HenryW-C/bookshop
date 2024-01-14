<?php
// start session to send error message back
session_start();

array_map("htmlspecialchars", $_POST);
include_once("connection.php");

$email=$_POST["email"];
$stmt = $conn->prepare("SELECT email FROM tblUsers WHERE email = :email;");
$stmt->bindparam('email',$email);
$stmt->execute();

// if the email entered is already in the database
if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    // the user is redirected with an error message
    $_SESSION['Message']="This email is already registered. Please user another email";
    header('Location: newadmin.php');
}

// ensures password is longer than 8 characters
else if(strlen($_POST["passwd"])<8){
    $_SESSION['Message']="Password must be at least 8 characters long";
    header('Location: signup.php');
}

// ensures password contains at least one number
else if(!preg_match("#[0-9]+#",$_POST["passwd"])){
    $_SESSION['Message']="Password must contain at least one number";
    header('Location: signup.php');
}

// ensures card number is 16 digits
else if(strlen($_POST["cardno"])!=16){
    $_SESSION['Message']="Card number must be 16 digits";
    header('Location: signup.php');
}

// ensures card CVC is 3 digits
else if(strlen($_POST["cardcvc"])!=3){
    $_SESSION['Message']="Card CVC must be 3 digits";
    header('Location: signup.php');
}

// ensures expiry data is in correct format
else if(!preg_match("/^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$/",$_POST["cardexpiry"])){
    $_SESSION['Message']="Card expiry date must be in the format MM/YY";
    header('Location: signup.php');
}

// if the email is not already registered, the user is added to the database
else{
    $stmt = $conn->prepare("INSERT INTO 
    tblUsers (userID,userType,email,password,forename,surname,telephone,addressLine,postcode,cardNo,cardName,cardExpiry,cardCVC)
    VALUES (null,1,:email,:password,:forename,:surname,:phone,:address,:postcode,:cardno,:cardname,:cardexpiry,:cardcvc)");

    $hashed_password = password_hash($_POST["passwd"], PASSWORD_DEFAULT);
    $hashed_cardno = password_hash($_POST["cardno"], PASSWORD_DEFAULT);
    $hashed_cardcvc = password_hash($_POST["cardcvc"], PASSWORD_DEFAULT);

    $stmt->bindParam(':email', $_POST["email"]);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':forename', $_POST["forename"]);
    $stmt->bindParam(':surname', $_POST["surname"]);
    $stmt->bindParam(':phone', $_POST["phone"]);
    $stmt->bindParam(':address', $_POST["address"]);
    $stmt->bindParam(':postcode', $_POST["postcode"]);
    $stmt->bindParam(':cardno', $hashed_cardno);
    $stmt->bindParam(':cardname', $_POST["cardname"]);
    $stmt->bindParam(':cardexpiry', $_POST["cardexpiry"]);
    $stmt->bindParam(':cardcvc', $hashed_cardcvc);
    $stmt->execute();
    $conn=null;
    header('Location: admin_account.php');
}
?>
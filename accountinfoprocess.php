<?php
// start session to send error message back
session_start();

array_map("htmlspecialchars", $_POST);
include_once("connection.php");

$email=$_POST["email"];
$stmt = $conn->prepare("SELECT email FROM tblUsers WHERE email = :email AND userID != :userID;");
$stmt->bindparam(':email',$email);
$stmt->bindparam(':userID',$_SESSION['UserID']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// if the email entered is already in the database
if($result){
    // the user is redirected with an error message
    $_SESSION['Message']="This email is already registered. Please user another email";
    header('Location: accountinfo.php');
}

// if new password is entered and current is not
elseif (!empty($_POST['newpass']) && empty($_POST["currentpass"])){
    // the user is redirected with an error message
    $_SESSION['Message']="Please enter the current password to make a change";
    header('Location: accountinfo.php');
}

// if new card number is entered, it must be 16 digits
elseif (!empty($_POST['cardno']) && strlen($_POST['cardno']) != 16){
    // the user is redirected with an error message
    $_SESSION['Message']="Please enter a valid card number";
    header('Location: accountinfo.php');
}

// if new cvc is entered, it must be 3 digits
elseif (!empty($_POST['cardCVC']) && strlen($_POST['cardCVC']) != 3){
    // the user is redirected with an error message
    $_SESSION['Message']="Please enter a valid card CVC";
    header('Location: accountinfo.php');
}

// if a new password is entered, it must be 8 charcaters or more and contain a number
elseif (!empty($_POST['newpass']) && strlen($_POST['newpass']) < 8 && !preg_match("#[0-9]+#", $_POST['newpass'])){
    // the user is redirected with an error message
    $_SESSION['Message']="Please enter a valid password, it must have at least 8 characters and a number";
    header('Location: accountinfo.php');
}

// the card expiry date must be in the correct format
elseif (!empty($_POST['cardexpiry']) && !preg_match("/^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$/", $_POST['cardexpiry'])){
    // the user is redirected with an error message
    $_SESSION['Message']="Please enter a valid card expiry date";
    header('Location: accountinfo.php');
}

// if the email is not already registered, the user's details are updated
else{
    // updates the main details
        $stmt = $conn->prepare("UPDATE tblUsers 
        SET email=:email, forename=:forename, surname=:surname, telephone=:phone, addressLine=:address, 
        postcode=:postcode, cardName=:cardname, cardExpiry=:cardexpiry
        WHERE userID=:userID");
        $stmt->bindParam(':email', $_POST["email"]);
        $stmt->bindParam(':forename', $_POST["forename"]);
        $stmt->bindParam(':surname', $_POST["surname"]);
        $stmt->bindParam(':phone', $_POST["phone"]);
        $stmt->bindParam(':address', $_POST["address"]);
        $stmt->bindParam(':postcode', $_POST["postcode"]);
        $stmt->bindParam(':cardname', $_POST["cardname"]);
        $stmt->bindParam(':cardexpiry', $_POST["cardexpiry"]);
        $stmt->bindParam(':userID', $_SESSION["UserID"]);
        $stmt->execute();

    // updates the password, if one has been entered
        if (!empty($_POST['newpass'])){
            // selects curent password from the user's row
            $stmt = $conn->prepare("SELECT * FROM tblUsers WHERE userID =:userID");
            $stmt->bindParam(':userID', $_SESSION['UserID'], PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $hashed = $result['password'];
            $attempt = $_POST['currentpass'];
            var_dump($hashed);
            echo('<br>');
            var_dump($attempt);
            // if passwords match, it is updated
            if(password_verify($attempt,$hashed)){
                $stmt = $conn->prepare("UPDATE tblUsers 
                SET password=:newPasswordHashed
                WHERE userID=:userID");

                $new_hashed_password = password_hash($_POST["newpass"], PASSWORD_DEFAULT);
                $stmt->bindParam(':newPasswordHashed', $new_hashed_password);
                $stmt->bindParam(':userID', $_SESSION["UserID"]);
                $stmt->execute();
            }
            // if they don't match, the user is told
            else {
                $_SESSION['Message']="Incorrect password entered, please try again";
                header('Location: accountinfo.php');
            }
        }
    
    // updates the card number, if one has been entered
        if (!empty($_POST['cardno'])){
            $stmt = $conn->prepare("UPDATE tblUsers 
            SET cardNo=:cardno
            WHERE userID=:userID");
            $stmt->bindParam(':cardno', password_hash($_POST["cardno"], PASSWORD_DEFAULT));
            $stmt->bindParam(':userID', $_SESSION["UserID"]);
            $stmt->execute();
        }
    // updates the cardCVC, if one has been entered
        if (!empty($_POST['cardCVC'])){
            $stmt = $conn->prepare("UPDATE tblUsers 
            SET cardCVC=:cardcvc
            WHERE userID=:userID");
            $stmt->bindParam(':cardcvc', password_hash($_POST["cardCVC"], PASSWORD_DEFAULT));
            $stmt->bindParam(':userID', $_SESSION["UserID"]);
            $stmt->execute();
        }
    
    
    $conn=null;

    header('Location: accountinfo.php');
}
?>
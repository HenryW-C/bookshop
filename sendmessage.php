<?php
// start session

try{
    session_start();

    array_map("htmlspecialchars", $_POST);
    include_once("connection.php");

    // sets the backURl and date
    $backURL = $_SESSION['backURL'];
    date_default_timezone_set('Europe/London');
    $date = date("Y-m-d H:i:s");

    // adds the message to the database
    $stmt = $conn->prepare("INSERT INTO 
    TblMessages (messageID,senderUserID,recieveUserID,sendDate,content)
    VALUES (null,:sendUserID,:recieveUserID,:sendDate,:content)");

    $stmt->bindParam(':sendUserID', $_SESSION["UserID"]);
    $stmt->bindParam(':recieveUserID', $_POST["recipient"]);
    $stmt->bindParam(':sendDate', $date);
    $stmt->bindParam(':content', $_POST["message"]);
    $stmt->execute();

    // sends the user back to the account page
    header('Location: ' . $backURL);

exit();
}
catch(PDOException $e)
{
    echo "error".$e->getMessage();
}
$conn=null;
?>
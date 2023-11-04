<?php
array_map("htmlspecialchars", $_POST);
include_once("connection.php");

$stmt = $conn->prepare("INSERT INTO 
  TblBooks (bookID, name, author, subject, level, description, image, price, sold, sellerID, buyerID, orderID)
  VALUES (null, :name, :author, :subject, :level, :description, null, :price, 0, :userID, null, null)");

  $stmt->bindParam(':name', $_POST["name"]);
  $stmt->bindParam(':author', $author);
  $stmt->bindParam(':subject', $subject);
  $stmt->bindParam(':level', $level);
  $stmt->bindParam(':description', $_POST["description"]);
  $stmt->bindParam(':price', $_POST["price"]);
  $stmt->bindParam(':userID', $_SESSION['UserID']);
  $stmt->execute();

if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === 0) {
  // if an image was uploaded, specifies the filename for the image
  $filename = ($conn->lastInsertId()).'.png';

  $target_dir = "/Applications/XAMPP/htdocs/bookshop/images/";
  $target_file = $target_dir . $filename . "." . strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "The file " . htmlspecialchars($filename) . " has been uploaded.";
      header('Location: ' . $backURL);
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }

  // tblBooks is updated to list the new file name
  $stmt = $conn->prepare("UPDATE tblBooks SET image=:imageName WHERE bookID=:bookID");
  $stmt->bindParam(':imageName', $filename);
  $stmt->bindParam(':bookID', $conn->lastInsertId());
  $stmt->execute();
  $conn=null;
}
?>
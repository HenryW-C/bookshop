<?php

print_r($_POST);

// $target_dir = "/Applications/XAMPP/htdocs/bookshop/images/";

// // specify the desired filename for the uploaded file
// $filename = "test_filename";

// $target_file = $target_dir . $filename . "." . strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
// $uploadOk = 1;
// $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// // check if file already exists
// if (file_exists($target_file)) {
//   echo "Sorry, file already exists.";
//   $uploadOk = 0;
// }

// // check file size
// if ($_FILES["fileToUpload"]["size"] > 500000) {
//   echo "Sorry, your file is too large.";
//   $uploadOk = 0;
// }

// // check if $uploadOk is set to 0 by an error
// if ($uploadOk == 0) {
//   echo "Sorry, your file was not uploaded.";
// } else {
//   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//     echo "The file ". htmlspecialchars($filename) . " has been uploaded.";
//     header('Location: ' . $backURL);
//   } else {
//     echo "Sorry, there was an error uploading your file.";
//   }
// }
    
// if(isset($_POST['description'])) {
//       $description = $_POST['description'];
//       echo "Description: $description<br>";
//   } 

// if(isset($_POST['selectedLevel'])) {
//     $selectedLevel = $_POST['selectedLevel'];
//     echo "Selected Level: $selectedLevel<br>";
// } 

// if(isset($_POST['selectedSubject'])) {
//     $selectedSubject = $_POST['selectedSubject'];
//     echo "Selected Subject: $selectedSubject<br>";
// } 
?>
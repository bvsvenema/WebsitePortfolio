<?php
session_start();
// Change this to your connection info.
include "../router/db.inc.php";

$target_dir = "../uploads/".$_POST['projectname']."-Project/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file2 = basename($_FILES["projectimage"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_dir)) {
    echo "Sorry, folder name already exists.";
    $uploadOk = 0;
    exit;
}

  // Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
    exit;
}

  // Allow certain file formats
if($imageFileType != "zip" && $imageFileType != "rar") {
  echo "Sorry, only zip or rar,";
  $uploadOk = 0;
  exit;
}

if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg"){
    echo "sorry, only jpg, png or jpeg";
    $uploadOk = 0;
    exit;
} 

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    $uniqId = uniqid();
    if($stmt = $con2->prepare('SELECT id, filename FROM projects WHERE projectname = ?')){
    $stmt->bind_param('s', $_POST['projectname']);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
      echo "Sorry, Project name already exist";
    }else{
      if($stmt = $con2->prepare("INSERT INTO `projects` (`projectname`, `filename`, `picturename`, `catagory`, `headlanguage`, `client`, `url`) VALUES (?,?,?,?,?,?,?)")){
        $fileName = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
        $picturename = $uniqId . $target_file2;
        $stmt->bind_param('sssssss', $_POST['projectname'], $fileName, $picturename, $_POST['category'], $_POST['headlanguage'], $_POST['client'], $_POST['url']);
        $stmt->execute();
        
      }else{
        echo"Could not prepare statement!";
        exit;
      }
    }
    $stmt->close();
  } else {
    // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
    echo"Could not prepare statement!";
    exit;
  }
    if(mkdir("../uploads/".$_POST['projectname'].'-Project')){
      echo'made a folder';
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) && move_uploaded_file($_FILES["projectimage"]["tmp_name"], $target_dir . $uniqId . $target_file2)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " with the name ". $_POST['projectname'] ." has been uploaded. with the picuter " .htmlspecialchars( basename( $_FILES["projectimage"]["name"]));
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }else{
      echo "Sorry, Couldnt make file folder";
    }
   
  }
  CloseConnection($con, $con2);


  ?>

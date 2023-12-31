<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Change this to your connection info.
include "../router/db.inc.php";

$target_dir = "../uploads/".$_POST['projectname']."-Project/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file2 = basename($_FILES["projectimage"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
$sql = "CREATE TABLE `_{$_POST['projectname']}-ProjectPictures` (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  projectID INT(11) NOT NULL,
  projectName VARCHAR(50) NOT NULL,
  picturePath VARCHAR(255) NOT NULL
)";
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    errorMessage("File is an image - " . $check["mime"] . ".", false);
    $uploadOk = 1;
  } else {
    errorMessage("File is not an image.", false);
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_dir)) {
    errorMessage("Sorry, folder name already exists.", "upload-page.php" , false);
    $uploadOk = 0;
    exit;
}

  // Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000000) {
  errorMessage("Sorry, your file is too large.", "upload-page.php" , false);
    $uploadOk = 0;
    exit;
}

  // Allow certain file formats
if($imageFileType != "zip" && $imageFileType != "rar") {
  errorMessage("Sorry, only zip or rar,", "upload-page.php" , false);
  $uploadOk = 0;
  exit;
}

if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg"){
  errorMessage("sorry, only jpg, png or jpeg", "upload-page.php" , false);
    $uploadOk = 0;
    exit;
} 

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  errorMessage("Sorry, your file was not uploaded.", "upload-page.php" , false);
  // if everything is ok, try to upload file
  } else {
    $uniqId = uniqid();
    if($stmt = $con2->prepare('SELECT id, filename FROM projects WHERE projectname = ?')){
    $stmt->bind_param('s', $_POST['projectname']);
    $stmt->execute();
    $stmt->store_result();
      echo "IDK";
    if($stmt->num_rows < 0){
      errorMessage("Sorry, Project name already exist", "upload-page.php" , false);
      exit;
    }else{
      if($con2->query($sql) === true){
      }else{
        errorMessage("Couldn't create table", "upload-page.php" , false);
        exit;
      }

      if($stmt = $con2->prepare("INSERT INTO projects (`projectname`, `filename`, `picturename`, `catagory`, `headlanguage`, `startdate`, `finishdate`, `client`, `url`, `information`, `tablename`) VALUES (?,?,?,?,?,?,?,?,?,?,?)")){
        $fileName = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
        $picturename = $uniqId . $target_file2;      
        $tablename = "_{$_POST['projectname']}-ProjectPictures";
        $startDate = $_POST['startdate'];
        $finishDate = $_POST['finishdate'];
        if($_POST['startdate'] == "")
          $startDate = null;
        if($_POST['finishdate'] == "")
          $finishDate = null;
        $stmt->bind_param('sssssssssss', $_POST['projectname'], $fileName, $picturename, $_POST['category'], $_POST['headlanguage'], $startDate, $finishDate, $_POST['client'], $_POST['url'], $_POST['information'], $tablename);
        $stmt->execute();
      }else{
        errorMessage("Could not prepare statement!", "upload-page.php" , false);
        exit;
      }
    }
    $stmt->close();
  } else {
    // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
    errorMessage("Could not prepare statement!", false);
    exit;
  }


    if(mkdir(__DIR__ ."/../uploads/".$_POST['projectname'].'-Project', 0777, true)){
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
        if(move_uploaded_file($_FILES["projectimage"]["tmp_name"], $target_dir . $uniqId . $target_file2)){
          errorMessage('<strong>'.$_POST['projectname']."</strong> has been uploaded with the file: <strong>" .htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]))."'</strong>' and with the picture: <strong>".htmlspecialchars( basename( $_FILES["projectimage"]["name"])).'</strong>',  "upload-page.php" ,true);
        }else{
          errorMessage("Sorry, there was an error uploading your image file.", "upload-page.php" ,false);
        }
      }else {
        errorMessage("Sorry, there was an error uploading your zip file.",  "upload-page.php" , false);
      }
    }else{
      errorMessage("Sorry, Couldnt make file folder", false);
    }

    
   
  }


  CloseConnection($con, $con2);
  ?>

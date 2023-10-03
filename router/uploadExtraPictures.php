<?php 
session_start();
// Change this to your connection info.
include "../router/db.inc.php";

$getData = $con2->query("SELECT * FROM projects WHERE id = ".$_POST['id']);
$Data = $getOldData->fetch_assoc();

$target_dir = "../uploads/".$Data['projectname']."-Project/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

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

if ($_FILES["fileToUpload"]["size"] > 5000) {
    errorMessage("Sorry, your file is too large.", false);
      $uploadOk = 0;
      exit;
  }

  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
    errorMessage("sorry, only jpg, png or jpeg", false);
      $uploadOk = 0;
      exit;
  } 

  // Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    errorMessage("Sorry, your file was not uploaded.", false);
    // if everything is ok, try to upload file
    } else {
      $uniqId = uniqid();
      if($stmt = $con2->prepare('SELECT id, filename FROM projects WHERE projectname = ?')){
      $stmt->bind_param('s', $_POST['projectname']);
      $stmt->execute();
      $stmt->store_result();
  
      if($stmt->num_rows > 0){
        errorMessage("Sorry, Project name already exist", false);
      }else{
        if($con2->query($sql) === true){
        }else{
          errorMessage("Couldn't create table", false);
          exit;
        }
  
        if($stmt = $con2->prepare("INSERT INTO `projects` (`projectname`, `filename`, `picturename`, `catagory`, `headlanguage`, `startdate`, `finishdate`, `client`, `url`, `information`, `table`) VALUES (?,?,?,?,?,?,?,?,?,?,?)")){
          $fileName = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
          $picturename = $uniqId . $target_file2;      
          $tablename = "_{$_POST['projectname']}-ProjectPictures";
          $stmt->bind_param('sssssssssss', $_POST['projectname'], $fileName, $picturename, $_POST['category'], $_POST['headlanguage'], $_POST['startdate'], $_POST['finishdate'], $_POST['client'], $_POST['url'], $_POST['information'], $tablename);
          $stmt->execute();
          
        }else{
          errorMessage("Could not prepare statement!", false);
          exit;
        }
      }
      $stmt->close();
    } else {
      // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
      errorMessage("Could not prepare statement!", false);
      exit;
    }
      if(mkdir("../uploads/".$_POST['projectname'].'-Project')){
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) && move_uploaded_file($_FILES["projectimage"]["tmp_name"], $target_dir . $uniqId . $target_file2)) {
          errorMessage('<strong>'.$_POST['projectname']."</strong> has been uploaded with the file: <strong>" .htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]))."'</strong>' and with the picture: <strong>".htmlspecialchars( basename( $_FILES["projectimage"]["name"])).'</strong>',true);
          
        } else {
          errorMessage("Sorry, there was an error uploading your file.", false);
        }
      }else{
        errorMessage("Sorry, Couldnt make file folder", false);
      }
  
      
     
    }
?>
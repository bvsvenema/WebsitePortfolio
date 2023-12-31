<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../router/db.inc.php";

$getOldData = $con2->query("SELECT * FROM projects WHERE id = ".$_POST['id']);
$oldData = $getOldData->fetch_assoc();

$target_dir = "../uploads/".$_POST['projectname']."-Project/";
$uploadOk = 1;
$sql = "UPDATE projects SET projectname=?, catagory=?, headlanguage=?, client=?, startdate=?, finishdate=?,url=?, tablename=?  WHERE id=?";
//$sql = "INSERT INTO `projects`(`projectname`,`catagory`, `headlanguage`, `client`, `startdate`, `finishdate`, `url`, `table`) VALUES (?,?,?,?,?,?,?,?) WHERE id=?";
$TableSql = "ALTER TABLE `_{$oldData['projectname']}-ProjectPictures` RENAME TO `_{$_POST['projectname']}-ProjectPictures`";
$bindparamint = 0;



echo"Old projectname is= ".$oldData['projectname']. ", ";

//get all the information of the current data
if($stmt = $con2->prepare('SELECT id FROM projects WHERE id = ?')){
    $stmt->bind_param('s', $_POST['id']);
    $stmt->execute();
    $stmt->store_result();
    //echo'data'.$stmt['id'];
}else{
    echo 'couldnt prepare statement';
}

//check if there has been a file in the input
if(basename($_FILES["fileToUpload"]["name"]) != null){
    echo 'File is not null, ';
    unlink('../uploads/'.$_POST['projectname'].'-Project/'.$oldData['filename']);
    echo 'old file deleted:'.$oldData['filename'].', ';
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $sql = "UPDATE projects SET projectname=?, filename=? ,catagory=?, headlanguage=?, client=?, startdate=?, finishdate=? , url=?, tablename=? WHERE id=?";
    $bindparamint = 1;
    
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
}else{
    echo'there is no files uploaded, ';
}

if(basename($_FILES["projectimage"]["name"] != null)){
    echo'image is not null ';
    unlink('../uploads/'.$_POST['projectname'].'-Project/'.$oldData['picturename']);
    echo 'old file deleted:'.$oldData['picturename'].', ';
    $target_file2 = basename($_FILES["projectimage"]["name"]);
    $imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
    $sql = "UPDATE projects SET projectname=?, picturename=? ,catagory=?, headlanguage=?, client=?, startdate=?, finishdate=?, url=?, tablename=? WHERE id=?";
    $bindparamint = 2;
   

    if($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg"){
        echo "sorry, only jpg, png or jpeg";
        $uploadOk = 0;
        exit;
    } 
}else{
    echo'there is no picture uploaded, ';
}
echo"Test";
if(basename($_FILES["projectimage"]["name"]) != null && basename($_FILES["fileToUpload"]["name"]) != null){
    //echo'both files are not null, ';
    $sql = "UPDATE projects SET projectname=?, filename=?, picturename=? ,catagory=?, headlanguage=?, client=?, startdate=?, finishdate=?, url=?, tablename=? WHERE id=?";
    $bindparamint = 3;
}
echo "test";
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    $uniqId = uniqid();
    echo "!@#EADWQADWADA,            " . $bindparamint;
    if($stmt->num_rows < 0){
      echo "Sorry, Project id doesn't exist";
    }else{
        echo $sql;
      if($stmt = $con2->prepare($sql)){
        echo"its working, ";
        echo "bindparamint = ".$bindparamint;
        if(basename($_FILES["fileToUpload"]["name"]) != null)
        $fileName = htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
        if(basename($_FILES["projectimage"]["name"]) != null)
        $picturename = $uniqId . $target_file2;
        $tablename = "_{$_POST['projectname']}-ProjectPictures";
        $startDate = $_POST['startdate'];
        $finishDate = $_POST['finishdate'];
        if($_POST['startdate'] == "")
          $startDate = null;
        if($_POST['finishdate'] == "")
          $finishDate = null;
        switch($bindparamint){
            case 0:
                $stmt->bind_param('ssssssssi', $_POST['projectname'], $_POST['category'], $_POST['headlanguage'], $_POST['client'], $startDate, $finishDate, $_POST['url'], $tablename ,$_POST['id']);
                break;
            case 1:
                $stmt->bind_param('sssssssssi', $_POST['projectname'], $fileName, $_POST['category'], $_POST['headlanguage'], $_POST['client'], $startDate, $finishDate, $_POST['url'], $tablename , $_POST['id']);
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                break;
            case 2:
                $stmt->bind_param('sssssssssi', $_POST['projectname'], $picturename, $_POST['category'], $_POST['headlanguage'], $_POST['client'], $startDate, $finishDate, $_POST['url'], $tablename , $_POST['id']);
                move_uploaded_file($_FILES["projectimage"]["tmp_name"], $target_dir . $uniqId . $target_file2);
                break;
            case 3:
                $stmt->bind_param('ssssssssssi', $_POST['projectname'], $fileName, $picturename, $_POST['category'], $_POST['headlanguage'], $_POST['client'], $startDate, $finishDate, $tablename , $_POST['url'], $_POST['id']);
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                move_uploaded_file($_FILES["projectimage"]["tmp_name"], $target_dir . $uniqId . $target_file2);
                break;
        }
        rename("../uploads/".$oldData['projectname'].'-Project', "../uploads/".$_POST['projectname'].'-Project');
        if($con2->query($TableSql) === true){
            echo "Renamed Table";
        }else{
            echo "Couldnt Rename Table";
        }
        $bindparamsql;
        $stmt->execute();
        
      }else{
        echo"Could not prepare statement aaaaaaaaa!";
        exit;
      }
    }
    $stmt->close();
  }
  CloseConnection($con, $con2);


?>
<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../router/db.inc.php";
  if(isset($_GET['project_id'])){
    $project_id = $_GET['project_id'];
    $sql = "DELETE FROM projects WHERE id=$project_id";

    $get_project = $con2->query("SELECT * FROM projects WHERE id = $project_id");
    $project_data = $get_project->fetch_assoc();
    $sqlTable = "DROP TABLE `_{$project_data['projectname']}-ProjectPictures`";
    $dir = "../uploads/".$project_data['projectname']."-Project";
  
  if($con2->query($sql) === true){
    if(removeFiles($dir)){
      errorMessage("Something went wrong with deleting files", "admin-project.php" ,false);
    }else{
      if($con2->query($sqlTable)){
      errorMessage("Delete files and project with the name: ".$project_data['projectname'],"admin-project.php" , true);
      }else{
        errorMessage("Something went wrong with deleting Table","admin-project.php" , false);
      }
    }
  }else{
    errorMessage('Something went wrong with deleting querry',"admin-project.php" , false);
  }

}else{
  errorMessage('Couldnt find project', "admin-project.php" , false);
}


function removeFiles($filepath){
  $files = glob($filepath . "/*");
  foreach($files as $file){
    if(is_file($file)){
      unlink($file);
    }
  }
  rmdir($filepath);
}
CloseConnection($con, $con2);
?>
<?php
session_start();
include "../router/db.inc.php";
  if(isset($_GET['project_id'])){
    $project_id = $_GET['project_id'];
    $sql = "DELETE FROM projects WHERE id=$project_id";

    $get_project = $con2->query("SELECT * FROM projects WHERE id = $project_id");
    $project_data = $get_project->fetch_assoc();
    $sqlTable = "DROP TABLE `_{$project_data['projectname']}-projectpictures`";
    $dir = "../uploads/".$project_data['projectname']."-Project";
  
  if($con2->query($sql) === true){
    if(removeFiles($dir)){
      errorMessage("Something went wrong with deleting files", false);
    }else{
      if($con2->query($sqlTable)){
      errorMessage("Delete files and project with the name: ".$project_data['projectname'], true);
      }else{
        errorMessage("Something went wrong with deleting Table", false);
      }
    }
  }else{
    errorMessage('Something went wrong with deleting querry', false);
  }

}else{
  errorMessage('Couldnt find project', false);
}

function errorMessage($Msg, bool $error_or_succes){
  if($error_or_succes == false){
    $_SESSION['delete_error_msg'] = "$Msg";
    header("Location: ../views/admin-project.php");
    exit;
  }
  $_SESSION['delete_succes_msg'] = "$Msg";
  header("Location: ../views/admin-project.php");
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
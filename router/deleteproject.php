<?php
include "../router/db.inc.php";
session_start();
  if(isset($_GET['project_id'])){

    $project_id = $_GET['project_id'];
    $sql = "DELETE FROM projects WHERE id=$project_id";
    $get_project = $con2->query("SELECT * FROM projects WHERE id = $project_id");
    $project_data = $get_project->fetch_assoc();
    $deletefile = unlink("../uploads/".$project_data['projectname']."-Project/".$project_data['filename']);
    $deletepicture = unlink("../uploads/".$project_data['projectname']."-Project/".$project_data['picturename']);
    if($con2->query($sql) === true){

        if($deletefile)
        {
            echo 'Deleted file '.$project_data['filename'].", ";
        }else{
            echo "something went wrong with deleting the file";
        }
        if($deletepicture){
            echo 'Deleted file '.$project_data['picturename'].", ";
            rmdir("../uploads/".$project_data['projectname']."-Project");
        }else{
            echo "something went wrong with deleting the picutre";
        }
        echo'Deleted files from database';
    }else{
        echo'something went wrong with deleting the data from database';
    }
  }else{
    echo 'something went wrong';
  }
?>
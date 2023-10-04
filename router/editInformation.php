<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../router/db.inc.php';

$sql = "UPDATE projects SET information=? WHERE id=?";

$getOldData = $con2->query("SELECT * FROM projects WHERE id = ".$_POST['id']);
$oldData = $getOldData->fetch_assoc();

if($stmt = $con2->prepare($sql)){
    $stmt->bind_param('si', $_POST['information'], $_POST['id']);
    $stmt->execute();
    $stmt->close();
    errorMessage("Information has been updated", "admin-portfolio.php?project_id=".$_POST['id'] ,true);
}else{
    errorMessage("something went wrong with uploading the information", "admin-portfolio.php?project_id=".$_POST['id'], false);
}
CloseConnection($con, $con2);


?>
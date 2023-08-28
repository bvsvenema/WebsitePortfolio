<?php
session_start();
include '../router/db.inc.php';

$sql = "UPDATE projects SET information=? WHERE id=?";

$getOldData = $con2->query("SELECT * FROM projects WHERE id = ".$_POST['id']);
$oldData = $getOldData->fetch_assoc();

if($stmt = $con2->prepare($sql)){
    $stmt->bind_param('si', $_POST['information'], $_POST['id']);
    $stmt->execute();
    $stmt->close();
}
CloseConnection($con, $con2);
?>
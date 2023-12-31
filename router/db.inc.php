<?php
require (__DIR__) . "/../vendor/autoload.php";

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(dirname(__DIR__ . "/../."));
$dotenv->load();

$DATABASE_HOST = $_ENV['DATABASE_HOST'];
$DATABASE_USER = $_ENV['DATABASE_USER'];
$DATABASE_PASS = $_ENV['DATABASE_PASS'];
$DATABASE_NAME = 'phplogin';
$DATABASE_NAME2 = 'myprojects';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	errorMessage("Sorry,Failed to connect to MySQL: " .mysqli_connect_error(), false);
	exit();
}

$con2 = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME2);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	errorMessage("Sorry,Failed to connect to MySQL: " .mysqli_connect_error(), false);
	exit();
}

function CloseConnection($con, $con2) {
	$con->close();
  	$con2->close();
}

function errorMessage($Msg, $header , bool $error_or_succes){
    if($error_or_succes == false){
      $_SESSION['error_msg'] = "$Msg";
      header("Location: ../views/".$header);
      exit;
    }
    $_SESSION['succes_msg'] = "$Msg";
    header("Location: ../views/".$header);
  }

?>
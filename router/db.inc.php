<?php
require_once "./vendor/autoload.php";

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(dirname("."));
$dotenv->load();

function ConnectDB($DATABASE_NAME){

	$DATABASE_HOST = $_ENV['DATABASE_HOST'];
	$DATABASE_USER = $_ENV['DATABASE_USER'];
	$DATABASE_PASS = $_ENV['DATABASE_PASS'];
	$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	if (mysqli_connect_errno()) {
		// If there is an error with the connection, stop the script and display the error.
		errorMessage("Sorry,Failed to connect to MySQL: " .mysqli_connect_error(), false);
		exit();
	}
}
<?php
session_start();
// Change this to your connection info.
include "../router/db.inc.php";
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	errorMessage("Sorry,Failed to connect to MySQL: " .mysqli_connect_error(), false);
	exit();
}

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	errorMessage("Please complete the registration form!", false);
	exit();
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	errorMessage("Please complete the registration form!", false);
	exit();
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	errorMessage("Sorry, Email is not valid!", false);
	exit();
}

if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
	errorMessage("Sorry, Username is not valid!", false);
	exit();
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	errorMessage("Sorry, Password must be between 5 and 20 characters long!", false);
	exit();
}

// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		errorMessage("Sorry, Username exists, please choose another!", false);
	} else {
		// Username doesn't exists, insert new account
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
	    // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
	        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	        $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
	        $stmt->execute();
			errorMessage("You have successfully registered! You can now login", true);
        } else {
	        // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
			errorMessage("Could not prepare statement!", false);
        }       
	}
	$stmt->close();
} else {
	// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
	errorMessage("Could not prepare statement!", false);
}
CloseConnection($con, $con2);

//error is false, succes is true
function errorMessage($Msg, bool $error_or_succes){
	if($error_or_succes == false){
		$_SESSION['login_error_msg'] = "$Msg";
		header("Location: ../views/register-page.php");
		exit;
	}
	$_SESSION['login_succes_msg'] = "$Msg";
	header("Location: ../views/register-page.php");
}
?>
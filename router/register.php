<?php
session_start();
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	errorMessage("Sorry,Failed to connect to MySQL: " .mysqli_connect_error());
	exit();
}

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	errorMessage("Please complete the registration form!");
	exit();
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	errorMessage("lease complete the registration form!");
	exit();
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	errorMessage("Sorry, Email is not valid!");
	exit();
}

if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
	errorMessage("Sorry, Username is not valid!");
	exit();
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	errorMessage("Sorry, Password must be between 5 and 20 characters long!");
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
		errorMessage("Sorry, Username exists, please choose another!");
	} else {
		// Username doesn't exists, insert new account
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
	    // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
	        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	        $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
	        $stmt->execute();
			$_SESSION['login_succes_msg'] = "You have successfully registered! You can now login!";
			header("Location: ../views/register-page.php");
        } else {
	        // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
			errorMessage("Could not prepare statement!");
        }       
	}
	$stmt->close();
} else {
	// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
	errorMessage("Could not prepare statement!");
}
$con->close();

function errorMessage($errorMsg){
	$_SESSION['login_error_msg'] = "$errorMsg";
	header("Location: ../views/register-page.php");
}
?>
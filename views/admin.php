<?php
// We need to use sessions, so you should always start sessions using the below code.
// If the user is not logged in redirect to the login page...
include "../router/inactivityLogout.php"
?>

<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="refresh" content="9001">
		<meta charset="utf-8">
		<title>Admin Page || Portofolio</title>
		<link href="../assets/css/styleAdmin.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Admin Page</h1>
				<a href="admin-project.php"><i class="fas fa-project-diagram"></i>projects</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="upload-page.php"><i class="fas fa-upload"></i>Upload</a>
				<a href="register-page.php"><i class="fas fa-registered"></i>Register</a>
				<a href="../router/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>	
		</div>
	</body>
</html>
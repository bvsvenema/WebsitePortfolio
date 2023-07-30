<!DOCTYPE html>
<?php session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../admin-login.html');
	exit;
}
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Register</title>
		<link href="../assets/css/styleAdmin.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body>
		<div class="register">
			<h1>Register</h1>
			<h2></h2>
			<form action="../router/register.php" method="post" autocomplete="off">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="email" name="email" placeholder="Email" id="email" required>
				<?php
					if(!empty($_SESSION['login_error_msg']))
					{
						echo"<h2>".$_SESSION['login_error_msg'],"</h2>";
						unset($_SESSION['login_error_msg']);
					}
					if(!empty($_SESSION['login_succes_msg']))
					{
						echo"<h3>".$_SESSION['login_succes_msg'],"</h3>";
						unset($_SESSION['login_succes_msg']);
					}
				?>
				<input type="submit" value="Register">
			</form>
		</div>
	</body>
</html>
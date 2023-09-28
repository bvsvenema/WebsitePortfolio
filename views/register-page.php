<!DOCTYPE html>
<?php
include "../router/inactivityLogout.php";
?>

<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="refresh" content="9001">
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="../assets/css/styleAdmin.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body class="loggedin">

		<nav class="navtop">
			<div>
				<h1>Admin Page</h1>
				<a href="../views/admin.php"><i class="fas fa-house"></i>Home</a>
				<a href="../router/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Register</h2>
			<div class="text-center">
				<p>Register acount below:</p>
			<form action="../router/register.php" method="post" autocomplete="off">
			<br>
						<label for="username">
							<i class="fas fa-user"></i>
						</label>
						<input type="text" name="username" placeholder="Username" id="username" required>
						<br>
						<label for="password">
							<i class="fas fa-lock"></i>
						</label>
						<input type="password" name="password" placeholder="Password" id="password" required>
				<br>
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
				<br>
				<input type="submit" value="Register">
			</form>
			</div>
		</div>
	</body>
</html>
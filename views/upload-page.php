<!DOCTYPE html>
<?php
include "../router/inactivityLogout.php";
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../admin-login.html');
	exit;
}
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
			<h2>Upload Project</h2>
			<div class="text-center">
				<p>Register acount below:</p>
			<form action="../router/upload.php" method="post" enctype="multipart/form-data" autocomplete="off">
			<br>
				<label for="projectname">
					<i class="fas fa-project-diagram"></i>
				</label>
				<input type="text" name="projectname" placeholder="Project Name" id="projectname" required>
				<br>

				<label for="client">
					<i class="fas fa-user"></i>
				</label>
				&nbsp;<input type="text" name="client" placeholder="Client Name" id="client">
				<br>

				<label for="url">
					<i class="fas fa-link"></i>
				</label>
				<input type="text" name="url" placeholder="Url" id="url">
				<br>

                <label for="category">
                    <i class="fas fa-list-alt"></i>
                </label>
                <select name="category" id="category" required>
                    <option value="Website">Website</option>
                    <option value="Game">Game</option>
                    <option value="Program">Program</option>
                </select>
                <br>

                <label for="headlanguage">
                    <i class="fas fa-language"></i>
                </label>
                <select name="headlanguage" id="headlanguage" required>
                    <option value="PHP">PHP</option>
                    <option value="EJS">EJS</option>
                    <option value="Javascript">JavaScript</option>
                    <option value="C#">C#</option>
                    <option value="Java">Java</option>
                </select>
                <br>

				<label for="startdate">
					<i class="fas fa-calendar-alt"></i>
				</label>
				<input type="date" name="startdate" id="startdate">
				<br>

				<label for="finishdate">
					<i class="fas fa-calendar-check"></i>
				</label>
				<input type="date" name="finishdate" id="finishdate">
				<br>

                <label for="Project Image">
                    <i class="fa-solid fa-image"></i>
                </label>
                <input type="file" name="projectimage" id="projectimage" required>
                <br>

                
				<label for="file">
					<i class="fas fa-file"></i>
				</label>
				<input type="file" name="fileToUpload" id="fileToUpload" required>
				<br>

				<label for="inforamtion">
					<i></i>
				</label>
				<textarea name="inforamtion" id="inforamtion" cols="80" rows="5"></textarea>


                <!-- error message -->
				<?php
					if(!empty($_SESSION['upload_error_msg']))
					{
						echo"
						<div class='alert alert-danger' role='alert'> 
							".$_SESSION['upload_error_msg'],"
						</div>";
						unset($_SESSION['upload_error_msg']);
					}
					if(!empty($_SESSION['upload_succes_msg']))
					{
						echo"
						<div class='alert alert-success' role='alert'> 
							".$_SESSION['upload_succes_msg'],"
						</div>";
						unset($_SESSION['upload_succes_msg']);
					}
				?>
				<br>

				<input type="submit" value="Upload Image">

			</form>
			</div>
		</div>
	</body>
</html>
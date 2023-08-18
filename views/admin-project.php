<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../admin-login.html');
	exit;
}
include "../router/db.inc.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="../assets/css/styleAdmin.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">

          <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    
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
			<h2>Profile Page</h2>
			<div>
            <p>Your projects are below:</p>
            <table style="width:100%">
                        <?php 
                            $sql = "SELECT id, projectname, filename, picturename, catagory, headlanguage, date FROM projects";
                            $result = $con2->query($sql);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo '
                                    
                                        <tr>
                                            <td>ProjectName: '.$row["projectname"].'</td>                                   
                                            <td><a href="admin-portfolio.php?project_id='.$row["id"].'"><button type="button" class="btn btn-warning btn-sm">Edit</button></a></td>
                                            <td>
                                            ';if(isset($_POST["button-atc"])){echo'<p>test</p>';} echo'
                                            <form action="../router/deleteproject.php?project_id='.$row["id"].'" method="post">
                                                <input class="btn btn-danger btn-sm" name="delete" type="submit" value="Delete" onclick="return confirm(`Are you sure you want to delete '.$row["projectname"].'?`)">
                                            </form>
                                            </td>
                                        </tr>
                                    ';
                                }
                            return;
                            }
                            echo "0 results";
                        ?>
            </table>
			</div>
		</div>
	</body>
</html>

<?= CloseConnection($con, $con2)?>
<?php
include "../router/db.inc.php";
include "../router/inactivityLogout.php";
  if(isset($_GET['project_id'])){

    $project_id = $_GET['project_id'];
    $get_project = $con2->query("SELECT * FROM projects WHERE id = $project_id");
    $project_data = $get_project->fetch_assoc();
  }else{
    header("location: ../index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="refresh" content="9001">
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <?php
  echo '<title>Portfolio Details - '.$project_data["projectname"].'</title>'
  ?>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
  <header id="header">
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Portfolio Details</h2>
          <ol>
            <li><a href="admin-project.php">Home</a></li>
            <?php echo'<li>Portfolio Details - '.$project_data["projectname"].'</li>'  ?>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

      
      <div class="w-100">
        <?php
                    if(!empty($_SESSION['delete_error_msg']))
                    {
                      echo"
                      <div class='alert alert-danger' role='alert'> 
                        ".$_SESSION['error_msg'],"
                      </div>";
                      unset($_SESSION['error_msg']);
                    }
                    if(!empty($_SESSION['succes_msg']))
                    {
                      echo"
                      <div class='alert alert-success' role='alert'> 
                        ".$_SESSION['succes_msg'],"
                      </div>";
                      unset($_SESSION['succes_msg']);
                    }
				          ?>
        </div>

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">

                <div class="swiper-slide">
                  <?php echo '<img src="../uploads/'.$project_data["projectname"].'-Project/'.$project_data["picturename"].'" alt=""> '?> 
                </div>

                <div class="swiper-slide">
                <?php echo '<img src="../uploads/'.$project_data["picturename"].'" alt=""> '?> 
                
                </div>

                <div class="swiper-slide">
                <?php echo '<img src="../uploads/'.$project_data["picturename"].'" alt=""> '?> 
                </div>

              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>Project information</h3>
              <ul>
                <form action="../router/editproject.php" method="post" enctype="multipart/form-data" autocomplete="off">
                  <input type="text" name="id" value="<?=$project_data["id"]?>" style="display: none">
                  <li class="w-100">
                    <strong>Project Name</strong>:
                    <input type="text" name="projectname" placeholder="Project Name" value="<?=$project_data["projectname"]?>" id="projectname" required>
                  </li>

                  <li class="w-100"><strong>Category</strong>:
                    <select selected="Game" name="category" id="category" required>
                      <option <?php if($project_data["catagory"] == "Website"){ echo'selected';} ?> value="Website">Website</option>
                      <option <?php if($project_data["catagory"] == "Game"){ echo'selected';}?> value="Game">Game</option>
                      <option <?php if($project_data["catagory"] == "Program"){ echo'selected';}?> value="Program">Program</option>
                    </select>
                  </li>

                  <li class="w-100">
                    <strong>Client</strong>: 
                    <input type="text" name="client" placeholder="Client Name" id="client" value="<?=$project_data["client"]?>">
                  </li>

                  <li>
                    <strong>Project start date</strong>: 
                    <input type="date" name="startdate" if="startdate" value="<?= $project_data["startdate"]?>">
                  </li>

                  <li>
                    <strong>Project finish date</strong>: 
                    <input type="date" name="finishdate" if="finishdate" value="<?= $project_data["finishdate"]?>">
                  </li>

                  <li>
                    <strong>Project URL</strong>: 
                    <input type="text" name="url" placeholder="Url" id="url" value="<?=$project_data["url"]?>">
                  </li>

                  
                  <li>
                    <strong>Project Image</strong>: 
                    <input type="file" name="projectimage" id="projectimage">
                  </li>

                  <li>
                    <strong>Project File</strong>: 
                    <input type="file" name="fileToUpload" id="fileToUpload">
                  </li>
                  <li>
                    <input type="submit" class="btn-success btn btn-sm" value="Save">
                    <input type="reset" class="btn-warning btn btn-sm" value="Cancel">
                  </li>
                </form></ul>

                <form action="../router/editproject.php" method="post" enctype="multipart/form-data" autocomplete="off">
                  <h3>add extra picture</h3>
                  <input type="text" name="id" value="<?=$project_data["id"]?>" style="display: none">
                  <ul>
                    <li>
                      <strong>Picture File</strong>: 
                      <input type="file" name="projectimage" id="projectimage"></br>
                    </li>
                    <li>
                      <input type="submit" class="btn-success btn btn-sm" value="Upload">
                    </li>
                  </ul>
                </form>
                <?php CloseConnection($con, $con2); ?>        
            </div>
        </div>


            <div class="portfolio-description">
              <h2>Project informatie</h2>


                <form action="../router/editInformation.php" method="post">
                  <input type="text" name="id" value="<?=$project_data["id"]?>" style="display: none">
                  <h3>Add information</h3>
                  <textarea  name="information" id="information" cols="80" rows="10"><?=$project_data["information"]?></textarea> <br>
                  <input type="submit" class="btn-success btn btn-sm" value="Save">
                  <input type="reset" class="btn-warning btn btn-sm" value="Cancel">
                </form>

              
            </div>
          </div>


      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Benjamin Venema</span></strong>
      </div>
      
    </div>
  </footer><!-- End  Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/typed.js/typed.umd.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>

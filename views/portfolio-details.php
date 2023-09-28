<?php
session_start();
include "../router/db.inc.php";
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
    <?php include '../assets/php/nav.html'; ?>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <?php echo'<h2>Portfolio Details - '.$project_data["projectname"].'</h2>' ?>
          <ol>
            <li><a href="../index.php#portfolio">Home</a></li>
            <?php echo'<li>Portfolio Details - '.$project_data["projectname"].'</li>'  ?>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">

                <div class="swiper-slide">
                  <?php echo '<img src="../uploads/'.$project_data["projectname"].'-Project/'.$project_data["picturename"].'" alt=""> '?> 
                </div>

                <div class="swiper-slide">
                  <img src="../assets/img/portfolio/portfolio-details-2.jpg" alt="">
                </div>

                <div class="swiper-slide">
                  <img src="../assets/img/portfolio/portfolio-details-3.jpg" alt="">
                </div>

              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>Project information</h3>

              <ul>
                <li><strong>Category</strong>: <?=$project_data["catagory"]?></li>
                <li><strong>Head language</strong>: <?=$project_data["headlanguage"]?></li>
                <?php if($project_data["client"] != null){?>
                  <li><strong>Client</strong>: <?=$project_data["client"]?></li>
                <?php } if($project_data["startdate"] != "0000-00-00" && $project_data["startdate"] != null){?>
                  <li><strong>Project start date</strong>: <?=$project_data["startdate"]?></li>
                <?php } if($project_data["finishdate"] != "0000-00-00" && $project_data["finishdate"] != null){?>
                <li><strong>Project finish date</strong>: <?=$project_data["finishdate"]?></li>
                <?php } if($project_data["url"] != null){ ?>
                  <li><strong>Project URL</strong>: <a href="#"><?=$project_data["url"]?></a></li><?php } ?>
                <li><strong>Project Download</strong>: <a href="../uploads/<?=$project_data["projectname"]?>-Project/<?=$project_data["filename"]?>"><i class="bi bi-download"> </i><?=$project_data["filename"]?></a></li>
                <?php CloseConnection($con, $con2); ?>
              </ul>
            </div>
            
          </div>

        </div>
        <div class="row gy-4">
              <h2>Project informatie</h2>
              <?=$project_data['information']?>
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

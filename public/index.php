<?php
  require_once '../includes/config.php';
  require_once LIB_PATH.DS.'Database.php';
  require_once LIB_PATH.DS.'Session.php';
  require_once LIB_PATH.DS.'Area.php';

  if($_SERVER['REQUEST_METHOD'] === "POST"){
    require_once LIB_PATH.DS.'Complain.php';
    $name = isset($_POST['name']) ? $_POST['name']: '';
    $phone = isset($_POST['phone']) ? $_POST['phone']: '';
    $complain = isset($_POST['complain']) ? $_POST['complain']: '';
    $area = isset($_POST['area']) ? $_POST['area']: 0;
    $newComplain = new Complain($name,$phone,$complain,$area);
    $newComplain->save();
    $link = SITE_LINK;
    $session->flash('complain', 'Yes');
    header("Location: {$link}");
  }
  $complain = $session->getFlashValue('complain');
  $allAreas = Area::findAll();
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sylvia WebGIS</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/grayscale.min.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Slyvia WebGIS</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">View Map</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#signup">Lay A Complain</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="admin/login.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Header -->
    <header class="masthead">
      <div class="container d-flex h-100 align-items-center">
        <div class="mx-auto text-center">
          <h2 class="text-success mx-auto mt-2 mb-5" style="font-size: 2rem" id="successMsg"></h2>
          <h1 class="mx-auto my-0 text-uppercase">WebGIS</h1>
          <h2 class="text-white-50 mx-auto mt-2 mb-5">A WebGIS application built with PHP, Bootstrap, Javascript, HTML and CSS.</h2>
          
        </div>
      </div>
    </header>

    <!-- About Section -->
    <section id="about" class="about-section text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <h2 class="text-white mb-4">View Map</h2>
          </div>
          <div style="width:100%;height:550px;background:grey" id="map"></div>
        </div>
      </div>
    </section>

    <!-- Signup Section -->
    <section id="signup" class="signup-section">
      <div class="container">
        <div class="row">
          <div class="col-md-10 col-lg-8 mx-auto text-center">

            <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
            <h2 class="text-white mb-5">Lay A Complain!</h2>

            <form class="form-inline d-flex" method="POST" action="<?php echo SITE_LINK?>">
              <div class="w-100 d-flex m-2">
                <input type="text" name="name" class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" id="inputEmail" placeholder="Enter your Name" required>
              </div>
              <div class="w-100 d-flex m-2">
                <input type="number" name="phone" class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" id="inputEmail" placeholder="Enter your phone number" required>
              </div>
              <div class="w-100 d-flex m-2">
                <select name="area" class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" required>
                  <option>Select a School Area</option>
                  <?php
                    foreach ($allAreas as $key => $area) {
                      echo "<option value='" . $area->id . "'>" . htmlentities($area->name) . "</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="w-100 d-flex m-2">
                <textarea name="complain" class="w-100" style="height: 250px" placeholder="What are you complaining about" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary mx-auto">Submit</button>
            </form>

          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black small text-center text-white-50">
      <div class="container">
        Copyright &copy; Sylvia WebGIS 2018
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/grayscale.min.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwO5hLv-bGYpOLUDyeM31YNHQbBRbc4Ak&callback=initMap"
    type="text/javascript"></script>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 4.9739, lng: 8.3410},
          zoom: 20,
          mapTypeId: "hybrid"
        });
      }
      function showSuccessMsg(){
        var msg = document.querySelector('#successMsg')
        msg.innerHTML = 'Complain Submitted'
        setTimeout(function(){
          msg.innerHTML = '' 
        },3000)
      }
      <?php
        if(!empty($complain)){
          echo 'showSuccessMsg()';
        }
      ?>
    </script>
  </body>

</html>

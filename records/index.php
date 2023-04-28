<?php
    session_start();
    #Server Connection...

    include 'assets/connection/connection.php';

    #Variable Declaration...

    $alert_class="";
    $alert_message="";
    $error_class="";
    $error_class2="";
    $login_var="";

    # Getting Data...

    if (isset($_POST['signin'])){
        // $username=$_POST['username'];
        $password_enc = $_POST['password'];
        $password=md5($password_enc);
        $login_var=addslashes($login_var);
        # Searching for user existence...

        // $search_user = $con->query("SELECT * FROM `account` WHERE `username`='$username'") or die(mysqli_error($con));
        $search_password = $con->query("SELECT * FROM `account` WHERE `password`='$password'") or die(mysqli_error($con));
        $count_password = mysqli_num_rows($search_password) > 0;
        // $count_user = mysqli_num_rows($search_user) > 0;
        #Counting User existence...

        if ($count_password) {
          $admin=mysqli_fetch_assoc($search_password);
          if ($password == $admin['password']) {
              $page='admin/';
              $_SESSION['login_var']=$admin;
              header('location:'.$page);
          }
        }

        // if (!$count_user) {
            // $admin=mysqli_fetch_assoc($search);
            // if ($username != $admin['username']) {
            //   $alert_class="text-muted";
            //   $alert_message="* User doesn't exist";
            //   $error_class2="border-bottom: 3px solid #d11a2c;";
            //   $error_class="border-bottom: 3px solid #d11a2c;";
            // }
          // else {
            if (!$count_password) {
              $alert_class="text-muted";
              $alert_message="* Incorrect Password";
              $error_class="border-bottom: 3px solid #d11a2c;";
          }
        // }
      }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <!-- <meta name="viewport" content="width=device-width, initial-scale = 1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700;800&display=swap" rel="stylesheet"> -->


  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@100;200;300;400;500;600;700;800;900&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="assets/css/style.core.css">
  <link rel="stylesheet" type="text/css" href="assets/icons/style.css">
  <title>MA Global | Records</title>
  <link rel="shortcut icon" type="image/ico" href="../assets/icons/earth3.ico">
</head>

<body>
<div class="index-wrapper">
  <header>
    <a href="index.html" class="header-brand">MA Global</a>
    <nav>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Our Services</a></li>
        <li><a href="records/">Records</a></li>
        <li><a href="#">About us</a></li>
        <li><a href="#">Help desk</a></li>
      </ul>
    </nav>
    <a href="#" class="header-cases">Cases</a>
  </header>

  <main>

      <section class="index-links">
        <div class="login-box">
          <h3>LOGIN</h3>
          <form class="" action="index.html" method="post">
            <span>
              <span class="fs1" aria-hidden="true" data-icon="&#xe08a;"></span>
              <input type="text" placeholder="Username" name="" value="">
            </span><br>
            <span>
              <span class="fs1" aria-hidden="true" data-icon="&#xe06e;"></span>
              <input type="password" placeholder="Password" name="" value="">
            </span><br>
            <button type="submit" name="">Login</button>
          </form>
        </div>
      </section>

  </main>

  <footer>
    <ul class="footer-links-main">
      <li><a href="#">Home</a></li>
      <li><a href="#">Construction</a></li>
      <li><a href="#">IT Pro</a></li>
      <li><a href="#">Telecom</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
    <ul class="footer-links-cases">
      <li><a href="#">Latest Cases</a></li>
      <li><a href="#">CONSTRUCTION ESTIMATE</a></li>
      <li><a href="#">WEB AND NET INSTALLER</a></li>
      <li><a href="#">TELECOMMUNICATIONS</a></li>
      <li><a href="#">CONTACT US</a></li>
    </ul>
    <div class="footer-social-media">
      <a href="#">
        <i class="social_tumblr_circle" alt="Facebook"></i>
      </a>
      <a href="#">
        <i class="social_instagram_circle" alt="Facebook"></i>
      </a>
      <a href="#">
        <i class="social_dribbble_circle" alt="Facebook"></i>
      </a>
      <a href="#">
        <i class="social_vimeo_circle" alt="Facebook"></i>
      </a>
    </div>
  </footer>
  </div>

</body>

</html>

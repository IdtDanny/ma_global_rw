<?php
    // session_start();
    // include '../assets/connection/connection.php';
    // if (!isset($_SESSION['login_var'])) {
    //     header("location:../index.php");
    // }
    // $user_id=$_SESSION['login_var']['user_ID'];
    // $user_password = $_SESSION['login_var']['password'];
    //
    //
    // # Fetching user Info...
    //
    // $select = $con -> query( "SELECT * FROM account WHERE user_ID = '$user_id' AND password = '$user_password' " ) or die ( mysqli_error($con) );
    //
    // $ad = mysqli_fetch_assoc($select);
    //
    // # user Info...
    // if (!$ad) {
    //   header("location:../index.php");
    // }
    // else {
    //   $username=$ad['username'];
    // }

    ?>

<?php
    session_start();
    #Server Connection...

    include '../assets/connection/connection.php';

    #Variable Declaration...

    $alert_class="";
    $alert_message="";
    $error_class="";
    $error_class2="";
    $login_var="";

    # Getting Data...

    if (isset($_POST['verify'])){
        $user_pin=$_POST['user_pin'];
        $user_year=$_POST['user_year'];
        # Searching for user existence...

        $search=$con->query("SELECT * FROM `account` WHERE `pin`='$user_pin'") or die(mysqli_error($con));
        $count=mysqli_num_rows($search);
        #Counting User existence...

        if ($count > 0) {
            $row =mysqli_fetch_assoc($search);
            if ($user_pin == $row['pin'] AND $user_year == $row['user_year']) {
                $user_id = $row['user_ID'];
                $page='reset.php';
                $_SESSION['user_id']=$user_id;
                header('location:'.$page);
            }
            else{
                $alert_class="text-muted";
                $alert_message="* Unknown User Info";
                $error_class="border-bottom: 3px solid #d11a2c;";
            }
        }

            /*
            $alert_class="text-muted";
            $alert_message="* Username doesn't exist";
            $error_class2="border-bottom: 3px solid #d11a2c;";
        */
    }
    if (isset($_POST['contact'])) {
      $alert_class="text-muted";
      $alert_message="* Contact us";
      // $error_class="border-bottom: 3px solid #d11a2c;";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Core Bootstrap Css -->
    <link rel="stylesheet" href="../assets/dist/css/bootstrap.min.css">

    <!-- Core MDB Css -->
    <link rel="stylesheet" href="../assets/md/css/mdb.min.css">

    <!-- Core MDB Css -->
    <link rel="stylesheet" href="../assets/md/css/style.css">

    <title>Kebo Group | Home</title>

    <!-- Internal Css -->
    <style type="text/css">
        input[type="text"],
        input[type="password"]{
            border: none;
            outline:none;
            border-bottom: 3px solid #A35448;
            transition:.3s border ease-in;
        }
        input[type="text"]:focus,
        input[type="password"]:focus{
            border-bottom: 3px solid #000000;
        }
        #mybtn:focus{
            background-color:#000000;
        }
        header{
            height:70px;
        }
        .animated{
            animation-name: animate;
            animation-duration: 0.5s;
            animation-direction: reverse;
            animation-delay: 0.7s;
        }

        @keyframes animate {
            0%{margin-left: 80px;color:#d11a2c;font-weight:bold;}
            100%{margin-left: 0px;}
        }
        .well1{
        background-color: #fff;
        /* width:240px;
        height:240px; */
        display:-webkit-box;
        display:-ms-flexbox;
        display:flex;
        -webkit-box-pack:center;
        -ms-flex-pack:center;
        justify-content:center;
        -webkit-box-align:center;
        -ms-flex-align:center;
        align-items:center;
        border-radius:5%}
    </style>
</head>
<body style="background-color:#f8f5f5;">
    <!-- <header class="teal">
        <div class="container">
            <h3 class="white-text text-center" style="font-family:Caviar Dreams;line-height:70px;">Kebo Group</h3><br>
        </div>
    </header> -->
    <br><br>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-7">
                <div class="well1 bg-white shadow-sm p-4">
                      <div class="mt-4" style="padding-top:30px;"><img src="../pictures/logo_k_login.svg" class="mt-4 ml-4" style="width:250px;" alt="Kebo Group Presents"></div>
                      <form action="" method="post" style="padding-right:20px;">
                        <h3 class="teal-text text-center">Fill this to verify your credentials</h3>
                        <hr>
                          <div>
                              <p class="<?php echo $alert_class ?> animated">
                                  <i style="font-size:14px;"><?php echo $alert_message ?></i>
                              </p>
                          </div>
                          <div class="form-group">
                              <label style="color: #A35448; font-weight: bold;">User Pin</label>
                              <input type="text" name="user_pin" style="<?php echo $error_class2 ?>" class="form-control rounded-0" required>
                          </div>
                          <div class="form-group">
                              <label style="color: #A35448; font-weight: bold;">Joined Year</label>
                              <input type="text" name="user_year" style="<?php echo $error_class ?>" class="form-control rounded-0" required>
                          </div><br>
                          <!-- <a href="#" class="text-muted" name="contact" style="font-size:14px;"><i>Forgot Everything?</i></a><br><br> -->
                          <div class="form-group">
                            <div class="row justify-content-center">
                              <div class="col-lg-5">
                                <input type="submit" class="btn teal btn-block btn-sm white-text" name="verify" value="Verify" style="font-size: 13px;">
                              </div>
                              <div class="col-lg-5">
                                <a href="../index.php" style="font-size: 13px;" class="btn shadow-0 btn-block btn-sm teal white-text">Cancel</a>
                              </div>
                          </div>
                        </div>
                      </form>
                </div>
            </div>
            <div class="col-lg-4"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-11">
                <p class="text-muted text-center">Copyright &copy; 2020</p>
            </div>
        </div>
    </div>
</body>
</html>

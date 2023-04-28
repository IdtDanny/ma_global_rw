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

    if (isset($_POST['reset'])){
        $npassword = $_POST['npassword'];
        $cpassword = $_POST['cpassword'];
        $user_id = $_SESSION['user_id'];
        # Searching for user existence...

        $search=$con->query("SELECT * FROM `account` WHERE `user_ID`='$user_id'") or die(mysqli_error($con));
        $count=mysqli_num_rows($search);
        #Counting User existence...

        if ($count > 0) {
            $row =mysqli_fetch_assoc($search);
            if ($npassword == $cpassword) {
                $reset_password = $con->query("UPDATE account SET password = '$npassword' WHERE user_ID = '$user_id'") or die(mysqli_error($con));
                $page='../index.php';
                // $_SESSION['user_id']=$row;
                header('location:'.$page);
            }
            else{
                $alert_class="text-muted";
                $alert_message="* Check the password";
                $error_class="border-bottom: 3px solid #d11a2c;";
            }
        }

            /*
            $alert_class="text-muted";
            $alert_message="* Username doesn't exist";
            $error_class2="border-bottom: 3px solid #d11a2c;";
        */
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

    <title>MA Hardware | Home</title>

    <!-- Internal Css -->
    <style type="text/css">
        input[type="text"],
        input[type="password"]{
            border: none;
            outline:none;
            border-bottom: 3px solid #298;
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
    </style>
</head>
<body style="background-color:#f8f5f5;">
    <!-- <header class="teal">
        <div class="container">
            <h3 class="white-text text-center" style="font-family:Caviar Dreams;line-height:70px;">MA Hardware</h3><br>
        </div>
    </header> -->
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="well bg-white shadow-sm p-4">
                    <div class="teal-text text-center"><img src="../pictures/logo_ma.svg" style="margin-top: -20px;"></div>
                    <hr>
                    <h3 class="teal-text text-center">Reset your password</h3>
                    <hr style="padding-bottom: 10px;">
                    <form action="" method="post">
                        <div>
                            <p class="<?php echo $alert_class ?> animated">
                                <i style="font-size:14px;"><?php echo $alert_message ?></i>
                            </p>
                        </div>
                        <div class="form-group">
                            <label style="color: #298; font-weight: bold;">New Password</label>
                            <input type="password" name="npassword" style="<?php echo $error_class2 ?>" class="form-control rounded-0" required>
                        </div>
                        <div class="form-group">
                            <label style="color: #298; font-weight: bold;">Confirm Password</label>
                            <input type="password" name="cpassword" style="<?php echo $error_class ?>" class="form-control rounded-0" required>
                        </div>
                        <a href="admin/reset.php" class="text-muted" style="font-size:14px;"><i>Forgot Everything?</i></a><br><br>
                        <div class="form-group">
                          <div class="row">
                            <div class="col lg-3">
                              <input type="submit" name="reset" value="Reset" style="font-size: 13px;" id="mybtn" class="btn btn-block shadow-0 btn-sm teal white-text">
                            </div>
                            <div class="col lg-3">
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
            <div class="col-lg-12">
                <p class="text-muted text-center">Copyright &copy; 2020</p>
            </div>
        </div>
    </div>
</body>
</html>

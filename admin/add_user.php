<?php
    session_start();
    include '../assets/connection/connection.php';
    if (!isset($_SESSION['login_var'])) {
        header("location:../index.php");
    }
    $user_id=$_SESSION['login_var']['user_ID'];
    $user_password = $_SESSION['login_var']['password'];


    # Fetching user Info...

    $select = $con -> query( "SELECT * FROM account WHERE user_ID = '$user_id' AND password = '$user_password' " ) or die ( mysqli_error($con) );

    $ad = mysqli_fetch_assoc($select);

    # user Info...
    if (!$ad) {
      header("location:../index.php");
    }
    else {
      $username=$ad['username'];
    }

    ?>

<?php include 'includes/header.php'; ?>


            <div class="col-md-10 bg-white">
                <ul>
                    <li><a href="daily.php">Daily</a></li>
                    <li><a href="cement.php">Cement</a></li>
                    <li><a href="others.php">Others</a></li>
                    <li><a href="report.php">Report</a></li>
                    <li><a href="account.php">My Account</a></li>
                    <li><a href="add.php" class="active">Add User</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>

    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <br>
                <form method="post" enctype="multipart/form-data">
                  <p class="display-4 teal-text text-center">
                      Add User
                  </p>
                <div class="row">
                    <div class="col-md-4">
                      <div class="well shadow-sm bg-white p-4">
                        <div class="form-group">
                            <label style="color:#298;">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label style="color:#298;">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="well shadow-sm bg-white p-4">
                        <div class="form-group">
                            <label style="color:#298;">New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label style="color:#298;">Confirm Password</label>
                            <input type="password" name="cpassword" class="form-control" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="well shadow-sm bg-white p-4">
                        <div class="form-group">
                            <label style="color:#298;">Profile Photo</label>
                            <input type="file" name="photo" required>
                        </div><hr><br>
                        <div class="form-group" style="margin-top: -10px;">
                            <input type="submit" style="font-size: 13px;" class="btn btn-sm teal text-white ml-3" title="Add user" value="Add User" name="adduser">
                            <a href="daily.php" style="font-size: 13px;" class="btn btn-sm teal text-white ml-3" title="Cancel">Cancel</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
                    <div class="col-md-2"></div>
            </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="text-muted text-center">Copyright &copy; 2020</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



<?php

    if (isset($_POST['adduser'])) {
        $names=$_POST['name'];
        $username=$_POST['username'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        // $password=md5($password);
        if ($password == $cpassword) {
        $photo=$_FILES['photo']['name'];
        $folder="../pictures/".basename($photo=$_FILES['photo']['name']);
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $folder) or die(error_reporting())){
        $user_pin = rand(1000,9999);
        $today = '2020';
        $pin = $today . $user_pin;
        $sql=$con->query("
                            INSERT INTO account(fullname,username,password,pin,photo)
                            VALUES('$names','$username','$password','$pin','$photo')
                        ") or die(mysqli_error($con));
        if ($sql) {
            # code...
            ?>
            <script>
                alert('Default Pin is <?php echo $pin ?> ')
                window.location = 'account.php'
            </script>
            <?php
        }
        }
        else{
            echo "Profile Not Added";
        }
      }
      else {
        echo "Check password";
      }
    }
?>

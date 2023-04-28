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
      $fullname = $ad['fullname'];
      $user_pin = $ad['pin'];
      $password = $ad['password'];
    }

    ?>


<?php include 'includes/header.php'; ?>


            <div class="col-md-10 bg-white">
                <ul>
                    <li><a href="daily.php">Daily</a></li>
                    <li><a href="cement.php">Cement</a></li>
                    <li><a href="others.php">Others</a></li>
                    <li><a href="expense.php">Expenses</a></li>
                    <li><a href="report.php">Report</a></li>
                    <li><a href="account.php" class="active">My Account</a></li>
                    <li><a href="add_user.php">Add User</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>

            </div>

    <div class="container">
        <div class="row">
          <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <form method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col">
                  <p class="display-4 teal-text text-center">
                      Edit
                  </p></div>
                  <div class="col">

                  <!-- PHP codes for modifying the users infos -->

                  <?php


                      # Editing Code ...

                      if ( isset ( $_POST [ 'edit' ] ) ) {

                          # Variable Declaration...

                          $name = $_POST ['name'] ;
                          $username = $_POST ['username'] ;
                          $oldpassword = $_POST ['oldpassword'] ;
                          $newpassword = $_POST ['newpassword'] ;
                          $cpassword = $_POST ['cpassword'] ;

                          # Fetching Admin Password...

                          $select = $con -> query( "SELECT * FROM account WHERE user_ID = '$user_id' " ) or die ( mysqli_error($con) );

                          $ad = mysqli_fetch_assoc($select);

                          # Admin Password...

                          $password = $ad['password'];

                          # Checking For Password Matching...

                          if ( $password == $oldpassword) {

                              if( $newpassword == $cpassword ){

                                  # Updating Query...

                                  $update = "
                                          UPDATE account
                                          SET fullname = '$name',
                                              username = '$username',
                                              password = '$newpassword'
                                          WHERE user_ID = '$user_id'
                                  ";

                                  $exec = $con -> query($update) or die ( mysqli_error($con) );

                                  if ( $exec ) {

                                      echo "<br><span class='badge teal white-text' style='margin-left: 60px; padding: 10px; font-size: 12px;'>Successfully Updated &nbsp;&nbsp;&nbsp;<a href='edit.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                      // echo "Successfully Updated";

                                  }
                              }

                          }
                          else{
                              echo "<br><span class='badge badge-danger white-text' style='margin-left: 60px; padding: 10px; font-size: 12px;'>Invalid Old Password &nbsp;&nbsp;&nbsp;<a href='index.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px;'></a></span>";
                              // echo "Invalid Old Password";
                          }



                      }

                  ?><br></div></div>


                    <div class="row">
                      <div class="col-md-6">
                        <div class="well shadow-sm bg-white p-4">
                          <div class="form-group">
                                <label style="color: #A35448;">Names</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $fullname ?>" required>
                          </div>
                          <div class="form-group">
                              <label style="color: #A35448;">Username</label>
                              <input type="text" name="username" class="form-control" value="<?php echo $username ?>" required>
                          </div>
                          <div class="form-group">
                              <label style="color: #A35448;">Pin</label>
                              <input type="text" name="user_pin" class="form-control" value="<?php echo $user_pin ?>" required>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="well shadow-sm bg-white p-4">
                          <div class="form-group">
                              <label style="color: #A35448;">Old Password</label>
                              <input type="password" name="oldpassword" class="form-control" value="<?php echo $password ?>" required>
                          </div>
                          <div class="form-group">
                              <label style="color: #A35448;">New Password</label>
                              <input type="password" name="newpassword" class="form-control" required>
                          </div>
                          <div class="form-group">
                              <label style="color: #A35448;">Confirm Password</label>
                              <input type="password" name="cpassword" class="form-control" required>
                          </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                          <div class="form-group"><br>
                              <button class="btn btn-sm btn-block teal white-text" name="edit" style="font-size: 13px;">
                                  Edit&nbsp;&nbsp;&nbsp;<span class="fs1" aria-hidden="true" data-icon="&#x6b;" title="edit"></span>
                              </button>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group"><br>
                              <a href="account.php" class="btn btn-sm btn-block teal white-text" style="font-size: 13px;">
                                  Return&nbsp;&nbsp;&nbsp;<span class="fs1" aria-hidden="true" data-icon="&#x4a;" title="Back"></span>
                              </a>
                          </div>
                        </div>
                      </div>
                    </div>
                   </div>
                  </form>
              </div>
                    <div class="col-md-2"></div>
            </div>

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

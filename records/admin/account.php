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

  <?php
    include 'includes/header.php';
   ?>

   <?php
       $username=$_SESSION['login_var']['username'];
       $fullname=$_SESSION['login_var']['fullname'];
       $photo=$_SESSION['login_var']['photo'];
       $admin_id=$_SESSION['login_var']['user_ID'];


       # Fetching Admin Info...

       $select = $con -> query( "SELECT * FROM account WHERE user_ID = '$admin_id' " ) or die ( mysqli_error($con) );

       $ad = mysqli_fetch_assoc($select);

       # Admin Info...

       $username=$ad['username'];
       $name=$ad['fullname'];
       $photo = $ad['photo'];

   ?>
   <style type="text/css">
   .img img{
       width: 140px;
       height: 140px;
       object-fit: cover;
       border-radius: 100%;
       box-shadow: 0px 0px 6px 2px #A35448;
   }
   </style>


                      <div class="col-md-10 bg-white">
                          <ul>
                              <li><a href="daily.php">Daily</a></li>
                              <li><a href="cement.php">Cement</a></li>
                              <li><a href="others.php">Others</a></li>
                              <li><a href="expense.php">Expenses</a></li>
                              <li><a href="report.php">Report</a></li>
                              <li><a href="add_user.php">Add User</a></li>
                              <li><a href="account.php" class="active">My Account</a></li>
                              <li><a href="logout.php">Logout</a></li>
                          </ul>
                      </div>
                  </div>

              <div class="container">
                <div class="row">
                  <div class="col-lg-12">
                        <br>
                      <div class="row">
                          <div class="col-md-3"></div>
                          <div class="col-md-6">
                           <div class="well shadow-sm bg-white p-4"><br>
                              <p class="display-4 teal-text text-center" style="font-size: 25px; font-weight: bold;">
                                  My account:
                              </p>
                              <br>
                          <div class="row">
                            <div class="col md-3">
                              <center>
                                  <div class="img">
                                      <img src="../pictures/<?php echo $photo ?>">
                                  </div>
                              </center>
                            </div>
                            <div class="col md-3">
                              <br>
                              <label class="teal-text" style="font-weight: bold;">Names:</label>&nbsp;&nbsp;&nbsp;<?php echo $name ?><br>
                              <label class="teal-text" style="font-weight: bold;">Username:</label>&nbsp;&nbsp;&nbsp;<?php echo $username ?>
                            </div>
                          </div>
                              <br><br>

                            <!-- Buttons  -->
                            <div class="row">
                              <div class="col md-3">
                                <a href="edit.php">
                                  <button class="btn btn-sm btn-block teal white-text" name="edit" style="font-size: 12px;font-weight: bold;">
                                      Edit&nbsp;&nbsp;&nbsp;<span class="fs1" aria-hidden="true" data-icon="&#x6b;" title="edit"></span>
                                  </button>
                                </a>
                              </div>
                              <!-- <div class="col md-3"></div> -->
                              <div class="col md-3">
                                <center>
                                    <a href="daily.php">
                                      <button class="btn btn-sm teal text-white"  style="font-size: 12px;">
                                        Return&nbsp;&nbsp;&nbsp;<span class="fs1" aria-hidden="true" data-icon="&#x4a;" title="return"></span>
                                      </button>
                                    </a>
                                </center>
                              </div>
                            </div>
                          </div>
                        </div>
                  </div>
                  <br><br>
                  <div class="row">
                      <div class="col-lg-12">
                          <p class="text-muted text-center">Copyright &copy; 2020</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </body>
  <script src="../assets/main.js"></script>
  </html>

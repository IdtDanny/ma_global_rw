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


                    <div class="col-md-10 bg-white">
                        <ul>
                            <li class="col-md-9"></li>
                            <li><a href="index.php" class="active"><span class="fs1" data-icon="&#xe074;" style="font-size: 19px;"></span></a></li>
                            <!-- <li><a href="account.php">My Account</a></li> -->
                            <li><a href="logout.php"><span class="fs1" data-icon="&#xe06d;" style="font-size: 19px;"></span></a></li>


                            <?php
                            if (isset($_POST['start_record'])) {
                              $date = $_POST['date'];
                              $_SESSION['today'] = $date;
                              $select_today = $con->query("SELECT * FROM `$date`");
                              if ($select_today) {
                                $_SESSION['today'] = $date;
                                header("Location: ../admin/daily.php");
                              }
                              else {
                                $create_table = $con->query("CREATE TABLE `$date`(
                                                                     Date DATE,
                                                                     No INT(255) PRIMARY KEY AUTO_INCREMENT,
                                                                     Designation VARCHAR(255),
                                                                     Unit VARCHAR(255),
                                                                     Qty INT(255),
                                                                     Prix INT(255),
                                                                     Total INT(255),
                                                                     Profit INT(255),
                                                                     Status TEXT(255),
                                                                     Type VARCHAR(255)
                                                                   )")or die(mysqli_error($con));
                                $make_report = $con->query("INSERT INTO `report`(`Date`) VALUES('$date')") or die(mysqli_error($con));
                                if ($create_table) {
                                  $_SESSION['today'] = $date;
                                  header("Location: ../admin/daily.php");
                                }
                              }
                            }
                              ?>

                        </ul>
                    </div>
                </div>
                <br>
                <div class="row">
                	<!-- <div class="col-md-3">
                		<!-
                          <div class="well shadow-sm bg-white p-4">
                            <h3 class="teal-text" style="font-family:Century Gothic;">Recharge:</h3><br>
                            <form class="form">
                                <div class="form-group">
                                    <label>card_id</label>
                                    <input type="text" name="search" class="form-control">
                                    <input type="submit" value="Search" name="send">
                                </div>
                            </form>
                        </div>
                        <br>
                        ->
                	</div> -->

                	<div class="col-lg-12">
                    <div class="row">
                      <div class="col-lg-3"></div>
                      <div class="col-lg-6">
                        <div class="well shadow-sm bg-white p-4">
                            <div class="teal-text text-center">
                              <img src="../pictures/logo_ma.svg" style="margin-top: -20px;height: 80px; width: 400px;">
                            </div>
                            <hr>
                            <h3 class="teal-text text-center">Fill The Date</h3>
                            <hr style="padding-bottom: 10px;">
                          <form method="post" enctype="multipart/form-data">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <input type="date" name="date" placeholder="Date" class="form-control" required><br>
                                    <center>
                                    <button type="submit" class="btn teal btn-block btn-sm white-text" style="font-size: 13px;" name="start_record">Start</button>
                                    <!-- <button href="daily.php" type="submit" class="btn teal btn-sm white-text" name="start_explore" style="font-size: 13px;">Explore</button> -->
                                  </center>
                                </div>
                              </div>
                            </form>
                          </div><br>
                        </div>
                      </div>


                		<div class="row">
                      <div class="col-md-12">
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
<script src="../assets/main.js"></script>
</html>

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
                            <li><a href="daily.php">Daily</a></li>
                            <li><a href="cement.php">Cement</a></li>
                            <li><a href="others.php" class="active">Others</a></li>
                            <li><a href="report.php">Report</a></li>
                            <li><a href="account.php">My Account</a></li>
                            <li><a href="logout.php">Logout</a></li>

                            <!-- reading the items -->
                            <?php
                             if (isset($_POST['add_item'])) {
                               $item = $_POST['Designation'];
                               $Qty = $_POST['qty'];
                               $Prix = $_POST['prix'];
                               $sprix = $_POST['sprix'];
                               $type = "others";
                               $status = "";
                               $unit = $_POST['unit'];
                               $Profit_unit = $sprix - $Prix;
                               $Profit = $Profit_unit * $Qty;

                               $select_cement = $con->query("SELECT * FROM others WHERE Designation = '$item'");
                               $count_cement = mysqli_num_rows($select_cement);
                               $count = $count_cement > 0;

                               // Updating the existing others stock
                               while ($row_cement = mysqli_fetch_array($select_cement)) {
                                 $current_qty = $row_cement['Qty'];
                                 $qty = $current_qty + $Qty;
                                 $update_cement = $con->query("UPDATE others SET `Date`=NOW(),Qty='$qty',Prix='$Prix',SPrix='$sprix',Profit_unit='$Profit_unit',Profit='$Profit',Status='Available' WHERE Designation = '$item'") or die(mysqli_error($con));
                                 echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Update_Success &nbsp;&nbsp;<a href='others.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                 exit();
                               }

                               // Adding to the current stock
                               if (!$count) {
                                 $status = "Available";
                                 $add_cement = $con -> Query("INSERT INTO `others`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `SPrix`, `Profit_unit`, `Profit`, `Status`, `Type`)
                                                                          VALUES (NOW() , '$item', '$unit', '$Qty', '$Prix', '$sprix', '$Profit_unit', '$Profit', '$status', '$type')
                                                                          ") or die(mysqli_error($con));
                                  echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Add_Success &nbsp;&nbsp;<a href='others.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                               }
                             }

                             ?>


                        </ul>
                    </div>
                </div>
                <br>
                <div class="row">
                	<div class="col-md-3">
                		<!--
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
                        -->
                        <div class="well shadow-sm bg-white p-4">
                            <center>
                              <form method="post" enctype="multipart/form-data">
                                  <div class="form-group">
                                      <input type="text" name="search" class="form-control" placeholder="Search Item">
                                  </div>
                              </form>

                                <a href="others.php" class="btn teal btn-sm btn-block white-text active">Current Stock</a>
                                <a href="profit_others.php" class="btn teal white-text btn-sm btn-block ">Profit Table</button></a>
                                <button class="btn teal btn-sm btn-block white-text" id="withdraw_btn">ADD NEW Other</button>
                            </center>
                        </div>
                        <br>
                	</div>

                	<div class="col-md-9">

                    <div class="row withdraw-modal">
                      <div class="col-md-12">
                        <div class="well shadow-sm bg-white p-4">
                          <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="Designation" placeholder="Designation" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="unit" placeholder="Unit" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="qty" placeholder="Qty" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="prix" placeholder="Prix" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="sprix" placeholder="SPrix" class="form-control" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn teal btn-sm white-text" data-icon="&#x4c;" style="font-size: 50px,font-weight: ;margin-left: -13px;" name="add_item"></button>
                                </div>
                              </div>
                            </form>
                          </div><br>

                              <!-- reading the items -->
                              <?php
                                // if (isset($_POST['add_item'])) {
                                //   $item = $_POST['Designation'];
                                //   $Unit = $_POST['unit'];
                                //   $Qty = $_POST['qty'];
                                //   $Prix = $_POST['prix'];
                                //   $SPrix = $_POST['sprix'];
                                //   $Profit_unit = $SPrix - $Prix;
                                //   $Profit = $Profit_unit * $Qty;
                                //   $type = "others";
                                //   $status = "";
                                //
                                //   if ($Qty == "0" ) {
                                //     $status ="Not Available";
                                //     $sql = $con -> Query("INSERT INTO `others`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `SPrix`, `Profit_unit`, `Profit`, `Status`, `Type`)
                                //                                              VALUES (NOW() , '$item', '$Unit', '$Qty', '$Prix', '$SPrix', '$Profit_unit', '$Profit', '$status', '$type')
                                //                                              ") or die(mysqli_error($con));
                                //   }
                                //   elseif($Qty > "0") {
                                //     $status = "Available";
                                //     $sql = $con -> Query("INSERT INTO `others`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `SPrix`, `Profit_unit`, `Profit`, `Status`, `Type`)
                                //                                              VALUES (NOW() , '$item', '$Unit', '$Qty', '$Prix', '$SPrix', '$Profit_unit', '$Profit', '$status', '$type')
                                //                                              ") or die(mysqli_error($con));
                                //   }
                                // }
                               ?>

                    </div>
                  </div>


                		<div class="row">
                      <div class="col-md-12">
                       <div class="well shadow-sm bg-white p-4">
                			<p class="display-4 teal-text">
                				Current Stock :
                      <!-- </p> -->
                      <!--  -->
                        <?php
                          if (!isset($_POST['search'])):
                          ?>
                          <?php
                              $sql = $con->Query("SELECT * FROM others");
                           ?>
                          <table class="table table-sm">
                                      <tr class="teal-text">
                                          <th class="text-center">No</th>
                                          <th>Designation</th>
                                          <th>Unit</th>
                                          <th>Qty</th>
                                          <th>Prix</th>
                                          <th>SPrix</th>
                                          <th>Status</th>
                                          <th class="text-center">Action</th>
                                      </tr>
                          <?php while($row = mysqli_fetch_array($sql)):
                                  ?>
                            <tr>
                              <td><span style="font-size: 19px;font-weight: bold;display: block; color: #298" data-icon="&#x4e;" class="text-center"></span></td>
                              <td><?php echo $row['Designation'] ?></td>
                              <td><?php echo $row['Unit'] ?></td>
                              <td><?php echo $row['Qty'] ?></td>
                              <td><?php echo $row['Prix'] ?></td>
                              <td><?php echo $row['SPrix'] ?></td>
                              <td><?php echo $row['Status'] ?></td>
                              <td><form method="post"><a href="cement_delete.php?No=<?php echo $row['No'] ?>" style="font-size: 19px;font-weight: bold;display: block;" class="text-danger text-center" name="delete" title="Delete Client">&times;</a></form></td>
                            </tr>
                          <?php endwhile ?>
                          </table>
                        <?php endif ?>

                  <!-- Search form -->
                    <?php
                      if (isset($_POST['search'])):
                      ?>
                      <?php
                          $item = $_POST['search'];
                          $sql = $con->Query("SELECT * FROM others WHERE Designation = '$item'");
                       ?>
                      <table class="table table-sm">
                                  <tr class="teal-text">
                                      <th class="text-center">No</th>
                                      <th>Designation</th>
                                      <th>Unit</th>
                                      <th>Qty</th>
                                      <th>Prix</th>
                                      <th>SPrix</th>
                                      <th>Status</th>
                                      <th class="text-center">Action</th>
                                  </tr>
                      <?php while($row = mysqli_fetch_array($sql)):
                              ?>
                        <tr>
                          <td><span style="font-size: 19px;font-weight: bold;display: block; color: #298" data-icon="&#x4e;" class="text-center"></span></td>
                          <td><?php echo $row['Designation'] ?></td>
                          <td><?php echo $row['Unit'] ?></td>
                          <td><?php echo $row['Qty'] ?></td>
                          <td><?php echo $row['Prix'] ?></td>
                          <td><?php echo $row['SPrix'] ?></td>
                          <td><?php echo $row['Status'] ?></td>
                          <td><form method="post"><a href="cement_delete.php?No=<?php echo $row['No'] ?>" style="font-size: 19px;font-weight: bold;display: block;" class="text-danger text-center" name="delete" title="Delete Client">&times;</a></form></td>
                        </tr>
                        <tr>
                          <td colspan="8"><a href="others.php" style="font-size: 19px;font-weight: bold;display: block;" class="text-danger text-center" name="delete" title="Delete Client"><i>Cancel &nbsp;</i></a></form></td>
                        </tr>

                      <?php endwhile ?>
                      </table>
                    <?php endif ?>

                			</p>
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

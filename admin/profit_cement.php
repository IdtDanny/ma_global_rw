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
                            <li><a href="cement.php" class="active">Cement</a></li>
                            <li><a href="others.php">Others</a></li>
                            <li><a href="report.php">Report</a></li>
                            <li><a href="account.php">My Account</a></li>
                            <li><a href="logout.php">Logout</a></li>

                            <!-- reading the and writing the Profit -->
                            <?php
                            $select_cement = $con->Query("SELECT * FROM cement");
                            while ($row = mysqli_fetch_array($select_cement)) {
                              // echo "Hey";
                              $item = $row['Designation'];
                              $unit = $row['Unit'];
                              $Profit_unit = $row['Profit_unit'];
                              $Profit = $row['Profit'];
                              $qty = $row['Qty'];
                              $status = $row['Status'];
                              $date = $row['Date'];
                              $No = $row['No'];

                              $select_profit = $con->query("SELECT * FROM profit_cement WHERE No = '$No'");
                              $count_profit = mysqli_num_rows($select_profit);
                              $count = $count_profit > 0;
                              // Adding profit
                              if (!$count) {
                                // echo "Here";
                                $add_profit = $con -> Query("INSERT INTO `profit_cement`(`Date`, `No`, `Designation`, `Unit`, `Qty`, `Profit_unit`, `Profit`, `Status`)
                                                                         VALUES ('$date' , '$No', '$item', '$unit', '$qty', '$Profit_unit', '$Profit', '$status')
                                                                         ") or die(mysqli_error($con));
                              }
                              else {
                                while ($row_profit = mysqli_fetch_array($select_profit)) {
                                  $update_profit = $con->query("UPDATE profit_cement SET Qty='$qty',Profit_unit='$Profit_unit',Profit='$Profit' WHERE No = '$No'") or die(mysqli_error($con));
                                  $delete_profit = $con->query("DELETE FROM profit_cement WHERE No != '$No'");
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

                	<div class="col-md-12">

                		<div class="row">
                      <div class="col-md-12">
                       <div class="well shadow-sm bg-white p-4">
                         <div class="row">
                           <div class="col md-9">
                  			     <p class="display-4 teal-text">
                  				      Today:
                           </div>
                         </div>
                				<?php
                					$sql = $con->Query("SELECT * FROM cement");
                				?>
                        <table class="table table-sm ">
                                    <tr class="teal-text">
                                        <th>Date</th>
                                        <th>No</th>
                                        <th>Designation</th>
                                        <th>Unit</th>
                                        <th>Qty</th>
                                        <th>Profit_Unit</th>
                                        <th>Profit</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                				<?php while($row = mysqli_fetch_array($sql)):
                                ?>
                					<tr>
                            <td><?php echo $row['Date'] ?></td>
                            <td><span class="fs1" aria-hidden="true" style="font-size: 19px; color:#298;font-weight: bold;" data-icon="&#x4e;" ></span></td>
                						<td><?php echo $row['Designation'] ?></td>
                						<td><?php echo $row['Unit']; ?></td>
                            <td><?php echo $row['Qty'] ?></td>
                            <td><?php echo $row['Profit_unit'] ?></td>
                            <td><?php echo $row['Profit'] ;?></td>
                						<td><?php echo $row['Status'] ;?></td>
                						<td><a href="daily_delete.php?No=<?php echo $row['No'] ?>" style="font-size: 19px;font-weight: bold;display: block;" class="text-danger text-center" title="Delete Client">&times;</a></td>
                					</tr>
                				<?php endwhile ?>
                        <?php
                          $make_sum = $con->Query("SELECT SUM(Profit) AS profit_sum FROM cement");
                        ?>

                        <?php
                          while ($row_total = mysqli_fetch_array($make_sum)):
                         ?>
                         <tr>
                           <td><?php echo "<h3 class='teal-text' style='font-size: 20px;font-weight: bold;'>Grand Total</h3>"; ?></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td><?php echo "<h3 class='teal-text' style='font-size: 17px;font-weight: bold;'>" . $row_total['profit_sum'] ."</h3>"; ?></td>
                         </tr>

                       <?php endwhile ?>
                				</table>
                        <tr colspan="3">
                          <center>
                              <a href="cement.php"><button class="btn btn-sm teal text-white">Return Back</button></a>
                          </center>
                        </tr>
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

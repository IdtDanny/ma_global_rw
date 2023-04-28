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

    # Fetching today table
    $_SESSION['today'];
    $date =  $_SESSION['today'];
    ?>

<?php
  include 'includes/header.php';
 ?>


                    <div class="col-md-10 bg-white">
                        <ul>
                            <li><a href="daily.php">Daily</a></li>
                            <li><a href="cement.php">Cement</a></li>
                            <li><a href="others.php">Others</a></li>
                            <li><a href="expense.php">Expenses</a></li>
                            <li><a href="report.php" class="active">Report</a></li>
                            <li><a href="account.php">My Account</a></li>
                            <li><a href="logout.php">Logout</a></li>
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
                           <div class="col-md-11">
                  			     <p class="display-4 teal-text text-center">
                  				     <!-- Date:  -->
                               <?php echo $date ?>

                           </div>
                           <div class="col-md-1">
                             <form method="POST">
                             <td class="text-center"><button style="border: none; color: none;" class="white" Type="submit" name="getphp" title="download"><div data-icon='&#xe071;' style="font-size: 25px; color:#298;"></div></button></td>
                             </form>
                           </div>
                         </div>
                         <?php
                         $select_report = $con->query("SELECT * FROM `report` WHERE `Date`='$date'");
                         $count_report = mysqli_num_rows($select_report);
                         $count = $count_report > 0;
                         if ($count) {
                           $row_report = mysqli_fetch_assoc($select_report);
                           $row_profit = $row_report['Profit'];
                          $status = "";
                          if ($row_profit < '10000') {
                            $status = "Good";
                            $update_report = $con-> query("UPDATE `report` SET `Status`='$status' WHERE `Profit`='$row_profit'") or die(mysqli_error($con));
                          }
                          elseif ($row_profit > '10000') {
                            $status = "Very Good";
                            $update_report = $con-> query("UPDATE `report` SET `Status`='$status' WHERE `Profit`='$row_profit'") or die(mysqli_error($con));
                          }
                        }
                        ?>
                				<?php
                					$sql = $con->Query("SELECT * FROM `report` WHERE `Date`='$date'");
                				?>
                        <table class="table table-sm ">
                                    <tr class="teal-text">
                                        <th>Date</th>
                                        <th>No</th>
                                        <th>Cement</th>
                                        <th>Others</th>
                                        <th>Profit</th>
                                        <th>Expenses</th>
                                        <th>Remain</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                				<?php while($row = mysqli_fetch_array($sql)):
                                ?>
                					<tr>
                            <td><?php echo $row['Date'] ?></td>
                            <td><span class="fs1" aria-hidden="true" style="font-size: 19px; color:#298;font-weight: bold;" data-icon="&#x4e;" ></span></td>
                						<td><?php echo $row['Cement'] .' Sac' ;?></td>
                						<td><?php echo $row['Others'] .' Rwf'; ?></td>
                            <td><?php echo $row['Profit'] .' Rwf' ;?></td>
                            <td><?php echo $row['Expenses'] .' Rwf' ;?></td>
                            <td><?php echo $row['Remain'] .' Rwf' ;?></td>
                						<td><?php echo $row['Status'] ;?></td>
                						<td><a href="daily_delete.php?No=<?php echo $row['No'] ?>" style="font-size: 19px;font-weight: bold;display: block;" class="text-danger text-center" title="Delete Client">&times;</a></td>
                					</tr>
                				<?php endwhile ?>
                          <tr>
                            <td colspan="9" class="teal-text text-muted text-center" style="font-size: 16px;"><i>Consider the current status</i></td>
                          </tr>

                       <!-- <tr>
                         <td colspan="4"><span class="fs1" aria-hidden="true" style="font-size: 19px; color:#298;font-weight: bold;" data-icon="&#xe071;" title="download"></span</td> -->
                				</table>
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

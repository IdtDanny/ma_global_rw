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
    $select_today = $con -> query( "SELECT * FROM `$date`" ) or die ( mysqli_error($con) );
    ?>

<?php
  include 'includes/header.php';
 ?>


                    <div class="col-md-10 bg-white">
                        <ul>
                            <li><a href="daily.php" class="active">Daily</a></li>
                            <li><a href="cement.php">Cement</a></li>
                            <li><a href="others.php">Others</a></li>
                            <li><a href="expense.php">Expenses</a></li>
                            <li><a href="report.php">Report</a></li>
                            <li><a href="account.php">My Account</a></li>
                            <li><a href="logout.php">Logout</a></li>


                            <!-- downloading the table -->
                            <?php
                             $output = '';
                             if (isset($_POST['getphp'])) {
                               $select_today = $con->query("SELECT * FROM `$date` ORDER BY No DESC") or die(mysqli_error($con));
                               $count_today = mysqli_num_rows($select_today);
                               $count = $count_today > 0;
                               if ($count) {
                                 // echo "hello";
                                 $output .='
                                 <table class="table table-sm">
                                             <tr class="teal-text">
                                                 <th>Date</th>
                                                 <th>No</th>
                                                 <th>Designation</th>
                                            </tr>
                                            ';
                                while ($row = mysqli_fetch_array($select_today)) {
                                  // echo "here";
                                  $output .='
                                            <tr>
                                              <td>'.$row["Date"].'</td>
                                              <td>'.$row["No"].'</td>
                                  						<td>'.$row["Designation"].'</td>
                                  						<td>'.$row["Unit"].'</td>
                                              <td>'.$row["Qty"].'</td>
                                              <td>'.$row["Prix"].'</td>
                                              <td>'.$row["Total"].'</td>
                                  						<td>'.$row["Status"].'</td>
                                  						<td>&times;</td>
                                  					</tr>
                                  ';
                                }
                                $output .='</table>';
                                header("Content-Type: application/xls");
                                header("Content-Disposition:attachment; filename=download.xls");
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
                                <div class="col-md-3">
                                    <input type="text" name="qty" placeholder="Qty" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="prix" placeholder="Prix" class="form-control" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn teal btn-sm white-text" data-icon="&#x4c;" style="font-size: 50px,font-weight: ;margin-left: -3;" name="add_item"></button>
                                </div>
                              </div>
                            </form>
                          </div><br>

                    </div>
                  </div>


                		<div class="row">
                      <div class="col-md-12">
                       <div class="well shadow-sm bg-white p-4">
                         <div class="row">
                           <div class="col-md-4">
                  			     <p class="display-4 teal-text text-center">
                  				     <!-- Date:  -->
                               <?php $date;
                                    $middle = strtotime($date);
                                    echo $new_date = date('F j', $middle);
                                    # echo $new_date = date('D, M j', $middle); ?>
                             </p>
                           </div>
                           <div class="col-md-4">

                             <!-- reading the items -->
                             <?php
                               if (isset($_POST['add_item'])) {
                                 $item = mysqli_real_escape_string($con , $_POST['Designation']);
                                 $Unit = mysqli_real_escape_string($con , $_POST['unit']);
                                 $Qty = mysqli_real_escape_string($con , $_POST['qty']);
                                 $Prix = mysqli_real_escape_string($con , $_POST['prix']);
                                 $type = "";
                                 $status = "";
                                 $Profit_unit;
                                 $Profit;
                                 $Total;

                           $select_today = $con-> Query("SELECT * FROM `$date` WHERE `Designation`='$item' AND `Prix`='$Prix'");
                           $count_today1 = mysqli_num_rows($select_today)>0;
                           # Checking for the item existance for avoiding duplication
                           if (!$count_today1) {
                             $row_update = mysqli_fetch_array($select_today);

                                 if (preg_match_all('/Sac/' , $Unit) || preg_match_all('/Cement(kg)/' , $Unit)){
                                   $select_cement = $con -> Query("SELECT * FROM cement WHERE Designation = '$item'");
                                   $count_cement = mysqli_num_rows($select_cement);

                                   if ($count_cement > 0) {
                                     $row = mysqli_fetch_array($select_cement);
                                   // while($row = mysqli_fetch_array($select_cement)){
                                     $Current_Qty_cement = $row['Qty'];
                                     // $Real_Qty_cement = $Current_Qty_cement - $Qty;
                                     $Current_Prix = $row['Prix'];
                                     $Profit_unit = $Prix - $Current_Prix;
                                     $Profit = $Qty * $Profit_unit;
                                     $Total = $Qty * $Prix;

                                     // checking and updating the cement availability
                                     if ($Current_Qty_cement != '0') {
                                       if ($Current_Qty_cement == $Qty) {
                                           $Real_Qty_cement = $Current_Qty_cement - $Qty;
                                           $status = "Not Available";
                                           $type = "cement";
                                           $add_cement = $con -> Query("INSERT INTO `$date`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `Total`, `Profit`, `Status`, `Type`)
                                                                                    VALUES (NOW() , '$item', '$Unit', '$Qty', '$Prix', '$Total', '$Profit', '$status', '$type')
                                                                                    ") or die(mysqli_error($con));
                                           $update_cement = $con -> Query("UPDATE `cement` SET `Qty`= '$Real_Qty_cement',`Status`= '$status' WHERE Designation = '$item'")
                                                                         or die(mysqli_error($con));

                                                     # Making the daily report
                                                       $select_report = $con->query("SELECT * FROM `report` WHERE `Date`='$date'") or die(mysqli_error($con));
                                                       $count_report = mysqli_num_rows($select_report) > 0;
                                                           if ($count_report) {
                                                                 $row_report = mysqli_fetch_array($select_report);
                                                                 $report_current = $row_report['Cement'];
                                                                 // $report_other = $row_report['Others'];
                                                                 $profit_current = $row_report['Profit'];
                                                                 // $report_expense = $row_report['Expenses'];
                                                                 // $report_status = $row_report['Status'];

                                                                  $new_cement = $report_current + $Qty;
                                                                  $new_profit = $profit_current + $Profit;
                                                                  $update_report = $con->query("UPDATE `report` SET `Cement`='$new_cement',`Profit`='$new_profit' WHERE `Date`='$date'") or die(mysqli_error($con));
                                                               }

                                           # Notifying the user about the transaction
                                           echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Successfully Added &nbsp;&nbsp;<a href='daily.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                           echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 5px; margin-left: 3px; padding: 10px; font-size: 12px;' data-icon='&#x71;'>&nbsp;&nbsp;Not Available in Stock</a></span>";
                                       }
                                       else {
                                         if ($Current_Qty_cement < $Qty) {
                                           echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                           echo "<span class='badge badge-danger white-text ml-3 ' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Only &nbsp;".$Current_Qty_cement."&nbsp;".$Unit."&nbsp;Available&nbsp;&nbsp;<a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                         }
                                         else {
                                           $Real_Qty_cement = $Current_Qty_cement - $Qty;
                                           $status = "Available";
                                           $type = "cement";
                                           $add_cement = $con -> Query("INSERT INTO `$date`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `Total`, `Profit`, `Status`, `Type`)
                                                                                    VALUES (NOW() , '$item', '$Unit', '$Qty', '$Prix', '$Total', '$Profit', '$status', '$type')
                                                                                    ") or die(mysqli_error($con));
                                           $update_cement = $con -> Query("UPDATE `cement` SET `Qty`= '$Real_Qty_cement',`Status`= '$status' WHERE Designation = '$item'")
                                                                         or die(mysqli_error($con));

                                           # Making the daily report
                                           $select_report = $con->query("SELECT * FROM `report` WHERE `Date`='$date'") or die(mysqli_error($con));
                                           $count_report = mysqli_num_rows($select_report) > 0;
                                                 if ($count_report) {
                                                         $row_report = mysqli_fetch_array($select_report);
                                                         $report_current = $row_report['Cement'];
                                                       // $report_other = $row_report['Others'];
                                                         $profit_current = $row_report['Profit'];
                                                         // $report_expense = $row_report['Expenses'];
                                                         // $report_status = $row_report['Status'];

                                                        $new_cement = $report_current + $Qty;
                                                        $new_profit = $profit_current + $Profit;
                                                        $update_report = $con->query("UPDATE `report` SET `Cement`='$new_cement',`Profit`='$new_profit' WHERE `Date`='$date'") or die(mysqli_error($con));
                                                     }


                                           echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                           echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 5px; font-size: 12px;'>Successfully Added &nbsp;&nbsp; <a href='daily.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a><br><br>Remain &nbsp;".$Real_Qty_cement."&nbsp;".$Unit."</span>";
                                         }
                                       }
                                     }
                                     else {
                                       echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                       echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 17px; margin-left: 3px; padding: 8px; font-size: 12px;'>Not Available in Stock &nbsp;&nbsp; <a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                     }
                                   }
                                   else {
                                     echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                     echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 17px; margin-left: 3px; padding: 8px; font-size: 12px;'>Unknown Item &nbsp;&nbsp; <a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                   }
                                 }

                                   // checking and updating the others
                                   else {
                                     $select_others = $con -> Query("SELECT * FROM others WHERE Designation = '$item'");
                                     $count_others = mysqli_num_rows($select_others);

                                     if ($count_others > 0) {
                                       $row = mysqli_fetch_array($select_others);
                                     // while($row = mysqli_fetch_array($select_others)){
                                       $Current_Qty_others = $row['Qty'];
                                       // $Real_Qty_others = $Current_Qty_others - $Qty;
                                       $Current_Prix = $row['Prix'];
                                       $Profit_unit = $Prix - $Current_Prix;
                                       $Profit = $Qty * $Profit_unit;
                                       $Total = $Qty * $Prix;

                                       if ($Unit == $row['Unit'] AND $item = $row['Designation']) {

                                       // checking and updating the availability in the Others Stock
                                       if ($Current_Qty_others != '0') {
                                             if ($Current_Qty_others == $Qty) {
                                                 $Real_Qty_others = $Current_Qty_others - $Qty;
                                                 $status = "Not Available";
                                                 $type = "others";
                                                 $add_others = $con -> Query("INSERT INTO `$date`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `Total`, `Profit`, `Status`, `Type`)
                                                                                          VALUES (NOW() , '$item', '$Unit', '$Qty', '$Prix', '$Total', '$Profit', '$status', '$type')
                                                                                          ") or die(mysqli_error($con));
                                                 $update_others = $con -> Query("UPDATE `others` SET `Qty`= '$Real_Qty_others',`Status`= '$status' WHERE Designation = '$item'")
                                                                               or die(mysqli_error($con));

                                                     # Making the daily report
                                                         $select_report = $con->query("SELECT * FROM `report` WHERE `Date`='$date'") or die(mysqli_error($con));
                                                         $count_report = mysqli_num_rows($select_report) > 0;
                                                               if ($count_report) {
                                                                         $row_report = mysqli_fetch_array($select_report);
                                                                         // $report_current = $row_report['Cement'];
                                                                         $report_current = $row_report['Others'];
                                                                         $profit_current = $row_report['Profit'];
                                                                         // $report_expense = $row_report['Expenses'];
                                                                         // $report_status = $row_report['Status'];

                                                                        $new_other = $report_current + $Total;
                                                                        $new_profit = $profit_current + $Profit;
                                                                      $update_report = $con->query("UPDATE `report` SET `Others`='$new_other',`Profit`='$new_profit' WHERE `Date`='$date'") or die(mysqli_error($con));
                                                                     }

                                                 echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Successfully Added &nbsp;&nbsp;<a href='daily.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                                 echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 5px; margin-left: 3px; padding: 10px; font-size: 12px;' data-icon='&#x71;'>&nbsp;&nbsp;Not Available in Stock</span>";
                                             }
                                             else {
                                               if ($Current_Qty_others < $Qty) {
                                                 echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                 echo "<span class='badge badge-danger white-text ml-3 ' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Only &nbsp;".$Current_Qty_others."&nbsp;".$Unit."&nbsp;Available&nbsp;&nbsp;<a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                               }
                                               else {
                                                 $Real_Qty_others = $Current_Qty_others - $Qty;
                                                 $status = "Available";
                                                 $type = "others";
                                                 $add_others = $con -> Query("INSERT INTO `$date`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `Total`, `Profit`, `Status`, `Type`)
                                                                                          VALUES (NOW() , '$item', '$Unit', '$Qty', '$Prix', '$Total', '$Profit', '$status', '$type')
                                                                                          ") or die(mysqli_error($con));
                                                 $update_others = $con -> Query("UPDATE `others` SET `Qty`= '$Real_Qty_others',`Status`= '$status' WHERE Designation = '$item'")
                                                                               or die(mysqli_error($con));

                                                       # Making the daily report
                                                           $select_report = $con->query("SELECT * FROM `report` WHERE `Date`='$date'") or die(mysqli_error($con));
                                                           $count_report = mysqli_num_rows($select_report) > 0;
                                                               if ($count_report) {
                                                                       $row_report = mysqli_fetch_array($select_report);
                                                                       // $report_current = $row_report['Cement'];
                                                                       $report_current = $row_report['Others'];
                                                                       $profit_current = $row_report['Profit'];
                                                                       // $report_expense = $row_report['Expenses'];
                                                                       // $report_status = $row_report['Status'];

                                                                          $new_other = $report_current + $Total;
                                                                          $new_profit = $profit_current + $Profit;
                                                                      $update_report = $con->query("UPDATE `report` SET `Others`='$new_other',`Profit`='$new_profit' WHERE `Date`='$date'") or die(mysqli_error($con));
                                                                     }

                                                 echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                 echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 5px; font-size: 12px;'>Successfully Added &nbsp;&nbsp; <a href='daily.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a><br><br>Remain &nbsp;".$Real_Qty_others."&nbsp;".$Unit."</span>";
                                               }
                                             }
                                       }
                                       else {
                                         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                         echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 17px; margin-left: 3px; padding: 8px; font-size: 12px;'>Not Available in Stock &nbsp;&nbsp; <a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                       }
                                     }
                                     else {
                                       echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                       echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 17px; margin-left: 3px; padding: 8px; font-size: 12px;'>Unknown Item &nbsp;&nbsp; <a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                     }
                                   }
                                 }
                               }

                             # checking for the item existance
                             else{
                               if (preg_match_all('/Sac/' , $Unit) || preg_match_all('/Cement(kg)/' , $Unit)){
                                 $select_cement = $con -> Query("SELECT * FROM cement WHERE Designation = '$item'");
                                 $count_cement = mysqli_num_rows($select_cement);

                                 if ($count_cement > 0) {
                                   $row = mysqli_fetch_array($select_cement);
                                 // while($row = mysqli_fetch_array($select_cement)){
                                   $Current_Qty_cement = $row['Qty'];
                                   // $Real_Qty_cement = $Current_Qty_cement - $Qty;
                                   $Current_Prix = $row['Prix'];
                                   $Profit_unit = $Prix - $Current_Prix;
                                   $Profit = $Qty * $Profit_unit;
                                   $Total = $Qty * $Prix;

                                   $row_update = mysqli_fetch_array($select_today);

                                   // checking and updating the cement availability
                                   if ($Current_Qty_cement != '0') {
                                     if ($Current_Qty_cement == $Qty) {
                                         $Real_Qty_cement = $Current_Qty_cement - $Qty;
                                         $status = "Not Available";
                                         $type = "cement";

                                         $update_qty = $row_update['Qty'] + $Qty;
                                         $update_total = $row_update['Total'] + $Total;
                                         $update_profit = $row_update['Profit'] + $Profit;
                                         $add_cement = $con -> Query("UPDATE `$date` SET `Qty`='$update_qty',`Prix`='$Prix',`Total`='$update_total',`Profit`='$update_profit',`Status`='$status',`Type`='$type' WHERE Designation = '$item'
                                                                     ") or die(mysqli_error($con));
                                         $update_cement = $con -> Query("UPDATE `cement` SET `Qty`= '$Real_Qty_cement',`Status`= '$status' WHERE Designation = '$item'")
                                                                       or die(mysqli_error($con));

                                                   # Making the daily report
                                                     $select_report = $con->query("SELECT * FROM `report` WHERE `Date`='$date'") or die(mysqli_error($con));
                                                     $count_report = mysqli_num_rows($select_report) > 0;
                                                         if ($count_report) {
                                                               $row_report = mysqli_fetch_array($select_report);
                                                               $report_current = $row_report['Cement'];
                                                               // $report_other = $row_report['Others'];
                                                               $profit_current = $row_report['Profit'];
                                                               // $report_expense = $row_report['Expenses'];
                                                               // $report_status = $row_report['Status'];

                                                                $new_cement = $report_current + $Qty;
                                                                $new_profit = $profit_current + $Profit;
                                                                $update_report = $con->query("UPDATE `report` SET `Cement`='$new_cement',`Profit`='$new_profit' WHERE `Date`='$date'") or die(mysqli_error($con));
                                                             }

                                         # Notifying the user about the transaction
                                         echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Successfully Added &nbsp;&nbsp;<a href='daily.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                         echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 5px; margin-left: 3px; padding: 10px; font-size: 12px;' data-icon='&#x71;'>&nbsp;&nbsp;Not Available in Stock</a></span>";
                                     }
                                     else {
                                       if ($Current_Qty_cement < $Qty) {
                                         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                         echo "<span class='badge badge-danger white-text ml-3 ' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Only &nbsp;".$Current_Qty_cement."&nbsp;".$Unit."&nbsp;Available&nbsp;&nbsp;<a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                       }
                                       else {
                                         $Real_Qty_cement = $Current_Qty_cement - $Qty;
                                         $status = "Available";
                                         $type = "cement";
                                         $update_qty = $row_update['Qty'] + $Qty;
                                         $update_total = $row_update['Total'] + $Total;
                                         $update_profit = $row_update['Profit'] + $Profit;
                                         $add_cement = $con -> Query("UPDATE `$date` SET `Qty`='$update_qty',`Prix`='$Prix',`Total`='$update_total',`Profit`='$update_profit',`Status`='$status',`Type`='$type' WHERE Designation = '$item'
                                                                     ") or die(mysqli_error($con));
                                         $update_cement = $con -> Query("UPDATE `cement` SET `Qty`= '$Real_Qty_cement',`Status`= '$status' WHERE Designation = '$item'")
                                                                       or die(mysqli_error($con));

                                         # Making the daily report
                                         $select_report = $con->query("SELECT * FROM `report` WHERE `Date`='$date'") or die(mysqli_error($con));
                                         $count_report = mysqli_num_rows($select_report) > 0;
                                               if ($count_report) {
                                                       $row_report = mysqli_fetch_array($select_report);
                                                       $report_current = $row_report['Cement'];
                                                     // $report_other = $row_report['Others'];
                                                       $profit_current = $row_report['Profit'];
                                                       // $report_expense = $row_report['Expenses'];
                                                       // $report_status = $row_report['Status'];

                                                      $new_cement = $report_current + $Qty;
                                                      $new_profit = $profit_current + $Profit;
                                                      $update_report = $con->query("UPDATE `report` SET `Cement`='$new_cement',`Profit`='$new_profit' WHERE `Date`='$date'") or die(mysqli_error($con));
                                                   }


                                         echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                         echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 5px; font-size: 12px;'>Successfully Added &nbsp;&nbsp; <a href='daily.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a><br><br>Remain &nbsp;".$Real_Qty_cement."&nbsp;".$Unit."</span>";
                                       }
                                     }
                                   }
                                   else {
                                     echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                     echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 17px; margin-left: 3px; padding: 8px; font-size: 12px;'>Not Available in Stock &nbsp;&nbsp; <a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                   }
                                 }
                                 else {
                                   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                   echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 17px; margin-left: 3px; padding: 8px; font-size: 12px;'>Unknown Item &nbsp;&nbsp; <a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                 }
                               }

                                 // checking and updating the others
                                 else {
                                   $select_others = $con -> Query("SELECT * FROM others WHERE Designation = '$item'");
                                   $count_others = mysqli_num_rows($select_others);

                                   if ($count_others > 0) {
                                     $row = mysqli_fetch_array($select_others);
                                   // while($row = mysqli_fetch_array($select_others)){
                                     $Current_Qty_others = $row['Qty'];
                                     // $Real_Qty_others = $Current_Qty_others - $Qty;
                                     $Current_Prix = $row['Prix'];
                                     $Profit_unit = $Prix - $Current_Prix;
                                     $Profit = $Qty * $Profit_unit;
                                     $Total = $Qty * $Prix;

                                     $row_update = mysqli_fetch_array($select_today);

                                     if ($Unit == $row['Unit'] AND $item = $row['Designation']) {

                                     // checking and updating the availability in the Others Stock
                                     if ($Current_Qty_others != '0') {
                                           if ($Current_Qty_others == $Qty) {
                                               $Real_Qty_others = $Current_Qty_others - $Qty;
                                               $status = "Not Available";
                                               $type = "others";

                                               $update_qty = $row_update['Qty'] + $Qty;
                                               $update_total = $row_update['Total'] + $Total;
                                               $update_profit = $row_update['Profit'] + $Profit;
                                               $add_others = $con -> Query("UPDATE `$date` SET `Qty`='$update_qty',`Prix`='$Prix',`Total`='$update_total',`Profit`='$update_profit',`Status`='$status',`Type`='$type' WHERE Designation = '$item'
                                                                           ") or die(mysqli_error($con));

                                               $update_others = $con -> Query("UPDATE `others` SET `Qty`= '$Real_Qty_others',`Status`= '$status' WHERE Designation = '$item'")
                                                                             or die(mysqli_error($con));

                                                   # Making the daily report
                                                       $select_report = $con->query("SELECT * FROM `report` WHERE `Date`='$date'") or die(mysqli_error($con));
                                                       $count_report = mysqli_num_rows($select_report) > 0;
                                                             if ($count_report) {
                                                                       $row_report = mysqli_fetch_array($select_report);
                                                                       // $report_current = $row_report['Cement'];
                                                                       $report_current = $row_report['Others'];
                                                                       $profit_current = $row_report['Profit'];
                                                                       // $report_expense = $row_report['Expenses'];
                                                                       // $report_status = $row_report['Status'];

                                                                      $new_other = $report_current + $Total;
                                                                      $new_profit = $profit_current + $Profit;
                                                                    $update_report = $con->query("UPDATE `report` SET `Others`='$new_other',`Profit`='$new_profit' WHERE `Date`='$date'") or die(mysqli_error($con));
                                                                   }

                                               echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Successfully Added &nbsp;&nbsp;<a href='daily.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                               echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 5px; margin-left: 3px; padding: 10px; font-size: 12px;' data-icon='&#x71;'>&nbsp;&nbsp;Not Available in Stock</span>";
                                           }
                                           else {
                                             if ($Current_Qty_others < $Qty) {
                                               echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                               echo "<span class='badge badge-danger white-text ml-3 ' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Only &nbsp;".$Current_Qty_others."&nbsp;".$Unit."&nbsp;Available&nbsp;&nbsp;<a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                             }
                                             else {
                                               $Real_Qty_others = $Current_Qty_others - $Qty;
                                               $status = "Available";
                                               $type = "others";

                                               $update_qty = $row_update['Qty'] + $Qty;
                                               $update_total = $row_update['Total'] + $Total;
                                               $update_profit = $row_update['Profit'] + $Profit;
                                               $add_others = $con -> Query("UPDATE `$date` SET `Qty`='$update_qty',`Prix`='$Prix',`Total`='$update_total',`Profit`='$update_profit',`Status`='$status',`Type`='$type' WHERE Designation = '$item'
                                                                           ") or die(mysqli_error($con));
                                               $update_others = $con -> Query("UPDATE `others` SET `Qty`= '$Real_Qty_others',`Status`= '$status' WHERE Designation = '$item'")
                                                                             or die(mysqli_error($con));

                                                     # Making the daily report
                                                         $select_report = $con->query("SELECT * FROM `report` WHERE `Date`='$date'") or die(mysqli_error($con));
                                                         $count_report = mysqli_num_rows($select_report) > 0;
                                                             if ($count_report) {
                                                                     $row_report = mysqli_fetch_array($select_report);
                                                                     // $report_current = $row_report['Cement'];
                                                                     $report_current = $row_report['Others'];
                                                                     $profit_current = $row_report['Profit'];
                                                                     // $report_expense = $row_report['Expenses'];
                                                                     // $report_status = $row_report['Status'];

                                                                        $new_other = $report_current + $Total;
                                                                        $new_profit = $profit_current + $Profit;
                                                                    $update_report = $con->query("UPDATE `report` SET `Others`='$new_other',`Profit`='$new_profit' WHERE `Date`='$date'") or die(mysqli_error($con));
                                                                   }

                                               echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                               echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 5px; font-size: 12px;'>Successfully Added &nbsp;&nbsp; <a href='daily.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a><br><br>Remain &nbsp;".$Real_Qty_others."&nbsp;".$Unit."</span>";
                                             }
                                           }
                                     }
                                     else {
                                       echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                       echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 17px; margin-left: 3px; padding: 8px; font-size: 12px;'>Not Available in Stock &nbsp;&nbsp; <a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                     }
                                   }
                                   else {
                                     echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                     echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 17px; margin-left: 3px; padding: 8px; font-size: 12px;'>Unknown Item &nbsp;&nbsp; <a href='daily.php' data-icon='&#x71;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                   }
                                 }
                               }
                             }
                           }

                                     // if ($Real_Qty_cement > "0") {
                                     //   $status = "Available";
                                     //   $type = "cement";
                                     //   $add_cement = $con -> Query("INSERT INTO `daily`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `Total`, `Profit`, `Status`, `Type`)
                                     //                                            VALUES (NOW() , '$item', '$Unit', '$Qty', '$Prix', '$Total', '$Profit', '$status', '$type')
                                     //                                            ") or die(mysqli_error($con));
                                     //   $update_cement = $con -> Query("UPDATE `cement` SET `Qty`= '$Real_Qty_cement',`Status`= '$status' WHERE Designation = '$item'")
                                     //                                 or die(mysqli_error($con));
                                     //   echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Successfully Added ~ <a href='index.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                                     // }
                                     // elseif ($Real_Qty_cement < "0") {
                                     //   $status = "Not Available";
                                     //   $Real_Qty_cement = "0";
                                     //   // $add_cement = $con -> Query("INSERT INTO `daily`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `Total`, `Profit`, `Status`, `Type`)
                                     //   //                                          VALUES (NOW() , '$item', '$Unit', '$Qty', '$Prix', '$Total', '$Profit', '$status', '$type')
                                     //   //                                          ") or die(mysqli_error($con));
                                     //   $update_cement = $con -> Query("UPDATE `cement` SET `Qty`= '$Real_Qty_cement',`Status`= '$status' WHERE Designation = '$item'")
                                     //                                 or die(mysqli_error($con));
                                     //   echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 10px;'>Not Available ~ <a href='index.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px;'></a></span>";
                                     // }
                                 //   }
                                 // }

                                 // // checking and updating the others
                                 // else {
                                 //   $select_others = $con -> Query("SELECT * FROM others WHERE Designation = '$item'");
                                 //
                                 //   while($row = mysqli_fetch_array($select_others)){
                                 //     $Current_Qty_others = $row['Qty'];
                                 //     $Real_Qty_others = $Current_Qty_others - $Qty;
                                 //     $Current_Prix = $row['Prix'];
                                 //     $Profit_unit = $Prix - $Current_Prix;
                                 //     $Profit = $Qty * $Profit_unit;
                                 //     $Total = $Qty * $Prix;
                                 //
                                 //     // checking and updating the availability in the Others Stock
                             //         if ($Real_Qty_others > "0") {
                             //           $status = "Available";
                             //           $type = "other";
                             //           $add_others = $con -> Query("INSERT INTO `daily`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `Total`, `Profit`, `Status`, `Type`)
                             //                                                    VALUES (NOW() , '$item', '$Unit', '$Qty', '$Prix', '$Total', '$Profit', '$status', '$type')
                             //                                                    ") or die(mysqli_error($con));
                             //           $update_others = $con -> Query("UPDATE `others` SET `Qty`= '$Real_Qty_others',`Status`= '$status' WHERE Designation = '$item'")
                             //                                         or die(mysqli_error($con));
                             //           echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Successfully Added ~ <a href='index.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                             //         }
                             //         elseif ($Real_Qty_others <= "0") {
                             //           $Real_Qty_others = "0";
                             //           $status = "Not Available";
                             //           // $add_others = $con -> Query("INSERT INTO `daily`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `Total`, `Profit`, `Status`, `Type`)
                             //           //                                          VALUES (NOW() , '$item', '$Unit', '$Qty', '$Prix', '$Total', '$Profit', '$status', '$type')
                             //           //                                          ") or die(mysqli_error($con));
                             //           $update_others = $con -> Query("UPDATE `others` SET `Qty`= '$Real_Qty_others',`Status`= '$status' WHERE Designation = '$item'")
                             //                                         or die(mysqli_error($con));
                             //           echo "<span class='badge badge-danger white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 10px;'>Not Available ~ <a href='index.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px;'></a></span>";
                             //       }
                             //     }
                             //   }
                             // }
                         ?>
                           </div>
                           <div class="col-md-3">
                             <form method="post">
                                 <div class="form-group"><br>
                                     <input type="text" name="search" class="form-control" placeholder="Search Item">
                                 </div>
                             </form>
                           </div>
                           <div class="col-md-1"><br>
                             <span class="fs1 ml-3" aria-hidden="true" style="font-size: 30px; color:#A35448;font-weight: bold;" data-icon="&#xe050;" id="withdraw_btn" title="Add Item"></span>
                           </div>
                         </div>

                        <?php if (!isset($_POST['search'])): ?>

                				<?php
                					$sql = $con->Query("SELECT * FROM `$date`");
                        #  $sql = $con->Query("SELECT * FROM `$date` WHERE `Designation` = '$search' ");
                				?>
                        <table class="table table-sm ">
                                    <tr class="teal-text">
                                        <th>Date</th>
                                        <th>No</th>
                                        <th>Designation</th>
                                        <th>Unit</th>
                                        <th>Qty</th>
                                        <th>Prix</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                				<?php while($row = mysqli_fetch_array($sql)):
                                ?>
                					<tr>
                            <td><?php echo $row['Date'] ?></td>
                            <td><span class="fs1" aria-hidden="true" style="font-size: 19px; color:#A35448;font-weight: bold;" data-icon="&#x4e;" ></span></td>
                						<td><?php echo $row['Designation'] ;?></td>
                						<td><?php echo $row['Unit']; ?></td>
                            <td><?php echo $row['Qty'] ;?></td>
                            <td><?php echo $row['Prix'] ;?></td>
                            <td><?php echo $row['Total'] ;?></td>
                						<td><?php echo $row['Status'] ;?></td>
                						<td><a href="daily_delete.php?No=<?php echo $row['No'] ?>" style="font-size: 19px;font-weight: bold;display: block;" class="text-danger text-center" title="Delete Item">&times;</a></td>
                					</tr>
                				<?php endwhile ?>
                        <?php
                          $sum_total = $con-> Query("SELECT SUM(Total) AS total_sum FROM `$date`");
                          $sum_profit = $con-> Query("SELECT SUM(Profit) AS total_profit FROM `$date`");
                        ?>

                        <?php
                          while (($row_total = mysqli_fetch_array($sum_total)) && ($row_profit = mysqli_fetch_array($sum_profit))):
                         ?>
                         <tr>
                           <td><?php echo "<h3 class='teal-text' style='font-size: 20px;font-weight: bold;'>Grand Total</h3>"; ?></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td><?php echo "<h3 class='teal-text' style='font-size: 17px;font-weight: bold;'>" . $row_total['total_sum'] ."</h3>"; ?></td>
                           <td></td>
                           <form method="POST">
                           <td class="text-center"><button style="border: none; color: none;" class="white" Type="submit" name="getphp" title="download"><div data-icon='&#xe071;' style="font-size: 25px; color:#A35448;"></div></button></td>
                           </form>
                         </tr>

                       <?php endwhile ?>
                       <!-- <tr>
                         <td colspan="4"><span class="fs1" aria-hidden="true" style="font-size: 19px; color:#A35448;font-weight: bold;" data-icon="&#xe071;" title="download"></span</td> -->
                				</table>
                      <?php endif ?>

                      <!-- Search form -->
                      <?php if (isset($_POST['search'])): ?>

                      <?php
                      #  $sql = $con->Query("SELECT * FROM `$date`");
                        $search = $_POST['search'];
                        $sql = $con->Query("SELECT * FROM `$date` WHERE `Designation` = '$search' ");
                      ?>
                      <table class="table table-sm ">
                                  <tr class="teal-text">
                                      <th>Date</th>
                                      <th>No</th>
                                      <th>Designation</th>
                                      <th>Unit</th>
                                      <th>Qty</th>
                                      <th>Prix</th>
                                      <th>Total</th>
                                      <th>Status</th>
                                      <th class="text-center">Action</th>
                                  </tr>
                      <?php while($row = mysqli_fetch_array($sql)):
                              ?>
                        <tr>
                          <td><?php echo $row['Date'] ?></td>
                          <td><span class="fs1" aria-hidden="true" style="font-size: 19px; color:#A35448;font-weight: bold;" data-icon="&#x4e;" ></span></td>
                          <td><?php echo $row['Designation'] ;?></td>
                          <td><?php echo $row['Unit']; ?></td>
                          <td><?php echo $row['Qty'] ;?></td>
                          <td><?php echo $row['Prix'] ;?></td>
                          <td><?php echo $row['Total'] ;?></td>
                          <td><?php echo $row['Status'] ;?></td>
                          <td><a href="daily_delete.php?No=<?php echo $row['No'] ?>" style="font-size: 19px;font-weight: bold;display: block;" class="text-danger text-center" title="Delete Item">&times;</a></td>
                        </tr>
                      <?php endwhile ?>
                      <tr>
                        <td colspan="8"><a href="daily.php" style="font-size: 19px;font-weight: bold;display: block;" class="text-danger text-center" name="delete" title="Delete Item"><i>Cancel &nbsp;</i></a></form></td>
                      </tr>
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

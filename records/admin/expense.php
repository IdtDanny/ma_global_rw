
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
                            <li><a href="expense.php" class="active">Expenses</a></li>
                            <li><a href="report.php">Report</a></li>
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
                      <div class="col-md-3"></div>
                      <div class="col-md-6">
                        <div class="well shadow-sm bg-white p-4">
                   			     <p class="display-4 teal-text text-center">
                   				     <!-- Date:  -->
                                <?php #echo $date ?>Expenses</p><hr>
                                <form method="post" enctype="multipart/form-data">
                                  <div class="row">
                                    <div class="col">
                                      <input type="number" class="form-control" placeholder="Daily Expenses" name="expense" required>
                                    </div>
                                    <div class="col">
                                      <input type="text" class="form-control" value="<?php $date;
                                           $middle = strtotime($date);
                                           echo $new_date = date('F j, Y', $middle);
                                           # echo $new_date = date('D, M j', $middle); ?>" name="date" readonly>
                                    </div>
                                  </div><br>
                                  <textarea class="form-control" name="description" placeholder="Description"></textarea><br>
                                  <input type="submit" class="btn btn-sm teal white-text" value="Submit" name="add_expense">
                                  <a href="" class="btn btn-sm teal white-text ml-3" name="review" title="Review The expenses">Review</a>
                                </form>
                   </div>
                <br><br>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="text-muted text-center">Copyright &copy; 2020</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">

              <?php
                if (isset($_POST['add_expense'])) {
                  $expense = $_POST['expense'];
                  $date;
                  $item = $_POST['description'];

                  $sql = $con->query("SELECT * FROM report WHERE `Date` = '$date'");
                  if ($sql) {
                  $insert_expense = $con->query("INSERT INTO expenses (`Date`, `Amount`, `Description`, `Reported By`)
                                                                VALUES ('$date','$expense','$item','$username')") or die(mysqli_error($con));
                  $row = mysqli_fetch_assoc($sql);
                  $old_expense = $row['Expenses'];
                  $Profit = $row['Profit'];
                  $new_expense = $old_expense + $expense;
                  $remain = $Profit - $new_expense;
                  if ($remain < '5000') {
                    $status = "Bad";
                    $update_expense = $con->query("UPDATE report SET `Expenses`='$new_expense',`Remain`='$remain',`Status`='$status' WHERE `Date`='$date'")
                                                    or die(mysqli_error($con));
                  }
                  elseif ($remain > '5000') {
                    $status = "Good";
                    $update_expense = $con->query("UPDATE report SET `Expenses`='$new_expense',`Remain`='$remain',`Status`='$status' WHERE `Date`='$date'")
                                                    or die(mysqli_error($con));
                  }
                  elseif ($remain > '10000') {
                    $status = "Success";
                    $update_expense = $con->query("UPDATE report SET `Expenses`='$new_expense',`Remain`='$remain',`Status`='$status' WHERE `Date`='$date'")
                                                    or die(mysqli_error($con));
                  }
                  // $update_expense = $con->query("UPDATE report SET `Expenses`='$new_expense',`Remain`='',`Status`='' WHERE `Date`='$date'")
                  //                                 or die(mysqli_error($con));
                  if ($insert_expense) {
                    echo "<span class='badge teal white-text ml-3' style='margin-top: 18px; margin-left: 3px; padding: 10px; font-size: 12px;'>Recorded &nbsp;&nbsp;<a href='expense.php' data-icon='&#x40;' class='fs1 white-text' style='font-size: 15px; margin-top: -5px;'></a></span>";
                    }
                  }
                  // else {
                    // $row = mysqli_fetch_assoc($sql);
                    // $amount = $row['Amount'];
                    // $new_expense = $amount + $expense;
                    // $update = $con->query("UPDATE expenses SET `Amount`='$new_expense' WHERE `Description`='$item'")or die(mysqli_error($con));
                  // }
                }
               ?>

            </div>
        </div>
    </div>
</body>
<script src="../assets/main.js"></script>
</html>

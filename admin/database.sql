ALTER TABLE `daily` ADD `Unit` VARCHAR(255) NOT NULL AFTER `Designation`;

//for adding item into Database
<?php
include '../assets/connection/connection.php';
  if (isset($_POST['add_user'])) {
    $item = $_POST['Designation'];
    $Unit = $_POST['unit'];
    $Qty = $_POST['qty'];
    $Prix = $_POST['prix'];
    $SPrix = $_POST['sprix'];
    $Profit_unit = $SPrix - $Prix;
    $Profit = $Profit_unit * $Qty;
    $type = "cement";
    $status = "Available";

    $sql = $con -> Query("INSERT INTO `cement`(`Date`, `Designation`, `Unit`, `Qty`, `Prix`, `SPrix`, `Profit_unit`, `Profit`, `Status`, `Type`)
                                             VALUES (NOW() , '$item', '$Unit', '$Qty', '$Prix', '$SPrix', '$Profit_unit', '$Profit', '$type', '$status')
                                             ") or die(mysqli_error($con));

                                             if ($sql) {
                                               echo "Added";
                                             }
                                             else {
                                               echo "Not added";
                                             }
  }
 ?>

 CREATE TABLE (
   Date DATE,
   No INT(255),
   Designation VARCHAR(255),
   Unit VARCHAR(255),
   Qty INT(255),
   Prix INT(255),
   Total INT(255),
   Profit INT(255),
   Status TEXT(255),
   Type VARCHAR(255)

 CREATE TABLE profit_other(
   Date DATE,
   Designation VARCHAR(255) NOT NULL,
   Unit VARCHAR(255),
   Qty INT(255) NOT NULL,
   Profit_unit INT(255) NOT NULL,
   Profit INT(255) NOT NULL,
   Status VARCHAR(255) NOT NULL
  );

  CREATE TABLE profit_cement(
    Date DATE,
    Designation VARCHAR(255) NOT NULL,
    Unit VARCHAR(255),
    Qty INT(255) NOT NULL,
    Profit_unit INT(255) NOT NULL,
    Profit INT(255) NOT NULL,
    Status VARCHAR(255) NOT NULL
   );

ALTER TABLE payment RENAME TO profit_others;




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
                                   )
                                   ") or die(mysqli_error($con));

   $make_report = $con -> query("INSERT INTO `report`(`Date`) VALUES('$date')") or die(mysqli_error($con));

    $page='daily.php';
    $_SESSION['today']=$date;

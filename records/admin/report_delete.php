<?php
	include '../assets/connection/connection.php';
	echo $No = $_GET['No'];
	$query = $con->query("DELETE FROM `report` WHERE `No` = '$No'") or die(mysqli_error($con));
	if ($query) {
		header("location:report.php");
	}
	else{
		echo "Not Deleted";
	}
?>

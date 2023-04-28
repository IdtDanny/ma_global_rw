<?php
	include '../assets/connection/connection.php';
	$No = $_GET['No'];
	$query = $con->query("DELETE FROM cement WHERE No = '$No'") or die(mysqli_error($con));
	if ($query) {
		header("location:cement.php");
	}
	else{
		echo "Not Deleted";
	}
?>

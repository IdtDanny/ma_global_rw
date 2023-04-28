<?php
session_start();
	include '../assets/connection/connection.php';
	$_SESSION['today'];
	$date =  $_SESSION['today'];

	$No = $_GET['No'];
	$query = $con->query("DELETE FROM `$date` WHERE No = '$No'");
	if ($query) {
		header("location:daily.php");
	}
	else{
		echo "Not Deleted";
	}
?>

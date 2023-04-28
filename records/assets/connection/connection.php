<?php


	$server="127.0.0.1";
	$username="root";
	$password="";
	$db="ma_group";

	$con = mysqli_connect($server,$username,$password,$db);


	if (!$con){
		echo "Not Connected";
	}

	#mysqli_close($con);
?>

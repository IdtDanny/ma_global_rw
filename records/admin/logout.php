<?php  
	session_start();
	if (isset($_SESSION['login_var'])) {
		session_destroy();
	}
	header('location:../index.php');
?>
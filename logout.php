<?php
	session_start();
	unset($_SESSION['login']);
	unset($_SESSION['username']);
	unset($_SESSION['userID']);
	session_destroy();
	header('Location: /100Fruity/login.php');
	exit();
?>

<?php
	if (!isset($_SESSION)){
		session_start();
	}
	 
	if (!isset($_SESSION["login"]) || $_SESSION["login"]!=1) {
		header('Location: login.php');
		exit;
    }
	 
	 $userName=@$_SESSION["user"];
	 include '../user/'.$userName.'/settings.php';
?>
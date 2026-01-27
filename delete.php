<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd” encoding="UTF-8">
<?php
	include('auth.php');
	$path = "../user/" . $userName . "/";
	echo "<div class=\"container\">";
	for($i = 0; $i < sizeof($_POST["deleteFiles"]); $i++){
		$_=preg_split("/\//",$_POST["deleteFiles"][$i]);
		if(!@unlink($path . $_POST["deleteFiles"][$i])){
			echo "<div class=\"alert alert-danger\" role=\"alert\">" . "error deleting " . $_[1] . "</div>";
		}else{
			echo "<div class=\"alert alert-success\" role=\"alert\">" . $_[1] . " deleted.</div>";
		}
	}
	echo "</div>";
	include('CrossVis.php');
?>
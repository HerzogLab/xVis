<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd” encoding="UTF-8">
<?php
	include('auth.php');
	$path = "../user/" . $userName;
	switch ($_POST["fileTyp"]){ 
		case "xQuestFile" :
			$path .= "/xQuestFiles/";
			break;
		case "domainFile" :
			$path .= "/domainFiles/";
			break;
		case "peptideLengthsFile":
			$path .= "/peptideLengthsFiles/";
	};
	echo "<div class=\"container\">";
	for($i = 0; $i < sizeof($_FILES ["files"]["error"]); $i++){
		if($_FILES ["files"]["error"][$i] == 0){
			if (file_exists($path . $_FILES["files"]["name"][$i])){
				echo "<div class=\"alert alert-success\" role=\"alert\">" . $_FILES["files"]["name"][$i] . " updated.</div>";
			}else{
				echo "<div class=\"alert alert-success\" role=\"alert\">" . $_FILES["files"]["name"][$i] . " uploaded.</div>";
			}	
			move_uploaded_file($_FILES["files"]["tmp_name"][$i],
				$path . $_FILES["files"]["name"][$i]);
		}else{
			echo "<div class=\"alert alert-danger\" role=\"alert\">" . $_FILES ["files"]["error"][$i]. "</div>";
		} 
	}
	echo "</div>";
	include("CrossVis.php"); 
?>
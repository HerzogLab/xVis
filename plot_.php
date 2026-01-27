<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Transitional//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd” encoding="UTF-8">

<?php
	session_start();
	if(isset($_FILES ["xQuestFile"]) && $_FILES ["xQuestFile"]["error"][0] == 0){	
		move_uploaded_file($_FILES["xQuestFile"]["tmp_name"][0],
		"../tmp/" . strval($_SESSION["FilePrev"]) . "xQuestFile");
	}
	if(isset($_FILES ["domainFile"]) && $_FILES ["domainFile"]["error"][0] == 0){	
		move_uploaded_file($_FILES["domainFile"]["tmp_name"][0],
		"../tmp/" . strval($_SESSION["FilePrev"]) . "domainFile");
	}
	if(isSet($_FILES ["peptideLengths"]) && $_FILES ["peptideLengths"]["error"][0] == 0){	
		move_uploaded_file($_FILES["peptideLengths"]["tmp_name"][0],
		"../tmp/" . strval($_SESSION["FilePrev"]) . "peptideLengths");
	}
	
	include 'plot.php';
?>
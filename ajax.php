<?php
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION['loginAsUser'])){
		if($_GET["ftype"] == "xQuestFile" && ! file_exists("../tmp/" . strval($_SESSION["FilePrev"]) . $_GET["ftype"])){
			$content = @file_get_contents("./docs/INO80 crosslink file.csv");
			echo $content;
		}else{
			$content = @file_get_contents("../tmp/" . strval($_SESSION["FilePrev"]) . $_GET["ftype"]);
			echo $content;
			@unlink("../tmp/" . strval($_SESSION["FilePrev"]) . $_GET["ftype"]);
		}
		exit;
	}

	include('auth.php');
	
	$path = "../user/" . $_SESSION['user'];
	
	function sendError() {
		header("HTTP/1.0 404 Not Found");
		exit;
	}
	
	if(array_key_exists("ftype", $_GET) == false || array_key_exists("file", $_GET) == false)
	{
		sendError();
	}
	
	switch ($_GET["ftype"]){ 
		case "xQuestFile" :
			$path .= "/xQuestFiles/";
			break;
		case "domainFile" :
			$path .= "/domainFiles/";
			break;
		case "peptideLengthsFile":
			$path .= "/peptideLengthsFiles/";
		default:
			sendError();
	};
	
	$path .= $_GET["file"];
	
	if(file_exists($path) == true) {
		$content = file_get_contents($path);
		echo $content;
		exit;
	}
	else {
		sendError();
	}
?>
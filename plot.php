<?php
	include('convertConsurfFiles.php');
	if(isset($_POST["plotTyp"])){
		switch($_POST["plotTyp"]){
			case "circularPlot" :
				include('circularPlot.php');
				break;
			case "barPlot" :
				include('barPlot.php');
				break;
			case "networkPlot" :
				include('networkPlot.php');
				break;
		}
	}
?>

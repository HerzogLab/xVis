<?php
    session_start();
    session_destroy();

    $hostname = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['PHP_SELF']);

	/* foreach(scandir('../tmp/'.$_SESSION["tmp"]) as $file){
		 echo unlink('../tmp/'.$_SESSION["tmp"]."/".$file);
	 }*/
    header('Location: login.php');
?>
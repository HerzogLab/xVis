<?php
	include('auth.php');
	echo "<div class=\"container\">";
	if (is_dir('../user/'.$_POST["name"])){
		$file = file('../user/' . $_POST["name"] . "/pwd.php");
		if ($handle = fopen('../user/' . $_POST["name"] . "/pwd.php", "w")){
			fwrite($handle, "<?php\n\$username = \"" . $_POST["name"] . "\";\n\$password = \"" . $_POST["pwd"] . "\";\n" . $file[3]);
		}
		fclose($handle);
		echo "<div class=\"alert alert-success\" role=\"alert\">" . $_POST["name"] . " password changed.</div></div>";
		@include("settings.php");
	}else{
		echo "<div class=\"alert alert-danger\" role=\"alert\">User doesn't exist.</div></div>";
		@include("settings.php");
	}
	
?>
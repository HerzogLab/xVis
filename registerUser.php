<?php
	include('auth.php');
	echo "<div class=\"container\">";
	if (!is_dir('../user/' . $_POST["name"])){
		mkdir('../user/' . $_POST["name"]);
		mkdir('../user/' . $_POST["name"] . '/xQuestFiles');
		mkdir('../user/' . $_POST["name"] . '/peptideLengthsFiles');
		mkdir('../user/' . $_POST["name"] . '/domainFiles');
		if ($handle =fopen('../user/'.$_POST["name"] . "/.htaccess", "w")){
			fwrite($handle,"Order deny,allow\nDeny from all");
		}
		if ($handle =fopen('../user/'.$_POST["name"] . "/pwd.php", "w")){
			fwrite($handle,"<?php\n\$username = \"" . $_POST["name"] . "\";\n\$password = \"" . $_POST["pwd"] . "\";\n\$admin = \"" . (isset($_POST["admin"]) ? $_POST["admin"] : "") . '"?>');
		}
		if ($handle =fopen('../user/' . $_POST["name"] . "/settings.php", "w")){
			fwrite($handle,'<?php $domainURLXQuestServer=""; $idXQuestUser=""; $scoreColumn=""; $scoreDirection="<"?>');
		}
		fclose($handle);
		echo "<div class=\"alert alert-success\" role=\"alert\">" . $_POST["name"] . " registered.</div></div>";
		@include("settings.php");
	}else{
		echo "<div class=\"alert alert-danger\" role=\"alert\">Choose another user name.</div></div>";
		@include("settings.php");
	}
?>
<?php
	include('auth.php');
	$_ = "\n\t";
	if(isset($_POST["xQuest"])){
		unset($_POST["xQuest"]);
		if ($handle =fopen("../user/" . $userName . "/settings.php", "w")){
			$settingsFile='<?php ' . $_.
						'$domainURLXQuestServer="'.$_POST["domainURLXQuestServer"] . '";' . $_.
						'$idXQuestUser="' . $_POST["idXQuestUser"] . '";' . $_.
						'$scoreColumn="' . $scoreColumn . '";' . $_.
						'$scoreDirection="' . $scoreDirection.'";' . "\n".
						'?>';
			fwrite($handle,$settingsFile);
			fclose($handle);
		}
	}else if(isset($_POST["CrossVis"])){
		unset($_POST["CrossVis"]);
		if ($handle =fopen("../user/" . $userName . "/settings.php", "w")){
			$settingsFile='<?php ' . $_.
						'$domainURLXQuestServer="'.$domainURLXQuestServer . '";' . $_.
						'$idXQuestUser="' . $idXQuestUser . '";' . $_.
						'$scoreColumn="' . $_POST["scoreColumn"] . '";' . $_.
						'$scoreDirection="' . $_POST["scoreDirection"] . '";' . "\n".
						'?>';
			fwrite($handle,$settingsFile);
			fclose($handle);
		}
	}
	header("Location: settings.php");
?>
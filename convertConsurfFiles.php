<?php 
	$rand = rand(12000, 32700);
	$conservation = "{";			
	if(isSet($_FILES ["files"]) && $_FILES ["files"]["error"][0] == 0){	
		for($i = 0; $i < sizeof($_FILES ["files"]["name"]); $i++){
			$conservation .= '"'. rtrim($_FILES ["files"]["name"][$i], '.csv') . '" : [';
			move_uploaded_file($_FILES["files"]["tmp_name"][$i], "../tmp/" . $rand . "files" . $i);	
			if (($file = fopen("../tmp/" . $rand . "files". $i, "r")) != FALSE) {
				fgetcsv($file);
				fgetcsv($file);
				fgetcsv($file);
				fgetcsv($file);
				fgetcsv($file);
				
				while (!feof($file)) { 
					$row = fgetcsv($file);
					if(sizeof( $row) > 1){
						$conservation .= '{"start" : ' . $row[0] . ', "end": ' . $row[0] . ', "name": "' . $row[23] .'"},'; 
					}
				}
				fclose($file);
				unlink("../tmp/" . $rand . "files". $i);
			}
			$conservation = rtrim($conservation, ',') ."],";
		}
	}
	$conservation =  rtrim($conservation, ',') . "}";
?>
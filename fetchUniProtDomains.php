<?php
	if(isset($_SESSION['loginAsUser'])){
		$userName="";
	}
	$path = "../user/" . $userName . "/xQuestFiles/";
	$row = 1;
	$proteinNames = array();
	$id = array();
	
	if (($file = @fopen(isset($_SESSION['loginAsUser']) ? "../tmp/" . strval($_SESSION["FilePrev"]) . "xQuestFile" : $path . $_POST["xQuestFile"], "r")) == FALSE) {
			$file = fopen("./docs/INO80 crosslink file.csv", "r");
	}
	$columnNames = fgetcsv($file);
	$id[1] = array_search('Protein1', $columnNames);
	$id[2] = array_search('Protein2', $columnNames);
	$i = 0;
		
	while (!feof($file)) { 
		$row = fgetcsv($file);
		if(sizeof(explode ("|", $row[$id[1]])) == 1){
			$proteinNames[$row[$id[1]]] = $row[$id[1]];
			$proteinNames[$row[$id[2]]] = $row[$id[2]];
		}else{
			$pName1=explode("|", $row[$id[1]]);
			$pName2=explode("|", $row[$id[2]]);
			$proteinNames[$pName1[1]] = $pName1[1];
			$proteinNames[$pName2[1]] = $pName2[1];
		}
	}
	fclose($file);
	unset($proteinNames[""]);
	
	$domains = "{";
	$lengths = "{";
	if(isset($_POST["useUniProtLengths"])){
		$response = file("http://www.ebi.ac.uk/Tools/dbfetch/dbfetch?db=uniprotkb&id=\"" . implode(",", $proteinNames)."\"&format=gff3&style=raw&Retrieve=Retrieve");
		$uniprotDomains = array();
		
		foreach($response as $line) {
			if ($line[0] == '#' && $line[2] == 's') {
				$line = preg_split("/ /", $line);
				$lengths = $lengths.$line[1] . ":" . rtrim($line[3], PHP_EOL) . ", ";
			}else if ( isset($_POST["showUniProtDomains"]) && preg_match("/[a-zA-Z0-9]*	UniProtKB	*[Helix|Beta strand|Turn] *\d* *\d*/", $line, $length)) {
				$line = preg_split("/\t/", $line);
				if (!array_key_exists($line[0], $uniprotDomains)) {
					$uniprotDomains[$line[0]] = array();
				}
				$uniprotDomains[$line[0]][] = ("{start:$line[3], end:$line[4], name:'$line[2]'}");
			}
		}
			
		if(isset($_POST["showInterProDomains"])){
			include('fetchInterProDomains.php');
		}

		foreach($proteinNames as $name) {
			if (array_key_exists($name, $uniprotDomains) && $uniprotDomains[$name] != null) {
				$domains.= "$name:[" . implode(", ", $uniprotDomains[$name]) . "], ";
			}
		}
	}else{
		$path="../user/" . $userName . "/peptideLengthsFiles/";
		
		if (($file = fopen(isset($_SESSION['loginAsUser'])? "../tmp/" . strval($_SESSION["FilePrev"]) . "peptideLengths" : $path . $_POST["peptideLengths"], "r")) !== FALSE) {
			$columnNames = fgetcsv($file);
			$i = 0;
			
			while (!feof($file)) {
				$row = fgetcsv($file);
				if(sizeof(explode ("|", $row[0])) == 1){
					if(isset($proteinNames[$row[0]])){
						$lengths .='"'.$row[0].'":'.$row[1].',';
					}
				}else{
					$row_ =explode("|", $row[0]);
					if( isset($proteinNames[$row_[1]])){
						$lengths .= '"'.$row_[1].'":'.$row[1].',';
					}
				}
			}
			fclose($file);
		}
	}
	$domains = rtrim($domains, ', ')."}";
	$lengths = rtrim($lengths, ', ')."}";
	echo"<script type=\"text/javascript\">";
	echo "var interProDomains ={".@rtrim($interProDomains_, ', ')."};";
	echo "var interProNames=[\"".@implode("\",\"", $interProNames) ."\"];";
	echo"var proteinLengths=$lengths;";
	echo"var uniProtDomains=$domains;";
	echo "var conservations = $conservation;";
	echo"</script>";
?>
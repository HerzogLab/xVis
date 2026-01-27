<?php
	$interProDomains_="";
	$query = "http://www.biomart.org/biomart/martservice?query=".
		urlencode("<Query client=\"true\" formatter = \"CSV\" limit=\"-1\" header=\"0\">".
			"<Dataset name=\"protein\" config=\"protein_config\">".
			"<Filter name=\"protein_accession\" value=\"".implode(",", $proteinNames)."\" filter_list=\"protein_accession\"/>".
			"<Filter name=\"entry_type\" value=\"Active_site,Binding_site,Conserved_site,Domain,Family,PTM,Repeat\" filter_list=\"entry_type\"/>".
			"<Attribute name=\"protein_accession\"/>".
			"<Attribute name=\"pos_from\"/>".
			"<Attribute name=\"pos_to\"/>".
			"<Attribute name=\"entry_name\"/>".
			"<Attribute name=\"entry_type\"/>".
			"</Dataset>".
			"</Query>"); 
			
	$response = file($query);
	$interProDomains = array();
	
	 foreach($response as $line) {
		$line = preg_split('/,/', $line,4);
		$line[3] = rtrim(str_replace('"', '',$line[3]), "\n\r");
		$interProDomains[$line[0]][] = array("{start:$line[1], end:$line[2], name:'$line[3]'}", abs($line[1]-$line[2]));
		$interProNames[] = $line[3];
	}
	foreach($proteinNames as $name) {
		if (array_key_exists($name, $interProDomains) && $interProDomains[$name] != null) {
			usort($interProDomains[$name], "cmp");
			$interProDomains_ .= "$name:[";
			foreach($interProDomains[$name] as $arr){
				$interProDomains_ .= $arr[0] . ",";
			}
			$interProDomains_ .= "], ";
		}
	}
	$interProNames=array_unique($interProNames);
	
	function cmp($a, $b){
		if ( $a[1] == $b[1]) {
			return 0;
		}
		return ($a[1] > $b[1]) ? -1 : 1;
	}
?>
<?php
if(!isset($_SESSION)){
	include('auth.php');
}
if(isset($_SESSION['loginAsUser'])){
	header("Location: CrossVisNoLogin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="img/icon.png" />
		<title>xVis</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
		<link href="css/jasny-bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="manual.php"><span class="glyphicon glyphicon-book"></span> Manual</a></li>
						<li><a href="contact.php"><span class="glyphicon glyphicon-envelope"></span> Contact</a></li>
						<li><a href="settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
						<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div><!--/.container-fluid -->
		</div>
	  
		<div class="container">
			<?php
				function getFiles($folder, $userName){
					$files = array();
					if($handle = opendir("../user/" . $userName . "/$folder/")){
						while (false !== ($file = readdir($handle))) {
							if ($file != "." && $file != "..") {
								$files[] = $file;
							}
						}
						closedir($handle);
					}
					return $files;
				}
				
				$domainFiles = getFiles("domainFiles", $userName);
				$xQuestFiles = getFiles("xQuestFiles", $userName);
				$peptideLengthsFiles = getFiles("peptideLengthsFiles", $userName);
			?>
			<div class="panel-group" id="accordion">
				<h1>File Management</h1>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseUpload">
								<small>
									<span class="glyphicon glyphicon-plus" id="collapseUploadIcon"></span>
								</small>
								Upload Files
							</a>
						</h4>
					</div>
					<div id="collapseUpload" class="panel-collapse collapse">
						<div class="panel-body">
							<form action="upload.php" method="post" enctype="multipart/form-data" role="form">
								<div class="form-group">
									<label for="fileTyp">File Type</label>
									<select name="fileTyp" class="form-control" id="fileTyp" size="1">
										<option value="xQuestFile" selected>File contains crosslink information</option>
										<option value="domainFile">File contains domains</option>
										<option value="peptideLengthsFile">File contains protein lengths</option>
									</select>
								</div>
								<div class="form-group">
									<div class="fileinput fileinput-new input-group" data-provides="fileinput">
										<div class="form-control" data-trigger="fileinput">
											<i class="glyphicon glyphicon-file fileinput-exists"></i>
											<span id="filename"> No file(s) selected</span>
										</div>
										<span class="input-group-addon btn btn-default btn-file">
										<span class="fileinput-new">Select file</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" id="files" name="files[]" multiple></span>
										<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput" onclick="document.getElementById('list').innerHTML =''
											document.getElementById('filename').innerHTML ='No file(s) selected'" >Remove</a>
									</div>
								</div>
								<div id="list"></div>
								<button type="submit" class="btn btn-primary">Upload</button>
							</form>
							<script>
								function dateiauswahl(evt) {
									var files = evt.target.files,
										output = [];
										
									for (var i = 0, f; f = files[i]; i++) {
										output.push('<li><strong>', f.name, '</strong> (', f.type || 'n/a', ') - ', f.size, ' bytes</li>');
									}	
									document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';
									switch(files.length){
										case 0:
											document.getElementById('filename').innerHTML="No file(s) selected";
											break;
										case 1:
											document.getElementById('filename').innerHTML="1 file selected";
											break;
										default:
											document.getElementById('filename').innerHTML= files.length + " files selected";
									}
								}
								
								document.getElementById('files').addEventListener('change', dateiauswahl, false);
								document.getElementById('files').addEventListener('reset.bs.fileinput', dateiauswahl, false);
							</script>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseDelete">
								<small>
									<span class="glyphicon glyphicon-plus" id="collapseDeleteIcon"></span>
								</small>
								Delete Files
							</a>
						</h4>
					</div>
					<div id="collapseDelete" class="panel-collapse collapse">
						<div class="panel-body">
							<form action="delete.php" role="form" method="post">
								<div class="form-group">
									<select name="deleteFiles[]" class="form-control" multiple="multiple" size="8">
										<?php
											for($i = 0; $i < sizeof($domainFiles); $i++){
												echo "<option value=\"domainFiles/" . $domainFiles[$i] . "\">" . $domainFiles[$i] . " (Domain File)" . "</option>";
											}
											for($i = 0; $i < sizeof($xQuestFiles); $i++){
												echo "<option value=\"xQuestFiles/" . $xQuestFiles[$i] . "\">" . $xQuestFiles[$i] . " (Crosslink File)" . "</option>";
											}
											for($i = 0; $i < sizeof($peptideLengthsFiles); $i++){
												echo "<option value=\"peptideLengthsFiles/" . $peptideLengthsFiles[$i] . "\">" . $peptideLengthsFiles[$i] . " (Protein Lengths File)" . "</option>";
											}
										?>
									</select>
								</div>
								<input type="submit" class="btn btn-danger" value="Delete" />
							</form>
						</div>
					</div>
				</div>

				<h1>Input Parameter</h1>
				<div class="panel panel-default">
					<div class="panel-body">
						<form action="plot.php" role="form" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label for="plotTyp">Plot Type</label>
								<select id="plotTyp" name="plotTyp" class="form-control" onchange="enableSortTypes()" size="1">
									<option value="circularPlot" selected>Circular plot</option>
									<option value="barPlot">Bar plot</option>
									<option value="networkPlot">Network plot</option>
								</select>
							</div>
							<script> 
								function appendOptions(optionsTag, valueList, namesList){
									for( var i = 0; i < valueList.length; ++i){
										var opt = document.createElement('option');
										opt.value = valueList[i];
										opt.innerHTML = namesList[i];
										optionsTag.add(opt);
									}
								}
								function enableSortTypes(){
									options = document.getElementById("sortTyp").options;
									if (document.getElementById("plotTyp").value != "networkPlot") {
										document.getElementById("sortTypLabel").innerHTML = "Sort Type";
										options.length = 0;
										appendOptions(options, ['alphabetical', 'unconnectedSubgraphsAlphabetical', 'unconnectedSubgraphsHierarchical'],
																['Alphabetical order' , 'Groups alphabetically ordered', 'Groups hierarchically structured']);	
									}else{
										document.getElementById("sortTypLabel").innerHTML = "Coloring";
										options.length = 0;
										appendOptions(options, ['none', 'unconnectedSubgraphsAlphabetical', 'unconnectedSubgraphsMCL'],
																['None' , 'Grouped', 'Groups Markov clustered']);
									}
								}
							</script>
							<div class="form-group">
								<label id="sortTypLabel" for="sortTyp">Sort Type</label>
								<select id="sortTyp" name="sortTyp" class="form-control" size="1">
									<option value="alphabetical" selected>Alphabetical order</option>
									<option value="unconnectedSubgraphsAlphabetical" selected>Groups alphabetically ordered</option>
									<option value="unconnectedSubgraphsHierarchical" selected>Groups hierarchically structured</option>
								</select>
							</div>
							<div class="form-group">
								<label for="xQuestFile">Crosslink Data File</label>
								<select id="xQuestFile" class="form-control" name="xQuestFile">
									<?php
										for($i = 0; $i < sizeof($xQuestFiles); $i++){
											echo "<option value=\"" . $xQuestFiles[$i] . "\">" . $xQuestFiles[$i] . "</option>"; 
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="domainFile">Domain File (optionally)</label>
								<select id="domainFile" class="form-control" name="domainFile">
									<option value="none" selected>none</option>
									<?php
										for($i = 0; $i < sizeof($domainFiles); $i++){
											echo "<option value=\"" . $domainFiles[$i] . "\">" . $domainFiles[$i] . "</option>"; 
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="fileTyp">Select the <em>msa_aa_variety_percentage</em> files from ConSurf (optionally)</label>
								<p>The file name has to be in the format <em>[UniProt accession number / user-defined names].csv</em> depending on the used protein descriptor.</p>
								<div class="fileinput fileinput-new input-group" data-provides="fileinput">
									<div class="form-control" data-trigger="fileinput">
										<i class="glyphicon glyphicon-file fileinput-exists"></i>
										<span id="filenameC"> No file(s) selected</span>
									</div>
									<span class="input-group-addon btn btn-default btn-file">
									<span class="fileinput-new">Select file</span>
									<span class="fileinput-exists">Change</span>
									<input type="file" id="filesC" name="files[]" multiple></span>
									<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput" onclick="document.getElementById('listC').innerHTML =''
										document.getElementById('filenameC').innerHTML ='No file(s) selected'" >Remove</a>
								</div>
								<div id="listC"></div>
							</div>
							<script>
								var filesC = [];
								function dateiauswahlC(evt) {
									filesC = evt.target.files,
										output = [];
									
									for (var i = 0, f; f = filesC[i]; i++) {
										output.push('<li><strong>', f.name, '</strong> (', f.type || 'n/a', ') - ', f.size, ' bytes</li>');
									}	
									document.getElementById('listC').innerHTML = '<ul>' + output.join('') + '</ul>';
									switch(filesC.length){
										case 0:
											document.getElementById('filenameC').innerHTML="No file(s) selected";
											break;
										case 1:
											document.getElementById('filenameC').innerHTML="1 file selected";
											break;
										default:
											document.getElementById('filenameC').innerHTML= filesC.length + " files selected";
									}
								}
								
								document.getElementById('filesC').addEventListener('change', dateiauswahlC, false);
								document.getElementById('filesC').addEventListener('reset.bs.fileinput', dateiauswahlC, false);
							</script>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="useUniProtLengths" value="useUniProtLengths" onclick="showPeptideLengthsSelect(this)" checked>
									Use UniProt protein lengths
								</label>
								<script>
									function showPeptideLengthsSelect(checkbox){
										if (checkbox.checked) {
											document.getElementById("peptideLengths").disabled=true;
											document.getElementById("showUniProtDomains").disabled=false;
											document.getElementById("showInterProDomains").disabled=false;
										}else{
											document.getElementById("peptideLengths").disabled=false;
											document.getElementById("showUniProtDomains").disabled=true;
											document.getElementById("showInterProDomains").disabled=true;
										}
									}
								</script>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" id="showUniProtDomains" name="showUniProtDomains" value="showUniProtDomains">
									Show secondary structures (UniProt)
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" id="showInterProDomains" name="showInterProDomains" value="showInerProDomains">
									Show annotations (InterPro) 
								</label>
							</div>
							<div class="form-group">
								<label for="peptideLengths">Protein Lengths</label>
								<select name="peptideLengths" id="peptideLengths" class="form-control" disabled>
									<?php
										for($i = 0; $i < sizeof($peptideLengthsFiles); $i++){
											echo "<option value=\"" . $peptideLengthsFiles[$i] . "\">" . $peptideLengthsFiles[$i] . "</option>";
										}
									?>
								</select>
							</div>
			
							<input type="submit" class="btn btn-primary" value="Plot" />
			
						</form>
					</div>
				</div>

			</div><!-- // accordion end -->
		</div> 

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jasny-bootstrap.min.js"></script>
		
		<script type="text/javascript">
			$('.collapse').on('shown.bs.collapse', function (event) {
				$("#" + event.target.id + "Icon")
					.removeClass("glyphicon glyphicon-plus")
					.addClass("glyphicon glyphicon-minus");
			})
			
			$('.collapse').on('hide.bs.collapse', function (event) {
				$("#" + event.target.id + "Icon")
					.removeClass("glyphicon glyphicon-minus")
					.addClass("glyphicon glyphicon-plus");
			})
		</script>
	</body>
</html>
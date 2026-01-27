<?php
session_start();
$_SESSION["login"] = 1;
$_SESSION["loginAsUser"] = 0;
$_SESSION["FilePrev"]= rand();
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
					<a class="navbar-brand" href="login.php">Home</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="manual.php"><span class="glyphicon glyphicon-book"></span> Manual</a></li>
						<li><a href="downloads.php"><span class="glyphicon glyphicon-download"></span> Downloads</a></li>
						<li><a href="contact.php"><span class="glyphicon glyphicon-envelope"></span> Contact</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div><!--/.container-fluid -->
		</div>
		
		<div class="container">
			<h1>Examples</h1>
			<ul class="media-list list-inline list-group">
				<li class="media list-group-item">
					<img src="img/examples/circular_gray.jpg" class=" media-figure" height="140" alt="Example circular plot"
						onmouseover="this.src='img/examples/circular_.jpg'"
						onmouseout="this.src='img/examples/circular_gray.jpg'"
						onclick="circular_example()">
					<h4 class="media-heading text-center">Circular Plot</h4>
				</li>
				<li class="media list-group-item">
					<img src="img/examples/bar_gray.jpg" class=" media-figure" height="140" alt="Example bar plot"
						onmouseover="this.src='img/examples/bar_.jpg'"
						onmouseout="this.src='img/examples/bar_gray.jpg'"
						onclick="bar_example()">	
					<h4 class="media-heading text-center">Bar Plot</h4>
				</li>
				<li class="media list-group-item">
					<img src="img/examples/network_gray.jpg" class=" media-figure" height="140" alt="Example network plot" 
						onmouseover="this.src='img/examples/network_.jpg'"
						onmouseout="this.src='img/examples/network_gray.jpg'"
						onclick="network_example()">
					<h4 class="media-heading text-center">Network Plot</h4>
				</li>
			</ul>
		</div>
		<script>
		function circular_example(){
			document.forms[0].xQuestFile.value = ""
			document.forms[0].domainFile.value = ""
			document.forms[0].peptideLengths.value = ""
			document.forms[0].plotTyp[0].selected=true
			document.forms[0].plotTyp.onchange()
			document.forms[0].sortTyp[2].selected=true
			document.forms[0].scoreColumn.value = 'ld-Score'
			document.forms[0].scoreDirectionBigger.checked = true
			document.forms[0].useUniProtLengths.checked = true
			document.forms[0].useUniProtLengths.onclick()
			document.forms[0].showUniProtDomains.checked =false
			document.forms[0].showInterProDomains.checked = true
			document.forms[0].submit()
		}
		function bar_example(){
			document.forms[0].xQuestFile.value = ""
			document.forms[0].domainFile.value = ""
			document.forms[0].peptideLengths.value = ""
			document.forms[0].plotTyp[1].selected=true
			document.forms[0].plotTyp.onchange()
			document.forms[0].sortTyp[2].selected=true
			document.forms[0].scoreColumn.value = 'ld-Score'
			document.forms[0].scoreDirectionBigger.checked = true
			document.forms[0].useUniProtLengths.checked = true
			document.forms[0].useUniProtLengths.onclick()
			document.forms[0].showUniProtDomains.checked =false
			document.forms[0].showInterProDomains.checked = true
			document.forms[0].submit()
		}
		function network_example(){
			document.forms[0].xQuestFile.value = ""
			document.forms[0].domainFile.value = ""
			document.forms[0].peptideLengths.value = ""
			document.forms[0].plotTyp[2].selected=true
			document.forms[0].plotTyp.onchange()
			document.forms[0].sortTyp[2].selected=true
			document.forms[0].scoreColumn.value = 'ld-Score'
			document.forms[0].scoreDirectionBigger.checked = true
			document.forms[0].useUniProtLengths.checked = true
			document.forms[0].useUniProtLengths.onclick()
			document.forms[0].showUniProtDomains.checked =false
			document.forms[0].showInterProDomains.checked = true
			document.forms[0].submit()
		}
		</script>
		<script>
			function checkIfFileSelected(){
				if((document.getElementById('xQuestFile').value != '' && document.getElementById('useUniProtLengths').checked) ||
					(document.getElementById('xQuestFile').value != '' && document.getElementById('peptideLengths').value )){
					document.getElementById('submitBtn').disabled = false;
					document.getElementById('errorFile1').hidden = true;
					document.getElementById('errorFile2').hidden = true;
				}else{
					document.getElementById('submitBtn').disabled = true;
				}
			}
		</script>
	  
		<div class="container">
			<div class="panel-group" id="accordion">
				<h1>Input Parameter</h1>
				<div class="panel panel-default">
					<div class="panel-body">
						<form action="plot_.php" role="form" method="post" enctype="multipart/form-data" role="form">
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
								<div class="fileinput fileinput-new input-group" data-provides="fileinput">
									<div class="form-control" data-trigger="fileinput">
										<i class="glyphicon glyphicon-file fileinput-exists"></i>
										<span id="xQuestFileSpan" class="fileinput-filename"></span>
									</div>
									<span class="input-group-addon btn btn-default btn-file">
										<span class="fileinput-new">Select file</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" id="xQuestFile" name="xQuestFile[]" onchange="checkIfFileSelected()">
									</span>
									<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput" onclick="document.getElementById('submitBtn').disabled=true;">Remove</a>
								</div>	
							</div>
							<div class="form-group">
								<label for="scoreColumn">Filter by Value: <small>Column Heading</small></label>
								<input class="form-control" id="scoreColumn" name="scoreColumn" type="text" size="40" value="">
							</div>
							<div class="form-group">
								Filter values
								<div class="radio-inline">
									<label class="checkbox-inline">
										<input id="scoreDirectionSmaller" type="radio" name="scoreDirection" value="<">
											below threshold 
									</label>
								</div>
								<div class="radio-inline">
									<label class="checkbox-inline">
										<input id="scoreDirectionBigger" type="radio" name="scoreDirection" value=">" checked>
											above threshold
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="domainFile">Domain File (optionally)</label>
								<div class="fileinput fileinput-new input-group" data-provides="fileinput">
									<div class="form-control" data-trigger="fileinput">
										<i class="glyphicon glyphicon-file fileinput-exists"></i>
										<span id="domainFileSpan" class="fileinput-filename"></span>
									</div>
									<span class="input-group-addon btn btn-default btn-file">
										<span class="fileinput-new">Select file</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" id="domainFile" name="domainFile[]">
									</span>
									<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
							<div class="form-group">
								<label for="fileTyp">ConSurf (optionally): select <em>msa_aa_variety_percentage</em> files (Consurf output files)</label>
								<p>The file names must have the format <em>[UniProt accession number or user-defined names].csv</em> depending on the used protein descriptor.</p>
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
								<div id="list"></div>
							</div>
							<script>
								var files = [];
								function dateiauswahl(evt) {
									files = evt.target.files,
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
							
							<div class="checkbox" title="Disable to use a protein length file.">
								<label>
									<input type="checkbox" id="useUniProtLengths" name="useUniProtLengths" value="useUniProtLengths" onclick="showPeptideLengthsSelect(this);checkIfFileSelected()" checked>
									Use UniProt protein lengths
								</label>
								<script>
									function showPeptideLengthsSelect(checkbox){
										if (checkbox.checked) {
											document.getElementById("peptideLengths_").style.display="none";
											document.getElementById("showUniProtDomains").disabled=false;
											document.getElementById("showInterProDomains").disabled=false;
										}else{
											document.getElementById("peptideLengths_").style.display="inline";
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
							<div class="form-group" id="peptideLengths_" style="display:none;">
								<label for="peptideLengths">Protein Lengths</label>
								<div class="fileinput fileinput-new input-group" data-provides="fileinput">
									<div class="form-control" data-trigger="fileinput">
										<i class="glyphicon glyphicon-file fileinput-exists"></i>
										<span id="peptideLengthsSpan" class="fileinput-filename"></span>
									</div>
									<span class="input-group-addon btn btn-default btn-file">
										<span class="fileinput-new">Select file</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" id="peptideLengths" name="peptideLengths[]" onchange="checkIfFileSelected()">
									</span>
									<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput" onclick="document.getElementById('submitBtn').disabled=true;">Remove</a>
								</div>	
							</div>
							<div class="form-group" onclick="showError()">
								<input type="submit" id="submitBtn" class="btn btn-primary" value="Plot" disabled/>
								<small id="errorFile1" style="color:#A94442" hidden>Choose a crosslink data file!</small> 
								<small id="errorFile2" style="color:#A94442" hidden>Choose a crosslink data file and a protein lengths file!</small>
							</div>
						</form>
					</div>
				</div>
			</div><!-- // accordion end -->
		</div> 

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		<!--<script src="js/dropzone.js"></script>-->
		<script src="js/jasny-bootstrap.min.js"></script>
	
		<script>
			function showError(){
				if(document.getElementById('xQuestFile').value == '' && document.getElementById('useUniProtLengths').checked){
					document.getElementById('errorFile1').hidden = false;
					document.getElementById('errorFile2').hidden = true;
				}else if(document.getElementById('xQuestFile').value == '' && document.getElementById('peptideLengths').value == ''){
					document.getElementById('errorFile2').hidden = false;
					document.getElementById('errorFile1').hidden = true;
				}
			}
		</script>
		<script>
			function setSpan(){
				document.getElementById("xQuestFileSpan").innerHTML=document.getElementById('xQuestFile').value.split("\\").pop()
				document.getElementById("domainFileSpan").innerHTML=document.getElementById('domainFile').value.split("\\").pop()
				document.getElementById("peptideLengthsSpan").innerHTML=document.getElementById('peptideLengths').value.split("\\").pop()
			}
			if(window.attachEvent) {
				window.attachEvent('onload', setSpan);
			} else {
				if(window.onload) {
					var curronload = window.onload;
					var newonload = function() {
						curronload();
						setSpan();
					};
					window.onload = newonload;
				} else {
					window.onload = setSpan;
				}
			}
		</script>
	
		<script type="text/javascript">
			$('.collapse').on('shown.bs.collapse', function (event) {
				$("#"+event.target.id+"Icon")
					.removeClass("glyphicon glyphicon-plus")
					.addClass("glyphicon glyphicon-minus");
			})
			$('.collapse').on('hide.bs.collapse', function (event) {
				$("#"+event.target.id+"Icon")
					.removeClass("glyphicon glyphicon-minus")
					.addClass("glyphicon glyphicon-plus");
			})
		</script>
	</body>
</html>
<?php
if(!isset($_SESSION)){
	include('auth.php');
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
					<a class="navbar-brand" href=<?php echo isset($_SESSION['loginAsUser'])?"CrossVisNoLogin.php":"CrossVis.php"?>>xVis</a>
				</div>
				<div class="navbar-collapse collapse">
				<?php if(!isset($_SESSION['loginAsUser'])){ ?>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
						<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					</ul>
				<?php } ?>
				</div><!--/.nav-collapse -->
			</div><!--/.container-fluid -->
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-7 col-lg-5">
				<?php 
				include('fetchUniProtDomains.php');
				?> 
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseShape">
										<small>
											<span class="glyphicon glyphicon-plus" id="collapseShapeIcon"></span>
										</small>
										Shapes
									</a>
								</h4>
							</div>
							<div id="collapseShape" class="panel-collapse collapse">
								<div class="panel-body">
									<form action="#" role="form" method="get">
										<div class="checkbox">
											<label>
												<input id="showNCTag" type="checkbox" name="show" value="show" checked>
												N/C-Tag
											</label>
										</div>
										<label>
											Protein Name
										</label>	
										<div class="radio-inline">
											<label class="checkbox-inline">
												<input id="showProteinName" type="radio" name="showProteinName" value="above" checked>
												above
											</label>
										</div>
										<div class="radio-inline">
											<label class="checkbox-inline">
												<input id="showProteinName" type="radio" name="showProteinName" value="below">
												below
											</label>
										</div>
										<div class="radio-inline">
											<label class="checkbox-inline">
												<input id="showProteinName" type="radio" name="showProteinName" value="inside">
												inside
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input id="showFrame" type="checkbox" name="show" value="show" checked>
												Frame
											</label>
										</div>
										
										<input type="button" class="btn btn-primary" value="Redraw" onclick="redraw()" />
									</form>
								</div>
							</div>
						</div>	

						<?php function colorOptions($defaultValue){
							$colors = array("White" ,"Silver" ,"Gray", "Black", "Red", "Maroon", "Yellow", "Olive", "Lime", "Green", "Aqua", "Teal", "Navy", "Fuchsia", "Purple", "Blue");
							for($i = 0; $i < sizeof($colors); $i++){
									echo "<option value=\"" . $colors[$i] . "\" " . (($defaultValue==$i) ? "selected" : "") . ">".$colors[$i] . "</option>"; 
							}
						}
						if(isset($_POST["showUniProtDomains"]) && $_POST["showUniProtDomains"] != null){
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseUniProt">
										<small>
											<span class="glyphicon glyphicon-plus" id="collapseUniProtIcon"></span>
										</small>
										Secondary Structures
									</a>
								</h4>
							</div>
							<div id="collapseUniProt" class="panel-collapse collapse">
								<div class="panel-body">
									<form action="#" role="form" method="get">
										<div class="checkbox">
											<label>
												<input type="checkbox" id="betaStrands" name="betaStrands" value="betaStrands" checked>
												Beta Strand
											</label>
										</div>
										<div class="form-group">
											<label for="betaStrandsColor" class="sr-only">Color</label>
											<select id="betaStrandsColor" class="form-control" name="betaStrandsColor">
												<?php colorOptions(6) ?>
											</select>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" id="helixes" name="helixes" value="helixes" checked>
												Helix
											</label>
										</div>
										<div class="form-group">
											<label for="helixesColor" class="sr-only">Color</label>
											<select id="helixesColor" class="form-control" name="helixesColor">
												<?php colorOptions(4) ?>
											</select>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" id="turns" name="turns" value="turns" checked>
												Turn
											</label>
										</div>
										<div class="form-group">
											<label for="turnsColor" class="sr-only">Color</label>
											<select id="turnsColor" class="form-control" name="turnsColor">
												<?php colorOptions(15) ?>
											</select>
										</div>

										<input type="button" class="btn btn-primary" value="Redraw" onclick="redraw()" />
									</form>
								</div>
							</div>
						</div>		
						<?php
						}
						if(isset($_POST["showInterProDomains"]) && $_POST["showInterProDomains"] != null){ 
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseInterPro">
										<small>
											<span class="glyphicon glyphicon-plus" id="collapseInterProIcon"></span>
										</small>
										InterPro Annotations
									</a>
								</h4>
							</div>
							<div id="collapseInterPro" class="panel-collapse collapse">
								<div class="panel-body">
									<form action="#" role="form" method="get">
										<div class="form-group">
											<label for="interProDomainsSelectionList" class="sr-only">Color</label>
											<select id="interProDomainsSelectionList" class="form-control" name="interProDomainsSelectionList[]" multiple="multiple" size="8"
												data-toggle="tooltip" data-placement="top" title="Multiple Selection">
												<?php
													sort($interProNames); 
													foreach($interProNames as $name){
														echo "<option value=\"" . $name . "\"selected>" . $name . "</option>"; ///change name
													}
												?>
											</select>
										</div>

										<input type="button" class="btn btn-primary" value="Redraw" onclick="redraw()" />
									</form>
								</div>
							</div>
						</div>
						<?php 
						}
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
										<small>
											<span class="glyphicon glyphicon-plus" id="collapseFilterIcon"></span>
										</small>
										Filter
									</a>
								</h4>
							</div>
							<div id="collapseFilter" class="panel-collapse collapse">
								<div class="panel-body">
									<form action="#" role="form" method="get">
										<div class="checkbox">
											<label>
												<input type="checkbox" id="interProteinCrosslinks" name="interProteinCrosslinks" value="interProteinCrosslinks" checked>
												Inter-Protein-Crosslinks
											</label>
										</div>
										<div class="form-group" id="interProteinCrosslinkColorGroup">
											<label for="interProteinCrosslinksColor" class="sr-only">Color</label>
											<select id="interProteinCrosslinksColor" class="form-control" name="interProteinCrosslinksColor">
												<?php colorOptions(15) ?>
											</select>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" id="intraProteinCrosslinks" name="intraProteinCrosslinks" value="intraProteinCrosslinks" checked>
												Intra-Protein-Crosslinks
											</label>
										</div>
										<div class="form-group" id="intraProteinCrosslinkColorGroup">
											<label for="intraProteinCrosslinksColor" class="sr-only">Color</label>
											<select id="intraProteinCrosslinksColor" class="form-control" name="interProteinCrosslinksColor" size="1">
												<?php colorOptions(4) ?>
											</select>
										</div>
										<div class="form-group">
											<label for="proteinSelectionList">Show Selected Proteins</label>
											<select id="proteinSelectionList" class="form-control" name="proteinSelectionList[]" multiple="multiple" size="4"
												data-toggle="tooltip" data-placement="top" title="Multiple Selection" onchange="selectedProteins_()";>
											</select>
										</div>
										<div class="form-group">
											<label> Cut-Off Score</label>
											<div class="input-group">
												<span class="input-group-addon" id="scoreMin">0</span>
												<input id="cutOffScore" type="range" class="form-control" min="0.0" max="10" step="0.01" value="0"	
													oninput="document.getElementById('cutOffScoreValue').innerHTML = parseFloat(this.value).toFixed(2)"
													onchange="document.getElementById('cutOffScoreValue').innerHTML = parseFloat(this.value).toFixed(2)"/><!--wegen firefox-->
												<span class="input-group-addon" id="scoreMax">0</span>
												<span class="input-group-addon">Cut-Off: <label id="cutOffScoreValue">0</label></span>
											</div>
										</div>
										
										<input type="button" class="btn btn-primary" value="Redraw" onclick="redraw()" />
									</form>
								</div>
							</div>
						</div>
						<?php
						if(isset($_POST["sortTyp"]) && $_POST["sortTyp"] == "unconnectedSubgraphsMCL"){
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseMCL">
										<small>
											<span class="glyphicon glyphicon-plus" id="collapseMCLIcon"></span>
										</small>
										Markov Cluster Settings
									</a>
								</h4>
							</div>
							<div id="collapseMCL" class="panel-collapse collapse">
								<div class="panel-body">
									<form action="#" role="form" method="get">
										<div class="form-group">
											<label for="expansion">Expansion</label>
											<input id="expansion" oninput="validateInputToNumber(document.getElementById('expansion'))" class="form-control" value="2">
											<small class="control-label" hidden>not a valid number</small>
										</div>
										<div class="form-group">
											<label for="inflation">Inflation</label>
											<input id="inflation" oninput="validateInputToNumber(document.getElementById('inflation'))" class="form-control" value="3"></input>
											<small class="control-label" hidden>not a valid number</small>
										</div>
										<div class="form-group">
											<label for="threshold">Threshold (minimum proteins in group)</label>
											<input id="threshold" oninput="validateInputToNumber(document.getElementById('threshold'))" class="form-control" value="3"></input>
											<small class="control-label" hidden>not a valid number</small>
										</div>
										
										<input type="button" class="btn btn-primary" value="Update Cluster" onclick="updateCluster()" />
									</form>
								</div>
							</div>
						</div>

						<?php
						}
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseSVG">
										<small>
											<span class="glyphicon glyphicon-plus" id="collapseSVGIcon"></span>
										</small>
										Download SVG
									</a>
								</h4>
							</div>
							<div id="collapseSVG" class="panel-collapse collapse">
								<div class="panel-body">	
									<form id="svgform" method="post" onsubmit="return false;" action="download.php">
										<div class="form-group">
											<label for="outputName">Output File Name</label>
											<input type="text" class="form-control" id="outputName" name="outputName" oninput="validateInput()" value="<?php $_=@explode("/", $path . $_POST["xQuestFile"]); $_=@explode(".",$_[4]); echo $_[0] ?>_network">
											<small class="control-label" hidden>filename contains an invalid character</small>
										</div>
										<input type="hidden" id="data" name="data" value="">
									</form>
									<button class="btn btn-success" id="save_as_svg" onclick="submit_download_form()">
										Save as SVG
									</button>
								</div>
							</div>
						</div>
					</div> <!-- // accordion end -->
				</div>
				<div class="<?php echo calcWidth();?>">
					<div class="alert alert-info" id="waitDialog" name="waitDialog">Processing...</div>
					<div class="panel panel-default">
						<div id="viz"></div>
					</div>
				</div>
				<?php 
					function calcWidth(){
						if((isset($_POST["showInterProDomains"]) && $_POST["showInterProDomains"] != null)  || 
							(isset($_FILES["domainFile"]) && $_FILES["domainFile"][0]["name"] != null)){
								return "col-md-14 col-lg-15";
							}else{
								return "col-md-17 col-lg-19";
							}
					}
				?>
				<div class="col-md-3 col-lg-4">
				<?php if((isset($_POST["showInterProDomains"]) && $_POST["showInterProDomains"] != null)  || 
							(isset($_FILES["domainFile"]) && $_FILES["domainFile"][0]["name"] != null)){?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								Legend
							</h4>
						</div>
						<div id="legend">
						</div>
					</div>
				<?php } ?>
				</div>
		</div>	
		<script>
			var outputName = document.getElementById("outputName");
			
			function validateInput(){
				if(new RegExp(/^[^\\/:\*\?\"<>\|&'@{}[\]§$=!#%+~°`\^'`]+$/).test(outputName.value)&& new RegExp(/^[^. ]/).test(outputName.value)){
					outputName.parentElement.className = "form-group";
					outputName.parentElement.getElementsByTagName("small")[0].style.display = 'none';
				}else{
					outputName.parentElement.className = "form-group has-error";
					outputName.parentElement.getElementsByTagName("small")[0].style.display = 'inline';
				}
			}
			
			function validateInputToNumber(input){
				if(new RegExp(/^[0-9\.-]+$/).test(input.value) && (input.value.match(/\./g) == null ? true : input.value.match(/\./g).length < 2)){
					input.parentElement.className = "form-group";
					input.parentElement.getElementsByTagName("small")[0].style.display = 'none';
				}else{
					input.parentElement.className = "form-group has-error";
					input.parentElement.getElementsByTagName("small")[0].style.display = 'inline';
				}
			}
			
			function submit_download_form(){
				if(outputName.parentElement.className == "form-group"){
					var svg = document.getElementsByTagName("svg")[0],
						svg_xml = (new XMLSerializer).serializeToString(svg),
						form = document.getElementById("svgform");
					form['data'].value = svg_xml;
					form.submit();
				}
			}
		</script>

		<div class="panel panel-default" style="display:none; "   id="contextMenu">
			<div class="panel-body">
				<div class="form-group">
					Rotate (in degrees)
					<input id="rotation" type="text" class="form-control" oninput="validateInputToNumber(document.getElementById('rotation'))" value="0" />
					<small class="control-label" hidden>not a valid number</small>
				</div>
				<div class="checkbox">
					<label>
						<input id="flipVertical" type="checkbox" name="flip" value="flip"/> Flip 
					</label>
				</div>
				<input type="button" value="Update" onclick="update()" />
				<input type="hidden" id="selectedProtein" ></input>
			</div>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery-2.1.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/sort.js"></script>
		<script type="text/javascript" src="js/d3.v3.js"></script>

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
			
			_ = {"betaStrands" : 1, "turns" : 1, "helixes" : 1, "interProteinCrosslinks" : 1, "intraProteinCrosslinks" : 1};
			$(".checkbox").on("change", function(event){
				if(_[event.target.id] != null){
					$('#'+event.target.id+'Color')[0].disabled = (!$('#'+event.target.id+'Color')[0].disabled);
				}
			});
		</script>

		<script type="text/javascript">
			var connections = [],
				forceOn = true,
				proteins = [],
				links = [],
				proteinNames = [],
				domainInfo = [],
				nodes = [],
				forceLines = [],
				maxLength = 0,
				flip = [],
				sizeModifakator = 160,
				names = [],
				score = <?php echo isset($_SESSION['loginAsUser'])? '"' . $_POST['scoreColumn'] . '"' : "\"$scoreColumn\"";?>,
				minScore = 999999,
				maxScore = 0,
				selectedProteins = [];
	
			d3.csv("<?php echo 'ajax.php?ftype=xQuestFile&file=' . (isset($_POST['xQuestFile']) ? $_POST['xQuestFile'] : '');?>", function(data) { 
				data.forEach(function(row) { 
					var prot1 = row.Protein1.split("\|"), 
					prot2 = row.Protein2 .split("\|"),
					index = [];
					
					if(prot1.length == 3){
						index = [prot1[1], prot2[1]];
						names[prot1[1]] = prot1[2];
						names[prot2[1]] = prot2[2];
					}else{ 
						index = [prot1[0], prot2[0]];
					}
					links.push({Protein1:index[0], Protein2:index[1], Pos1:row.AbsPos1, Pos2:row.AbsPos2, XProphetURL:generateXProphetURL(row),
								name1:names[index[0]], name2:names[index[1]], score:row[score], scoreName:score});	
					if(row[score] < minScore){
						minScore = row[score];
					}
					if(row[score] > maxScore){
						maxScore = row[score];
					}
					index.sort();
					connections[index] = (connections[index] == null) ? 1 : connections[index] + 1;
					if(proteins[index[0]] == null){
						proteins[index[0]] = 1;
						proteinNames.push(index[0]);
					}else{
						proteins[index[0]] = proteins[index[0]] + 1;
					}
					if(proteins[index[1]] == null){
						proteins[index[1]] = 1;
						proteinNames.push(index[1]);
					}else{
						proteins[index[1]] = proteins[index[1]] + 1;
					}
					
				});
				d3.csv("<?php echo 'ajax.php?ftype=domainFile&file='.(isset($_POST["domainFile"])?$_POST["domainFile"] : '');?>", function(data2) { 
					if(data2 != null){
						data2.forEach(function(row) {
							var tmp = row.Protein.split("\|").length == 3  ?  row.Protein.split("\|")[1] : row.Protein;

							if(domainInfo[tmp] == null){
								domainInfo[tmp] = [];
							}
							domainInfo[tmp].push({start:row.Start, end:row.End, name:row.Name});
						});
					}
					var clustered = cluster(proteinNames, connections, proteinLengths);
					forceLines = clustered[0];
					maxValue = clustered[1];
					maxLength = clustered[2];
					nodes = clustered[3];
					
					var sort = new Sort(proteinNames, connections, names);
					proteinNames = sort.sort("alphabetical","L");
					appendOptions(document.getElementById("proteinSelectionList").options, proteinNames, names);
					draw();
					legend();
					document.getElementById("waitDialog").style.display = 'none';
				});
				if(minScore == 999999){
					document.getElementById('cutOffScore').disabled = "true";
				}else{
					document.getElementById('cutOffScore').min = minScore;
					document.getElementById('cutOffScore').max = maxScore;
					document.getElementById('cutOffScore').step = maxScore / 100;
					document.getElementById('scoreMin').innerHTML = minScore;
					document.getElementById('scoreMax').innerHTML = maxScore;
					if(<?php echo isset($_SESSION['loginAsUser'])? '"' . $_POST['scoreDirection'] . '"' : '"' . $scoreDirection . '"';?> == "<"){
						document.getElementById('cutOffScore').value = maxScore;
						document.getElementById('cutOffScoreValue').innerHTML = maxScore;
					}else{
						document.getElementById('cutOffScoreValue').innerHTML = minScore;
					}
				}
			});
	
			var width = $('#viz').width(),
				height = $('#viz').width(),
				svg = d3.select("#viz").append("svg:svg")
					.attr("width", width)
					.attr("height", height);

			svg=svg.append("g")
				.call(d3.behavior.zoom()
				.scaleExtent([1, 10])
				.on("zoom", zoom))
				.on("dblclick.zoom", null);
			svg.append("rect") 
				.attr("width", width)
				.attr("height", height)
				.attr("fill", "#ffffff")
				.attr("fill-opacity", 0);
				
			window.onresize =function(){ 
				width = $('#viz').width();
				height = $('#viz').width();
				d3.select("svg")
					.attr("width", width)
					.attr("height", height);
				if(d3.select("#legend")[0][0]!=null && d3.select("#legend")[0][0].firstElementChild != null){
					d3.select("#legend")[0][0].firstElementChild.attributes['width'].value = $("#legend").width() *0.99;
				}
			};
			window.onresize();

			var lines = svg.append("g").attr("id", "links");
			
			
			function draw(){	
				var color = d3.scale.category20();	
					
				var force = self.force = d3.layout.force()
					.nodes(nodes)
					.links(forceLines)
					.gravity(.1)
					.linkDistance(function(d){return (maxValue / d.value * 50 > 100) ? 100 : maxValue / d.value * 50})
					.charge(-1000)
					.size([width, height])
					.start();

				var forceLine = svg.select("#links")
					.data(svg.selectAll(".link"))
					.enter()
					.append("svg:line")
					.attr("class", "link")
					.attr("x1", function(d) { return d.source.x; })
					.attr("y1", function(d) { return d.source.y; })
					.attr("x2", function(d) { return d.target.x; })
					.attr("y2", function(d) { return d.target.y; })
					
				forceLine.append("title")
					.text(function(d) {  return d.source.name + "<->" + d.target.name + ": " + d.value; });

				var node_drag = d3.behavior.drag()
					.on("dragstart", dragstart)
					.on("drag", dragmove)
					.on("dragend", dragend);

				function dragstart(d, i) {
					svg.select("#links").selectAll("line").remove();
					svg.select("#links").selectAll("path").remove();
					hideMenu();
					force.stop() 
					d3.event.sourceEvent.stopPropagation();
				}
				function dragmove(d, i) {
					d.px += d3.event.dx;
					d.py += d3.event.dy;
					d.x += d3.event.dx;
					d.y += d3.event.dy; 
					tick(); 
				}
				function dragend(d, i) {
					d.fixed = true; 
					tick();
				   drawLinks(links);
				   
				}
				
				selectedProteins_();
				
				var node = svg.selectAll("g.node")
					.data(nodes)
					.enter()
					.append("g")
					.attr("display", function(d){return selectedProteins[d.name] ? "inline" : "none";})
					.attr("id", function(d) { return d.name; })
					.attr("transform", "translate(0,0)")
					.on("contextmenu", function(node, index) {
						d3.event.preventDefault();
						d3.event.stopPropagation();
						document.getElementById("contextMenu").style.zIndex = "1";
						var posx = d3.event.clientX + window.pageXOffset + 'px'; 
						var posy = d3.event.clientY + window.pageYOffset + 'px'; 
						document.getElementById("contextMenu").style.position = 'absolute';
						document.getElementById("contextMenu").style.display = 'inline';
						document.getElementById("contextMenu").style.left = posx;
						document.getElementById("contextMenu").style.top = posy; 
						document.getElementById("contextMenu").focus();
						document.getElementById("rotation").value = node.r == null ? 0 : node.r; 
						document.getElementById("selectedProtein").value  = node.name;
					})
					.on("dblclick", function () {window.open('http://www.uniprot.org/uniprot/' + this.attributes["id"].value);})
					.call(node_drag);
				  
				var rect=node.append("rect")
					.attr("x", function(d) {return - d.size / maxLength * sizeModifakator / 2})
					.attr("y",0)
					.attr("width", function(d) { return d.size / maxLength * sizeModifakator})
					.attr("height", 12)
					.style("fill", function(d) { return color(d.group); })
					.style("fill-opacity", 0.8)

				if(document.getElementById("showFrame").checked){
					rect.style("stroke", "black");
				}
					
				node.append("title")	
				  .text(function(d) { return names[d.name] != null ? names[d.name] : d.name});
				  
				node.append("svg:text")
					.attr("text-anchor", "middle")
					.attr("font-size", "10")
					.attr("dy", function(){
						namePos = document.getElementsByName("showProteinName")
						for(var i = 0; i < namePos.length; ++i){
							if(namePos[i].checked)
								return {"above":-8, "below":24, "inside":8.5}[namePos[i].value]
						}
					})
					.text(function(d) { return names[d.name] != null ? names[d.name] : d.name});
				
				if(document.getElementById("showNCTag").checked){
					node.append("svg:text")
						.attr("dx", function(d) {return - d.size / maxLength * sizeModifakator / 2 - 10})
						.attr("dy", "8")
						.attr("font-size", "10")
						.text(function(d){return flip[d.name] != null ? "C" : "N";});
					node.append("svg:text")
						.attr("dx", function(d) {return d.size / maxLength * sizeModifakator / 2 + 3})
						.attr("dy", "8")
						.attr("font-size", "10")
						.text(function(d){ return flip[d.name] != null ? "N" : "C";});
				}
				node.append("svg:text")
					.attr("dx", function(d) {return - d.size / maxLength * sizeModifakator / 2 + (flip[d.name] != null ? - (new String(d.size)).length * 2 : - 2.2)})
					.attr("dy", "-1.5")
					.attr("font-size", "8")
					.text(function(d) {return flip[d.name] != null ? d.size : 1;});
				node.append("svg:text")
					.attr("dx", function(d) {return d.size / maxLength * sizeModifakator / 2 + (flip[d.name] != null ? - 3 : - (new String(d.size)).length * 2)})
					.attr("dy", "-1.5")
					.attr("font-size", "8")
					.text(function(d) {return flip[d.name] != null ? 1 : d.size;});
					
				var j =0,
					selectedInterProDomains=[],
					interProDomainsSelectionList = document.getElementById("interProDomainsSelectionList");
				if(interProDomainsSelectionList != null){
					for(k = 0; k<interProDomainsSelectionList.length; k++){
						if(interProDomainsSelectionList[k].selected){
							selectedInterProDomains[interProDomainsSelectionList[k].value] = 1;
						}
					}
				}
				
				var conSurfColor = d3.scale.linear().domain([1, 5, 9]).range(["blue", "white", "red"]);
				
				for (i = 0; i < proteinNames.length; ++i) {
					if (domainInfo[proteinNames[i]] != null) {
						domainInfo[proteinNames[i]].forEach(function (domain) {
							svg.select("#" + proteinNames[i])
								.append("rect")
								.attr("x", function(d) {return - d.size / maxLength * sizeModifakator / 2 + (flip[proteinNames[i]] != null ? proteinLengths[proteinNames[i]] - domain.end : domain.start - 1) / maxLength * sizeModifakator})
								.attr("y",6.5)
								.attr("width", function(d) { return (domain.end - domain.start + 1) / maxLength * sizeModifakator})
								.attr("height", document.getElementById("showFrame").checked? 5 : 5.5)
								.attr("fill", stringToColour(domain.name))
								.style("fill-opacity", 0.8)
								.attr("id", "domain" + j)
								.append("svg:title")
								.text(domain.name + " (" + domain.start + "-" + domain.end + ")");
							j++;
						});
					}
					
					if (conservations[proteinNames[i]] != null) {
						conservations[proteinNames[i]].forEach(function (domain) {
							svg.select("#" + proteinNames[i])
								.append("rect")
								.attr("x", function(d) {return - d.size / maxLength * sizeModifakator / 2 + (flip[proteinNames[i]] != null ? proteinLengths[proteinNames[i]] - domain.end : domain.start - 1) / maxLength * sizeModifakator})
								.attr("y",8)
								.attr("width", function(d) { return (domain.end - domain.start + 1) / maxLength * sizeModifakator})
								.attr("height", document.getElementById("showFrame").checked? 3.5 : 4)
								.attr("fill", conSurfColor(parseFloat(domain.name)))
								.style("fill-opacity", 0.8)
								.append("svg:title")
								.text(domain.name + " (" + domain.start + "-" + domain.end + ")");
						});
					}
					
					if (interProDomains[proteinNames[i]] != null) {
						interProDomains[proteinNames[i]].forEach(function (domain) {
							if(selectedInterProDomains[domain.name] == 1){
								svg.select("#" + proteinNames[i])
									.append("rect")
									.attr("x", function(d) {return - d.size / maxLength * sizeModifakator / 2 +(flip[proteinNames[i]] != null ? proteinLengths[proteinNames[i]] - domain.end : domain.start - 1) / maxLength * sizeModifakator})
									.attr("y",document.getElementById("showFrame").checked? 0.5 : 0)
									.attr("width", function(d) { return (domain.end - domain.start + 1) / maxLength * sizeModifakator})
									.attr("height", document.getElementById("showFrame").checked? 5 : 5.5)
									.attr("fill", stringToColour(domain.name))
									.style("fill-opacity", 0.8)
									.append("title")	
									.text(domain.name + " (" + domain.start + "-" + domain.end + ")");
								j++;
							}
						});
					}	
					if (uniProtDomains[proteinNames[i]] != null) {
						uniProtDomains[proteinNames[i]].forEach(function (domain) {
							if(domain.name == 'Turn' && document.getElementById("turns").checked ||
								domain.name == 'Helix' && document.getElementById("helixes").checked || 
								domain.name == 'Beta strand'&& document.getElementById("betaStrands").checked){			
									svg.select("#" + proteinNames[i])
										.append("rect")
										.attr("x", function(d) {return - d.size / maxLength * sizeModifakator / 2 +(flip[proteinNames[i]] != null ? proteinLengths[proteinNames[i]] - domain.end :domain.start - 1) / maxLength * sizeModifakator})
										.attr("y", document.getElementById("showFrame").checked? 0.5 : 0)
										.attr("width", function(d) { return (domain.end - domain.start + 1) / maxLength * sizeModifakator})
										.attr("height", document.getElementById("showFrame").checked? 3.5 : 4)
										.attr("fill", function () {
											switch (domain.name) {
												case 'Turn':
													return document.getElementById("turnsColor").value;
												case 'Helix':
													return document.getElementById("helixesColor").value;
												case 'Beta strand':
													return document.getElementById("betaStrandsColor").value;
											}
										})
										.append("title")	
										.text(domain.name + " (" + domain.start + "-" + domain.end + ")");
							}
						});
					}		
				}
				if(forceOn){
					force.on("tick", tick).on("end",function(){ drawLinks(links)
						nodes.forEach(function (node) {
							node.fixed = true;
						});
					});
					forceOn = false;
				}else{
					force.alpha(0.1);
					force.on("tick", function(d){force.alpha(force.alpha() - 0.1); tick();}).on("end",function(){ drawLinks(links)
						nodes.forEach(function (node) {
							node.fixed = true;
						});
					});
				}

				function tick() {
					forceLine.attr("x1", function(d) { return d.source.x; })
						.attr("y1", function(d) { return d.source.y; })
						.attr("x2", function(d) { return d.target.x; })
						.attr("y2", function(d) { return d.target.y; });
					node.attr("transform", function(d) {return "translate(" + d.x + "," + d.y + ")rotate(" + (d.r  == null ? 0 : d.r)+")";  });
				};	
			}

			//FUNCTIONS
			function appendOptions(optionsTag, valueList, namesList){
				for( var i = 0; i < valueList.length; ++i){
					var opt = document.createElement('option');
					opt.value = valueList[i];
					opt.innerHTML = namesList[valueList[i]] != null ? namesList[valueList[i]] : valueList[i];
					opt.selected = "selected";
					optionsTag.add(opt);
				}
			}
			function cluster(proteinNames, connections, proteinLengths){
				var sort = new Sort(proteinNames,connections,names),
					forceLines = [],
					maxLength = 0,
					maxValue = 0.2, 
					nodes = [],
					offset = 0;
					array = sort.sort("<?php echo $_POST["sortTyp"];?>","A", getParams());
					
				for(var g = 0; g < array.length; ++g){
					for (var i = 0 ; i < array[g].length ; i++) {
						nodes[offset+i] = {"name":array[g][i],"size":proteinLengths[array[g][i]],"group":g}
						for (var j = 0 ; j < array[g].length ; j++) {
							if([array[g][i],array[g][j]].sort() in connections && connections[[array[g][i],array[g][j]].sort()]!= null){
								forceLines.push({"source":offset + i,"target":offset + j, "value": connections[[array[g][i],array[g][j]].sort()]});
								if(maxValue < connections[[array[g][i],array[g][j]].sort()]){
									maxValue = connections[[array[g][i],array[g][j]].sort()];
								}
							}
						}
						if(maxLength < proteinLengths[array[g][i]]){
							maxLength = proteinLengths[array[g][i]];
						}
					}
					offset += array[g].length;
				}
				return [forceLines, maxValue, maxLength, nodes];	
			}
			
			function drawLinks(links) {
				svg.select("#links").selectAll("line").remove();
				svg.select("#links").selectAll("path").remove();
					
				links.forEach(function (link) {
					if(scoreLink(link.score) && (selectedProteins[link.Protein1] && selectedProteins[link.Protein2])){
						if(link.Protein1 != link.Protein2 && document.getElementById("interProteinCrosslinks").checked  ){
							generateInterLink(lines, svg, link,  document.getElementById("interProteinCrosslinksColor").value, maxLength, sizeModifakator, proteinLengths);
						}
						if(link.Protein1 == link.Protein2 && document.getElementById("intraProteinCrosslinks").checked){
							generateIntraLink(lines, svg, link, document.getElementById("intraProteinCrosslinksColor").value, maxLength, sizeModifakator, proteinLengths);
						}
					}
				});
			}

			function getParams(){
				switch("<?php echo $_POST["sortTyp"];?>"){
					case "unconnectedSubgraphsMCL":
						return [document.getElementById("expansion").value, document.getElementById("inflation").value, document.getElementById("threshold").value];
					default: 
						return [];
				};
			}
			
			function color(i,k){
				return	["LightCoral", "MediumSpringGreen", "PaleGoldenrod", "HotPink", "DarkRed", "GreenYellow", "LightBlue",
					"DarkOrange", "Green", "RoyalBlue", "Coral", "DarkViolet", "Cyan", "Chocolate", "Thistle", "DarkBlue", "Gold",
					"Pink", "Tan", "SaddleBrown", "DodgerBlue", "YellowGreen", "OrangeRed", "Cornsilk", "LightSeaGreen", "Salmon",
					"PowderBlue", "DarkKhaki", "MistyRose", "SlateBlue", "Crimson", "MediumSlateBlue", "PapayaWhip", "LavenderBlush",
					"LightSteelBlue", "LightGreen", "Violet", "OldLace", "DarkGoldenrod", "OliveDrab", "SpringGreen", "Red", "PaleVioletRed",
					"LemonChiffon", "PeachPuff", "Purple", "RosyBrown", "Goldenrod", "BurlyWood", "MediumOrchid", "DarkOliveGreen",
					"PaleTurquoise", "Maroon", "Peru", "BlanchedAlmond", "Turquoise", "DarkGreen", "DeepSkyBlue", "CadetBlue", "Orange",
					"MediumTurquoise", "NavajoWhite", "Fuchsia", "FireBrick", "MidnightBlue", "Khaki", "Lime", "Orchid", "MediumVioletRed",
					"Olive", "Beige", "Plum", "DarkTurquoise", "Sienna", "LightPink", "Teal", "Yellow", "DarkSlateBlue", "MediumPurple",
					"DarkSalmon", "IndianRed", "SandyBrown", "DarkSeaGreen", "SkyBlue", "Tomato", "LightSalmon", "SeaGreen", "Moccasin",
					"CornflowerBlue", "SteelBlue", "LawnGreen", "BlueViolet", "LimeGreen", "AntiqueWhite", "Lavender", "MediumSeaGreen",
					"Indigo", "Aquamarine", "DeepPink", "MediumAquamarine" ][(i+k)%100];
			}

			function generateXProphetURL(row) {
				<?php if(!isset($_SESSION['loginAsUser'])){ ?>
				if(row.Id && row.Spectrum && row.Type && <?php echo "\"$domainURLXQuestServer?\"" ?> != "" && <?php echo "\"$idXQuestUser\""?> !=""){
					var seq = row.Id.split("-");
					return  <?php echo "\"$domainURLXQuestServer?\"+\n" ?>
						<?php echo "\"id=$idXQuestUser///" . substr($_POST['xQuestFile'], 0, strlen($_POST['xQuestFile'])-4) . ";\"+" ?>
						"plottype=spectrum;" +
						"spectrum=/tmp/" + row.Spectrum + ";" +
						"specfilename=" + row.Spectrum.replace(/.c.*/, '') + "_matched.spec.xml;" + 
						"type=" + row.Type + ";" + 
						"xlid=" + row.Id + ";" + 
						"seq1=" + seq[0] + ";" + 
						"seq2=" + seq[1] + ";" + 
						"xlpos=" + seq[2].replace('a', '') + "," + seq[3].replace('b', '') + ";" + 
						"xlmass=138.0680796;" +//default value???
						"scantype=light_heavy;" +//default value
						"lapS=-999";
				}
				<?php }?>
				return null;
			}

			function generateIntraLink(lines,svg, link, color, maxLength, sizeModifakator, proteinLengths){
				var n1 = svg.select("#"+link.Protein1).attr("transform").split(/[,\s]/),
					r = svg.select("#"+link.Protein1)[0][0].__data__.r,
					radius = Math.abs((link.Pos1 - link.Pos2) / maxLength * sizeModifakator * 0.5),
					position = radius  + ((flip[link.Protein1] != null ? proteinLengths[link.Protein1] - Math.max(link.Pos1, link.Pos2) + 0.5 : Math.min(link.Pos1, link.Pos2) - 0.5) - proteinLengths[link.Protein1] * 0.5) / maxLength * sizeModifakator, 
					
				arc = d3.svg.arc()
					.innerRadius(radius - 0.375)
					.outerRadius(radius + 0.375)
					.startAngle(-0.5 * Math.PI)
					.endAngle(0.5 * Math.PI);
				r = r == null ? 0 : r;
				
				lines.append("path")
					.attr("d", arc)
					.attr("transform", "translate(" + (parseFloat(n1[0].split("(")[1]) + position * Math.cos(r / 180 * Math.PI))+ 
						"," + (parseFloat(n1[1].split("(")[0]) + position * Math.sin(r / 180 * Math.PI)) + ") rotate(" + r + ")")
					.style("fill", color)
					.style("stroke-width", 0.75)
					.style("fill-opacity", 0.6).on("dblclick", function () {if(link.XProphetURL){window.open(link.XProphetURL);}})
					.append("svg:title").text("Crosslink " + (link.score != null ?"(" + link.scoreName + ": " + link.score + ")" : "") + "\n" +
													(link.name1 != null ? link.name1 : link.Protein1) + ": " + link.Pos1 + " <-> " +
													(link.name2 != null ? link.name2 : link.Protein2) + ": " + link.Pos2);
			}
			
			function generateInterLink(lines,svg, link, color, maxLength, sizeModifakator, proteinLengths){ 
				var n1 = svg.select("#"+link.Protein1).attr("transform").split(/[,\s]/),
					n2 = svg.select("#"+link.Protein2).attr("transform").split(/[,\s]/)
				var radius1 = (flip[link.Protein1] != null ? proteinLengths[link.Protein1] - link.Pos1 + 0.5 : link.Pos1 - 0.5) / maxLength * sizeModifakator,
					radius2 = (flip[link.Protein2] != null ? proteinLengths[link.Protein2] - link.Pos2 + 0.5 : link.Pos2 - 0.5) / maxLength * sizeModifakator,
					r1 = svg.select("#"+link.Protein1)[0][0].__data__.r,
					r2 = svg.select("#"+link.Protein2)[0][0].__data__.r;
					
					r1 = r1 == null ? 0 : r1;
					r2 = r2 == null ? 0 : r2;
					x1_y1 = adjustPosition(r1,r2,parseFloat(n1[0].split("(")[1]),
						parseFloat(n2[0].split("(")[1]),parseFloat(n1[1].split(")")[0]),
						parseFloat(n2[1].split(")")[0]));
					x2_y2 = adjustPosition(r2,r1,parseFloat(n2[0].split("(")[1]),
						parseFloat(n1[0].split("(")[1]),parseFloat(n2[1].split(")")[0]),
						parseFloat(n1[1].split(")")[0]));
					
				lines.append("line")
					.attr("x1", function(d){return parseFloat(n1[0].split("(")[1]) 
						+ (r1 == null ? radius1-proteinLengths[link.Protein1] / maxLength * sizeModifakator / 2 : (radius1-proteinLengths[link.Protein1] / maxLength * sizeModifakator / 2)* Math.cos(r1 / 180 * Math.PI))
						+x1_y1[0]})
					.attr("x2", function(){return parseFloat(n2[0].split("(")[1]) + (r2 == null ? radius2 - proteinLengths[link.Protein2] / maxLength * sizeModifakator / 2 : (radius2 - proteinLengths[link.Protein2] / maxLength * sizeModifakator / 2) * Math.cos(r2 / 180 * Math.PI))
						+x2_y2[0]})
					.attr("y1", + parseFloat(n1[1].split(")")[0]) + (r1 == null ? 0 : (radius1 - proteinLengths[link.Protein1] / maxLength * sizeModifakator / 2) * Math.sin(r1 / 180 * Math.PI)) + x1_y1[1])
					.attr("y2", + parseFloat(n2[1].split(")")[0]) + (r2 == null ? 0 : (radius2-proteinLengths[link.Protein2]/ maxLength * sizeModifakator / 2) * Math.sin(r2/180*Math.PI)) + x2_y2[1])
					.style("stroke", color)
					.style("stroke-width", 0.75)
					.style("stroke-opacity", 0.6).on("dblclick", function () {if(link.XProphetURL){window.open(link.XProphetURL);}})
					.append("svg:title").text("Crosslink " + (link.score != null ?"(" + link.scoreName + ": " + link.score + ")" : "") + "\n" +
													(link.name1 != null ? link.name1 : link.Protein1) + ": " + link.Pos1 + " <-> " +
													(link.name2 != null ? link.name2 : link.Protein2) + ": " + link.Pos2); 
			}

			

			function adjustPosition(rc,ro,xc,xo,yc,yo){
				y_s = Math.atan(rc) * xo + yc - Math.atan(rc) * (xc);
				v=[xo,yo-y_s];

				if(v[1] > 0){
					return [- 12 * Math.sin(rc / 180 * Math.PI), 12 * Math.cos(rc / 180 * Math.PI)];
				}
				if(90 < rc && rc <= 180 && -( Math.atan(rc) * (xc)) / Math.atan(rc)  + xo < 0){
					return [- 12 * Math.sin(rc / 180 * Math.PI), 12 * Math.cos(rc / 180 * Math.PI)];
				}
				if(180 < rc && rc < 270 && rc * (xo - xc) + yc > yc){
					return [- 12 * Math.sin(rc / 180 * Math.PI), 12 * Math.cos(rc / 180 * Math.PI)];
				}
				if(270 < rc && rc < 360 && rc * (xo - xc) + yc > yc){
					return [- 12 * Math.sin(rc / 180 * Math.PI), 12 * Math.cos(rc / 180 * Math.PI)];
				}
				return [0, 0];
			}

			function updateCluster(){
				var color = d3.scale.category20();
				lines = svg.append("g").attr("id", "links");
				cluster(proteinNames, connections, proteinLengths)[3].forEach( function(node){
					svg.select("g#"+node.name).select("rect").attr("style", function(d) { d.group=node.group; return "fill: " + color(d.group); });
					if(document.getElementById("showFrame").checked){
						svg.select("g#"+node.name).select("rect").style("stroke", "black");
					}
				});
				redraw();
			}

			function redraw(){
				svg.selectAll('g').remove();
				lines = svg.append("g").attr("id", "links");
				draw();
			}

			function scoreLink(value){
				if(value == null){
					return true;
				}
				if(value != null && value <?php echo isset($_SESSION['loginAsUser']) ? $_POST['scoreDirection'] . '=' : "$scoreDirection" . "=";?> document.getElementById('cutOffScoreValue').innerHTML){
					return true;
				}
				return false;
			}

			function hideMenu() {
				document.getElementById("contextMenu").style.display = 'none'; 
				document.getElementById('rotation').className = 'form-group';
				document.getElementById("contextMenu").getElementsByTagName("small")[0].style.display = 'none';
			}

			function transformProtein(){
				var proteinName = document.getElementById("selectedProtein").value;
				svg.select("g#"+proteinName)
					.attr("transform", function (d){d.r = document.getElementById("rotation").value; 
						return "translate(" + d.x + "," + d.y + ")rotate(" + (d.r  == null ? 0 : d.r)+")";
					})
					drawLinks(links);
				if(document.getElementById("flipVertical").checked){
					var protein = svg.select("g#"+proteinName).selectAll("text")[0];
					flip[proteinName]	= (flip[proteinName] == null ? true : null);
					document.getElementById("flipVertical").checked = false;
					svg.selectAll('g').remove();
					lines = svg.append("g").attr("id", "links");
					draw();
				}
			}

			function zoom(){
				hideMenu();
				svg.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
			}
				//stack overflow
			function stringToColour(str) {
				for (var i = 0, hash = 0; i < str.length; hash = str.charCodeAt(i++) + ((hash << 5) - hash));
				for (var i = 0, colour = "#"; i < 3; colour += ("00" + ((hash >> i++ * 8) & 0xFF).toString(16)).slice(-2));
				return colour;
			}
			function update(){
				if(document.getElementById('rotation').parentElement.className=='form-group'){
					transformProtein();
					hideMenu();
				}
			}
			
			function selectedProteins_(){
				var list = document.getElementById("proteinSelectionList");
				for (var i = 0; i < list.length; i++){
					selectedProteins[list[i].value] = list[i].selected;
				}
			}
			function legend(){
				var list = document.getElementById("interProDomainsSelectionList"),
					legendWidth = $("#legend").width() *0.99,
					legend = d3.select("#legend").append("svg")
						.attr("width",legendWidth)
						.attr("height", 0),
					offset = 0;
					if(list != null){
						offset += 10;
						offset += printLegendInterPro(legend, list, offset);
					}
					if(Object.keys(domainInfo).length > 0){
						offset += 10;
						offset = printLegendUserAnnotation(legend, domainInfo, offset);
					}
					legend.attr("height", offset);
			}
			
			function printLegendInterPro(legend, list, offset){
				legend.append("text")
					.attr("x", 10)
					.attr("y", 14 + offset)
					.style("font-size", "14px")
					.text("InterPro Annotations");   
		   
				for(var i = 0; i < list.length; i++){
					legend.append("rect")
						  .attr("x", 10)
						  .attr("y", (i * 15 + 20 + offset))
						  .attr("width", 10)
						  .attr("height", 10)
						  .attr("fill", stringToColour(list[i].value));
					var text = legend.append("text")
						   .attr("x", 25)
						   .attr("y", (i * 15 + 27.5 + offset))
						   .style("font-size", "10px")
						   .text(list[i].value)
						text.append("svg:title").text(list[i].value);
						
				}
				return offset + list.length * 15 +16;
			}
			function printLegendUserAnnotation(legend, list, offset){
				legend.append("text")
					.attr("x", 10)
					.attr("y", 14 + offset)
					.style("font-size", "14px")
					.text("User-defined annotations"); 
				var map = {};
				for(var j = 0; j < proteinNames.length; j++){
					if(list[proteinNames[j]] != null){
						for(var i = 0; i < list[proteinNames[j]].length; i++){
							if(!map[list[proteinNames[j]][i]]){
								legend.append("rect")
									.attr("x", 10)
									.attr("y", (20 + offset))
									.attr("width", 10)
									.attr("height", 10)
									.attr("fill", stringToColour(list[proteinNames[j]][i].name));
								var text = legend.append("text")
									.attr("x", 25)
									.attr("y", (27.5 + offset))
									.style("font-size", "10px")
									.text(list[proteinNames[j]][i].name);
								text.append("svg:title").text(list[proteinNames[j]][i].name);
								map[list[proteinNames[j]][i].name] = true;
								offset += 15;
							}
						}
					}
				}
				return offset + 20;
			}
		</script>
	</body>
</html>
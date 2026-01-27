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
						<?php function colorOptions($defaultValue){
							$colors = array("White" ,"Silver" ,"Gray", "Black", "Red", "Maroon", "Yellow", "Olive", "Lime", "Green", "Aqua", "Teal", "Navy", "Fuchsia", "Purple", "Blue");
							for($i = 0; $i < sizeof($colors); $i++){
								echo "<option value=\"".$colors[$i]."\" ". (($defaultValue==$i)?"selected":"") .">".$colors[$i]."</option>"; 
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
														echo "<option value=\"" . $name . "\"selected>" . $name . "</option>";
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
											<label for="proteinSelectionList">Show Crosslinks from Selected Proteins</label>
											<select id="proteinSelectionList" class="form-control" name="proteinSelectionList[]" multiple="multiple" size="4"
												data-toggle="tooltip" data-placement="top" title="Multiple Selection">
											</select>
										</div>
										<div class="form-group">
											<label> Cut-Off Score</label>
											<div class="input-group">
												<span class="input-group-addon" id="scoreMin">0</span>
												<input id="cutOffScore" type=range class="form-control" min="0.0" max="10" step="0.01" value="0"
													oninput="document.getElementById('cutOffScoreValue').innerHTML = parseFloat(this.value).toFixed(2)"
													onchange="document.getElementById('cutOffScoreValue').innerHTML = parseFloat(this.value).toFixed(2)">
												</input>
												<span class="input-group-addon" id="scoreMax">0</span>
												<span class="input-group-addon">Cut-Off: <label id="cutOffScoreValue">0</label></span>
											</div>
										</div>
										<input type="button" class="btn btn-primary" value="Redraw" onclick="redraw()" />
									</form>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseSVG">
										<small>
											<span class="glyphicon glyphicon-plus" id="collapseSVGIcon"/>
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
											<input type="text" class="form-control" id="outputName" name="outputName" oninput="validateInput()" value="<?php $_=@explode("/", $path . $_POST["xQuestFile"]); $_=@explode(".",$_[4]); echo $_[0] ?>_circularPlot">
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

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery-2.1.0.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/d3.v3.js"></script>
		<script type="text/javascript" src="js/sort.js"></script>
		
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
			
			$(".checkbox").on("change", function(event){
				$('#' + event.target.id + 'Color')[0].disabled = (!$('#' + event.target.id + 'Color')[0].disabled);
			});
		</script>

		<script type="text/javascript">
			var	initialWidth = $('#viz').width(), 
				initialHeight = initialWidth,
				initialInnerRadius = Math.min(initialWidth, initialHeight) * .29,
				initialOuterRadius = initialInnerRadius * 1.1;
				width = initialWidth,
				height = initialHeight,
				innerRadius = initialInnerRadius,
				outerRadius = initialOuterRadius,
				svg = d3.select("#viz").append("svg")
					.attr("width", width)
					.attr("height", height),
				space = 0.5,
				proteins = [],
				proteinNames = [],
				links = [],
				connections = [],
				domainInfo = []; 
				
				svg = svg.append("g")
					.call(d3.behavior.zoom()
					.scaleExtent([1, 10])
					.on("zoom", zoom))
					.on("dblclick.zoom", null)
					
				svg.append("rect") 
					.attr("width", width)
					.attr("height", height)
					.attr("fill", "#ffffff")
					.attr("fill-opacity", 0);
				
			var zoomLvl = 1, 
				startpositions=[];
			
			window.onresize = function(){ 
				initialWidth = $('#viz').width();
				initialHeight = $('#viz').width();
				initialInnerRadius = Math.min(initialWidth, initialHeight) * .29;
				initialOuterRadius = initialInnerRadius*1.1;
				width = initialWidth;
				height = initialHeight;
				
				d3.select("svg")
					.attr("width", width)
					.attr("height", height);
					
				innerRadius = initialInnerRadius;
				outerRadius = initialOuterRadius;
				svg.selectAll("g").remove();
				if(d3.select("#legend")[0][0]!=null && d3.select("#legend")[0][0].firstElementChild != null){
					d3.select("#legend")[0][0].firstElementChild.attributes['width'].value = $("#legend").width() *0.99;
				}
				draw();
				
			};
			window.onresize();

			var names = [],
				score = <?php echo isset($_SESSION['loginAsUser']) ? '"' . $_POST['scoreColumn'] . '"' : "\"$scoreColumn\"";?>,
				minScore = 999999;
				maxScore = 0;
				
			d3.csv("<?php echo 'ajax.php?ftype=xQuestFile&file=' . (isset($_POST['xQuestFile']) ? $_POST['xQuestFile'] : '');?>", function(data) {
				data.forEach(function(row) {
					var prot1 = row.Protein1.split("\|"),
						prot2 = row.Protein2.split("\|"),
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
					connections[index] = (connections[index] == null)? 1 : connections[index] + 1;
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
				d3.csv("<?php echo 'ajax.php?ftype=domainFile&file=' . (isset($_POST["domainFile"]) ? $_POST["domainFile"] : '');?>", function(data2) { 
					if(data2 != null){
						data2.forEach(function(row) {
							var tmp = row.Protein.split("\|").length == 3  ?  row.Protein.split("\|")[1] : row.Protein;
							
							if(domainInfo[tmp] == null){
								domainInfo[tmp] = [];
							}
							domainInfo[tmp].push({start:row.Start, end:row.End, name:row.Name});
						});
					}
					var sort = new Sort(proteinNames,connections,names);
					
					proteinNames = sort.sort("<?php echo $_POST["sortTyp"];?>","L");
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
			function draw(){
				var radialLength = sum(proteinLengths) + space * proteinNames.length,
					start = 0,
					end = 0,
					arcs = [],
					selectedInterProDomains=[],
					interProDomainsSelectionList = document.getElementById("interProDomainsSelectionList");
					
				if(interProDomainsSelectionList != null){
					for(k = 0; k < interProDomainsSelectionList.length; k++){
						if(interProDomainsSelectionList[k].selected){
							selectedInterProDomains[interProDomainsSelectionList[k].value] = 1;
						}
					}
				}
				
				var conSurfColor = d3.scale.linear().domain([1, 5, 9]).range(["blue", "white", "red"]);

				for (i = 0; i < proteinNames.length; ++i) {
					var fontSize = 120 * (outerRadius - innerRadius) * proteinLengths[proteinNames[i]] / (proteinNames[i].length * radialLength),
						arc = d3.svg.arc()
							.innerRadius(innerRadius)
							.outerRadius(outerRadius)
							.startAngle(start) 
							.endAngle(start+proteinLengths[proteinNames[i]] / radialLength * Math.PI * 2),
						g = svg.append("g")
							.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")")
							.attr("name", proteinNames[i])
							.on("dblclick", function () {window.open('http://www.uniprot.org/uniprot/' + this.attributes["name"].value);});
							
					startpositions[proteinNames[i]] = {start : start, proteinLength : proteinLengths[proteinNames[i]]};

					g.append("path")
						.attr("d", arc)
						.attr("fill", color(i, 0))
						.style("fill-opacity", 0.6)
						.attr("id", "path" + i)
						.append("svg:title")
						.text( names[proteinNames[i]] != null ? names[proteinNames[i]] : proteinNames[i]);
					g.append("svg:text")
						.attr("id", i)
						.attr("class", "proteinName")
						.attr("text-anchor", "middle")
						.attr("alignment-baseline", "middle")
						.attr("x", (90 + outerRadius)* Math.cos(startpositions[proteinNames[i]].start + startpositions[proteinNames[i]].proteinLength / radialLength * Math.PI - 0.5 * Math.PI ))
						.attr("y", (90 + outerRadius)  * Math.sin(startpositions[proteinNames[i]].start + startpositions[proteinNames[i]].proteinLength / radialLength * Math.PI - 0.5 * Math.PI))
						.text(names[proteinNames[i]] != null ? names[proteinNames[i]] : proteinNames[i])
						.attr("fill", "black")
						.on('mousedown', function() { d3.select(this).attr("fill", (d3.select(this).attr("fill") == "black") ? color(parseFloat(this.id), 0) : "black");});

					var j = 0, outerRadiusDomain = innerRadius + (outerRadius - innerRadius) * 0.4;
					
					if (domainInfo[proteinNames[i]] != null) {
						domainInfo[proteinNames[i]].forEach(function (domain) {
							arc = d3.svg.arc()
								.innerRadius(innerRadius)
								.outerRadius(outerRadiusDomain)
								.startAngle(start + (domain.start-1) / radialLength * Math.PI * 2)
								.endAngle(start + domain.end / radialLength * Math.PI * 2);
							g.append("path")
								.attr("d", arc)
								.attr("fill", stringToColour(domain.name))
								.style("fill-opacity", 0.8)
								.attr("id", "domain" + j)
								.append("svg:title")
								.text(domain.name + " (" + domain.start + "-" + domain.end + ")");								
							j++;
						});
					}
					var j = 0;
					
					if (conservations[proteinNames[i]] != null) {
						conservations[proteinNames[i]].forEach(function (domain) {
							arc = d3.svg.arc()
								.innerRadius(innerRadius)
								.outerRadius(innerRadius + (outerRadius - innerRadius) * 0.3)
								.startAngle(start + (domain.start-1) / radialLength * Math.PI * 2)
								.endAngle(start + domain.end / radialLength * Math.PI * 2);
							g.append("path")
								.attr("d", arc)
								.attr("fill", conSurfColor(parseFloat(domain.name)))
								.style("fill-opacity", 0.8)
								.attr("id", "domain" + j)
								.append("svg:title")
								.text(domain.name + " (" + domain.start + "-" + domain.end + ")");								
							j++;
						});
					}

					if (interProDomains[proteinNames[i]] != null) {
						interProDomains[proteinNames[i]].forEach(function (domain) {
							if(selectedInterProDomains[domain.name] == 1){
								arc = d3.svg.arc()
									.innerRadius(outerRadius - (outerRadius - innerRadius) * 0.4)
									.outerRadius(outerRadius)
									.startAngle(start + (domain.start-1) / radialLength * Math.PI * 2)
									.endAngle(start + domain.end / radialLength * Math.PI * 2);
								g.append("path")
									.attr("d", arc)
									.attr("fill", stringToColour(domain.name))
									.style("fill-opacity", 0.8)
									.attr("id", "interProdomain" + j)
									.append("svg:title")
									.text(domain.name + " (" + domain.start + "-" + domain.end + ")");
							}
							j++;
						});
					}
					if (uniProtDomains[proteinNames[i]] != null) {
						uniProtDomains[proteinNames[i]].forEach(function (domain) {
							if(domain.name == 'Turn' && document.getElementById("turns").checked ||
								domain.name == 'Helix' && document.getElementById("helixes").checked || 
								domain.name == 'Beta strand'&& document.getElementById("betaStrands").checked){
									
								arc = d3.svg.arc()
									.innerRadius(outerRadius - (outerRadius - innerRadius) * 0.3)
									.outerRadius(outerRadius)
									.startAngle(start + (domain.start-1) / radialLength * Math.PI * 2)
									.endAngle(start + domain.end / radialLength * Math.PI * 2);
								g.append("path")
									.attr("d", arc).attr("fill", function () {
										switch (domain.name) {
											case 'Turn':
												return document.getElementById("turnsColor").value;
											case 'Helix':
												return document.getElementById("helixesColor").value;
											case 'Beta strand':
												return document.getElementById("betaStrandsColor").value;
										}
									})
									.attr("id", "uniProtdomain" + j)
									.append("svg:title")
									.text(domain.name + " (" + domain.start + "-" + domain.end + ")");
							}
							j++;
						});
					}
					end = start + proteinLengths[proteinNames[i]] / radialLength * Math.PI * 2;
			
					function groupTicks(d) {
						var k = (end - start) /proteinLengths[proteinNames[i]];

						if (radialLength / proteinNames.length > 500 && proteinNames.length < 30) {
							return calculateGroupTicks([50, 5], k);
						}
						if (radialLength / proteinNames.length < 500 && proteinNames.length < 30) {
							return calculateGroupTicks([25, 4], k);
						}
					}
					
					function calculateGroupTicks(d, k) {
						return d3.range(0, proteinLengths[proteinNames[i]], (zoomLvl > 4) ? d[0] / 5 : (zoomLvl < 1) ? d[0] * 2 : d[0]).map(function(v, j) {
							if(v == 0) v = 1;
							return {
								angle : v * k + start, label : j % d[1] != 0 ? null  : j==0? "" : v
							};
						});
					}
					var ticks = g.selectAll("g")
						.data(groupTicks).enter()
						.append("g")
						.attr("id", "tickgroup" + i)
						.attr("transform", function (d) {
							return"rotate(" + ((d.angle - 0.5 / radialLength * Math.PI * 2) * 180 / Math.PI - 90) + ")" + "translate(" + outerRadius + ",0)";
						});
					ticks.append("line")
						.attr("x1", 1)
						.attr("y1", 0)
						.attr("x2", function (d) { return d.label != null ? 8 : 5;})
						.attr("y2", 0)
						.style("stroke", "#000");
						
					ticks.append("text")
						.attr("x", 8)
						.attr("dy", ".35em")
						.attr("font-size", "13")
						.attr("transform", function (d) { return d.angle > Math.PI ? "rotate(180)translate(-16)" : null;})
						.style("text-anchor", function (d) { return d.angle > Math.PI ? "end" : null;})
						.text(function (d) { return d.label;});

					start = start + (proteinLengths[proteinNames[i]] + space) / radialLength * Math.PI * 2;
				}

				lines = svg.append("g").attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");
				
				var selectedProteins=[],
					proteinSelectionList = document.getElementById("proteinSelectionList");
					
				for(i = 0; i < proteinSelectionList.length; i++){
					if(proteinSelectionList[i].selected){
						selectedProteins.push(proteinSelectionList[i].value);
					}
				}
				links.forEach(function (link) {
					if(scoreLink(link.score) && (selectedProteins.indexOf(link.Protein1) + 1 || selectedProteins.indexOf(link.Protein2) + 1)){
						if(link.Protein1 != link.Protein2 && document.getElementById("interProteinCrosslinks").checked  ){
							generateLine(lines,link, document.getElementById("interProteinCrosslinksColor").value, radialLength);
						}
						if(link.Protein1 == link.Protein2 && document.getElementById("intraProteinCrosslinks").checked){
							generateLine(lines,link, document.getElementById("intraProteinCrosslinksColor").value, radialLength );
						}
					}
				});
				arrangeLabels();
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

			function generateLine(lines, link, color, radialLength){
				var lineData = [{ "x": innerRadius * Math.cos(position(startpositions[link.Protein1].start, link.Pos1, radialLength)),
								  "y": innerRadius * Math.sin(position(startpositions[link.Protein1].start, link.Pos1, radialLength))},
								{ "x": 0,  "y": 0},
								{ "x": innerRadius * Math.cos(position(startpositions[link.Protein2].start, link.Pos2, radialLength)),
								  "y": innerRadius * Math.sin(position(startpositions[link.Protein2].start, link.Pos2, radialLength))}],
					tension= Math.sqrt((lineData[0].x - lineData[2].x) * (lineData[0].x - lineData[2].x)  + (lineData[0].y - lineData[2].y) * (lineData[0].y - lineData[2].y) + 40) / innerRadius / 2,
					lineFunction = d3.svg.line()
						.x(function(d) { return d.x; })
						.y(function(d) { return d.y; })
						.interpolate("bundle").tension(tension),
					lineGraph = lines.append("path")
						.attr("d", lineFunction(lineData))
						.attr("fill", "none")
						.style("stroke", color).style("stroke-width", zoomLvl * 0.75).style("stroke-opacity", 0.6).on("dblclick", function () {
							if(link.XProphetURL!= null){window.open(link.XProphetURL);}
						})
						.append("svg:title").text("Crosslink " + (link.score != null ?"(" + link.scoreName + ": " + link.score + ")" : "") + "\n" +
												(link.name1 != null ? link.name1 : link.Protein1) + ": " + link.Pos1 + " <-> " +
												(link.name2 != null ? link.name2 : link.Protein2) + ": " + link.Pos2); 		 			 
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
						"xlmass=138.0680796;" +
						"scantype=light_heavy;" +
						"lapS=-999";
				}
				<?php }?>
				return null;
			}

			function position(start, p, radialLength) {
				return start + (p-0.5) / radialLength * Math.PI * 2 - 0.5 * Math.PI;
			}

			function redraw(){
				svg.selectAll('g').remove();
				draw();
			}

			function sum( obj ) {
				var sum = 0;
				for( var el in obj ) {
					if( obj.hasOwnProperty( el ) ){
						sum += parseFloat( obj[el] );
					}
				}
				return sum;
			}

			function scoreLink(value){
				if(value == null){
					return true;
				}
				if(value != null && value <?php echo isset($_SESSION['loginAsUser']) ? $_POST['scoreDirection'] . '=' :"$scoreDirection" . "=";?> document.getElementById('cutOffScoreValue').innerHTML){
					return true;
				}
				return false;
			}

			function zoom() {
				svg.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")")			
			}
				//stack overflow
			function stringToColour(str) {
				for (var i = 0, hash = 0; i < str.length; hash = str.charCodeAt(i++) + ((hash << 5) - hash));
				for (var i = 0, colour = "#"; i < 3; colour += ("00" + ((hash >> i++ * 8) & 0xFF).toString(16)).slice(-2));
				return colour;
			}
			
			//http://bl.ocks.org
			function arrangeLabels() {
				var move = 1;
				while(move > 0) {
					move = 0;
					svg.selectAll(".proteinName")
					   .each(function() {
						var that = this,
							a = this.getBoundingClientRect();
							svg.selectAll(".proteinName")
								.each(function() {
									if(this != that) {
										var b = this.getBoundingClientRect();
										if((Math.abs(a.left - b.left) * 2 < (a.width + b.width)) &&
										   (Math.abs(a.top - b.top) * 2 < (a.height + b.height))) {
										  // overlap, move labels
											var dx = (Math.max(0, a.right - b.left) +
												   Math.min(0, a.left - b.right)) * 0.01 + 2,
												dy = (Math.max(0, a.bottom - b.top) +
												   Math.min(0, a.top - b.bottom)) * 0.02 + 2,
												tt = d3.transform(d3.select(this).attr("transform")),
												to = d3.transform(d3.select(that).attr("transform"));
											move += Math.abs(dx) + Math.abs(dy);
										
											to.translate = [ to.translate[0] + dx, to.translate[1] + dy ];
											tt.translate = [ tt.translate[0] - dx, tt.translate[1] - dy ];
											d3.select(this).attr("transform", "translate(" + tt.translate + ")");
											d3.select(that).attr("transform", "translate(" + to.translate + ")");
											a = this.getBoundingClientRect();
										}
									}
								});
						});
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

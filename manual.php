<!DOCTYPE html>
<?php session_start() ?>
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
					<a class="navbar-brand" href=<?php echo isset($_SESSION['user'])? '"CrossVis.php"' : '"index.php"' ?>><?php echo isset($_SESSION['user'])? 'xVis' : 'Home' ?></a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="downloads.php"><span class="glyphicon glyphicon-download"></span> Downloads</a></li>
						<li><a href="contact.php"><span class="glyphicon glyphicon-envelope"></span> Contact</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div><!--/.container-fluid -->
		</div>
	
		<div class="container">	
			<h1>Manual</h1>
			<p><span style="color:#777;">Contact:</span> <a href="mailto:herzog@genzentrum.lmu.de">Franz Herzog - herzog@genzentrum.lmu.de</a>, <a href="mailto:grimm@genzentrum.lmu.de">Maximilian Grimm - grimm@genzentrum.lmu.de</a></p>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Background</h2>
				</div>
				<div class="panel-body">
					<p>Chemical crosslinking combined with mass spectrometry has recently been established as state-of-the-art workflow for the structural analysis of macromolecular protein complexes. The output of the crosslinking analysis is the proximity information between two amino acids linked by the bifunctional chemical agent and is typically summarized in a table format which does not allow an immediate and comprehensive interpretation of the topological data. We developed <span style="color:#777; font-weight:bold">xVis</span>, a server-client-based software solution, to visualize the crosslink derived distance restraints of protein complexes that describe their architecture. <span style="color:#777; font-weight:bold">xVis</span> displays cross-links in clear schematic representations in form of a pie chart, a bar chart or a network diagram. The subunit proteins of a complex are displayed as bars or segments of a circle scaled to the protein lengths, lines connecting specific positions of the bars or the segments indicate the crosslinking sites within the protein sequence from the N- to the C-terminus. The software facilitates the importing of user-defined protein motifs as well as annotated domains from public databases. The graphs reveal the spatial proximity of proteins and their structurally and functionally annotated motifs which is crucial for the initial structural and functional interpretation prior to the more laborious generation of three-dimensional models.</p>
					<p>Furthermore, the program offers two options for the qualitative assessment of the crosslink identifications. First, filtering the crosslinks according to the identification score or the false discovery rate allows for the selective representation of restraints below or above a certain threshold value. Second, <span style="color:#777; font-weight:bold">xVis</span> provides a link between each crosslink and the corresponding fragment ion spectrum for the manual inspection of the mass spectrometric data. <span style="color:#777; font-weight:bold">xVis</span> was developed for the representation of crosslinks identified by the software <span style="color:#777; font-weight:bold">xQuest</span>, however, it also supports the visualization of crosslink results obtained from various other search engines providing the appropriate format of the input data.</p>
					<p>This software solution represents an easy-to-use tool for the fast and clear representation of distance information on protein complex structures and for the evaluation of the mass spectrometric identification of the crosslinks.</p> 
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Introduction and Sample Data</h2>
				</div>
				<div class="panel-body">
					<p>The sample data set was acquired by analyzing the multi-subunit chromatin remodeler INO80 in complex with its nucleosome substrate (Tosi et al. 2013 Cell). The INO80 complex was purified by affinity-chromatography from budding yeast and reconstituted in complex with a mono-nucleosome.  This supramolecular assembly was crosslinked with isotope-coded BS3 (Bis[sulfosuccinimidyl] suberate). The crosslinked complex was digested with trypsin and the crosslink fractions were analyzed by tandem mass spectrometry (Jennebach et al. 2012 Nucleic Acids Res; Herzog et al. 2012 Science). The resulting spectra were searched by the software <span style="color:#777; font-weight:bold">xQuest</span> (Walzthoeni et al. 2012 Nat Methods) and visualized by <span style="color:#777; font-weight:bold">xVis</span>.</p>
					<p>The dataset is composed of 274 intra-protein and 149 inter-protein crosslinks detected on 18 proteins. The sample data is available under <a href="downloads.php">Test Data</a>. For testing <span style="color:#777; font-weight:bold">xVis</span> download the test data and follow the instructions in the manual sections <a href="#GeneratingAPlot">Generating a Plot</a>.</p>
					<p>The access of <span style="color:#777; font-weight:bold">xVis</span> without login provides all features and display options. The use of <span style="color:#777; font-weight:bold">xVis</span> with an account (see section <a href="#FileManagement">File Management</a>) allows storing the settings of the <span style="color:#777; font-weight:bold">xVis</span> analysis, for example, datasets with the preconfigured filter settings. Additionally, the login is required for connecting to the <span style="color:#777; font-weight:bold">xQuest</span> server in order to view and evaluate the fragment ion mass spectra of the respective crosslink. You may enter a URL under <em>Settings</em> to connect to <a href="http://proteomics.ethz.ch/cgi-bin/xquest2_cgi/index.cgi">xQuest</a>, the search engine that identifies the crosslinks from mass spectrometric data and displays the fragment ion spectra as htmls (see sections: <a href="#CircularPlotFunctions_DoubleClick">Functions</a>,  <a href="#Settings_xQuest">Settings</a>). For the analysis of the test data we linked the corresponding fragment ion spectra htmls and allocate a test user account (username: test_user; password: user-56).</p>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Input Data</h2>
				</div>
				<div class="panel-body">
					<a name="ProteinIdentifier"></a>
					<h3>Protein identifier</h3>
					<p>The protein identifier is used to link protein names to crosslink data and annotations. Therefore, you have to consistently use a unique name in each of the input files. You may choose one of the following three protein identifiers in your input files: UniProt-ID, FASTA-header or user-defined names. The protein name in the crosslink data input file is shown in the representation. It is possible to combine UniProt-IDs and FASTA-header. If you use the FASTA-header in the crosslink data input files only the Entry Name without the accession number is displayed. To generate a plot with user-defined protein names you have to disable <em>Use UniProt protein lengths</em> and to upload a <em>Protein Lengths File</em> using the same user-defined names as in the crosslink data file (see section: <a href="#ProteinLengthsFile">Protein Lengths File</a>).</p>
					
					<h3><small>FASTA-header</small></h3>
					<p>The term FASTA-header defines the following part of the UniProt-FASTA-header (see <a href="http://www.uniprot.org/help/fasta-headers">http://www.uniprot.org/help/fasta-headers</a>): <em>Database|UniqueIdentifier|EntryName</em> like <em>sp|P53115|INO80_YEAST</em>. The source Database is ignored. Isoform identifiers like <em>Q4R572-2</em> are not allowed. By removing <em>-2</em> you get a permissive identifier. You may keep the Entry Name from the UniProt-FASTA-header or use a user-defined name instead. If you use a user-defined name it must follow the rules below (section: User-defined protein name).</p>
					
					<h3><small>UniProt-ID</h3></small>
					<p>A UniProt-ID is the Unique Identifier of entries in UniProt (also known as UniProtKB accession number). It consists of 6 or 10 alphanumerical characters. For details see <a href="http://www.uniprot.org/help/accession_numbers">http://www.uniprot.org/help/accession_numbers</a>.</p>
					
					<h3><small>User-defined protein name</h3></small>
					<p>The user-defined name may consist of capital and lowercase letters, spaces, minus signs, numbers, brackets and underline characters. Special characters like comma, semicolon, quote or vertical bar are not allowed.</p>
					
					<h3><small>xVis options depend on the appropriate protein identifier</small></h3>
					<table class="table table-condensed table-bordered">
						<tr>
							<th>Option</th>
							<th class="text-center">User-defined name</th>
							<th class="text-center">UniProt-ID</th>
							<th class="text-center">FASTA-header</th>
						</tr>
						<tr>
							<td>Import protein lengths from UniProt</td>
							<td class="text-center">-*</td>
							<td class="text-center">+</td>
							<td class="text-center">+</td>
						</tr>
						<tr>
							<td>Import Secondary structure</td>
							<td class="text-center">-</td>
							<td class="text-center">+</td>
							<td class="text-center">+</td>
						</tr>
						<tr>
							<td>Import InterPro annotations</td>
							<td class="text-center">-</td>
							<td class="text-center">+</span></td>
							<td class="text-center">+</span></td>
						</tr>
						<tr>
							<td>Show user-defined annotations</td>
							<td class="text-center">+**</td>
							<td class="text-center">+**</td>
							<td class="text-center">+**</td>
						</tr>
						<tr>
							<td>Show user-defined name</td>
							<td class="text-center">+</td>
							<td class="text-center">-***</td>
							<td class="text-center">+</td>
						</tr>

					</table>
					<p align="right">(- not available, + available)</p>
					<p>* If you use user-defined names you cannot import protein lengths from UniProt. In this case, you have to generate a file containing the protein lengths (see section: <a href="#ProteinLengthsFile">Protein Lengths File</a>).<br/>
					** To use user-defined annotations you have to generate an annotations file (see section: <a href="#DomainFile">Domain File for Annotation</a>).<br/>
					*** If you do not use FASTA-header in your crosslink data input file and UniProt-IDs in other input files, you may show user-defined names in the diagram.</p>
					
					 <a name="CrosslinkDataFile"></a>
					<h3>Crosslink Data File</h3>
					
					<h3><small>Minimal Crosslink Data File</h3></small>
					<p>A crosslink data file is a comma separated file (csv) that has to contain at least the columns <em>Protein1</em>, <em>Protein2</em>, <em>AbsPos1</em> and <em>AbsPos2</em>. The columns may be in any order but you have to use the exact same column headings. <em>Protein1</em> and <em>Protein2</em> define the two linked proteins with <em>AbsPos1</em> and <em>AbsPos2</em> indicating the absolute positions of the two crosslinked amino acids within the protein sequences. For intra-links <em>Protein1</em> and <em>Protein2</em> have to have the same protein identifiers. Additional columns are ignored by <span style="color:#777; font-weight:bold">xVis</span>. If you use the crosslink identification score or the false discovery rate for filtering see section: Medium Crosslink Data File.</p>
					<img src="img/manual/inputData_minCrosslinkFile.png" class="img-responsive" alt="Minimal Crosslink Data File Example">
					
					<h3><small>Medium Crosslink Data File</h3></small>
					<p>The medium crosslink file is comma separated (csv) and needs in addition to the columns <em>Protein1</em>, <em>Protein2</em>, <em>AbsPos1</em> and <em>AbsPos2</em> of the minimal crosslink file, the columns of the identification score (Id-Score) and the false discovery rate (FDR) for the filtering option.  In contrast to the columns <em>Protein1</em>, <em>Protein2</em>, <em>AbsPos1</em> and <em>AbsPos2</em>, the columns of the filter values may have arbitrary headings. For filtering the crosslinks (see section: <a href="#CircularPlotMenu_Filter">Menus: Filter</a>) you have to select the filter value in settings and enable displaying the crosslinks above or below the threshold (see section: <a href="#Settings_xQuest">Settings</a>). If you have selected a filter score column the value is shown for each crosslink on mouse over. The file may contain additional columns which are ignored if they are not chosen in the settings as filter scores.</p>
					<img src="img/manual/inputData_medCrosslinkFile.png" class="img-responsive" alt="Medium Crosslink Data File Example">
					
					<h3><small>xQuest generated Crosslink Data File</h3></small>
					<p>As the minimal and the medium crosslink file the crosslink file generated by <span style="color:#777; font-weight:bold">xQuest</span> is comma separated (csv) and needs the columns <em>Protein1</em>, <em>Protein2</em>, <em>AbsPos1</em> and <em>AbsPos2</em>. To display the corresponding fragment ion spectrum for each crosslink you need the columns <em>Spectrum</em>, <em>Type</em> and <em>Id</em> as well as the name of the <span style="color:#777; font-weight:bold">xQuest</span> output file. Importantly, you have to insert the server location and the user name in settings (see section: <a href="#Settings_xQuest">Settings</a>). In addition, the file may have one or more columns containing filter score values.  They may have an arbitrary heading. For filtering the crosslinks (see section: <a href="#CircularPlotMenu_Filter">Menus: Filter</a>) you have to select the respective filter score column in settings and indicate whether crosslinks above or below a threshold value are displayed (see section: <a href="#Settings_xQuest">Settings</a>). If the column is selected the respective filter score value is shown for each crosslink on mouse over. The file may include additional columns which are ignored.</p>
					<img src="img/manual/inputData_xquestCrosslinkFile.png" class="img-responsive" alt="xQuest generated Crosslink Data File Example">
					
					<h3><small>Display options according to crosslink features in different input data formats</h3></small>
					<p>Some features depend on the type of the crosslink file (- not available and + available). To apply certain display options you need to use the crosslink data input file supporting this feature.</p>
					<table class="table table-condensed table-bordered">
						<tr>
							<th>Option</th>
							<th class="text-center">Minimum</th>
							<th class="text-center">Medium</th>
							<th class="text-center">xQuest</th>
						</tr>
						<tr>
							<td>Link to the corresponding fragment ion spectrum</td>
							<td class="text-center">-</td>
							<td class="text-center">-</td>
							<td class="text-center">+</td>
						</tr>
						<tr>
							<td>Filtering by Score/FDR</td>
							<td class="text-center">-</td>
							<td class="text-center">+*</td>
							<td class="text-center">+*</td>
						</tr>
						<tr>
							<td>Show Score for a crosslink</td>
							<td class="text-center">-</td>
							<td class="text-center">+*</td>
							<td class="text-center">+*</td>
						</tr>
					</table>
					<p>* Options available if input file contains columns for Id-Score and FDR and which have to be selected under settings.</p>
				
					
					<a name="DomainFile"></a>
					<h3>Domain File for Annotation</h3>
					<p>The domain file is a comma separated (csv) file for annotated protein motifs. <span style="color:#777; font-weight:bold">xVis</span> supports names or even short descriptions as annotations. The <em>Name</em> (annotation text) allows capital and lower case letters, numbers, brackets, spaces, minus signs, semicolons, dots and underline characters but no special characters like commas, quotes or vertical bars. The column <em>Protein</em> contains a protein identifier (see section: <a href="#ProteinIdentifier">Protein identifier</a>).  The start and the end of the annotation are defined by the amino acid positions in the <em>Start</em> and <em>End</em> columns. You have to use <em>Protein</em>, <em>Start</em>, <em>End</em> and <em>Name</em> as column headings but their order may be altered.</p>
					<img src="img/manual/inputData_domainFile.png" class="img-responsive" alt="Domain File Example">
				
				
					<a name="ProteinLengthsFile"></a>
					<h3>Protein Lengths File</h3>
					<p>The comma separated file (csv) includes the protein identifiers (see section: <a href="#ProteinIdentifier">Protein identifier</a>) and the respective protein lengths. The first row may be used for the column headings (ignored by <span style="color:#777; font-weight:bold">xVis</span>). The following rows have to contain a protein identifier and the protein length (identifier, length). If you apply user-defined names as protein identifiers instead of Fasta-headers or UniProt-IDs they have to match the names in the crosslink data input file.</p>
					<img src="img/manual/inputData_lengthsFile.png" class="img-responsive" alt="Lengths File Example">
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<a name="FileManagement"></a>
					<h2>File Management</h2>
				</div>
				<div class="panel-body">
					<p>This section describes the upload and handling of input files. The file management option allows the uploading and storing of all types of input files in the user account folder. This option is only available if you are logged in onto the server. For test purposes we offer a test account which has limited storage space and data will be deleted regularly (username: test_user;  password: user-56). Without login <span style="color:#777; font-weight:bold">xVis</span> analysis is fully functional, however, input files are only used for generating the plot and are not stored on the server.We recommend to install <span style="color:#777; font-weight:bold">xVis</span> and to distribute user accounts if you connect <span style="color:#777; font-weight:bold">xVis</span> to a <span style="color:#777; font-weight:bold">xQuest</span> server in your IT environment (see section: <a href="#Installation">Installation</a>) .</p>
					
					<h3>Upload Files</h3>
					<p>Here, the different input files are uploaded for generating a plot. You have to select the input file type: crosslink data, domain annotation or protein lengths and the location of the file you want to upload. It is possible to upload more than one file of the same file type. After choosing the files with the file browser you see a list of selected files above as well as their size. You can check if the selected files are assigned to the correct file type. Press the button to upload files to the server.</p>
					<img src="img/manual/fileManagement_uploadFiles.png" class="img-responsive" alt="Upload Files Menu">
					
					<h3>Delete Files</h3>
					<p>You may select one or more files for deleting. The file type (crosslink data, domain annotation or protein lengths) is indicated in parentheses.</p>
					<img src="img/manual/fileManagement_deleteFiles.png" class="img-responsive" alt="Delete Files Menu">
					
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<a name="GeneratingAPlot"></a>
					<h2>Generating a Plot</h2>
				</div>
				<div class="panel-body">
					<p>First, you have to choose a plot type. You can choose between <a href="#CircularPlot">circular plot</a>, <a href="#BarPlot">bar plot</a> and <a href="#NetworkPlot">network plot</a>:</p>
					<p><img src="img/manual/generatingAPlot_plotType.png" class="img-responsive" alt="Plot Type"></br></p>
					<p>Second, you may select a sort type. For the circular plot and the bar plot you can choose between <a href="#AlphabeticallyOrdered">alphabetical order</a>, <a href="#GroupsAlphabeticallyOrdered">groups alphabetically ordered</a> and <a href="#GroupsHierarchicallyOrdered">groups hierarchically structured</a>:</p>
					<p><img src="img/manual/generatingAPlot_sortType.png" class="img-responsive" alt="Sort Type / Coloring"></br></p>
					<p>In comparison to the circular plot and the bar plot the network plot offers a drag and drop feature to arrange the pre-arranged proteins. Therefore no sort type option is provided. Instead you may choose a clustering algorithm for coloring the proteins:  none (all proteins have the same color), <a href="#Grouped">grouped</a> and <a href="MarkovClustering">groups Markov clustered</a>.</p>
					<p><img src="img/manual/generatingAPlot_sortType2.png" class="img-responsive" alt="Sort Type / Coloring"></br></p>
					<p>Third, you have to select a <a href="#CrosslinkDataFile">crosslink data input file</a> and may select <a href="#DomainFile">a file with user-defined annotations</a>.</p>
					<p><img src="img/manual/generatingAPlot_CrosslinkDomainFile.png" class="img-responsive" alt=""></br></p>
					<p>Evolutionary conservation of amino acid positions in the proteins (optional). To integrate on the diagrams amino acid evolutionary conservation generate output files using ConSurf (<a href="http://consurf.tau.ac.il/">http://consurf.tau.ac.il/</a>). The file names have to be converted into the format <em>[UniProt accession number or user-defined names].csv</em> depending on the used protein identifier. Multiple files can selected for upload.</p>
					<p><img src="img/manual/generatingAPlot_conSurf.png" class="img-responsive" alt=""></br></p
					<p>Furthermore you can decide if you import protein lengths and secondary structures from UniProt (turns, helixes or beta strands) as well as annotations provided by InterPro databases. To use user-defined protein lengths or user-defined protein names you have to deselect this option and chose a <a href="#ProteinLengthsFile">protein lengths file</a> below. If you import protein lengths from UniProt you may also import secondary structures provided by UniProt and/or annotations from InterPro. Default: Use UniProt protein lengths.</p>
					<p><img src="img/manual/generatingAPlot_importLengths.png" class="img-responsive" alt=""></br></p>
					<p>To create a diagram with the chosen features press the Plot button.</p>
					<p><img src="img/manual/generatingAPlot_generate.png" class="img-responsive" alt=""></p>
					
					
					<h3>Plot Types</h3>
					<a name="CircularPlot"></a>
					<h3><small>Circular Plot</h3></small>
					<p>This figure shows a circular plot with all possible annotations. Depending on your input files or choices there could be fewer:</p>
					<p><img src="img/manual/generatingAPlot_circularPlot.png" class="img-responsive" alt=""></p>
					<ol>
						<li>protein: each protein has a different color</li>
						<li>protein name if you use FASTA-header or user-defined names. If you use UniProt-IDs the UniProt-ID is displayed.</li>
						<li>scale beginning from the first amino acid of the protein</li>
						<li>inter-links (on mouse over you view the crosslink details; see section:<a href="#MouseOver">Mouse Over</a>)</li>
						<li>intra-links (on mouse over you view the crosslink details; see section:<a href="#MouseOver">Mouse Over</a>)</li>
						<li>Secondary Structures (turns, helixes and beta strands): available if FASTA-header or UniProt-IDs are used</li>
						<li>user defined annotations; same color means same annotation (name)</li>
						<li>InterPro annotations; same color means same annotation. It is possible to hide annotations for example if they overlap.</li>
					</ol>
					
					<a name="Functions"></a>
					<h5><em><strong>Functions</strong></em></h5>
					<h5><em>Zooming and Drag and Drop</em></h5>
					<p>The diagram is zoom-able and the position can be adjusted with drag and drop.</p>
					<a name="MouseOver"></a>
					<h5><em>Mouse Over</em></h5>
					<p>Additional information is displayed by mouse over: mouse over an annotation shows the start and end position and name of it; mouse over a crosslinks shows the names of the crosslinked proteins with the crosslink sites. If a score column is selected in <em>Settings</em> (see section: <a href="#Settings_xVis">xVis</a>) the Score/FDR of the crosslinks as well as the name of the score are displayed. Mouse over a protein shows the protein name. Default: no score column selected.</p>
					<img src="img/manual/generatingAPlot_mouseOver.png" class="img-responsive" alt=""></br>
					<h5><em>On Click</em></h5>
					<p>If you click a protein name the color switches between black and the color of the respective protein segment (circular plot) or protein bar (bar plot).</p>
					<a name="CircularPlotFunctions_DoubleClick"></a> 
					<h5><em>Double Click</em></h5>
					<p>Double clicking a protein field or name opens the corresponding UniProt entry. This feature requires the use of UniProt-IDs or the FASTA-header in the crosslink data input file. Double clicking on a crosslink line links to the login of the <span style="color:#777; font-weight:bold">xQuest</span> viewer and in case you are already logged in to the fragment ion spectrum. This feature requires the <span style="color:#777; font-weight:bold">xQuest</span> generated files and needs the filename given from <span style="color:#777; font-weight:bold">xQuest</span>.</p>
					
					<a name="Menus"></a>
					<h5><em><strong>Menus</strong></em></h5>
					<p>The menus shown above are collapsible, so their content is displayed after a click on the menu name. New settings are applied by the Redraw button.</p>
					<h5><em>Secondary Structures</em></h5>
					<p>You can select each beta strand, helix or turn separately for displaying and assign a color with a dropdown box. Default: all secondary structures are shown; beta strand in yellow, helix in red and turn in blue.</p>
					<img src="img/manual/generatingAPlot_uniProtDomain.png" class="img-responsive" alt=""></br>
					<h5><em>InterPro Annotations</em></h5>
					<p>It is possible to select several annotations to be displayed in the plot. The same annotations have the same color in the plot. Default: all annotations downloaded from InterPro are shown.</p>
					<img src="img/manual/generatingAPlot_interProDomain.png" class="img-responsive" alt=""></br>
					<a name="CircularPlotMenu_Filter"></a> 
					<h5><em>Filter</em></h5>
					<p>To distinguish inter- and intra-links it is possible to assign different colors or to selectively hide them. By selecting the involved proteins (multiple selection) you can view this subset of crosslinks. Furthermore the crosslinks can be filtered and displayed according to quality scores. The column of the Id-Score or the FDR can be defined  as score column in <em>Settings</em> (see section: <a href="#Settings_xVis">xVis</a>) and chosing a threshold value facilitates to selectively display crosslinks above or below the cut-off. Default: cross-links to all proteins are shown and inter- and intra-links colored in blue. All crosslinks are shown regardless of their score.</p>
					<img src="img/manual/generatingAPlot_filter.png" class="img-responsive" alt=""></br>
					<h5><em>Download</em></h5>
					<p>The diagram can be downloaded as SVG (Scalable Vector Graphics). You may define a filename or default filename is used ([crosslink filename]_[plot type]).</p>
					<img src="img/manual/generatingAPlot_download.png" class="img-responsive" alt=""></br>
					
					<a name="Legends"></a>
					<h5><em><strong>Legends</strong></em></h5>
					<p>If InterPro or user-defined annotations are selected an appropriate legend will be displayed on the right panel.</p>
					<img src="img/manual/generatingAPlot_legendInterPro.png" class="img-responsive" style="display: inline"  alt="Legend for InterPro annotations">
					<img src="img/manual/generatingAPlot_legendUserDef.png" class="img-responsive" style="display: inline" alt="Legend for user-defined annotations">
					
					<a name="BarPlot"></a>
					<h3><small>Bar plot</h3></small>
					<p>The following diagram shows a bar plot with all possible annotations. Depending on the input file type or choices there are fewer annotations:</p>
					<p><img src="img/manual/generatingAPlot_barPlot.png" class="img-responsive" alt=""></p>
					<ol>
						<li>protein: each protein has a different color</li>
						<li>protein name if you use FASTA-header or user-defined names. If you use UniProt-IDs the UniProt-ID is displayed.</li>
						<li>scale beginning from the first amino acid of the protein</li>
						<li>inter-links (on mouse over you view the crosslink details; see section:<a href="#MouseOver">Mouse Over</a>)</li>
						<li>intra-links (on mouse over you view the crosslink details; see section:<a href="#MouseOver">Mouse Over</a>)</li>
						<li>Secondary Structures(turns, helixes and beta strands): available if FASTA-header or UniProt-IDs are used</li>
						<li>user defined annotations; same color means same annotation (name)</li>
						<li>InterPro annotations; same color means same annotation. It is possible to hide annotations for example if they overlap.</li>
					</ol>
					
					<h5><em><strong>Functions</strong></em></h5>
					<p><a href="#Functions">see Circular Plot</a></p>
					
					<h5><em><strong>Menus</strong></em></h5>
					<p><a href="#Menus">see Circular Plot</a></p>
					
					<h5><em><strong>Legends</strong></em></h5>
					<p><a href="#Legends">see Circular Plot</a></p>
					
					<a name="NetworkPlot"></a>
					<h3><small>Network plot</h3></small>
					<p>This diagram shows a part of a network plot with all possible annotations. Depending on the input file type and your choices there are fewer annotations possible:</p>
					<p><img src="img/manual/generatingAPlot_networkPlot.png" class="img-responsive" alt="Network plot"></p>
					<ol>
						<li>protein</li>
						<li>protein name if you use FASTA-header or user-defined names. If you use UniProt-IDs the UniProt-ID is displayed.</li>
						<li>first and last amino acid</li>
						<li>inter-links (on mouse over you view the crosslink details; see section:<a href="#MouseOver">Mouse Over</a>)</li>
						<li>intra-links (on mouse over you view the crosslink details; see section:<a href="#MouseOver">Mouse Over</a>)</li>
						<li>Secondary Structures (turns, helixes and beta strands): available if FASTA-header or UniProt-IDs are used</li>
						<li>user defined annotations; same color means same annotation (name)</li>
						<li>InterPro annotations; same color means same annotation. It is possible to hide annotations for example if they overlap.</li>
						<li>rotated protein</li>
						<li>flipped protein</li>
					</ol>
					
					<h5><em><strong>Functions</strong></em></h5>
					<p>In addition to functions described for circular plots (see section: <a href="#Functions">Circular Plot</a>) the network plot offers:</p>
					<h5><em>Context Menu</em></h5>
					<p>The context menu opens with a right click on a protein. A clicked protein can be mirrored horizontally by choosing <em>flip</em> and rotated over a degree value. The degree value has to be positive but can be a decimal number. The new settings are applied upon pressing the button <em>Update</em>. Default: not rotated and not mirrored.</p>
					<img src="img/manual/generatingAPlot_contextMenu.png" class="img-responsive" alt="Network plot"></br>
					<h5><em>Drag and Drop</em></h5>
					<p>The proteins are moved using drag and drop.</p>
					
					<h5><em><strong>Menus</strong></em></h5>
					<p>In addition to menus described for circular plots (see section: <a href="#Menus">Circular Plot</a>) the network plot offers:</p>
					<h5><em>Shapes</em></h5>
					<p>The <em>Shapes</em> menu helps to design the network plot. It is possible to show an N and C for the N- and C-terminus of the protein. In addition the protein name can be displayed above, below or inside the protein bar which can be framed. Default: The protein name is above the bar and the N/C-Tag as well the frame around each bar is shown.</p>
					<img src="img/manual/generatingAPlot_shapes.png" class="img-responsive" alt="Network plot"></br>
					<h5><em>Markov Cluster Settings</em></h5>
					<p>Through the Markov Cluster Settings the number of clusters and their size can be determined. High <em>expansion</em> values generate a few big cluster and high <em>inflation</em> values generate many small cluster. This means the two parameters are counteracting. Protein groups (see section: <a href="MarkovClustering">Markov Clustering</a>) with a lower number of proteins than the <em>threshold</em> are not clustered. Default: <em>expansion 2</em>, <em>inflation 1</em> and <em>threshold 3</em>.</p>
					<img src="img/manual/generatingAPlot_markovClustering.png" class="img-responsive" alt="Network plot">
					
					<h5><em><strong>Legends</strong></em></h5>
					<p><a href="#Legends">see Circular Plot</a></p>
					
					<h3>Sort type and Coloring</h3>
					<p>A sort type defines the arrangement of the proteins (available for circular and bar plot) and the coloring of proteins in a network plot.</p>
					
					<a name="AlphabeticallyOrdered"></a>
					<h3><small>Alphabetically ordered</h3></small>
					<p>The proteins are ordered alphabetically by protein name if user-defined names or FASTA-header are applied as protein identifier or numerically by UniProt-IDs.<p>
					<img src="img/manual/generatingAPlot_alphabetically.png" class="img-responsive" alt="">
					
					<a name="GroupsAlphabeticallyOrdered"></a>
					<h3><small>Groups alphabetically ordered</h3></small>
					<p>Proteins are separated in clusters comprising a connected group of proteins. In a cluster each protein has to be connected at least to one other protein in the same cluster. A cluster may consist of only one protein if this protein has no interlinks. After grouping all cluster are sorted alphabetically. In case all proteins are in one cluster this sorting looks like the alphabetically ordering.</p>
					<img src="img/manual/generatingAPlot_alphabetically.png" class="img-responsive" alt="">
					
					<a name="GroupsHierarchicallyOrdered"></a>
					<h3><small>Groups hierarchically ordered</h3></small>
					<p>The proteins are grouped like for the alphabetically ordering. Subsequently, a dendrogram depending on the number of crosslinks between the proteins is generated in order to arrange the proteins. In general, many crosslinks between proteins result in a sub complex with fewer crosslinks between them. The dendrogram is converted in a list to arrange the proteins along a line or a circular line.</p>
					<img src="img/manual/generatingAPlot_hcl.png" class="img-responsive" alt="">
					
					<a name="Grouped"></a>
					<h3><small>Grouped</h3></small>
					<p>The proteins are grouped like for the alphabetically ordering. Subsequently, each group gets a different color in the diagram.</p>
					<img src="img/manual/generatingAPlot_grouped.png" class="img-responsive" alt="">
					
					<a name="MarkovClustering"></a>
					<h3><small>Markov Clustering</h3></small>
					<p>Before the Markov Clustering starts the proteins are grouped like for the alphabetically ordering. Each group is clustered by the Markov Algorithm with default parameters which you may change in the menu <em>Markov Cluster Settings</em>.  The Markov Clustering Algorithm analyzes the protein network and identifies areas of high connectivity as clusters that are separated by areas with low connectivity from other cluster. It is recommended to optimize the clustering for your protein complex by changing the parameters.</p>
					<img src="img/manual/generatingAPlot_mcl.png" class="img-responsive" alt="">
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Settings</h2>
				</div>
				<div class="panel-body">
					<a name="Settings_xQuest"></a>
					<h3>xQuest</h3>
					<p>Here, you have to define the location of the <span style="color:#777; font-weight:bold">xQuest</span> visualization server as well as your login name for the server if you want to connect crosslinks in <span style="color:#777; font-weight:bold">xVis</span> plots with the <span style="color:#777; font-weight:bold">xQuest</span> fragment ion spectra.  As URL you need to insert the whole path to the <em>xions2.cgi</em>. Default: no default values</p>
					<img src="img/manual/generatingAPlot_xQuest.png" class="img-responsive" alt="Network plot">
					
					<a name="Settings_xVis"></a>
					<h3>xVis</h3>
					<p>In the xVis menu the <em>Score column</em> has to be specified in order to perform the filtering option by Id-Score or FDR. In addition the score range has to be defined by chosing whether crosslinks above or below a defined threshold value are displayed.  Default: no score column; score range smaller.</p>
					<img src="img/manual/generatingAPlot_xVis.png" class="img-responsive" alt="Network plot">
					
					<h3>Administrator Setting</h3>
					<h3><small>Register User</h3></small>
					<p>The easy registration process of new users by the administrator cis possible through the web interface. The user has to enter a username. The name has to be unique in the system. If the name already exists an error will occur. Furthermore, the user has to enter a password in the password field (it shows placeholders instead of the password). If you want to establish a new admin you have to set the <em>admin</em> flag. Upon  confirmation with the Register button the password gets md5 encrypted and the new user is registered.</p>
					<img src="img/manual/generatingAPlot_registerUser.png" class="img-responsive" alt="Network plot">
					
					<h3><small>Change Password</h3></small>
					<p>The user has to enter the username and a new password. By clicking Change the password gets changed with a modification of the admin status, the settings or files.</p>
					<img src="img/manual/generatingAPlot_changePassword.png" class="img-responsive" alt="Network plot">
					
					<h3><small>Delete User</h3></small>
					<p>To delete one or more users select them and press delete. Note if you delete a user you delete also all user settings and the complete folder structure for this user.</p>
					<img src="img/manual/generatingAPlot_deleteUser.png" class="img-responsive" alt="Network plot">
				</div>
			</div>
			<div class="panel panel-default">
				<a name="Installation"></a>
				<div class="panel-heading">
					<h2>Installation</h2>
				</div>
				<div class="panel-body">
					<h3>Installation on a web server</h3>
					<ol>
						<li>Verify that your server supports PHP. For more information and to download PHP see <a href="http://php.net/downloads.php">http://php.net/downloads.php</a>.</li>
						<li>Extract the zip file (see <a href="downloads.php">xVis source code</a>) and copy source code files in the directory of the server</li>
						<li>
							<ol style="list-style-type:lower-alpha">
								<li>If you want to use <span style="color:#777; font-weight:bold">xVis</span> without user accounts delete the folder <em>xVis/user/test_user</em>. You should delete the test user to prevent undesired access to the server (<strong>the test user has admin rights!</strong>).</li>
								<li>If you want to use <span style="color:#777; font-weight:bold">xVis</span> with user accounts you have to login as <em>test_user</em> (password: user-56). Afterwards change the password or create a new admin user and delete <em>test_user</em>. Now you are able to create user as well as admin accounts.</li>
							</ol>
						</li>
					</ol>
					
					<h3>Local Installation / Installation of xVis containing XAMPP</h3>
					<p>This section describes the installation of <span style="color:#777; font-weight:bold">xVis</span> on a local computer as well as the installation if no webserver exist (only available for windows). The provided package contains a predefined Apache server called <a href="https://www.apachefriends.org/">XAMPP</a>.</p>
					<ol>
						<li>Extract the zip file (see <a href="downloads.php">xVis with XAMPP</a>)and copy the folder xampp into the destination folder.</li>
						<li>Run <em>xampp/setup_xampp</em> and approve the command line application.</li>
						<li>Run <em>xampp/apache_start</em>. You have to rerun this file each time to start the server e.g. after restarting the computer.</li>
						<li>See <em>Installation on a web server</em> section 3</li>
						<li>It is recommended to change the security settings (http://localhost/security/index.php) of the Apache server if it can be accessed through the internet to prevent malicious access.</li>
						<li>xVis is accessible by <em>localhost/xVis</em> or by <em>[IP/name of the server]/xVis</em></li>
					</ol>
				</div>
			</div>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jasny-bootstrap.min.js"></script>
	</body>
</html>
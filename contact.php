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
						<li><a href="manual.php"><span class="glyphicon glyphicon-book"></span> Manual</a></li>
						<li><a href="downloads.php"><span class="glyphicon glyphicon-download"></span> Downloads</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div><!--/.container-fluid -->
		</div>
		
		<div class="container">	
			<h1>Contact</h1>
			</br>
				<dl class="dl-horizontal">
					<dt><span style="color:#777;">Maximilian Grimm</span></dt>
					<dd class="clearfix"></dd>
					<dt>Email</dt>
					<dd><a href="mailto:grimm@genzentrum.lmu.de">grimm@genzentrum.lmu.de</a></dd>
					<dt>Adress</dt>
					<dd>
						Gene Center Munich</br>
						Ludwig-Maximilians-Universität (LMU) Munich</br>
						Feodor-Lynen-Strasse 25</br>
						81377 Munich</br>
						Germany</br></br>
					</dd>
					<dt><span style="color:#777;">Franz Herzog</span></dt>
					<dd class="clearfix"></dd>
					<dt>Email</dt>
					<dd><a href="mailto:herzog@genzentrum.lmu.de">herzog@genzentrum.lmu.de</a></dd>
					<dt>Adress</dt>
					<dd>
						Gene Center Munich</br>
						Ludwig-Maximilians-Universität (LMU) Munich</br>
						Feodor-Lynen-Strasse 25</br>
						81377 Munich</br>
						Germany</br></br>
					</dd>
					
				</dl>
				<p>To apply for a xVis account contact us by mail.</p>
		</div>
	</body>
</html>		
		
		
		
		
		
		
		
		
		
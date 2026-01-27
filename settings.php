<?php
	include('auth.php');
	include('../user/' . $userName . '/settings.php');
	if(isset($_SESSION['loginAsUser'])){
		header("Location: login.php");
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
	<?php
	if(!isset($_SESSION)){
		include('auth.php');
	}
	?>
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="CrossVis.php">xVis</a>
				</div>
			  <div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="contact.php"><span class="glyphicon glyphicon-envelope"></span> Contact</a></li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
				</ul>
			  </div><!--/.nav-collapse -->
			</div><!--/.container-fluid -->
		</div>
	  
		<div class="container">
			<h1> Settings </h1>
			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseXQuest">
								<small>
									<span class="glyphicon glyphicon-plus" id="collapseXQuestIcon"></span>
								</small>
								xQuest
							</a>
						</h4>
					</div>
					<div id="collapseXQuest" class="panel-collapse collapse">
						<div class="panel-body">
							<form action="changeSettings.php" role="form" method="post">
								<div class="form-group">
									<label for="domainURLXQuestServer">Server Location</label></br>
									<small>The Location of the xQuest server and the executable xions2.cgi for example: "http://myServer.myDomain.de/cgi-bin/xquest-2.1.1/xions2.cgi"</small>
									<input class="form-control" id="domainURLXQuestServer" name="domainURLXQuestServer" type="text" size="40" value= 
										<?php 
											if(isset($domainURLXQuestServer)){ 
												echo '"' . $domainURLXQuestServer . '"';}
											else{
												echo '"eg. http://xQuest.myServer.myDomain.de/cgi-bin/xquest-2.1.1/xions2.cgi"';}
										?>
									>
								</div>
								<div class="form-group">
									<label for="idXQuestUser">User Name</label>
									<input class="form-control" id="idXQuestUser" name="idXQuestUser" type="text" size="40" value= 
										<?php 
											if(isset($idXQuestUser)){ 
												echo '"'.$idXQuestUser.'"';}
											else{
												echo '"xQuest user name"';}
										?>
									>
								</div>
								
								<input type="submit" name="xQuest" class="btn btn-primary" value="Change" />	
							</form>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseXVis">
								<small>
									<span class="glyphicon glyphicon-minus" id="collapseXVisIcon"></span>
								</small>
								xVis
							</a>
						</h4>
					</div>
					<div id="collapseXVis" class="panel-collapse collapse in">
						<div class="panel-body">
							<form action="changeSettings.php" role="form" method="post">
								<div class="form-group">
									<label for="scoreColumn">Filter by Value: <small>Column Heading</small></label>
									<input class="form-control" id="scoreColumn" name="scoreColumn" type="text" size="40" value= 
										<?php 
											if(isset($scoreColumn)){ 
												echo '"'.$scoreColumn.'"';}
											else{
												echo '"e.g. FDR"';}
										?>
									>
								</div>
								<div class="form-group">
									Filter values
									<div class="radio-inline">
										<label class="checkbox-inline">
											<input id="scoreDirectionSmaller" type="radio" name="scoreDirection" value="<" 
												<?php 
													if(isset($scoreDirection) && $scoreDirection=="<"){ 
														echo 'checked';} 
												?>
											>
											below threshold 
										</label>
									</div>
									<div class="radio-inline">
										<label class="checkbox-inline">
											<input id="scoreDirectionBigger" type="radio" name="scoreDirection" value=">"
												<?php 
													if(isset($scoreDirection) && $scoreDirection==">"){ 
														echo 'checked';} 
												?>
											>
											above threshold
										</label>
									</div>
								</div>
								<input type="submit" name="CrossVis" class="btn btn-primary" value="Change" />	
							</form>
						</div>
					</div>
				</div>
				<?php 
					if($_SESSION["admin"] == "on"){
				?>
				<h1> Administrator Settings </h1>
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseRegister">
									<small>
										<span class="glyphicon glyphicon-plus" id="collapseRegisterIcon"></span>
									</small>
									Register User
								</a>
							</h4>
						</div>
						<div id="collapseRegister" class="panel-collapse collapse">
							<div class="panel-body">
								<form action="registerUser.php" name="registerUser" role="form" method="post" onsubmit="document.registerUser.pwd.value=MD5(document.registerUser.pw.value); document.registerUser.pw.value=''">
									<div class="form-group">
										<label for="name">Username</label>
										<input class="form-control" id ="name" name="name" type="text" size="40">
									</div>
									<div class="form-group">
										<label for="pw">Password</label>
										<input class="form-control" id="pw" name="pw" type="password" size="40">
										<input type="hidden" id="pwd" name="pwd">
									</div>
									<div class="form-group">
										<label for="admin">Admin</label>
										<input id="admin" type="checkbox" name="admin"/>
									</div>
									<input type="submit" class="btn btn-primary" value="Register" />
								</form>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseChange">
									<small>
										<span class="glyphicon glyphicon-plus" id="collapseChangeIcon"></span>
									</small>
									Change Password
								</a>
							</h4>
						</div>
						<div id="collapseChange" class="panel-collapse collapse">
							<div class="panel-body">
								<form action="changePassword.php" name="changePassword" role="form" method="post" onsubmit="document.changePassword.pwd.value=MD5(document.changePassword.pw.value); document.changePassword.pw.value=''">
									<div class="form-group">
										<label for="UserName">Username</label>
										<input class="form-control" id ="UserName" name="name" type="text" size="40">
									</div>
									<div class="form-group">
										<label for="newPw">New password</label>
										<input class="form-control" id="newPw" name="pw" type="password" size="40">
										<input type="hidden" id="newPwd" name="pwd">
									</div>
									<input type="submit" class="btn btn-primary" value="Change" />
								</form>
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
									Delete User
								</a>
							</h4>
						</div>
						<div id="collapseDelete" class="panel-collapse collapse">
							<div class="panel-body">
								<form action="deleteUser.php" name="deleteUser" role="form" method="post">
									<div class="form-group">
										<label for="deleteUser">Username</label>
										<select name="deleteUser[]" class="form-control" multiple="multiple" size="4" onmousedown="this.parentElement.className='form-group has-warning';
																																this.parentElement.getElementsByTagName('small')[0].style.display='inline'">
											<?php
												$user = scandir('../user/');
												for($i = 3; $i < sizeof($user); $i++){
													echo "<option value=\"" . $user[$i] . "\">" . $user[$i] . "</option>";
												}
											?>
										</select>
										<small class="control-label" hidden>By clicking delete the user and all user data will be deleted!</small>
									</div>
									<input type="submit" class="btn btn-primary" value="Delete" />
								</form>
							</div>
						</div>
					</div>
				</div>
				<?php
					}
				?>
			</div>
		</div>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		<script src="js/md5.js"></script>
	
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

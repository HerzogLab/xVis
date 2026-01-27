<?php
session_start();
$error = false;

if(array_key_exists("username", $_POST) && array_key_exists("pw",$_POST)){
	$inputUsername=$_POST["username"];
	$inputPassword=$_POST["pw"];
	
	if(file_exists("../user/".$inputUsername) == true)
	{
		include "../user/".$inputUsername."/"."pwd.php";
		
		if($username == $inputUsername && $password == $inputPassword)
		{
			$_SESSION["login"] = 1;
			$_SESSION["user"] = $inputUsername;
			$_SESSION["admin"] = $admin;
			unset($_SESSION["loginAsUser"]);
			
			header("Location: CrossVis.php");
		}
		else
		{
			unset($_POST);
			$error = true;
		}
	}
	else
	{
		unset($_POST);
		$error = true;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" type="image/x-icon" href="img/icon.png" />
		<title>Signin to xVis</title>

		<!-- Bootstrap core CSS -->
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
					<a class="navbar-brand" id="loginBtn" href="#" onClick="logIn()">Login</a>
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
		<script>
			function logIn(){
				document.getElementById('xVis').style.display = 'none';
				document.getElementById('username').style.display = 'inline';
				document.getElementById('pwd').style.display = 'inline';
				document.getElementById('submitBtn').style.display = 'inline';
				document.getElementById('loginBtn').style.display = 'none';
			}
		</script>
		<div class="container"> 
			<?php if($error == true) { ?>
			<div class="alert alert-danger">Wrong username or password!</div>
			<?php }	?>
			<div style="background:url('./img/background.svg') center center no-repeat;">
				<form class="form-signin" role="form" method="post" name="signin" action="login.php" align="center" style="padding:250px 0 300px 0;" 
					onsubmit="document.signin.pw.value=MD5(document.signin.pwd.value); document.signin.pwd.value=''">
					<h1 style="font-size:110px" id="xVis" class="text-center">xVis</h1>
					<h2 class="form-signin-heading" style="display:none">Please sign in</h2>
					<input type="text" id="username" name="username" class="form-control" style="display:none" placeholder="Username" required autofocus>
					<input type="password" id="pwd" name="pwd" class="form-control" style="display:none" placeholder="Password" required>
					<input type="hidden" id="pw" name="pw">
					<button type="submit" id="submitBtn" class="btn btn-lg btn-primary btn-block"  style="display:none">Sign in</button>
					<input class="btn btn-lg btn-success btn-block" type="button" onClick="parent.location='CrossVisNoLogin.php'" value="Use xVis">
				</form>
			</div>
		</div> <!-- /container -->
		<script src="js/md5.js"></script>
	</body>
</html>
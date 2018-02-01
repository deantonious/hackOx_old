<?php
	session_start();
	include "load.php";
		
	if(checkSession()) {
		header("Location: index.php");
	}
	
?>
<!DOCTYPE html>
<html>
    <head>
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
		<link rel="icon" type="image/png" href="favicon.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<title>hackOx</title>
    </head>

    <body class="grey darken-3">
		<div class="valign-wrapper" style="height:100vh;">
			<div class="row valign">
				<div class="card grey darken-4" id="login-form">
					<div class="card-content white-text">
						<span class="title-login center">hackOx</span>
						<label for="username">Username</label>
						<input placeholder="Username" id="username" type="text" class="validate">
				
						<label for="password">Password</label>
						<input placeholder="Password" id="password" type="password" class="validate">
					</div>
					<div class="card-action center">
						<button class="btn waves-effect waves-light green darken-4" type="submit" id="btn-login" name="action">Login <i class="material-icons left">perm_identity</i></button>
					</div>
				</div>
			</div>
		</div>
	
	
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript" src="js/login.js"></script>
    </body>
</html>

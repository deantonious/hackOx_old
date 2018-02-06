<?php
	if(file_exists("/var/hackox/www/core/database.php")) {
		header("Location: ../login.php");
	}
?>
<!DOCTYPE html>
<html>
    <head>
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="/css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="/css/style.css"  media="screen,projection"/>
		<link rel="icon" type="image/png" href="favicon.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<title>hackOx Installation</title>
    </head>
	
    <body class="grey darken-3 white-text">
		<div class="valign-wrapper" style="height:100vh;">
			<div class="row valign">
				<div class="card grey darken-4" id="login-form" style="max-width: 30vw;">
					<div class="card-content white-text">
						<span class="title-login center">hackOx Installer</span>
						
						<label for="db_host">DB Host</label>
						<input placeholder="DB Host" id="db_host" type="text" class="validate" value="localhost">
				
						<label for="db_host">DB Username</label>
						<input placeholder="DB Username" id="db_username" type="text" class="validate">
				
						<label for="db_host">DB Password</label>
						<input placeholder="DB Password" id="db_password" type="text" class="validate">
						
						<label for="db_database">DB Database</label>
						<input placeholder="DB Database" id="db_database" type="text" class="validate">
				
						<label for="db_table_prefix">Table Prefix</label>
						<input placeholder="hackox_" id="db_table_prefix" type="text" class="validate">
						
						<label for="db_password_salt">Password Salt</label>
						<input placeholder="Password Salt" id="db_password_salt" type="text" class="validate">
					</div>
					<div class="card-action center">
						<div class="row" id="installation">
							<button class="btn waves-effect waves-light green darken-4" type="submit" id="btn-install" name="action">Install <i class="material-icons left">play_circle_outline</i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="/js/materialize.min.js"></script>
		<script type="text/javascript" src="install.js"></script>
    </body>
</html>

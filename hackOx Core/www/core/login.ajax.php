<?php
	session_start();
	include("class.LogManager.php");
	include("database.php");
	
	
	if(!(empty($_POST['username']) && empty($_POST['password']))) {
		
		if(login($database, $_POST['username'], $_POST['password']) == true) {
			$_SESSION['username'] = $_POST['username'];
			$username = $database->real_escape_string($_POST['username']);
			
			echo "true";
		} else {
			echo "false";
		}
	} else {
		echo "false";
	}
	
	function login($database, $username, $password) {
		$username = $database->real_escape_string($username);
		$data = $database->query("SELECT * FROM " . T_PREFIX . "config WHERE dev_admin_usr='" . $username . "'")->fetch_assoc();
		$password = hash('sha512', PASSWORD_SALT . $database->real_escape_string($password));
		if($password == $data['dev_password']) {
			return true;
		}
		return false;
    }
	
?>
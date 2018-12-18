<?php

    session_start();
    include("../config.php");
	include("class.LogManager.php");
	include("class.Database.php");

    $data = json_decode(file_get_contents('php://input'), true);
    
	if(!(empty($data['username']) && empty($data['password']))) {
		
		if(login($data['username'], $data['password']) == true) {
			$_SESSION['username'] = $data['username'];
			echo "true";
		} else {
			echo "false";
		}
	} else {
		echo "false";
	}
	
	function login($username, $password) {
        $database = new Database;
        $connection = $database->connection();

        $exq = $connection->prepare("SELECT * FROM config WHERE dev_admin_usr=:username");
        $exq->execute([':username' => $username]);

        $data = $exq->fetch(PDO::FETCH_ASSOC);
        
		if(hash('sha512', PASSWORD_SALT . $password) == $data['dev_password']) {
			return true;
		}
		return false;
    }
	
?>
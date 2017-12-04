<?php
	session_start();
	include("config.php");
	include("load.php");
	
	//TODO: Load Components
	//TODO: Load Modules
	
	/**
	 * Load Page
	 */
	//Check permission
	if(checkSession()) {
		//Get page
		if(isset($_GET["p"])) {
			$page = $database->real_escape_string($_GET["p"]);
		
			$view = new View($database);
			
			if($view->load($page)) {
				echo $view->render();
			}
		} else {
			header("Location: index.php?p=0");
		}
	} else {
		header("Location: /login.php");
	}
	
	
	
	
	
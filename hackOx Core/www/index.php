<?php
	session_start();
	include("load.php");
	
	if(isset($_GET["p"])) {
		$page = $database->real_escape_string($_GET["p"]);
		$view = new View($database);
		
		if($view->load($page)) {
			echo $view->render();
		}
	} else {
		header("Location: index.php?p=1");
	}
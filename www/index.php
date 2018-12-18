<?php
    session_start();
    include("load.php");

	if(isset($_GET["p"])) {
        $database = new Database;
		$view = new View($database->connection());
		if($view->load($_GET["p"])) {
			echo $view->render();
        }
	} else {
		header("Location: index.php?p=1");
	}
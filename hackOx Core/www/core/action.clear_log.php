<?php

	session_start();
	include("class.LogManager.php");
	include("../config.php");
	include("database.php");
	if(!checkSession()) {
		header("Location: login.php");
	}
	
	$log = new LogManager;
	$log->clear($database);
	
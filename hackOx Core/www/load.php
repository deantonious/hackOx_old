<?php

	include("functions.php");
	include("core/database.php");
	include("core/class.Template.php");
	include("core/class.Navigation.php");
	include("core/class.View.php");
	include("core/class.Module.php");
	include("core/class.LogManager.php");
	include("core/class.Application.php");
	include("core/class.Response.php");

		
	define("ROOTPATH", dirname( __FILE__ ) . "/");
	define("SW_VER", "hackOx 0.9.1");

	if(DEBUG) {
		ini_set("display_errors", "On");
		error_reporting(E_ALL);
	}
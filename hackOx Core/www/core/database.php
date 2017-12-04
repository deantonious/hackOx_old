<?php
	define("DB_HOST", "HOST");
	define("DB_USERNAME", "USERNAME");
	define("DB_PASSWORD", "PASSWORD");
	define("DB_DATABASE", "DATABASE_NAME");
	define("PASSWORD_SALT", "SALT");
	define("DB_CHARSET", "utf8");
	
	define("T_PREFIX", "hackox_");
	
	$database = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
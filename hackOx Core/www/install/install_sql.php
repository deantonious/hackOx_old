<?php
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
	
	$db_host = $_POST["db_host"];
	$db_username = $_POST["db_username"];
	$db_password = $_POST["db_password"];
	$db_database = $_POST["db_database"];
	
	$db_table_prefix = $_POST["db_table_prefix"];
	$db_password_salt = $_POST["db_password_salt"];
	
	$database = new mysqli($db_host, $db_username, $db_password, $db_database);
	
	if ($database->connect_errno) {
		echo "Error: " . $database->connect_error;
	} else {
		$password = hash('sha512', $db_password_salt . "hackox");
	
		$database->query("CREATE TABLE IF NOT EXISTS `".$db_table_prefix."apps` (`app_id` int(11) NOT NULL, `app_name` text NOT NULL, `app_version` text NOT NULL, `app_author` text NOT NULL, `app_description` text NOT NULL, `app_file` text NOT NULL, `app_directory` text NOT NULL, `app_installed` datetime NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$database->query("CREATE TABLE IF NOT EXISTS `".$db_table_prefix."config` (`id` int(11) NOT NULL, `dev_name` text NOT NULL, `dev_id` text NOT NULL, `dev_key` text NOT NULL, `dev_remote_url` text NOT NULL, `dev_admin_usr` text NOT NULL, `dev_password` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		
		$database->query("CREATE TABLE IF NOT EXISTS `".$db_table_prefix."logs` (`id` int(11) NOT NULL,  `log_date` datetime NOT NULL,  `log_action` text NOT NULL,  `log_data` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$database->query("CREATE TABLE IF NOT EXISTS `".$db_table_prefix."modules` (`module_id` int(11) NOT NULL,  `view_id` int(11) NOT NULL,  `module_installed` datetime NOT NULL,  `module_directory` text NOT NULL,  `module_enabled` tinyint(4) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$database->query("CREATE TABLE IF NOT EXISTS `".$db_table_prefix."modules_config` (`config_id` int(11) NOT NULL,  `module_id` int(11) NOT NULL,  `config_key` text NOT NULL,  `config_value` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		
		$database->query("CREATE TABLE IF NOT EXISTS `".$db_table_prefix."tabs` (`tab_id` int(11) NOT NULL,  `tab_order` int(11) NOT NULL,  `tab_parent` int(11) NOT NULL,  `tab_divider` tinyint(11) NOT NULL,  `tab_name` text NOT NULL,  `tab_slug` text NOT NULL,  `tab_icon` text NOT NULL,  `tab_view_id` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		
		$database->query("CREATE TABLE IF NOT EXISTS `".$db_table_prefix."views` (`view_id` int(11) NOT NULL, `view_is_module` int(11) NOT NULL, `view_controller` text NOT NULL, `view_template` text NOT NULL, `view_title` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		
		$database->query("ALTER TABLE `".$db_table_prefix."apps` ADD PRIMARY KEY (`app_id`)");
		$database->query("ALTER TABLE `".$db_table_prefix."config` ADD PRIMARY KEY (`id`)");
		$database->query("ALTER TABLE `".$db_table_prefix."logs` ADD PRIMARY KEY (`id`)");
		$database->query("ALTER TABLE `".$db_table_prefix."modules` ADD PRIMARY KEY (`module_id`)");
		$database->query("ALTER TABLE `".$db_table_prefix."modules_config` ADD PRIMARY KEY (`config_id`)");
		$database->query("ALTER TABLE `".$db_table_prefix."tabs` ADD PRIMARY KEY (`tab_id`)");
		$database->query("ALTER TABLE `".$db_table_prefix."views` ADD PRIMARY KEY (`view_id`)");
		
		$database->query("ALTER TABLE `".$db_table_prefix."apps` MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT");
		$database->query("ALTER TABLE `".$db_table_prefix."config` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");
		$database->query("ALTER TABLE `".$db_table_prefix."logs` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");
		$database->query("ALTER TABLE `".$db_table_prefix."modules` MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT");
		$database->query("ALTER TABLE `".$db_table_prefix."modules_config` MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT");
		$database->query("ALTER TABLE `".$db_table_prefix."tabs` MODIFY `tab_id` int(11) NOT NULL AUTO_INCREMENT");
		$database->query("ALTER TABLE `".$db_table_prefix."views` MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT");
		
		$database->query("INSERT INTO `".$db_table_prefix."config` (`dev_name`, `dev_id`, `dev_key`, `dev_remote_url`, `dev_admin_usr`, `dev_password`) VALUES('hackOx', '', '', '', 'admin', '$password')");
		$database->query("INSERT INTO `".$db_table_prefix."views` (`view_is_module`, `view_controller`, `view_template`, `view_title`) VALUES (0, 'view_index.php', 'view_index.tpl', 'System Overview'), (0, 'view_config.php', 'view_config.tpl', 'Configuration'), (0, 'view_apps.php', 'view_apps.tpl', 'Applications'), (0, 'view_logs.php', 'view_logs.tpl', 'Logs'), (0, 'view_modules.php', 'view_modules.tpl', 'Modules')");
		
		$database->query("INSERT INTO `".$db_table_prefix."tabs` (`tab_order`, `tab_parent`, `tab_divider`, `tab_name`, `tab_slug`, `tab_icon`, `tab_view_id`) VALUES (0, 1, 0, 'Home', 'index', 'home', 1), (1, 2, 0, 'Config', 'config', 'settings', 2), (2, 3, 0, 'Applications', 'apps', 'settings_applications', 3), (20, 4, 0, 'Logs', 'logs', 'assignment', 4), (0, 6, 1, 'Manage Modules', 'manage-modules', '', 5), (4, 6, 0, 'Modules', 'modules', 'extension', 1)");
		
		//Add defaults to database.php
		file_put_contents("../core/database.php", "<?php\ndefine(\"DB_HOST\", \"$db_host\");\ndefine(\"DB_USERNAME\", \"$db_username\");\ndefine(\"DB_PASSWORD\", \"$db_password\");\ndefine(\"DB_DATABASE\", \"$db_database\");\ndefine(\"PASSWORD_SALT\", \"$db_password_salt\");\ndefine(\"DB_CHARSET\", \"utf8\");\ndefine(\"T_PREFIX\", \"$db_table_prefix\");\n\$database = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);");
		file_put_contents(".htaccess", "Deny from all");
		
		
		echo "Installation finished!";
	}

	
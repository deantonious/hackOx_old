<?php
	
	/**
	 *	Use $controller for template stuff and $module to access your module data
	 */
	
	$controller->addJS("js/mailspoof.js"); 
	$controller->set("smtp_host", $module->get("smtp_host"));
	$controller->set("smtp_port", $module->get("smtp_port"));
	$controller->set("smtp_username", $module->get("smtp_username"));
	$controller->set("smtp_password", $module->get("smtp_password"));
	$controller->set("module_id", $module_id);
	
	
	//$api = new ModuleAPI();
	//$output = $module->install_package("nmap ");
	
	//$module->save_log("fdsfnsdlfkj");
	//$module->execute_command("ifconfig");
	
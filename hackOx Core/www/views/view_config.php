<?php
	
	/**
	 * Page Content
	 */
	$aux = "";
	$loaded_data = $this->database->query("SELECT * FROM " . T_PREFIX . "config")->fetch_assoc();
	
	$controller->set("dev_name", $loaded_data['dev_name']);
	$controller->set("dev_remote_url", $loaded_data['dev_remote_url']);
	$controller->set("dev_id", $loaded_data['dev_id']);
	$controller->set("dev_key", $loaded_data['dev_key']);
	$controller->set("dev_admin_usr", $loaded_data['dev_admin_usr']);
	
	//Load SSIDs
	//iwlist wlan0 scan | grep ESSID:
	
	//Load Interfaces
	$interfaces = getInterfaces();
	foreach($interfaces as $interface) {
		$name = $interface["name"];
		$enabled = $interface["enabled"];
		
		if($enabled == "true" && $name[0] == "w")
			$aux .= "<option value=\"$name\">$name</option>";
	}
	$controller->set("config_wc_interfaces", $aux);
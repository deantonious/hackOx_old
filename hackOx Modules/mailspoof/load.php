<?php
	
	/**
	 *	Use $load for template stuff and $module to access your module data
	 */
	
	$load->addJS("js/mailspoof.js"); 
	$load->set("smtp_host", $module->get("smtp_host"));
	$load->set("smtp_port", $module->get("smtp_port"));
	$load->set("smtp_username", $module->get("smtp_username"));
	$load->set("smtp_password", $module->get("smtp_password"));
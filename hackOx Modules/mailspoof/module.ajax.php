<?php
	session_start();
	
	include($_SERVER["DOCUMENT_ROOT"] . "/load.php");
	require("module.php");
	
	$response = new Response();
	$log = new LogManager();
	$log->loadDB($database);
	
	if(isset($_POST["form_smtp_host"]) && isset($_POST["form_smtp_encryption"]) && isset($_POST["form_smtp_port"]) && isset($_POST["form_smtp_username"]) && isset($_POST["form_smtp_password"]) && isset($_POST["form_from_name"]) && isset($_POST["form_from_email"]) && isset($_POST["form_reply_name"]) && isset($_POST["form_reply_email"]) && isset($_POST["form_destination_email"]) && isset($_POST["form_subject"]) && isset($_POST["form_message"]) && $_POST["form_smtp_host"] != "" && $_POST["form_smtp_encryption"] != "" && $_POST["form_smtp_port"] != "" && $_POST["form_smtp_username"] != "" && $_POST["form_smtp_password"] != "" && $_POST["form_from_name"] != "" && $_POST["form_from_email"] != "" && $_POST["form_reply_name"] != "" && $_POST["form_reply_email"] != "" && $_POST["form_destination_email"] != "" && $_POST["form_subject"] != "" && $_POST["form_message"] != "") {
		
		$mailspoof = new MailSpoof($database);
		
		$mailspoof->configure($_POST["form_smtp_host"], $_POST["form_smtp_encryption"], $_POST["form_smtp_port"], $_POST["form_smtp_username"], $_POST["form_smtp_password"]);
		
		$form_from_name = $_POST["form_from_name"];
		$form_from_email = $_POST["form_from_email"];
		$form_reply_name = $_POST["form_reply_name"];
		$form_reply_email = $_POST["form_reply_email"];
		$form_destination_email = $_POST["form_destination_email"];
		$form_subject = $_POST["form_subject"];
		$form_message = $_POST["form_message"];
		
		$output = $mailspoof->send($form_subject, $form_message, $form_from_name, $form_from_email, $form_reply_name, $form_reply_email, $form_destination_email, $form_subject, $form_message);
		if($output != -1) {
			$log->addModuleLog($_POST["module_id"], $output);
			$response->setWData(0, "The message has been sent.", "$output");
		} else { 
			$response->set(1, "Couldn't send mail.");
		}
		
	} else {
		$response->set(1, "Please, don't leave any input empty.");
	}
	echo json_encode($response);

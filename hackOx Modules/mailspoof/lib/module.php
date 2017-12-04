<?php
	session_start();
	
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	//Import libraries
	require("class.phpmailer.php");
	require("class.smtp.php");
	
	include($_SERVER["DOCUMENT_ROOT"] . "/core/database.php");
	include($_SERVER["DOCUMENT_ROOT"] . "/core/class.Response.php");
	include($_SERVER["DOCUMENT_ROOT"] . "/core/class.LogManager.php");
	include($_SERVER["DOCUMENT_ROOT"] . "/functions.php");
	
	if(!checkSession()) {
		header("Location: /login.php");
	}
	
	$log = new LogManager($database);
	$response = new Response();
	
	if(isset($_POST["form_smtp_host"]) && isset($_POST["form_smtp_encryption"]) && isset($_POST["form_smtp_port"]) && isset($_POST["form_smtp_username"]) && isset($_POST["form_smtp_password"]) && isset($_POST["form_from_name"]) && isset($_POST["form_from_email"]) && isset($_POST["form_reply_name"]) && isset($_POST["form_reply_email"]) && isset($_POST["form_destination_email"]) && isset($_POST["form_subject"]) && isset($_POST["form_message"]) && $_POST["form_smtp_host"] != "" && $_POST["form_smtp_encryption"] != "" && $_POST["form_smtp_port"] != "" && $_POST["form_smtp_username"] != "" && $_POST["form_smtp_password"] != "" && $_POST["form_from_name"] != "" && $_POST["form_from_email"] != "" && $_POST["form_reply_name"] != "" && $_POST["form_reply_email"] != "" && $_POST["form_destination_email"] != "" && $_POST["form_subject"] != "" && $_POST["form_message"] != "") {
		$form_smtp_host = $_POST["form_smtp_host"];
		$form_smtp_encryption = $_POST["form_smtp_encryption"];
		$form_smtp_port = $_POST["form_smtp_port"];
		$form_smtp_username = $_POST["form_smtp_username"];
		$form_smtp_password = $_POST["form_smtp_password"];
		
		$form_from_name = $_POST["form_from_name"];
		$form_from_email = $_POST["form_from_email"];
		
		$form_reply_name = $_POST["form_reply_name"];
		$form_reply_email = $_POST["form_reply_email"];
		
		$form_destination_email = $_POST["form_destination_email"];
		
		$form_subject = $_POST["form_subject"];
		$form_message = $_POST["form_message"];
		
		$mail = new PHPMailer();
		$mail->SMTPDebug = 3;
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = $form_smtp_host; 
		$mail->Username = $form_smtp_username; 
		$mail->Password = $form_smtp_password; 
		$mail->Port = $form_smtp_port;
		$mail->SMTPSecure = $form_smtp_encryption;
		
		$mail->From = $form_from_email;
		$mail->FromName = $form_from_name; 
		
		$mail->AddReplyTo($form_reply_email, $form_reply_name);
		
		$mail->AddAddress($form_destination_email); 
		
		$mail->Subject = $form_subject;
		$mail->Body = nl2br($form_message);
		$mail->IsHTML(true);
		
		$mail->CharSet = "UTF-8";
		
		$debug = "";
		$mail->Debugoutput = function($str, $level) {
			$GLOBALS["debug"] .= "Lv. $level: $str";
		};

		if($mail->Send()) {
			$log->addModuleLog($_POST["module_id"], $debug);
			$response->setWData(0, "The message has been sent.", "$debug");
		} else { 
			$response->set(1, "Couldn't send mail.");
		}
	} else {
		$response->set(1, "Please, don't leave any input empty.");
	}
	echo json_encode($response);

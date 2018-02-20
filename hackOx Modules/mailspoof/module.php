<?php

	require("lib/class.phpmailer.php");
	require("lib/class.smtp.php");
	
	class MailSpoof extends Module {
		
		private $smtp_host;
		private $smtp_encryption;
		private $smtp_port;
		private $smtp_username;
		private $smtp_password;
		
		public function configure($form_smtp_host, $form_smtp_encryption, $form_smtp_port, $form_smtp_username, $form_smtp_password) {
			$this->smtp_host = $form_smtp_host;
			$this->smtp_encryption = $form_smtp_encryption;
			$this->smtp_port = $form_smtp_port;
			$this->smtp_username = $form_smtp_username;
			$this->smtp_password = $form_smtp_password;
		}
		
		public function send($form_subject, $form_message, $form_from_name, $form_from_email, $form_reply_name, $form_reply_email, $form_destination_email, $form_subject, $form_message) {
			$mail = new PHPMailer();
			$mail->SMTPDebug = 3;
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host = $this->smtp_host; 
			$mail->Username = $this->smtp_username; 
			$mail->Password = $this->smtp_password; 
			$mail->Port = $this->smtp_port;
			$mail->SMTPSecure = $this->smtp_encryption;
			
			$mail->From = $form_from_email;
			$mail->FromName = $form_from_name; 
			
			$mail->AddReplyTo($form_reply_email, $form_reply_name);
			
			$mail->AddAddress($form_destination_email); 
			
			$mail->Subject = $form_subject;
			$mail->Body = nl2br($form_message);
			$mail->IsHTML(true);
			
			$mail->CharSet = "UTF-8";
			
			global $debug;
			$mail->Debugoutput = function($str, $level) {
				$GLOBALS["debug"] .= "Lv. $level: $str";
			};
			
			if($mail->Send()) {
				return $debug;
			}
			return -1;
		}
		
	}
	
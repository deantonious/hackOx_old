<?php
	
	class Response { 		
		
		public $exit_code;
		public $message;
		public $data;
		
		/**
		 *	Set response exit code and message to be displayed
		 *	
		 *	@return void
		 */
		public function set($exit_code, $message) {
			$this->exit_code = $exit_code;
			$this->message = $message;
			$this->data = "";
		}
		
		/**
		 *	Set response exit code, message and output to be displayed
		 *	
		 *	@return void
		 */
		public function setWData($exit_code, $message, $data) {
			$this->exit_code = $exit_code;
			$this->message = $message;
			$this->data = $data;
		}
	}
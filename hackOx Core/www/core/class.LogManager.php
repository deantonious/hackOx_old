<?php

	class LogManager { 		

		private $database;
		
		public function __construct($database) {
			$this->database = $database;
		}
		/**
		 *	Log action on the DataBase
		 *	
		 *	@param $database Connection to the DataBase
		 *	@param $action Action to be logged
		 *	@param $data Data for the action logged
		 *	@return string Returns the HTML of the tabs
		 */
		public function addDBLog($action, $data) {
			$date = date("Y-m-d H:i:s");
			$this->database->query("INSERT INTO botpi_logs (log_date, log_action, log_data) VALUES ('$date','$action','$data')");
		}
		
		/**
		 *	Remove all entries from the log talbe on the DataBase
		 *	
		 *	@param $database Connection with the database
		 *	@return void
		 */
		public function clearDBLog() {
			$this->database->query("TRUNCATE TABLE " . T_PREFIX . "logs");
		}
		
		public function addModuleLog($module_id, $data) {
			$module = $this->database->query("SELECT * FROM " . T_PREFIX . "modules WHERE module_id='$module_id'")->fetch_assoc();
			
			$log_file = $_SERVER["DOCUMENT_ROOT"] . "/modules/" . $module["module_directory"] . "/" . $module["module_directory"] . ".log";
			$this->addFileLog($log_file, $data);
			
		}
		
		public function addFileLog($file, $data) {
			$date = date("Y-m-d H:i:s");
			if(!file_exists($file)) {
				shell_exec("sudo touch $file; sudo chmod 0777 $file");
			}
			$file = fopen($file, "a");
			$data = str_replace("\n", "\n\t", $data);
			$data = "\t$data";
			fwrite($file, "\n[$date]:\n$data\n\t");	
			fclose($file);
		}
	}
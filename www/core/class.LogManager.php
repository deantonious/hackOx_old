<?php

	class LogManager { 		

		private $connection;
		
		/**
		 *	Load database connection
		 *	
		 *	@param $database Database connection
		 *	@return void
		 */
		public function load($connection) {
			$this->connection = $connection;
		}
		
		/**
		 *	Create app log entry on it's log file
		 *	
		 *	@param $app_id App ID on DB
		 *	@param $data Data to log
		 *	@return void
		 */
		public function addAppLog($app_id, $data) {
            $exq = $this->connection->prepare("SELECT * FROM apps WHERE app_id=:id");
            $exq->execute([':id' => $app_id]);
            $app = $exq->fetch(PDO::FETCH_ASSOC);
            
			$log_file = "/var/hackox/logs/apps/" . $app["app_directory"] . ".log";
			$this->addFileLog($log_file, $data);
			
		}
		
		/**
		 *	Create module log entry on it's log file
		 *	
		 *	@param $module_id Module ID on DB
		 *	@param $data Data to log
		 *	@return void
		 */
		public function addModuleLog($module_id, $data) {
			$exq = $this->connection->prepare("SELECT * FROM modules WHERE module_id=:id");
            $exq->execute([':id' => $module_id]);
            $module = $exq->fetch(PDO::FETCH_ASSOC);

			$log_file = "/var/hackox/logs/modules/" . $module["module_directory"] . ".log";
			$this->addFileLog($log_file, $data);
			
		}
		
		/**
		 *	Create/append data to log file
		 *	
		 *	@param $file Log file absolute path
		 *	@param $data Data to log
		 *	@return void
		 */
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
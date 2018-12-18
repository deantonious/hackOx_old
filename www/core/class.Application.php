<?php
	
	class Application { 		
		
		private $connection;
		
		private $id;
		private $abs_dir;
		private $config_file;
		
		public function __construct($connection) {
			$this->connection = $connection;
        }
		
		/**
		 *	Load app data
		 *	
		 *	@param $id Application id on DB
		 *	@return boolean Return true if app was loaded successfully 
		 */
		public function load($id) {
            $exq = $this->connection->prepare("SELECT * FROM apps WHERE app_id=:id");
            $exq->execute([':id' => $id]);
            $app = $exq->fetch(PDO::FETCH_ASSOC);

			if($app != null) {
				$this->id = $id;
				$this->abs_dir = ROOT_PATH . "/apps/" . $app["app_directory"];
				$this->config_file = ROOT_PATH . "/apps/" . $app["app_directory"] . "/app.json";
				return true;
			}
			return false;
			
		}
		
		/**
		 *	Run app as normal user
		 *	
		 *	@param $args Arguments for running the app
		 *	@return void
		 */
		public function run($args) {
			$file = file_get_contents($this->config_file);
			$json = json_decode($file, true);
			
			$run_command	= $json["run_command"];
			$script			= $json["script"];
			$script_full	= $this->abs_dir . "/" . $script;
			$output = shell_exec("$run_command $script_full $args 2>&1");

			return $output;
		}

		/**
		 *	Run app as super user
		 *	
		 *	@param $args Arguments for running the app
		 *	@return void
		 */
		public function runSudo($args) {
			$file = file_get_contents($this->config_file);
			$json = json_decode($file, true);
			
			$run_command	= $json["run_command"];
			$script			= $json["script"];
			$script_full	= $this->abs_dir . "/" . $script;
			$output = shell_exec("sudo $run_command $script_full $args 2>&1");
			
			return $output;
		}
		
		/**
		 *	Install app on system
		 *	
		 *	@param $abs_dir Absolute path to app folder
		 *	@param $zip_file Zip file containing app data
		 *	@return void
		 */
		function install($abs_dir, $zip_file) {
			$this->abs_dir = $abs_dir;
			$zip_file = $abs_dir . "/" . $zip_file;
			$data_file = $this->abs_dir . "/app.json";
			
			$zip = new ZipArchive;
			$res = $zip->open($zip_file);
			if ($res === TRUE) {
				$zip->extractTo($abs_dir);
				$zip->close();
				
				$to_decode = file_get_contents($data_file);
				$data = json_decode($to_decode, true);
				
				$directory = $data["directory"];
				$installed = date("Y-m-d H:i:s");
				
				$exq = $this->connection->prepare("INSERT INTO apps (app_directory, app_installed) VALUES (:directory, :installed)");
				if($exq->execute([':directory' => $directory, ':installed' => $installed])) {
					return true;
				}
			}
			return false;

		}
		
		/**
		 *	Unnstall app on system
		 *	
		 *	@return boolean Returns true if the application was successfully removed
		 */
		public function remove() {
			$exq = $this->connection->prepare("DELETE FROM apps WHERE app_id=:id");
			if($exq->execute([':id' => $this->id])) {
				if($this->rrmdir($this->abs_dir))
					return true;
			}
			return false;
		}

		private function rrmdir($dir) {
			if (!file_exists($dir)) {
				return true;
			}

			if (!is_dir($dir)) {
				return unlink($dir);
			}

			foreach (scandir($dir) as $item) {
				if ($item == '.' || $item == '..') {
					continue;
				}

				if (!$this->rrmdir($dir . DIRECTORY_SEPARATOR . $item)) {
					return false;
				}

			}

			return rmdir($dir);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	

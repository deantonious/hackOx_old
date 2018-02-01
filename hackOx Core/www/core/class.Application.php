<?php
	
	class Application { 		
		
		private $database;
		
		private $id;
		private $abs_dir;
		private $config_file;
		
		public function __construct($database) {
			$this->database = $database;
        }
		
		public function load($id) {
			$app = $this->database->query("SELECT * FROM " . T_PREFIX . "apps WHERE app_id='$id'")->fetch_assoc();
			if($app != null) {
				$this->id = $id;
				$this->abs_dir = ROOT_PATH . "/apps/" . $app["app_directory"];
				$this->config_file = ROOT_PATH . "/apps/" . $app["app_directory"] . "/app.json";
				return true;
			}
			return false;
			
		}
		
		public function run($args, $mode) {
			$file = file_get_contents($this->config_file);
			$json = json_decode($file, true);
			
			$run_command	= $json["run_command"];
			$script			= $json["script"];
			$script_full	= $this->abs_dir . "/" . $script;
			if($mode == "normal") {
				$output = shell_exec("$run_command $script_full $args");
			} else if($mode == "sudo") {
				$output = shell_exec("sudo $run_command $script_full $args");
			}
			
			return $output;
		}
		
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
				
				$app_query = "INSERT INTO " . T_PREFIX . "apps (app_directory, app_installed) VALUES ('$directory','$installed')";
				if($this->database->query($app_query)) {
					return true;
				}
			}
			return false;

		}
		
		public function remove() {
			$app_query = "DELETE FROM " . T_PREFIX . "apps WHERE app_id=" . $this->id;
			
			if($this->database->query($app_query)) {
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	

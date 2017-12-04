<?php
	
	class Application { 		
		
		private $database;
		
		private $app_full_dir;
		private $app_id;
		private $app_file;
		
		public function __construct($database) {
			$this->database = $database;
        }
		
		public function load($id) {
			$app = $this->database->query("SELECT * FROM " . T_PREFIX . "apps WHERE app_id='$id'")->fetch_assoc();
			if($app != null) {
				$this->app_id = $id;
				$this->app_full_dir = ROOTPATH . $app["app_directory"];
				$this->app_file = $this->app_full_dir . "/" . $app["app_file"];
				return true;
			}
			return false;
			
		}
		
		public function run($args, $mode) {
			if($mode == "normal") {
				$output = shell_exec("sh " . $this->app_file . " $args");
			} else if($mode == "sudo") {
				$output = shell_exec("sudo sh " . $this->app_file . " $args");
			}
			return $output;
		}
		
		function install($app_full_dir, $zip_file) {
			$this->app_full_dir = $app_full_dir;
			$zip_file = $app_full_dir . "/" . $zip_file;
			$data_file = $this->app_full_dir . "/app.json";
			
			$zip = new ZipArchive;
			$res = $zip->open($zip_file);
			if ($res === TRUE) {
				$zip->extractTo($app_full_dir);
				$zip->close();
				
				$to_decode = file_get_contents($data_file);
				$data = json_decode($to_decode, true);
				
				$app_name = $data["name"];
				$app_version = $data["version"];
				$app_author = $data["author"];
				$app_description = $data["description"];
				$app_script = $data["script"];
				$app_installed = date("Y-m-d H:i:s"); 
				$app_directory = "apps/" . basename($zip_file, ".zip");
				
				$app_query = "INSERT INTO " . T_PREFIX . "apps (app_name, app_version, app_author, app_description, app_file, app_directory, app_installed) VALUES ('$app_name','$app_version','$app_author','$app_description','$app_script','$app_directory','$app_installed')";
				if($this->database->query($app_query)) {
					return true;
				}
			}
			return false;

		}
		
		public function remove() {
			$app_query = "DELETE FROM " . T_PREFIX . "apps WHERE app_id=" . $this->app_id;
			
			if($this->database->query($app_query)) {
				if($this->rrmdir($this->app_full_dir))
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	

<?php

	class Module {
		
		private $database;
		
		private $id;
		private $view_id;
		private $abs_dir;
		private $config_file;
		
		private $configuration = array();
		
		public function __construct($database) { 
			$this->database = $database;
		}

		/**
		 *	Load module data and config values
		 *
		 *	@id $id Module ID on DB
		 *	@return boolean
		 */ 
		public function load($id) {
			$module = $this->database->query("SELECT * FROM " . T_PREFIX . "modules WHERE module_id='$id'")->fetch_assoc();
			if($module != null) {
				$this->id = $id;
				$this->view_id = $module["view_id"];
				$this->abs_dir = ROOT_PATH . "/modules/" . $module["module_directory"];
				$this->config_file = ROOT_PATH . "/modules/" . $module["module_directory"] . "/module.json";
				
				//Load config values
				$config = $this->database->query("SELECT * FROM " . T_PREFIX . "modules_config WHERE module_id='$id'");		
				if ($config->num_rows > 0) {
					while($row = $config->fetch_assoc()) {
						$this->configuration[$row["config_key"]] = $row["config_value"];
					}
				}
				
				return true;
			}
			return false;
		}
		
		/**
		 *	Install module package
		 *
		 *	@param $abs_dir Absolute directory of the module
		 *	@param $zip_file Module package (zip file name)
		 *	@return boolean
		 */ 
		public function install($abs_dir, $zip_file) {		
			$this->abs_dir = $abs_dir;
			$zip_file = $abs_dir . "/" . $zip_file;
			$data_file = $this->abs_dir . "/module.json";
			
			$zip = new ZipArchive;
			$res = $zip->open($zip_file);
			if ($res === TRUE) {
				$zip->extractTo($abs_dir);
				$zip->close();
				
				$to_decode = file_get_contents($data_file);
				$data = json_decode($to_decode, true);
				
				$directory = $data["directory"];
				$installed = date("Y-m-d H:i:s");
				//Create view				
				$directory = $data["directory"];
				$name = $data["info"]["name"];
				
				$this->database->query("INSERT INTO " . T_PREFIX . "views (view_is_module, view_controller, view_template, view_title) VALUES (1, 'load.php', 'module.tpl', '$name')");
				$view_id = $this->database->insert_id;
				
				//Create tab if set
				$tab_display = $data["tab"]["display"];
				if($tab_display == 1) {
					$tab_name = $data["tab"]["name"];
					$tab_slug = $data["tab"]["slug"];
					$tab_order = $this->database->query("SELECT MAX(tab_order)+1 AS next_order FROM botpi_tabs WHERE tab_parent=6 AND tab_id<>tab_parent");
					if($tab_order === false) {
							$tab_order = 0;
					} else {
							$tab_order = $tab_order->fetch_object()->next_order;
					}
					
					$this->database->query("INSERT INTO " . T_PREFIX . "tabs (tab_order, tab_parent, tab_divider, tab_name, tab_slug, tab_icon, tab_view_id) VALUES ($tab_order, 6, 0, '$tab_name', '$tab_slug', '', $view_id)");
				
				}
				
				$module_query = "INSERT INTO " . T_PREFIX . "modules (view_id, module_installed, module_directory, module_enabled) VALUES ($view_id, '$installed', '$directory', 1)";
				if($this->database->query($module_query)) {
					$this->id = $this->database->insert_id;
					//Load default config
					$default_config = $data["default_config"];
					foreach($default_config as $config) {
						$this->set($config["key"], $config["value"]);
					}
					//Load install commands
					$install_commands = $data["install_commands"];
					foreach($install_commands as $command) {
						shell_exec($command);
					}
					return true;
				}
				
			}
			return false;
		}
		
		/**
		 *	Remove module files and DB entries
		 *
		 *	@return boolean
		 */ 
		public function remove() {
			$removed = false;
			//Remove tab
			$removed = $this->database->query("DELETE FROM " . T_PREFIX . "tabs WHERE tab_view_id=" . $this->view_id);
			//Remove view 
			$removed = $this->database->query("DELETE FROM " . T_PREFIX . "views WHERE view_id=" . $this->view_id);
			//Remove module
			$removed = $this->database->query("DELETE FROM " . T_PREFIX . "modules WHERE module_id=" . $this->id);
			//Remove configs from db
			$removed = $this->database->query("DELETE FROM " . T_PREFIX . "modules_config WHERE module_id=" . $this->id);
			
			if($removed) {
				if($this->rrmdir($this->abs_dir))
					return true;
			}
			return false;
		}
		
		/**
		 *	Update/Create configuration value on DB and PHP
		 *
		 *	@param $key Configuration key to be updated/created
		 *	@param $value Configuration value 
		 *	@return void
		 */ 
		public function set($key, $value) {
			$this->configuration[$key] = $value; 
			if($this->database->query("SELECT * FROM ".T_PREFIX."modules_config WHERE module_id=" . $this->id . " AND config_key='$key'")->num_rows == 0) {
				$this->database->query("INSERT INTO " . T_PREFIX . "modules_config (module_id, config_key, config_value) VALUES(" . $this->id . ", '$key', '$value')");
			} else {
				$this->database->query("UPDATE " . T_PREFIX . "modules_config SET config_value='$value' WHERE module_id=" . $this->id . " AND config_key='$key'");
			}
		}
		
		/**
		 *	Return configuration value
		 *
		 *	@param $key Configuration key 
		 *	@return void
		 */ 
		public function get($key) {
			if(isset($this->configuration[$key]))
				return $this->configuration[$key];
			return "";
		}
		
		/**
		 *	Remove directory and it's contents
		 *
		 *	@param $dir Absolute directory to remove
		 *	@return boolean
		 */ 
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
		
		public function execBackground($command) {
			return exec("$command > /dev/null &");
		}
		
		public function execNormal($command) {
			return shell_exec("$command 2>&1");
		}
		
		public function execRoot($command) {
			return shell_exec("sudo $command 2>&1");
		}
		
		public function getInterfaces() {
			$interface_names = shell_exec("ip link show | awk 'NR%2!=0' | cut -d ':' -f 2");
			$interface_names = str_replace("lo\n", "", $interface_names);
			$interface_names = str_replace(" ", "", $interface_names);
			$interface_names = str_replace("\n", ",", $interface_names);
			$interface_names = substr($interface_names, 0, -1);
			$interface_names = explode(",", $interface_names);
			
			$interfaces = array();
			foreach($interface_names as $interface_name) {
				$interface = array();
				$interface["name"] = $interface_name;
				
				if(shell_exec("ip link show $interface_name up") != "") {
					$interface["enabled"] = "true";
				} else {
					$interface["enabled"] = "false";
				}
				
				$interface_data = shell_exec("ip addr show $interface_name");
				
				preg_match("/.*link\/ether\s([a-fA-F0-9:]{17}).*/ims", $interface_data, $regex);
				if(count($regex) > 0) {
					$interface["mac"] = $regex[1];
				} else {
					$interface["mac"] = "-";
				}
				
				preg_match("/.*inet\s(([0-9]?[0-9]?[0-9]\.){3}([0-9]?[0-9]?[0-9])).*/ims", $interface_data, $regex);
				if(count($regex) > 0) {
					$interface["ip"] = $regex[1];
				} else {
					$interface["ip"] = "-";
				}
				
				preg_match("/.*brd\s(([0-9]?[0-9]?[0-9]\.){3}([0-9]?[0-9]?[0-9])).*/ims", $interface_data, $regex);
				if(count($regex) > 0) {
					$interface["broadcast"] = $regex[1];
				} else {
					$interface["broadcast"] = "-";
				}
				
				preg_match("/.*inet\s(([0-9]?[0-9]?[0-9]\.){3}([0-9]?[0-9]?[0-9])\/[1-4][0-9]?).*/ims", $interface_data, $regex);
				if(count($regex) > 0) {
					$cidr = substr($regex[1], strpos($regex[1], '/') + 1) * 1;
					$netmask = str_split(str_pad(str_pad('', $cidr, '1'), 32, '0'), 8);
					foreach ($netmask as &$element) $element = bindec($element);
					$interface["netmask"] = join('.', $netmask);
		
				} else {
					$interface["netmask"] = "-";
				}
				
				$interfaces[] = $interface;
			}
			return $interfaces;
		}
	
	}
	
	

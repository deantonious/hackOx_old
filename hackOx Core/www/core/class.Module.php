<?php

	class Module {
		
		private $database;
		private $id;
		private $configuration = array();
		
		public function __construct($database) { 
			$this->database = $database;
		}
		
		public function load($id) {
			$this->id = $id;
			$module = $this->database->query("SELECT * FROM " . T_PREFIX . "modules WHERE module_id='$id'")->fetch_assoc();
			if($module != null) {
				//Load module data
				
				
				//Load config
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
		
		public function install() {
			//Load JSON
			//Add module info to 'modules' (view_id module_installed module_directory module_enabled)
			//Add view to 'views' (view_is_module view_controller view_template view_title)
			//If show tab -> add tab to 'tabs' (tab_order tab_parent(5) tab_divider(0) tab_name tab_slug tab_icon tab_view_id
		}
		
		public function remove() {
			
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
			if(!($this->database->query("UPDATE " . T_PREFIX . "modules_config SET config_value='$value' WHERE module_id=" . $this->id . " AND config_key='$key'") > 0)) {
				$this->database->query("INSERT INTO " . T_PREFIX . "modules_config (config_key, config_value) VALUES('$key', '$value')");
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
	
	}
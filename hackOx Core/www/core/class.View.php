<?php

	class View {
		
		private $database;
		private $id;
		private $is_module;
		private $controller;
		private $template;
		private $title;
		
		public function __construct($database) {
			$this->database = $database;
        }
		
		public function load($id) {
			$this->id = $id;
			if($view = $this->database->query("SELECT * FROM " . T_PREFIX . "views WHERE view_id=$id")->fetch_assoc()) {
				$this->is_module	= $view["view_is_module"];
				$this->controller	= $view["view_controller"];
				$this->template		= $view["view_template"];
				$this->title		= $view["view_title"];
				return true;
			}	
			return false;
		}
		
		public function render() {
			if($this->is_module == 1)
				return $this->renderModulePage();
			return $this->renderPage();
		}
		
		private function renderPage() {
			/**
			 * Navigation Bar
			 */
			$nav = new Navigation($this->database);
			$nav->generateTabs();
			$navbar = new Template("views/navigation.tpl");
			$navbar->set("logo", "hackOx");
			$navbar->set("tabs", $nav->getTabs());
			$navbar->set("tabs_mobile", $nav->getMobileTabs());
			
			/**
			 * Page Content
			 */
			 
			$controller = new Template("views/" . $this->template);
			include(ROOT_PATH . "/views/" . $this->controller);
			
			/**
			 * Create and return page
			 */
			$page = new Template("views/page.tpl");
			$page->set("main_title", "hackOx");
			$page->set("title", $this->title);
			$page->set("navbar", $navbar->output());
			$page->set("content", $controller->output());
			
			return $page->output(); 
		}
		
		private function renderModulePage() {
			
			/**
			 * Navigation Bar
			 */
			$nav = new Navigation($this->database);
			$nav->generateTabs();

			$navbar = new Template("views/navigation.tpl");
			$navbar->set("logo", "hackOx");
			$navbar->set("tabs", $nav->getTabs());
			$navbar->set("tabs_mobile", $nav->getMobileTabs());
			
			/**
			 * Page Content
			 */
			
			$view_id = $this->id;
			$module_db = $this->database->query("SELECT * FROM " . T_PREFIX . "modules WHERE view_id='$view_id'")->fetch_assoc();
			$module_id = $module_db["module_id"];
			$module_directory = $module_db["module_directory"];

			$module = new Module($this->database);
			$module->load($module_id);
			
			//Module View 
			$load = new Template("modules/$module_directory/" . $this->template);
			include(ROOT_PATH . "/modules/$module_directory/" . $this->controller);
			
			/**
			 * Create and return page
			 */
			$page = new Template("views/page_module.tpl");
			$page->set("main_title", "hackOx");
			$page->set("title", $this->title);
			$page->set("navbar", $navbar->output());
			$page->set("scripts", $load->outputJS());
			$page->set("module_panel", $load->output());
			$page->set("module_output", "No output returned...");
			
			$log_file = LOGPATH . "/modules/$module_directory.log";
			$page->set("module_log_file", "$module_directory.log");
			if(file_exists($log_file)) {
				$page->set("module_logs", file_get_contents($log_file));
			} else {
				$page->set("module_logs", "No log file found...");
			}
			
			
			$module_about = "";
			$module_json = json_decode(file_get_contents(ROOT_PATH . "/modules/$module_directory/module.json"), true);
			foreach($module_json["info"] as $key => $value) {
				$module_about .= ucfirst($key) . ": $value<br/>";
			}
			$page->set("module_about", $module_about);
			
			return $page->output();
		}
	}
	
<?php

	class View {
		
		private $connection;
		private $id;
		private $is_module;
		private $controller;
		private $template;
		private $title;
		
		public function __construct($connection) {
			$this->connection = $connection;
        }
		
		public function load($id) {
            $this->id = $id;
            $exq = $this->connection->prepare("SELECT * FROM views WHERE view_id=:id");
            $exq->execute([':id' => $id]);
            $view = $exq->fetch(PDO::FETCH_ASSOC);
            
			if($view) {
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
			$nav = new Navigation($this->connection);
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
			$content = new ContentLoader($controller, $this->connection);
			$content->load();

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
			$nav = new Navigation($this->connection);
			$nav->generateTabs();

			$navbar = new Template("views/navigation.tpl");
			$navbar->set("logo", "hackOx");
			$navbar->set("tabs", $nav->getTabs());
			$navbar->set("tabs_mobile", $nav->getMobileTabs());
			
			/**
			 * Page Content
			 */
			
			$view_id = $this->id;
			$exq = $this->connection->prepare("SELECT * FROM modules WHERE view_id=:id");
			$exq->execute([':id' => $view_id]);
			$module_info = $exq->fetch(PDO::FETCH_ASSOC);

			$module_id = $module_info["module_id"];
			$module_directory = $module_info["module_directory"];

            //Load custom module class
            $module_config = json_decode(file_get_contents(ROOT_PATH . "/modules/$module_directory/module.json"), true);
            $module_class = $module_config["info"]["name"];
            include(ROOT_PATH . "/modules/$module_directory/module.php");
            $module = new $module_class($this->connection);
            $module->load($module_id);
			
			//Module View 
			$controller = new Template("modules/$module_directory/module.tpl");
			$module->loadUI($controller);
			
			/**
			 * Create and return page
			 */
			$page = new Template("views/page_module.tpl");
			$page->set("main_title", "hackOx");
			$page->set("title", $this->title);
			$page->set("dir", "/modules/$module_directory/");
			$page->set("id", $module_id);
			$page->set("navbar", $navbar->output());
			$page->set("scripts", $controller->outputJS());
			$page->set("module_panel", $controller->output());
			$page->set("module_output", "No output returned...");

            $file = LOGPATH . "/modules/$module_directory.log";
            $file_name = basename($file).PHP_EOL;
			$page->set("module_logs", "<span class=\"title\">$file_name</span><div class=\"log-block\" data-log=\"$file\">Loading...</div>");

			
			
			$module_about = "";
			$module_json = json_decode(file_get_contents(ROOT_PATH . "/modules/$module_directory/module.json"), true);
			foreach($module_json["info"] as $key => $value) {
				$module_about .= ucfirst($key) . ": $value<br/>";
			}
			$page->set("module_about", $module_about);
			
			return $page->output();
		}
	}
	
<?php
	
	class Navigation {
		
		private $connection;
		private $tabs;
		private $tabs_mobile;
		
		public function __construct($connection) {
			$this->connection = $connection;
        }
		
		/**
		 *	Generate the tabs HTML to be added to the navbar
		 *
		 *	@return string Returns the HTML of the tabs
		 */ 
		public function generateTabs() {

			$exq = $this->connection->prepare("SELECT * FROM tabs WHERE tab_id=tab_parent ORDER BY tab_order");
			$exq->execute();
            $parent_tabs = $exq->fetchAll(PDO::FETCH_ASSOC);

			foreach($parent_tabs as $tab_parent) {
				$tab_name		= $tab_parent["tab_name"];
				$tab_id 		= $tab_parent["tab_id"];
				$tab_slug 		= $tab_parent["tab_slug"];
				$tab_icon 		= $tab_parent["tab_icon"];
				$tab_view_id	= $tab_parent["tab_view_id"];
				
				

				$exq1 = $this->connection->prepare("SELECT * FROM tabs WHERE tab_parent=$tab_id AND tab_id<>$tab_id ORDER BY tab_order");
				$exq1->execute();

				$child_tabs = $exq1->fetchAll(PDO::FETCH_ASSOC);
				//Parent has child tabs
				if (count($child_tabs) > 0) {
					$dropdown_id		= "$tab_slug-$tab_id";
					$dropdown_tabs 		= "";
					
					foreach($child_tabs as $tab_child) {
						$tab_child_id 		= $tab_child["tab_id"];
						$tab_child_name 	= $tab_child["tab_name"];
						$tab_child_divider 	= $tab_child["tab_divider"];
						$tab_child_icon 	= $tab_child["tab_icon"];
						$tab_child_view_id	= $tab_child["tab_view_id"];
						
						//Add child to dropdown tab list
						$dropdown_tabs .= "<li><a href=\"index.php?p=$tab_child_view_id\"><i class=\"left material-icons\">$tab_child_icon</i>$tab_child_name</a></li>";
						if($tab_child_divider == "1")
							$dropdown_tabs .= "<li class=\"divider\"></li>";
					}
					
					//Add parent to main tabs
					$dropdown = "<ul id=\"$dropdown_id\" class=\"dropdown-content dropdown-dark\">$dropdown_tabs</ul>";
					$dropdown_m = "<ul id=\"m-$dropdown_id\" class=\"dropdown-content\">$dropdown_tabs</ul>";
					$this->tabs .= "<li>$dropdown<a class=\"dropdown-trigger\" href=\"#!\" data-target=\"$dropdown_id\"><i class=\"left material-icons\">$tab_icon</i>$tab_name<i class=\"material-icons right\">arrow_drop_down</i></a></li>";
					$this->tabs_mobile .= "<li>$dropdown_m<a class=\"dropdown-trigger\" href=\"#!\" data-target=\"m-$dropdown_id\"><i class=\"left material-icons\">$tab_icon</i>$tab_name<i class=\"material-icons right\">arrow_drop_down</i></a></li>";
					
				} else {
					$this->tabs .= "<li><a href=\"index.php?p=$tab_view_id\"><i class=\"left material-icons\">$tab_icon</i>$tab_name</a></li>";
					$this->tabs_mobile .= "<li><a href=\"index.php?p=$tab_view_id\"><i class=\"left material-icons\">$tab_icon</i>$tab_name</a></li>";
				}
			}
			

			$this->tabs .= "<li><a class=\"btn btn-floating waves-effect waves-light red modal-trigger\" href=\"#power-modal\"><i class=\"left material-icons\">settings_power</i></a></li>";
			$this->tabs_mobile .= "<li><a class=\"modal-trigger\" href=\"#power-modal\"><i class=\"left material-icons\">settings_power</i>Power Options</a></li>";
			
		}
		
		public function getTabs() {
			return $this->tabs;
		}
		
		public function getMobileTabs() {
			return $this->tabs_mobile;
		}
	}
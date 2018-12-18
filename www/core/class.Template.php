<?php

    class Template {

        protected $file;
        protected $values = array();
        protected $scripts = array();
		
        public function __construct($file) {
            $this->file = $file;
        }
        
		/**
		 *	Set values for the page frontend
		 *	
		 *	@param $key String to be replaced by it's value
		 *	@param $value Value for the key
		 *	@return void
		 */
        public function set($key, $value) {
            $this->values[$key] = $value;
        }
        
		/**
		 *	Add a JavaScript file for being used on the template
		 *	
		 *	@param $value File name (including sub-directories relative to the template file)
		 *	@return void
		 */
		public function addJS($value) {
			array_push($this->scripts, $value);
        }
		
		/**
		 *	Generate the HTML for the JavaScript files
		 *	
		 *	@return string Script tag with the given JS files
		 */
		public function outputJS() {
			$tpl_dir = dirname($this->file);
			
			$output = "";
			foreach ($this->scripts as $script) {
				$script = $tpl_dir . "/" . $script;
				$output .= "<script type=\"text/javascript\" src=\"$script\"></script>";
			}
			return $output;
		}
		
		/**
		 *	Generate the frontend code of the page
		 *	
		 *	@return string Returns the HTML of the page
		 */
        public function output() {

            if (!file_exists($this->file)) {
            	return "Error loading template file ($this->file).<br />";
            }
            $output = file_get_contents($this->file);
            
            foreach ($this->values as $key => $value) {
                $output = preg_replace("/{{\\s{0,}$key\\s{0,}}}/i", $value, $output); 
            }

            return $output;
        }
        
    }

?>
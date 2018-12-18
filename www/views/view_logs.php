<?php
	class ContentLoader {

        private $controller;
        private $connection;

        public function __construct($controller, $connection) {
            $this->controller = $controller;
            $this->connection = $connection;
        }

        public function load() {

            /**
             * Page Content
             */
            
            //Load system logs
            $logs = "";
            $log_files = array("/var/log/kern.log", "/var/log/syslog");
            foreach($log_files as $file) {
                $file_name = basename($file).PHP_EOL;
                $logs .= "<span class=\"title\">$file_name</span><div class=\"log-block\" data-log=\"$file\">Loading...</div>";
            }
            $this->controller->set("log_system", $logs);
            
            //Load app logs
            $logs = "";
            $log_dir = "/var/hackox/logs/apps";
            $log_files = glob("$log_dir/*.{log}", GLOB_BRACE);
            foreach($log_files as $file) {
                $file_name = basename($file).PHP_EOL;
                $logs .= "<span class=\"title\">$file_name</span><div class=\"log-block\" data-log=\"$file\">Loading...</div>";
            }
            $this->controller->set("log_apps", $logs);
            
            //Load module logs
            $logs = "";
            $log_dir = "/var/hackox/logs/modules";
            $log_files = glob("$log_dir/*.{log}", GLOB_BRACE);
            foreach($log_files as $file) {
                $file_name = basename($file).PHP_EOL;
                $logs .= "<span class=\"title\">$file_name</span><div class=\"log-block\" data-log=\"$file\">Loading...</div>";
            }
            $this->controller->set("log_modules", $logs);
        }
    }
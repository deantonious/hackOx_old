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
            $aux = "";
            $exq = $this->connection->prepare("SELECT * FROM config");
            $exq->execute();
            $loaded_data = $exq->fetch(PDO::FETCH_ASSOC);
            $this->controller->set("dev_name", $loaded_data['dev_name']);
            $this->controller->set("dev_remote_url", $loaded_data['dev_remote_url']);
            $this->controller->set("dev_id", $loaded_data['dev_id']);
            $this->controller->set("dev_key", $loaded_data['dev_key']);
            $this->controller->set("dev_admin_usr", $loaded_data['dev_admin_usr']);
        }
    }
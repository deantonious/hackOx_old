<?php

    class Database {

        private $connection;
    
        public function __construct() {
            $options = [
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $this->connection = new PDO('sqlite:/var/hackox/database.sqlite', null, null, $options) or die('Unable to open database');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
    
        public function connection() {
            return $this->connection;
        }
    }
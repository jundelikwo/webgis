<?php
    require_once 'config.php';

    class Database {

        public $connection;

        function __construct(){
            $this->openConnection();
        }

        private function openConnection(){
            $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME;
            try {
                $this->connection = new PDO($dsn,DB_USER,DB_PASS);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }

    $database = new Database();
    $db =& $database;

?>
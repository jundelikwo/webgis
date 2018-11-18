<?php
    require_once("config.php");
    require_once("Model.php");
    require_once("Database.php");

    class Area extends Model{
        protected static $tableName = "areas";
        protected static $dbFields = ["id","name","driverId"];
        public $id;
        public $name;
        public $driverId;

        function __construct($name='',$driverId=null){
            $this->name = $name;
            $this->driverId = $driverId;
        }

        protected function create(){
            global $database;

            $sql = 'INSERT INTO ' . static::$tableName . " (name) VALUES (?)";
            
            $smt = $database->connection->prepare($sql);
            $smt->bindParam(1, $this->name);
            $smt->execute();
            $this->id = $database->connection->lastInsertId();
        }
    }

?>
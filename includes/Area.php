<?php
    require_once("config.php");
    require_once("Model.php");
    require_once("Database.php");

    class Area extends Model{
        protected static $tableName = "areas";
        protected static $dbFields = ["id","name","driverId"];
        public $id;
        public $name=null;
        public $driverId;

        function __construct($name='',$driverId=null){
            $this->name = $name;
            $this->driverId = $driverId;
        }
    }

?>
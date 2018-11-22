<?php
    require_once("config.php");
    require_once("Model.php");
    require_once("Database.php");

    class Bin extends Model{
        protected static $tableName = "bins";
        protected static $dbFields = ["id","name","longitude","latitude","areaId"];
        public $id;
        public $name=null;
        public $areaId;
        public $longitude;
        public $latitude;

        function __construct($name='',$longitude="",$latitude="",$areaId=null){
            $this->name = $name;
            $this->areaId = $areaId;
        }
    }

?>
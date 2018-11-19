<?php
    require_once("config.php");
    require_once("Model.php");
    require_once("Database.php");

    class Complain extends Model{
        protected static $tableName = "complains";
        protected static $dbFields = ["id","name","phone","complain","created","view","areaId"];
        //public $errors = [];
        //private $formValidation;
        public $id;
        public $name;
        public $phone;
        public $complain;
        public $created;
        public $areaId=0;
        protected $view = 0;

        function __construct($name='',$phone='',$complain='',$areaId=0){
            global $session;
            global $CURRENT_TIME;
            $this->name = $name;
            $this->phone = $phone;
            $this->complain = $complain;
            $this->areaId = $areaId;
            $this->created = $CURRENT_TIME;
            //$this->formValidation = new Validate(["name" => 255, "price" => 11, "description" => 0]);
        }

        public function markAsViewed(){
            if(empty($this->view)){
                $this->view = 1;
                $this->save();
            }
        }

        /*protected function validate(){
            $this->formValidation->validate_presences();
            $this->formValidation->validate_max_length();
            $this->errors = $this->formValidation->errors;
            $this->validateCategory();
            if($this->address == 1){
                $this->validateState();
            }
        }

        public function save($msg=false){
            global $session;
            $this->validate();
            if(!$this->errors){
                Parent::save($msg);
            }
        }*/
    }

?>
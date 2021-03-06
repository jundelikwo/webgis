<?php
    require_once("Model.php");
    require_once("Database.php");
    require_once("Session.php");

    class User extends Model {

        protected static $tableName = "users";
        public static $error;
        protected static $dbFields = ["id","name","password","username","role"];
        public $errors = [];
        private $formValidation;
        public $id;
        public $role = "driver";
        protected $password;
        public $name;
        public $username;

        public function updatePassword($password){
            $this->password = password_hash($password, PASSWORD_BCRYPT , ["cost" => 10]);
        }

        public static function authenticate($username, $password){
            global $database;
            
            $sql = "SELECT * FROM users WHERE username = ?";
            $smt = $database->connection->prepare($sql);
            $smt->bindParam(1, $username);
            $smt->execute();
            $result = $smt->fetchAll(PDO::FETCH_CLASS);
            if(!$result){
                return false;
            }
            if(password_verify($password, $result[0]->password)){
                $user = new Self;
                $user->id = $result[0]->id;
                $user->name = $result[0]->name;
                $user->role = $result[0]->role;
                return $user;
            }
            return false;
        }
    }

?>
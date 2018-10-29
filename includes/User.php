<?php
    require_once("Model.php");
    require_once("Database.php");
    require_once("Session.php");

    class User extends Model {

        protected static $tableName = "users";
        public static $error;
        protected static $dbFields = ["id","name","password","phone","email","role"];
        public $errors = [];
        private $formValidation;
        public $id;
        public $role = "user";
        public $password;
        public $name;
        public $phone;
        public $email;

        public function save($msg=false){
            global $session;
            $this->validate();
            if(!$this->errors){
                Parent::save('Your Profile has been saved');
            }else{
                $session->flash('errors',$this->errors);
                $session->flash('form',$_POST);
            }
        }

        protected function create(){
            global $session;
            $this->password = password_hash($this->password, PASSWORD_BCRYPT , ["cost" => 10]);
            Parent::create();
            $session->login($this);
        }

        protected function update($msg){
            global $session;
            Parent::update($msg);
            $this->updateProducts();
            $session->login($this);
        }

        public static function authenticate($email, $password){
            global $database;
            if(!Session::istokenValid()){
                // It is actually CSRF token validation that failed 
                // but this is not a helpful message to the user
                static::$error = "CSRF token validation failed";
                return false;
            }
            
            $sql = "SELECT * FROM users WHERE email = ?";
            $smt = $database->connection->prepare($sql);
            $smt->bindParam(1, $email);
            $smt->execute();
            $result = $smt->fetchAll(PDO::FETCH_CLASS);
            if(!$result){
                static::$error = "Email and password are incorrect";
                return false;
            }
            if(password_verify($password, $result[0]->password)){
                $user = new Self;
                $user->id = $result[0]->id;
                $user->name = $result[0]->name;
                $user->role = $result[0]->role;
                return $user;
            }
            static::$error = "Email and password are incorrect";
            return false;
        }
    }

?>
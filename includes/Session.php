<?php

    class Session {
        
        private $loggedIn = false;
        private $isAdmin = false;
        private $flashValues = [];
        private $userId;
        private $userRole;
        public $userName;

        function __construct(){
            session_start();
            $this->flashValues = $_SESSION['flash'];
            $_SESSION['flash'] = [];
            $this->checkLogin();
        }

        private function checkLogin() {
            if(isset($_SESSION['userId'])) {
              $this->userId = $_SESSION['userId'];
              $this->userName = $_SESSION['userName'];
              $this->userRole = $_SESSION['userRole'];
              $this->isAdmin = $_SESSION['userRole'] === 'admin';
              $this->loggedIn = true;
            } else {
              unset($this->userId);
              unset($this->userName);
              unset($this->userRole);
              $this->loggedIn = false;
              $this->userId = 0;
            }
        }

        public function isLoggedIn(){
            return $this->loggedIn;
        }

        public function isAdmin(){
            return $this->isAdmin;
        }

        public function getId(){
            return $this->userId;
        }

        public function logout() {
            unset($_SESSION['userId']);
            unset($this->userId);
            $this->loggedIn = false;
        }

        public static function createToken(){
            $token = md5(uniqid(rand(),TRUE));
            $_SESSION['csrf_token'] = $token;
            $_SESSION['csrf_token_time'] = time();
            return $token;
        }

        public static function istokenValid(){
            if(isset($_POST['csrf_token'])){
                return $_POST['csrf_token'] === $_SESSION['csrf_token'];
            }
            return false;
        }

        public function flash($name,$value){
            $_SESSION['flash'][$name] = $value;
            $this->flashValues[$name] = $value;
        }

        public function getFlashValue($key){
            return isset($this->flashValues[$key]) ? $this->flashValues[$key] : null;
        }

        public function login($user) {
            // database should find user based on username/password
            if($user){
              $this->userId = $_SESSION['userId'] = $user->id;
              $this->userName = $_SESSION['userName'] = $user->name;
              $this->userRole = $_SESSION['userRole'] = $user->role;
              $this->isAdmin = $user->role === 'admin';
              $this->loggedIn = true;
            }
        }

    }
    $session = new Session;
?>
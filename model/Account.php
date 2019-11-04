<?php
    class Account{
        private $table = 'users';
        public $id;
        public $name;
        public $email;
        public $password;
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        public function login(){
            $query = "select * from $this->table where email=:email";
            $stm = $this->conn->prepare($query);
            $stm->bindParam('email', $this->email);
            $stm->execute();
            $num = $stm->rowCount();
            if($num > 0){
                $row = $stm->fetch(PDO::FETCH_ASSOC);
                extract($row);
                $this->id = $id;
                $this->name = $name;
                $this->email = $email;
                if( password_verify($this->password, $password)){
                    return true;
                } 
            }
                return false;
        }
        
        public function register(){
            $query = "insert into $this->table set name=:name, email=:email, password=:pass";
            $stm = $this->conn->prepare($query);
            $stm->bindParam('name', $this->name);
            $stm->bindParam('email', $this->email);
            $stm->bindParam('pass', $this->password);
            if($stm->execute()){
                return true;
            } else {
                return false;
            }
        }
    }
?>
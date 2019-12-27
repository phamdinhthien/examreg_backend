<?php
    class Account{
        private $tb_account = 'account';
        private $tb_students = 'students';
        private $tb_admins = 'admins';

        public $id;
        public $username;
        public $user_id;
        public $password;

        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }

        public function login(){
            $query = "select * from $this->tb_account where username=:username";
            $stm = $this->conn->prepare($query);
            $stm->bindParam('username', $this->username);
            $stm->execute();
            $num = $stm->rowCount();
            if($num > 0){
                $row = $stm->fetch(PDO::FETCH_ASSOC);
                extract($row);
                $this->id = $id;
                $this->user_id = $user_id;
                $this->username = $username;
                $this->role = $role;
                if( password_verify($this->password, $password)){
                    return true;
                } 
            }
                return false;
        }
        
        public function register(){
            $query = "insert into $this->tb_account set name=:name, email=:email, password=:pass";
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
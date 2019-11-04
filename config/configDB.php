<?php 
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '123456';
    private $dbname = 'examreg_backend';
    public $conn;
    public function getConnection(){
        $this->conn = null;
        try{
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->SetAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn = $pdo;
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
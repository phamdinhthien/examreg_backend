<?php
class Semesters
{
    private $table = 'semesters';
    public $id;
    public $name;
    public $year;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createOneSemester()
    {
        $query = "insert into $this->table set name=:name, year=:year";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('name', $this->name);
        $stm->bindParam('year', $this->year);
        if ($stm->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOneSemester()
    {
        $query = "delete from $this->table where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->execute();
        if ($stm->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOneSemester()
    {
        $query = "update $this->table set name=:name, year=:year where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->bindParam('name', $this->name);
        $stm->bindParam('year', $this->year);
        $stm->execute();
        if ($stm->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getOneSemester()
    {
        $query = "select * from $this->table where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->execute();
        return $stm;
    }
    
    public function getAllSemesters()
    {
        // $amount = 5;
        // $start = ((int) $this->page) * $amount + 1;
        // $query = "select * from $this->table limit $start, $amount";
        $query = "select * from $this->table order by year and name desc";
        $stm = $this->conn->prepare($query);
        $stm->execute();
        return $stm;
    }

    public function searchCourse()
    {
        $amount = 5;
        $start = ((int) $this->page) * $amount + 1;
        $query = "select * from $this->table where like concat(:code, '%') limit $start, $amount";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->execute();
        return $stm;
    }
}

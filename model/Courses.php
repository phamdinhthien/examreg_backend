<?php
class Courses
{
    private $table = 'courses';
    public $id;
    public $code;
    public $year_start;
    public $year_end;

    public $page;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createOneCourse()
    {
        $query = "insert into $this->table set code=:code, year_start=:year_start, year_end=:year_end";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('year_start', $this->year_start);
        $stm->bindParam('year_end', $this->year_end);
        if ($stm->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllCourses()
    {
        // $amount = 5;
        // $start = ((int) $this->page) * $amount + 1;
        // $query = "select * from $this->table limit $start, $amount";
        $query = "select * from $this->table order by code desc";
        $stm = $this->conn->prepare($query);
        $stm->execute();
        return $stm;
    }

    public function deleteOneCourse()
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

    public function updateOneCourse()
    {
        $query = "update $this->table set code=:code, year_start=:year_start, year_end=:year_end where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('year_start', $this->year_start);
        $stm->bindParam('year_end', $this->year_end);
        $stm->execute();
        if ($stm->execute()) {
            return true;
        } else {
            return false;
        }
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

    public function getOneCourse()
    {
        $query = "select * from $this->table where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->execute();
        return $stm;
    }
}

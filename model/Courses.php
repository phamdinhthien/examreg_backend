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
        $query = "select * from $this->table";
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

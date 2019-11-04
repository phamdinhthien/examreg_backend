<?php
class Courses
{
    private $table = 'subjects';
    public $id;
    public $code;
    public $name;

    public $page;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllCourses()
    {
        $amount = 5;
        $start = ((int)$this->page)*$amount + 1;
        $query = "select * from $this->table limit $start, $amount";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('name', $this->name);
        $stm->execute();
        return $stm;
    }

    public function searchCourse()
    {
        $amount = 5;
        $start = ((int)$this->page)*$amount + 1;
        $query = "select * from $this->table where like concat(:name, '%') limit $start, $amount";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('name', $this->name);
        $stm->execute();
        return $stm;
    }
}

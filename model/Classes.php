<?php
class Classes
{
    private $table = 'classes';
    public $id;
    public $code;
    public $course_id;

    public $page;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createOneClass()
    {
        $query = "insert into $this->table set code=:code, course_id=:course_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('course_id', $this->course_id);
        if ($stm->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOneClass()
    {
        $query = "delete $this->table where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        if ($stm->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOneClass()
    {
        $query = "update $this->table set code=:code, course_id=:course_id where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('course_id', $this->course_id);
        if ($stm->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllClassesByCourseId()
    {
        // $amount = 5;
        // $start = ((int) $this->page) * $amount + 1;
        // $query = "select * from $this->table limit $start, $amount where course_id=:course_id";
        $query = "select * from $this->table where course_id=:course_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('course_id', $this->course_id);
        $stm->execute();
        return $stm;
    }
}

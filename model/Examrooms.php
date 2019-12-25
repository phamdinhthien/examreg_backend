<?php
class Examrooms
{
    private $tb_examrooms = 'examrooms'; // bảng ca thi

    public $examtime_id; // ID ca thi
    public $name;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * lấy ID cuối của ca thi
     */
    public function getAllExamrooms()
    {
        $query = "select * from $this->tb_examrooms";
        $stm = $this->conn->prepare($query);
        $stm->execute();
        return $stm;
    }
}
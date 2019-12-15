<?php
class Semesters
{
    private $tb_semesters = 'semesters'; // bảng kì thi
    public $id; // ID kì thi
    public $name; // tên kì thi
    public $year; // năm của kì thi

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * tạo 1 học kì
     */
    public function createOneSemester()
    {
        $query = "insert into $this->tb_semesters set name=:name, year=:year";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('name', $this->name);
        $stm->bindParam('year', $this->year);
         try {
            $stm->execute();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    /**
     * xóa một học kì
     */
    public function deleteOneSemester()
    {
        $query = "delete from $this->tb_semesters where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->execute();
         try {
            $stm->execute();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    /**
     * cập nhật một học kì
     */
    public function updateOneSemester()
    {
        $query = "update $this->tb_semesters set name=:name, year=:year where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->bindParam('name', $this->name);
        $stm->bindParam('year', $this->year);
        $stm->execute();
         try {
            $stm->execute();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    /**
     * lấy thông tin 1 học kì
     */
    public function getOneSemester()
    {
        $query = "select * from $this->tb_semesters where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->execute();
        return $stm;
    }
    
    /**
     * lấy thông tin tất cả học kì
     */
    public function getAllSemesters()
    {
        // $amount = 5;
        // $start = ((int) $this->page) * $amount + 1;
        // $query = "select * from $this->tb_semesters limit $start, $amount";
        $query = "select * from $this->tb_semesters order by year and name desc";
        $stm = $this->conn->prepare($query);
        $stm->execute();
        return $stm;
    }

}

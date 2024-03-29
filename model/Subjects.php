<?php
class Subjects
{
    private $tb_subjects = 'subjects'; // bảng môn học
    public $id; // ID môn học
    public $code; // mã môn học
    public $name; // tên môn học
    public $semester_id; // ID kì thi

    public $page;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    /**
     * kiểm tra trùng lặp dữ liệu
     */
    public function isDuclicate()
    {
        $query = "select * from $this->tb_subjects where (name=:name and code=:code)";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('name', $this->name);
        $stm->bindParam('code', $this->code);
        $stm->execute();
        $num = $stm->rowCount();
        if ($num > 0) {
            return true;
        }
        return false;
    }
    /**
     * lấy thông tin 1 môn học dựa trên ID môn học
     */
    public function getOneSubject()
    {
        $query = "select * from $this->tb_subjects where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->execute();
        return $stm;
    }

    /**
     * lấy thông tin tất cả môn học dựa trên ID kì thi
     */
    public function getAllSubjects()
    {
        $query = "select * from $this->tb_subjects where semester_id=:semester_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('semester_id', $this->semester_id);
        $stm->execute();
        return $stm;
    }
    /**
     * tạo 1 môn học
     */
    public function createOneSubject()
    {
        $query = "insert into $this->tb_subjects set code=:code, name=:name, semester_id=:semester_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('name', $this->name);
        $stm->bindParam('semester_id', $this->semester_id);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * cập nhật 1 môn học
     */
    public function updateOneSubject()
    {
        $query = "update $this->tb_subjects set code=:code, name=:name, semester_id=:semester_id where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('name', $this->name);
        $stm->bindParam('semester_id', $this->semester_id);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * xóa 1 môn học
     */
    public function deleteOneSubject()
    {
        $query = "delete from $this->tb_subjects where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

<?php
class Subjects
{
    private $tb_subjects = 'subjects'; // bảng môn học
    public $id; // ID môn học
    public $name; // tên môn học
    public $semester_id; // ID kì thi

    public $page;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
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
        $query = "insert into $this->tb_subjects set name=:name, semester_id=:semester_id";
        $stm = $this->conn->prepare($query);
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
        $query = "update $this->tb_subjects set name=:name, semester_id=:semester_id where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
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

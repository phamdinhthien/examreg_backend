<?php
class SubjectClasses
{
    private $tb_subjectclasses = 'subjectclasses'; // bảng lớp môn học phần
    public $id; // ID lớp môn học phần
    public $code; // mã lớp môn học phần
    public $subject_id; // ID môn học

    public $page;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * lấy thông tin tất cả lớp môn học phần dựa trên ID môn học
     */
    public function getAllSubjectClasses()
    {
        $query = "select * from $this->tb_subjectclasses where subject_id=:subject_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('subject_id', $this->subject_id);
        $stm->execute();
        return $stm;
    }
    /**
     * tạo 1 lớp môn học phần
     */
    public function createOneSubjectClass()
    {
        $query = "insert into  $this->tb_subjectclasses set code=:code, subject_id=:subject_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('subject_id', $this->subject_id);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * cập nhật 1 lớp môn học phần
     */
    public function updateOneSubjectClass()
    {
        $query = "update  $this->tb_subjectclasses set code=:code, subject_id=:subject_id where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('subject_id', $this->subject_id);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * xóa 1 lớp môn học phần
     */
    public function deleteOneSubjectClass()
    {
        $query = "delete from $this->tb_subjectclasses where id=:id";
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

<?php
class Classes
{
    private $tb_classes = 'classes'; // bảng lớp học
    public $id; // ID lớp học
    public $code; // mã lớp học
    public $course_id; // ID khóa học

    public $page;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function isDupicate(){
        $query = "select * from $this->tb_classes where code=:code";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->execute();
        $num = $stm->rowCount();
        if($num > 0){
            return true;
        }
        return false;
    }

    /**
     * tạo 1 lớp học
     */
    public function createOneClass()
    {
        $query = "insert into $this->tb_classes set code=:code, course_id=:course_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('course_id', $this->course_id);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * xóa một lớp học
     */
    public function deleteOneClass()
    {
        $query = "delete from $this->tb_classes where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * cập nhật 1 lớp học
     */
    public function updateOneClass()
    {
        $query = "update $this->tb_classes set code=:code where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->bindParam('code', $this->code);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * lấy thông tin tất cả lớp học dựa trên ID khóa học
     */
    public function getAllClassesByCourseId()
    {
        // $amount = 5;
        // $start = ((int) $this->page) * $amount + 1;
        // $query = "select * from $this->tb_classes limit $start, $amount where course_id=:course_id";
        $query = "select * from $this->tb_classes where course_id=:course_id order by code";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('course_id', $this->course_id);
        $stm->execute();
        return $stm;
    }

    /**
     * lấy thông tin 1 khóa học
     */
    public function getOneClass()
    {
        $query = "select * from $this->tb_classes where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->execute();
        return $stm;
    }
}

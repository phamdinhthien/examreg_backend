<?php
class Courses
{
    private $tb_courses = 'courses'; // bảng khóa học
    public $id; // ID khóa học
    public $code; // mã khóa học
    public $year_start; // năm bắt đầu
    public $year_end; // năm kết thúc

    public $page;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function isDuplicated(){
        $query = "select * from $this->tb_courses where code=:code";
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
     * tạo một khóa học
     */
    public function createOneCourse()
    {
        $query = "insert into $this->tb_courses set code=:code, year_start=:year_start, year_end=:year_end";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('year_start', $this->year_start);
        $stm->bindParam('year_end', $this->year_end);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * lấy thông tin tất cả các khóa học
     */
    public function getAllCourses()
    {
        // $amount = 5;
        // $start = ((int) $this->page) * $amount + 1;
        // $query = "select * from $this->tb_courses limit $start, $amount";
        $query = "select * from $this->tb_courses order by code desc";
        $stm = $this->conn->prepare($query);
        $stm->execute();
        return $stm;
    }

    /**
     * xóa 1 khóa học
     */
    public function deleteOneCourse()
    {
        $query = "delete from $this->tb_courses where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->execute();
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * cập nhật một khóa học
     */
    public function updateOneCourse()
    {
        $query = "update $this->tb_courses set code=:code, year_start=:year_start, year_end=:year_end where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('year_start', $this->year_start);
        $stm->bindParam('year_end', $this->year_end);
        $stm->execute();
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * tìm kiếm khóa học
     */
    public function searchCourse()
    {
        $amount = 5;
        $start = ((int) $this->page) * $amount + 1;
        $query = "select * from $this->tb_courses where like concat(:code, '%') limit $start, $amount";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->execute();
        return $stm;
    }

    /**
     * lấy thông tin 1 khóa học
     */
    public function getOneCourse()
    {
        $query = "select * from $this->tb_courses where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->execute();
        return $stm;
    }
}

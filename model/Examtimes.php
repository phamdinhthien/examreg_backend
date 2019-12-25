<?php
class Examtimes
{
    private $tb_examtimes = 'examtimes'; // bảng ca thi
    private $tb_examrooms = 'examrooms'; // bảng phòng thi
    private $tb_examtimes_subjectclasses = 'examtimes_subjectclasses'; // bảng ca thi - lớp học phần
    private $tb_examtime_examroom = 'examtime_examroom'; // bảng phòng thi
    private $tb_subjects = 'subjects'; // bảng môn học
    private $tb_subjectclasses = 'subjectclasses'; // bảng môn học phần
    private $tb_semesters = 'semesters'; // bảng kì thi

    public $examtime_id; // ID ca thi
    public $subjectclass_id; // id lớp môn học phần
    public $date; // ngày thi
    public $start_time; // thời gian bắt đâu ca thi
    public $examroom_name; // tên phòng thi
    public $amount_computer; // số lượng máy tính
    public $examroom_id; // ID phòng thi
    public $semester_id; // ID kì thi

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * lấy ID cuối của ca thi
     */
    public function getLastExamtimeId()
    {
        $query = "select max(id) as id from $this->tb_examtimes";
        $stm = $this->conn->prepare($query);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            extract($row);
            return $id;
        }
    }

    /**
     * tạo một khóa học
     */
    public function createOneExamtime()
    {
        $query1 = "insert into $this->tb_examtimes set date=:date, start_time=:start_time";
        $stm1 = $this->conn->prepare($query1);
        $stm1->bindParam('date', $this->date);
        $stm1->bindParam('start_time', $this->start_time);

        $query2 = "insert into $this->tb_examtimes_subjectclasses set examtime_id=:examtime_id, subjectclass_id=:subjectclass_id";
        $stm2 = $this->conn->prepare($query2);
        $stm2->bindParam('examtime_id', $this->examtime_id);
        $stm2->bindParam('subjectclass_id', $this->subjectclass_id);

        $query3 = "insert into $this->tb_examtime_examroom set examtime_id=:examtime_id, examroom_id=:examroom_id, amount_computer=:amount_computer";
        $stm3 = $this->conn->prepare($query3);
        $stm3->bindParam('examtime_id', $this->examtime_id);
        $stm3->bindParam('examroom_id', $this->examroom_id);
        $stm3->bindParam('amount_computer', $this->amount_computer);

   
            $stm1->execute();
            $this->examtime_id = $this->getLastExamtimeId();
            if (is_numeric($this->examtime_id)) {
                $stm2->execute() && $stm3->execute();
                return true;
            }
            return false;
        
    }

    /**
     * lấy tất cả thông tin của ca thi theo ID kì thi
     */
    public function getAllExamtimesBySemesterId()
    {
        $query = "select t4.name as subject_name, t5.code as subjectclass_code, t1.date as date, 
                         t1.start_time as start_time, t7.name as examroom_name, t3.amount_computer as amount_computer
                           from $this->tb_examtimes as t1   
                           join $this->tb_examtimes_subjectclasses as t2 on t1.id = t2.examtime_id
                           join $this->tb_examtime_examroom as t3 on t1.id = t3.examtime_id
                           join $this->tb_examrooms as t7 on t7.id = t3.examroom_id
                           join $this->tb_subjectclasses as t5 on t2.subjectclass_id = t5.id
                           join $this->tb_subjects as t4 on t4.id = t5.subject_id
                           join $this->tb_semesters as t6 on t6.id = t4.semester_id
                           where t4.semester_id=:semester_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('semester_id', $this->semester_id);
        $stm->execute();
        return $stm;
    }

    /**
     * lấy thông tin 1 ca thi
     */
    public function getOneExamtime()
    {
        $query = "select t4.name, t5.code, t1.date, t1.start_time, t1.end_time, t3.name, t3.amount_computer
                           from $this->tb_examtimes as t1   
                           join $this->tb_examtimes_subjectclasses as t2 on t1.id = t2.examtime_id
                           join $this->tb_examtime_examroom as t3 on t1.id = t3.examtime_id
                           join $this->tb_subjectclasses as t5 on t2.subjectclass_id = t5.id
                           join $this->tb_subjects as t4 on t4.id = t5.subject_id
                    where t1.id=:examtime_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('examtime_id', $this->examtime_id);
        $stm->execute();
        return $stm;
    }

    /**
     * cập nhật 1 ca thi
     */
    public function updateOneExamtime()
    {
        $query1 = "update $this->tb_examtimes set date=:date, start_time=:start_time, end_time=:end_time where id=:examtime_id";
        $stm1 = $this->conn->prepare($query1);
        $stm1->bindParam('examtime_id', $this->examtime_id);
        $stm1->bindParam('date', $this->date);
        $stm1->bindParam('start_time', $this->start_time);
        $stm1->bindParam('end_time', $this->end_time);

        $query2 = "update $this->tb_examtimes_subjectclasses set subjectclass_id=:subjectclass_id where examtime_id=:examtime_id";
        $stm2 = $this->conn->prepare($query2);
        $stm2->bindParam('examtime_id', $this->examtime_id);
        $stm2->bindParam('subjectclass_id', $this->subjectclass_id);

        $query3 = "update $this->tb_examtime_examroom set examtime_id=:examtime_id, amount_computer=:amount_computer where examtime_id=:examtime_id";
        $stm3 = $this->conn->prepare($query3);
        $stm3->bindParam('examtime_id', $this->examtime_id);
        $stm3->bindParam('examroom_name', $this->examroom_name);
        $stm3->bindParam('amount_computer', $this->amount_computer);
        $stm1->execute() && $stm2->execute() && $stm3->execute();
        try {
            $stm1->execute() && $stm2->execute() && $stm3->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * xóa 1 ca thi
     */
    public function deleteOneExamtime()
    {
        $query = "delete from $this->tb_examtimes where id=:examtime_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('examtime_id', $this->examtime_id);
        $stm->execute();
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

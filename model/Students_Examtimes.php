<?php
class Students_Examtimes
{
    private $tb_examtimes = 'examtimes'; // bảng ca thi
    private $tb_examrooms = 'examrooms'; // bảng phòng thi
    private $tb_examtimes_subjectclasses = 'examtimes_subjectclasses'; // bảng ca thi - lớp học phần
    private $tb_examtime_examroom = 'examtime_examroom'; // bảng phòng thi
    private $tb_subjects = 'subjects'; // bảng môn học
    private $tb_subjectclasses = 'subjectclasses'; // bảng môn học phần
    private $tb_semesters = 'semesters'; // bảng kì thi
    private $tb_students = 'students';
    private $tb_subjectclasses_students = 'subjectclasses_students';
    private $tb_students_examtimes = 'students_examtimes';

    public $examtime_id; // ID ca thi
    public $subjectclass_id; // id lớp môn học phần
    public $date; // ngày thi
    public $start_time; // thời gian bắt đâu ca thi
    public $end_time; // thời gian kết thúc ca thi
    public $examroom_name; // tên phòng thi
    public $amount_computer; // số lượng máy tính
    public $examroom_id; // ID phòng thi
    public $semester_id; // ID kì thi
    public $student_id;
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * lấy tất cả thông tin của ca thi theo ID kì thi
     */
    public function getAllExamtimesBySemesterId()
    {
        $query = "select t1.id as id, t4.name as subject_name, t5.code as subjectclass_code, t1.date as date, 
                         t1.start_time as start_time, t1.end_time as end_time, t7.name as examroom_name, t3.amount_computer as amount_computer
                           from $this->tb_examtimes as t1   
                           join $this->tb_examtimes_subjectclasses as t2 on t1.id = t2.examtime_id
                           join $this->tb_examtime_examroom as t3 on t1.id = t3.examtime_id
                           join $this->tb_examrooms as t7 on t7.id = t3.examroom_id
                           join $this->tb_subjectclasses as t5 on t2.subjectclass_id = t5.id
                           join $this->tb_subjects as t4 on t4.id = t5.subject_id
                           join $this->tb_semesters as t6 on t6.id = t4.semester_id
                           join $this->tb_subjectclasses_students as t8 on t5.id = t8.subjectclass_id
                           join $this->tb_students as t9 on t9.id = t8.student_id
                           where t4.semester_id=:semester_id and t9.id =:student_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('semester_id', $this->semester_id);
        $stm->bindParam('student_id', $this->student_id);
        $stm->execute();
        return $stm;
    }

    /**
     * chức năng sinh viên chọn ca thi
     */
    public function pickExamtimes()
    {
        $query = "insert into $this->tb_students_examtimes set student_id=:student_id, examtime_id=:examtime_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('student_id', $this->student_id);
        $stm->bindParam('examtime_id', $this->examtime_id);
        $stm->execute();

        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    /**
     * chức năng sinh viên chọn ca thi
     */
    public function getAllRegestered()
    {
        $query = "select distinct t2.id as id, t7.name as subject_name, t6.code as subjectclass_code, t2.date as date, 
        t2.start_time as start_time, t2.end_time as end_time, t5.name as examroom_name, t4.amount_computer as amount_computer
        from $this->tb_students_examtimes as t1
        join $this->tb_examtimes as t2 on t1.examtime_id = t2.id
        join $this->tb_examtimes_subjectclasses as t3 on t2.id = t3.examtime_id
        join $this->tb_examtime_examroom as t4 on t2.id = t4.examtime_id
        join $this->tb_examrooms as t5 on t5.id = t4.examroom_id
        join $this->tb_subjectclasses as t6 on t3.subjectclass_id = t6.id
        join $this->tb_subjects as t7 on t7.id = t6.subject_id
        join $this->tb_semesters as t8 on t8.id = t7.semester_id
        where t7.semester_id=:semester_id and t1.student_id =:student_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('semester_id', $this->semester_id);
        $stm->bindParam('student_id', $this->student_id);
        $stm->execute();
        return $stm;
    }

    /**
     * chức năng sinh viên chọn ca thi
     */
    public function deleteOneExamtime()
    {
        $query = "delete from $this->tb_students_examtimes where examtime_id=:examtime_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('examtime_id', $this->examtime_id);
        $stm->execute();
        return $stm;
    }

      /**
     * chức năng sinh viên chọn ca thi
     */
    public function getAmountRegistered($id)
    {
        $query = "select count(*) as count FROM $this->tb_students_examtimes where examtime_id=:examtime_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('examtime_id', $id);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        extract($row);
        return $count;
    }

    /**
     * kiểm tra trùng lặp
     */
    public function isDuplicate(){
        $query = "select * FROM $this->tb_students_examtimes where examtime_id=:examtime_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('examtime_id', $this->examtime_id);
        $stm->execute();
        $num = $stm->rowCount();
        if($num > 0){
            return true;
        }
       return false;
    }
}

<?php
class Students_Examtimes
{
    private $tb_examtimes = 'examtimes'; // bảng ca thi
    private $tb_examtimes_subjectclasses = 'examtimes_subjectclasses'; // bảng kì thi - lớp môn thi học phần
    private $tb_examrooms = 'examrooms'; // bảng phòng thi
    private $tb_subjects = 'subjects'; // bảng môn thi
    private $tb_subjectclasses = 'subjectclasses'; // bảng lớp môn thi học phần
    private $tb_subjectclasses_students = 'subjectclasses_students'; // bảng lớp môn thi học phần - sinh viên
    private $tb_students_examtimes = 'students_examtimes'; // bảng sinh viên - ca thi

    public $student_id; // ID sinh viên
    public $examtime_id; // ID kì thi
    
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * lấy tất cả ca thi dựa trên id của sinh viên
     */
    public function getAllExamtimesByStudentId()
    {
        $query = "select t1.id, t4.name as subject_name, t5.code as subjectclass_code, t1.date as date, 
                         t1.start_time as start_time, t1.end_time as end_time, t3.name as examroom_name, t3.amount_computer as amount_computer
                           from $this->tb_examtimes as t1   
                           join $this->tb_examtimes_subjectclasses as t2 on t1.id = t2.examtime_id
                           join $this->tb_examrooms as t3 on t1.id = t3.examtime_id
                           join $this->tb_subjectclasses as t5 on t2.subjectclass_id = t5.id
                           join $this->tb_subjects as t4 on t4.id = t5.subject_id
                           join $this->tb_subjectclasses_students as t6 on t5.id = t6.subjectclass_id
                           where t6.student_id=:student_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('student_id', $this->student_id);
        $stm->execute();
        return $stm;
    }

    /**
     * chức năng sinh viên chọn ca thi
     */
    public function pickExamtimes(){
        $query = "insert into $this->tb_students_examtimes set student_id=:student_id, examtime_id=:examtime_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('student_id', $this->student_id);
        $stm->bindParam('examtime_id', $this->examtime_id);
        try{
            $stm->execute();
            return true;
        } catch(Exception $e){
            return false;
        }
    }
}

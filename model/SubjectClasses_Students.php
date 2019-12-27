<?php
require '../../vendor/autoload.php';
class SubjectClasses_Students
{
    private $tb_subjectclasses_students = 'subjectclasses_students'; // bảng lớp môn học phần - sinh viên
    private $tb_students = 'students'; // bảng sinh viên
    private $tb_classes = 'classes'; // bảng sinh viên
    public $id; // ID lớp môn học phần - sinh viên
    public $student_id; // ID sinh viên
    public $subjectclass_id; // ID lớp môn học phần

    public $code; // mã sinh viên
    public $page;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * kiểm tra sinh viên có tồn tại trong DB (quản lý sinh viên)
     */
    public function checkStudentExistInDB()
    {
        $query = "select * from $this->tb_students where code=:code";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->execute();
        $num = $stm->rowCount();
        if ($num > 0) {
            return true;
        }
        return false;
    }

    /**
     * kiểm tra sinh viên có tồn tại trong lớp môn học phần
     */
    public function checkStudentExistInSubjectClass()
    {
        $query = "select * from $this->tb_subjectclasses_students where student_id=:student_id and subjectclass_id=:subjectclass_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('student_id', $this->student_id);
        $stm->bindParam('subjectclass_id', $this->subjectclass_id);
        $stm->execute();
        $num = $stm->rowCount();
        if ($num > 0) {
            return true;
        }
        return false;
    }

    /**
     * lấy ID sinh viên dựa trên má sinh viên
     */
    public function getStudentIdByStudentCode()
    {
        $query = "select id from $this->tb_students where code=:code";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->execute();
        $num = $stm->rowCount();
        if ($num > 0) {
            $row = $stm->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                extract($row);
                return $id;
            }
        }
    }

    /**
     * thêm sinh viên bằng file excel
     */
    public function importDataFromExcel()
    {
        // (3) INIT PHP SPREADSHEET
        if (pathinfo($_FILES['upexcel']['name'], PATHINFO_EXTENSION) == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if (pathinfo($_FILES['upexcel']['name'], PATHINFO_EXTENSION) == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else if (pathinfo($_FILES['upexcel']['name'], PATHINFO_EXTENSION) == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }
        $spreadsheet = $reader->load($_FILES['upexcel']['tmp_name']);
        $worksheet = $spreadsheet->getActiveSheet();
        $sql = "INSERT INTO $this->tb_subjectclasses_students set student_id=:student_id, subjectclass_id=:subjectclass_id";
        $dataFromExels = [];
        $dataFromExels['datas'] = [];
        $flag = false;
        $isAllow = false;
        try {
            foreach ($worksheet->getRowIterator() as $row) {
                // Fetch data
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $nameCol = ['STT', 'code', 'name', 'dob', 'class_name', 'other'];
                $index = 0;
                foreach ($cellIterator as $cell) {
                    if ($cell->getValue() == 'STT') {
                        $flag = true;
                        break;
                    }
                    if ($flag) {
                        if (!isset($nameCol[$index])) {
                            throw new Exception(json_encode(['error' => 'missed column']));
                        }
                        $isAllow = true;
                        $dataFromExel[$nameCol[$index]] = $cell->getValue();
                    }
                    $index++;
                }
                // Insert database
                if ($flag && $isAllow) {
                    if (!is_numeric($dataFromExel['STT'])) {
                        break;
                    }
                    $this->code = $dataFromExel['code'];
                    if ($this->checkStudentExistInDB()) { // kiểm tra sinh viên có tồn tại trong DB (quản lý sinh viên)
                        $this->student_id = $this->getStudentIdByStudentCode(); // lấy ID sinh viên theo mã sinh viên
                        if (!$this->checkStudentExistInSubjectClass()) { // kiểm tra sinh viên có tồn tại trong lớp môn học phần
                            try {
                                if (is_numeric($this->subjectclass_id)) {
                                    array_push($dataFromExels['datas'], $dataFromExel);
                                    $stmt = $this->conn->prepare($sql);
                                    $stmt->bindParam('student_id', $this->student_id);
                                    $stmt->bindParam('subjectclass_id', $this->subjectclass_id);
                                    $stmt->execute();
                                }
                            } catch (Exception $ex) {
                                echo json_encode(['error' => 'query error']);
                            }
                        }
                    }
                    $stmt = null;
                }
            }
            echo json_encode($dataFromExels, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    // lấy tất cả thông tin của sinh viên theo ID lớp môn học phần
    public function getInfoAllStudents()
    {
        $query = "select t1.id, t2.code, t2.name, t2.dob, t2.mail, t3.code as class_name from $this->tb_subjectclasses_students as t1 
                                join $this->tb_students as t2 on t2.id=t1.student_id 
                                join $this->tb_classes as t3 on t2.class_id = t3.id
                                where t1.subjectclass_id=:subjectclass_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('subjectclass_id', $this->subjectclass_id);
        $stm->execute();
        return $stm;
    }

    // thêm 1 sinh viên vào lớp môn học phần
    public function addOneStudent()
    {
        $this->student_id = $this->getStudentIdByStudentCode();
        if ($this->checkStudentExistInDB() && !$this->checkStudentExistInSubjectClass()) {
            $query = "insert into $this->tb_subjectclasses_students set student_id=:student_id, subjectclass_id=:subjectclass_id";
            $stm = $this->conn->prepare($query);
            $stm->bindParam('student_id', $this->student_id);
            $stm->bindParam('subjectclass_id', $this->subjectclass_id);
            if ($stm->execute()) {
                return 'done';
            }
            return 'fail';
        } else if (!$this->checkStudentExistInDB()) {
            return 'none-existed';
        } else if ($this->checkStudentExistInSubjectClass()) {
            return 'existed';
        }
    }

    // xóa 1 sinh viên vào lớp môn học phần
    public function deleteOneStudent()
    {
        $query = "delete from $this->tb_subjectclasses_students where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        if ($stm->execute()) {
            return true;
        }
        return false;
    }
}

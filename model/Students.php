<?php
require '../../vendor/autoload.php';
class Students
{
    private $tb_students = 'students'; // bảng sinh viên
    public $id; // ID sinh viên
    public $code; // mã sinh viên
    public $name; // tên sinh viên
    public $mail; // mail sinh viên
    public $dob; // ngày sinh
    public $class_id; // ID lớp học
    public $class_name; // tên lớp học

    private $tb_account = 'account'; // bảng tài khoản
    public $student_id; // ID người dùng
    public $password; // mật khẩu
    public $role = 2; // vai trò (1: admin, 2: student)

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * lấy thông tin 1 sinh viên theo mã sinh viên
     */
    public function getOneStudentByCode()
    {
        $query = "select * from $this->tb_students where code=:code";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->execute();
        return $stm;
    }
    /**
     * lấy thông tin 1 sinh viên theo tên lớp
     */
    public function getClassIDbyClassName()
    {
        $query = "select id from classes where code=:class_name";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('class_name', $this->class_name);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            extract($row);
            return $id;
        }
    }
    /**
     * lấy thông tin sinh viên theo ID lớp học
     */
    public function getClassNameByClassID()
    {
        $query = "select code from classes where id=:class_id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('class_id', $this->class_id);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            extract($row);
            return $code;
        }
    }

    /**
     * kiểm tra sinh viên có tồn tại dựa trên mã sinh viên
     */
    public function checkStudentExist()
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
     * lấy ID cuối của SV
     */
    public function getLastStudentId()
    {
        $query = "select max(id) as id from $this->tb_students";
        $stm = $this->conn->prepare($query);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            extract($row);
            return $id;
        }
    }

    /**
     * thêm sinh viên từ file excel
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
        $sql = "INSERT INTO $this->tb_students set code=:code, name=:name, dob=:dob, mail=:mail, class_id=:class_id";
        $sql1 = "INSERT INTO $this->tb_account set user_id=:user_id, username=:username, password=:password, role=:role";
        $dataFromExels = [];
        $dataFromExels['datas'] = [];
        $dataFromExels['studentExisted'] = [];
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
                    $student = $this->getOneStudentByCode();
                    $num = $student->rowCount();
                    // check if student exist
                    if ($num == 0) { // student not exist in db
                        
                            // modify date of birth
                            $time = explode('/', $dataFromExel['dob']);
                            $newTime = $time[1] . '/' . $time[0] . '/' . $time[2];
                            $time = strtotime($newTime);
                            $date = date("Y-m-d", $time);
                            // modify mail
                            $newMail = $dataFromExel['code'] . '@vnu.edu.vn';
                            // modify class ID
                            $this->class_name = $dataFromExel['class_name'];
                            // $getClassID = $this->getClassIDbyClassName();
                            if (is_numeric($this->class_id)) {
                                // push data to array
                                array_push($dataFromExels['datas'], $dataFromExel);
                                // run sql query
                                $stmt = $this->conn->prepare($sql);
                                $stmt->bindParam('code', $dataFromExel['code']);
                                $stmt->bindParam('name', $dataFromExel['name']);
                                $stmt->bindParam('dob', $date);
                                $stmt->bindParam('mail', $newMail);
                                $stmt->bindParam('class_id', $this->class_id);
                                $stmt->execute();

                                $this->id = $this->getLastStudentId();
                                $stmt1 = $this->conn->prepare($sql1);
                                $stmt1->bindParam('user_id', $this->id);
                                $stmt1->bindParam('username', $dataFromExel['code']);
                                $password = password_hash($dataFromExel['code'], PASSWORD_DEFAULT);
                                $stmt1->bindParam('password', $password);
                                $stmt1->bindParam('role', $this->role);
                                $stmt1->execute();
                            }
                        
                    } else { // student exist in db
                        $row = $student->fetch(PDO::FETCH_ASSOC);
                        extract($row);
                        $item = [
                            'code' => $code,
                            'name' => $name
                        ];
                        array_push($dataFromExels['studentExisted'], $item);
                    }
                    //  $lastID = $this->conn->lastInsertId(); // If you need the last insert ID
                    //  echo $lastID;
                    $stmt = null;
                }
            }
            echo json_encode($dataFromExels, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    /**
     * lấy thông tin 1 sinh viên dựa trên ID sinh viên
     */
    public function getOneStudent()
    {
        $query = "select * from $this->tb_students where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->execute();
        return $stm;
    }

    /**
     * lấy thông tin tất cả sinh viên dựa trên ID lớp học
     */
    public function getAllStudentsByClassID()
    {
        $query = "select * from $this->tb_students where class_id=:class_id order by code";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('class_id', $this->class_id);
        $stm->execute();
        return $stm;
    }

    /**
     * xóa 1 sinh viên
     */
    public function deleteOneStudent()
    {
        $query = "delete from $this->tb_students where id=:id";
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
     * cập nhật 1 sinh viên
     */
    public function updateOneStudent()
    {
        $query = "update $this->tb_students set code=:code, name=:name, mail=:mail, dob=:dob where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('name', $this->name);
        $stm->bindParam('mail', $this->mail);
        $stm->bindParam('dob', $this->dob);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * thêm 1 sinh viên
     */
    public function addOneStudent()
    {
        $query = "insert into $this->tb_students set code=:code, name=:name, mail=:mail, class_id=:class_id, dob=:dob";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('name', $this->name);
        $stm->bindParam('mail', $this->mail);
        $stm->bindParam('class_id', $this->class_id);
        $stm->bindParam('dob', $this->dob);
        try {
            $stm->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

<?php
require '../../vendor/autoload.php';
class Students
{
    private $table = 'students';
    public $id;
    public $code;
    public $name;
    public $mail;
    public $dob;
    public $class_id;

    public $class_name;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getOneStudentByCode()
    {
        $query = "select * from $this->table where code=:code";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->execute();
        return $stm;
    }

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

    public function checkStudentExist () {
        $query = "select * from $this->table where code=:code";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->execute();
        $num = $stm->rowCount();
        if($num > 0) {
            return true;
        }
        return false;
    }

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
        $sql = "INSERT INTO $this->table set code=:code, name=:name, dob=:dob, mail=:mail, class_id=:class_id";
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
                        try {
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
                            }
                        } catch (Exception $ex) {
                            echo json_encode(['error' => 'query error']);
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

    public function getOneStudent()
    {
        $query = "select * from $this->table where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->execute();
        return $stm;
    }
    public function getAllStudentsByClassID()
    {
        $query = "select * from $this->table where class_id=:class_id order by code";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('class_id', $this->class_id);
        $stm->execute();
        return $stm;
    }

    public function deleteOneStudent()
    {
        $query = "delete from $this->table where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        if ($stm->execute()) {
            return true;
        }
        return false;
    }

    public function updateOneStudent()
    {
        $query = "update $this->table set code=:code, name=:name, mail=:mail, dob=:dob where id=:id";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('id', $this->id);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('name', $this->name);
        $stm->bindParam('mail', $this->mail);
        $stm->bindParam('dob', $this->dob);
        if ($stm->execute()) {
            return true;
        }
        return false;
    }

    public function addOneStudent()
    {
        $query = "insert into $this->table set code=:code, name=:name, mail=:mail, class_id=:class_id, dob=:dob";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->bindParam('name', $this->name);
        $stm->bindParam('mail', $this->mail);
        $stm->bindParam('class_id', $this->class_id);
        $stm->bindParam('dob', $this->dob);
        if ($stm->execute()) {
            return true;
        }
        return false;
    }

}

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
    public $class;
    public $class_course;

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getOneStudent()
    {
        $query = "select * from $this->table where code=:code";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('code', $this->code);
        $stm->execute();
        return $stm;
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
        $sql = "INSERT INTO $this->table set code=:code, name=:name, dob=:dob, mail=:mail, class_course=:class_course";
        $datas = [];
        $datas['datas'] = [];
        $datas['studentExisted'] = [];
        $flag = false;
        $isAllow = false;
        try {
            foreach ($worksheet->getRowIterator() as $row) {
                // Fetch data
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $data = [];
                $nameCol = ['STT', 'code', 'name', 'dob', 'class_course', 'other'];
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
                        $data[$nameCol[$index]] = $cell->getValue();
                    }
                    $index++;
                }
                // Insert database
                if ($flag && $isAllow) {
                    if (!is_numeric($data['STT'])) {
                        break;
                    }
                    $this->code = $data['code'];
                    $student = $this->getOneStudent();
                    $num = $student->rowCount();
                    // check if student exist
                    if ($num == 0) { // student not exist in db
                        try {
                            // push data to array
                            array_push($datas['datas'], $data);
                            // modify date of birth
                            $time = explode('/', $data['dob']);
                            $newTime = $time[1] . '/' . $time[0] . '/' . $time[2];
                            $time = strtotime($newTime);
                            $date = date("Y-m-d", $time);
                            // modify mail
                            $newMail = $data['code'] . '@vnu.edu.vn';
                            // run sql query
                            $stmt = $this->conn->prepare($sql);
                            $stmt->bindParam('code', $data['code']);
                            $stmt->bindParam('name', $data['name']);
                            $stmt->bindParam('dob', $date);
                            $stmt->bindParam('mail', $newMail);
                            $stmt->bindParam('class_course', $data['class_course']);
                            $stmt->execute();
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
                        array_push($datas['studentExisted'], $item);
                    }
                    //  $lastID = $this->conn->lastInsertId(); // If you need the last insert ID
                    //  echo $lastID;
                    $stmt = null;
                }
            }
            echo json_encode($datas, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    public function getStudentsByClassCourse(){
        $query = "select * from $this->table where class_course=:class_course";
        $stm = $this->conn->prepare($query);
        $stm->bindParam('class_course', $this->class_course);
        $stm->execute();
        return $stm;
    }
}

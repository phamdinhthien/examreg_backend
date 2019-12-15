<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Students.php';

$database = new Database();
$db = $database->getConnection();
$students = new Students($db);
$students->class_id = isset($_GET['class_id']) ? $_GET['class_id'] : 0; // ID lớp học
$results = $students->getAllStudentsByClassID();
$num = $results->rowCount();
$student_arr = [];
$student_arr['data'] = [];
if ($num) {
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        $class_name =  $students->getClassNameByClassID(); // lấy tên lớp học dựa trên ID lớp học
        extract($row);
        $item = [
            'id' => $id,
            'code' => $code,
            'name' => $name,
            'class_name' => $class_name,
            'dob' => $dob,
            'mail' => $mail
        ];
        array_push($student_arr['data'], $item);
    }
}
echo json_encode($student_arr, JSON_UNESCAPED_UNICODE);

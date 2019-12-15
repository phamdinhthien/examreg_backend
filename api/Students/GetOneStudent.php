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
$students->id = $_GET['id']; // ID SV
$results = $students->getOneStudent();
$num = $results->rowCount();
$student_arr = [];
$student_arr['data'] = [];
if ($num) {
    $row = $results->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $students->class_id = $class_id;
    $class_name =  $students->getClassNameByClassID();
    $item = [
        'id' => $id, //ID SV
        'code' => $code, // mã SV
        'name' => $name, // tên SV
        'class_name' => $class_name, // tên lớp học
        'dob' => $dob, // ngày sinh
        'mail' => $mail // mail SV
    ];
    array_push($student_arr['data'], $item);
} else {
    array_push($student_arr['data'], ["message" => "no data"]);
}
echo json_encode($student_arr, JSON_UNESCAPED_UNICODE);

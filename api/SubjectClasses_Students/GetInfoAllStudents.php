<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/SubjectClasses_Students.php';
include '../../model/Students.php';

$database = new Database();
$db = $database->getConnection();
$subjectClasses_students = new SubjectClasses_Students($db);
$students = new Students($db);
$students->subjectclass_id = $_GET["subjectclass_id"]; // ID lớp môn học phần
$results = $subjectClasses_students->getInfoAllStudents();
$num = $results->rowCount();
$subjectClasses_students_arr = [];
$subjectClasses_students_arr['data'] = [];
if ($num) {
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = [
            'id' => $id, // ID SV
            'code' => $code, // mã SV
            'name' => $name, // tên SV
            'class_name' => $class_name, // tên lớp học
            'dob' => $dob, // ngày sinh
            'mail' => $mail // mail SV
        ];
        array_push($subjectClasses_students_arr['data'], $item);
    }
}
echo json_encode($subjectClasses_students_arr, JSON_UNESCAPED_UNICODE);

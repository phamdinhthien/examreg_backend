<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/SubjectClasses.php';

$database = new Database();
$db = $database->getConnection();
$subjectClasses = new SubjectClasses($db);
$subjectClasses->subject_id = $_GET['subject_id']; // mã môn học
$results = $subjectClasses->getAllSubjectClasses();
$num = $results->rowCount();
$subjectClasses_arr = [];
$subjectClasses_arr['data'] = [];
if ($num) {
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = [
            'id' => $id,
            'code' => $code, // mã lớp môn học phần
            'name' => $name, // tên môn học,
            'code_subject' => $codeSubject
        ];
        array_push($subjectClasses_arr['data'], $item);
    }
} 
echo json_encode($subjectClasses_arr, JSON_UNESCAPED_UNICODE);

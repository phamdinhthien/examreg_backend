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
$data = json_decode(file_get_contents('php://input'));
$subjectClasses->id = $data->id; // ID lớp môn học phần
$subjectClasses->code = $data->code; // mã lớp môn học phần
$subjectClasses->subject_id = $data->subject_id; // ID môn học
if ($subjectClasses->updateOneSubjectClass()) {
    http_response_code(200);
    echo json_encode(
        ["message" => "one subject updated"]
    );
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "no subject updated"]
    );
}

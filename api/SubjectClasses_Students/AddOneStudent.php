<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/SubjectClasses_Students.php';

$database = new Database();
$db = $database->getConnection();
$subjectClasses_students = new SubjectClasses_Students($db);
$data = json_decode(file_get_contents('php://input'));
$subjectClasses_students->code = $data->code; // mã SV
$subjectClasses_students->subjectclass_id = $data->subjectclass_id; // ID lớp môn học phần
$result = $subjectClasses_students->addOneStudent();

switch ($result) {
    case 'done':
        http_response_code(200);
        echo json_encode(
            ["message" => "one student added"]
        );
        break;
    case 'fail':
        http_response_code(400);
        echo json_encode(
            ["message" => "no student added"]
        );
        break;
    case 'none-existed':
        http_response_code(400);
        echo json_encode(
            ["message" => "student not existed"]
        );
        break;
    case 'existed':
        http_response_code(400);
        echo json_encode(
            ["message" => "student existed"]
        );
        break;
}

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
$data = json_decode(file_get_contents('php://input'));
$students->name = $data->name;
$students->code = $data->code;
$students->mail = $data->mail;
$students->dob = $data->dob;
$students->class_id = $data->class_id;
if(!$students->checkStudentExist()) {
    if ($students->addOneStudent()) {
        http_response_code(200);
        echo json_encode(
            ["message" => "one student added"]
        );
    } else {
        http_response_code(400);
        echo json_encode(
            ["message" => "no student added"]
        );
    }
} else {
    http_response_code(200);
    echo json_encode(
        ["message" => "studentExisted"]
    );
}

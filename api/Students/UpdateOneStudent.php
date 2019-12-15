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
$students->id = $data->id; // ID SV
$students->name = $data->name; // tên SV
$students->code = $data->code; // mã SV
$students->mail = $data->mail; // mail SV
$students->dob = $data->dob; // ngày sinh
if ($students->updateOneStudent()) {
    http_response_code(200);
    echo json_encode(
        ["message" => "one student updated"]
    );
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "no student updated"]
    );
}

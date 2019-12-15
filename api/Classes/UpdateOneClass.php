<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Classes.php';

$database = new Database();
$db = $database->getConnection();
$classes = new Classes($db);
$data = json_decode(file_get_contents('php://input'));
$classes->id = $data->id; // ID lớp học
$classes->code = $data->code; // 
$classes->course_id = $data->course_id;
if ($classes->updateOneClass()) {
    http_response_code(201);
    echo json_encode(
        ["message" => "one class updated"]
    );
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "no class updated"]
    );
}

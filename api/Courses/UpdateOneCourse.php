<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Courses.php';

$database = new Database();
$db = $database->getConnection();
$courses = new Courses($db);
$data = json_decode(file_get_contents('php://input'));
$courses->id = $data->id;
$courses->code = $data->code;
$courses->year_start = $data->year_start;
$courses->year_end = $data->year_end;
if ($courses->updateOneCourse()) {
    http_response_code(200);
    echo json_encode(
        ["message" => "one course updated"]
    );
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "no course updated"]
    );
}

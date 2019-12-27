<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Subjects.php';

$database = new Database();
$db = $database->getConnection();
$subjects = new Subjects($db);
$data = json_decode(file_get_contents('php://input'));
$subjects->id = $data->id; // ID môn học
$subjects->code = $data->code; // mã môn học
$subjects->name = $data->name; // tên môn học
$subjects->semester_id = $data->semester_id; // ID kì thi
if (!$subjects->isDuclicate()) {
    if ($subjects->updateOneSubject()) {
        http_response_code(201);
        echo json_encode(
            ["message" => "Cập nhật môn thi thành công", "status" => 200]
        );
    } else {
        http_response_code(400);
        echo json_encode(
            ["message" => "Cập nhật môn thi không thành công", "status" => 201]
        );
    }
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "Tên môn thi hoặc mã môn đã tồn tại", "status" => 400]
    );
}

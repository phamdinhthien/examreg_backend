<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Examtimes.php';

$database = new Database();
$db = $database->getConnection();
$examtimes = new Examtimes($db);
$data = json_decode(file_get_contents('php://input'));
$examtimes->examtime_id = $data->examtime_id; // ID ca thi
$examtimes->subjectclass_id = $data->subjectclass_id; // ID lớp môn học phần
$examtimes->date = $data->date; // ngày thi
$examtimes->start_time = $data->start_time; // thời gian bắt đầu
$examtimes->end_time = $data->end_time; // thời gian bắt đầu
$examtimes->examroom_id = $data->examroom_id; // tên phòng thi
$examtimes->amount_computer = $data->amount_computer; // số máy tính
if ($examtimes->validateTimeFromInputToUpdate()) {
    if ($examtimes->updateOneExamtime()) {
        http_response_code(201);
        echo json_encode(
            ["message" => "Thêm ca thi thành công", "status" => 201]
        );
    } else {
        http_response_code(400);
        echo json_encode(
            ["message" => "Thêm ca thi không thành công", "status" => 400]
        );
    }
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "thời gian ca thi bị trùng", "status" => 400]
    );
}

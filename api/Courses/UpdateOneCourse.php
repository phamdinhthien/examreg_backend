<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Courses.php';
include '../../validate/Courses/ValidateValue.php';

$database = new Database();
$db = $database->getConnection();
$courses = new Courses($db);
$data = json_decode(file_get_contents('php://input'));
$courses->id = $data->id; // mã khóa học
$courses->code = $data->code; // mã khóa học
$courses->year_start = $data->year_start; // năm bắt đầu
$courses->year_end = $data->year_end; // năm kết thúc
$isDuplicated = $courses->isDuplicatedToUpdate();
if (validateValue($data->code, $data->year_start, $data->year_end) && !$isDuplicated) {
    if ($courses->updateOneCourse()) {
        http_response_code(200);
        echo json_encode(
            ["message" => "Cập nhật khóa học thành công","status" => 200]
        );
    } else {
        http_response_code(400);
        echo json_encode(
            ["message" => "Cập nhật khóa học không thành công","status" => 400]
        );
    }
} else if ($isDuplicated) {
    http_response_code(400);
    echo json_encode(
        ["message" => "Tên khóa đã tồn tại hoặc năm bị trùng", "status" => 400]
    );
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "Cập nhật khóa học không thành công", "status" => 400]
    );
}

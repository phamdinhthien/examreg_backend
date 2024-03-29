<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Students.php';
include '../../validate/Students/ValidateValue.php';

$database = new Database();
$db = $database->getConnection();
$students = new Students($db);
$data = json_decode(file_get_contents('php://input'));
$students->name = $data->name; // tên SV
$students->code = $data->code; // mã SV
$students->mail = $data->mail; // mail SV
$students->dob = $data->dob; // ngày sinh
$students->class_id = $data->class_id; // ID lớp học
$isDuplicate = $students->isDuplicate();
if (!$isDuplicate && validateValueStudent($data->name, $data->code, $data->dob)) { // kiểm tra sinh viên có tồn tại trong DB
    if ($students->addOneStudent()) {
        http_response_code(201);
        echo json_encode(
            ["message" => "Thêm sinh viên thành công", "status" => 201]
        );
    } else {
        http_response_code(400);
        echo json_encode(
            ["message" => "Thêm sinh viên không thành công", "status" => 400]
        );
    }
} else if($isDuplicate){
    http_response_code(400);
    echo json_encode(
        ["message" => "Sinh viên đã tồn tại", "status" => 400]
    );
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "Nhập sai định dạng", "status" => 400]
    );
}

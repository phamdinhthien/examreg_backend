<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Students_Examtimes.php';

$database = new Database();
$db = $database->getConnection();
$students_examtimes = new Students_Examtimes($db);
$data = json_decode(file_get_contents('php://input'));
$students_examtimes->student_id = $data->student_id; // ID sinh viên
$students_examtimes->examtime_id = $data->examtime_id; // mảng các ca thi sinh viên đăng kí
if($students_examtimes->pickExamtimes()){
    http_response_code(200);
    echo json_encode(
        ["message" => "Đăng kí ca thi thành công", "status"=> 200]
    );
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "Đăng kí ca thi không thành công", "status"=> 400]
    );
}

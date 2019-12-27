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
$students_examtimes->examtime_id = $_GET['id']; // mảng các ca thi sinh viên đăng kí
if($students_examtimes->deleteOneExamtime()){
    http_response_code(200);
    echo json_encode(
        ["message" => "Xóa ca thi thành công", "status"=> 200]
    );
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "Xóa ca thi không thành công", "status"=> 400]
    );
}

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
$examtime_arr = $data->examtime_id; // mảng các ca thi sinh viên đăng kí
$count = 0; // số ca thi sinh viên đăng kí thành công
foreach ($examtime_arr as $examtime) {
    $students_examtimes->examtime_id = $examtime;
    if ($students_examtimes->pickExamtimes()) {
        $count++;
    }
}
if ($count > 0) {
    http_response_code(200);
    echo json_encode(
        ["message" => "$count examtime added"]
    );
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "no examtime added"]
    );
}

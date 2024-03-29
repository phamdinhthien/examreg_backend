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
$courses->id = $_GET['id']; // ID khóa học
$results = $courses->getOneCourse();
$num = $results->rowCount();
$courses_arr = [];
$courses_arr['data'] = [];
if ($num) {
    $row = $results->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $item = [
        'code' => $code, // mã khóa học
        'year_start' => $year_start, // năm bắt đầu
        'year_end' => $year_end, // năm kết thúc
        'course_id' => $id // ID khóa học
    ];
    array_push($courses_arr['data'], $item);
} else {
    array_push($courses_arr['data'], ["message" => "no data"]);
}
echo json_encode($courses_arr, JSON_UNESCAPED_UNICODE);

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
$students_examtimes->student_id = $_GET['student_id']; // ID sinh viên
$results = $students_examtimes->getAllExamtimesByStudentId();
$num = $results->rowCount();
$students_examtimes_arr = [];
$students_examtimes_arr['data'] = [];
if ($num) {
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = [
            'subject_name' => $subject_name, // tên môn học
            'subjectclass_code' => $subjectclass_code, // mã lớp môn học phần
            'date' => $date, // ngày thi
            'start_time' => $start_time, // ngày bắt đầu
            'end_time' => $end_time, // ngày kết thúc
            'examroom_name' => $examroom_name, // tên phòng thi
            'amount_computer' => $amount_computer // số máy tính
        ];
        array_push($students_examtimes_arr['data'], $item);
    }
} else {
    array_push($students_examtimes_arr['data'], ["message" => "no data"]);
}
echo json_encode($students_examtimes_arr, JSON_UNESCAPED_UNICODE);

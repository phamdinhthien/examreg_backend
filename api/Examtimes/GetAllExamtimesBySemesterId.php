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
$examtimes->semester_id = $_GET['semester_id']; // ID kì thi
$results = $examtimes->getAllExamtimesBySemesterId();
$num = $results->rowCount();
$examtimes_arr = [];
$examtimes_arr['data'] = [];
if ($num) {
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = [
            'subjectName' => $subject_name, // tên môn học
            'subjectclassCode' => $subjectclass_code, // mã lớp môn học phần
            'date' => $date, // ngày thi
            'startTime' => $start_time, // ngày bắt đầu
            'endTime' => $end_time, // ngày kết thúc
            'examroomName' => $examroom_name, // tên phòng thi
            'amountComputer' => $amount_computer // số máy tính
        ];
        array_push($examtimes_arr['data'], $item);
    }
} else {
    array_push($examtimes_arr['data'], ["message" => "no data"]);
}
echo json_encode($examtimes_arr, JSON_UNESCAPED_UNICODE);

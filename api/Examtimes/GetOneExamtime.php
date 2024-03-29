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
$examtimes->examtime_id = $_GET['id']; // ID kì thi
$results = $examtimes->getOneExamtime();
$num = $results->rowCount();
$examtimes_arr = [];
$examtimes_arr['data'] = [];
if ($num) {
    $row = $results->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $item = [
            'id' => $id,
            'subjectName' => $subject_name, // tên môn học
            'subjectclassCode' => $subjectclass_code, // mã lớp môn học phần,
            'subjectclassID' => $subjectclass_id, // mã lớp môn học phần
            'date' => $date, // ngày thi
            'startTime' => $start_time, // ngày bắt đầu
            'endTime' => $end_time,
            'examroomName' => $examroom_name, // tên phòng thi
            'amountComputer' => $amount_computer // số máy tính
        ];
        array_push($examtimes_arr['data'], $item);
}
echo json_encode($examtimes_arr, JSON_UNESCAPED_UNICODE);

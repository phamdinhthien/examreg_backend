<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Students_Examtimes.php';

$database = new Database();
$db = $database->getConnection();
$examtimes_students = new Students_Examtimes($db);
$examtimes_students->semester_id = $_GET['semester_id']; // ID kì thi
$examtimes_students->student_id = $_GET['student_id']; // ID kì thi
$results = $examtimes_students->getAllExamtimesBySemesterId();
$num = $results->rowCount();
$examtimes_students_arr = [];
$examtimes_students_arr['data'] = [];
if ($num) {
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = [
            'id' => $id,
            'subjectName' => $subject_name, // tên môn học
            'subjectclassCode' => $subjectclass_code, // mã lớp môn học phần
            'date' => $date, // ngày thi
            'startTime' => $start_time, // ngày bắt đầu
            'endTime' => $end_time,
            'count' => $examtimes_students->getAmountRegistered($id),
            'examroomName' => $examroom_name, // tên phòng thi
            'amountComputer' => $amount_computer // số máy tính
        ];
        array_push($examtimes_students_arr['data'], $item);
    }
}
echo json_encode($examtimes_students_arr, JSON_UNESCAPED_UNICODE);

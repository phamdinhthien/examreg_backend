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
$examtimes->subjectclass_id = $_GET['subjectclass_id'];
$results = $examtimes->getSubjectClassesToUpdateExamtime();
$num = $results->rowCount();
$examtimes_arr = [];
$examtimes_arr['data'] = [];
if ($num) {
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = [
            'id' => $id,
            'code' => $code, // mã lớp môn học phần
        ];
        array_push($examtimes_arr['data'], $item);
    }
}
echo json_encode($examtimes_arr, JSON_UNESCAPED_UNICODE);

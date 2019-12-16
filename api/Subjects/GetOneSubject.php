<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Subjects.php';

$database = new Database();
$db = $database->getConnection();
$subject = new Subjects($db);
$subject->id = $_GET['id']; // ID môn học
$results = $subject->getOneSubject();
$num = $results->rowCount();
$subject_arr = [];
$subject_arr['data'] = [];
if ($num) {
    $row = $results->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $item = [
        'id' => $id, // ID môn học
        'name' => $name, // tên môn học
        'code' => $code // mã môn học
    ];
    array_push($subject_arr['data'], $item);
} else {
    // array_push($subject_arr['data'], []);
}
http_response_code(200);
echo json_encode($subject_arr, JSON_UNESCAPED_UNICODE);

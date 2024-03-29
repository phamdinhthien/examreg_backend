<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Classes.php';

$database = new Database();
$db = $database->getConnection();
$classes = new Classes($db);
$classes->id = $_GET['id']; // ID lớp học
$results = $classes->getOneClass();
$num = $results->rowCount();
$classes_arr = [];
$classes_arr['data'] = [];
if ($num) {
    $row = $results->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $item = [
        'id' => $id, // ID lớp học
        'code' => $code // mã lớp học
    ];
    array_push($classes_arr['data'], $item);
}
echo json_encode($classes_arr, JSON_UNESCAPED_UNICODE);

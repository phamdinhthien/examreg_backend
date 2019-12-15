<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Students.php';

$database = new Database();
$db = $database->getConnection();
$students = new Students($db);
$students->id = $_GET['id']; // ID sinh viên 
if ($students->deleteOneStudent()) {
    http_response_code(200);
    echo json_encode(
        ["message" => "one student deleted"]
    );
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "no student deleted"]
    );
}

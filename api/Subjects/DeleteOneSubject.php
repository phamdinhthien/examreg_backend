<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Subjects.php';

$database = new Database();
$db = $database->getConnection();
$subjects = new Subjects($db);
$subjects->id = $_GET["id"]; // ID môn học
if ($subjects->deleteOneSubject()) {
    http_response_code(200);
    echo json_encode(
        ["message" => "one subject deleted"]
    );
} else {
    http_response_code(400);
    echo json_encode(
        ["message" => "no subject deleted"]
    );
}

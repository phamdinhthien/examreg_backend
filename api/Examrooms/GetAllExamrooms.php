<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../../config/configDB.php';
include '../../model/Examrooms.php';

$database = new Database();
$db = $database->getConnection();
$examrooms = new Examrooms($db);
$results = $examrooms->getAllExamrooms();
$num = $results->rowCount();
$examrooms_arr = [];
$examrooms_arr['data'] = [];
if ($num) {
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = [
            'id' => $id,
            'name' => $name
        ];
        array_push($examrooms_arr['data'], $item);
    }
} else {
    array_push($examrooms_arr['data'], ["message" => "no data"]);
}
echo json_encode($examrooms_arr, JSON_UNESCAPED_UNICODE);

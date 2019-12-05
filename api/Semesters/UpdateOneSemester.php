<?php
     header("Access-Control-Allow-Origin: *");
     header("Content-Type: application/json; charset=UTF-8");
     header("Access-Control-Max-Age: 3600");
     header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     include '../../config/configDB.php';
     include '../../model/Semesters.php';

     $database = new Database();
     $db = $database->getConnection();
     $semesters = new Semesters($db);
     $data = json_decode(file_get_contents('php://input'));
     $semesters->id = $data->id;
     $semesters->name = $data->name;
     $semesters->year = $data->year;

     if($semesters->updateOneSemester()){
        http_response_code(201);
        echo json_encode(
            ["message"=> "one semester updated"]
        );
    } else{
        http_response_code(400);
        echo json_encode(
            ["message"=> "no semester updated"]
        );
    }

?>
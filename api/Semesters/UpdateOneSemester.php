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
     $semesters->id = $data->id; // ID kì thi
     $semesters->name = $data->name; // tên kì thi
     $semesters->year = $data->year; // năm của kì thi
    if(!$semesters->isDuclicateToUpdate()){
        if($semesters->updateOneSemester()){
            http_response_code(201);
            echo json_encode(
                ["message"=> "Cập nhật kì thi thành công", "status" => 201]
            );
        } else{
            http_response_code(400);
            echo json_encode(
                ["message"=> "Cập nhật kì thi không thành công", "status" => 400]
            );
        }
     } else {
        http_response_code(400);
        echo json_encode(
            ["message"=> "Tên kì thi hoặc năm đã tồn tại", "status" => 400]
        );
     }

?>
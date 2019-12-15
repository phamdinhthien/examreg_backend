<?php
     header("Access-Control-Allow-Origin: *");
     header("Content-Type: application/json; charset=UTF-8");
     header("Access-Control-Max-Age: 3600");
     header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     include '../../config/configDB.php';
     include '../../model/Courses.php';

     $database = new Database();
     $db = $database->getConnection();
     $courses = new Courses($db);
     $data = json_decode(file_get_contents('php://input'));
     $courses->code = $data->code; // mã khóa học
     $courses->year_start = $data->year_start; // năm bắt đầu
     $courses->year_end = $data->year_end; // năm kết thúc

     if($courses->createOneCourse()){
        http_response_code(201);
        echo json_encode(
            ["message"=> "one course created"]
        );
    } else{
        http_response_code(400);
        echo json_encode(
            ["message"=> "no student created"]
        );
    }

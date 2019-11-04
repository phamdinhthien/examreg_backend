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
    $students->class_course = isset($_GET['class_course'])?$_GET['class_course']:die();
    $result = $students->getStudentsByClassCourse();
    $num = $result->rowCount();
    $students_arr = [];
    $students_arr['data'] = [];
    if($num){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $item = [
            'code'=>$code,
            'name'=>$name
        ];
        array_push($students_arr['data'], $item);
    }
    }else{
        array_push($students_arr['data'], ["message"=>"no data"]);
    }
    http_response_code(200);
    echo json_encode($students_arr, JSON_UNESCAPED_UNICODE);

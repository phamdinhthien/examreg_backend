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
    $subjects->course_id = isset($_GET['course_id'])?$_GET['course_id']:die();
    $result = $subjects->getSubjectsByCourseId();
    $num = $result->rowCount();
    $subjects_arr = [];
    $subjects_arr['data'] = [];
    if($num){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $item = [
            'code'=>$code,
            'name'=>$name
        ];
        array_push($subjects_arr['data'], $item);
    }
    }else{
        array_push($subjects_arr['data'], ["message"=>"no data"]);
    }
    http_response_code(200);
    echo json_encode($subjects_arr, JSON_UNESCAPED_UNICODE);

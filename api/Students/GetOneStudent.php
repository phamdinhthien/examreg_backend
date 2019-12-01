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
    $students->id = $_GET['id'];
    $results = $students->getOneStudent();
    $num = $results->rowCount();
    $student_arr = [];
    $student_arr['data'] = [];
    if($num){
    $row = $results->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $students->class_id = $class_id;
        $class_name =  $students->getClassNameByClassID();
        $item = [
            'id'=>$id,
            'code'=>$code,
            'name'=>$name,
            'class_name'=> $class_name,
            'dob'=>$dob,
            'mail'=>$mail
        ];
        array_push($student_arr['data'], $item);
    }else{
        array_push($student_arr['data'], ["message"=>"no data"]);
    }
    echo json_encode($student_arr, JSON_UNESCAPED_UNICODE);

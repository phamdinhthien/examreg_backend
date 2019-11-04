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
     $courses->page = isset($_GET['page'])?$_GET['page']:die();
     $courses->name = isset($_GET['search'])?$_GET['search']:die();
     $result = $courses->searchCourses();
     $num = $result->rowCount();
     if($num > 0){
     $courses_arr = [];
     $courses_arr['data'] = [];
     while ($row = $result->fetch(PDO::FETCH_ASSOC)){
         extract($row);
         $item = [
            'id'=>$id,
            'code'=> $code
         ];
         array_push($courses_arr['data'], $item);
     }
     http_response_code(200);
     echo json_encode($courses_arr, JSON_UNESCAPED_UNICODE);
    }

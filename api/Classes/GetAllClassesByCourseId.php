<?php
     header("Access-Control-Allow-Origin: *");
     header("Content-Type: application/json; charset=UTF-8");
     header("Access-Control-Max-Age: 3600");
     header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     include '../../config/configDB.php';
     include '../../model/Classes.php';

     $database = new Database();
     $db = $database->getConnection();
     $classes = new Classes($db);
     $classes->course_id = $_GET['course_id'];
     $results = $classes->getAllClassesByCourseId();
     $num = $results->rowCount();
     $classes_arr = [];
     $classes_arr['data'] = [];
     if($num){
        while ($row = $results->fetch(PDO::FETCH_ASSOC)){     
         extract($row);
         $item = [
             'id'=>$id,
             'code'=>$code
         ];
         array_push($classes_arr['data'], $item);
        }
     }
     echo json_encode($classes_arr, JSON_UNESCAPED_UNICODE);

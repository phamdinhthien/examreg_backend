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
     $results = $semesters->getAllSemesters();
     $num = $results->rowCount();
     $semesters_arr = [];
     $semesters_arr['data'] = [];
     if($num){   
        while ($row = $results->fetch(PDO::FETCH_ASSOC)){
         extract($row);
         $item = [
             'id'=>$id, // ID kì thi
             'name'=>$name, // tên kì thi
             'year'=>$year, // năm của kì thi
         ];
         array_push($semesters_arr['data'], $item);
        }
     }else{
         array_push($semesters_arr['data'], ["message"=>"no data"]);
     }
     echo json_encode($semesters_arr, JSON_UNESCAPED_UNICODE);

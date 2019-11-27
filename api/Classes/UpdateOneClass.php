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
     $data = json_decode(file_get_contents('php://input'));
     $classes->id = $data->id;
     $classes->code = $data->code;
     $classes->course_id = $data->course_id;
     if($classes->updateOneClass()){
        http_response_code(201);
        // echo json_encode(
        //     ["message"=> "one class updated"]
        // );
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
    } else{
        http_response_code(400);
        echo json_encode(
            ["message"=> "no class created"]
        );
    }

?>
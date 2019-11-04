<?php
      header("Access-Control-Allow-Origin: *");
      header("Content-Type: application/json; charset=UTF-8");
      header("Access-Control-Allow-Methods: POST");
      header("Access-Control-Max-Age: 3600");
      header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
      include '../../config/configDB.php';
      include '../../model/Account.php';
      include '../../library/JWT.php';

      $database = new Database();
      $db = $database->getConnection();
      $account = new Account($db);

      $data = json_decode(file_get_contents('php://input'));
      $account->name = $data->name;
      $account->email = $data->email;
      $account->password = password_hash($data->password, PASSWORD_DEFAULT);
      if($account->register()){
        http_response_code(201);
        echo json_encode([
            'message'=>'register successfully'
        ]);
      } else {
        http_response_code(400);
        echo json_encode([
          'message'=>'register failed'
      ]);
      }
?>
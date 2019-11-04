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
      $account->email = $data->email;
      $account->password = $data->password;
      if($account->login()){
        http_response_code(200);
        $key="check_login";
        $token = [
            'id'=>$account->id,
            'name'=>$account->email,
            'exp'=>time()
        ];
        $jwt = JWT::encode($token, $key);
        echo json_encode([
            'token'=>$jwt
        ]);
      } else {
        echo json_encode([
          'message'=>'login failed'
      ]);
      }
?>
<?php
// api rest pour login 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../../config/database.php';
include_once '../../core/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->username)&& !empty($data->password)){
    $user->username =$data->username;
    $user->password =$data->password; 

    if($user->login()){
       
        http_response_code(200);
        echo json_encode(array(
             "message" => "Connexion reussie.",
            "user_id" => $user->id,
            "username" => $user->username
        ));
    }else {
        http_response_code(401);
        echo json_encode(
            array("message"=>"echec de la connexion.")
        );
    }


}else {
    http_response_code(400);
    echo json_encode(array(
        "message" => "Donnees incompletes"
    ));
}




?>

<?php
// api rest pour register (creation du compte user )

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access6cONTROL-Allow-Methods: POST");

include_once '../../config/database.php';
include_once '../../core/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Recuperation des donner POST 

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->username)&& !empty($data->password)){
    $user->username = $data->username ;
    $user->password = $data->password ;

    if ($user->register()){
        http_response_code(201);
        echo json_encode(array("message"=> "Utilisateur créé."));
    }else {
         http_response_code(500);
        echo json_encode(array("message"=> "exist"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message"=>"Données incomplètes. "));
}





?>
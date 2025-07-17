<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Methods: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../../config/database.php';
include_once '../../core/favorite.php';
$database = new Database();
$db = $database->getConnection();
$favorite = new Favorite($db);

$data = json_decode(file_get_contents("php://input"));

//verification que les donnees ne sont pas vide 

if(
    !empty($data->user_id )&&
    !empty($data->city_name = $data->city_name)

){
 
    $favorite->user_id = $data->user_id;
    $favorite->city_name = $data->city_name;

    //tenter d'ajouter le favori :
    if($favorite->add()){
        
      // Réponse 201 - Created
        http_response_code(201);
        echo json_encode(array("message" => "Le favori a été ajouté."));
      

    }else {
        http_response_code(503);
        echo json_encode(
            array(
                "message"=>"Impossible d'ajouter le favori"
            )
            );

    }
}else {
    http_response_code(400);
    echo json_encode(array(
        "message"=>"Impossible d'ajouter le favori. les données sont incomplètes "
    ));
}

?>

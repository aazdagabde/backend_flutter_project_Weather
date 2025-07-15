<?php
// remove.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../core/favorite.php';
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();
$favorite = new Favorite($db);

// Récupérer les données envoyées
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->user_id)&&
    !empty($data->city_name)
){
    $favorite->user_id = $data->user_id;
    $favorite->city_name = $data->city_name;

    if ($favorite->remove()){
        http_response_code(204);
       
    }else {
        http_response_code(503);
         echo json_encode(array(
            "message"=> "erreur a ete servenue "
        ));
    }
}else {
    http_response_code(400);
    echo json_encode(array(
        "message"=>"user_id manqant ou ville introuvale "
    ));
}


/////////////////function a l'interieur de la classe favorit pour prendre une aider 

//function remove() {
 //       $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id AND city_name = :city_name";
//        $stmt = $this->conn->prepare($query);
//
//        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
//        $this->city_name = htmlspecialchars(strip_tags($this->city_name));
//
//        $stmt->bindParam(":user_id", $this->user_id);
//        $stmt->bindParam(":city_name", $this->city_name);
//
 //       if ($stmt->execute()) {
 //           return true;
 //       }
  //      return false;
 //   }//
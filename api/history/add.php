<?php
// add.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods:  POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../core/history.php';

$database = new Database();
$db = $database ->getConnection();
$history=new History($db);

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->user_id)&&
    !empty($data->city_name)&&
    !empty($data->temperature)
) {
        $history->user_id = $data->user_id;
        $history->city_name = $data->city_name;
       $history->temperature = $data->temperature;


    if($history->add()){
        http_response_code(201);
        echo json_encode(
            array(
                "message"=>"Consultation ajoutée à l'historique"
            ) );
    }else {
        http_response_code(503);
    }

}else {
    http_response_code(400);
     echo json_encode(
            array(
                "message"=>" tous les champs sont obligatoir !!"
            ) );
    }






















// function add() {
//        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, city_name=:city_name, temperature=:temperature";
//        $stmt = $this->conn->prepare($query);
//
 //       $this->user_id = htmlspecialchars(strip_tags($this->user_id));
 //       $this->city_name = htmlspecialchars(strip_tags($this->city_name));
 //       $this->temperature = htmlspecialchars(strip_tags($this->temperature));
 //       
 //       $stmt->bindParam(":user_id", $this->user_id);
//        $stmt->bindParam(":city_name", $this->city_name);
 //       $stmt->bindParam(":temperature", $this->temperature);
//
 //       if ($stmt->execute()) {
 //           return true;
 //       }
 //       return false;
 //   }














//{
//    "user_id": 1,
//   "city_name": "Oujda",
//    "temperature": 29.5
//}

//JSON
//
//{
//    "message": "Consultation ajoutée à l'historique."
//}
?>
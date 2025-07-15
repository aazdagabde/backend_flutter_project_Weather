<?php
// get.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once '../../config/database.php';
include_once '../../core/history.php';

$database = new Database();
$db = $database->getConnection();

$history = new History($db);
if(isset($_GET['user_id'])){
    $history->user_id=$_GET['user_id'];
    $stmt=$history->getByUser();
    $num = $stmt->rowCount();
    if ($num>0){
        $history_arr = array();
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $history_item = array("city_name" => $city_name , "temperature"=> $temperature,
        
        "consultation_date" => $consultation_date
        );
            array_push($history_arr, $history_item);
        }
        http_response_code(200);
     
        echo json_encode($history_arr);
    }else{
        http_response_code(200);
        // On retourne un tableau JSON vide
        echo json_encode(array());
    }
}else {
    http_response_code(400);
    echo json_encode(array("message" => "user_id manquant."));
}

//  function getByUser() {
//        $query = "SELECT city_name, temperature, consultation_date FROM " . $this->table_name . " WHERE user_id = ? ORDER BY consultation_date DESC";
//        $stmt = $this->conn->prepare($query);
 //       $stmt->bindParam(1, $this->user_id);
//        $stmt->execute();
 //       return $stmt;
//    }//
<?php
// get.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//inclure les fichiers necessaire 
include_once '../../config/database.php';
include_once '../../core/favorite.php';
$database = new Database();
$db = $database -> getConnection();
$favorite = new Favorite($db);


//S'assurer que les données ne sont pas vides 
if (isset($_GET['user_id'])){
$favorite->user_id = $_GET["user_id"];
$stmt = $favorite->getByUser();
$num = $stmt->rowCount();

if ($num >0){
    $favorites_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $favorite_item = array("city_name" => $city_name);
        array_push($favorites_arr, $favorite_item);
    }

    http_response_code(200);
    echo json_encode($favorites_arr);
}else {
    http_response_code(200);
    echo json_encode(array());
}

}else {
    http_response_code(400);
    echo json_encode(array("message"=>"user_id manquant"));
}
// function getByUser() {//
 //       $query = "SELECT city_name FROM " . $this->table_name . " WHERE user_id = ?";//
//        $stmt = $this->conn->prepare($query);//
 //       $stmt->bindParam(1, $this->user_id);//
//        $stmt->execute();//
 //       return $stmt;//
 //   }//

//






















?>

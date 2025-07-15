<?php
class User {

private $conn;
private $table_name = "users";

public $id ;
public $username;
public $password;
public function __construct($db){
    $this->conn =$db ;
}

function register(){
    if ($this->usernameExists()){
        return false;
    }

$query = "INSERT INTO " . $this->table_name . " SET username=:username, password=:password";

$stmt = $this->conn->prepare($query);

$this->username = htmlspecialchars(strip_tags($this->username));
$this->password = htmlspecialchars(strip_tags($this->password));

//hacher le password 
$password_hash = password_hash ($this->password, PASSWORD_BCRYPT);

$stmt->bindParam(":username",$this->username);
$stmt->bindParam(":password",$password_hash);
if($stmt->execute()){
    return true ;
}

return false ;



}//register 

function login(){

$query = "SELECT id, username, password FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";
 $stmt = $this->conn->prepare($query);

$this->username = htmlspecialchars(strip_tags($this->username));
$stmt->bindParam(1, $this->username);
$stmt->execute();

//manipulation de rresultat de la requette sql : 

 $num = $stmt->rowCount();

        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $password2 = $row['password'];

            if (password_verify($this->password, $password2)) {
                return true;
            }
        }
        return false;



    }


 private function usernameExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $this->username = htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(1, $this->username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
}

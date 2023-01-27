<?php

class User {

    // db stuff
private $conn;
private $table = 'user';

//
public $id;
public $name;
public $phone;
public $email;
public $password;
public $confirm_password;
public $loggedin_location;	
public $loggedin_time;
public $login_status;



//construct with DB
public function __construct($db){

    $this->conn = $db;
}

// function insert

public function insert($field,$value){

    // insert query
    $query = " UPDATE " . $this->table. " SET " .$field . "  = :field WHERE id = :id";

// prepare the query
$stmt = $this->conn->prepare($query);

// sanitize
$value=htmlspecialchars(strip_tags($value));
// bind the values
$stmt->bindParam(':field', $value);
$stmt->bindParam(':id', $this->id);


if($stmt->execute()){
return true;
}

print($stmt->error);
return false;

}


public function updateLocation($user_id,$location){

    // insert query
$query = " INSERT INTO location SET user_id = :user_id,location = :location";

// prepare the query
$stmt = $this->conn->prepare($query);

// bind the values
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':location', $location);


if($stmt->execute()){
return true;
}

print($stmt->error);
return false;

}
 //function create

public function create(){

        // insert query
        $query = " INSERT INTO " . $this->table. "
        SET
            name = :name,
            email = :email,
            phone = :phone,
            password = :password";

// prepare the query
$stmt = $this->conn->prepare($query);

// sanitize
$this->name=htmlspecialchars(strip_tags($this->name));
$this->email=htmlspecialchars(strip_tags($this->email));
$this->phone=htmlspecialchars(strip_tags($this->phone));
$this->password=htmlspecialchars(strip_tags($this->password));

 // bind the values
 $stmt->bindParam(':name', $this->name);
 $stmt->bindParam(':email', $this->email);
 $stmt->bindParam(':phone', $this->phone);

  // hash the password before saving to database
  $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
  $stmt->bindParam(':password', $password_hash);

  if($stmt->execute()){
    return true;
}

print($stmt->error);
return false;

}


// check if given email exist in the database
public function emailExists(){
 
    // query to check if email exists
    $query = "SELECT id,name,password
            FROM " . $this->table . "
            WHERE email = ?
            LIMIT 0,1";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->email=htmlspecialchars(strip_tags($this->email));
 
    // bind given email value
    $stmt->bindParam(1, $this->email);
 
    // execute the query
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    // if email exists, assign values to object properties for easy access and use for php sessions
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // assign values to object properties
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->password = $row['password'];
 
        // return true because email exists in the database
        return true;
    }
 
    // return false if email does not exist in the database
    return false;
}

// search for id with email

public function getUserId($ref_code){
 
    // query to check if email exists
    $query = "SELECT id
            FROM " . $this->table . "
            WHERE ref_code = ?
            LIMIT 0,1";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($ref_code));
 
    // bind given email value
    $stmt->bindParam(1, $ref_code);
 
    // execute the query
   
   if( $stmt->execute()){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // assign values to object properties
        $this->id = $row['id'];
    return $this->id;
   }
 
    // return false if email does not exist in the database
    return false;
}


public function getUserDetails($id){
 
    // query to check if email exists
    $query = "SELECT *
            FROM " . $this->table . "
            WHERE id = :id";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($id));
 
    // bind given email value
    $stmt->bindParam(":id", $id);
 
    // execute the query
   
   if( $stmt->execute()){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // assign values to object properties
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
       
      
    return true;
   }
 
    // return false if email does not exist in the database
    return false;
}


public function getAllUserDetails(){
 
    // query to check if email exists
    $query = "SELECT *
            FROM " . $this->table . " ";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 

    // execute the query   
   if( $stmt->execute()){
    return $stmt;
   }
    // return false if email does not exist in the database
    return false;
}


public function getUserHistory(){
 
    // query to check if email exists
    $query = " SELECT id,location,datetime FROM location WHERE user_id = :user_id ORDER BY datetime DESC";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    $stmt->bindParam(":user_id", $this->id);
    // execute the query   
   if( $stmt->execute()){
    return $stmt;
   }
    // return false if email does not exist in the database
    return false;
}




public function getLocationCount($location){
 
    // query to check if email exists
    $query = " SELECT COUNT(id) AS LocationCount FROM location WHERE user_id = :user_id AND location = :location";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    $stmt->bindParam(":user_id", $this->id);
    $stmt->bindParam(":location", $location);
    // execute the query   
   if( $stmt->execute()){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // assign values to object properties
    return  $row['LocationCount'];
   }
    // return false if email does not exist in the database
    return false;
}



// update a user record
public function update(){
 
    // if no posted password, do not update the password
    $query = "UPDATE " . $this->table . "
            SET
                name = :name,
                email = :email,
                phone = :phone
            WHERE id = :id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->phone=htmlspecialchars(strip_tags($this->phone));

    // bind the values from the form
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':phone_number', $this->phone_number);
  
    // unique ID of record to be edited
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}



public function updatePassword(){
 
    // if no posted password, do not update the password
    $query = "UPDATE " . $this->table . "
            SET 
                password = :password
            WHERE id = :id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
   
    // hash the password before saving to database

        $this->password=htmlspecialchars(strip_tags($this->password));
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
   
    // unique ID of record to be edited
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

}
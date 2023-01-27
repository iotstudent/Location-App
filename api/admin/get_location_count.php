<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Mehtods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,application/json,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-with');

include_once '../../config/core.php';
require "../../vendor/autoload.php";

// include DB class and Post model
include_once '../../config/Database.php';
include_once '../../models/Staff.php';

//instantiate db
$database = new Database();
$db = $database->connect();

//instantiate new user
$user = new user($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// get jwt
$user->id=$data->id;
$location=$data->location;


// get jwt
// if jwt is not empty
if($user->id && $location){
 
    // if decode succeed, show user details
    try {
        
        $result=$user->getLocationCount($location);

            http_response_code(200);
            // turn to json & output
            echo json_encode(array("Location Count" =>$result));

    }catch (Exception $e){
 
        // set response code
        http_response_code(401);
     
        // show error message
        echo json_encode(array(
            "error" => $e->getMessage()
        ));
    }
} else{
      // set response code
      http_response_code(401);
      // show error message
      echo json_encode(array("message" => "User Id or location not captured"));
}

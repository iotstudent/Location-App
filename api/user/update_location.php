<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Mehtods:PUT');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,application/json,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-with');

include_once '../../config/core.php';
include_once '../../config/map.php';
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// include DB class and Post model
include_once '../../config/Database.php';
include_once '../../models/Staff.php';

//instantiate db
$database = new Database();
$db = $database->connect();


//instantiate new user
$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$latitude= $data->latitude;
$longitude = $data->longitude;


// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";

// if jwt is not empty
if($jwt){
 
    // if decode succeed, show user details
    try {
 
        // decode jw
        $decoded = JWT::decode($jwt,new key ($key,'HS256'));

        // get user if from jwt token
        $user->id = $decoded->data->id;
    
        GetLocation($latitude,$longitude);
        if($httpcode != 200){
            $dataobj = json_decode($response,true);
            echo $dataobj["status"]; 
            die();   
          }else {
            $dataobj = json_decode($response);
            $location=($dataobj->results[0]->formatted_address);
            $user->updateLocation($user->id,$location);
            $user->insert("loggedin_location",$location);
                 //  set response code
                http_response_code(200);
                // json response
                echo json_encode(
                        array(
                            "message" => "Location captured",
                            "location" => $location
                        )
                    );
        }  
    
    
      
    }catch (Exception $e){
 
        // set response code
        http_response_code(401);
     
        // show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
}
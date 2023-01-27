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
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;


// include DB class and Post model
include_once '../../config/Database.php';
include_once '../../models/Admin.php';

//instantiate db
$database = new Database();
$db = $database->connect();

//instantiate new admin
$admin = new admin($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";

// if jwt is not empty
if($jwt){
 
    // if decode succeed, show admin details
    try {
 
        // decode jw
        $decoded = JWT::decode($jwt,new key ($key,'HS256'));

        // set admin property values here
        $admin->id = $decoded->data->id;
        
  
        // update admin with data gotten
        if($admin->getadminDetails($admin->id)){
          
             // set response code
             http_response_code(200);
        
             echo json_encode(
                     array(
                         "message" => "admin Data",
                         "email" => $admin->email,
                     )
                 );
        }
         
        // message if unable to update admin
        else{
            // set response code
            http_response_code(401);
         
            // show error message
            echo json_encode(array("message" => "Unable To Fetch admin Data."));
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
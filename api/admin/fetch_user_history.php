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

// get jwt
// if jwt is not empty
if($user->id){
 
    // if decode succeed, show user details
    try {
        
        $result=$user->getUserHistory();

        $num =$result->rowCount();
        // update user with data gotten
        if($num > 0){
             //user array
            $user_arr['data'] = array();
            // set response code
            http_response_code(200);

            //fetch data as associtive array
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                //extract variable turns the array object value and saves it in a vairable of same name as object
                $user_item = array(
                        "id"   => $id,
                        "location" => $location,
                        "time" => $datetime
                );

                //push data
                array_push($user_arr['data'],$user_item);
            }
            // turn to json & output
           echo json_encode($user_arr['data']);
            
        }else{
            // set response code
            http_response_code(401);
         
            // show error message
            echo json_encode(array("message" => "Unable To Fetch user Data."));
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
} else{
      // set response code
      http_response_code(401);

      // show error message
      echo json_encode(array("message" => "Unable To Fetch Employee Data."));
}

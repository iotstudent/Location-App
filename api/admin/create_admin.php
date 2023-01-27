<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Mehtods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,application/json,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-with');

// include DB class and Post model
include_once '../../config/Database.php';
include_once '../../models/Admin.php';

//instantiate db
$database = new Database();
$db = $database->connect();

//instantiate new admin
$admin = new Admin($db);

//get posted data
$data = json_decode(file_get_contents("php://input"));

$admin->email = $data->email;
$admin->password = $data->password;
$admin->confirm_password = $data->confirm_password;

$emailExist = $admin->emailExists();

if(!$emailExist){
    if($admin->password == $admin->confirm_password){

        // create the admin
        if(!empty($admin->email) && !empty($admin->password) && $admin->create())
        {
            // set response code
            http_response_code(200);
        
            // display message: admin was created
            echo json_encode(array("message" => "Admin created successfully."));
        }
        
        // message if unable to create admin
        else{
        
            // set response code
            http_response_code(400);
        
            // display message: unable to create admin
            echo json_encode(array("message" => "Unable to create admin."));
        }

    } else{
         // set response code
        http_response_code(400);
    
        // display message: unable to create admin
        echo json_encode(array("message" => " Password does not match."));
    }

}else{
     
    // set response code
    http_response_code(400);
 
    // display message: unable to create admin
    echo json_encode(array("message" => " Email already exist."));
}



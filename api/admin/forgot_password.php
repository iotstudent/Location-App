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
include_once '../../config/sm.php';
include_once '../../models/Admin.php';




//instantiate db
$database = new Database();
$db = $database->connect();

//instantiate new admin
$admin = new Admin($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$admin->email = $data->email;
$email_exists = $admin->emailExists();
 

// check if email exists 
if($email_exists){
    
    function randString($length) {
        $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $char = str_shuffle($char);
        for($i = 0, $rand = '', $l = strlen($char) - 1; $i < $length; $i ++) {
            $rand .= $char[mt_rand(0, $l)];
        }
        return $rand;
    }

    $code=randString(5);

    $admin->insert('ref_code',$code);
    sendResetEmail($admin->email,$code);
     // set response code
     http_response_code(200);
 
     // tell the admin mail sent
     echo json_encode(array("message" => " If you have an account with us, a reset code has been sent to it  "));
} else{
 
    // set response code
    http_response_code(401);
 
    // tell the admin account does not exist
    echo json_encode(array("message" => "You do not have an account with us "));
}
 
<?php
// show error reporting
error_reporting(E_ALL);
 
// set your default time-zone
date_default_timezone_set('Africa/Lagos');
 
// variables used for jwt
$key = "68V0zWFrS72GbpPreidkQFLfj4v9m3Ti+DXc8OB0gcM=";
$issued_at = time();
$expiration_time = $issued_at + (60 * 60); // valid for 1 hour
$issuer = "http://localhost/hious/";
?>
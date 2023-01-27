<?php

function GetLocation($latitude,$longitude)
{
    GLOBAL $httpcode;
    GLOBAL $response;
    $ref= mt_rand()* time();

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&key=AIzaSyCwcpufOybAP5GMtgdZdHcMZQYIE5GeNvM',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"latlng":"'.$latitude.'","'.$longitude.'"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));
  
  $response = curl_exec($curl);
  $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  curl_close($curl);
}

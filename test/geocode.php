<?php 

$address = 'zipaquira,PLANTA+KM+4+VIA+ZIPAQUIRA';
$key = 'AIzaSyDsjI18s16qkN9XavLeNZ4ROpVwbQAToLg';
$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$key;
    
    
//// get the json response
//$resp_json = file_get_contents($url);
//
//// decode the json
//$resp = json_decode($resp_json, true);


$ch = curl_init();

  curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
  curl_setopt( $ch, CURLOPT_HEADER, 0 );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt( $ch, CURLOPT_URL, $url );
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

  $data = curl_exec( $ch );
  //$data = json_decode($data);
  curl_close( $ch );
//$data->status
print_r($data);
exit;
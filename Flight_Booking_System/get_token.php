<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://test.api.amadeus.com/v1/security/oauth2/token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'client_id=DzzkQK6dPUGIY8XzHkKRRmutapqKcuHD&client_secret=Nm1sn8NQxsnYq9cq&grant_type=client_credentials',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// sample response 
// {
//     "type": "amadeusOAuth2Token",
//     "username": "prodevroger@gmail.com",
//     "application_name": "Flight1",
//     "client_id": "DzzkQK6dPUGIY8XzHkKRRmutapqKcuHD",
//     "token_type": "Bearer",
//     "access_token": "OrWjAuhRmA3soIg4jLCu1FiVOpbR",
//     "expires_in": 1799,
//     "state": "approved",
//     "scope": ""
// }
$resp_parse = json_decode($response, true);
// echo $resp_parse['access_token'];
// var_dump($resp_parse['access_token']);
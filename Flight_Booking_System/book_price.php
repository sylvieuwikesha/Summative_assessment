<?php
    include 'get_token.php';
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://test.api.amadeus.com/v1/shopping/flight-offers/pricing',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "data": {
        "type": "flight-offers-pricing",
        "flightOffers": [
            '.base64_decode(urldecode($_GET['flightOffer'])).'
        ]
    }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'X-HTTP-Method-Override: GET',
    'Authorization: Bearer '.$resp_parse['access_token']
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

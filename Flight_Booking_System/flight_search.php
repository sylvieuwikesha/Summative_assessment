<?php 

include 'get_token.php';

$curl = curl_init();

curl_setopt_array($curl, array(
    // $api_url = "https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=$departureCityCode&destinationLocationCode=$destinationCityCode&departureDate=$departureDate&returnDate=$returnDate&adults=$adults&max=5";
  CURLOPT_URL => 'https://test.api.amadeus.com/v2/shopping/flight-offers?originLocationCode=SYD&destinationLocationCode=BKK&departureDate=2023-07-27&returnDate=2023-08-01&adults=2&max=10',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer ' . $resp_parse['access_token'],
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;



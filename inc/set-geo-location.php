<?php

use Ipdata\ApiClient\Ipdata;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$httpClient = new Psr18Client();
$psr17Factory = new Psr17Factory();
$ipdata = new Ipdata(
  'ba6aeede5f23ba7bd168b52086f44cb5520fd7ecabfe23db44bd7536',
  $httpClient,
  $psr17Factory
);


// $data = null;
$data = $ipdata->lookup( get__user_IP() );
// $data = $ipdata->lookup( '5.137.170.165' );
// $data = $ipdata->lookup( '178.120.0.0' ); // Беларусь, Брест

if ($data) {
  $GLOBALS["_USER_IP_DATA_"] = $data;
}
else {
  $GLOBALS["_USER_IP_DATA_"] = [
    "region_code" => "MOW",
    "country_code" => "RU",
    // ...
  ];
}


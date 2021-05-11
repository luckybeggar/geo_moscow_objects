<?php

use Application\ApplicationConfig;

require __DIR__ . '/../../init.php';

$config = ApplicationConfig::getConfig();

$client = new \Promopult\Dadata\Client(
    $config['dadata_api_key'],
    $config['dadata_api_secret'],
    new \GuzzleHttp\Client()
);

$address = $client->clean->address('Москва Покровка 1');

echo $address[0]['source'] . "\n";

echo $address[0]['result'] . "\n";

echo $address[0]['geo_lat'] . "\n";

echo $address[0]['geo_lon'] . "\n";

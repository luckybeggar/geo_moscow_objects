<?php


namespace Application\Geocoder;

use Application\ApplicationConfig;
use Exception;
use \Promopult\Dadata\Client;

class Dadata implements GeocoderInterface {
    private Client $client;
    public function __construct() {
        $config = ApplicationConfig::getConfig();
        $this->client = new Client(
            $config['dadata_api_key'],
            $config['dadata_api_secret'],
            new \GuzzleHttp\Client()
        );
    }

    public function geocode(string $rawAddress): ?GeoPoint {
        try {
            $result = $this->client->clean->address($rawAddress);
            sleep(1);
            if ($result[0]) {
                $geoPoint = new GeoPoint();
                $geoPoint->rawAddress = $rawAddress;
                $geoPoint->geocodedAddress = $result[0]['result'];
                $geoPoint->latitude = $result[0]['geo_lat'];
                $geoPoint->longitude = $result[0]['geo_lon'];
                echo $rawAddress . "\n";
                return $geoPoint;
            }
        } catch (Exception $e) {
            echo ($e->getMessage() . "\n");
            return null;
        }
        return null;
    }
}

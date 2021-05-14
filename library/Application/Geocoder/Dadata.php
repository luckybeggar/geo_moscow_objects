<?php


namespace Application\Geocoder;

use Application\ApplicationConfig;
use Application\Cache\CacheInterface;
use Application\Cache\DataKeyValueCache;
use Exception;
use \Promopult\Dadata\Client;

class Dadata implements GeocoderInterface {
    private Client         $client;
    private CacheInterface $cache;

    public function __construct() {
        $config       = ApplicationConfig::getConfig();
        $this->client = new Client(
            $config['dadata_api_key'],
            $config['dadata_api_secret'],
            new \GuzzleHttp\Client()
        );
        $this->cache  = new DataKeyValueCache(DataKeyValueCache::TYPE_DADATA_GEO_CODER);
    }

    public function geocode(string $rawAddress): ?GeoPoint {
        try {

            $result = $this->cache->cache($rawAddress, function () use ($rawAddress) {
                $result = $this->client->clean->address($rawAddress);
                if (isset($result['error'])) {
                    return null;
                }
                return $result;
            });
            usleep(500000);
            if ($result[0]) {
                $geoPoint = new GeoPoint();

                $geoPoint->rawAddress      = $rawAddress;
                $geoPoint->geocodedAddress = $result[0]['result'];
                $geoPoint->latitude        = $result[0]['geo_lat'];
                $geoPoint->longitude       = $result[0]['geo_lon'];

                return $geoPoint;
            }
        } catch (Exception $e) {
            echo($e->getMessage() . "\n");
            return null;
        }
        return null;
    }
}

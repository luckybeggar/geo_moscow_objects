<?php


namespace Application\Geocoder;


interface GeocoderInterface {
    public function geocode(string $rawAddress): ?GeoPoint;
}

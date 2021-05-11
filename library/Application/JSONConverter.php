<?php


namespace Application;


use Application\Geocoder\GeocoderInterface;

class JSONConverter {
    public array   $fileData = [];
    /**
     * @var callable
     */
    private $geocoder;

    public function __construct(string $dataFilename, GeocoderInterface $geocoder) {
        $this->fileData       = json_decode(file_get_contents($dataFilename), true);
        $this->geocoder       = $geocoder;
    }

    public function exportToYandex() {
        $export = [
            0 => ["Широта","Долгота","Описание","Подпись","Номер метки"],
        ];
        foreach ($this->fileData as $record) {
            $geoPoint = $this->geocoder->geocode('Москва ' . $record['address']);
            if ($geoPoint) {
                $export[] = [
                    $geoPoint->latitude,
                    $geoPoint->longitude,
                    $record['name'],
                    $record['name'],
                    $record['number'],
                ];
            }
        }

        return $export;
    }
}

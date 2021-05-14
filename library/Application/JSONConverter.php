<?php


namespace Application;


use Application\Geocoder\GeocoderInterface;

class JSONConverter {
    public array   $fileData = [];
    /**
     * @var callable
     */
    private      $geocoder;
    private ?int $limit;

    public function __construct(string $dataFilename, GeocoderInterface $geocoder, ?int $limit = null) {
        $this->fileData = json_decode(file_get_contents($dataFilename), true);
        $this->geocoder = $geocoder;
        $this->limit = $limit;
    }

    public function exportToYandex() {
        $export = [
            0 => ["Широта","Долгота","Описание","Подпись","Номер метки"],
        ];
        $counter = 0;
        foreach ($this->fileData as $record) {
            $geoPoint = $this->geocoder->geocode($record['address']);
            if ($geoPoint) {
                $export[] = [
                    $geoPoint->latitude,
                    $geoPoint->longitude,
                    $record['name'],
                    $record['name'],
                    $record['number'],
                ];
                $counter++;
                echo $counter . ' ' . $record['address'] . "\n";

            }
            if ($this->limit && $counter >= $this->limit) {
                break;
            }
        }

        return $export;
    }
}

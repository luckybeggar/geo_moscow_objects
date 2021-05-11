<?php

use Application\JSONConverter;
use \Application\Geocoder\Dadata;

require __DIR__ . '/../../init.php';

/** @see http://edu.repetitor-general.ru/rating/ege2020.php */

$jsonFile = __DIR__ . '/../../data_sources/edu.repetitor-general.ru/ege2020.json';
$exportFile = __DIR__ . '/../../export/ege2020_yandex.csv';

$converter  = new JSONConverter($jsonFile, new Dadata());
$exportRows = $converter->exportToYandex();

$out = fopen($exportFile, 'w');

foreach ($exportRows as $exportRow) {
    fputcsv($out, $exportRow, ';', '"');
}

fclose($out);

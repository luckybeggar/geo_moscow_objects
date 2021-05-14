<?php

use Application\JSONConverter;
use Application\Geocoder\Dadata;

require __DIR__ . '/../../init.php';

/** @see http://edu.repetitor-general.ru/rating/oge2018.php */

$jsonFile = __DIR__ . '/../../data_sources/edu.repetitor-general.ru/oge2018.json';
$exportFile = __DIR__ . '/../../export/oge2018_top250_yandex.csv';

$converter  = new JSONConverter($jsonFile, new Dadata(), 250);
$exportRows = $converter->exportToYandex();

$out = fopen($exportFile, 'w');

foreach ($exportRows as $exportRow) {
    fputcsv($out, $exportRow, ';', '"');
}

fclose($out);

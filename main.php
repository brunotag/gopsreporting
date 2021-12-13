<?php
require './nvsprintf.php';
require './month.php';
require './DBAccess/dbAccessModule.php';
require './DataTransform/dataTransformModule.php';
require './GoogleAPI/googleAPIModule.php';

$argc > 2 || die('error:provide month and year.');
$month = $argv[1];
$year = $argv[2];
($year >= 2000 && $year <= 2200) || die('error: year out of range.');
($month >= 1 && $month <= 12) || die('error: month out of range.');

($string = file_get_contents('./config.json')) || die("can't find config file");;
($config = json_decode($string)) || die("can't decode configuration");

$dataModule = new dbAccessModule($config->SQL);
$dataTransformModule = new dataTransformModule($dataModule->getDataService());
$chartRows = $dataTransformModule->getChartRows($month, $year);

$spreadSheetName = nvsprintf($config->spreadSheetName, array(
    'year' => $year,
    'month' => $month,
    'monthName' => (new month($month))->name
));
$googleApiModule = new googleAPIModule($config->Google);
$googleApiModule->createNewSpreadsheet($chartRows, $spreadSheetName);

return;
?>
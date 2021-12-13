<?php
require __DIR__ . '/vendor/autoload.php';
require './Domain/month.php';
require './Domain/depthFirstIterator.php';
require './Domain/exportToChartRowsVisitor.php';
require './Google/googleDriveAPIService.php';
require './Google/googleSheetsAPIService.php';
require './DAL/db.php';
require './DAL/dbObjects/utilisationByCategoryDbObject.php';
require './DAL/dbObjects/totalsDbObject.php';
require './DAL/Services/monthToTimeInterval.php';
require './Domain/treeBuilder.php';
require './DAL/dataService.php';


putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/google_sheet_cred.json');

$argc > 2 || die('error:provide month and year.');
$month = $argv[1];
$year = $argv[2];
($year >= 2000 && $year <= 2200) || die('error: year out of range.');
($month >= 1 && $month <= 12) || die('error: month out of range.');

($string = file_get_contents('./config.json')) || die("can't find config file");;
($json_a = json_decode($string)) || die("can't decode configuration");
$db = new db($json_a->SQL->host,$json_a->SQL->username,$json_a->SQL->gnocchi,$json_a->SQL->db);

$totalsDbObject = new totalsDbObject($db);
$utilisationDbObject = new utilisationByCategoryDbObject($db);
$dataService = new dataService($totalsDbObject,$utilisationDbObject);

$timeIntervalService = new monthToTimeInterval();

$treeBuilder = new treeBuilder($dataService, $timeIntervalService);

$tree = $treeBuilder->getChartTree($month, $year);

$iterator = new depthFirstIterator($tree, 1, true); //minLevel 1 to skip root, resetLevelToZero so offset is 0
$visitor = new exportToChartRowsVisitor();
while($iterator->hasMore())
{
    $visitor->visit($iterator->getNext());
}

$chartRows = $visitor->getChartRows();

($string = file_get_contents('./config.json')) || die("can't find config file");;
($config = json_decode($string)) || die("can't decode configuration");

$googleDriveManager = new googleDriveAPIService($config->Google->applicationName);
$spreadSheet = $googleDriveManager->copyFileFromTemplate(
    $config->Google->templateId,
    sprintf("%d-%'02d - TEST - Monthly Dashboard - %s %d",$year,$month,(new month($month))->name,$year)
);

$googleSheetsService = new googleSheetsAPIService($config->Google->applicationName);
// for($i=0;$i<count($chartRows);$i++){
//     $row = $chartRows[$i];
//     $googleSheetsService->writeRangeInRow($spreadSheet->id, "raw_data", $i, $row->getOffset(), $row->getValues());
// }
$googleSheetsService->writeChartRows($spreadSheet->id, "raw_data", $chartRows);

return;




// $spreadsheet = new Google_Service_Sheets_Spreadsheet([
//     'properties' => [
//         'title' => "Test"
//     ]
// ]);
// $spreadsheet = $service->spreadsheets->create($spreadsheet, [
//     'fields' => 'spreadsheetId'
// ]);
// printf("Spreadsheet ID: %s\n", $spreadsheet->spreadsheetId);
?>
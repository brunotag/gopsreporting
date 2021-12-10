<?php
require __DIR__ . '/vendor/autoload.php';
require 'dataModule.php';
require './Domain/month.php';
require './Google/googleDriveAPIService.php';
require './Google/googleSheetsAPIService.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/google_sheet_cred.json');

$month = $argv[1];
$year = $argv[2];
($year >= 2000 && $year <= 2200) || die('error: year out of range.');
($month >= 1 && $month <= 12) || die('error: month out of range.');

$charts = DataModule::getCharts($month, $year);

($string = file_get_contents('./config.json')) || die("can't find config file");;
($config = json_decode($string)) || die("can't decode configuration");

$googleDriveManager = new googleDriveAPIService($config->Google->applicationName);
$spreadSheet = $googleDriveManager->copyFileFromTemplate(
    $config->Google->templateId,
    sprintf("%d-%'02d - TEST - Monthly Dashboard - %s %d",$year,$month,(new month($month))->name,$year)
);

$googleSheetsService = new googleSheetsAPIService($config->Google->applicationName);
$googleSheetsService->changeMonthAndYear($spreadSheet->id, $month, $year);

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
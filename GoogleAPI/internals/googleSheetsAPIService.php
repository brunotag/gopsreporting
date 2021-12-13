<?php
    require_once './vendor/autoload.php';
    require_once 'googleAPIService.php';

    class googleSheetsAPIService extends googleAPIService{

        public function __construct($applicationName)
        {
            parent::__construct($applicationName);
        }

        function scopesToSet(){
            //Sheet Scopes reference:
            //https://developers.google.com/resources/api-libraries/documentation/sheets/v4/java/latest/com/google/api/services/sheets/v4/SheetsScopes.html
            return Google_Service_Sheets::SPREADSHEETS;
        }

        //"row" is an integer
        //"initialColumn" is a letter
        //"consecutiveValues" is an array of scalar
        public function writeRangeInRow($spreadsheetId, $sheetName, $row, $initialColumn, $consecutiveValues){
            $values = [$consecutiveValues];
            $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
            $params = ['valueInputOption' => "RAW"];
            $range = $this->getRange($row, $initialColumn, count($consecutiveValues), $sheetName);

            $service = new Google_Service_Sheets($this->getClient());
            $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
        }

        public function writeChartRows($spreadsheetId, $sheetName, $chartRows, $rowOffset = 0, $columnOffset = 0){
            $data = array();
            for($i=0;$i<count($chartRows);$i++){
                $values =  [$chartRows[$i]->getValues()];
                $range = $this->getRange(
                    $i+$rowOffset,
                    $columnOffset+$chartRows[$i]->getOffset(), 
                    count($chartRows[$i]->getValues()),
                    $sheetName
                );
                $valueRange = new Google_Service_Sheets_ValueRange([
                    'range' => $range,
                    'values' => $values
                ]);
                array_push($data, $valueRange);
            }
            $body = new Google_Service_Sheets_BatchUpdateValuesRequest([
                'valueInputOption' => "RAW",
                'data' => $data
            ]);
            
            $service = new Google_Service_Sheets($this->getClient());
            $service->spreadsheets_values->batchUpdate($spreadsheetId, $body);
        }

        private function getRange($row, $initialColumn, $size, $sheetName = null){
            return 
                ($sheetName ? $sheetName.'!' : "")
                .$this->getLetterColumn($initialColumn)
                .($row+1)
                .":"
                .$this->getLetterColumn(($initialColumn+$size))
                .($row+1);
        }

        private function getLetterColumn($integerColumn){
            $letter = "A";
            for($i=0;$i<$integerColumn;$i++){
                $letter++;
            }
            return $letter;
        }
    }
?>
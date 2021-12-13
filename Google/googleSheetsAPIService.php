<?php
    require_once './vendor/autoload.php';
    require_once 'googleAPIService.php';

    class googleSheetsAPIService extends googleAPIService{

        public function __construct($applicationName)
        {
            parent::__construct($applicationName);
        }

        //"row" is an integer
        //"initialColumn" is a letter
        //"consecutiveValues" is an array of scalar
        public function writeRangeInRow($spreadsheetId, $sheetName, $row, $initialColumn, $consecutiveValues){
            $client = $this->getClient();
            $service = new Google_Service_Sheets($client);

            $values = [
                $consecutiveValues
            ];
            $body = new Google_Service_Sheets_ValueRange([
                'values' => $values
            ]);
            $params = [
                'valueInputOption' => "RAW"
            ];
            $range = 
                $this->getLetterColumn($initialColumn)
                .$row
                .":"
                .$this->getLetterColumn(($initialColumn+count($consecutiveValues)))
                .$row;
            $service->spreadsheets_values->update($spreadsheetId, "$sheetName!$range", $body, $params);
        }

        private function getLetterColumn($integerColumn){
            $letter = "A";
            for($i=0;$i<$integerColumn;$i++){
                $letter++;
            }
            return $letter;
        }

        function scopesToSet(){
            //Sheet Scopes reference:
            //https://developers.google.com/resources/api-libraries/documentation/sheets/v4/java/latest/com/google/api/services/sheets/v4/SheetsScopes.html
            return Google_Service_Sheets::SPREADSHEETS;
        }
    }
?>
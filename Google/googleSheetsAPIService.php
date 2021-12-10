<?php
    require_once './vendor/autoload.php';
    require_once 'googleAPIService.php';

    class googleSheetsAPIService extends googleAPIService{

        public function __construct($applicationName)
        {
            parent::__construct($applicationName);
        }

        public function changeMonthAndYear($spreadsheetId, $month, $year){
            $client = $this->getClient();
            $service = new Google_Service_Sheets($client);

            $values = [
                [$month],
                [$year]
                // Additional rows ...
            ];
            $body = new Google_Service_Sheets_ValueRange([
                'values' => $values
            ]);
            $params = [
                'valueInputOption' => "RAW"
            ];
            $result = $service->spreadsheets_values->update($spreadsheetId, "raw_data!B1:B2", $body, $params);

        }

        function scopesToSet(){
            //Sheet Scopes reference:
            //https://developers.google.com/resources/api-libraries/documentation/sheets/v4/java/latest/com/google/api/services/sheets/v4/SheetsScopes.html
            return Google_Service_Sheets::SPREADSHEETS;
        }
    }
?>
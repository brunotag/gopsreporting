<?php 
    require_once './GoogleAPI/internals/googleDriveAPIService.php';
    require_once './GoogleAPI/internals/googleSheetsAPIService.php';

    class googleAPIModule{
        private $googleConfig;
        public function __construct($googleConfig)
        {
            putenv('GOOGLE_APPLICATION_CREDENTIALS='.getcwd().'/google_sheet_cred.json');
            $this->googleConfig = $googleConfig;
        }
        public function createNewSpreadsheet($chartRows, $spreadSheetName){
            $googleDriveManager = new googleDriveAPIService($this->googleConfig->applicationName);
            $spreadSheet = $googleDriveManager->copyFileFromTemplate(
                $this->googleConfig->templateId,
                $spreadSheetName,
                $this->googleConfig->destinationFolderId
            );

            $googleSheetsService = new googleSheetsAPIService($this->googleConfig->applicationName);
            $googleSheetsService->writeChartRows($spreadSheet->id, $this->googleConfig->sheetName, $chartRows);
        }
    }
?>
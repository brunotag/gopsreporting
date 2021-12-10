<?php
    require_once './vendor/autoload.php';
    require_once 'googleAPIService.php';

    class googleDriveAPIService extends googleAPIService{

        public function __construct($applicationName)
        {
            parent::__construct($applicationName);
        }

        public function copyFileFromTemplate($sourceFileId, $destinationFileName){
            $client = $this->getClient();
            $service = new Google_Service_Drive($client);
            $file = $service->files->get($sourceFileId);
            $newFile = new Google_Service_Drive_DriveFile();
            $newFile->name = $destinationFileName;
            return $service->files->copy($file->id, $newFile);
        }

        function scopesToSet(){
            //Sheet Scopes reference:
            //https://developers.google.com/resources/api-libraries/documentation/sheets/v4/java/latest/com/google/api/services/sheets/v4/SheetsScopes.html
            return Google_Service_Drive::DRIVE;
        }
    }
?>
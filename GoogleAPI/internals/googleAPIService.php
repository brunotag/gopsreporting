<?php
    abstract class googleAPIService{
        private $applicationName;

        public function __construct($applicationName)
        {
            $this->applicationName = $applicationName;
        }

        protected function getClient()
        {
            $client = new Google_Client();
            $client->setApplicationName($this->applicationName);
            $client->useApplicationDefaultCredentials();
            $client->setScopes($this->scopesToSet());
            return $client;
        }

        //Sheet Scopes reference:
        //https://developers.google.com/resources/api-libraries/documentation/sheets/v4/java/latest/com/google/api/services/sheets/v4/SheetsScopes.html
        abstract function scopesToSet();
    }
?>
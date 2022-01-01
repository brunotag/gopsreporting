<?php
    require_once __DIR__.'/DBAccess/internals/db.php';
    require_once __DIR__.'/DBAccess/internals/dbObjects/totalsDbObject.php';
    require_once __DIR__.'/DBAccess/internals/dbObjects/utilisationByCategoryDbObject.php';
    require_once __DIR__.'/DBAccess/services/dataService.php';

    class dbAccessModule{
        private $sqlConfig;
        public function __construct($SQLConfig)
        {
            $this->sqlConfig = $SQLConfig;
        }
        public function getDataService(){
            $db = new db($this->sqlConfig->host,$this->sqlConfig->username,$this->sqlConfig->password,$this->sqlConfig->db);
            $totalsDbObject = new totalsDbObject($db);
            $utilisationDbObject = new utilisationByCategoryDbObject($db);
            $dataService = new dataService($totalsDbObject,$utilisationDbObject);
            return $dataService;
        }
    }
?>
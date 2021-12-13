<?php
    require_once './DBAccess/model/dataSet.php';

    class dataService{
        private $totalsDbObject;
        private $utilisationDbObject;

        public function __construct($totalsDbObject,$utilisationDbObject){
            $this->totalsDbObject = $totalsDbObject;
            $this->utilisationDbObject = $utilisationDbObject;
            $this->objectsAvailable = false;
        }

        public function getDataByTimeInterval($timeInterval){
            $this->totalsDbObject->hydrateFromDb($timeInterval);
            $this->utilisationDbObject->hydrateFromDb($timeInterval);

            $retval = new dataSet(
                $this->totalsDbObject->flyingDays,
                $this->utilisationDbObject->hours,
                $this->utilisationDbObject->launches
            );
            
            return $retval;
        }
    }
?>
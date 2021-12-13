<?php
    require_once 'dbObject.php';

    class totalsDbObject extends dbObject{
        public $flyingDays;
        public $totalFlights;

        protected function getSql(){
            return <<<'SQL'
            SELECT 
                count(*) as Total_flights, 
                count(distinct localdate) as Flying_days
            FROM gliding.flights
            WHERE localdate >= ? AND localdate < ? AND org = 1;
SQL;
        }

        protected function buildReturnValue($buildReturnValue){
            $this->flyingDays = (int)$buildReturnValue["Flying_days"];
            $this->totalFlights = (int)$buildReturnValue["Total_flights"];
        }

        protected function reset(){
            //NOP
        }
    }
?>
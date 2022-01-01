<?php
    require_once __DIR__.'/DBAccess/model/timeInterval.php';

    class monthToIntervalService{
        public function __construct(){}
        
        public function getMonthTimeInterval($month, $year){
            $startDateInclusive = monthToIntervalService::getStartDateInclusive($month,$year);
            $endDateExclusive = monthToIntervalService::getEndDateExclusive($month,$year);
            return new timeInterval($startDateInclusive, $endDateExclusive);
        }

        public function getYTDTimeInterval($month, $year){
            //YTD begins in JULY (7)
            if ($month<7){
                $startDateInclusive = monthToIntervalService::getStartDateInclusive(7,$year - 1);
            }else{
                $startDateInclusive = monthToIntervalService::getStartDateInclusive(7,$year); 
            }
            $endDateExclusive = monthToIntervalService::getEndDateExclusive($month,$year);
            return new timeInterval($startDateInclusive, $endDateExclusive);
        }

        private static function getStartDateInclusive($month, $year){
            $startDateInclusive = monthToIntervalService::getMyIntegerDate($month,$year);
            return $startDateInclusive;
        }

        private static function getEndDateExclusive($month, $year){
            $month += 1;
            if ($month > 12){
                $month = 1;
                $year += 1;
            }
            $endDateExclusive =  monthToIntervalService::getMyIntegerDate($month,$year);
            return $endDateExclusive;
        }

        private static function getMyIntegerDate($month, $year){
            return 1 + (100 * $month) + (10000 * $year); //format: 20200801
        }
    }
?>
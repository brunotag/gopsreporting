<?php
    require 'timeInterval.php';

    class monthToTimeInterval{
        public function __construct(){}
        
        public function getMonthTimeInterval($month, $year){
            $startDateInclusive = monthToTimeInterval::getStartDateInclusive($month,$year);
            $endDateExclusive = monthToTimeInterval::getEndDateExclusive($month,$year);
            return new timeInterval($startDateInclusive, $endDateExclusive);
        }

        public function getYTDTimeInterval($month, $year){
            //YTD begins in JULY (7)
            if ($month<7){
                $startDateInclusive = monthToTimeInterval::getStartDateInclusive(7,$year - 1);
            }else{
                $startDateInclusive = monthToTimeInterval::getStartDateInclusive(7,$year); 
            }
            $endDateExclusive = monthToTimeInterval::getEndDateExclusive($month,$year);
            return new timeInterval($startDateInclusive, $endDateExclusive);
        }

        private static function getStartDateInclusive($month, $year){
            $startDateInclusive = monthToTimeInterval::getMyIntegerDate($month,$year);
            return $startDateInclusive;
        }

        private static function getEndDateExclusive($month, $year){
            $month += 1;
            if ($month > 12){
                $month = 1;
                $year += 1;
            }
            $endDateExclusive =  monthToTimeInterval::getMyIntegerDate($month,$year);
            return $endDateExclusive;
        }

        private static function getMyIntegerDate($month, $year){
            return 1 + (100 * $month) + (10000 * $year); //format: 20200801
        }
    }
?>
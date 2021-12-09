<?php
    require './Domain/Objects/chartDimension.php';
    require './Domain/Objects/chartSet.php';

    class chartService{
        public $dataService;
        public $monthToTimeIntervalService;

        public function __construct($dataService,$monthToTimeIntervalService){
            $this->dataService = $dataService;
            $this->monthToTimeIntervalService = $monthToTimeIntervalService;
        }

        //returns an array of chartSet
        public function getMonthCharts($month, $year){
            return $this->getFiveYearsOfCharts($month, $year, function ($m,$y){ return $this->monthToTimeIntervalService->getMonthTimeInterval($m,$y);});
        }

        //returns an array of chartSet
        public function getYTDCharts($month, $year){
            return $this->getFiveYearsOfCharts($month, $year, function ($m,$y){ return $this->monthToTimeIntervalService->getYTDTimeInterval($m,$y);});
        }

        private function getFiveYearsOfCharts($month, $year, callable $getTimeInterval){
            $flyingDaysChart = new chartDimension();
            $flyingHoursChart = new chartDimension();
            $launchesChart = new chartDimension();
            
            for ($i = 0; $i <= 5; $i++) {
                $dataSet = $this->dataService->getDataByTimeInterval($getTimeInterval($month, $year-$i));
                $key = ($i == 0 ? "current year" : "current year - ".$i);
                var_dump($dataSet);
                $flyingDaysChart->addPeriod($key, $dataSet->flyingDays);
                $flyingHoursChart->addPeriod($key, $dataSet->hours);
                $launchesChart->addPeriod($key, $dataSet->launches);
            };

            return new chartSet($flyingDaysChart, $flyingHoursChart, $launchesChart);
        }
    }
?>
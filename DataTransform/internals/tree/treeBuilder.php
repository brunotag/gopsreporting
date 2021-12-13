<?php
    require 'node.php';
    require 'keyValue.php';

    class treeBuilder{
        public $dataService;
        public $monthToTimeIntervalService;

        public function __construct($dataService,$monthToTimeIntervalService){
            $this->dataService = $dataService;
            $this->monthToTimeIntervalService = $monthToTimeIntervalService;
        }

        public function getChartTree($month, $year){
            $tree = new Node();
            $tree->addChild(new Node(new keyValue("Month", $month)));
            $tree->addChild(new Node(new keyValue("Year", $year)));
            $tree->addChild(new Node("Month", $this->getMonthCharts($month, $year)));
            $tree->addChild(new Node("YTD", $this->getYTDCharts($month, $year)));
            return $tree;
        }

        //returns an array of nodes
        private function getMonthCharts($month, $year){
            return $this->getFiveYearsOfCharts($month, $year, function ($m,$y){ return $this->monthToTimeIntervalService->getMonthTimeInterval($m,$y);});
        }

        //returns an array of nodes
        private function getYTDCharts($month, $year){
            return $this->getFiveYearsOfCharts($month, $year, function ($m,$y){ return $this->monthToTimeIntervalService->getYTDTimeInterval($m,$y);});
        }

        private function getFiveYearsOfCharts($month, $year, callable $getTimeInterval){
            $flyingDaysChart = new Node("FlyingDays");
            $launchesChart = new Node("Launches");
            $flyingHoursChart = new Node("FlyingHours");
            
            for ($i = 5; $i >= 0; $i--) {
                $dataSet = $this->dataService->getDataByTimeInterval($getTimeInterval($month, $year-$i));
                $key = ($i == 0 ? "current year" : "current year - ".$i);
                $flyingDaysChart->addChild(new Node(new keyValue($key, $dataSet->flyingDays)));
                $launchesChart->addChild(new Node(new keyValue($key, $dataSet->launches)));
                $flyingHoursChart->addChild(new Node(new keyValue($key, $dataSet->hours)));
            };

            return array($flyingDaysChart, $launchesChart, $flyingHoursChart);
        }
    }
?>

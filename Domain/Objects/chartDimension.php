<?php
    class chartDimension{ //example of chart dimensions: launches, flyingHours, lyingDays
        
        //associative array
        //e.g. "current year"  , value1
        //     "current year-1", value2
        //etc...
        public $periods; 

        public function __construct()
        {
            $this->periods = array();
        }

        //key string, value scalar
        public function addPeriod($key, $value){
            $this->periods[$key] = $value;
        }
    }
?>
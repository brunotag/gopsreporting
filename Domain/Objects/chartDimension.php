<?php
    class chartDimension{ //example of chart dimensions: launches, flyingHours, lyingDays
        
        //associative array
        //e.g. "current year"  , value1
        //     "current year-1", value2
        //etc...
        public $rows; 

        public function __construct()
        {
            $this->rows = array();
        }

        //key string, value scalar
        public function addRow($key, $value){
            $this->rows[$key] = $value;
        }
    }
?>
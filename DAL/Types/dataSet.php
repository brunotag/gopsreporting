<?php
    class dataSet{
        public $flyingDays; //scalar
        public $hours;      //byMemberCategory
        public $launches;   //byMemberCategory

        public function __construct($flyingDays, $hours, $launches)
        {
            $this->flyingDays = $flyingDays;
            $this->hours = $hours;
            $this->launches = $launches;
        }
    }
?>